<?php
/**
 * Users manager file.
 * Profile editor template.
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

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">

            <?php echo CHtml::form('','POST',array(
                'role' => 'form',
                'class' => 'form-horizontal',
                'enctype' => 'multipart/form-data'
            )); ?>
            
            <div class="panel-body"> 
                <div class="form-group <?php if ($model->hasErrors('name')) echo('has-error'); ?>">
                    <?php echo CHtml::activeLabel($model,'name',array(
                        'for' => 'userName',
                        'class' => 'col-sm-2 control-label'
                    )); ?>
                    <div class="col-sm-10">
                        <?php echo CHtml::activeTextField($model,'name',array(
                            'class' => 'form-control',
                            'id' => 'userName',
                            'placeholder' => Yii::t('users','placeholder.profile.name')
                        )); ?>
                        <?php echo CHtml::error($model,'name',array(
                            'class' => 'help-block text-danger'
                        )); ?>

                    </div>
                </div>
                <div class="form-group <?php if ($model->hasErrors('country')) echo('has-error'); ?>">
                    <?php echo CHtml::activeLabel($model,'country',array(
                        'for' => 'userCountry',
                        'class' => 'col-sm-2 control-label'
                    )); ?>
                    <div class="col-sm-10">
                        <?php echo CHtml::activeTextField($model,'country',array(
                            'class' => 'form-control',
                            'id' => 'userCountry',
                            'placeholder' => Yii::t('users','placeholder.profile.country')
                        )); ?>
                        <?php echo CHtml::error($model,'country',array(
                            'class' => 'help-block text-danger'
                        )); ?>

                    </div>
                </div>
                <div class="form-group <?php if ($model->hasErrors('city')) echo('has-error'); ?>">
                    <?php echo CHtml::activeLabel($model,'city',array(
                        'for' => 'userCity',
                        'class' => 'col-sm-2 control-label'
                    )); ?>
                    <div class="col-sm-10">
                        <?php echo CHtml::activeTextField($model,'city',array(
                            'class' => 'form-control',
                            'id' => 'userCity',
                            'placeholder' => Yii::t('users','placeholder.profile.city')
                        )); ?>
                        <?php echo CHtml::error($model,'city',array(
                            'class' => 'help-block text-danger'
                        )); ?>

                    </div>
                </div>
                <div class="form-group <?php if ($model->hasErrors('language')) echo('has-error'); ?>">
                    <?php echo CHtml::activeLabel($model,'language',array(
                        'for' => 'userLanguage',
                        'class' => 'col-sm-2 control-label'
                    )); ?>
                    <div class="col-sm-10">
                        <?php echo CHtml::activeDropDownList($model,'language',$model->getLanguages(),array(
                            'class' => 'form-control',
                            'id' => 'userLanguage'
                        )); ?>
                        <?php echo CHtml::error($model,'language',array(
                            'class' => 'help-block text-danger'
                        )); ?>

                    </div>
                </div>
                <div class="form-group <?php if ($model->hasErrors('photo')) echo('has-error'); ?>">
                    <?php echo CHtml::activeLabel($model,'photo',array(
                        'for' => 'userPhoto',
                        'class' => 'col-sm-2 control-label'
                    )); ?>
                    <div class="col-sm-10">
                        <?php echo CHtml::activeFileField($model,'photo',array(
                            'class' => 'form-control',
                            'id' => 'userPhoto'
                        )); ?>
                        <?php echo CHtml::error($model,'photo',array(
                            'class' => 'help-block text-danger'
                        )); ?>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <div class="checkbox">
                            <label>
                                <?php echo CHtml::activeCheckBox($model,'removePhoto'); ?>
                                <?php echo Yii::t('users','model.profile.removephoto'); ?>
                            </label>
                        </div>
                    </div>
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