<?php
/**
 * PagesController class file.
 *
 * @author Vlad Gramuzov <vlad.gramuzov@gmail.com>
 * @link http://yonote.org
 * @copyright 2014 Vlad Gramuzov
 * @license http://yonote.org/license.html
 */

/**
 * Administrative panel Pages module controller.
 * Provides pages management tools.
 * 
 * @author Vlad Gramuzov <vlad.gramuzov@gmail.com>
 * @since 1.0
 */
class PagesController extends CApplicationController
{
    
    private $_pagesListModel = null;
    private $_pageEditModel = null;
    private $_pagesListPages;
    private $_pagesListSort;
    
    /**
     * Controller filters.
     * @return array filters.
     */
    public function filters()
    {
        return array(
            'accessControl'
        );
    }
    
    /**
     * Controller access rules.
     * @return array access rules.
     */
    public function accessRules()
    {
        return array(
            array(
                'allow',
                'actions' => array('index'),
                'roles' => array('admin.pages.index')
            ),
            array(
                'allow',
                'actions' => array('settings'),
                'roles' => array('admin.pages.settings')
            ),
            array(
                'allow',
                'actions' => array('edit'),
                'roles' => array('admin.pages.edit')
            ),
            array(
                'allow',
                'actions' => array('add'),
                'roles' => array('admin.pages.add')
            ),
            array(
                'allow',
                'actions' => array('remove'),
                'roles' => array('admin.pages.remove')
            ),
            array(
                'deny',
                'users' => array('*')
            )
        );
    }
    
    /**
     * Show general pages settings.
     * @return void.
     */
    public function actionSettings()
    {
        $this->pageTitle = Yii::t('PagesModule.settings','page.settings.title');
        $this->setPathsQueue(array(
            Yii::t('PagesModule.settings','page.settings.title') => $this->createUrl($this->getRoute())
        ));
        $model = new PagesSettings();
        if (isset($_POST['PagesSettings']))
        {
            $model->setAttributes($_POST['PagesSettings']);
            if ($model->save())
            {
                Yii::app()->user->setFlash(
                    'pagesSettingsSuccess',
                    Yii::t('PagesModule.settings','success.settings.update')
                );
                $this->refresh();
            }
        }
        $this->render('settings',array(
            'model' => $model
        ));
    }
    
    /**
     * Edit page.
     * @return void.
     */
    public function actionEdit($id)
    {
        $this->pageTitle = Yii::t('PagesModule.pages','page.edit.title');
        $this->setPathsQueue(array(
            Yii::t('PagesModule.pages','page.pages.title') => Yii::app()->createUrl('pages/pages/index'),
            Yii::t('PagesModule.pages','page.edit.title') => $this->createUrl($this->getRoute())
        ));
        $model = $this->loadPageEditModel($id);
        if (isset($_POST['Page']))
        {
            $model->setAttributes($_POST['Page']);
            if ($model->save())
            {
                Yii::app()->user->setFlash(
                    'pagesSuccess',
                    Yii::t('PagesModule.pages','success.page.edit')
                );
                $this->redirect(array('edit','id' => $_POST['Page']['alias']));
            }
                
        }
        
        $this->render('editor',array(
            'model' => $model
        ));
        
    }
    
    /**
     * Add a new page.
     * @return void.
     */
    public function actionAdd()
    {
        $this->pageTitle = Yii::t('PagesModule.pages','page.add.title');
        $this->setPathsQueue(array(
            Yii::t('PagesModule.pages','page.pages.title') => $this->createUrl('index'),
            Yii::t('PagesModule.pages','page.edit.title') => $this->createUrl($this->getRoute())
        ));
        $model = new Page();
        if (isset($_POST['Page']))
        {
            $model->setAttributes($_POST['Page']);
            if ($model->save())
            {
                Yii::app()->user->setFlash(
                    'pagesSuccess',
                    Yii::t('PagesModule.pages','success.page.add')
                );
                $this->redirect(array('index'));
            }
        }
        
        $this->render('editor',array(
            'model' => $model,
            'languages' => $model->getLanguages()
        ));
    }
    
    /**
     * Remove page.
     * @throws CHttpException if invalid request given.
     */
    public function actionRemove()
    {
        if (Yii::app()->request->isPostRequest)
        {
            $c = 0;
            if (isset($_POST['select']) && is_array($_POST['select']))
                $c = Page::model()->deleteByPk($_POST['select']);
            if ($c == 0)
                Yii::app()->user->setFlash('pagesWarning',Yii::t('PagesModule.pages','warning.page.remove'));
            else
                Yii::app()->user->setFlash('pagesSuccess',Yii::t('PagesModule.pages','success.page.remove'));
            $this->redirect(array('index'));
        }
        else
            throw new CHttpException(400,Yii::t('system','error.400.description'));
    }
    
    /**
     * Show pages list.
     * @return void.
     */
    public function actionIndex()
    {
        $this->pageTitle = Yii::t('PagesModule.pages','page.pages.title');
        $this->setPathsQueue(array(
            Yii::t('PagesModule.pages','page.pages.title') => $this->createUrl($this->getRoute())
        ));        
        $models = $this->loadPagesListModel();
        $this->render('index',array(
            'models' => $models,
            'pages' => $this->_pagesListPages,
            'sort' => $this->_pagesListSort
        ));
    }
    
    /**
     * Load pages models for list show according to the given params.
     * @return array of Page models.
     */
    public function loadPagesListModel()
    {
        if ($this->_pagesListModel === null)
        {
            $sort = new CSort();
            $sort->sortVar = 'sort';
            $sort->defaultOrder = 'alias ASC';
            $sort->multiSort = true;

            $sort->attributes = array(
                'alias' => array(
                    'label'=>Yii::t('PagesModule.pages','model.page.alias'),
                    'asc'=>'alias ASC',
                    'desc'=>'alias DESC',
                    'default'=>'asc',
                ),
                'title' => array(
                    'label'=>Yii::t('PagesModule.pages','model.page.title'),
                    'asc'=>'title ASC',
                    'desc'=>'title DESC',
                    'default'=>'asc',
                ),
                'language' => array(
                    'label' => Yii::t('PagesModule.pages','model.page.language'),
                    'asc' => 'language ASC',
                    'desc' => 'language DESC',
                    'default' => 'asc'
                )
            );

            $criteria = new CDbCriteria();

            if (isset($_POST['search']))
                Yii::app()->session['pagesSearch'] = $_POST['search'];
            if (Yii::app()->session['pagesSearch'] !== null){
                $criteria->addSearchCondition('alias',Yii::app()->session['pagesSearch'],true);
                $criteria->addSearchCondition('title',Yii::app()->session['pagesSearch'],true,'OR');
            }

            $count = Page::model()->count($criteria);
            $pages = new CPagination($count);

            $pages->pageSize = (int) Yii::app()->settings->get('pages','admin.pages.page.size');
            $pages->applyLimit($criteria);

            $sort->applyOrder($criteria);
            
            $this->_pagesListModel = Page::model()->findAll($criteria);
            $this->_pagesListPages = $pages;
            $this->_pagesListSort = $sort;
        }
        
        return $this->_pagesListModel;
        
    }
    
    /**
     * Get Page model for editing.
     * @return Page model.
     */
    public function loadPageEditModel($id)
    {
        if ($this->_pageEditModel === null)
        {
            $this->_pageEditModel = Page::model()->findByPk($_GET['id']);
            if ($this->_pageEditModel === null)
                throw new CHttpException(404,Yii::t('system','error.404.description'));
        }
        return $this->_pageEditModel;
    }
}
?>