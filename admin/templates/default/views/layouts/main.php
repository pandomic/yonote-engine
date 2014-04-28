<?php
// Template path
$template = Yii::app()->request->baseUrl.'/templates/'.Yii::app()->getTheme()->name;
// jQuery .js asset path
$jQueryJS = Yii::app()->assetManager->publish(
    Yii::getPathOfAlias('application.vendors.jquery').'/jquery.js'
);
// Easypie .js path
$easypieJS = Yii::app()->assetManager->publish(
    Yii::getPathOfAlias('application.vendors.easypie').'/easypie.js'
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
    <script src="<?php echo $easypieJS; ?>"></script>
    <script src="<?php echo $bootstrapJS; ?>"></script>
    <script src="<?php echo $template; ?>/js/functions.js"></script>
    <script src="<?php echo $template; ?>/js/ui.js"></script>
    
    <title><?php echo $this->pageTitle; ?></title>
    
    <link rel="shortcut icon" href="<?php echo $template; ?>/images/logo.gif">
    <link href="<?php echo $bootstrapCss; ?>" rel="stylesheet">
    <link href="<?php echo $template; ?>/stylesheet/css/theme.css" rel="stylesheet">
    <link href="<?php echo $template; ?>/stylesheet/css/theme-extended.css" rel="stylesheet">
    <link href="<?php echo $template; ?>/stylesheet/css/loadmeter.css" rel="stylesheet">

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
                    <h4 class="modal-title" id="myModalLabel"><?php echo Yii::t('system','Confirm your action'); ?></h4>
                </div>
                <div class="modal-body">
                    <?php echo Yii::t('system','With continued implementation of the selected action some data can be permanently deleted or changed. Are you sure you want to continue?'); ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo Yii::t('system','Cancel'); ?></button>
                    <button type="button" class="btn btn-danger" id="confirm-modal-button"><?php echo Yii::t('system','Continue'); ?></button>
                </div>
            </div>
        </div>
    </div>  
    
    <div class="navbar navbar-inverse navbar-static-top"  role="navigation">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-nav">
                    <span class="sr-only"><?php echo Yii::t('system','Toggle navigation element'); ?></span>
                    <span class="glyphicon glyphicon-th"></span>
                </button>
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collection">
                    <span class="sr-only"><?php echo Yii::t('system','Toggle navigation element'); ?></span>
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
                    <a href="/" target="_blank" class="btn btn-primary navbar-btn btn-xl hidden-sm hidden-xs">View web site</a>
                </div>
                <?php $w = $this->beginWidget('UserWidget'); ?>
                    <div class="navbar-right">
                        <ul class="nav navbar-nav navbar-left profile-navbar">
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle dropdown-profile" data-toggle="dropdown">
                                    <span>
                                        <img class="img-rounded" src="<?php if ($w->getPhoto() !== false): echo '/'.$w->getPhoto(); else: echo $template; ?>/images/user.jpg<?php endif; ?>">
                                        <span><?php if ($w->getProfile()->name != null) echo $w->getProfile()->name; else echo $w->getUser()->name; ?> <?php if ($w->getUnreadCount() > 0): ?><span class="badge blue-badge"><?php echo $w->getUnreadCount(); ?></span><?php endif; ?> <b class="caret"></b></span>
                                    </span>
                                </a>
                                <ul class="dropdown-menu profile-box">
                                    <li class="avatar">
                                        <img class="img-circle img-thumbnail" src="<?php if ($w->getPhoto() !== false): echo '/'.$w->getPhoto(); else: echo $template; ?>/images/user.jpg<?php endif; ?>">
                                        <div class="text-center" >
                                            <h4><?php if ($w->getProfile()->name != null) echo $w->getProfile()->name; else echo $w->getUser()->name; ?></h4>
                                        </div>
                                    </li>
                                    <li class="divider"></li>
                                    <li><a href="<?php echo $this->createUrl('/users/profile',array('id' => $w->getUser()->name)); ?>"><span class="glyphicon glyphicon-user"></span> Profile</a></li>
                                    <li><a href="<?php echo $this->createUrl('/users/edit',array('id' => $w->getUser()->name)); ?>"><span class="glyphicon glyphicon-cog"></span> Settings</a></li>
                                    <li><a href="<?php echo $this->createUrl('/pm'); ?>"><span class="glyphicon glyphicon-envelope"></span><?php if ($w->getUnreadCount() > 0): ?><span class="badge pull-right blue-badge"><?php echo $w->getUnreadCount(); ?></span><?php endif; ?>Messages</a></li>
                                    <li><a href="<?php echo $this->createUrl('/base/logout'); ?>"><span class="glyphicon glyphicon-off"></span>Logout</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                <?php $this->endWidget(); ?>
                
                
            </div>
        </div>
    </div>
    <div class="sidebar-bg hidden-xs"></div>
    
    <div class="sidebar">
        <ul class="nav navbar-collapse collapse sidebar-nav" id="accordion">
            <li class="active">
                <span class="glow"></span>
                <a href="/admin"><span class="glyphicon glyphicon-home"></span> Рабочий стол</a>
            </li>
            <li>
                <span class="glow"></span>
                <a href="<?php echo $this->createUrl('/pm'); ?>"><span class="glyphicon glyphicon-envelope"></span> Сообщения</a>
            </li>
            <li>
                <span class="glow"></span>
                <a href="#" data-toggle="collapse" data-parent="#accordion" data-target="#collapseOne"><span class="glyphicon glyphicon-user"></span> Пользователи</a>
                <ul class="nav collapse" id="collapseOne">
                    <li><a href="<?php echo $this->createUrl('/users/index'); ?>"><span class="glyphicon glyphicon-user"></span> Пользователи</a></li>
                    <li><a href="<?php echo $this->createUrl('/roles/index'); ?>"><span class="glyphicon glyphicon-lock"></span> Роли</a></li>
                    <li><a href="<?php echo $this->createUrl('/users/settings'); ?>"><span class="glyphicon glyphicon-cog"></span> Настройки</a></li>
                </ul>
            </li>
            <li>
                <span class="glow"></span>
                <a href="#" data-toggle="collapse" data-parent="#accordion" data-target="#collapseTwo" href="#"><span class="glyphicon glyphicon-cog"></span> Система</a>
                <ul class="nav collapse" id="collapseTwo">
                    <li><a href="<?php echo $this->createUrl('/modules'); ?>"><span class="glyphicon glyphicon-th-large"></span> Модули</a></li>
                    <li><a href="<?php echo $this->createUrl('/settings'); ?>"><span class="glyphicon glyphicon-cog"></span> Настройки</a></li>
                </ul>
            </li>
        </ul>
        <?php $this->widget('admin.modules.loadmeter.components.widgets.LoadMeterWidget'); ?>
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