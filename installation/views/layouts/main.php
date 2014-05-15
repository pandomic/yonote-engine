<?php $template = Yii::app()->request->baseUrl; ?>
<!DOCTYPE html>
<html>
    <head>
        <title><?php echo Yii::t('installation','title'); ?></title>
        <script type="text/javascript" src="<?php echo $template; ?>/js/jquery.min.js"></script>
        <script type="text/javascript" src="<?php echo $template; ?>/js/bootstrap.min.js"></script>
        <link rel="stylesheet" type="text/css" href="<?php echo $template; ?>/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="<?php echo $template; ?>/css/bootstrap-theme.min.css">
    </head>
    <body>
        <div class="container">
            <div class="row">
                <h1 class="text-center"><strong>YO</strong>note ENGINE</h1>
                <div class="col-md-6 col-md-offset-3">
                    <div class="panel panel-default">
                        <?php echo $content; ?>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>