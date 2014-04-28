<?php
class Module extends CActiveRecord
{
    
    public $file;
    public $name;
    public $title;
    public $author;
    public $description;
    public $email;
    public $website;
    public $copyright;
    public $licence;
    public $installed;
    public $updatetime;
    public $position;
    public $version;
    public $max;
    public $min;

    public function rules()
    {
        return array(
            array(
                'file','file',
                'on' => 'add',
                'allowEmpty' => false,
                'maxFiles' => 1,
                'maxSize' => Yii::app()->settings->get('modules','size.max'),
                'types' => array('zip'),
                'tooLarge' => Yii::t('modules','model.module.error.file.large',array(
                    '{filesize}' => Yii::app()->settings->get('modules','size.max')
                )),
                'tooMany' => Yii::t('modules','model.module.error.file.many'),
                'wrongType' => Yii::t('modules','model.module.error.file.type'),
                'message' => Yii::t('modules','model.module.error.file.empty')
            )
        );
    }

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
 
    public function tableName()
    {
        return '{{module}}';
    }
    
    public function beforeSave()
    {
        $this->updatetime = time();
        
        if ($this->scenario == 'add')
        {
            $module = CUploadedFile::getInstance($this,'file');

            // If there is no uploaded file, throw an error
            if ($module === null)
            {
                $this->addError('file',Yii::t('modules','model.module.error.file.error'));
                return false;
            }

            // Check if extension archive exists
            if (!file_exists("phar://{$module->tempName}/info.php"))
            {
                $this->addError('file',Yii::t('modules','model.module.error.file.info'));
                return false;
            }

            // Create new attribute collection with extension info
            $info = new CAttributeCollection();
            $conf = new CConfiguration("phar://{$module->tempName}/info.php");
            $conf->applyTo($info);

            // Check if info file exists
            if (!isset($info->name))
            {
                $this->addError('file',Yii::t('modules','model.module.error.file.name'));
                return false;
            }

            $this->name = $info->name;

            // Try to find current module
            $checkModule = $this->findByPk($info->name);

            if ($checkModule !== null){
                $this->addError('file',Yii::t('modules','model.module.error.exists',array(
                    '{module}' => $info->name
                )));
                return false;
            }

            if (isset($info->title))
                $this->title = $info->title;
            if (isset($info->description))
                $this->description = $info->description;
            if (isset($info->author))
                $this->author = $info->author;
            if (isset($info->email))
                $this->email = $info->email;
            if (isset($info->website))
                $this->website = $info->website;
            if (isset($info->copyright))
                $this->copyright = $info->copyright;
            if (isset($info->licence))
                $this->licence = $info->licence;
            if (isset($info->version))
                $this->version = $info->version;

            $this->installed = true;

            if (!file_exists("phar://{$module->tempName}/frontend"))
            {
                $this->addError('file',Yii::t('modules','model.module.error.frontend'));
                return false;
            }

            if (!file_exists("phar://{$module->tempName}/backend"))
            {
                $this->addError('file',Yii::t('modules','model.module.error.backend'));
                return false;
            }

            if (!file_exists(ADMIN_PATH.'/modules/'.$this->name))
                mkdir(ADMIN_PATH.'/modules/'.$this->name);
            if (!file_exists(ENGINE_PATH.'/modules/'.$this->name))
                mkdir(ENGINE_PATH.'/modules/'.$this->name);

            CFileHelper::copyDirectory(
                "phar://{$module->tempName}/frontend",
                ENGINE_PATH.'/modules/'.$this->name
            );

            CFileHelper::copyDirectory(
                "phar://{$module->tempName}/backend",
                ADMIN_PATH.'/modules/'.$this->name
            );

            $criteria = new CDbCriteria();
            $criteria->select = 'MAX(position) AS max';
            $rec = $this->find($criteria);
            if ($rec !== null)
                $this->position = $rec->max+1;
        }
        return parent::beforeSave();
    }
    
    public function beforeDelete()
    {
        if ($this->name != null)
        {
            CFileHelper::removeDirectory(ADMIN_PATH.'/modules/'.$this->name);
            CFileHelper::removeDirectory(ENGINE_PATH.'/modules/'.$this->name);
        }
        return parent::beforeDelete();
    }

}
?>