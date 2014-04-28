<?php
class UserWidget extends CWidget
{
    private $_messages = null;
    private $_model = null;
    private $_profile = null;
    private $_inbox = null;
    private $_outbox = null;
    private $_unread = null;
    private $_photo = null;
    
    public function init()
    {
        $this->_model = User::model()->with('profile','pm')->findByPk(Yii::app()->user->getId());
        $this->_messages = $this->_model->pm;
        $this->_profile = $this->_model->profile;
        return $this;
    }
    
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
    
    public function getProfile()
    {
        return $this->_profile;
    }
    
    public function getuser()
    {
        return $this->_model;
    }
    
    public function getPhoto()
    {
        return $this->_profile->getPhoto();
    }
}
?>