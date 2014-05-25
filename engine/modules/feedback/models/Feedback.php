<?php
class Feedback extends CFormModel
{
    public $name;
    public $email;
    public $phone;
    public $message;
    public $captcha;
    
    public function rules()
    {
        return array(
            array(
                'name,email,phone,message','required',
                'message' => 'Please, fill all fields!'
            ),
            array(
                'email','email',
                'message' => 'Invalid email'
            ),
            array(
                'name','match','pattern' => '/^[\w\s\-]+$/iu'
            ),
            array(
                'phone','match','pattern' => '/^\+[0-9]{1,4}[0-9]{7,10}$/i',
                'message' => 'Invalid phone number'
            ),
            array(
                'message','length',
                'min' => 10,
                'max' => 1000,
                'tooShort' => 'Too short',
                'tooLong' => 'Too long'
            ),
            array(
                'captcha','captcha',
                'message' => 'Invalid captcha!'
            ),
            array('message','filter','filter' => array($obj = new CHtmlPurifier(),'purify'))
        );
    }
    
    public function send()
    {
        $settings = Yii::app()->settings;
        $mail = Yii::app()->mail->getInstance();
        $mail->setSubject($settings->get('feedback','subject'));
        $mail->setReplyTo($this->email);
        $mail->setFrom($settings->get('feedback','from'));
        $mail->setSender($settings->get('feedback','sender'));
        $mail->setMessage('Проверка');
        $mail->addReceiver($settings->get('feedback','email'));
        $mail->send();
        $errors = $mail->getErrors();
        return empty($errors);
    }
}
?>