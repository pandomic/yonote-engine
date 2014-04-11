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

<div class="row">
    <div class="col-lg-6 col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading clearfix">
                <button class="btn btn-primary btn-xs pull-right"><span class="glyphicon glyphicon-plus"></span> Добавить расширение</button>
                <h3 class="panel-title">Расширения <span class="label label-primary"><?php echo count($extensions); ?></span></h3>
            </div>
            <div class="panel-body"> 
                
                <?php if (count($extensions) > 0): ?>
                
                    <form id="extensionsForm" method="POST" action="<?php echo Yii::app()->createUrl('extensions/delete') ?>">
                        
                        <input type="hidden" name="<?php echo Yii::app()->request->csrfTokenName ?>" value="<?php echo Yii::app()->request->getCsrfToken(); ?>">
                        
                        <table class="table table-striped table-hover table-middle table-responsive">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Название</th>
                                    <th>Автор</th>
                                    <th>Выделить</th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php foreach ($extensions as $extension): ?>

                                    <tr>
                                        <td>
                                            <a href="#" data-toggle="modal" data-target="#ajaxModal" data-remote="<?php echo Yii::app()->createUrl('extensions/info',array('e' => $extension->name)); ?>">
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
                                            <input type="checkbox" name="select[]" value="<?php echo $extension->name; ?>">
                                        </td>
                                    </tr>

                                <?php endforeach; ?>

                            </tbody>
                        </table>
                        
                        <button type="button" class="btn btn-danger" onclick="$(this).confirmModal();" data-action="$('#extensionsForm').submit();">Удалить выбранное</button>
                        <button type="reset" class="btn btn-default">Сбросить</button>
                        
                    </form>
                <?php else: ?>
                    
                    <div class="alert alert-warning">
                        Расширения не найдены. Загрузите новое расширение.
                    </div>
                    
                <?php endif; ?>
                    
            </div>
        </div>
    </div>
    <div class="col-lg-6 col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading clearfix">
                <h3 class="panel-title">Модули <span class="label label-primary"><?php echo count($modules); ?></span></h3>
            </div>
            <div class="panel-body">
                
                <?php if (count($modules) > 0): ?>
                
                <table class="table table-striped table-hover table-middle table-responsive">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Название</th>
                            <th>Расширение</th>
                            <th>Состояние</th>
                            <th>Выделить</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                        <?php foreach ($modules as $module): ?>
                            
                            <tr>
                                <td>
                                    <?php echo $module->name; ?>
                                </td>
                                <td>
                                    <?php echo Yii::t('extensions',$module->title); ?>
                                </td>
                                <td>
                                    <a href="#" data-toggle="modal" data-target="#ajaxModal" data-remote="<?php echo Yii::app()->createUrl('extensions/info',array('e' => $module->extension)); ?>">
                                        <?php echo $module->extension; ?>
                                    </a>
                                </td>
                                <td>
                                    <?php if ((bool) $module->installed): ?>
                                        <span class="label label-success">Работает</span>
                                    <?php else: ?>
                                        <span class="label label-danger">Отключен</span>
                                    <?php endif; ?>
                                <td>
                                    <div class="btn-group" data-toggle="buttons">
                                        <label class="btn btn-default btn-sm">
                                            <input type="checkbox"> <span class="glyphicon glyphicon-check"> Выделить
                                        </label>
                                    </div>
                                </td>
                            </tr>
                            
                        <?php endforeach; ?>
                            
                    </tbody>
                </table>
                
                <div class="btn-group">
                    <button type="button" class="btn btn-primary">Выполнить</button>
                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                        <span class="caret"></span>
                        <span class="sr-only">Выбрать действие</span>
                    </button>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="#">Включить</a></li>
                        <li><a href="#">Отключить</a></li>
                    </ul>
                </div>

                <button type="button" class="btn btn-default">Сбросить</button>
                
                <?php else: ?>
                    
                    <div class="alert alert-warning">
                        Не обнаружено модулей в составе расширений.
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
                <h3 class="panel-title">Виджеты <span class="label label-primary"><?php echo count($widgets); ?></span></h3>
            </div>
            <div class="panel-body">
                
                <?php if (count($widgets) > 0): ?>
                
                    <table class="table table-striped table-hover table-middle">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Название</th>
                                <th>Расширение</th>
                                <th>Класс</th>
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
                                        <a href="#" data-toggle="modal" data-target="#ajaxModal" data-remote="<?php echo Yii::app()->createUrl('extensions/info',array('e' => $widget->extension)); ?>">
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
                        Не обнаружено виджетов в составе расширений.
                    </div>
                
                <?php endif; ?>
                
            </div>
        </div>
    </div>
    <div class="col-lg-6 col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading clearfix">
                <h3 class="panel-title">Шаблоны <span class="label label-primary"><?php echo count($templates); ?></span></h3>
            </div>
            <div class="panel-body">        
                
                <?php if(count($templates) > 0): ?>
                
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Расширение</th>
                            <th>По умолчанию</th>
                            <th>Выделить</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                        <?php foreach ($templates as $template): ?>
                        
                            <tr>
                                <td>
                                    <?php echo $template->name; ?>
                                </td>
                                <td>
                                    <a href="#" data-toggle="modal" data-target="#ajaxModal" data-remote="<?php echo Yii::app()->createUrl('extensions/info',array('e' => $template->extension)); ?>">
                                        <?php echo $template->extension; ?>
                                    </a>
                                </td>
                                <td>
                                    <div class="btn-group" data-toggle="buttons">
                                        <label class="btn btn-default btn-sm">
                                            <input type="radio" name="options" id="option1" data-toggle="button"><span class="glyphicon glyphicon-ok"> По умолчанию
                                        </label>
                                    </div>
                                </td>
                                <td>
                                    <div class="btn-group" data-toggle="buttons">
                                        <label class="btn btn-default btn-sm">
                                            <input type="checkbox" checked=""> <span class="glyphicon glyphicon-check"> Выделить
                                        </label>
                                    </div>
                                </td>
                            </tr>
                        
                        <?php endforeach; ?>
                        
                    </tbody>
                </table>
                
                <button type="button" class="btn btn-primary">Сохранить</button>
                <button type="button" class="btn btn-default">Сбросить</button>
                
                <?php else: ?>
                
                    <div class="alert alert-warning">
                        Не обнаружено шаблонов в составе расширений.
                    </div>
                
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>