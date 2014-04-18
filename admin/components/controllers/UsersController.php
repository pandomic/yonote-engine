<?php
class UsersController extends CApplicationController
{
    
    private $_topLevelAuth = null;
    private $_usersListModel = null;
    private $_usersListPages;
    private $_usersListSort;
    private $_userEditModel = null;
    
    public function actionProfile()
    {
        $this->pageTitle = Yii::t('users','page.profile.title');
        
        $this->addBreadcrumb(
            Yii::t('users','page.users.title'),
            Yii::app()->createUrl('users/index')
        )->addBreadcrumb(
            Yii::t('users','page.profile.title'),
            $this->createUrl($this->route)
        );
        
        if (!isset($_GET['id']))
            throw new CHttpException(400,Yii::t('system','error.400.description'));
        $model = Profile::model()->findByPk($_GET['id']);
        if ($model === null)
            throw new CHttpException(404,Yii::t('system','error.404.description'));
        
        if (isset($_POST['Profile']))
        {
            $model->setAttributes($_POST['Profile']);
            if ($model->save())
            {
                Yii::app()->user->setFlash(
                    'usersSuccess',
                    Yii::t('users','success.profile.edit')
                );
                $this->refresh();
            }
        }
        
        $this->render('profile',array(
            'model' => $model,
            'languages' => $model->languages()
        ));
    }

    public function actionEdit()
    {
        $this->pageTitle = Yii::t('users','page.edituser.title');
        
        $this->addBreadcrumb(
            Yii::t('users','page.users.title'),
            Yii::app()->createUrl('users/index')
        )->addBreadcrumb(
            Yii::t('users','page.edituser.title'),
            $this->createUrl($this->route)
        );
        
        $allAuthItems = array();
        $model = $this->loadUserEditModel();
        $model->setScenario('edit');
        $model->setAttributes(array('password' => null));
        
        if (isset($_POST['User']))
        {
            $model->setAttributes($_POST['User']);
            if ($model->save())
            {
                Yii::app()->user->setFlash(
                    'usersSuccess',
                    Yii::t('users','success.user.edit')
                );
                $this->refresh();
            }
                
        }
        
        $this->render('editor',array(
            'model' => $model,
            'tree' => $this->_authTree(
                $this->_modelParents(),
                $allAuthItems
            ),
            'items' => $allAuthItems
        ));
        
    }
    
    public function actionRemove()
    {
        if (Yii::app()->request->isPostRequest)
        {
            $c = 0;
            if (isset($_POST['select']) && is_array($_POST['select']))
                $c = User::model()->deleteByPk($_POST['select']);
            if ($c == 0)
                Yii::app()->user->setFlash('usersWarning','Nothing selected!');
            else
                Yii::app()->user->setFlash('usersSuccess','Selected items was removed.');
            $this->redirect(array('index'));
        }
        else
            throw new CHttpException(400,Yii::t('system','error.400.description'));
    }

    public function actionAdd()
    {
        
        $this->pageTitle = Yii::t('users','page.adduser.title');
        
        $this->addBreadcrumb(
            Yii::t('users','page.users.title'),
            Yii::app()->createUrl('users/index')
        )->addBreadcrumb(
            Yii::t('users','page.adduser.title'),
            $this->createUrl($this->route)
        );
        
        $allAuthItems = array();
        $model = new User('add');
        
        if (isset($_POST['User']))
        {
            $model->setAttributes($_POST['User']);
            if ($model->save())
            {
                Yii::app()->user->setFlash(
                    'usersSuccess',
                    Yii::t('users','success.user.add')
                );
                $this->redirect(array('index'));
            }
        }
            
        $this->render('editor',array(
            'model' => $model,
            'tree' => $this->_authTree(
                $this->_modelParents(),
                $allAuthItems
            ),
            'items' => $allAuthItems
        ));
    }

    public function actionIndex()
    {
        $this->pageTitle = Yii::t('users','page.users.title');
        $this->addBreadcrumb(
            Yii::t('users','page.users.title'),
            Yii::app()->createUrl($this->route)
        );
        $users = $this->loadUsersListModel();
        $this->render('list',array(
            'users' => $users,
            'pages' => $this->_usersListPages,
            'sort' => $this->_usersListSort
        ));
    }
    
    public function loadUserEditModel()
    {
        if ($this->_userEditModel === null)
        {
            if (isset($_GET['id']))
            {
                $this->_userEditModel = User::model()->with('assignments')->findByPk($_GET['id']);
                if ($this->_userEditModel === null)
                    throw new CHttpException(404,Yii::t('system','error.404.description'));
            }
            else
                $this->_userEditModel = new CAttributeCollection(
                    array_fill_keys(array_keys(array_flip(
                        User::model()->getTableSchema()->getColumnNames()
                    )),null)
                );
        }
        return $this->_userEditModel;
    }

    public function loadUsersListModel()
    {
        if ($this->_usersListModel === null)
        {
            $sort = new CSort();
            $sort->sortVar = 'sort';
            $sort->defaultOrder = 'name ASC';
            $sort->multiSort = true;

            $sort->attributes = array(
                'name' => array(
                    'label'=>Yii::t('users','model.user.name'),
                    'asc'=>'name ASC',
                    'desc'=>'name DESC',
                    'default'=>'asc',
                ),
                'email' => array(
                    'label'=>Yii::t('users','model.user.email'),
                    'asc'=>'email ASC',
                    'desc'=>'email DESC',
                    'default'=>'asc',
                ),
                'activated' => array(
                    'label' => Yii::t('users','model.user.activated'),
                    'asc' => 'activated ASC',
                    'desc' => 'activated DESC',
                    'default' => 'asc'
                ),
                'verified' => array(
                    'label' => Yii::t('users','model.user.verified'),
                    'asc' => 'verified ASC',
                    'desc' => 'verified DESC',
                    'default' => 'asc'
                ),
                'subscribed' => array(
                    'label' => Yii::t('users','model.user.subscribed'),
                    'asc' => 'subscribed ASC',
                    'desc' => 'subscribed DESC',
                    'default' => 'asc'
                )
            );

            $criteria = new CDbCriteria();

            if (isset($_POST['search']))
                Yii::app()->session['usersSearch'] = $_POST['search'];
            if (Yii::app()->session['usersSearch'] !== null){
                $criteria->addSearchCondition('name',Yii::app()->session['usersSearch'],true);
                $criteria->addSearchCondition('email',Yii::app()->session['usersSearch'],true,'OR');
            }

            $count = User::model()->count($criteria);
            $pages = new CPagination($count);

            $pages->pageSize = 5;
            $pages->applyLimit($criteria);

            $sort->applyOrder($criteria);
            
            $this->_usersListModel = User::model()->findAll($criteria);
            $this->_usersListPages = $pages;
            $this->_usersListSort = $sort;
        }
        
        return $this->_usersListModel;
        
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