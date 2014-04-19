<?php
// A little bit of magic
// Create new Recursive iterator
$array_iterator = new RecursiveIteratorIterator(
    new RecursiveArrayIterator($tree)
);
// Create dropdown items array
$dropDownList = array();
// Create dropdown selected items array
$dropDownListSelected = array();
// Available auth item types
$types = array('Operation','Task','Role');
// Build dropdown items
foreach($array_iterator as $key => $value)
{
    $indent = str_repeat('&nbsp;',$array_iterator->getDepth()*3);
    $dropDownList[$key] = $indent.'|- '.$value." ({$types[$items[$key]->type]})";
}
// Build dropdown selected items
if (isset($model->assignments))
{
    foreach ($model->assignments as $assignment)
        $dropDownListSelected[$assignment->itemname] = array('selected' => true);
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
                    <div class="form-group <?php if ($model->hasErrors('permissions')) echo('has-error'); ?>">
                        <?php echo CHtml::activeLabel($model,'permissions',array(
                            'for' => 'rolePermissions',
                            'class' => 'col-sm-2 control-label'
                        )); ?>
                        <div class="col-sm-10">
                            <?php echo CHtml::activeDropDownList($model,'permissions',$dropDownList,array(
                                'multiple' => true,
                                'encode' => false,
                                'class' => 'form-control',
                                'options' => $dropDownListSelected,
                                'id' => 'rolePermissions'
                            )); ?>
                            <?php echo CHtml::error($model,'permissions',array(
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