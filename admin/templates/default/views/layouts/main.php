<?php
$template = Yii::app()->request->baseUrl.'/templates/'.Yii::app()->getTheme()->name;
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="<?php echo $template; ?>/js/bootstrap.min.js"></script>
    
    <title>Yonote ENGINE</title>

    <link href="<?php echo $template; ?>/css/bootstrap-theme.css" rel="stylesheet">

    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

  </head>
  <body>

    <div class="navbar navbar-inverse navbar-static-top"  role="navigation">
        <div class="container-fluid">
            <div class="navbar-header">
                <a class="navbar-brand logo-nav" href="#"><img style="margin:-3px 10px 0 0; height:20px;" src="<?php echo $template; ?>/images/logo.gif"/>YOnote ENGINE</a>
            </div>
        </div>
    </div>

    <div class="sidebar">
        
    </div>
    
    
  </body>
</html>