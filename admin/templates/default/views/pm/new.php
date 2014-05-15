<?php
/**
 * PM manager template file.
 * New message template.
 *
 * @author Vlad Gramuzov <vlad.gramuzov@gmail.com>
 * @link http://yonote.org
 * @copyright 2014 Vlad Gramuzov
 * @license http://yonote.org/license.html
 */
?>

<?php
// Select tinymce language.
$tinymceLanguage = (in_array(Yii::app()->getLanguage().'.js',scandir($tinymcePath = Yii::app()->assetManager->getPublishedPath
        (Yii::getPathOfAlias('application.vendors.tinymce')).'/langs'))) ? Yii::app()->getLanguage() : '';
?>

<script type="text/javascript" src="<?php echo $this->asset('application.vendors.tinymce'); ?>/tinymce.min.js"></script>
<script type="text/javascript">
tinymce.init({
    selector: 'textarea',
    language: '<?php echo $tinymceLanguage; ?>',
    plugins: [
        'link','image','code','media'
    ]
 });
</script>

<?php if (Yii::app()->user->hasFlash('pmSuccess')): ?>
    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <?php echo Yii::app()->user->getFlash('pmSuccess'); ?>
            </div>
        </div>
    </div>
<?php endif; ?>

<?php if (Yii::app()->user->hasFlash('pmWarning')): ?>
    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-warning">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <?php echo Yii::app()->user->getFlash('pmWarning'); ?>
            </div>
        </div>
    </div>
<?php endif; ?>

<div class="row">
    <div class="col-md-2">
       <div class="list-group">
           <a href="<?php echo $this->createUrl('index'); ?>" class="list-group-item"><?php echo Yii::t('pm','label.inbox'); ?></a>
          <a href="<?php echo $this->createUrl('outbox'); ?>" class="list-group-item"><?php echo Yii::t('pm','label.outbox'); ?></a>
          <a href="<?php echo $this->createUrl('new'); ?>" class="list-group-item active"><?php echo Yii::t('pm','label.add'); ?></a>
          <a href="<?php echo $this->createUrl('settings'); ?>" class="list-group-item"><?php echo Yii::t('pm','page.settings.title'); ?></a>
      </div>
    </div>
    <div class="col-md-10">
        <div class="panel panel-default">
            <?php echo CHtml::form(null,'POST',array(
                'role' => 'form',
                'id' => 'pagesForm',
                'enctype' => 'multipart/form-data'
            )); ?>
                <div class="panel-body"> 
                    <div class="form-group <?php if ($model->hasErrors('title')) echo('has-error'); ?>">
                        <?php echo CHtml::activeLabel($model,'title',array(
                            'for' => 'title',
                            'class' => 'control-label'
                        )); ?>
                        <?php echo CHtml::activeTextField($model,'title',array(
                            'class' => 'form-control',
                            'id' => 'title',
                            'placeholder' => ''
                        )); ?>
                        <?php echo CHtml::error($model,'title',array(
                            'class' => 'help-block text-danger'
                        )); ?>
                    </div>
                    <div class="form-group <?php if ($model->hasErrors('touserid')) echo('has-error'); ?>">
                        <?php echo CHtml::activeLabel($model,'touserid',array(
                            'for' => 'touserid',
                            'class' => 'control-label'
                        )); ?>
                        <?php echo CHtml::activeTextField($model,'touserid',array(
                            'class' => 'form-control',
                            'id' => 'touserid',
                            'placeholder' => ''
                        )); ?>
                        <?php echo CHtml::error($model,'touserid',array(
                            'class' => 'help-block text-danger'
                        )); ?>
                    </div>
                    <div class="form-group <?php if ($model->hasErrors('message')) echo('has-error'); ?>">
                        <?php echo CHtml::activeLabel($model,'message',array(
                            'for' => 'message',
                            'class' => 'control-label'
                        )); ?>
                        <?php echo CHtml::activeTextArea($model,'message',array(
                            'class' => 'form-control',
                            'id' => 'message',
                            'placeholder' => ''
                        )); ?>
                        <?php echo CHtml::error($model,'message',array(
                            'class' => 'help-block text-danger'
                        )); ?>
                    </div>
                </div>
                <div class="panel-footer">
                    <button type="submit" class="btn btn-primary"><?php echo Yii::t('system','app.save'); ?></button>
                    <button type="reset" class="btn btn-default"><?php echo Yii::t('system','app.reset'); ?></button>
                </div>
            
            <?php echo CHtml::endForm(); ?>
        </div>
    </div>
</div>