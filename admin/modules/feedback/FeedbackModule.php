<?php
/**
 * FeedbackModule class file.
 *
 * @author Vlad Gramuzov <vlad.gramuzov@gmail.com>
 * @link http://yonote.org
 * @copyright 2014 Vlad Gramuzov
 * @license http://yonote.org/license.html
 */

/**
 * Feedback module class (administrative).
 * Provides a simple feedback form.
 * 
 * @author Vlad Gramuzov <vlad.gramuzov@gmail.com>
 * @since 1.0
 */
class FeedbackModule extends CWebModule
{
    /**
     * Init module.
     * @return void.
     */
    public function init()
    {
        $this->defaultController = 'feedback';
        $this->setImport(array(
            'application.modules.feedback.models.*'
        ));
    }
}
?>