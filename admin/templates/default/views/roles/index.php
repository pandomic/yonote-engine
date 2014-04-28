<?php if (Yii::app()->user->hasFlash('rolesSuccess')): ?>
    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <?php echo Yii::app()->user->getFlash('rolesSuccess'); ?>
            </div>
        </div>
    </div>
<?php endif; ?>

<?php if (Yii::app()->user->hasFlash('rolesWarning')): ?>
    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-warning">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <?php echo Yii::app()->user->getFlash('rolesWarning'); ?>
            </div>
        </div>
    </div>
<?php endif; ?>

<div class="row">
    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading table-middle clearfix">
                <a class="btn btn-primary btn-xs pull-right" href="<?php echo $this->createUrl('add'); ?>"><span class="glyphicon glyphicon-plus"></span> <?php echo Yii::t('users','button.role.add'); ?></a>
                <h3 class="panel-title"><?php echo Yii::t('users','label.roles'); ?></h3>
            </div>
            
            <?php echo CHtml::form(array('remove'),'POST',array(
                'role' => 'form',
                'id' => 'rolesForm'
            )); ?>
            
                <table class="table table-hover table-striped table-middle table-separated table-responsive">
                    <thead>
                        <tr>
                            <th><?php echo $sort->link('name'); ?></th>
                            <th><?php echo $sort->link('description'); ?></th>
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
                        <?php
                        foreach ($models as $model):
                                if ($model->type == 2):
                        ?>

                            <tr>
                                <td>
                                    <a href="<?php echo $this->createUrl('edit',array('id' => $model->name)); ?>">
                                        <?php echo $model->name; ?>
                                    </a>
                                </td>
                                <td>
                                    <?php echo $model->description; ?>
                                </td>
                                <td>
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="select[]" value="<?php echo $model->name; ?>"> <?php echo Yii::t('system','app.select'); ?>
                                        </label>
                                    </div>
                                </td>
                            </tr>
                        <?php
                            endif;
                        endforeach; 
                        ?>
                    </tbody>
                </table>

                <div class="panel-footer">
                    <button type="button" class="btn btn-danger" onclick="$(this).confirmModal();" data-action="$('#rolesForm').submit();"><?php echo Yii::t('users','button.roles.remove'); ?></button>
                </div>

            <?php echo CHtml::endForm(); ?>
            
        </div>
    </div>
    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading table-middle clearfix">
                <h3 class="panel-title"><?php echo Yii::t('users','label.authitems'); ?></h3>
            </div>
                
            <?php echo CHtml::form(array('remove'),'POST',array(
                'role' => 'form'
            )); ?>

                <table class="table table-hover table-striped table-middle table-responsive">
                    <thead>
                        <tr>
                            <th><?php echo $sort->link('name'); ?></th>
                            <th><?php echo $sort->link('description'); ?></th>
                            <th><?php echo $sort->link('type'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($models as $model):
                                if ($model->type != 2):
                        ?>

                            <tr>
                                <td>
                                    <a href="<?php echo $this->createUrl('edit',array('id' => $model->name)); ?>">
                                        <?php echo $model->name; ?>
                                    </a>
                                </td>
                                <td>
                                    <?php echo $model->description; ?>
                                </td>
                                <td>
                                    <?php if ($model->type == 1): ?>
                                        <span class="label label-primary">
                                            <?php echo Yii::t('users','label.task'); ?>
                                        </span>
                                    <?php else: ?>
                                        <span class="label label-success">
                                            <?php echo Yii::t('users','label.operation'); ?>
                                        </span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php
                            endif;
                        endforeach; 
                        ?>
                    </tbody>
                </table>

            <?php echo CHtml::endForm(); ?>
        </div>
    </div>
</div>