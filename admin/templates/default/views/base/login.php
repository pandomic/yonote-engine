<?php
/**
 * Administrative panel login page template.
 * 
 * @author Vlad Gramuzov <vlad.gramuzov@gmail.com>
 * @link http://yonote.org
 * @copyright 2014 Vlad Gramuzov
 * @license http://yonote.org/license.html
 */
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title><?php echo $this->pageTitle; ?></title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex,nofollow">
    <link href="<?php echo $this->templateAsset('assets'); ?>/stylesheet/css/bootstrap.css" rel="stylesheet">
    <link href="<?php echo $this->templateAsset('assets'); ?>/stylesheet/css/theme.css" rel="stylesheet">
    <link href="<?php echo $this->templateAsset('assets'); ?>/stylesheet/css/theme-extended.css" rel="stylesheet">
    <link href="<?php echo $this->templateAsset('assets'); ?>/stylesheet/css/loadmeter.css" rel="stylesheet">
    <script src="<?php echo $this->asset('application.vendors.jquery'); ?>/jquery.js"></script>
    <script src="<?php echo $this->asset('application.vendors.bootstrap'); ?>/js/bootstrap.js"></script>
    <link rel="shortcut icon" href="<?php echo $this->templateAsset('assets'); ?>/images/logo.gif">
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
    <div class="container page-center">
        <div class="row page-center-body">
            <div class="col-md-6 col-md-offset-3">
                <div class="panel panel-default">
                    <div class="panel-heading"><?php echo Yii::t('login','label.login'); ?></div>
                    <div class="panel-body">
                        <?php echo CHtml::form('','POST',array('role' => 'form','class' => 'form-horizontal')); ?>
                            <div class="form-group">
                                <div class="col-md-12">
                                    <div class="input-group <?php if ($model->hasErrors('name')) echo('has-error'); ?>">
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-user"></span>
                                        </span>
                                        <?php echo CHtml::activeTextField($model,'name',array(
                                            'autocomplete' => 'off',
                                            'class' => 'form-control',
                                            'placeholder' => Yii::t('login','placeholder.username')
                                        )); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-12">
                                    <div class="input-group <?php if ($model->hasErrors('password')) echo('has-error'); ?>">
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-lock"></span>
                                        </span>
                                        <?php echo CHtml::activePasswordField($model,'password',array(
                                            'class' => 'form-control',
                                            'placeholder' => Yii::t('login','placeholder.password')
                                        )); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-12">
                                    <div class="checkbox">
                                        <label>
                                            <?php echo CHtml::activeCheckBox($model,'rememberMe'); echo Yii::t('login','label.remember') ?>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary btn-block"><?php echo Yii::t('login','button.login'); ?></button>
                                </div>
                            </div>
                        <?php echo CHtml::endForm(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
  </body>
</html>