<?php
class rolesController extends CApplicationController
{
    private $_topLevelAuth = null;
    
    public function actionRemove()
    {
        if (Yii::app()->request->isPostRequest)
        {
            $c = 0;
            if (isset($_POST['select']) && is_array($_POST['select']))
                $c = AuthItem::model()->deleteByPk($_POST['select']);
            if ($c == 0)
                Yii::app()->user->setFlash('rolesWarning',Yii::t('users','warning.role.remove'));
            else
                Yii::app()->user->setFlash('rolesSuccess',Yii::t('users','success.role.remove'));
            $this->redirect(array('index'));
        }
        else
            throw new CHttpException(400,Yii::t('system','error.400.description'));
    }

    public function actionIndex()
    {
        $this->pageTitle = Yii::t('users','page.roles.title');
        
        $this->addBreadcrumb(
            Yii::t('users','page.roles.title'),
            Yii::app()->createUrl('roles/index')
        );
        
        $criteria = new CDbCriteria();
        
        $sort = new CSort();
        $sort->sortVar = 'sort';
        $sort->defaultOrder = 'name ASC';
        $sort->multiSort = true;

        $sort->attributes = array(
            'name' => array(
                'label'=>Yii::t('users','model.authitem.name'),
                'asc'=>'name ASC',
                'desc'=>'name DESC',
                'default'=>'asc',
            ),
            'description' => array(
                'label'=>Yii::t('users','model.authitem.description'),
                'asc'=>'description ASC',
                'desc'=>'description DESC',
                'default'=>'asc',
            ),
            'type' => array(
                'label'=>Yii::t('users','model.authitem.type'),
                'asc'=>'type ASC',
                'desc'=>'type DESC',
                'default'=>'asc',
            )
        );
        $sort->applyOrder($criteria);
        $models = AuthItem::model()->findAll($criteria);
        $this->render('list',array(
            'sort' => $sort,
            'models' => $models
        ));
    }
    
    public function actionAdd()
    {
        $model = new AuthItem('add');
        if (isset($_POST['AuthItem']))
        {
            $model->setAttributes($_POST['AuthItem']);
            $model->setAttribute('type',2);
            if ($model->save())
            {
                Yii::app()->user->setFlash(
                    'rolesSuccess',
                    Yii::t('users','success.role.add')
                );
                $this->redirect(array('index'));
            }
        }
        $this->render('editor',array(
            'model' => $model,
            'authTree' => AuthItem::model()->friendlyTree()
        ));
    }
    
    public function actionEdit()
    {
        if (!isset($_GET['id']))
            throw new CHttpException(400,Yii::t('system','error.400.description'));
        
        $model = AuthItem::model()->findByPk($_GET['id']);
        
        if ($model === null)
            throw new CHttpException(404,Yii::t('system','error.404.description'));

        $model->setScenario('edit');
        if (isset($_POST['AuthItem']))
        {
            $model->setAttributes($_POST['AuthItem']);
            if ($model->save())
            {
                Yii::app()->user->setFlash(
                    'rolesSuccess',
                    Yii::t('users','success.role.edit')
                );
                $this->redirect(array('roles/edit','id' => $model->name));
            }
        }
        $this->render('editor',array(
            'model' => $model,
            'authTree' => AuthItem::model()->friendlyTree()
        ));
    }
    
    private function _modelParents()
    {
        if ($this->_topLevelAuth === null)
        {
            $authItems = AuthItem::model()->with('children','parents')->findAll();
            $this->_topLevelAuth = array();

            if (count($authItems) > 0)
                foreach ($authItems as $record)
                    if ($record->type == 2 && count($record->parents) == 0)
                        $this->_topLevelAuth[] = $record;
        }
        return $this->_topLevelAuth;
    }
    
    private function _authTree($parents,&$allAuthItems)
    {
        $tree = array();
        if (count($parents) > 0)
            foreach($parents as $parent)
            {
                $tree[$parent->name] = $parent->description;
                $allAuthItems[$parent->name] = $parent;
                if (count($parent->children) > 0)
                    $tree[] = $this->_authTree($parent->children,$allAuthItems);
                else if (count($parent->children) == 1)
                {
                    $tree[] = $parent->children[0]->description;
                    $allAuthItems[$parent->children[0]->name] = $parent->children[0];
                }
            }
        return $tree;
    }
}
?>