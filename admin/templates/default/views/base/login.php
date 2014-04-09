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
    
    <title>Bootstrap 101 Template</title>
    
    <link href="<?php echo $bootstrapCss; ?>" rel="stylesheet">
    <link href="<?php echo $template; ?>/stylesheet/css/theme.css" rel="stylesheet">

    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

  </head>
  <body>

    <!--<div class="navbar navbar-inverse navbar-static-top"  role="navigation">
        <div class="container-fluid">
            <div class="navbar-header">
                <a class="navbar-brand" href="#">YOnote ENGINE</a>
            </div>
        </div>
    </div>-->

    
    <div class="container page-center" style="height:100%;">
        
        <div class="row page-center-body">
            <div class="col-md-6 col-md-offset-3">
            
                <div class="panel panel-default">
                    <div class="panel-heading">Please login</div>
                    <div class="panel-body">
                        <form role="form" class="form-horizontal" method="POST">
                            <div class="form-group">
                                <div class="col-md-12">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-user"></span>
                                        </span>
                                        <input type="text" autocomplete="off" class="form-control" placeholder="Username or login" name="login[username]">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-12">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-lock"></span>
                                        </span>
                                        <input type="password" class="form-control" placeholder="Password" name="login[password]">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-12">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="login[rememberMe]"> Remember me
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary btn-block">Sign in</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                
            </div>
            
        </div>
        
    </div>
    
  </body>
</html>