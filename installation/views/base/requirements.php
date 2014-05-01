<!DOCTYPE html>
<html>
    <head>
        <script type="text/javascript" src="<?php echo $template; ?>/js/jquery.min.js"></script>
        <script type="text/javascript" src="<?php echo $template; ?>/js/bootstrap.min.js"></script>
        <link rel="stylesheet" type="text/css" href="<?php echo $template; ?>/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="<?php echo $template; ?>/css/bootstrap-theme.min.css">
    </head>
    <body>
        <div class="container">
            <div class="row">
                <h1 class="text-center">YOnote ENGINE <span class="badge">installation</span></h1>
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">Database settings</h3>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <form role="form" class="">
                                        <h2>Database settings <span class="small glyphicon glyphicon-cog"></span></h2>
                                        <div class="form-group">
                                            <label class="sr-only" for="dbName">Database name</label>
                                            <div class="input-group">
                                                <span class="input-group-addon"><span class="glyphicon glyphicon-cloud"></span></span>
                                                <input id="dbName" type="text" class="form-control" placeholder="Database name">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="sr-only" for="dbHost">Database host</label>
                                            <div class="input-group">
                                                <span class="input-group-addon"><span class="glyphicon glyphicon-tasks"></span></span>
                                                <input id="dbHost" type="text" value="localhost" class="form-control" placeholder="Database host">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="sr-only" for="dbType">Database type</label>
                                            <div class="input-group">
                                                <span class="input-group-addon"><span class="glyphicon glyphicon-hdd"></span></span>
                                                <select id="dbType" class="form-control">
                                                    <option>MySQL</option>
                                                    <option>SQLite</option>
                                                    <option>PostgreSQL</option>
                                                    <option>Oracle</option>
                                                    <option>MSSQL</option>
                                                    <option>ODBC</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="sr-only" for="dbUser">Database user</label>
                                            <div class="input-group">
                                                <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
                                                <input id="dbUser" type="text" class="form-control" placeholder="Database user">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="sr-only" for="dbPwd">Database user password</label>
                                            <div class="input-group">
                                                <span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
                                                <input id="dbPwd" type="password" class="form-control" placeholder="Database user password">
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="col-md-6">
                                    <form role="form" class="">
                                        <h2>Administrator settings <span class="small glyphicon glyphicon-user"></span></h2>
                                        <div class="form-group">
                                            <label class="sr-only" for="adminUsername">Administrator user name</label>
                                            <div class="input-group">
                                                <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
                                                <input id="adminUsername" type="text" class="form-control" placeholder="Administrator user name">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="sr-only" for="adminEmail">Administrator email</label>
                                            <div class="input-group">
                                                <span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span></span>
                                                <input id="adminEmail" type="email" class="form-control" placeholder="Administrator email">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="sr-only" for="adminPwd">Administrator password</label>
                                            <div class="input-group">
                                                <span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
                                                <input id="adminPwd" type="password" class="form-control" placeholder="Administrator password">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="sr-only" for="adminPwdRepeat">Administrator password repeat</label>
                                            <div class="input-group">
                                                <span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
                                                <input id="adminPwdRepeat" type="password" class="form-control" placeholder="Administrator password repeat">
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <h2>Checking requirements <span class="small glyphicon glyphicon-info-sign"></span></h2>
                                    <div class="list-group">
                                        <?php foreach ($model->getAttributes() as $k => $v): ?>
                                            <a href="javascript:void(0);" class="list-group-item <?php if ($model->hasErrors($k)): ?>list-group-item-danger<?php elseif ($model->hasWarning($k)): ?>list-group-item-warning<?php else: ?>list-group-item-success<?php endif; ?>" data-toggle="collapse" data-target="#collapse-<?php echo $k; ?>">
                                                <p class="list-group-item-heading"><strong><?php echo $model->getAttributeLabel($k); ?></strong></p>
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
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>