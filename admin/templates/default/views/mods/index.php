<?php
/**
 * Modules manager template file.
 * Index template.
 *
 * @author Vlad Gramuzov <vlad.gramuzov@gmail.com>
 * @link http://yonote.org
 * @copyright 2014 Vlad Gramuzov
 * @license http://yonote.org/license.html
 */
?>
<?php if (Yii::app()->user->hasFlash('modulesSuccess')): ?>
    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <?php echo Yii::app()->user->getFlash('modulesSuccess'); ?>
            </div>
        </div>
    </div>
<?php endif; ?>
<?php if (Yii::app()->user->hasFlash('modulesWarning')): ?>
    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-warning">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <?php echo Yii::app()->user->getFlash('modulesWarning'); ?>
            </div>
        </div>
    </div>
<?php endif; ?>
<div class="row">
    <div class="col-md-2">
       <div class="list-group">
          <a href="<?php echo $this->createUrl('index'); ?>" class="list-group-item active"><?php echo Yii::t('modules','page.modules.title'); ?></a>
          <a href="<?php echo $this->createUrl('add'); ?>" class="list-group-item"><?php echo Yii::t('modules','page.add.title'); ?></a>
      </div>
    </div>
    <div class="col-md-10">
        <div class="panel panel-default">
            <div class="panel-heading clearfix">
                <a href="<?php echo $this->createUrl('add'); ?>" class="btn btn-primary btn-xs pull-right"><span class="glyphicon glyphicon-plus"></span> <?php echo Yii::t('modules','button.module.add'); ?></a>
                <h3 class="panel-title"><?php echo Yii::t('modules','label.modules.list'); ?></h3> <span class="label label-primary"><?php echo count($models); ?></span>
            </div>
            <div class="panel-body">
                <?php echo CHtml::form('','POST',array(
                    'role' => 'form',
                    'class' => 'form-inline'
                )); ?>
                    <div class="input-group">
                        <label class="sr-only" for="searchInput"><?php echo Yii::t('system','app.search'); ?></label>
                        <input type="text" class="form-control" name="search" value="<?php echo Yii::app()->session['modulesSearch']; ?>" id="searchInput" placeholder="<?php echo Yii::t('modules','placeholder.modules.search'); ?>">
                        <span class="input-group-btn">
                            <button class="btn btn-default" type="submit"><?php echo Yii::t('system','app.search'); ?></button>
                        </span>
                    </div>
                <?php echo CHtml::endForm(); ?>
            </div>
                <?php if (count($models) > 0): ?>
                    <table class="table table-striped table-hover table-middle table-responsive table-separated">
                        <thead>
                            <tr>
                                <th><?php echo Yii::t('modules','model.module.name'); ?></th>
                                <th><?php echo Yii::t('modules','model.module.title'); ?></th>
                                <th><?php echo Yii::t('modules','model.module.status'); ?></th>
                                <th><?php echo Yii::t('modules','model.module.position'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($models as $model): ?>
                                <tr>
                                    <td>
                                        <div class="dropdown">
                                            <a id="dLabel" role="button" data-toggle="dropdown" data-target="#" href="/page.html">
                                              <?php echo $model->name; ?> <span class="caret"></span>
                                            </a>
                                            <ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
                                                <li role="presentation"><a role="menuitem" tabindex="-1" href="<?php echo $this->createUrl("/{$model->name}"); ?>"><?php echo Yii::t('modules','label.module.goto'); ?></a></li>
                                                <li role="presentation"><a role="menuitem" tabindex="-1" href="<?php echo $this->createUrl('info',array('id' => $model->name)); ?>"><?php echo Yii::t('modules','label.module.info.view'); ?></a></li>
                                                <li role="presentation" class="divider"></li>
                                                <li role="presentation"><a role="menuitem" tabindex="-1" href="<?php echo $this->createUrl('status',array('id' => $model->name)); ?>"><?php echo Yii::t('modules','label.module.status.toggle'); ?></a></li>
                                                <li role="presentation" class="text-danger"><a role="menuitem" tabindex="-1" href="#" onclick="$(this).confirmModal();" data-action="window.location.href='<?php echo $this->createUrl('remove',array('id' => $model->name)); ?>';" ><?php echo Yii::t('modules','button.module.remove'); ?></a></li>
                                            </ul>
                                        </div>
                                    </td>
                                    <td>
                                        <?php echo $model->title; ?>
                                    </td>
                                    <td>
                                        <?php if ((bool) $model->installed): ?>
                                            <span class="label label-success"><?php echo Yii::t('modules','label.enabled'); ?></span>
                                        <?php else: ?>
                                            <span class="label label-danger"><?php echo Yii::t('modules','label.disabled'); ?></span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <a href="<?php echo $this->createUrl('up',array('id' => $model->name)); ?>"><span class="glyphicon glyphicon-circle-arrow-up"></span></a>
                                        <a href="<?php echo $this->createUrl('down',array('id' => $model->name)); ?>"><span class="glyphicon glyphicon-circle-arrow-down"></span></a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <div class="panel-body">
                        <div class="alert alert-warning">
                            <?php echo Yii::t('modules','warning.modules.empty'); ?>
                        </div>
                    </div>
                <?php endif; ?>
        </div>
    </div>
</div>