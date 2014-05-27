<?php
class Feedback extends CActiveRecord
{
    public $name;
    public $email;
    public $phone;
    public $message;
    public $captcha;
    
    private $_msgTmpl;
    
    /**
     * Return static model of AuthItem.
     * @param string $className current class name.
     * @return Feedback object.
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
        return '{{mod_feedback}}';
    }
    
    public function rules()
    {
        return array(
            array(
                'name,email,phone,message','required',
                'message' => Yii::t('FeedbackModule.feedback','model.feedback.error.required')
            ),
            array(
                'email','email',
                'message' => Yii::t('FeedbackModule.feedback','model.feedback.error.email')
            ),
            array(
                'name','match','pattern' => '/^[\w\s\-]+$/iu',
                'message' => Yii::t('FeedbackModule.feedback','model.feedback.error.name.match')
            ),
            array(
                'phone','match','pattern' => '/^\+[0-9]{1,4}[0-9]{7,10}$/i',
                'message' => Yii::t('FeedbackModule.feedback','model.feedback.error.phone.match')
            ),
            array(
                'message','length',
                'min' => 10,
                'max' => 1000,
                'tooShort' => Yii::t('FeedbackModule.feedback','model.feedback.error.message.short'),
                'tooLong' => Yii::t('FeedbackModule.feedback','model.feedback.error.message.long')
            ),
            array(
                'captcha','captcha',
                'message' => Yii::t('FeedbackModule.feedback','model.feedback.error.captcha')
            ),
            array('message','filter','filter' => array($obj = new CHtmlPurifier(),'purify'))
        );
    }
    
    public function attributeLabels()
    {
        return array(
            'name' => Yii::t('FeedbackModule.feedback','model.feedback.name'),
            'email' => Yii::t('FeedbackModule.feedback','model.feedback.email'),
            'phone' => Yii::t('FeedbackModule.feedback','model.feedback.phone'),
            'message' => Yii::t('FeedbackModule.feedback','model.feedback.message'),
            'captcha' => Yii::t('FeedbackModule.feedback','model.feedback.captcha')
        );
    }
    
    public function setMessageTemplate($template)
    {
        $this->_msgTmpl = $template;
    }
    
    public function beforeSave()
    {
        $this->updatetime = time();
        return parent::beforeSave();
    }

    public function save($runValidation = true,$attributes = NULL)
    {
        if (!parent::save())
            return false;
        if (!Yii::app()->settings->get('feedback','sendmail',true))
            return true;
        $settings = Yii::app()->settings;
        $mail = Yii::app()->mail->getInstance();
        $mail->setSubject($settings->get('feedback','subject'));
        $mail->setReplyTo($this->email);
        $mail->setFrom($settings->get('feedback','from'));
        $mail->setSender($settings->get('feedback','sender'));
        $mail->setMessage($this->_msgTmpl);
        $mail->addReceiver(explode(',',$settings->get('feedback','email')));
        $mail->send();
        $errors = $mail->getErrors();
        return empty($errors);
    }
}
?>