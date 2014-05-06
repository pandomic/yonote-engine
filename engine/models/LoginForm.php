<?php
/**
 * LoginForm class file.
 *
 * @author Vlad Gramuzov <vlad.gramuzov@gmail.com>
 * @link http://yonote.org
 * @copyright 2014 Vlad Gramuzov
 * @license http://yonote.org/license.html
 */

/**
 * LoginForm model is used to process login requests.
 * 
 * @author Vlad Gramuzov <vlad.gramuzov@gmail.com>
 * @since 1.0
 */
class LoginForm extends CFormModel
{
    private $_identity = null;
    
    /**
     * @var string user name.
     */
    public $name;
    /**
     * @var string user password.
     */
    public $password;
    /**
     * @var boolean remember user.
     */
    public $rememberMe = false;
    
    /**
     * Validation rules.
     * @return array validation rules.
     */
    public function rules()
    {
        return array(
            array(
                'name,password','required',
                'message' => Yii::t('login','model.loginform.error.required')
            ),
            array('rememberMe','boolean','on' => 'login'),
            array('password','authenticateRule','on' => 'login')
        );
    }
    
    /**
     * Attribute labels.
     * @return array attribute labels.
     */
    public function attributeLabels()
    {
        return array(
            'rememberMe' => Yii::t('login','model.loginform.remember'),
            'name' => Yii::t('login','model.loginform.name'),
            'password' => Yii::t('login','model.loginform.password')
        );
    }
    
    /**
     * Validation rule.
     * Check user password.
     * @param string $attribute attribute name.
     * @param array $params additional params.
     * @return void.
     */
    public function authenticateRule($attribute,$params)
    {
        $this->_identity = new CApplicationIdentity($this->name,$this->password);
        if (!$this->_identity->authenticate())
            $this->addError('password',Yii::t('login','model.loginform.error.login'));
            
    }
    
    /**
     * Login process.
     * @return boolean user successfully logged.
     */
    public function login()
    {
        if ($this->_identity === null)
        {
            $this->_identity = new CApplicationIdentity($this->name,$this->password);
            $this->_identity->authenticate();
        }
        if ($this->_identity->errorCode == CApplicationIdentity::ERROR_NONE)
        {
            $duration = ($this->rememberMe) ? 
                Yii::app()->settings->get('system','login.duration') : 0;
            
            Yii::app()->user->login($this->_identity,$duration);
            
            return true;
        }
        
        $this->addError('password',Yii::t('login','model.loginform.error.login'));
        return false;
    }
}
?>