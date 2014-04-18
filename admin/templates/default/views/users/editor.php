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

            <div class="panel-body"> 
                    
                <?php echo CHtml::form('','POST',array(
                    'role' => 'form',
                    'class' => 'form-horizontal'
                )); ?>

                    <div class="form-group <?php if ($model->hasErrors('name')) echo('has-error'); ?>">
                        <?php echo CHtml::activeLabel($model,'name',array(
                            'for' => 'userName',
                            'class' => 'col-sm-2 control-label'
                        )); ?>
                        <div class="col-sm-10">
                            <?php echo CHtml::activeTextField($model,'name',array(
                                'value' => $user->name,
                                'class' => 'form-control',
                                'id' => 'userName',
                                'placeholder' => Yii::t('users','placeholder.user.name')
                            )); ?>
                            <?php echo CHtml::error($model,'name',array(
                                'class' => 'help-block text-danger'
                            )); ?>
                            
                        </div>
                    </div>
                    <div class="form-group <?php if ($model->hasErrors('email')) echo('has-error'); ?>">
                        <?php echo CHtml::activeLabel($model,'email',array(
                            'for' => 'userEmail',
                            'class' => 'col-sm-2 control-label'
                        )); ?>
                        <div class="col-sm-10">
                            <?php echo CHtml::activeEmailField($model,'email',array(
                                'value' => $user->email,
                                'class' => 'form-control',
                                'id' => 'userEmail',
                                'placeholder' => Yii::t('users','placeholder.user.email')
                            )); ?>
                            <?php echo CHtml::error($model,'email',array(
                                'class' => 'help-block text-danger'
                            )); ?>
                        </div>
                    </div>
                    <div class="form-group <?php if ($model->hasErrors('password')) echo('has-error'); ?>">
                        <?php echo CHtml::activeLabel($model,'password',array(
                            'for' => 'userPassword',
                            'class' => 'col-sm-2 control-label'
                        )); ?>
                        <div class="col-sm-10">
                            <?php echo CHtml::activePasswordField($model,'password',array(
                                'class' => 'form-control',
                                'id' => 'userPassword',
                                'placeholder' => Yii::t('users','placeholder.user.password')
                            )); ?>
                            <?php echo CHtml::error($model,'password',array(
                                'class' => 'help-block text-danger'
                            )); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <div class="checkbox">
                                <label>
                                    <?php echo CHtml::activeCheckBox($model,'activated'); ?>
                                    <?php echo Yii::t('users','model.user.activated'); ?>
                                </label>
                            </div>
                            <div class="checkbox">
                                <label>
                                    <?php echo CHtml::activeCheckBox($model,'verified'); ?>
                                    <?php echo Yii::t('users','model.user.verified'); ?>
                                </label>
                            </div>
                            <div class="checkbox">
                                <label>
                                    <?php echo CHtml::activeCheckBox($model,'subscribed'); ?>
                                    <?php echo Yii::t('users','model.user.subscribed'); ?>
                                </label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group <?php if ($model->hasErrors('permissions')) echo('has-error'); ?>">
                        <?php echo CHtml::activeLabel($model,'permissions',array(
                            'for' => 'userPermissions',
                            'class' => 'col-sm-2 control-label'
                        )); ?>
                        <div class="col-sm-10">
                            <?php echo CHtml::activeDropDownList($model,'permissions',$dropDownList,array(
                                'multiple' => true,
                                'encode' => false,
                                'class' => 'form-control',
                                'options' => $dropDownListSelected,
                                'id' => 'userPermissions'
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