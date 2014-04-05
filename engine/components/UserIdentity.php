<?php
class UserIdentity extends CUserIdentity
{
    private $_id;
    
    public function authenticate(){
        if (!Yii::app()->user instanceof IApplicationUser)
            throw new CException(Yii::t('system','user access class must be implemented from IApplicationUser interface.'));
        $record = Yii::app()->user->find($this->username);
        if ($record === false)
            $this->errorCode = self::ERROR_USERNAME_INVALID;
        else if (!CPasswordHelper::verifyPassword($this->password,$record->password))
            $this->errorCode = self::ERROR_PASSWORD_INVALID;
        else
        {
            $this->setState('token',$record->token);
            $this->_id = $record->username;
            $this->errorCode = self::ERROR_NONE;
            
            Yii::app()->db->createCommand()->update('{{user}}',array(
                'token' => CPasswordHelper::generateSalt()
            ),'username=:username OR email=:username',array(
                ':username' => $this->username
            ));

        }
        return !$this->errorCode;
    }
    
    public function getId()
    {
        return $this->_id;
    }
}
?>