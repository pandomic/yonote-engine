<?php
/**
 * Administrative panel common layout wrapper.
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
    <script src="<?php echo $this->asset('application.vendors.easypie'); ?>/easypie.js"></script>
    <script src="<?php echo $this->asset('application.vendors.bootstrap'); ?>/js/bootstrap.js"></script>
    <script src="<?php echo $this->templateAsset('assets'); ?>/js/functions.js"></script>
    <script src="<?php echo $this->templateAsset('assets'); ?>/js/ui.js"></script>
    <link rel="shortcut icon" href="<?php echo $this->templateAsset('assets'); ?>/images/logo.gif">
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
                    <h4 class="modal-title" id="myModalLabel"><?php echo Yii::t('system','message.confirm.title'); ?></h4>
                </div>
                <div class="modal-body">
                    <?php echo Yii::t('system','message.confirm.text'); ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo Yii::t('system','app.cancel'); ?></button>
                    <button type="button" class="btn btn-danger" id="confirm-modal-button"><?php echo Yii::t('system','app.continue'); ?></button>
                </div>
            </div>
        </div>
    </div>  
    <div class="navbar navbar-inverse navbar-static-top"  role="navigation">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-nav">
                    <span class="sr-only"><?php echo Yii::t('system','message.toggle.navigation'); ?></span>
                    <span class="glyphicon glyphicon-th"></span>
                </button>
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collection">
                    <span class="sr-only"><?php echo Yii::t('system','message.toggle.navigation'); ?></span>
                    <span class="glyphicon glyphicon-th-list"></span>
                </button>
                <a class="navbar-brand logo-nav" href="<?php echo $this->createUrl('/base'); ?>"><img style="margin:-3px 10px 0 0; height:20px;" src="<?php echo $this->templateAsset('assets'); ?>/images/logo.gif"/>YOnote ENGINE</a>
            </div>
            <div class="collapse navbar-collapse navbar-collection">
                <ul class="nav navbar-nav navbar-left">
                    <li <?php if ($this->getId() == 'base') : ?>class="active"<?php endif; ?>><a href="<?php echo $this->createUrl('/base'); ?>"><?php echo Yii::t('dashboard','main'); ?></a></li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo Yii::t('dashboard','yonote'); ?> <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li><a href="#"><?php echo Yii::t('dashboard','yonote.licence'); ?></a></li>
                            <li><a href="#"><?php echo Yii::t('dashboard','yonote.docs'); ?></a></li>
                            <li><a href="#"><?php echo Yii::t('dashboard','yonote.tutorials'); ?></a></li>
                            <li class="divider"></li>
                            <li><a href="#"><?php echo Yii::t('dashboard','yonote.extensions'); ?></a></li>
                            <li class="divider"></li>
                            <li><a href="#"><?php echo Yii::t('dashboard','yonote.github'); ?></a></li>
                        </ul>
                    </li>
                    <li><a href="#"><?php echo Yii::t('dashboard','yonote.contacts'); ?></a></li>
                </ul>
                <div class="navbar-right">
                    <a href="/" target="_blank" class="btn btn-primary navbar-btn btn-xl hidden-sm hidden-xs"><?php echo Yii::t('dashboard','website'); ?></a>
                </div>
                <?php $w = $this->beginWidget('UserWidget'); ?>
                    <div class="navbar-right">
                        <ul class="nav navbar-nav navbar-left profile-navbar">
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle dropdown-profile" data-toggle="dropdown">
                                    <span>
                                        <img class="img-rounded" src="<?php if ($w->getPhoto() !== false): echo '/'.$w->getPhoto(); else: echo $this->templateAsset('assets'); ?>/images/user.jpg<?php endif; ?>">
                                        <span><?php if ($w->getProfile()->name != null) echo $w->getProfile()->name; else echo $w->getUser()->name; ?> <?php if ($w->getUnreadCount() > 0): ?><span class="badge blue-badge"><?php echo $w->getUnreadCount(); ?></span><?php endif; ?> <b class="caret"></b></span>
                                    </span>
                                </a>
                                <ul class="dropdown-menu profile-box">
                                    <li class="avatar">
                                        <img class="img-circle img-thumbnail" src="<?php if ($w->getPhoto() !== false): echo '/'.$w->getPhoto(); else: echo $this->templateAsset('assets'); ?>/images/user.jpg<?php endif; ?>">
                                        <div class="text-center" >
                                            <h4><?php if ($w->getProfile()->name != null) echo $w->getProfile()->name; else echo $w->getUser()->name; ?></h4>
                                        </div>
                                    </li>
                                    <li class="divider"></li>
                                    <li><a href="<?php echo $this->createUrl('/users/profile',array('id' => $w->getUser()->name)); ?>"><span class="glyphicon glyphicon-user"></span> <?php echo Yii::t('dashboard','user.profile'); ?></a></li>
                                    <li><a href="<?php echo $this->createUrl('/users/edit',array('id' => $w->getUser()->name)); ?>"><span class="glyphicon glyphicon-cog"></span> <?php echo Yii::t('dashboard','user.settings'); ?></a></li>
                                    <li><a href="<?php echo $this->createUrl('/pm'); ?>"><span class="glyphicon glyphicon-envelope"></span><?php if ($w->getUnreadCount() > 0): ?><span class="badge pull-right blue-badge"><?php echo $w->getUnreadCount(); ?></span><?php endif; ?> <?php echo Yii::t('dashboard','user.messages'); ?></a></li>
                                    <li><a href="<?php echo $this->createUrl('/base/logout'); ?>"><span class="glyphicon glyphicon-off"></span> <?php echo Yii::t('dashboard','user.logout'); ?></a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                <?php $this->endWidget(); ?>
            </div>
        </div>
    </div>
    <div class="sidebar-bg hidden-xs hidden-sm"></div>
    <div class="sidebar">
        <ul class="nav navbar-collapse collapse sidebar-nav" id="accordion">
            <li <?php if ($this->getId() == 'base') : ?>class="active"<?php endif; ?>>
                <span class="glow"></span>
                <a href="<?php echo $this->createUrl('/base'); ?>"><span class="glyphicon glyphicon-home"></span> <?php echo Yii::t('dashboard','main'); ?></a>
            </li>
            <li <?php if ($this->getId() == 'pm') : ?>class="active"<?php endif; ?>>
                <span class="glow"></span>
                <a href="<?php echo $this->createUrl('/pm'); ?>"><span class="glyphicon glyphicon-envelope"></span> <?php echo Yii::t('dashboard','messages'); ?></a>
            </li>
            <li <?php if ($this->getId() == 'users' || $this->getId() == 'roles') : ?>class="active"<?php endif; ?>>
                <span class="glow"></span>
                <a href="#" data-toggle="collapse" data-parent="#accordion" data-target="#collapseOne"><span class="glyphicon glyphicon-user"></span> <?php echo Yii::t('dashboard','users'); ?></a>
                <ul class="nav collapse" id="collapseOne">
                    <li><a href="<?php echo $this->createUrl('/users/index'); ?>"><span class="glyphicon glyphicon-user"></span> <?php echo Yii::t('dashboard','users'); ?></a></li>
                    <li><a href="<?php echo $this->createUrl('/roles/index'); ?>"><span class="glyphicon glyphicon-lock"></span> <?php echo Yii::t('dashboard','users.roles'); ?></a></li>
                    <li><a href="<?php echo $this->createUrl('/users/settings'); ?>"><span class="glyphicon glyphicon-cog"></span> <?php echo Yii::t('dashboard','users.settings'); ?></a></li>
                </ul>
            </li>
            <li <?php if ($this->getId() == 'modules' || $this->getId() == 'settings') : ?>class="active"<?php endif; ?>>
                <span class="glow"></span>
                <a href="#" data-toggle="collapse" data-parent="#accordion" data-target="#collapseTwo" href="#"><span class="glyphicon glyphicon-cog"></span> <?php echo Yii::t('dashboard','system'); ?></a>
                <ul class="nav collapse" id="collapseTwo">
                    <li><a href="<?php echo $this->createUrl('/mods'); ?>"><span class="glyphicon glyphicon-th-large"></span> <?php echo Yii::t('dashboard','system.modules'); ?></a></li>
                    <li><a href="<?php echo $this->createUrl('/settings'); ?>"><span class="glyphicon glyphicon-cog"></span> <?php echo Yii::t('dashboard','system.settings'); ?></a></li>
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
                            <?php $this->widget('BreadcrumbsWidget',array(
                                'links' => $this->pathsQueue
                            )); ?>
                        </div>
                    </div>
                    <?php echo $content; ?>
                </div>
            </div>
        </div>
    </div>
  </body>
</html>