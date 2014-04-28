<?php
$tinymce = Yii::app()->assetManager->publish(
    Yii::getPathOfAlias('application.vendors.tinymce')
);
$tinymcePath = Yii::app()->assetManager->getPublishedPath(
    Yii::getPathOfAlias('application.vendors.tinymce')
);
$tinymceLangs = scandir($tinymcePath.'/langs');
$tinymceLanguage = (in_array(Yii::app()->getLanguage().'.js',$tinymceLangs)) ? Yii::app()->getLanguage() : '';
?>

<script type="text/javascript" src="<?php echo $tinymce; ?>/tinymce.min.js"></script>
<script type="text/javascript">
tinymce.init({
    selector: 'textarea',
    language: '<?php echo $tinymceLanguage; ?>',
    plugins: [
        'link','image','code','media'
    ]
 });
</script>

<?php if (Yii::app()->user->hasFlash('postsSuccess')): ?>
    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <?php echo Yii::app()->user->getFlash('postsSuccess'); ?>
            </div>
        </div>
    </div>
<?php endif; ?>

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <?php echo CHtml::form(null,'POST',array(
                'role' => 'form',
                'id' => 'pagesForm',
                'enctype' => 'multipart/form-data'
            )); ?>
                <div class="panel-body"> 
                    <div class="form-group <?php if ($model->hasErrors('alias')) echo('has-error'); ?>">
                        <?php echo CHtml::activeLabel($model,'alias',array(
                            'for' => 'postAlias',
                            'class' => 'control-label'
                        )); ?>
                        <?php echo CHtml::activeTextField($model,'alias',array(
                            'class' => 'form-control',
                            'id' => 'postAlias',
                            'placeholder' => Yii::t('PostsModule.posts','placeholder.post.alias')
                        )); ?>
                        <?php echo CHtml::error($model,'alias',array(
                            'class' => 'help-block text-danger'
                        )); ?>
                    </div>
                    <div class="form-group <?php if ($model->hasErrors('title')) echo('has-error'); ?>">
                        <?php echo CHtml::activeLabel($model,'title',array(
                            'for' => 'postTitle',
                            'class' => 'control-label'
                        )); ?>
                        <?php echo CHtml::activeTextField($model,'title',array(
                            'class' => 'form-control',
                            'id' => 'postTitle',
                            'placeholder' => Yii::t('PostsModule.posts','placeholder.post.title')
                        )); ?>
                        <?php echo CHtml::error($model,'title',array(
                            'class' => 'help-block text-danger'
                        )); ?>
                    </div>
                    <div class="form-group <?php if ($model->hasErrors('language')) echo('has-error'); ?>">
                        <?php echo CHtml::activeLabel($model,'language',array(
                            'for' => 'postLanguage',
                            'class' => 'control-label'
                        )); ?>
                        <?php echo CHtml::activeDropDownList($model,'language',array_merge(array(''=>''),$model->getLanguages()),array(
                            'class' => 'form-control',
                            'id' => 'postLanguage'
                        )); ?>
                        <?php echo CHtml::error($model,'language',array(
                            'class' => 'help-block text-danger'
                        )); ?>
                    </div>
                    <div class="form-group <?php if ($model->hasErrors('thumbnail')) echo('has-error'); ?>">
                        <?php echo CHtml::activeLabel($model,'thumbnail',array(
                            'for' => 'postThumbnail',
                            'class' => 'control-label'
                        )); ?>
                        <?php echo CHtml::activeFileField($model,'thumbnail',array(
                            'class' => 'form-control',
                            'id' => 'postThumbnail'
                        )); ?>
                        <?php echo CHtml::error($model,'thumbnail',array(
                            'class' => 'help-block text-danger'
                        )); ?>
                    </div>
                    <div class="form-group">
                        <div class="checkbox">
                            <label>
                                <?php echo CHtml::activeCheckBox($model,'removeThumbnail'); ?>
                                <?php echo Yii::t('PostsModule.posts','model.post.removethumbnail'); ?>
                            </label>
                        </div>
                    </div>
                    <div class="form-group <?php if ($model->hasErrors('short')) echo('has-error'); ?>">
                        <?php echo CHtml::activeLabel($model,'short',array(
                            'for' => 'pageShort',
                            'class' => 'control-label'
                        )); ?>
                        <?php echo CHtml::activeTextArea($model,'short',array(
                            'class' => 'form-control',
                            'id' => 'pageShort'
                        )); ?>

                        <?php echo CHtml::error($model,'short',array(
                            'class' => 'help-block text-danger'
                        )); ?>
                    </div>
                    <div class="form-group <?php if ($model->hasErrors('full')) echo('has-error'); ?>">
                        <?php echo CHtml::activeLabel($model,'full',array(
                            'for' => 'pageFull',
                            'class' => 'control-label'
                        )); ?>
                        <?php echo CHtml::activeTextArea($model,'full',array(
                            'class' => 'form-control',
                            'id' => 'pageFull'
                        )); ?>

                        <?php echo CHtml::error($model,'full',array(
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