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

<?php if (Yii::app()->user->hasFlash('postsWarning')): ?>
    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-warning">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <?php echo Yii::app()->user->getFlash('postsWarning'); ?>
            </div>
        </div>
    </div>
<?php endif; ?>



<div class="row">
    <div class="col-md-2">
       <div class="list-group">
          <a href="<?php echo $this->createUrl('posts/index'); ?>" class="list-group-item active"><?php echo Yii::t('PostsModule.posts','page.posts.title'); ?></a>
          <a href="<?php echo $this->createUrl('hashtags/index'); ?>" class="list-group-item"><?php echo Yii::t('PostsModule.hashtags','page.hashtags.title'); ?></a>
          <a href="<?php echo $this->createUrl('posts/add'); ?>" class="list-group-item"><?php echo Yii::t('PostsModule.posts','page.add.title'); ?></a>
      </div>
    </div>
    <div class="col-md-10">
        <div class="panel panel-default">
            <div class="panel-heading table-middle clearfix">
                <a class="btn btn-primary btn-xs pull-right" href="<?php echo $this->createUrl('add'); ?>"><span class="glyphicon glyphicon-plus"></span> <?php echo Yii::t('PostsModule.posts','button.post.add'); ?></a>
                <h3 class="panel-title"><?php echo Yii::t('PostsModule.posts','label.posts.list'); ?></h3>
            </div>
            <div class="panel-body"> 
                
                <?php echo CHtml::form('','POST',array(
                    'role' => 'form',
                    'class' => 'form-inline'
                )); ?>

                    <div class="input-group">
                        <label class="sr-only" for="searchInput"><?php echo Yii::t('system','app.search'); ?></label>
                        <input type="text" class="form-control" name="search" value="<?php echo Yii::app()->session['postsSearch']; ?>" id="searchInput" placeholder="<?php echo Yii::t('PostsModule.posts','placeholder.posts.search'); ?>">
                        <span class="input-group-btn">
                            <button class="btn btn-default" type="submit"><?php echo Yii::t('system','app.search'); ?></button>
                        </span>
                    </div>
                    
                <?php echo CHtml::endForm(); ?>
            </div>
            <?php if (count($models) > 0): ?>

                <?php echo CHtml::form(array('remove'),'POST',array(
                    'role' => 'form',
                    'id' => 'pagesForm'
                )); ?>

                    <table class="table table-hover table-striped table-middle table-separated table-responsive">
                        <thead>
                            <tr>
                                <th><?php echo $sort->link('alias'); ?></th>
                                <th><?php echo $sort->link('title'); ?></th>
                                <th><?php echo $sort->link('language'); ?></th>
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
                            <?php foreach ($models as $model): ?>
                                <tr>
                                    <td>
                                        <a href="<?php echo $this->createUrl('edit',array('id' => $model->alias)); ?>">
                                            <?php echo $model->alias; ?>
                                        </a>
                                    </td>
                                    <td>
                                        <?php echo $model->title; ?>
                                    </td>
                                    <td>
                                        <?php if ($model->language == null): ?>
                                            <span class="label label-warning"><?php echo Yii::t('PostsModule.posts','label.language.any'); ?></span>
                                        <?php else: ?>
                                            <span class="label label-success"><?php echo $model->language; ?></span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" name="select[]" value="<?php echo $model->alias; ?>"> <?php echo Yii::t('system','app.select'); ?>
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
                                <button type="button" class="btn btn-danger" onclick="$(this).confirmModal();" data-action="$('#pagesForm').submit();"><?php echo Yii::t('PostsModule.posts','button.posts.remove'); ?></button>
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
                        <?php echo Yii::t('PostsModule.posts','warning.posts.empty'); ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>