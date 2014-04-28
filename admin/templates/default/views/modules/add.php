<div class="row">
    <div class="col-md-2">
       <div class="list-group">
          <a href="<?php echo $this->createUrl('index'); ?>" class="list-group-item"><?php echo Yii::t('modules','page.modules.title'); ?></a>
          <a href="<?php echo $this->createUrl('add'); ?>" class="list-group-item active"><?php echo Yii::t('modules','page.add.title'); ?></a>
      </div>
    </div>
    <div class="col-md-10">
        <div class="panel panel-default">
            
            <?php echo CHtml::form('','POST',array(
                'role' => 'form',
                'class' => 'form-horizontal',
                'enctype' => 'multipart/form-data'
            )); ?>
            
                <div class="panel-body"> 

                    <div class="form-group <?php if ($model->hasErrors('file')) echo('has-error'); ?>">
                        <?php echo CHtml::activeLabel($model,'file',array(
                            'for' => 'userName',
                            'class' => 'col-sm-2 control-label'
                        )); ?>
                        <div class="col-sm-10">
                            <?php echo CHtml::activeFileField($model,'file',array(
                                'class' => 'form-control',
                                'id' => 'userName'
                            )); ?>
                            <?php echo CHtml::error($model,'file',array(
                                'class' => 'help-block text-danger'
                            )); ?>

                        </div>
                    </div>

                </div>
                <div class="panel-footer">
                    <button type="submit" id="uploadSubmit" class="btn btn-primary"><?php echo Yii::t('system','app.submit'); ?></button>
                    <button type="reset" class="btn btn-default"><?php echo Yii::t('system','app.reset'); ?></button>
                </div>
            
            <?php Chtml::endForm(); ?>
            
        </div>
    </div>
</div>