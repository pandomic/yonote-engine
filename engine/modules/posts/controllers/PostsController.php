<?php
class PostsController extends CApplicationController
{

    public function actionIndex()
    {
        $sort = new CSort();
        $sort->sortVar = 'sort';
        $sort->defaultOrder = 'alias ASC';
        $sort->multiSort = true;

        $criteria = new CDbCriteria();
        $criteria->condition = 'language=:language OR language=\'\'';
        $criteria->params = array(
            ':language' => Yii::app()->getLanguage()
        );
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

        $count = $model->count($criteria);
        $pages = new CPagination($count);

        $pages->pageSize = (int) Yii::app()->settings->get('posts','website.posts.page.size');
        $pages->applyLimit($criteria);
        $sort->applyOrder($criteria);
        
        $this->render('index',array(
            'models' => $model->findAll($criteria),
            'pages' => $pages
        ));
    }
    
    public function actionShow($id)
    {
        $model = Post::model()->find(
            'alias=:alias AND (language=:language OR language=\'\')',
            array(
                ':alias' => $id,
                ':language' => Yii::app()->getLanguage()
            )
        );
        if ($model === null)
            throw new CHttpException(404,'Not found');
        $this->render('post',array(
            'model' => $model
        ));
    }
}
?>