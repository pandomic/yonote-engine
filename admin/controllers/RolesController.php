<?php
/**
 * RolesController class file.
 *
 * @author Vlad Gramuzov <vlad.gramuzov@gmail.com>
 * @link http://yonote.org
 * @copyright 2014 Vlad Gramuzov
 * @license http://yonote.org/license.html
 */

/**
 * Roles manager controller, used in administrative panel.
 * 
 * @author Vlad Gramuzov <vlad.gramuzov@gmail.com>
 * @since 1.0
 */
class RolesController extends CApplicationController
{
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
                'roles' => array('admin.roles.index')
            ),
            array(
                'allow',
                'actions' => array('add'),
                'roles' => array('admin.roles.add')
            ),
            array(
                'allow',
                'actions' => array('edit'),
                'roles' => array('admin.roles.edit')
            ),
            array(
                'allow',
                'actions' => array('remove'),
                'roles' => array('admin.roles.remove')
            ),
            array(
                'deny',
                'users' => array('*')
            )
        );
    }
    /**
     * Remove selected auth items.
     * @return void.
     * @throws CHttpException if request type is not POST.
     */
    public function actionRemove()
    {
        if (Yii::app()->request->isPostRequest)
        {
            $c = 0;
            if (isset($_POST['select']) && is_array($_POST['select']))
            {
                if (count(array_intersect(Yii::app()->authManager->defaultRoles,$_POST['select'])) == 0)
                    $c = AuthItem::model()->deleteByPk($_POST['select']);
            }
            if ($c == 0)
                Yii::app()->user->setFlash('rolesWarning',Yii::t('users','warning.role.remove'));
            else
                Yii::app()->user->setFlash('rolesSuccess',Yii::t('users','success.role.remove'));
            $this->redirect(array('index'));
        }
        else
            throw new CHttpException(400,Yii::t('system','error.400.description'));
    }
    
    /**
     * Display auth items.
     * @return void.
     */
    public function actionIndex()
    {
        $this->pageTitle = Yii::t('users','page.roles.title');
        $this->setPathsQueue(array(
            Yii::t('users','page.roles.title') => Yii::app()->createUrl($this->getRoute())
        ));
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
        $this->render('index',array(
            'sort' => $sort,
            'models' => $models
        ));
    }
    
    /**
     * Add role.
     * @return void.
     */
    public function actionAdd()
    {
        $this->pageTitle = Yii::t('users','page.addrole.title');
        $this->setPathsQueue(array(
            Yii::t('users','page.roles.title') => Yii::app()->createUrl('roles'),
            Yii::t('users','page.addrole.title') => Yii::app()->createUrl($this->getRoute())
        ));
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
    
    /**
     * Edit auth item.
     * @throws CHttpException if auth item not found or invalid request given.
     */
    public function actionEdit($id)
    {
        $this->pageTitle = Yii::t('users','page.editrole.title');
        $this->setPathsQueue(array(
            Yii::t('users','page.roles.title') => Yii::app()->createUrl('roles'),
            Yii::t('users','page.editrole.title') => Yii::app()->createUrl($this->getRoute())
        ));        
        $model = AuthItem::model()->findByPk($id);
        
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
}
?>