<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-body"> 
                <dl class="dl-horizontal">
                    
                    <div class="media">
                        <a class="pull-left" href="<?php echo $this->createUrl('/users/edit',array('id' => $model->senderid)); ?>">
                            <img width="64" class="media-object" src="<?php if ($model->author->profile->getPhoto() !== false) echo '/'.$model->author->profile->getPhoto(); else echo "{$template}/images/user.jpg"; ?>" alt="<?php echo $model->senderid; ?>">
                        </a>
                        <div class="media-body">
                            <h4 class="media-heading"><?php echo $model->title; ?></h4>
                            <div class="small text-muted"><a href="<?php echo $this->createUrl('/users/edit',array('id' => $model->senderid)); ?>"><?php echo $model->senderid; ?></a>, <?php echo Yii::app()->dateFormatter->formatDateTime($model->updatetime); ?></div>
                            <div class="media-heading"></div>
                            <?php echo $model->message; ?>
                        </div>
                    </div>

                </dl>
            </div>
            <div class="panel-footer">
                <a href="<?php echo $this->createUrl('add',array('replyid' => $model->id)); ?>" class="btn btn-primary"><?php echo Yii::t('pm','button.reply'); ?></a>
                <a href="<?php echo $this->createUrl('remove',array('select[]' => $model->id)); ?>" class="btn btn-default"><?php echo Yii::t('pm','button.remove'); ?></a>
            </div>
        </div>
    </div>
</div>