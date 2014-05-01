<?php $template = Yii::app()->request->baseUrl; ?>
<!DOCTYPE html>
<html>
    <head>
        <script type="text/javascript" src="<?php echo $template; ?>/js/jquery.min.js"></script>
        <script type="text/javascript" src="<?php echo $template; ?>/js/bootstrap.min.js"></script>
        <link rel="stylesheet" type="text/css" href="<?php echo $template; ?>/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="<?php echo $template; ?>/css/bootstrap-theme.min.css">
    </head>
    <body>
        <div class="container">
            <div class="row">
                <h1 class="text-center">YOnote ENGINE <span class="badge">installation</span></h1>
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <?php echo $content; ?>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>