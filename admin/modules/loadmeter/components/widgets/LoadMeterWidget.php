<?php
class LoadMeterWidget extends CWidget
{

    public function init()
    {
        $this->controller->renderPartial('//loadmeter/widget',array(
            'average' => $this->getAverageUsage(),
            'memory' => $this->getMemoryUsage(),
            'disk' => $this->getDiskUsage()
        ));
        return $this;
    }
    
    public function getAverageUsage()
    {
        if (function_exists('sys_getloadavg'))
        {
            $usage = sys_getloadavg();
            return $usage[0];
        }
        return 0;
    }
    
    public function getMemoryUsage()
    {
        $current = memory_get_usage(true);
        $limit = $this->_returnBytes(ini_get('memory_limit'));
        $usage = 0;
        if ($linit != -1)
            $usage = ceil($current/$limit*100);
        return $usage;
    }
    
    public function getDiskUsage()
    {
        $total = disk_total_space('/');
        $free = disk_free_space('/');
        $used = $total-$free;
        return ceil($used/$total*100);
    }
    
    private function _returnBytes($val)
    {
        $val = trim($val);
        $last = strtolower($val[strlen($val)-1]);
        switch($last) {
            case 'g': $val *= 1024;
            case 'm': $val *= 1024;
            case 'k': $val *= 1024;
        }
        return $val;
    }
    
}
?>