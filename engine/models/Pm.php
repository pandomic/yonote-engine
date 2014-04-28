<?php
class Pm extends CActiveRecord
{
    public $touserid;
    public $title;
    public $message;
    
    public function rules()
    {
        return array(
            array(
                'title,message','required',
                'message' => Yii::t('pm','model.pm.error.required')
            ),
            array(
                'touserid','exist','on' => 'inbox,outbox','className' => 'User', 'attributeName' => 'name','allowEmpty' => false,
                'message' => Yii::t('pm','model.pm.error.receiver.invalid')
            ),
            array('message','filter','filter' => array($obj = new CHtmlPurifier(),'purify')),
            array(
                'title','match','pattern' => '/^[\w\s.,\-!?:@]+$/iu',
                'message' => Yii::t('pm','model.pm.error.title.match')
            ),
            array(
                'title','length',
                'min' => Yii::app()->settings->get('pm','title.length.min'),
                'max' => Yii::app()->settings->get('pm','title.length.max'),
                'tooShort' => Yii::t('pm','model.pm.error.title.short'),
                'tooLong' => Yii::t('pm','model.pm.error.title.long')
            ),
            array(
                'message','length',
                'min' => Yii::app()->settings->get('pm','message.length.min'),
                'max' => Yii::app()->settings->get('pm','message.length.max'),
                'tooShort' => Yii::t('pm','model.pm.error.message.short'),
                'tooLong' => Yii::t('pm','model.pm.error.message.long')
            )
        );
    }
    
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
 
    public function tableName()
    {
        return '{{pm}}';
    }
    
    public function relations()
    {
        return array(
            'author' => array(self::BELONGS_TO,'User','senderid')
        );
    }
    
    public function attributeLabels()
    {
        return array(
            'title' => Yii::t('pm','model.pm.title'),
            'message' => Yii::t('pm','model.pm.message'),
            'touserid' => Yii::t('pm','model.pm.touserid')
        );
    }
    
    public function read()
    {
        $this->read = true;
    }
    
    public function inbox()
    {
        $this->inbox = true;
        $this->outbox = false;
    }
    
    public function outbox()
    {
        $this->inbox = false;
        $this->outbox = true;
    }
    
    public function setOwnerId($owner)
    {
        $this->ownerid = $owner;
    }
    
    public function setSenderId($sender)
    {
        $this->senderid = $sender;
    }

    public function beforeSave()
    {
        if ($this->getScenario() == 'inbox')
        {
            $this->updatetime = time();
            $this->inbox = true;
            $this->outbox = false;
            $this->ownerid = $this->touserid;
        }
        else if ($this->getScenario() == 'outbox')
        {
            $this->updatetime = time();
            $this->inbox = false;
            $this->outbox = true;
        }
        return parent::beforeSave();
    }
}
?>