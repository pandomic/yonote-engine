<?php
class PagesController extends CApplicationController
{
    
    private $_pagesListModel = null;
    private $_pageEditModel = null;
    private $_pagesListPages;
    private $_pagesListSort;
    
    public function actionEdit()
    {
        $this->pageTitle = Yii::t('PagesModule.pages','page.edit.title');
        
        $this->addBreadcrumb(
            Yii::t('PagesModule.pages','page.pages.title'),
            Yii::app()->createUrl('pages/pages/index')
        )->addBreadcrumb(
            Yii::t('PagesModule.pages','page.edit.title'),
            $this->createUrl($this->route)
        );
        
        $model = $this->loadPageEditModel();
        
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
    
    public function actionAdd()
    {
        $this->pageTitle = Yii::t('PagesModule.pages','page.add.title');
        
        $this->addBreadcrumb(
            Yii::t('PagesModule.pages','page.pages.title'),
            $this->createUrl('index')
        )->addBreadcrumb(
            Yii::t('PagesModule.pages','page.add.title'),
            $this->createUrl($this->route)
        );
        
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

    public function actionIndex()
    {
        $this->pageTitle = Yii::t('PagesModule.pages','page.pages.title');
        
        $this->addBreadcrumb(
            Yii::t('PagesModule.pages','page.pages.title'),
            $this->createUrl($this->route)
        );
        
        $models = $this->loadPagesListModel();
        
        $this->render('index',array(
            'models' => $models,
            'pages' => $this->_pagesListPages,
            'sort' => $this->_pagesListSort
        ));
    }
    
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
    
    public function loadPageEditModel()
    {
        if ($this->_pageEditModel === null)
        {
            if (isset($_GET['id']))
            {
                $this->_pageEditModel = Page::model()->findByPk($_GET['id']);
                if ($this->_pageEditModel === null)
                    throw new CHttpException(404,Yii::t('system','error.404.description'));
            }
            else
                throw new CHttpException(400,Yii::t('system','error.400.description'));
        }
        return $this->_pageEditModel;
    }
}
?>