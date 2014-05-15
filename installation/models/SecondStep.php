<?php
/**
 * Requirements class file.
 * 
 * @author Vlad Gramuzov <vlad.gramuzov@gmail.com>
 * @link http://yonote.org
 * @copyright 2014 Vlad Gramuzov
 * @copyright 2008-2013 Yii Software LLC
 * @license http://yonote.org/licence.html
 */

/**
 * Requirements checkink model.
 * Based on Yii Requirement Checker script.
 * 
 * @author Vlad Gramuzov <vlad.gramuzov@gmail.com>
 * @since 1.0
 */
class SecondStep extends CFormModel
{
    /**
     * @var null check php version.
     */
    public $phpVersion;
    /**
     * @var null check server variables.
     */
    public $serverVars;
    /**
     * @var null check php reflections api.
     */
    public $phpReflections;
    /**
     * @var null check php pcre extension.
     */
    public $phpPcre;
    /**
     * @var null check php spl extension.
     */
    public $phpSpl;
    /**
     * @var null check php domdocument extension.
     */
    public $phpDom;
    /**
     * @var null check php pdo extension.
     */
    public $phpPdo;
    /**
     * @var null check php pdo database interfaces.
     */
    public $dbInterfaces;
    /**
     * @var null check php mcrypet extension.
     */
    public $phpMcrypt;
    /**
     * @var null check php blowfish.
     */
    public $phpBlowfish;
    /**
     * @var null check php ctype extension.
     */
    public $phpCtype;
    /**
     * @var null check php fileinfo extension.
     */
    public $phpFileInfo;
    /**
     * @var null check php gd or imagick.
     */
    public $phpGd;
    /**
     * @var null check php memcache or memcached extensions.
     */
    public $phpMemcache;
    /**
     * @var null check php apc extension.
     */
    public $phpApc;
    /**
     * @var null check php soap extension.
     */
    public $phpSoap;
    /**
     * @var string database type.
     */
    public $dbType;
    /**
     * @var string database host.
     */
    public $dbHost;
    /**
     * @var string database username.
     */
    public $dbUser;
    /**
     * @var string database user password.
     */
    public $dbPwd;
    /**
     * @var string database name.
     */
    public $dbName;
    /**
     * @var null database connection check.
     */
    public $dbCnn;
    /**
     * @var string database prefix.
     */
    public $dbPrefix;
    /**
     * @var string admin username.
     */
    public $username;
    /**
     * @var string admin email.
     */
    public $email;
    /**
     * @var string admin password.
     */
    public $password;
    /**
     * @var string admin password repeat.
     */
    public $passwordRepeat;
    
    private $_warnings = array();
    private $_connection = null;
    
    public function attributeLabels()
    {
        return array(
            'phpVersion' => Yii::t('installation','model.secondstep.phpversion'),
            'serverVars' => Yii::t('installation','model.secondstep.servervars'),
            'phpReflections' => Yii::t('installation','model.secondstep.phpreflections'),
            'phpPcre' => Yii::t('installation','model.secondstep.phppcre'),
            'phpSpl' => Yii::t('installation','model.secondstep.phpspl'),
            'phpDom' => Yii::t('installation','model.secondstep.phpdom'),
            'phpPdo' => Yii::t('installation','model.secondstep.phppdo'),
            'dbInterfaces' => Yii::t('installation','model.secondstep.dbinterfaces'),
            'phpMcrypt' => Yii::t('installation','model.secondstep.phpmcrypt'),
            'phpBlowfish' => Yii::t('installation','model.secondstep.phpblowfish'),
            'phpCtype' => Yii::t('installation','model.secondstep.phpctype'),
            'phpFileInfo' => Yii::t('installation','model.secondstep.phpfileinfo'),
            'phpGd' => Yii::t('installation','model.secondstep.phpgd'),
            'phpMemcache' => Yii::t('installation','model.secondstep.phpmemcache'),
            'phpApc' => Yii::t('installation','model.secondstep.phpapc'),
            'phpSoap' => Yii::t('installation','model.secondstep.phpsoap'),
            'dbType' => Yii::t('installation','model.secondstep.dbtype'),
            'dbHost' => Yii::t('installation','model.secondstep.dbhost'),
            'dbUser' => Yii::t('installation','model.secondstep.dbuser'),
            'dbPwd' => Yii::t('installation','model.secondstep.dbpwd'),
            'dbName' => Yii::t('installation','model.secondstep.dbname'),
            'dbCnn' => Yii::t('installation','model.secondstep.dbcnn'),
            'dbPrefix' => Yii::t('installation','model.secondstep.dbprefix'),
            'username' => Yii::t('installation','model.secondstep.username'),
            'email' => Yii::t('installation','model.secondstep.email'),
            'password' => Yii::t('installation','model.secondstep.password'),
            'passwordRepeat' => Yii::t('installation','model.secondstep.passwordrepeat')
        );
    }
    
    public function rules()
    {
        return array(
            array('dbType,dbHost,dbUser,dbPwd,dbName','safe'),
            array('phpVersion','phpVersionRule'),
            array('serverVars','serverVarsRule'),
            array('phpReflections','reflectionRule'),
            array('phpPcre','pcreRule'),
            array('phpSpl','splRule'),
            array('phpDom','domRule'),
            array('phpPdo','pdoRule'),
            array('dbInterfaces','dbInterfacesRule'),
            array('phpMcrypt','mcryptRule'),
            array('phpBlowfish','blowfishRule'),
            array('phpCtype','ctypeRule'),
            array('phpFileInfo','fileinfoRule'),
            array('phpGd','gdRule'),
            array('phpMemcache','memcacheRule'),
            array('phpApc','apcRule'),
            array('phpSoap','soapRule'),
            array('dbCnn','checkDbConnection'),
            array(
                'username,email,password,passwordRepeat','required',
                'message' => Yii::t('installation','model.secondstep.error.required')
            ),
            array(
                'username','match','pattern' => '/[a-z0-9_]/i',
                'message' => Yii::t('installation','model.secondstep.error.name.match')
            ),
            array(
                'email','email',
                'message' => Yii::t('installation','model.secondstep.error.email')
            ),
            array(
                'passwordRepeat','compare','compareAttribute' => 'password',
                'message' => Yii::t('installation','model.secondstep.error.pwdrepeat')
            ),
            array(
                'dbPrefix','match','pattern' => '/[a-z0-9_]/',
                'message' => Yii::t('installation','model.secondstep.error.tblprefix')
            )
        );
    }
    
    public function hasWarning($attribute)
    {
        return isset($this->_warnings[$attribute]);
    }
    
    public function getWarning($attribute)
    {
        return $this->_warnings[$attribute];
    }
    
    public function addWarning($attribute,$message)
    {
        $this->_warnings[$attribute] = $message;
    }

    public function phpVersionRule($attribute,$params)
    {
        if (!version_compare(PHP_VERSION,'5.3.0','>='))
            $this->addError($attribute,'Version error');
    }
    
    public function serverVarsRule($attribute,$params)
    {
        $vars = array('HTTP_HOST','SERVER_NAME','SERVER_PORT','SCRIPT_NAME','SCRIPT_FILENAME','PHP_SELF','HTTP_ACCEPT','HTTP_USER_AGENT');
        $missing=array();
	foreach($vars as $var)
	{
            if(!isset($_SERVER[$var]))
                $missing[] = $var;
	}
        if (!empty($missing))
            $this->addError($attribute,'Missing');
        if(realpath($_SERVER["SCRIPT_FILENAME"]) !== realpath(Yii::getPathOfAlias('application').'/index.php'))
            $this->addError($attribute,'Realpath');
        if(!isset($_SERVER["REQUEST_URI"]) && isset($_SERVER["QUERY_STRING"]))
            $this->addError($attribute,'Either');
        if(!isset($_SERVER["PATH_INFO"]) && strpos($_SERVER["PHP_SELF"],$_SERVER["SCRIPT_NAME"]) !== 0)
            $this->addError($attribute,'Error URL path info');
    }
    
    public function reflectionRule($attribute,$params)
    {
        if (!class_exists('Reflection',false))
            $this->addError($attribute,'Reflection API required!');
    }
    
    public function pcreRule($attribute,$params)
    {
        if (!extension_loaded("pcre"))
            $this->addError($attribute,'PCRE required!');
    }
    
    public function splRule($attribute,$params)
    {
        if (!extension_loaded("SPL"))
            $this->addError($attribute,'SPL required!');
    }
    
    public function domRule($attribute,$params)
    {
        if (!class_exists("DOMDocument",false))
            $this->addError($attribute,'DOM is required');
    }
    
    public function pdoRule($attribute,$params)
    {
        if (!extension_loaded('pdo'))
            $this->addError($attribute,'PDO is required');
    }
    
    public function dbInterfacesRule($attribute,$params)
    {
        if ($this->dbType != null)
        {
            if ($this->dbType == 'mysql')
            {
                if (!extension_loaded('pdo_mysql'))
                    $this->addError($attribute,'No PDO MySQL interface found!');
            }
            else if ($this->dbType == 'sqlite')
            {
                if (!extension_loaded('pdo_sqlite'))
                    $this->addError($attribute,'No PDO SQLite interface found!');
            }
            else if ($this->dbType == 'postgresql')
            {
                if (!extension_loaded('pdo_pgsql'))
                    $this->addError($attribute,'No PDO SQLite interface found!');
            }
            else if ($this->dbType == 'oracle')
            {
                if (!extension_loaded('pdo_oci'))
                    $this->addError($attribute,'No PDO Oracle interface found!');
            }
            else if ($this->dbType == 'mssql')
            {
                if (!extension_loaded('pdo_sqlsrv'))
                    $this->addError($attribute,'No PDO MS SQL server interface found!');
            }
            else if ($this->dbType == 'odbc')
            {
                if (!extension_loaded('pdo_odbc'))
                    $this->addError($attribute,'No PDO ODBC interface found!');
            }
            else
            {
                $this->addError($attribute,'Undefined DB type!');
            }
        }
    }
    
    public function mcryptRule($attribute,$params)
    {
        if (!extension_loaded('mcrypt'))
            $this->addError($attribute,'MCrypt is required');
    }
    
    public function blowfishRule($attribute,$params)
    {
        if (!(function_exists('crypt') && defined('CRYPT_BLOWFISH') && CRYPT_BLOWFISH))
            $this->addError($attribute,'Blowfish is required!');
    }
    
    public function ctypeRule($attribute,$params)
    {
        if (!extension_loaded('ctype'))
            $this->addError($attribute,'CType is required');
    }
    
    public function fileinfoRule($attribute,$params)
    {
        if (!extension_loaded('fileinfo'))
            $this->addError($attribute,'FileInfo is required');
    }
    
    public function gdRule($attribute,$params)
    {
        if(extension_loaded('imagick'))
	{
            $imagick=new Imagick();
            $imagickFormats=$imagick->queryFormats('PNG');
	}
	if(extension_loaded('gd'))
            $gdInfo=gd_info();
        
	if(!(isset($imagickFormats) && in_array('PNG',$imagickFormats)))
        {
            if(!isset($gdInfo))
                $this->addError($attribute,'GD or Imagick required');
            else if (!$gdInfo['FreeType Support'] && isset($gdInfo))
                $this->addError($attribute,'GD installed, FreeType support not installed');
        }
    }
    
    public function memcacheRule($attribute,$params)
    {
        if (!(extension_loaded("memcache") || extension_loaded("memcached")))
            $this->addWarning($attribute,'Memcache or Memcached not found');
    }
    
    public function apcRule($attribute,$params)
    {
        if (!extension_loaded("apc"))
            $this->addWarning($attribute,'APC not found.');
    }
    
    public function soapRule($attribute,$params)
    {
        if (!extension_loaded("soap"))
            $this->addWarning($attribute,'SOAP not found.');
    }
    
    public function checkDbConnection($attribute,$params)
    {
        if ($this->dbType == 'mysql')
        {
            $this->_connection = new CDbConnection(
                "mysql:host={$this->dbHost};dbname={$this->dbName}",
                $this->dbUser,$this->dbPwd
            );
        }
        else if ($this->dbType == 'sqlite')
        {
            $this->_connection = new CDbConnection("sqlite:{$this->dbName}");
        }
        else if ($this->dbType == 'postgresql')
        {
            $this->_connection = new CDbConnection(
                "pgsql:host={$this->dbHost};dbname={$this->dbName}",
                $this->dbUser,$this->dbPwd
            );
        }
        else if ($this->dbType == 'oracle')
        {
            $this->_connection = new CDbConnection("oci:dbname={$this->dbName}");
        }
        else if ($this->dbType == 'mssql')
        {
            $this->_connection = new CDbConnection(
                "sqlsrv:server={$this->dbHost};Database={$this->dbName}",
                $this->dbUser,$this->dbPwd
            );
        }
        else if ($this->dbType == 'odbc')
        {
            $this->_connection = new CDbConnection(
                "odbc:DSN={$this->dbName}",
                $this->dbUser,$this->dbPwd
            );
        }
        else
        {
            $this->addError($attribute,'Undefined DB type!');
        }
        if ($this->dbType != null && is_object($this->_connection))
        {
            try {
                $this->_connection->active = true;
                $this->_connection->tablePrefix = $this->dbPrefix;
            } catch (Exception $e) {
                $this->addError($attribute,'Database connection error!');
            }
        }
        
    }
    
    public function validate($attributes = null,$clearErrors = true)
    {
        if (parent::validate($attributes,$clearErrors))
        {
            $this->createTables();
            $this->createUser();
            $this->createAuthItems();
            $this->createAuthAssignment('administrator');
            $this->createConfig();
            $this->createConfiguration();
            return true;
        }
        return false;
    }
    
    public function createTables()
    {
        $sql = realpath(Yii::getPathOfAlias('application.schema')."/{$this->dbType}.sql");
        if (!file_exists($sql))
        {
            $this->addError('dbCnn','Can\'t load schema file!');
            return false;
        }
        $sqlCont = file_get_contents($sql);
        $sqlParts = explode(';',$sqlCont);
        foreach ($sqlParts as $part)
        {
            $part = trim($part);
            if ($part != null)
                $this->_connection->createCommand($part)->execute();
        }
    }
    
    public function createUser()
    {
        $db = $this->_connection->createCommand();
        $db->insert('{{user}}',array(
            'name' => $this->username,
            'password' => CPasswordHelper::hashPassword($this->password),
            'email' => $this->email,
            'activated' => true,
            'verified' => true,
            'subscribed' => true,
            'updatetime' => time()
        ));
        $db->insert('{{profile}}',array(
            'userid' => $this->username
        ));
    }
    
    public function createAuthItems()
    {
        $db = $this->_connection->createCommand();
        $authItems = array(
            array('admin.index',0,'Administrative panel access',NULL,'N;'),
            array('admin.modules.add',0,'Allow modules uploading',NULL,'N;'),
            array('admin.modules.down',0,'Allow move modules down',NULL,'N;'),
            array('admin.modules.index',0,'Access modules index',NULL,'N;'),
            array('admin.modules.info',0,'Allow view modules info',NULL,'N;'),
            array('admin.modules.remove',0,'Allow modules removing',NULL,'N;'),
            array('admin.modules.status',0,'Toggle module status',NULL,'N;'),
            array('admin.modules.up',0,'Allow move modules up',NULL,'N;'),
            array('admin.pm.index',0,'PM manager access',NULL,'N;'),
            array('admin.pm.new',0,'Allow send new pm messages',NULL,'N;'),
            array('admin.pm.outbox',0,'PM outbox access',NULL,'N;'),
            array('admin.pm.read',0,'Allow pm read',NULL,'N;'),
            array('admin.pm.remove',0,'Allow pm remove',NULL,'N;'),
            array('admin.pm.settings',0,'PM settings access',NULL,'N;'),
            array('admin.roles.add',0,'Allow add auth items',NULL,'N;'),
            array('admin.roles.edit',0,'Allow edit auth items',NULL,'N;'),
            array('admin.roles.index',0,'Roles manager access',NULL,'N;'),
            array('admin.roles.remove',0,'Allow remove auth items',NULL,'N;'),
            array('admin.settings.index',0,'Allow access to system settings management',NULL,'N;'),
            array('admin.users.add',0,'Allow to add new users',NULL,'N;'),
            array('admin.users.edit',0,'Allow edit user info',NULL,'N;'),
            array('admin.users.index',0,'Allow users manager access',NULL,'N;'),
            array('admin.users.profile',0,'Allow edit user profile',NULL,'N;'),
            array('admin.users.remove',0,'Allow remove users',NULL,'N;'),
            array('admin.users.settings',0,'Users settings access',NULL,'N;'),
            array('administrator',2,'Administrator','','N;'),
            array('authenticated',2,'Authenticated','return !Yii::apparray()->user->getIsGuestarray();','N;'),
            array('guest',2,'Guest','return Yii::apparray()->user->getIsGuestarray();','N;')
        );
        foreach ($authItems as $authArray)
        {
            $db->insert('{{auth_item}}',array(
                'name' => $authArray[0],
                'type' => $authArray[1],
                'description' => $authArray[2],
                'bizrule' => $authArray[3],
                'data' => $authArray[4]
            ));
        }
    }
    
    public function createAuthRelations()
    {
        $db = $this->_connection->createCommand();
        $authRelations = array(
            array('administrator','admin.index'),
            array('administrator','admin.modules.add'),
            array('administrator','admin.modules.down'),
            array('administrator','admin.modules.index'),
            array('administrator','admin.modules.info'),
            array('administrator','admin.modules.remove'),
            array('administrator','admin.modules.status'),
            array('administrator','admin.modules.up'),
            array('administrator','admin.pm.index'),
            array('administrator','admin.pm.new'),
            array('administrator','admin.pm.outbox'),
            array('administrator','admin.pm.read'),
            array('administrator','admin.pm.remove'),
            array('administrator','admin.pm.settings'),
            array('administrator','admin.roles.add'),
            array('administrator','admin.roles.edit'),
            array('administrator','admin.roles.index'),
            array('administrator','admin.roles.remove'),
            array('administrator','admin.settings.index'),
            array('administrator','admin.users.add'),
            array('administrator','admin.users.edit'),
            array('administrator','admin.users.index'),
            array('administrator','admin.users.profile'),
            array('administrator','admin.users.remove'),
            array('administrator','admin.users.settings')
        );
        foreach ($authRelations as $authArray)
        {
            $db->insert('{{auth_item_child}}',array(
                'parent' => $authArray[0],
                'child' => $authArray[1]
            ));
        }
    }
    
    public function createConfiguration()
    {
        $db = $this->_connection->createCommand();
        $settings = array(
            array('pages','admin.pages.page.size','50','Posts page size array(administrative panel)'),
            array('pages','alias.length.max','50','Page alias max length'),
            array('pages','alias.length.min','2','Page alias min length'),
            array('pages','title.length.max','50','Page title max length'),
            array('pages','title.length.min','1','Page title min length'),
            array('pm','message.length.max','3000','description.message.length.max'),
            array('pm','message.length.min','1','description.message.length.min'),
            array('pm','title.length.max','50','description.title.length.max'),
            array('pm','title.length.min','1','description.title.length.min'),
            array('posts','admin.posts.page.size','50','description.admin.posts.page.size'),
            array('posts','alias.length.max','50','description.alias.length.max'),
            array('posts','alias.length.min','2','description.alias.length.min'),
            array('posts','full.length.min','1','description.full.length.min'),
            array('posts','short.length.min','1','description.short.length.min'),
            array('posts','thumbnail.height.max','1000','description.thumbnail.height.max'),
            array('posts','thumbnail.height.min','300','description.thumbnail.height.min'),
            array('posts','thumbnail.quality','80','description.thumbnail.quality'),
            array('posts','thumbnail.resize.enabled','1','description.thumbnail.resize.enabled'),
            array('posts','thumbnail.resize.height','300','description.thumbnail.resize.height'),
            array('posts','thumbnail.resize.width','300','description.thumbnail.resize.width'),
            array('posts','thumbnail.size.max','819200','description.thumbnail.size.max'),
            array('posts','thumbnail.width.max','1000','description.thumbnail.width.max'),
            array('posts','thumbnail.width.min','300','description.thumbnail.width.min'),
            array('posts','title.length.max','80','description.title.length.max'),
            array('posts','title.length.min','2','description.title.length.min'),
            array('system','admin.language','ru','description.admin.language'),
            array('system','admin.template','default','description.admin.template'),
            array('system','admin.time.zone','Europe/Kaliningrad','description.admin.time.zone'),
            array('system','login.duration','604800','description.login.duration'),
            array('system','module.size.max','5242880','description.module.size.max'),
            array('system','url.format','path','description.url.format'),
            array('system','website.language','ru','description.website.language'),
            array('system','website.template','default','description.website.template'),
            array('system','website.time.zone','Europe/Kaliningrad','description.website.time.zone'),
            array('users','name.length.max','20','description.name.length.max'),
            array('users','name.length.min','2','description.name.length.min'),
            array('users','password.length.max','50','description.password.length.max'),
            array('users','password.length.min','6','description.password.length.min'),
            array('users','profile.fields.length.max','50','description.profile.fields.length.max'),
            array('users','profile.fields.length.min','2','description.profile.fields.length.min'),
            array('users','profile.photo.height.max','1000','description.profile.photo.height.max'),
            array('users','profile.photo.height.min','300','description.profile.photo.height.min'),
            array('users','profile.photo.quality','80','description.profile.photo.quality'),
            array('users','profile.photo.resize.enabled','1','description.profile.photo.resize.enabled'),
            array('users','profile.photo.resize.height','300','description.profile.photo.resize.height'),
            array('users','profile.photo.resize.width','300','description.profile.photo.resize.width'),
            array('users','profile.photo.size.max','819200','description.profile.photo.size.max'),
            array('users','profile.photo.width.max','1000','description.profile.photo.width.max'),
            array('users','profile.photo.width.min','300','description.profile.photo.width.min'),
            array('users','role.description.length.max','50','description.role.description.length.max'),
            array('users','role.description.length.min','2','description.role.description.length.min'),
            array('users','role.name.length.max','50','description.role.name.length.max'),
            array('users','role.name.length.min','2','description.role.name.length.min'),
            array('users','users.page.size','50','description.users.page.size')
        );
        foreach ($settings as $setArray)
        {
            $db->insert('{{setting}}',array(
                'category' => $setArray[0],
                'name' => $setArray[1],
                'value' => $setArray[2],
                'description' => $setArray[3]
            ));
        }
    }
    
    public function createAuthAssignment($authItem)
    {
        $db = $this->_connection->createCommand();
        $db->insert('{{auth_assignment}}',array(
            'itemname' => $authItem,
            'userid' => $this->username,
            'bizrule' => null,
            'data' => 'N;'
        ));
    }
    
    /**
     * Create engine configuration file.
     * @return boolean false if configuration pattern not found.
     */
    public function createConfig()
    {
        $source = realpath(Yii::getPathOfAlias('application.patterns')."/{$this->dbType}.php");
        $destination = realpath(Yii::getPathOfAlias('application').'/../engine/settings/database.php');
        if (!file_exists($source))
        {
            $this->addError('dbCnn','Configuration pattern not found!');
            return false;
        }
        $pattern = file_get_contents($source);
        $pattern = str_replace(array(
            '{user}',
            '{password}',
            '{dbname}',
            '{host}',
            '{type}',
            '{prefix}'
        ),array(
            $this->dbUser,
            $this->dbPwd,
            $this->dbName,
            $this->dbHost,
            $this->dbType,
            $this->dbPrefix
        ),$pattern);
        
        file_put_contents($destination,$pattern);
    }
}
?>