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

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading clearfix">
                <button class="btn btn-primary btn-xs pull-right"><span class="glyphicon glyphicon-plus"></span> Добавить расширение</button>
                <h3 class="panel-title">Расширения <span class="label label-primary">2</span></h3>
            </div>
            <div class="panel-body">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Название</th>
                            <th>Автор</th>
                            <th>Описание</th>
                            <th>Выделить</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><a href="#">news</a></td>
                            <td>Новости</td>
                            <td>Новости</td>
                            <td>Новости</td>
                            <td>
                                <div class="btn-group" data-toggle="buttons">
                                    <label class="btn btn-default btn-sm">
                                        <input type="checkbox" checked=""> <span class="glyphicon glyphicon-check"> Выделить
                                    </label>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>gallery</td>
                            <td>Галлерея</td>
                            <td>Новости</td>
                            <td>Новости</td>
                            <td>
                                <div class="btn-group" data-toggle="buttons">
                                    <label class="btn btn-default btn-sm">
                                        <input type="checkbox" checked=""> <span class="glyphicon glyphicon-check"> Выделить
                                    </label>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td>Ivan Raven</td>
                            <td>Новости</td>
                            <td>Новости</td>
                            <td>
                                <div class="btn-group" data-toggle="buttons">
                                    <label class="btn btn-default btn-sm">
                                        <input type="checkbox" checked=""> <span class="glyphicon glyphicon-check"> Выделить
                                    </label>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <button type="button" class="btn btn-danger">Удалить выбранное</button>
                <button type="button" class="btn btn-default">Сбросить</button>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-4">
        <div class="panel panel-default">
            <div class="panel-heading clearfix">
                <h3 class="panel-title">Модули <span class="label label-primary">2</span></h3>
            </div>
            <div class="panel-body">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Название</th>
                            <th>Выделить</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><span class="label label-success">Работает</span> <a href="#">news</a></td>
                            <td>Новости</td>
                            <td>
                                <div class="btn-group" data-toggle="buttons">
                                    <label class="btn btn-default btn-sm">
                                        <input type="checkbox"> <span class="glyphicon glyphicon-check"> Выделить
                                    </label>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td><span class="label label-danger">Отключен</span> <a href="#">gallery</a></td>
                            <td>Галлерея</td>
                            <td>
                                <div class="btn-group" data-toggle="buttons">
                                    <label class="btn btn-default btn-sm">
                                        <input type="checkbox"> <span class="glyphicon glyphicon-check"> Выделить
                                    </label>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td><span class="label label-success">Работает</span> <a href="#">modernizer</a></td>
                            <td>Ivan Raven</td>
                            <td>
                                <div class="btn-group" data-toggle="buttons">
                                    <label class="btn btn-default btn-sm">
                                        <input type="checkbox"> <span class="glyphicon glyphicon-check"> Выделить
                                    </label>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
                
                <div class="btn-group">
                    <button type="button" class="btn btn-primary">Выполнить</button>
                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                        <span class="caret"></span>
                        <span class="sr-only">Выбрать действие</span>
                    </button>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="#">Установить</a></li>
                        <li><a href="#">Отключить</a></li>
                    </ul>
                </div>

                <button type="button" class="btn btn-default">Сбросить</button>
                
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="panel panel-default">
            <div class="panel-heading clearfix">
                <h3 class="panel-title">Виджеты <span class="label label-primary">2</span></h3>
            </div>
            <div class="panel-body">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Класс</th>
                            <th>Название</th>
                            <th>Выделить</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><a href="#">default</a></td>
                            <td>
                                CInterveWidget
                            </td>
                            <td>
                                Виджет внутренних зависимостей
                            </td>
                            <td>
                                <div class="btn-group" data-toggle="buttons">
                                    <label class="btn btn-default btn-sm">
                                        <input type="checkbox" checked=""> <span class="glyphicon glyphicon-check"> Выделить
                                    </label>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <button type="button" class="btn btn-danger">Удалить выбранное</button>
                <button type="button" class="btn btn-default">Сбросить</button>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="panel panel-default">
            <div class="panel-heading clearfix">
                <h3 class="panel-title">Шаблоны <span class="label label-primary">2</span></h3>
            </div>
            <div class="panel-body">                
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>По умолчанию</th>
                            <th>Выделить</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><a href="#">default</a></td>
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
                    </tbody>
                </table>
                
                <div class="btn-group">
                    <button type="button" class="btn btn-primary">Выполнить</button>
                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                        <span class="caret"></span>
                        <span class="sr-only">Выбрать действие</span>
                    </button>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="#">Сохранить</a></li>
                        <li><a href="#" onclick="$(this).confirmModal();" data-action="alert();">Удалить</a></li>
                    </ul>
                </div>

                <button type="button" class="btn btn-default">Сбросить</button>
            </div>
        </div>
    </div>
</div>