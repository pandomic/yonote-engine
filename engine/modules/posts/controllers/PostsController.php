<?php
class PostsController extends CApplicationController
{
    private $_list = null;    
    
    public function actionIndex()
    {
        $list = $this->loadPostListModels();
        $this->render('index',array(
            'models' => $list->models,
            'pages' => $list->pages
        ));
    }
    
    public function loadPostListModels()
    {
        if ($this->_list === null)
        {
            $this->_list = new CAttributeCollection();
            $sort = new CSort();
            
            $sort->sortVar = 'sort';
            $sort->defaultOrder = 'alias ASC';
            $sort->multiSort = true;

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
            {
                $criteria->addSearchCondition('title',$_POST['search'],true,'OR');
                $criteria->addSearchCondition('short',$_POST['search'],true,'OR');
                $criteria->addSearchCondition('full',$_POST['search'],true,'OR');
            }

            $count = $model->count($criteria);
            $pages = new CPagination($count);

            $pages->pageSize = (int) Yii::app()->settings->get('posts','website.posts.page.size');
            $pages->applyLimit($criteria);
            $sort->applyOrder($criteria);
            
            $this->_list->models = $model->findAll($criteria);
            $this->_list->pages = $pages;
        }
        
        return $this->_list;
    }
}
?>