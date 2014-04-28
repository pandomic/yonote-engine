<?php
/**
 * CApplicationUser class file.
 *
 * @author Vlad Gramuzov <vlad.gramuzov@gmail.com>
 * @link http://yonote.org
 * @copyright 2014 Vlad Gramuzov
 * @license http://yonote.org/licence.html
 */

/**
 * CApplicationUser is the base YOnote ENGINE user class,
 * inherited from CWebUser and IApplicationUser, that
 * provide cookies-based authentication model.
 * 
 * @author Vlad Gramuzov <vlad.gramuzov@gmail.com>
 * @since 1.0
 */
class CApplicationUser extends CWebUser implements IApplicationUser
{
    /**
     * @var string database component identifier.
     */
    public $dbComponentId = 'db';
    /**
     * @var users database table. 
     */
    public $userTable = '{{user}}';
    
    /**
     * Find user by username and return info as object.
     * @param string $username username.
     * @return boolean|object false if there is no records found or PDO record.
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
     * Before login action.
     * @param string $id username.
     * @param array $states a set of name-value pairs that are provided by the user identity.
     * @param boolean $fromCookie login obtained through the cookies?
     * @return boolean beforeLogin() status
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