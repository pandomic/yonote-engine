<?php
class Extension extends CActiveRecord
{
    public $extension;
    
    private $_files = array();
    private $_folders = array();
    private $_operations = array();
    private $_appends = array();
    
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
            
            if (!file_exists("phar://{$extension->tempName}/info.php"))
            {
                $this->addError($attribute,Yii::t('extensions','Information file "info.php" not found!'));
                return false;
            }
            
            $extension->saveAs($archive);
            
            $this->_appends = array();
            $this->_folders = array();
            $this->_files = array();
            $this->_operations = array();
            
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
                                $this->_folders[] = $folder;
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
                                $this->_files[] = $path;
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
                    
            // Register operations and tasks
            if (isset($info->operations))
                if (is_array($info->operations))
                    foreach ($info->operations as $operation)
                        if (Yii::app()->authManager->getAuthItem($operation[0]) === null)
                        {
                            Yii::app()->authManager->createOperation(
                                $operation[0],
                                $operation[1]
                            );

                            $this->_operations[] = $operation[0];

                            if (is_array($operation[2]))
                                foreach ($operation[2] as $task)
                                {
                                    $taskObj = Yii::app()->authManager->createTask(
                                        $task[0],$task[1],$task[2]
                                    );
                                    $taskObj->addChild($operation[0]);
                                }
                        }
                    
            // Append files
            if (isset($info->appends))
                if (is_array($info->appends))
                    foreach ($info->appends as $append)
                    {
                        $path = $this->_substPath($append[1]);
                        if (file_exists("phar://{$archive}/{$append[0]}"))
                            if (file_exists($path))
                            {
                                $file = file_get_contents("phar://{$archive}/{$append[0]}");
                                
                                $this->_appends[] = array(
                                    $path,$file
                                );
                                
                                if (isset($append[2]))
                                {
                                    $original = file_get_contents($path);
                                    $pos = mb_strpos($original,$append[2]);
                                    file_put_contents($path,substr_replace(
                                        $original,$append[2].$file,$pos,mb_strlen($append[2])
                                    ));
                                }
                                else
                                {
                                    file_put_contents($path,$file,FILE_APPEND);
                                }
                            }
                    }
                    
            // Remove archive
            unlink($archive);    
                
            // Add error, if any error detected
            if (!$status)
            {
                self::model()->findByPk($info->name)->delete();
                $this->_removeComponents();
                $this->addError($attribute,Yii::t('extensions','Extension was not installed!'));
                return false;
            }
            
            $model = self::model()->findByPk($info->name);
            $model->data = serialize(array(
                'files' => $this->_files,
                'folders' => $this->_folders,
                'operations' => $this->_operations,
                'appends' => $this->_appends
            ));
            $model->save();

            return true;

    }
    
    public function removeExtensions($extension)
    {
        $c = 0;
        $extensions = self::model()->findAllByPk($extension);
        if (count($extensions) > 0)
        {
            foreach ($extensions as $extension)
            {
                $data = unserialize($extension->data);
                $this->_appends = $data['appends'];
                $this->_folders = $data['folders'];
                $this->_files = $data['files'];
                $this->_appends = $data['appends'];
                $this->_removeComponents();
                $extension->delete();
                $c++;
            }
        }
        return $c;
    }
    
    private function _removeComponents()
    {
        $dirs = array_reverse($this->_folders);
        foreach ($this->_files as $file)
            unlink($file);
        foreach ($dirs as $dir)
            rmdir($dir);
        foreach ($this->_appends as $append)
            if (file_exists($append[0]))
            {
                $file = file_get_contents($append[0]);
                file_put_contents($append[0],str_replace($append[1],'',$file));
            }
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