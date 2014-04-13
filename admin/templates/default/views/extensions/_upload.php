<script type="text/javascript">
    $('#extensionUpload').uploadFile({
        progressContainer: '#uploadProgressContainer',
        progressBar: '#uploadProgressBar',
        disableObjects: ['#extensionFile','#uploadSubmit'],
        fileObjects: ['#extensionFile'],
        ajaxParam: 'extension-upload',
        errorContainer: '#uploadErrorContainer',
        successContainer: '#uploadSuccessContainer',
        reload: true
    });
</script>

<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title" id="ajaxModalLabel">Загрузить новое расширение</h4>
</div>

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
    <div class="modal-body">
        <p>
            
            <div class="progress progress-striped active" id="uploadProgressContainer">
                <div class="progress-bar"  role="progressbar" style="width: 0%" id="uploadProgressBar"></div>
            </div>


            <div class="form-group">
                <p class="text-danger" id="uploadErrorContainer"></p>
                <p class="text-success" id="uploadSuccessContainer"></p>
                <?php echo $form->labelEx($model,'extension',array(
                    'for' => 'extensionFile'
                )); ?>
                <?php echo $form->fileField($model,'extension',array(
                    'id' => 'extensionFile'
                )); ?>
            </div>

        </p>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
        <button type="submit" id="uploadSubmit" class="btn btn-primary">Отправить</button>
    </div>

<?php $this->endWidget(); ?>