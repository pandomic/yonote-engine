<?php
/**
 * Pm class file.
 *
 * @author Vlad Gramuzov <vlad.gramuzov@gmail.com>
 * @link http://yonote.org
 * @copyright 2014 Vlad Gramuzov
 * @license http://yonote.org/license.html
 */

/**
 * Pm model helps to manage and send personal messages.
 * 
 * @author Vlad Gramuzov <vlad.gramuzov@gmail.com>
 * @since 1.0
 */
class Pm extends CActiveRecord
{
    /**
     * @var string receiver id.
     */
    public $touserid;
    /**
     * @var string message title.
     */
    public $title;
    /**
     * @var type message content.
     */
    public $message;
    
    /**
     * Validation rules.
     * @return array validation rules.
     */
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
    
    /**
     * Return static model of Pm.
     * @param string $className current class name.
     * @return Pm object.
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
    
    /**
     * Model database table name.
     * @return string table name.
     */
    public function tableName()
    {
        return '{{pm}}';
    }
    
    /**
     * Model relations.
     * Relations:
     *     author - message sender.
     * @return array relations.
     */
    public function relations()
    {
        return array(
            'author' => array(self::BELONGS_TO,'User','senderid')
        );
    }
    
    /**
     * Attribute labels.
     * @return array attribute labels.
     */
    public function attributeLabels()
    {
        return array(
            'title' => Yii::t('pm','model.pm.title'),
            'message' => Yii::t('pm','model.pm.message'),
            'touserid' => Yii::t('pm','model.pm.touserid')
        );
    }
    
    /**
     * Mark current message as read.
     * @return void.
     */
    public function read()
    {
        $this->read = true;
    }
    
    /**
     * Mark current message as inbox.
     * @return void.
     */
    public function inbox()
    {
        $this->inbox = true;
        $this->outbox = false;
    }
    
    /**
     * Mark current message as outbox.
     * @return void.
     */
    public function outbox()
    {
        $this->inbox = false;
        $this->outbox = true;
    }
    
    /**
     * Set message owner.
     * @param string $owner user id.
     * @return void.
     */
    public function setOwnerId($owner)
    {
        $this->ownerid = $owner;
    }
    
    /**
     * Set message sender.
     * @param string $sender user id.
     * @return void.
     */
    public function setSenderId($sender)
    {
        $this->senderid = $sender;
    }
    
    /**
     * Action, that will be executed before model will be saved.
     * Upload and process module archive.
     * @return boolean parent beforeSave() status.
     */
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