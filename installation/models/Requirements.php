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
class Requirements extends CFormModel
{
    public $phpVersion;
    public $serverVars;
    public $phpReflections;
    public $phpPcre;
    public $phpSpl;
    public $phpDom;
    public $phpPdo;
    public $dbInterfaces;
    public $phpMcrypt;
    public $phpBlowfish;
    public $phpCtype;
    public $phpFileInfo;
    public $phpGd;
    public $phpMemcache;
    public $phpApc;
    public $phpSoap;
    
    public $dbType;
    public $dbHost;
    public $dbUser;
    public $dbPwd;
    public $dbName;
    public $dbCnn;
    
    private $_warnings = array();
    
    public function rules()
    {
        return array(
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
            array('dbCnn','checkDbConnection')
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
            $cnn = new CDbConnection(
                "mysql:host={$this->dbHost};dbname={$this->dbName}",
                $this->dbUser,$this->dbPwd
            );
        }
        else if ($this->dbType == 'sqlite')
        {
            $cnn = new CDbConnection("sqlite:{$this->dbName}");
        }
        else if ($this->dbType == 'postgresql')
        {
            $cnn = new CDbConnection(
                "pgsql:host={$this->dbHost};dbname={$this->dbName}",
                $this->dbUser,$this->dbPwd
            );
        }
        else if ($this->dbType == 'oracle')
        {
            $cnn = new CDbConnection("oci:dbname={$this->dbName}");
        }
        else if ($this->dbType == 'mssql')
        {
            $cnn = new CDbConnection(
                "sqlsrv:server={$this->dbHost};Database={$this->dbName}",
                $this->dbUser,$this->dbPwd
            );
        }
        else if ($this->dbType == 'odbc')
        {
            $cnn = new CDbConnection(
                "odbc:DSN={$this->dbName}",
                $this->dbUser,$this->dbPwd
            );
        }
        else
        {
            $this->addError($attribute,'Undefined DB type!');
        }
        if ($this->dbType != null && is_object($cnn))
        {
            if (!$cnn->getActive())
                $this->addError($attribute,'Database connection error!');
        }
    }

    public function init()
    {
        $this->validate();
        return parent::init();
    }
}
?>