<?php
$unread = 0;
$outbox = 0;
foreach ($models as $model)
{
    if ((boolean) $model->inbox && (boolean) !$model->read)
        $unread++;
}
?>

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
           <a href="<?php echo $this->createUrl('index'); ?>" class="list-group-item active"><?php echo Yii::t('pm','label.inbox'); ?> <?php if ($unread > 0): ?><label class="label label-default"><?php echo $unread; ?></label><?php endif; ?></a>
          <a href="<?php echo $this->createUrl('outbox'); ?>" class="list-group-item"><?php echo Yii::t('pm','label.outbox'); ?> <?php if ($outbox > 0): ?><label class="label label-default"><?php echo $outbox; ?></label><?php endif; ?></a>
          <a href="<?php echo $this->createUrl('add'); ?>" class="list-group-item"><?php echo Yii::t('pm','label.add'); ?></a>
      </div>
    </div>
    <div class="col-md-10">
        <div class="panel panel-default">
            <div class="panel-heading clearfix">
                <a href="<?php echo $this->createUrl('add'); ?>" class="btn btn-primary btn-xs pull-right"><span class="glyphicon glyphicon-plus"></span> <?php echo Yii::t('pm','label.add'); ?></a>
                <h3 class="panel-title"><?php echo Yii::t('pm','label.inbox.list'); ?></h3> <span class="label label-primary"><?php echo count($models); ?></span>
            </div>
            <div class="panel-body">
                <?php echo CHtml::form('','POST',array(
                    'role' => 'form',
                    'class' => 'form-inline'
                )); ?>

                    <div class="input-group">
                        <label class="sr-only" for="searchInput"><?php echo Yii::t('system','app.search'); ?></label>
                        <input type="text" class="form-control" name="search" value="<?php echo Yii::app()->session['pmSearch']; ?>" id="searchInput" placeholder="<?php echo Yii::t('pm','placeholder.pm.search'); ?>">
                        <span class="input-group-btn">
                            <button class="btn btn-default" type="submit"><?php echo Yii::t('system','app.search'); ?></button>
                        </span>
                    </div>
                    
                <?php echo CHtml::endForm(); ?>
            </div>
            <?php if (count($models) > 0): ?>

                <?php echo CHtml::form(array('remove'),'POST',array(
                    'role' => 'form',
                    'id' => 'messagesForm'
                )); ?>

                    <table class="table table-striped table-hover table-middle table-responsive table-separated">
                        <thead>
                            <tr>
                                <th><?php echo $sort->link('title'); ?></th>
                                <th><?php echo $sort->link('senderid'); ?></th>
                                <th><?php echo $sort->link('updatetime'); ?></th>
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
                                        <a href="<?php echo $this->createUrl('read',array('id' => $model->id)); ?>"><?php echo $model->title; ?></a> <?php if ((boolean) !$model->read): ?><span class="label label-danger">new</span><?php endif; ?>
                                    </td>
                                    <td>
                                        <a href="<?php echo $this->createUrl('add',array('to' => $model->senderid)); ?>"><?php echo $model->senderid; ?></a>
                                    </td>
                                    <td>
                                        <?php echo Yii::app()->dateFormatter->formatDateTime($model->updatetime); ?>
                                    </td>
                                    <td>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" name="select[]" value="<?php echo $model->id; ?>"> <?php echo Yii::t('system','app.select'); ?>
                                            </label>
                                        </div>
                                    </td>
                                </tr>

                            <?php endforeach; ?>

                        </tbody>
                    </table>
                    <div class="panel-footer">
                        <button type="button" class="btn btn-danger" onclick="$(this).confirmModal();" data-action="$('#messagesForm').submit();"><?php echo Yii::t('pm','button.messages.remove'); ?></button>
                    </div>
                <?php echo CHtml::endForm(); ?>
            <?php else: ?>
                <div class="panel-body">
                    <div class="alert alert-warning">
                        <?php echo Yii::t('pm','warning.pm.empty'); ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>