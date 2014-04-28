<?php
/**
 * LanguagesBehavior class file.
 *
 * @author Vlad Gramuzov <vlad.gramuzov@gmail.com>
 * @link http://yonote.org
 * @copyright 2014 Vlad Gramuzov
 * @license http://yonote.org/licence.html
 */

/**
 * Provides the list of Yii languages.
 * 
 * @author Vlad Gramuzov <vlad.gramuzov@gmail.com>
 * @since 1.0
 */
class LanguagesBehavior extends CBehavior
{
    private $_languages = null;
    
    /**
     * Get Yii languages list.
     * @return array languages.
     */
    public function getLanguages()
    {
        if ($this->_languages === null)
        {
            $this->_languages = array();
            $locale = CLocale::getInstance(Yii::app()->getLanguage());
            $ids = $locale->getLocaleIDs();
            foreach ($ids as $name)
                if (($language = $locale->getLocaleDisplayName($name)) !== null)
                    $this->_languages[$name] = "{$language} ({$name})";
        }
        return $this->_languages;
    }
}
?>