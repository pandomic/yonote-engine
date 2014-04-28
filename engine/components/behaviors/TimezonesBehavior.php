<?php
/**
 * TimezonesBehavior class file.
 *
 * @author Vlad Gramuzov <vlad.gramuzov@gmail.com>
 * @link http://yonote.org
 * @copyright 2014 Vlad Gramuzov
 * @license http://yonote.org/licence.html
 */

/**
 * Provides the list of PHP timezones.
 * 
 * @author Vlad Gramuzov <vlad.gramuzov@gmail.com>
 * @since 1.0
 */
class TimezonesBehavior extends CBehavior
{
    private $_timezones = null;

    /**
     * Get Yii languages list.
     * @return array languages.
     */
    public function getTimezones()
    {
        if ($this->_timezones === null)
        {
            $this->_timezones = array();
            $phpTimezones = timezone_identifiers_list();
            foreach ($phpTimezones as $k => $v)
            {
                $timezone = Yii::t('timezones',$v);
                $this->_timezones[$v] = "{$timezone} ({$v})";
            } 
        }
        return $this->_timezones;
    }
}
?>