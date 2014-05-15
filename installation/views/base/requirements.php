<?php
$dbTypes = array(
    'mysql' => 'MySQL',
    'sqlite' => 'SQLite',
    'postgresql' => 'PostgreSQL',
    'oracle' => 'Oracle',
    'mssql' => 'MS SQL Server',
    'odbc' => 'ODBC'
);
?>
<div class="panel-heading">
    <h3 class="panel-title"><?php echo Yii::t('installation','label.step',array('{current}' => 2,'{all}' => 3)); ?></h3>
</div>
<form role="form" method="POST">
    <div class="panel-body">
        <div class="row">
            <div class="col-md-12">
                    <h2><?php echo Yii::t('installation','label.dbsettings'); ?> <span class="small glyphicon glyphicon-cog"></span></h2>
                    <div class="form-group">
                        <label class="sr-only" for="dbName"><?php echo $model->getAttributeLabel('dbName'); ?></label>
                        <div class="input-group">
                            <span class="input-group-addon"><span class="glyphicon glyphicon-cloud"></span></span>
                            <?php echo CHtml::activeTextField($model,'dbName',array(
                                'class' => 'form-control',
                                'placeholder' => $model->getAttributeLabel('dbName'),
                                'id' => 'dbName'
                            )); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="sr-only" for="dbPrefix"><?php echo $model->getAttributeLabel('dbPrefix'); ?></label>
                        <div class="input-group">
                            <span class="input-group-addon"><span class="glyphicon glyphicon-bookmark"></span></span>
                            <?php echo CHtml::activeTextField($model,'dbPrefix',array(
                                'class' => 'form-control',
                                'placeholder' => $model->getAttributeLabel('dbPrefix'),
                                'id' => 'dbPrefix'
                            )); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="sr-only" for="dbHost"><?php echo $model->getAttributeLabel('dbHost'); ?></label>
                        <div class="input-group">
                            <span class="input-group-addon"><span class="glyphicon glyphicon-tasks"></span></span>
                            <?php echo CHtml::activeTextField($model,'dbHost',array(
                                'class' => 'form-control',
                                'placeholder' => $model->getAttributeLabel('dbHost'),
                                'value' => 'localhost',
                                'id' => 'dbHost'
                            )); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="sr-only" for="dbType"><?php echo $model->getAttributeLabel('dbType'); ?></label>
                        <div class="input-group">
                            <span class="input-group-addon"><span class="glyphicon glyphicon-hdd"></span></span>
                            <?php echo CHtml::activeDropDownList($model,'dbType',$dbTypes,array(
                                'class' => 'form-control',
                                'id' => 'dbType'
                            )); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="sr-only" for="dbUser"><?php echo $model->getAttributeLabel('dbUser'); ?></label>
                        <div class="input-group">
                            <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
                            <?php echo CHtml::activeTextField($model,'dbUser',array(
                                'class' => 'form-control',
                                'placeholder' => $model->getAttributeLabel('dbUser'),
                                'id' => 'dbUser'
                            )); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="sr-only" for="dbPwd"><?php echo $model->getAttributeLabel('dbPwd'); ?></label>
                        <div class="input-group">
                            <span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
                            <?php echo CHtml::activePasswordField($model,'dbPwd',array(
                                'class' => 'form-control',
                                'placeholder' => $model->getAttributeLabel('dbPwd'),
                                'id' => 'dbPwd'
                            )); ?>
                        </div>
                    </div>
                    <h2><?php echo Yii::t('installation','label.usersettings'); ?> <span class="small glyphicon glyphicon-user"></span></h2>
                    <div class="form-group">
                        <label class="sr-only" for="username"><?php echo $model->getAttributeLabel('username'); ?></label>
                        <div class="input-group <?php if ($model->hasErrors('username')) echo('has-error'); ?>">
                            <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
                            <?php echo CHtml::activeTextField($model,'username',array(
                                'class' => 'form-control',
                                'placeholder' => $model->getAttributeLabel('username'),
                                'id' => 'username'
                            )); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="sr-only" for="email"><?php echo $model->getAttributeLabel('email'); ?></label>
                        <div class="input-group <?php if ($model->hasErrors('email')) echo('has-error'); ?>">
                            <span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span></span>
                            <?php echo CHtml::activeEmailField($model,'email',array(
                                'class' => 'form-control',
                                'placeholder' => $model->getAttributeLabel('email'),
                                'id' => 'email'
                            )); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="sr-only" for="password"><?php echo $model->getAttributeLabel('password'); ?></label>
                        <div class="input-group <?php if ($model->hasErrors('password')) echo('has-error'); ?>">
                            <span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
                            <?php echo CHtml::activePasswordField($model,'password',array(
                                'class' => 'form-control',
                                'placeholder' => $model->getAttributeLabel('password'),
                                'id' => 'password'
                            )); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="sr-only" for="passwordRepeat"><?php echo $model->getAttributeLabel('passwordRepeat'); ?></label>
                        <div class="input-group <?php if ($model->hasErrors('passwordRepeat')) echo('has-error'); ?>">
                            <span class="input-group-addon"><span class="glyphicon glyphicon-repeat"></span></span>
                            <?php echo CHtml::activePasswordField($model,'passwordRepeat',array(
                                'class' => 'form-control',
                                'placeholder' => $model->getAttributeLabel('passwordRepeat'),
                                'id' => 'passwordRepeat'
                            )); ?>
                        </div>
                    </div>
            </div>
            <div class="col-md-12">
                <h2><?php echo Yii::t('installation','label.requirements'); ?> <span class="small glyphicon glyphicon-info-sign"></span></h2>
                <div class="list-group">
                    <?php foreach ($model->getAttributes() as $k => $v): ?>
                        <a href="javascript:void(0);" class="list-group-item <?php if ($model->hasErrors($k)): ?>list-group-item-danger<?php elseif ($model->hasWarning($k)): ?>list-group-item-warning<?php else: ?>list-group-item-success<?php endif; ?>" data-toggle="collapse" data-target="#collapse-<?php echo $k; ?>">
                            <p class="list-group-item-heading">
                                <strong><?php echo $model->getAttributeLabel($k); ?></strong>
                                <?php if ($model->hasErrors($k)): ?>
                                    <span class="glyphicon glyphicon-remove pull-right"></span>
                                <?php elseif ($model->hasWarning($k)): ?>
                                    <span class="glyphicon glyphicon-warning-sign pull-right"></span>
                                <?php else: ?>
                                    <span class="glyphicon glyphicon-ok pull-right"></span>
                                <?php endif; ?>
                            </p>
                            <p class="list-group-item-text collapse" id="collapse-<?php echo $k; ?>">
                                <?php echo $model->getError($k); ?>
                                <?php echo $model->getWarning($k); ?>
                            </p>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>



    </div>
    <div class="panel-footer">
        <button type="submit" class="btn btn-primary">Submit</button>
        <button type="reset" class="btn btn-default">Reset</button>
    </div>
</form>