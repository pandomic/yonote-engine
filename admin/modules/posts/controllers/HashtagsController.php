<?php
/**
 * HashtagsController class file.
 *
 * @author Vlad Gramuzov <vlad.gramuzov@gmail.com>
 * @link http://yonote.org
 * @copyright 2014 Vlad Gramuzov
 * @license http://yonote.org/license.html
 */

/**
 * Administrative panel Posts module controller.
 * Provides hashtags management tools.
 * 
 * @author Vlad Gramuzov <vlad.gramuzov@gmail.com>
 * @since 1.0
 */
class HashtagsController extends CApplicationController
{
    private $_hashtagsListModel = null;
    private $_hashtagsListSort;
    
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
                'roles' => array('admin.posts.hashtags.index')
            ),
            array(
                'allow',
                'actions' => array('remove'),
                'roles' => array('admin.posts.hashtags.remove')
            ),
            array(
                'deny',
                'users' => array('*')
            )
        );
    }
    
    /**
     * Show hashtags.
     * @return void.
     */
    public function actionIndex()
    {
        $this->pageTitle = Yii::t('PostsModule.hashtags','page.hashtags.title');
        $this->setPathsQueue(array(
            Yii::t('PostsModule.posts','page.posts.title') => $this->createUrl('posts/index'),
            Yii::t('PostsModule.hashtags','page.hashtags.title') => $this->createUrl($this->getRoute())
        ));
        $models = $this->loadHashtagsListModel();
        $this->render('index',array(
            'models' => $models,
            'sort' => $this->_hashtagsListSort
        ));
    }
    
    /**
     * Remove hashtags.
     * @throws CHttpException if invalid request given.
     * @return void.
     */
    public function actionRemove()
    {
        if (Yii::app()->request->isPostRequest)
        {
            $c = 0;
            if (isset($_POST['select']) && is_array($_POST['select']))
                $c = PostHashtag::model()->deleteByPk($_POST['select']);
            if ($c == 0)
                Yii::app()->user->setFlash('hashtagsWarning',Yii::t('PostsModule.hashtags','warning.hashtag.remove'));
            else
                Yii::app()->user->setFlash('hashtagsSuccess',Yii::t('PostsModule.hashtags','success.hashtag.remove'));
            $this->redirect(array('index'));
        }
        else
            throw new CHttpException(400,Yii::t('system','error.400.description'));
    }
    
    /**
     * Load hashtag models to show.
     * @return array of HashTag models
     */
    public function loadHashtagsListModel()
    {
        if ($this->_hashtagsListModel === null)
        {
            $sort = new CSort();
            $sort->sortVar = 'sort';
            $sort->defaultOrder = 'name ASC';
            $sort->multiSort = true;

            $sort->attributes = array(
                'name' => array(
                    'label' => Yii::t('PostsModule.hashtags','model.hashtag.name'),
                    'asc' => 'name ASC',
                    'desc' => 'name DESC',
                    'default' => 'asc',
                )
            );

            $criteria = new CDbCriteria();
            $model = PostHashtag::model()->with('posts');
                
            if (isset($_POST['search']))
                Yii::app()->session['hashtagsSearch'] = $_POST['search'];
            if (Yii::app()->session['hashtagsSearch'] !== null)
                $criteria->addSearchCondition('name',Yii::app()->session['hashtagsSearch'],true);

            $sort->applyOrder($criteria);
            
            $this->_hashtagsListModel = $model->findAll($criteria);
            $this->_hashtagsListSort = $sort;
        }
        
        return $this->_hashtagsListModel;
    }
}
?>