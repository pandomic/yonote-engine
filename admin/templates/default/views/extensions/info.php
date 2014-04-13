<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading clearfix">
                <a class="pull-right" href="<?php echo Yii::app()->createUrl('extensions/index'); ?>"><span class="glyphicon glyphicon-arrow-left"></span> Назад</a>
                <h3 class="panel-title">Информация о расширении "<?php echo $model->name; ?>"</h3>
            </div>
            <div class="panel-body"> 
                <p>
                    <dl class="dl-horizontal">
                        <dt>Дата изменения:</dt>
                        <dd><?php echo Yii::app()->dateFormatter->formatDateTime($model->updateTime); ?></dd>

                        <dt>Расширение:</dt>
                        <dd><?php echo $model->name; ?></dd>

                        <dt>Название:</dt>
                        <dd><?php echo $model->title; ?></dd>

                        <dt>Автор:</dt>
                        <dd><a href="mailto:<?php echo $model->email; ?>"><?php echo $model->author; ?></a></dd>

                        <dt>Сайт:</dt>
                        <dd><a href="<?php echo $model->website; ?>"><?php echo $model->website; ?></a></dd>

                        <dt>Лицензия:</dt>
                        <dd><?php echo $model->licence; ?></dd>

                        <dt>Описание:</dt>
                        <dd><?php echo $model->description; ?></dd>

                        <dt>Содержимое:</dt>
                        <dd>

                            <ul>
                                <?php
                                if (is_array($data['folders'])):
                                    foreach ($data['folders'] as $folder): 
                                ?>

                                    <li>
                                        <?php echo $folder; ?>
                                    </li>

                                <?php
                                    endforeach;
                                endif;
                                ?>
                                <?php
                                if (is_array($data['files'])):
                                    foreach ($data['files'] as $file): 
                                ?>

                                    <li>
                                        <?php echo $file; ?>
                                    </li>

                                <?php
                                    endforeach;
                                endif;
                                ?>
                            </ul>

                        </dd>
                    </dl>
                </p>
            </div>
        </div>
    </div>
</div>