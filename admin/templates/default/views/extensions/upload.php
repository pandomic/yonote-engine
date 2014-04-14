<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading clearfix">
                <a class="pull-right" href="<?php echo Yii::app()->createUrl('extensions/index'); ?>"><span class="glyphicon glyphicon-arrow-left"></span> Назад</a>
                <h3 class="panel-title">Загрузить новое расширение</h3>
            </div>
            <div class="panel-body"> 
                
                <?php $form = $this->beginWidget('CActiveForm',array(
                    'id' => 'extensionUpload',
                    'enableAjaxValidation' => false,
                    'enableClientValidation' => false,
                    'htmlOptions' => array(
                        'enctype' => 'multipart/form-data',
                        'method' => 'POST',
                        'role' => 'form'
                    )
                )); ?>
                
                    <?php echo $form->error($model,'extension',array(
                        'class' => 'alert alert-warning'
                    )); ?>
                
                    <div class="form-group">
                        <?php echo $form->labelEx($model,'extension',array(
                            'for' => 'extensionFile'
                        )); ?>
                        <?php echo $form->fileField($model,'extension',array(
                            'id' => 'extensionFile'
                        )); ?>
                    </div>
                    
                    <button type="submit" id="uploadSubmit" class="btn btn-primary">Отправить</button>
                    <button type="reset" class="btn btn-default">Сбросить</button>
                    
                <?php $this->endWidget(); ?>
                
            </div>
        </div>
    </div>
</div>