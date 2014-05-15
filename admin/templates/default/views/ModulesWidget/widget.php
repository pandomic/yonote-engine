<?php
/**
 * Modules list widget.
 *
 * @author Vlad Gramuzov <vlad.gramuzov@gmail.com>
 * @link http://yonote.org
 * @copyright 2014 Vlad Gramuzov
 * @license http://yonote.org/license.html
 */
?>
<?php if (count($models) > 0): ?>
    <div class="row">
        <?php foreach ($models as $model): ?>
        <div class="col-md-4">
        <div class="thumbnail">
          <div class="caption">
              <h3><?php echo $model->title; ?></h3>
              <p><?php echo $model->description; ?></p>
              <p><a href="<?php echo $this->controller->createUrl('/'.$model->name); ?>" class="btn btn-primary" role="button"><?php echo Yii::t('modules','label.module.goto'); ?></a> <a href="<?php echo $this->controller->createUrl('/modules/info',array('id' => $model->name)); ?>" class="btn btn-default" role="button"><?php echo Yii::t('modules','label.module.info.view'); ?></a></p>
          </div>
        </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>