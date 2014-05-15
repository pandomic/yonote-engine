<?php
/**
 * PagesModule class file.
 *
 * @author Vlad Gramuzov <vlad.gramuzov@gmail.com>
 * @link http://yonote.org
 * @copyright 2014 Vlad Gramuzov
 * @license http://yonote.org/license.html
 */

/**
 * This is a simple module class, that provides general access to other
 * module parts.
 * 
 * @author Vlad Gramuzov <vlad.gramuzov@gmail.com>
 * @since 1.0
 */
class PagesModule extends CWebModule
{
    /**
     * Init module.
     * @return void.
     */
    public function init()
    {
        $this->defaultController = 'pages';
        $this->setImport(array(
            'pages.components.*',
            'pages.models.*'
        ));
    }
}
?>