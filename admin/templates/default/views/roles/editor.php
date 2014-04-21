<?php
// Build permissions selected items
$selected = array();
if (isset($model->parentrelations))
{
    $selected = array();
    foreach ($model->parentrelations as $parent)
        $selected[] = $parent->parent;
}
?>

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

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">

            <div class="panel-body"> 
                    
                <?php echo CHtml::form('','POST',array(
                    'role' => 'form',
                    'class' => 'form-horizontal'
                )); ?>

                    <div class="form-group <?php if ($model->hasErrors('name')) echo('has-error'); ?>">
                        <?php echo CHtml::activeLabel($model,'name',array(
                            'for' => 'roleName',
                            'class' => 'col-sm-2 control-label'
                        )); ?>
                        <div class="col-sm-10">
                            <?php echo CHtml::activeTextField($model,'name',array(
                                'class' => 'form-control',
                                'id' => 'roleName',
                                'placeholder' => Yii::t('users','placeholder.role.name')
                            )); ?>
                            <?php echo CHtml::error($model,'name',array(
                                'class' => 'help-block text-danger'
                            )); ?>
                            
                        </div>
                    </div>
                    <div class="form-group <?php if ($model->hasErrors('description')) echo('has-error'); ?>">
                        <?php echo CHtml::activeLabel($model,'description',array(
                            'for' => 'roleDescription',
                            'class' => 'col-sm-2 control-label'
                        )); ?>
                        <div class="col-sm-10">
                            <?php echo CHtml::activeTextField($model,'description',array(
                                'class' => 'form-control',
                                'id' => 'roleDescription',
                                'placeholder' => Yii::t('users','placeholder.role.description')
                            )); ?>
                            <?php echo CHtml::error($model,'description',array(
                                'class' => 'help-block text-danger'
                            )); ?>
                        </div>
                    </div>
                    <div class="form-group <?php if ($model->hasErrors('parents')) echo('has-error'); ?>">
                        <?php echo CHtml::activeLabel($model,'parents',array(
                            'for' => 'rolePermissions',
                            'class' => 'col-sm-2 control-label'
                        )); ?>
                        <div class="col-sm-10">
                            <select class="form-control" multiple="true" name="AuthItem[parents][]" size="<?php echo count($authTree); ?>">
                                <?php foreach($authTree as $arr): list($k,$v) = each($arr); ?>
                                    <option <?php if (in_array($k,$selected)) echo 'selected="true"'; ?> value="<?php echo $k; ?>"><?php echo $v; ?></option>
                                <?php endforeach; ?>
                            </select>
                            <?php echo CHtml::error($model,'parents',array(
                                'class' => 'help-block text-danger'
                            )); ?>
                        </div>
                    </div>
                    
                    <button type="submit" class="btn btn-primary"><?php echo Yii::t('system','app.save'); ?></button>
                    <button type="reset" class="btn btn-default"><?php echo Yii::t('system','app.reset'); ?></button>
                
                <?php echo CHtml::endForm(); ?>
                
            </div>
        </div>
    </div>
</div>