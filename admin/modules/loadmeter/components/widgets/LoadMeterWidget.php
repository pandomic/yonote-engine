<?php
/**
 * LoadMeterWidget class file.
 *
 * @author Vlad Gramuzov <vlad.gramuzov@gmail.com>
 * @link http://yonote.org
 * @copyright 2014 Vlad Gramuzov
 * @license http://yonote.org/license.html
 */

/**
 * Loadmeter widget provides system loading information, such as
 * memory used, disk space and etc.
 * 
 * @author Vlad Gramuzov <vlad.gramuzov@gmail.com>
 * @since 1.0
 */
class LoadMeterWidget extends CWidget
{

    /**
     * Init widget.
     * @return LoadMeterWidget instance itself.
     */
    public function init()
    {
        $this->controller->renderPartial('//loadmeter/widget',array(
            'average' => $this->getAverageUsage(),
            'memory' => $this->getMemoryUsage(),
            'disk' => $this->getDiskUsage()
        ));
        return $this;
    }
    
    /**
     * Get average system usage.
     * Note, that this method can not be used on the Windows(tm) platform.
     * @return int average system loading in percents.
     */
    public function getAverageUsage()
    {
        if (function_exists('sys_getloadavg'))
        {
            $usage = sys_getloadavg();
            return $usage[0];
        }
        return 0;
    }
    
    /**
     * Get PHP-memory usage.
     * @return int memory usage in percents.
     */
    public function getMemoryUsage()
    {
        $current = memory_get_usage(true);
        $limit = $this->_returnBytes(ini_get('memory_limit'));
        $usage = 0;
        if ($linit != -1)
            $usage = ceil($current/$limit*100);
        return $usage;
    }
    
    /**
     * Get disk space used.
     * @return int disk space used in percents.
     */
    public function getDiskUsage()
    {
        $total = disk_total_space('/');
        $free = disk_free_space('/');
        $used = $total-$free;
        return ceil($used/$total*100);
    }
    
    /**
     * Used to convert string measurement values to numbers.
     * @param string $val input value.
     * @return int converted number.
     */
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