<?php
/**
 * PostsController class file.
 *
 * @author Vlad Gramuzov <vlad.gramuzov@gmail.com>
 * @link http://yonote.org
 * @copyright 2014 Vlad Gramuzov
 * @license http://yonote.org/license.html
 */

/**
 * Administrative panel Posts module controller.
 * Provides posts management tools.
 * 
 * @author Vlad Gramuzov <vlad.gramuzov@gmail.com>
 * @since 1.0
 */
class PostsController extends CApplicationController
{
    
    private $_postsListModel = null;
    private $_postEditModel = null;
    private $_postsListPages;
    private $_postsListSort;
    
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
                'roles' => array('admin.posts.index')
            ),
            array(
                'allow',
                'actions' => array('settings'),
                'roles' => array('admin.posts.settings')
            ),
            array(
                'allow',
                'actions' => array('add'),
                'roles' => array('admin.posts.add')
            ),
            array(
                'allow',
                'actions' => array('remove'),
                'roles' => array('admin.posts.remove')
            ),
            array(
                'allow',
                'actions' => array('edit'),
                'roles' => array('admin.posts.edit')
            ),
            array(
                'deny',
                'users' => array('*')
            )
        );
    }
    
    /**
     * Show general posts settings.
     * @return void.
     */
    public function actionSettings()
    {
        $this->pageTitle = Yii::t('PostsModule.settings','page.settings.title');
        $this->setPathsQueue(array(
            Yii::t('PostsModule.settings','page.settings.title') => $this->createUrl($this->getRoute())
        ));
        $model = new PostsSettings();
        if (isset($_POST['PostsSettings']))
        {
            $model->setAttributes($_POST['PostsSettings']);
            if ($model->save())
            {
                Yii::app()->user->setFlash(
                    'postsSettingsSuccess',
                    Yii::t('PostsModule.settings','success.settings.update')
                );
                $this->refresh();
            }
        }
        $this->render('settings',array(
            'model' => $model
        ));
    }
    
    /**
     * Add new post.
     * @return void.
     */
    public function actionAdd()
    {
        $this->pageTitle = Yii::t('PostsModule.posts','page.add.title');
        $this->setPathsQueue(array(
            Yii::t('PostsModule.posts','page.posts.title') => $this->createUrl('index'),
            Yii::t('PostsModule.posts','page.add.title') => $this->createUrl($this->getRoute())
        ));
        $model = new Post();
        if (isset($_POST['Post']))
        {
            $model->setAttributes($_POST['Post']);
            if ($model->save())
            {
                Yii::app()->user->setFlash(
                    'postsSuccess',
                    Yii::t('PostsModule.posts','success.post.add')
                );
                $this->redirect(array('index'));
            }
        }
        $this->render('editor',array(
            'model' => $model
        ));
    }
    
    /**
     * Edit post.
     * @return void.
     */
    public function actionEdit($id)
    {
        $this->pageTitle = Yii::t('PostsModule.posts','page.edit.title');
        $this->setPathsQueue(array(
            Yii::t('PostsModule.posts','page.posts.title') => Yii::app()->createUrl('posts/posts/index'),
            Yii::t('PostsModule.posts','page.edit.title') => $this->createUrl($this->getRoute())
        ));
        $model = $this->loadPostEditModel($id);
        if (isset($_POST['Post']))
        {
            $model->setAttributes($_POST['Post']);
            if ($model->save())
            {
                Yii::app()->user->setFlash(
                    'postsSuccess',
                    Yii::t('PostsModule.posts','success.post.edit')
                );
                $this->redirect(array('edit','id' => $_POST['Post']['alias']));
            }
                
        }
        
        $this->render('editor',array(
            'model' => $model
        ));
        
    }
    
    /**
     * Remove post.
     * @throws CHttpException if invalid request given.
     * @return void.
     */
    public function actionRemove()
    {
        if (Yii::app()->request->isPostRequest)
        {
            $c = 0;
            if (isset($_POST['select']) && is_array($_POST['select']))
                $c = Post::model()->deleteByPk($_POST['select']);
            if ($c == 0)
                Yii::app()->user->setFlash('postsWarning',Yii::t('PostsModule.posts','warning.post.remove'));
            else
                Yii::app()->user->setFlash('postsSuccess',Yii::t('PostsModule.posts','success.post.remove'));
            $this->redirect(array('index'));
        }
        else
            throw new CHttpException(400,Yii::t('system','error.400.description'));
    }
    
    /**
     * Show posts list.
     * @return void.
     */
    public function actionIndex()
    {
        $this->pageTitle = Yii::t('PostsModule.posts','page.posts.title');
        $this->setPathsQueue(array(
            Yii::t('PostsModule.posts','page.posts.title') => $this->createUrl($this->getRoute())
        ));
        $models = $this->loadPostsListModel();
        $this->render('index',array(
            'models' => $models,
            'pages' => $this->_postsListPages,
            'sort' => $this->_postsListSort
        ));
    }
    
    /**
     * Load Post models to show.
     * @return array of Post models.
     */
    public function loadPostsListModel()
    {
        if ($this->_postsListModel === null)
        {
            $sort = new CSort();
            $sort->sortVar = 'sort';
            $sort->defaultOrder = 'alias ASC';
            $sort->multiSort = true;

            $sort->attributes = array(
                'alias' => array(
                    'label'=>Yii::t('PostsModule.posts','model.post.alias'),
                    'asc'=>'alias ASC',
                    'desc'=>'alias DESC',
                    'default'=>'asc',
                ),
                'title' => array(
                    'label'=>Yii::t('PostsModule.posts','model.post.title'),
                    'asc'=>'title ASC',
                    'desc'=>'title DESC',
                    'default'=>'asc',
                ),
                'language' => array(
                    'label' => Yii::t('PostsModule.posts','model.post.language'),
                    'asc' => 'updatetime ASC',
                    'desc' => 'updatetime DESC',
                    'default' => 'asc'
                )
            );

            $criteria = new CDbCriteria();
            $model = Post::model();
            
            if (isset($_GET['hashtag']))
            {
                $criteria->together = true;
                $criteria->with = array(
                    'relations' => array(
                        'select' => false,
                        'joinType' => 'INNER JOIN',
                        'condition' => 'relations.hashtagid=:hashtagid',
                        'params' => array(':hashtagid' => $_GET['hashtag'])
                    )
                );
                
            }
                
            if (isset($_POST['search']))
                Yii::app()->session['postsSearch'] = $_POST['search'];
            if (Yii::app()->session['postsSearch'] !== null){
                $criteria->addSearchCondition('alias',Yii::app()->session['postsSearch'],true);
                $criteria->addSearchCondition('title',Yii::app()->session['postsSearch'],true,'OR');
            }

            $count = $model->count($criteria);
            $pages = new CPagination($count);

            $pages->pageSize = (int) Yii::app()->settings->get('posts','admin.posts.page.size');
            $pages->applyLimit($criteria);
            $sort->applyOrder($criteria);
            
            $this->_postsListModel = $model->findAll($criteria);
            $this->_postsListPages = $pages;
            $this->_postsListSort = $sort;
        }
        
        return $this->_postsListModel;
    }
    
    /**
     * Load Post model for editing.
     * @return Post model.
     */
    public function loadPostEditModel($id)
    {
        if ($this->_postEditModel === null)
        {
            $this->_postEditModel = Post::model()->findByPk($id);
            if ($this->_postEditModel === null)
                throw new CHttpException(404,Yii::t('system','error.404.description'));
        }
        return $this->_postEditModel;
    }
}
?>