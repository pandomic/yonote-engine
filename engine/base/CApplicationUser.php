<?php
class CApplicationUser extends CWebUser implements IApplicationUser
{
    public $dbComponentId = 'db';
    public $userTable = '{{user}}';
    
    /**
     * Find user by username and return his data
     * @param string $username username
     * @return boolean|object false if there is no records found or PDO record object
     */
    public function find($username)
    {
        $db = Yii::app()->db;
        return $db->createCommand()
            ->setFetchMode(PDO::FETCH_OBJ)
            ->select('name,password,token,email')
            ->from($this->userTable)
            ->where('name=:username OR email=:username',array(
                ':username' => $username
            ))
            ->queryRow();
    }
    
    /**
     * Before login action
     * @param string $id username
     * @param array $states a set of name-value pairs that are provided by the user identity.
     * @param type $fromCookie
     * @return boolean
     */
    public function beforeLogin($id,$states,$fromCookie)
    {
        if ($fromCookie)
        {
            $db = Yii::app()->getComponent($id);
            $record = $db->createCommand()
                ->setFetchMode(PDO::FETCH_OBJ)
                ->select('token')
                ->from($this->userTable)
                ->where('name=:username or email=:username',array(
                    ':username' => $id
                ))
                ->queryRow();

            if ($record === false)
                return false;
            else if ($record->token !== Yii::app()->user->getState('token'))
                return false;
        }
        return parent::beforeLogin($id,$states,$fromCookie);
    }
}
?>