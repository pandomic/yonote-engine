<?php
/**
 * Posts module template file.
 * Hashtags manager template file.
 * Hashtags list template.
 *
 * @author Vlad Gramuzov <vlad.gramuzov@gmail.com>
 * @link http://yonote.org
 * @copyright 2014 Vlad Gramuzov
 * @license http://yonote.org/license.html
 */
?>

<?php if (Yii::app()->user->hasFlash('hashtagsSuccess')): ?>
    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <?php echo Yii::app()->user->getFlash('hashtagsSuccess'); ?>
            </div>
        </div>
    </div>
<?php endif; ?>

<?php if (Yii::app()->user->hasFlash('hashtagsWarning')): ?>
    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-warning">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <?php echo Yii::app()->user->getFlash('hashtagsWarning'); ?>
            </div>
        </div>
    </div>
<?php endif; ?>

<div class="row">
    <div class="col-md-2">
       <div class="list-group">
          <a href="<?php echo $this->createUrl('posts/index'); ?>" class="list-group-item"><?php echo Yii::t('PostsModule.posts','page.posts.title'); ?></a>
          <a href="<?php echo $this->createUrl('hashtags/index'); ?>" class="list-group-item active"><?php echo Yii::t('PostsModule.hashtags','page.hashtags.title'); ?></a>
          <a href="<?php echo $this->createUrl('posts/add'); ?>" class="list-group-item"><?php echo Yii::t('PostsModule.posts','page.add.title'); ?></a>
          <a href="<?php echo $this->createUrl('posts/settings'); ?>" class="list-group-item"><?php echo Yii::t('PostsModule.settings','page.settings.title'); ?></a>
      </div>
    </div>
    <div class="col-md-10">
        <div class="panel panel-default">
            <div class="panel-heading table-middle clearfix">
                <h3 class="panel-title"><?php echo Yii::t('PostsModule.hashtags','label.hashtags.list'); ?></h3> <span class="label label-primary"><?php echo count($models); ?></span>
            </div>
            <div class="panel-body"> 
                
                <?php echo CHtml::form('','POST',array(
                    'role' => 'form',
                    'class' => 'form-inline'
                )); ?>

                    <div class="input-group">
                        <label class="sr-only" for="searchInput"><?php echo Yii::t('system','app.search'); ?></label>
                        <input type="text" class="form-control" name="search" value="<?php echo Yii::app()->session['hashtagsSearch']; ?>" id="searchInput" placeholder="<?php echo Yii::t('PostsModule.hashtags','placeholder.hashtags.search'); ?>">
                        <span class="input-group-btn">
                            <button class="btn btn-default" type="submit"><?php echo Yii::t('system','app.search'); ?></button>
                        </span>
                    </div>
                    
                <?php echo CHtml::endForm(); ?>
            </div>
            <?php if (count($models) > 0): ?>

                <?php echo CHtml::form(array('remove'),'POST',array(
                    'role' => 'form',
                    'id' => 'hashtagsForm'
                )); ?>

                    <table class="table table-middle table-separated table-hover table-striped">
                        <thead>
                            <tr>
                                <th>
                                    <?php echo $sort->link('name'); ?>
                                </th>
                                <th>
                                    <?php echo Yii::t('system','app.select'); ?>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($models as $model): ?>
                            <tr>
                                <td>
                                    <a href="<?php echo $this->createUrl('/posts/posts/index',array('hashtag' => $model->name)); ?>" class="list-group-item">#<?php echo $model->name; ?><span class="badge"><?php echo count($model->posts); ?></span></a>
                                </td>
                                <td>
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="select[]" value="<?php echo $model->name; ?>"> <?php echo Yii::t('system','app.select'); ?>
                                        </label>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            </div>
                        </tbody>
                    </table>
                    <div class="panel-footer">
                        <button type="button" class="btn btn-danger" onclick="$(this).confirmModal();" data-action="$('#hashtagsForm').submit();"><?php echo Yii::t('PostsModule.posts','button.posts.remove'); ?></button>
                    </div>
                <?php echo CHtml::endForm(); ?>

            <?php else: ?>
                <div class="panel-body">
                    <div class="alert alert-warning">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <?php echo Yii::t('PostsModule.hashtags','warning.hashtags.empty'); ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>