<?php
/**
 * CApplicationIdentity class file.
 *
 * @author Vlad Gramuzov <vlad.gramuzov@gmail.com>
 * @link http://yonote.org
 * @copyright 2014 Vlad Gramuzov
 * @license http://yonote.org/licence.html
 */

/**
 * CApplicationIdentity is the base identity class, used for
 * user authentication.
 * 
 * @author Vlad Gramuzov <vlad.gramuzov@gmail.com>
 * @since 1.0
 */
class CApplicationIdentity extends CUserIdentity
{
    private $_id;
    
    /**
     * Authenticate user.
     * @return boolean status.
     * @throws CException if user object is not IApplicationUser descendant.
     */
    public function authenticate(){
        if (!Yii::app()->user instanceof IApplicationUser)
            throw new CException(Yii::t('system','message.invalid.user.interface'));
        $record = Yii::app()->user->find($this->username);
        if ($record === false)
            $this->errorCode = self::ERROR_USERNAME_INVALID;
        else if (!CPasswordHelper::verifyPassword($this->password,$record->password))
            $this->errorCode = self::ERROR_PASSWORD_INVALID;
        else
        {
            $token = CPasswordHelper::generateSalt();
            $this->setState('token',$token);
            $this->_id = $record->name;
            $this->errorCode = self::ERROR_NONE;
            Yii::app()->db->createCommand()->update('{{user}}',array(
                'token' => $token
            ),'name=:username OR email=:username',array(
                ':username' => $this->username
            ));

        }
        return !$this->errorCode;
    }
    
    /**
     * Get current user identifier.
     * @return string user identifier.
     */
    public function getId()
    {
        return $this->_id;
    }
}
?>