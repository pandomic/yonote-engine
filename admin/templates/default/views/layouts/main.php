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
    <script src="<?php echo $template; ?>/js/functions.js"></script>
    <script src="<?php echo $template; ?>/js/ui.js"></script>
    
    <title>Bootstrap 101 Template</title>
    
    <link href="<?php echo $bootstrapCss; ?>" rel="stylesheet">
    <link href="<?php echo $template; ?>/stylesheet/css/theme.css" rel="stylesheet">
    <link href="<?php echo $template; ?>/stylesheet/css/theme-extended.css" rel="stylesheet">

    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

  </head>
  <body>
      
    <div class="modal fade" id="confirm-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Подтвердите действие</h4>
                </div>
                <div class="modal-body">
                В результате произведения действия могут быть безвозвратно удалены или изменены некоторые данные. Вы уверены, что хотите продолжить?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Отмена</button>
                    <button type="button" class="btn btn-danger" id="confirm-modal-button">Продолжить</button>
                </div>
            </div>
        </div>
    </div>  
    
    <div class="navbar navbar-inverse navbar-static-top"  role="navigation">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-nav">
                    <span class="sr-only">Toggle sidebar</span>
                    <span class="glyphicon glyphicon-th"></span>
                </button>
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collection">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="glyphicon glyphicon-th-list"></span>
                </button>
                <a class="navbar-brand logo-nav" href="#"><img style="margin:-3px 10px 0 0; height:20px;" src="<?php echo $template; ?>/images/logo.gif"/>YOnote ENGINE</a>
            </div>
            <div class="collapse navbar-collapse navbar-collection">
                <ul class="nav navbar-nav navbar-left">
                    <li class="active"><a href="#">Dashboard</a></li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">YOnote <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li><a href="#">Licence</a></li>
                            <li><a href="#">Documentation</a></li>
                            <li><a href="#">Tutorials</a></li>
                            <li class="divider"></li>
                            <li><a href="#">Extensions</a></li>
                            <li class="divider"></li>
                            <li><a href="#">View YOnote on GitHub</a></li>
                        </ul>
                    </li>
                    <li><a href="#">Contacts</a></li>
                </ul>
                <div class="navbar-right">
                    <button type="button" class="btn btn-primary navbar-btn btn-xl hidden-sm hidden-xs">View web site</button>
                </div>
                <div class="navbar-right">
                    <ul class="nav navbar-nav navbar-left profile-navbar">
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle dropdown-profile" data-toggle="dropdown">
                                <span>
                                    <img class="img-rounded" src="<?php echo $template; ?>/images/user.jpg" >
                                    <span>Iwan Raven <span class="badge blue-badge">10</span> <b class="caret"></b></span>
                                </span>
                            </a>
                            <ul class="dropdown-menu profile-box">
                                <li class="avatar">
                                    <img class="img-circle img-thumbnail" src="<?php echo $template; ?>/images/user.jpg">
                                    <div class="text-center" >
                                        <h4>Iwan Raven</h4>
                                    </div>
                                </li>
                                <li class="divider"></li>
                                <li><a href="#"><span class="glyphicon glyphicon-user"></span> Profile</a></li>
                                <li><a href="#"><span class="glyphicon glyphicon-cog"></span>Settings</a></li>
                                <li><a href="#"><span class="glyphicon glyphicon-envelope"></span><span class="badge pull-right blue-badge">10</span>Messages</a></li>
                                <li><a href="#"><span class="glyphicon glyphicon-off"></span>Logout</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
                
                
                
            </div>
        </div>
    </div>
    <div class="sidebar-bg hidden-xs"></div>
    
    <div class="sidebar">
        <ul class="nav navbar-collapse collapse sidebar-nav" id="accordion">
            <li class="active">
                <span class="glow"></span>
                <a href="#"><span class="glyphicon glyphicon-home"></span> Рабочий стол</a>
            </li>
            <li>
                <span class="glow"></span>
                <a href="#" data-toggle="collapse" data-parent="#accordion" data-target="#collapseOne" href="#"><span class="glyphicon glyphicon-asterisk"></span> Система</a>
                <ul class="nav collapse" id="collapseOne">
                    <li><a href="/admin/extensions"><span class="glyphicon glyphicon-home"></span> Расширения</a></li>
                    <li><a href="#"><span class="glyphicon glyphicon-home"></span> Виджеты</a></li>
                </ul>
            </li>
            <li>
                <span class="glow"></span>
                <a href="#" data-toggle="collapse" data-parent="#accordion" data-target="#collapseTwo" href="#collapseTwo"><span class="glyphicon glyphicon-file"></span> OPen</a>
                <ul class="nav collapse" id="collapseTwo">
                    <li><a href="#">1</a></li>
                    <li><a href="#">2</a></li>
                </ul>
            </li>
        </ul>
    </div>
    
    <div class="dashboard">
        <div class="container-fluid">
            <div class="row">
                <div class="dashboard-header clearfix">
                    <div class="header pull-left">
                        <?php echo $this->pageTitle; ?>
                    </div>
                </div>
            </div>
            <div class="row dashboard-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <?php echo $this->breadcrumbs; ?>
                        </div>
                    </div>
                    <?php echo $content; ?>
                    
                </div>
            </div>
        </div>
    </div>
    
    
  </body>
</html>