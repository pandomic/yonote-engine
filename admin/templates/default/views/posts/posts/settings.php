<?php
/**
 * Posts module template file.
 * Posts manager template file.
 * Posts general settings template.
 *
 * @author Vlad Gramuzov <vlad.gramuzov@gmail.com>
 * @link http://yonote.org
 * @copyright 2014 Vlad Gramuzov
 * @license http://yonote.org/license.html
 */
?>

<?php if (Yii::app()->user->hasFlash('postsSettingsSuccess')): ?>
    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <?php echo Yii::app()->user->getFlash('postsSettingsSuccess'); ?>
            </div>
        </div>
    </div>
<?php endif; ?>

<div class="row">
    <div class="col-md-2">
       <div class="list-group">
          <a href="<?php echo $this->createUrl('posts/index'); ?>" class="list-group-item"><?php echo Yii::t('PostsModule.posts','page.posts.title'); ?></a>
          <a href="<?php echo $this->createUrl('hashtags/index'); ?>" class="list-group-item"><?php echo Yii::t('PostsModule.hashtags','page.hashtags.title'); ?></a>
          <a href="<?php echo $this->createUrl('posts/add'); ?>" class="list-group-item"><?php echo Yii::t('PostsModule.posts','page.add.title'); ?></a>
          <a href="<?php echo $this->createUrl('posts/settings'); ?>" class="list-group-item active"><?php echo Yii::t('PostsModule.settings','page.settings.title'); ?></a>
      </div>
    </div>
    <div class="col-md-10">
        <div class="panel panel-default">
            <div class="panel-heading table-middle clearfix">
                <h3 class="panel-title"><?php echo Yii::t('PostsModule.settings','page.settings.title'); ?></h3>
            </div>
            
            <?php echo CHtml::form('','POST',array(
                'role' => 'form',
                'class' => 'form-horizontal'
            )); ?>
            
                <div class="panel-body"> 
                    <?php foreach ($model->getAttributes() as $key => $val): ?>            

                        <div class="form-group <?php if ($model->hasErrors($key)) echo 'has-error'; ?>">
                            <?php echo CHtml::activeLabel($model,$key,array(
                                'for' => $key,
                                'class' => 'col-md-2 control-label'
                            )); ?>
                            <div class="col-md-10">
                                <?php echo CHtml::activeTextField($model,$key,array(
                                    'class' => 'form-control',
                                    'id' => $key
                                )); ?>
                                <?php echo CHtml::error($model,$key,array(
                                    'class' => 'help-block text-danger'
                                )); ?>
                            </div>
                        </div>

                    <?php endforeach; ?>
                </div>
                <div class="panel-footer">
                    <button type="submit" class="btn btn-primary"><?php echo Yii::t('system','app.save'); ?></button>
                    <button type="reset" class="btn btn-default"><?php echo Yii::t('system','app.reset'); ?></button>
                </div>
            <?php echo CHtml::endForm(); ?>
        </div>
    </div>
</div>