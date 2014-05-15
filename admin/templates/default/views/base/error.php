<?php
/**
 * Error template.
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
    <title><?php echo Yii::t('system','error.title',array('{error}' => $error['code'])); ?></title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="<?php echo $this->asset('application.vendors.bootstrap'); ?>/css/bootstrap.css" rel="stylesheet">
    <link href="<?php echo $this->templateAsset('assets'); ?>/stylesheet/css/theme.css" rel="stylesheet">
    <link href="<?php echo $this->templateAsset('assets'); ?>/stylesheet/css/theme-extended.css" rel="stylesheet">
    <script src="<?php echo $this->asset('application.vendors.jquery'); ?>/jquery.js"></script>
    <script src="<?php echo $this->asset('application.vendors.bootstrap'); ?>/js/bootstrap.js"></script>
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
    <div class="container page-center" style="height:100%;">
        <div class="row page-center-body">
            <div class="col-md-6 col-md-offset-3 text-center">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <h1><?php echo Yii::t('system','error.title',array('{error}' => $error['code'])); ?></h1>
                        <p class="text-muted"><?php echo nl2br(CHtml::encode($error['message'])); ?></p>
                        <a href="<?php echo Yii::app()->urlManager->createUrl('base/index'); ?>" class="btn btn-primary"><?php echo Yii::t('system','back.dashboard'); ?></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
  </body>
</html>