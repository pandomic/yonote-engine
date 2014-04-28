<?php
class HashtagsController extends CApplicationController
{
    private $_hashtagsListModel = null;
    private $_hashtagsListSort;
    
    public function actionIndex()
    {
        $this->pageTitle = Yii::t('PostsModule.hashtags','page.hashtags.title');
        
        $this->addBreadcrumb(
            Yii::t('PostsModule.posts','page.posts.title'),
            $this->createUrl('posts/index')
        )->addBreadcrumb(
            Yii::t('PostsModule.hashtags','page.hashtags.title'),
            $this->createUrl($this->getRoute())
        );
        $models = $this->loadHashtagsListModel();
        $this->render('index',array(
            'models' => $models,
            'sort' => $this->_hashtagsListSort
        ));
    }
    
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