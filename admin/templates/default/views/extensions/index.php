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

<div class="modal fade" id="ajaxModal" tabindex="-1" role="dialog" aria-labelledby="ajaxModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content"></div>
    </div>
</div>

<?php if (Yii::app()->user->hasFlash('extensionsSuccess')): ?>
    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <?php echo Yii::app()->user->getFlash('extensionsSuccess'); ?>
            </div>
        </div>
    </div>
<?php endif; ?>

<?php if (Yii::app()->user->hasFlash('extensionsWarning')): ?>
    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-warning">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <?php echo Yii::app()->user->getFlash('extensionsWarning'); ?>
            </div>
        </div>
    </div>
<?php endif; ?>

<div class="row">
    <div class="col-lg-6 col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading clearfix">
                <button data-toggle="modal" data-target="#ajaxModal" data-remote="<?php echo Yii::app()->createUrl('extensions/upload',array('ajax' => 'upload-required')); ?>" class="btn btn-primary btn-xs pull-right"><span class="glyphicon glyphicon-plus"></span> Добавить расширение</button>
                <h3 class="panel-title">Расширения <span class="label label-primary"><?php echo count($extensions); ?></span></h3>
            </div>
            <div class="panel-body"> 
                
                <?php if (count($extensions) > 0): ?>
                    
                    <?php echo CHtml::form(Yii::app()->createUrl('extensions/delete'),'POST',array(
                        'role' => 'form',
                        'id' => 'extensionsForm'
                    )); ?>
                        
                        <table class="table table-striped table-hover table-middle table-responsive">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Название</th>
                                    <th>Автор</th>
                                    <th>
                                        <div class="btn-group" data-toggle="buttons">
                                            <label class="btn btn-default ">
                                                <input type="checkbox" onchange="$(this).autoCheck();"> Выделить
                                            </label>
                                        </div>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php foreach ($extensions as $extension): ?>

                                    <tr>
                                        <td>
                                            <a href="#" data-toggle="modal" data-target="#ajaxModal" data-remote="<?php echo Yii::app()->createUrl('extensions/info',array('e' => $extension->name,'ajax' => 'info-requred')); ?>">
                                                <?php echo $extension->name; ?>
                                            </a>
                                        </td>
                                        <td>
                                            <?php echo $extension->title; ?>
                                        </td>
                                        <td>
                                            <?php echo $extension->author; ?>
                                        </td>
                                        <td>
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" name="select[]" value="<?php echo $extension->name; ?>"> <?php echo Yii::t('system','Select'); ?>
                                                </label>
                                            </div>
                                        </td>
                                    </tr>

                                <?php endforeach; ?>

                            </tbody>
                        </table>
                        
                        <button type="button" class="btn btn-danger" onclick="$(this).confirmModal();" data-action="$('#extensionsForm').submit();"><?php echo Yii::t('system','Remove selected'); ?></button>
                        <button type="reset" class="btn btn-default"><?php echo Yii::t('system','Reset'); ?></button>
                        
                    <?php echo CHtml::endForm(); ?>
                <?php else: ?>
                    
                    <div class="alert alert-warning">
                        <?php echo Yii::t('extensions','There are no extensions here.'); ?>
                    </div>
                    
                <?php endif; ?>
                    
            </div>
        </div>
    </div>
    <div class="col-lg-6 col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading clearfix">
                <h3 class="panel-title"><?php echo Yii::t('system','Modules'); ?> <span class="label label-primary"><?php echo count($modules); ?></span></h3>
            </div>
            <div class="panel-body">
                
                <?php if (count($modules) > 0): ?>
                
                    <?php echo CHtml::form(Yii::app()->createUrl('extensions/modstate'),'POST',array(
                        'role' => 'form'
                    )); ?>
                        
                        <input type="hidden" id="modAction" name="action" value="enable">
                        
                        <table class="table table-striped table-hover table-middle table-responsive">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th><?php echo Yii::t('system','Name'); ?></th>
                                    <th><?php echo Yii::t('system','Extension'); ?></th>
                                    <th><?php echo Yii::t('system','Status'); ?></th>
                                    <th>
                                        <div class="btn-group" data-toggle="buttons">
                                            <label class="btn btn-default ">
                                                <input type="checkbox" onchange="$(this).autoCheck();"> <?php echo Yii::t('system','Select'); ?>
                                            </label>
                                        </div>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php foreach ($modules as $module): ?>

                                    <tr>
                                        <td>
                                            <?php echo $module->name; ?>
                                        </td>
                                        <td>
                                            <?php echo $module->title; ?>
                                        </td>
                                        <td>
                                            <a href="#" data-toggle="modal" data-target="#ajaxModal" data-remote="<?php echo Yii::app()->createUrl('extensions/info',array('e' => $module->extension,'ajax' => 'info-requred')); ?>">
                                                <?php echo $module->extension; ?>
                                            </a>
                                        </td>
                                        <td>
                                            <?php if ((bool) $module->installed): ?>
                                                <span class="label label-success"><?php echo Yii::t('system','Enabled'); ?></span>
                                            <?php else: ?>
                                                <span class="label label-danger"><?php echo Yii::t('system','Disabled'); ?></span>
                                            <?php endif; ?>
                                        <td>
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" name="select[]" value="<?php echo $module->name; ?>"> <?php echo Yii::t('system','Select'); ?>
                                                </label>
                                            </div>
                                        </td>
                                    </tr>

                                <?php endforeach; ?>

                            </tbody>
                        </table>

                        <div class="btn-group">
                            <button type="submit" class="btn btn-primary"><?php echo Yii::t('system','Perform the action'); ?></button>
                            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                                <span class="caret"></span>
                                <span class="sr-only"><?php echo Yii::t('system','Perform the action'); ?></span>
                            </button>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="#" onclick="$('#modAction').attr('value','enable');"><?php echo Yii::t('system','Enable'); ?></a></li>
                                <li><a href="#" onclick="$('#modAction').attr('value','disable');"><?php echo Yii::t('system','Disable'); ?></a></li>
                            </ul>
                        </div>

                        <button type="reset" class="btn btn-default"><?php echo Yii::t('system','Reset'); ?></button>
                    
                    <?php echo CHtml::endForm(); ?>
                        
                <?php else: ?>
                    
                    <div class="alert alert-warning">
                        <?php echo Yii::t('extensions','There are no modules here.'); ?>
                    </div>
                
                <?php endif; ?>
                
            </div>
        </div>
    </div>
</div>

<div class="row">
    
    <div class="col-lg-6 col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading clearfix">
                <h3 class="panel-title"><?php echo Yii::t('system','Widgets'); ?> <span class="label label-primary"><?php echo count($widgets); ?></span></h3>
            </div>
            <div class="panel-body">
                
                <?php if (count($widgets) > 0): ?>
                
                    <table class="table table-striped table-hover table-middle">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th><?php echo Yii::t('system','Name'); ?></th>
                                <th><?php echo Yii::t('system','Extension'); ?></th>
                                <th><?php echo Yii::t('system','Class'); ?></th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php foreach ($widgets as $widget): ?>

                                <tr>
                                    <td>
                                        <?php echo $widget->name; ?>
                                    </td>
                                    <td>
                                        <?php echo $widget->title; ?>
                                    </td>
                                    <td>
                                        <a href="#" data-toggle="modal" data-target="#ajaxModal" data-remote="<?php echo Yii::app()->createUrl('extensions/info',array('e' => $widget->extension,'ajax' => 'info-requred')); ?>">
                                            <?php echo $widget->extension; ?>
                                        </a>
                                    </td>
                                    <td>
                                        <?php echo $widget->classPath; ?>
                                    </td>
                                </tr>

                            <?php endforeach; ?>

                        </tbody>
                    </table>
                
                <?php else: ?>
                
                    <div class="alert alert-warning">
                        <?php echo Yii::t('extensions','There are no widgets here.'); ?>
                    </div>
                
                <?php endif; ?>
                
            </div>
        </div>
    </div>
    <div class="col-lg-6 col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading clearfix">
                <h3 class="panel-title"><?php echo Yii::t('system','Templates'); ?> <span class="label label-primary"><?php echo count($templates); ?></span></h3>
            </div>
            <div class="panel-body">        
                
                <?php if(count($templates) > 0): ?>
                
                <table class="table table-striped table-hover table-middle">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th><?php echo Yii::t('system','Extension'); ?></th>
                            <th><?php echo Yii::t('system','By default'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        
                        <?php foreach ($templates as $template): ?>
                        
                            <tr>
                                <td>
                                    <?php echo $template->name; ?>
                                </td>
                                <td>
                                    <a href="#" data-toggle="modal" data-target="#ajaxModal" data-remote="<?php echo Yii::app()->createUrl('extensions/info',array('e' => $template->extension,'ajax' => 'info-requred')); ?>">
                                        <?php echo $template->extension; ?>
                                    </a>
                                </td>
                                <td>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="default"> <?php echo Yii::t('system','By default'); ?>
                                        </label>
                                    </div>
                                </td>
                            </tr>
                        
                        <?php endforeach; ?>
                        
                    </tbody>
                </table>
                
                <button type="button" class="btn btn-primary"><?php echo Yii::t('system','Save'); ?></button>
                <button type="button" class="btn btn-default"><?php echo Yii::t('system','Reset'); ?></button>
                
                <?php else: ?>
                
                    <div class="alert alert-warning">
                        <?php echo Yii::t('extensions','There are no templates here.'); ?>
                    </div>
                
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>