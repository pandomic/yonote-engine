<?php if ($model !== null): ?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title" id="ajaxModalLabel">Информация о расширении "<?php echo $model->name; ?>"</h4>
</div>
<div class="modal-body">
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
<div class="modal-footer">
    <small class="text-muted"><?php echo $model->copyright; ?></small>
</div>
<?php else: ?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title">Error</h4>
</div>
<div class="modal-body">
    <p>Extension not found</p>
</div>
<?php endif; ?>
