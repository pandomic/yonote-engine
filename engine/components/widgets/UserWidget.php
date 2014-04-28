<?php
/**
 * UserWidget class file.
 *
 * @author Vlad Gramuzov <vlad.gramuzov@gmail.com>
 * @link http://yonote.org
 * @copyright 2014 Vlad Gramuzov
 * @license http://yonote.org/licence.html
 */

/**
 * Allows to access to different user information and user model.
 * init() method returns UserWidget self-instance, so you can access
 * widget methods inside of beginWidget() and endWidget() methods.
 * 
 * @author Vlad Gramuzov <vlad.gramuzov@gmail.com>
 * @since 1.0
 */
class UserWidget extends CWidget
{
    private $_messages = null;
    private $_model = null;
    private $_profile = null;
    private $_inbox = null;
    private $_outbox = null;
    private $_unread = null;
    
    /**
     * Start widget.
     * @return UserWidget instance itself.
     */
    public function init()
    {
        $this->_model = User::model()->with('profile','pm')->findByPk(Yii::app()->user->getId());
        $this->_messages = $this->_model->pm;
        $this->_profile = $this->_model->profile;
        return $this;
    }
    
    /**
     * Get inbox messages count.
     * @return integer messages count.
     */
    public function getInboxCount()
    {
        if ($this->_inbox !== null)
            return $this->_inbox;
        $this->_inbox = 0;
        foreach ($this->_messages as $model)
            if ((boolean) $model->inbox)
                $this->_inbox++;
        return $this->_inbox;
    }
    
    /**
     * Get outbox messages count.
     * @return integer messages count.
     */
    public function getOutboxCount()
    {
        if ($this->_outbox !== null)
            return $this->_outbox;
        $this->_outbox = 0;
        foreach ($this->_messages as $model)
            if ((boolean) $model->outbox)
                $this->_outbox++;
        return $this->_outbox;
    }
    
    /**
     * Get unread messages count.
     * @return integer messages count.
     */
    public function getUnreadCount()
    {
        if ($this->_unread !== null)
            return $this->_unread;
        $this->_unread = 0;
        foreach ($this->_messages as $model)
            if ((boolean) $model->inbox && (boolean) !$model->read)
                $this->_unread++;
        return $this->_unread;
    }
    
    /**
     * Get user profile active record model.
     * @return Profile user profile.
     */
    public function getProfile()
    {
        return $this->_profile;
    }
    
    /**
     * Get user active record model.
     * @return User user model.
     */
    public function getUser()
    {
        return $this->_model;
    }
    
    /**
     * Get user photo path.
     * @return string|boolean user photo or false, if not found.
     */
    public function getPhoto()
    {
        return $this->_profile->getPhoto();
    }
}
?>