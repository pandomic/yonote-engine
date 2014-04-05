<?php
class CApplicationController extends CController
{
    /**
     * @var array page widgets 
     */
    public $widgets;
    /**
     * @var int current page id
     */
    public $pid = -1;
    
    private $_done = false;
    
    /**
     * Get widgets on a specified position
     * @param string $position widget position
     * @param boolean $captureOutput whether to capture the output of the widgets
     * @return string 
     */
    public function widgetPos($position,$captureOutput=false)
    {
        if (!$this->_done)
        {
            Yii::app()->wmanager->setCurrentPid($this->pid);
            $this->widgets = Yii::app()->wmanager->getWidgets();
        }
        
        $output = (isset($this->widgets[$position])) ? $this->widgets[$position] : NULL;
        
        if ($captureOutput)
            return $output;
        else
            echo $output;
        
    }
    
    /**
     * Set current page id
     * @param int $pid page id
     */
    public function setPid($pid)
    {
        $this->pid = $pid;
    }
    
    /**
     * Get current page id
     * @return int page id
     */
    public function getPid()
    {
        return $this->pid;
    }
}
?>