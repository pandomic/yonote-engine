<?php
/**
 * UsersController class file.
 *
 * @author Vlad Gramuzov <vlad.gramuzov@gmail.com>
 * @link http://yonote.org
 * @copyright 2014 Vlad Gramuzov
 * @license http://yonote.org/license.html
 */

/**
 * Users manager controller, used in administrative panel.
 * Displays and allows to edit users and their profiles, also as common
 * users settings.
 * 
 * @author Vlad Gramuzov <vlad.gramuzov@gmail.com>
 * @since 1.0
 */
class UsersController extends CApplicationController
{
    
    private $_usersListModel = null;
    private $_usersListPages;
    private $_usersListSort;
    private $_userEditModel = null;
    
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
                'roles' => array('admin.users.index')
            ),
            array(
                'allow',
                'actions' => array('settings'),
                'roles' => array('admin.users.settings')
            ),
            array(
                'allow',
                'actions' => array('profile'),
                'roles' => array('admin.users.profile')
            ),
            array(
                'allow',
                'actions' => array('edit'),
                'roles' => array('admin.users.edit')
            ),
            array(
                'allow',
                'actions' => array('remove'),
                'roles' => array('admin.users.remove')
            ),
            array(
                'allow',
                'actions' => array('add'),
                'roles' => array('admin.users.add')
            ),
            array(
                'deny',
                'users' => array('*')
            )
        );
    }
    
    /**
     * Show and edit users settings.
     * @return void.
     */
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

    /**
     * Edit user profile.
     * @throws CHttpException if profile not found.
     * @return void.
     */
    public function actionProfile($id)
    {
        $this->pageTitle = Yii::t('users','page.profile.title');
        
        $this->addBreadcrumb(
            Yii::t('users','page.users.title'),
            Yii::app()->createUrl('users/index')
        )->addBreadcrumb(
            Yii::t('users','page.profile.title'),
            $this->createUrl($this->route)
        );
        
        $model = Profile::model()->findByPk($id);
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
            'model' => $model
        ));
    }
    
    /**
     * Edit user info.
     * @param string $id user id to edit.
     * @return void.
     */
    public function actionEdit($id)
    {
        $this->pageTitle = Yii::t('users','page.edituser.title');
        
        $this->addBreadcrumb(
            Yii::t('users','page.users.title'),
            Yii::app()->createUrl('users/index')
        )->addBreadcrumb(
            Yii::t('users','page.edituser.title'),
            $this->createUrl($this->route)
        );
        
        $model = $this->loadUserEditModel($id);
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
    
    /**
     * Remove user.
     * @return void.
     * @throws CHttpException if invalid request given.
     */
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
    
    /**
     * Add new user.
     * @return void.
     */
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
    
    /**
     * Display users list.
     * @return void.
     */
    public function actionIndex()
    {
        $this->pageTitle = Yii::t('users','page.users.title');
        $this->addBreadcrumb(
            Yii::t('users','page.users.title'),
            Yii::app()->createUrl($this->route)
        );
        $users = $this->loadUsersListModel();
        $this->render('index',array(
            'users' => $users,
            'pages' => $this->_usersListPages,
            'sort' => $this->_usersListSort
        ));
    }
    
    /**
     * Load user model for edit.
     * @param string $id user id.
     * @return User user model.
     * @throws CHttpException if model not found.
     */
    public function loadUserEditModel($id)
    {
        if ($this->_userEditModel === null)
        {
            $this->_userEditModel = User::model()->with('assignments')->findByPk($id);
            if ($this->_userEditModel === null)
                throw new CHttpException(404,Yii::t('system','error.404.description'));
        }
        return $this->_userEditModel;
    }
    
    /**
     * Load users according to the given request params.
     * @return array of User models.
     */
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

            $pages->pageSize = Yii::app()->settings->get('users','users.page.size');
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