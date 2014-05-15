<div class="panel-heading">
    <h3 class="panel-title"><?php echo Yii::t('installation','label.step',array('{current}' => 1,'{all}' => 3)); ?></h3>
</div>
<form role="form" class="form-horizontal" method="POST">
    <div class="panel-body">
        <div class="row">
            <div class="col-md-12">
                <p><img width="100%" src="/installation/images/ye_powered.png" alt="YOnote ENGINE CMS" /></p>
                <p class="text-justify">
                    <?php echo Yii::t('installation','model.firststep.welcome'); ?>
                </p>
            </div>
        </div>

        <h4><?php echo $model->getAttributeLabel('insLang'); ?></h4>
        <label for="insLanguage" class="sr-only"><?php echo $model->getAttributeLabel('insLang'); ?></label>
        <?php echo CHtml::activeDropDownList($model,'insLang',$model->getInstallationLanguages(),array(
            'class' => 'form-control',
            'id' => 'insLanguage'
        )); ?>

    </div>
    <div class="panel-footer">
        <button type="submit" class="btn btn-primary"><?php echo Yii::t('installation','button.firststep.submit'); ?></button>
    </div>
</form>