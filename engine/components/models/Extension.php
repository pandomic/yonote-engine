<?php
class Extension extends CActiveRecord
{
    public $extension;
    public $select;

    public function rules()
    {
        return array(
            array(
                'extension','file',
                'on' => 'upload',
                'allowEmpty' => false,
                'maxFiles' => 1,
                'maxSize' => Yii::app()->settings->get('extensions.maxSize'),
                'types' => array('zip'),
                'tooLarge' => Yii::t('extensions','File is too large. The maximum filesize is {filesize} bytes.',array(
                    '{filesize}' => Yii::app()->settings->get('extensions.maxSize')
                )),
                'tooMany' => Yii::t('extensions','Only one file can be selected.'),
                'wrongType' => Yii::t('extensions','Only .zip archives allowed.'),
                'message' => Yii::t('extensions','You should select extension to upload.')
            )
        );
    }
    
    public function loadExtension($attribute = 'extension')
    {
        $extension = CUploadedFile::getInstance($this,$attribute);

        if ($extension === null)
        {
            $this->addError($attribute,Yii::t('extensions','There is no files!'));
            return false;
        }

            $newName = uniqid();
            $archive = ENGINE_PATH."/runtime/{$newName}.zip";
            
            $extension->saveAs($archive);

            if (!file_exists("phar://{$archive}/info.php"))
            {
                unlink($archive);
                $this->addError($attribute,Yii::t('extensions','Information file "info.php" not found!'));
                return false;
            }
            
            $info = new CAttributeCollection();
            $conf = new CConfiguration("phar://{$archive}/info.php");
            $conf->applyTo($info);

            if (!isset($info->name))
            {
                unlink($archive);
                $this->addError($attribute,Yii::t('extensions','Parameter "name" not found!'));
                return false;
            }
            
            $checkExtension = self::model()->findByPk($info->name);
            if ($checkExtension !== null){
                unlink($archive);
                $this->addError($attribute,Yii::t('extensions','Extension "{extension}" already exists!',array(
                    '{extension}' => $info->name
                )));
                return false;
            }
            
            $status = true;
            $dirs = array();
            $files = array();
            
            // Create folders
            if (isset($info->folders))
                if (is_array($info->folders))
                {
                    foreach ($info->folders as $folder)
                    {
                        $folder = $this->_substPath($folder);
                        if (!is_dir($folder))
                            if (!mkdir($folder))
                            {
                                $this->addError($attribute,Yii::t('extensions','Cannot create folder "{folder}"!',array(
                                    '{folder}' => $folder
                                )));
                                $status = false;
                            }
                            else
                                $dirs[] = $folder;
                    }
                }
            
            // Move files
            if (isset($info->files))
                if (is_array($info->files))
                {
                    foreach ($info->files as $local => $path)
                    {
                        $path = $this->_substPath($path);
                        if (file_exists("phar://{$archive}/{$local}"))
                        {
                            if (!copy("phar://{$archive}/{$local}",$path))
                            {
                                $this->addError($attribute,Yii::t('extensions','Cannot copy file "{local}" to "{path}"!',array(
                                    '{local}' => $local,'{path}' => $path
                                )));
                                $status = false;
                            }
                            else
                                $files[] = $path;
                        }
                    }
                }
            
            // Register extension
            $extensionModel = new self;
            $extensionModel->name = $info->name;
            $extensionModel->updateTime = time();
            
            if (isset($info->description))
                $extensionModel->description = $info->description;
            if (isset($info->author))
                $extensionModel->author = $info->author;
            if (isset($info->email))
                $extensionModel->email = $info->email;
            if (isset($info->website))
                $extensionModel->website = $info->website;
            if (isset($info->copyright))
                $extensionModel->copyright = $info->copyright;
            if (isset($info->licence))
                $extensionModel->licence = $info->licence;
            if (isset($info->title))
                $extensionModel->title = $info->title;
                
            $extensionModel->save();
            
            // Register modules
            if (isset($info->modules))
                if (is_array($info->modules))
                    foreach ($info->modules as $modParams)
                    {
                        if (is_array($modParams) && count($modParams) == 4)
                        {
                            $moduleModel = new Module();
                            $moduleModel->extension = $info->name;
                            $moduleModel->name = $modParams[0];
                            $moduleModel->priority = $modParams[1];
                            $moduleModel->installed = $modParams[2];
                            $moduleModel->title = $modParams[3];
                            $moduleModel->updateTime = time();
                            
                            if (!$moduleModel->save())
                            {
                                $this->addError($attribute,Yii::t('extensions','Cannot register module "{module}".',array(
                                    '{module}' => $modParams[0]
                                )));
                                $status = false;
                            }
                        }
                    }
            
            // Register widgets
            if (isset($info->widgets))
                if (is_array($info->widgets))
                    foreach ($info->widgets as $widParams)
                    {
                        if (is_array($widParams) && count($widParams) == 4)
                        {
                            $widModel = new Widget();
                            $widModel->extension = $info->name;
                            $widModel->name = $widParams[0];
                            $widModel->classPath = $widParams[1];
                            $widModel->title = $widParams[2];
                            $widModel->description = $widParams[3];
                            $widModel->type = 0;
                            $widModel->updateTime = time();
                            
                            if (!$widModel->save())
                            {
                                $this->addError($attribute,Yii::t('extensions','Cannot register widget "{widget}".',array(
                                    '{widget}' => $widParams[0]
                                )));
                                $status = false;
                            }
                        }
                    }
                
            // Register templates
            if (isset($info->templates))
                if (is_array($info->templates))
                    foreach ($info->templates as $tplName)
                    {
                        $tplModel = new Template();
                        $tplModel->extension = $info->name;
                        $tplModel->name = $tplName;
                        $tplModel->updateTime = time();

                        if (!$tplModel->save())
                        {
                            $this->addError($attribute,Yii::t('extensions','Cannot register template "{template}".',array(
                                '{template}' => $tplParams[0]
                            )));
                            $status = false;
                        }
                    }
                    
            // Remove archive
            unlink($archive);    
                
            // Add error, if any error detected
            if (!$status)
            {
                $this->addError($attribute,Yii::t('extensions','Extension was not installed correctly.',array(
                    '{module}' => $modParams[3]
                )));
            }
            
            /*$extensionModel->data = serialize(array(
                'files' => $files,
                'directories' => $dirs
            ));*/
            
            
            
            return true;

    }
    
    public function attributeLabels()
    {
        return array(
            'extension'=>Yii::t('extensions','Upload extension'),
        );
    }

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
 
    public function tableName()
    {
        return '{{extension}}';
    }
    
    public function relations()
    {
        return array(
            'modules' => array(self::HAS_MANY,'Module','extension'),
            'widgets' => array(self::HAS_MANY,'Widget','extension'),
            'templates' => array(self::HAS_MANY,'Template','extension'),
        );
    }
    
    private function _removeDir($path)
    {
        if (file_exists($path))
        {
            if (is_dir($path))
            {
                $scan = scandir($path);
                foreach ($scan as $file)
                {
                    if (is_dir($file))
                        $this->_removeDir("{$path}/{$file}");
                    else
                        unlink("{$path}/{$file}");
                }
                rmdir($path);
            }
        }
    }
    
    private function _substPath($path)
    {
        return str_replace(array(
            '{engine}','{admin}'
        ),array(
            ENGINE_PATH,ADMIN_PATH
        ),$path);
    }
}
?>