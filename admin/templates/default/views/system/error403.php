<?php
// Template path
$template = Yii::app()->request->baseUrl.'/templates/'.Yii::app()->getTheme()->name;
// jQuery .js asset path
$jQueryJS = Yii::app()->assetManager->publish(
    Yii::getPathOfAlias('application.vendors.jquery').'/jquery.js'
);
// Bootstrap .css asset path
$bootstrapCss = Yii::app()->assetManager->publish(
    Yii::getPathOfAlias('application.vendors.bootstrap.css').'/bootstrap.css'
);
// Boostrap .js asset path
$bootstrapJS = Yii::app()->assetManager->publish(
    Yii::getPathOfAlias('application.vendors.bootstrap.js').'/bootstrap.js'
);
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <script src="<?php echo $jQueryJS; ?>"></script>
    <script src="<?php echo $bootstrapJS; ?>"></script>
    
    <title><?php echo Yii::t('system','error.403.title'); ?></title>
    
    <link href="<?php echo $bootstrapCss; ?>" rel="stylesheet">
    <link href="<?php echo $template; ?>/stylesheet/css/theme.css" rel="stylesheet">
    <link href="<?php echo $template; ?>/stylesheet/css/theme-extended.css" rel="stylesheet">

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
                        <h1><?php echo Yii::t('system','error.403.title'); ?></h1>
                        <p class="text-muted"><?php echo Yii::t('system','error.403.description'); ?></p>
                        <a href="<?php echo Yii::app()->urlManager->createUrl('base/index'); ?>" class="btn btn-primary">Back to dashboard</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
  </body>
</html>