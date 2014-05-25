<?php
/**
 * System settings manager file.
 * Settings list template.
 *
 * @author Vlad Gramuzov <vlad.gramuzov@gmail.com>
 * @link http://yonote.org
 * @copyright 2014 Vlad Gramuzov
 * @license http://yonote.org/license.html
 */
?>

<?php if (Yii::app()->user->hasFlash('settingsSuccess')): ?>
    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <?php echo Yii::app()->user->getFlash('settingsSuccess'); ?>
            </div>
        </div>
    </div>
<?php endif; ?>
<div class="row">
    <div class="col-md-2">
        <ul class="list-group">
            <li class="list-group-item active"><a href="#url" data-toggle="tab">URL settings</a></li>
            <li class="list-group-item"><a href="#localization" data-toggle="tab">Localization</a></li>
            <li class="list-group-item"><a href="#other" data-toggle="tab">Other</a></li>
        </ul>           
    </div>
    <div class="col-md-10">
        <div class="panel panel-default">
            
            <?php echo CHtml::form('','POST',array(
                'role' => 'form',
                'class' => 'form-horizontal'
            )); ?>
            
                <div class="panel-body">
                    <div class="tab-content">
                        <div class="tab-pane active" id="url">
                            <div class="form-group <?php if ($model->hasErrors('systemUrlFormat')) echo 'has-error'; ?>">
                                <?php echo CHtml::activeLabel($model,'systemUrlFormat',array(
                                    'for' => 'systemUrlFormat',
                                    'class' => 'col-md-2 control-label'
                                )); ?>
                                <div class="col-md-10">
                                    <?php echo CHtml::activeDropDownList($model,'systemUrlFormat',$model->getUrlFormats(),array(
                                        'class' => 'form-control',
                                        'id' => 'systemUrlFormat'
                                    )); ?>
                                    <?php echo CHtml::error($model,'systemUrlFormat',array(
                                        'class' => 'help-block text-danger'
                                    )); ?>
                                </div>
                            </div>
                            <div class="checkbox col-md-10 col-md-offset-2">
                                <label>
                                    <?php echo CHtml::activeCheckBox($model,'allowMultilingualUrls'); ?> <?php echo $model->getAttributeLabel('allowMultilingualUrls'); ?>
                                </label>
                            </div>
                            <div class="checkbox col-md-10 col-md-offset-2">
                                <label>
                                    <?php echo CHtml::activeCheckBox($model,'redirectDefault'); ?> <?php echo $model->getAttributeLabel('redirectDefault'); ?>
                                </label>
                            </div>
                        </div>
                        <div class="tab-pane" id="localization">
                            <div class="form-group <?php if ($model->hasErrors('allowedLanguages')) echo 'has-error'; ?>">
                                <?php echo CHtml::activeLabel($model,'allowedLanguages',array(
                                    'for' => 'allowedLanguages',
                                    'class' => 'col-md-2 control-label'
                                )); ?>
                                <div class="col-md-10">
                                    <?php echo CHtml::activeTextField($model,'allowedLanguages',array(
                                        'class' => 'form-control',
                                        'id' => 'allowedLanguages'
                                    )); ?>
                                    <?php echo CHtml::error($model,'allowedLanguages',array(
                                        'class' => 'help-block text-danger'
                                    )); ?>
                                </div>
                            </div>
                            <div class="form-group <?php if ($model->hasErrors('adminLanguage')) echo 'has-error'; ?>">
                                <?php echo CHtml::activeLabel($model,'adminLanguage',array(
                                    'for' => 'adminLanguage',
                                    'class' => 'col-md-2 control-label'
                                )); ?>
                                <div class="col-md-10">
                                    <?php echo CHtml::activeDropDownList($model,'adminLanguage',$model->getLanguages(),array(
                                        'class' => 'form-control',
                                        'id' => 'adminLanguage'
                                    )); ?>
                                    <?php echo CHtml::error($model,'adminLanguage',array(
                                        'class' => 'help-block text-danger'
                                    )); ?>
                                </div>
                            </div>
                            <div class="form-group <?php if ($model->hasErrors('adminTimezone')) echo 'has-error'; ?>">
                                <?php echo CHtml::activeLabel($model,'adminTimezone',array(
                                    'for' => 'adminTimezone',
                                    'class' => 'col-md-2 control-label'
                                )); ?>
                                <div class="col-md-10">
                                    <?php echo CHtml::activeDropDownList($model,'adminTimezone',$model->getTimezones(),array(
                                        'class' => 'form-control',
                                        'id' => 'adminTimezone'
                                    )); ?>
                                    <?php echo CHtml::error($model,'adminTimezone',array(
                                        'class' => 'help-block text-danger'
                                    )); ?>
                                </div>
                            </div>
                            <div class="form-group <?php if ($model->hasErrors('websiteLanguage')) echo 'has-error'; ?>">
                                <?php echo CHtml::activeLabel($model,'websiteLanguage',array(
                                    'for' => 'websiteLanguage',
                                    'class' => 'col-md-2 control-label'
                                )); ?>
                                <div class="col-md-10">
                                    <?php echo CHtml::activeDropDownList($model,'websiteLanguage',$model->getLanguages(),array(
                                        'class' => 'form-control',
                                        'id' => 'websiteLanguage'
                                    )); ?>
                                    <?php echo CHtml::error($model,'websiteLanguage',array(
                                        'class' => 'help-block text-danger'
                                    )); ?>
                                </div>
                            </div>
                            <div class="form-group <?php if ($model->hasErrors('websiteTimezone')) echo 'has-error'; ?>">
                                <?php echo CHtml::activeLabel($model,'websiteTimezone',array(
                                    'for' => 'websiteTimezone',
                                    'class' => 'col-md-2 control-label'
                                )); ?>
                                <div class="col-md-10">
                                    <?php echo CHtml::activeDropDownList($model,'websiteTimezone',$model->getTimezones(),array(
                                        'class' => 'form-control',
                                        'id' => 'websiteTimezone'
                                    )); ?>
                                    <?php echo CHtml::error($model,'websiteTimezone',array(
                                        'class' => 'help-block text-danger'
                                    )); ?>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="other">
                            
                            <div class="form-group <?php if ($model->hasErrors('systemLoginDuration')) echo 'has-error'; ?>">
                                <?php echo CHtml::activeLabel($model,'systemLoginDuration',array(
                                    'for' => 'systemLoginDuration',
                                    'class' => 'col-md-2 control-label'
                                )); ?>
                                <div class="col-md-10">
                                    <?php echo CHtml::activeNumberField($model,'systemLoginDuration',array(
                                        'class' => 'form-control',
                                        'id' => 'systemUrlFormat'
                                    )); ?>
                                    <?php echo CHtml::error($model,'systemLoginDuration',array(
                                        'class' => 'help-block text-danger'
                                    )); ?>
                                </div>
                            </div>
                            <div class="form-group <?php if ($model->hasErrors('adminTemplate')) echo 'has-error'; ?>">
                                <?php echo CHtml::activeLabel($model,'adminTemplate',array(
                                    'for' => 'adminTemplate',
                                    'class' => 'col-md-2 control-label'
                                )); ?>
                                <div class="col-md-10">
                                    <?php echo CHtml::activeDropDownList($model,'adminTemplate',$model->getTemplates('backend'),array(
                                        'class' => 'form-control',
                                        'id' => 'adminTemplate'
                                    )); ?>
                                    <?php echo CHtml::error($model,'adminTemplate',array(
                                        'class' => 'help-block text-danger'
                                    )); ?>
                                </div>
                            </div>
                            <div class="form-group <?php if ($model->hasErrors('websiteTemplate')) echo 'has-error'; ?>">
                                <?php echo CHtml::activeLabel($model,'websiteTemplate',array(
                                    'for' => 'websiteTemplate',
                                    'class' => 'col-md-2 control-label'
                                )); ?>
                                <div class="col-md-10">
                                    <?php echo CHtml::activeDropDownList($model,'websiteTemplate',$model->getTemplates('frontend'),array(
                                        'class' => 'form-control',
                                        'id' => 'adminTemplate'
                                    )); ?>
                                    <?php echo CHtml::error($model,'websiteTemplate',array(
                                        'class' => 'help-block text-danger'
                                    )); ?>
                                </div>
                            </div>
                            <div class="form-group <?php if ($model->hasErrors('moduleMaxSize')) echo 'has-error'; ?>">
                                <?php echo CHtml::activeLabel($model,'moduleMaxSize',array(
                                    'for' => 'moduleMaxSize',
                                    'class' => 'col-md-2 control-label'
                                )); ?>
                                <div class="col-md-10">
                                    <?php echo CHtml::activeNumberField($model,'moduleMaxSize',array(
                                        'class' => 'form-control',
                                        'id' => 'moduleMaxSize'
                                    )); ?>
                                    <?php echo CHtml::error($model,'moduleMaxSize',array(
                                        'class' => 'help-block text-danger'
                                    )); ?>
                                </div>
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