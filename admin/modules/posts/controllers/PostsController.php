<?php
class PostsController extends CApplicationController
{
    
    private $_postsListModel = null;
    private $_postEditModel = null;
    private $_postsListPages;
    private $_postsListSort;
    
    public function actionSettings()
    {
        $this->pageTitle = Yii::t('PostsModule.settings','page.settings.title');
        
        $this->addBreadcrumb(
            Yii::t('PostsModule.settings','page.settings.title'),
            $this->createUrl($this->getRoute())
        );
        
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
    
    public function actionAdd()
    {
        $this->pageTitle = Yii::t('PostsModule.posts','page.add.title');
        
        $this->addBreadcrumb(
            Yii::t('PostsModule.posts','page.posts.title'),
            $this->createUrl('index')
        )->addBreadcrumb(
            Yii::t('PostsModule.posts','page.add.title'),
            $this->createUrl($this->route)
        );
        
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
    
    public function actionEdit()
    {
        $this->pageTitle = Yii::t('PostsModule.posts','page.edit.title');
        
        $this->addBreadcrumb(
            Yii::t('PostsModule.posts','page.posts.title'),
            Yii::app()->createUrl('posts/posts/index')
        )->addBreadcrumb(
            Yii::t('PostsModule.posts','page.edit.title'),
            $this->createUrl($this->route)
        );
        
        $model = $this->loadPostEditModel();
        
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
    
    public function actionIndex()
    {
        $this->pageTitle = Yii::t('PostsModule.posts','page.posts.title');
        $this->addBreadcrumb(
            Yii::t('PostsModule.posts','page.posts.title'),
            Yii::app()->createUrl($this->getRoute())
        );
        $models = $this->loadPostsListModel();
        $this->render('index',array(
            'models' => $models,
            'pages' => $this->_postsListPages,
            'sort' => $this->_postsListSort
        ));
    }
    
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
    
    public function loadPostEditModel()
    {
        if ($this->_postEditModel === null)
        {
            if (isset($_GET['id']))
            {
                $this->_postEditModel = Post::model()->findByPk($_GET['id']);
                if ($this->_postEditModel === null)
                    throw new CHttpException(404,Yii::t('system','error.404.description'));
            }
            else
                throw new CHttpException(400,Yii::t('system','error.400.description'));
        }
        return $this->_postEditModel;
    }
}
?>