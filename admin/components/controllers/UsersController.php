<?php
class UsersController extends CApplicationController
{
    
    private $_usersListModel = null;
    private $_usersListPages;
    private $_usersListSort;
    private $_userEditModel = null;
    
    public function actionSettings()
    {
        $this->pageTitle = Yii::t('users','page.settings.title');
        
        $this->addBreadcrumb(
            Yii::t('users','page.settings.title'),
            $this->createUrl($this->route)
        );
        
        $model = new UsersSettings();
        if (isset($_POST['UsersSettings']))
        {
            $model->setAttributes($_POST['UsersSettings']);
            if ($model->save())
            {
                Yii::app()->user->setFlash(
                    'usersSettingsSuccess',
                    Yii::t('users','success.settings.update')
                );
                $this->refresh();
            }
        }
        $this->render('settings',array(
            'model' => $model
        ));
    }


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
                $this->redirect(array('edit','id' => $_POST['User']['name']));
            }
                
        }
        
        $this->render('editor',array(
            'model' => $model,
            'authTree' => AuthItem::model()->friendlyTree()
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
                Yii::app()->user->setFlash('usersWarning',Yii::t('users','warning.user.remove'));
            else
                Yii::app()->user->setFlash('usersSuccess',Yii::t('users','success.user.remove'));
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
            'authTree' => AuthItem::model()->friendlyTree()
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
}
?>