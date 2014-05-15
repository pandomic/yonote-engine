<?php
/**
 * Users manager file.
 * Users list template.
 *
 * @author Vlad Gramuzov <vlad.gramuzov@gmail.com>
 * @link http://yonote.org
 * @copyright 2014 Vlad Gramuzov
 * @license http://yonote.org/license.html
 */
?>

<?php if (Yii::app()->user->hasFlash('usersSuccess')): ?>
    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <?php echo Yii::app()->user->getFlash('usersSuccess'); ?>
            </div>
        </div>
    </div>
<?php endif; ?>

<?php if (Yii::app()->user->hasFlash('usersWarning')): ?>
    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-warning">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <?php echo Yii::app()->user->getFlash('usersWarning'); ?>
            </div>
        </div>
    </div>
<?php endif; ?>

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading table-middle clearfix">
                <a class="btn btn-primary btn-xs pull-right" href="<?php echo $this->createUrl('add'); ?>"><span class="glyphicon glyphicon-plus"></span> <?php echo Yii::t('users','button.user.add'); ?></a>
                <h3 class="panel-title"><?php echo Yii::t('users','page.users.title'); ?></h3> <span class="label label-primary"><?php echo count($users); ?></span>
            </div>
            <div class="panel-body"> 
                <?php echo CHtml::form('','POST',array(
                    'role' => 'form',
                    'class' => 'form-inline'
                )); ?>
                    <div class="input-group">
                        <label class="sr-only" for="searchInput">Email address</label>
                        <input type="text" class="form-control" name="search" value="<?php echo Yii::app()->session['usersSearch']; ?>" id="searchInput" placeholder="<?php echo Yii::t('users','placeholder.users.search'); ?>">
                        <span class="input-group-btn">
                            <button class="btn btn-default" type="submit"><?php echo Yii::t('system','app.search'); ?></button>
                        </span>
                    </div>
                <?php echo CHtml::endForm(); ?>
            </div>
            <?php if (count($users) > 0): ?>

                <?php echo CHtml::form(array('remove'),'POST',array(
                    'role' => 'form',
                    'id' => 'usersForm'
                )); ?>

                    <table class="table table-hover table-striped table-middle  table-responsive table-separated">
                        <thead>
                            <tr>
                                <th><?php echo $sort->link('name'); ?></th>
                                <th><?php echo $sort->link('email'); ?></th>
                                <th><?php echo $sort->link('activated'); ?></th>
                                <th><?php echo $sort->link('verified'); ?></th>
                                <th><?php echo $sort->link('subscribed'); ?></th>
                                <th><?php echo Yii::t('users','label.profile'); ?></th>
                                <th>
                                    <div class="btn-group" data-toggle="buttons">
                                        <label class="btn btn-default ">
                                            <input type="checkbox" onchange="$(this).autoCheck();"> <?php echo Yii::t('system','app.select'); ?>
                                        </label>
                                    </div>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($users as $user): ?>
                                <tr>
                                    <td>
                                        <a href="<?php echo $this->createUrl('edit',array('id' => $user->name)); ?>">
                                            <?php echo $user->name; ?>
                                        </a>
                                    </td>
                                    <td>
                                        <?php echo $user->email; ?>
                                    </td>
                                    <td>
                                        <?php if ((bool) $user->activated): ?>
                                            <span class="label label-success"><?php echo Yii::t('users','label.activated'); ?></span>
                                        <?php else: ?>
                                            <span class="label label-danger"><?php echo Yii::t('users','label.unactivated'); ?></span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if ((bool) $user->verified): ?>
                                            <span class="label label-success"><?php echo Yii::t('users','label.verified'); ?></span>
                                        <?php else: ?>
                                            <span class="label label-danger"><?php echo Yii::t('users','label.unverified'); ?></span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if ((bool) $user->subscribed): ?>
                                            <span class="label label-success"><?php echo Yii::t('users','label.subscribed'); ?></span>
                                        <?php else: ?>
                                            <span class="label label-primary"><?php echo Yii::t('users','label.unsubscribed'); ?></span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <a href="<?php echo $this->createUrl('profile',array('id' => $user->name)); ?>"><?php echo Yii::t('system','app.edit'); ?></a>
                                    </td>
                                    <td>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" name="select[]" value="<?php echo $user->name; ?>"> <?php echo Yii::t('system','app.select'); ?>
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <div class="panel-footer">
                        <div class="clearfix">
                            <div class="pull-left">
                                <button type="button" class="btn btn-danger" onclick="$(this).confirmModal();" data-action="$('#usersForm').submit();"><?php echo Yii::t('users','button.users.remove'); ?></button>
                            </div>

                            <div class="pull-right">
                                <?php $this->widget('CLinkPager',array(
                                    'pages' => $pages,
                                    'firstPageLabel' => '',
                                    'firstPageCssClass' => 'hidden',
                                    'lastPageCssClass' => 'hidden',
                                    'hiddenPageCssClass' => 'disabled',
                                    'cssFile' => false,
                                    'prevPageLabel' => '&laquo;',
                                    'nextPageLabel' => '&raquo;',
                                    'internalPageCssClass' => false,
                                    'nextPageCssClass' => false,
                                    'previousPageCssClass' => false,
                                    'header' => '',
                                    'selectedPageCssClass' => 'active',
                                    'htmlOptions' => array(
                                        'class' => 'pagination text-center'
                                    )
                                )); ?>
                            </div>
                        </div>
                    </div>
                <?php echo CHtml::endForm(); ?>
                
            <?php else: ?>
                <div class="panel-body">
                    <div class="alert alert-warning">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <?php echo Yii::t('users','warning.users.empty'); ?>
                    </div>
                </div>
            <?php endif; ?>
                
           
        </div>
    </div>
</div>