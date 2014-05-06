<?php
/**
 * Modules manager template file.
 * Module info template.
 * 
 * $this - current controller.
 * $model - Module model.
 *
 * @author Vlad Gramuzov <vlad.gramuzov@gmail.com>
 * @link http://yonote.org
 * @copyright 2014 Vlad Gramuzov
 * @license http://yonote.org/license.html
 */
?>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading clearfix">
                <a class="pull-right" href="<?php echo Yii::app()->createUrl('modules'); ?>"><span class="glyphicon glyphicon-arrow-left"></span> <?php echo Yii::t('system','app.back'); ?></a>
                <h3 class="panel-title"><?php echo Yii::t('modules','label.module.info',array('{module}' => ucfirst($model->name))); ?></h3>
            </div>
            <div class="panel-body"> 
                <p>
                    <dl class="dl-horizontal">
                        <dt><?php echo Yii::t('modules','model.module.updatetime'); ?>:</dt>
                        <dd><?php echo Yii::app()->dateFormatter->formatDateTime($model->updatetime); ?></dd>
                        <dt><?php echo Yii::t('modules','model.module.name'); ?>:</dt>
                        <dd><?php echo $model->name; ?></dd>
                        <dt><?php echo Yii::t('modules','model.module.version'); ?>:</dt>
                        <dd><?php echo $model->version; ?></dd>
                        <dt><?php echo Yii::t('modules','model.module.title'); ?>:</dt>
                        <dd><?php echo $model->title; ?></dd>
                        <dt><?php echo Yii::t('modules','model.module.author'); ?>:</dt>
                        <dd><a href="mailto:<?php echo $model->email; ?>"><?php echo $model->author; ?></a></dd>
                        <dt><?php echo Yii::t('modules','model.module.copyright'); ?>:</dt>
                        <dd><?php echo $model->copyright; ?></dd>
                        <dt><?php echo Yii::t('modules','model.module.website'); ?>:</dt>
                        <dd><a href="<?php echo $model->website; ?>"><?php echo $model->website; ?></a></dd>
                        <dt><?php echo Yii::t('modules','model.module.license'); ?>:</dt>
                        <dd><?php echo $model->license; ?></dd>
                        <dt><?php echo Yii::t('modules','model.module.description'); ?>:</dt>
                        <dd><?php echo $model->description; ?></dd>
                    </dl>
                </p>
            </div>
        </div>
    </div>
</div>