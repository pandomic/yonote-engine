<?php
/**
 * CApplicationUrlManager class file.
 *
 * @author Vlad Gramuzov <vlad.gramuzov@gmail.com>
 * @link http://yonote.org
 * @copyright 2014 Vlad Gramuzov
 * @copyright 2008-2013 Yii Software LLC
 * @license http://yonote.org/licence.html
 */

/**
 * This class allows to orginize  multilingual URLs.
 * e.g. http://yoursite.com/en for PATH format or
 * http://yoursite.com?r=someroute&language=en.
 * 
 * Baed on the Yii-native CUrlManager class code.
 * 
 * All paths are generating automaticly based on allowed languages list.
 * 
 * If {@link $redirectOnDefault} is set to "true" and no any language param specified,
 * user will be redirected to default language version, specified by the {@link $defaultLanguage}.
 * 
 * @author Vlad Gramuzov <vlad.gramuzov@gmail.com>
 * @since 1.0
 */
class CApplicationUrlManager extends CUrlManager
{
    /**
     * @var string default website language version. 
     */
    public $defaultLanguage = 'en';
    public $multilangEnabled = true;
    public $languages = array();
    public $redirectOnDefault = false;
    
    private $_langChanged = false;
    private $_rules = array();
    
    public $settingsComponentId = 'settings';
    
    public function init()
    {
        $settings = Yii::app()->getComponent($this->settingsComponentId);
        $this->defaultLanguage = Yii::app()->getLanguage();
        $this->urlFormat = $settings->get('system','url.format');
        $this->multilangEnabled = $settings->get('system','url.multilingual',true);
        $this->languages = explode(',',$settings->get('system','languages'));
        $this->redirectOnDefault = $settings->get('system','url.redirectondefault',true);
    }

    /**
     * Add URL rules.
     * @param array $rules rules to add.
     * @param boolean $append append to existing rules.
     */
    public function addRules($rules,$append=true)
    {
        if ($append)
        {
            foreach($rules as $pattern=>$route)
                $this->_rules[]=$this->createUrlRule($route,$pattern);
        }
        else
        {
            $rules=array_reverse($rules);
            foreach($rules as $pattern=>$route)
                array_unshift($this->_rules,$this->createUrlRule($route,$pattern));
        }
        parent::addRules($rules,$append);
    }
    
    /**
     * URL parsing rules
     * @param CHttpRequest $request the request object.
     * @return string parsed URL.
     * @throws CException if no allowed languages were specified.
     * @throws CHttpException if something goes wrong.
     */
    public function parseUrl($request)
    {
        if (!in_array($this->defaultLanguage,$this->languages))
            throw new CException(Yii::t('system','message.language.undefined',array(
                '{language}' => $this->defaultLanguage
            )));
        if($this->getUrlFormat() === self::PATH_FORMAT)
        {
            $rawPathInfo = $request->getPathInfo();
            if ($this->multilangEnabled)
            {
                if (($pos = strpos($rawPathInfo,'/')) === false)
                    $pos = mb_strlen($rawPathInfo);
                $lang = mb_strtolower(substr($rawPathInfo,0,$pos));
                if ($lang != null)
                {
                    if (!empty($this->languages))
                    {
                        if (in_array($lang,$this->languages))
                        {
                            $this->setLanguage($lang);
                            $rawPathInfo = (string) substr($rawPathInfo,$pos + 1);
                        }
                    }
                    else
                        throw new CException(Yii::t('system','message.languages.empty'));
                }
                else if ($lang == null)
                {
                    if ($this->redirectOnDefault)
                        $request->redirect($this->baseUrl."/{$this->defaultLanguage}");
                }
            }
            $pathInfo = $this->removeUrlSuffix($rawPathInfo,$this->urlSuffix);
            foreach($this->_rules as $i => $rule)
            {
                if(is_array($rule))
                    $this->_rules[$i] = $rule=Yii::createComponent($rule);
                if(($r = $rule->parseUrl($this,$request,$pathInfo,$rawPathInfo)) !== false)
                    return isset($_GET[$this->routeVar]) ? $_GET[$this->routeVar] : $r;
            }
            if($this->useStrictParsing)
                throw new CHttpException(404,Yii::t('yii','Unable to resolve the request "{route}".',
                    array('{route}' => $pathInfo)));
            else
                return $pathInfo;
        }
        elseif(isset($_GET[$this->routeVar]))
        {
            $this->_paramLanguage(
                $_GET['language'],$request,$_GET[$this->routeVar]
            );
            return $_GET[$this->routeVar];
        }
        elseif(isset($_POST[$this->routeVar]))
        {
            $this->_paramLanguage(
                $_POST['language'],$request,$_POST[$this->routeVar]
            );
            return $_POST[$this->routeVar];
        }
        else
        {
            $this->_paramLanguage(
                $_GET['language'],$request,''
            );
            return '';
        }
    }
    
    /**
     * URL forming rules.
     * @param string $route route.
     * @param array $params URL params.
     * @param string $ampersand default params glue.
     * @return string formed URL.
     */
    public function createUrl($route,$params=array(),$ampersand='&')
    {
        if ($this->multilangEnabled)
        {
            if($this->getUrlFormat() === self::PATH_FORMAT)
            {
                $original = parent::createUrl($route,$params,$ampersand);
                $slash = ($original{0} == '/') ? '/' : '';
                $lang = Yii::app()->getLanguage();

                if (isset($params['language']))
                {
                    $lang = $params['language'];
                    unset($params['language']);
                }
                else if (in_array($lang,$this->languages) && $lang != $this->defaultLanguage)
                    return $slash.$lang.'/'.ltrim($original,'/');
            }
            else if (Yii::app()->getLanguage() != $this->defaultLanguage)
                $params['language'] = Yii::app()->getLanguage();
        }
        return parent::createUrl($route,$params,$ampersand);
    }
    
    /**
     * Used in {@link parseUrl()} method.
     * Checks if necessary language param given and saves current language.
     * If not, redirects to default language secified by the {@link $defaultLanguage}.
     * @param array $param request param to check ($_POST or $_GET).
     * @param CHttpRequest $request request object.
     * @return void.
     */
    private function _paramLanguage($param,$request,$route)
    {
        if ($this->multilangEnabled)
        {
            $param = mb_strtolower($param);
            if (in_array($param,$this->languages))
                $this->setLanguage(mb_strtolower($param));
            else if ($param == null)
            {
                $this->setLanguage(mb_strtolower($this->defaultLanguage));
                if ($this->redirectOnDefault)
                {
                    if($this->getUrlFormat() === self::PATH_FORMAT)
                        $request->redirect($this->baseUrl."/{$this->defaultLanguage}");
                    else
                        $request->redirect($this->createUrl($route,array('language' => $this->defaultLanguage) + $_GET));
                }
            }
            else
                throw new CHttpException(404,Yii::t('yii','Unable to resolve the request "{route}".',
                    array('{route}' => $route)));
        }
    }
    
    /**
     * Used to set current app language.
     * @param string $language language.
     */
    public function setLanguage($language)
    {
        if ($this->multilangEnabled && !$this->_langChanged)
        {
            Yii::app()->setLanguage($language);
            $this->_langChanged = true;
        }
    }
    
    /**
     * Set if user should be redirected to default language version,
     * if no any version specified in URL.
     * @param boolean $redirect redirect or not.
     * @return void.
     */
    public function setRedirectOnDefault($redirect)
    {
        $this->redirectOnDefault = $redirect;
    }
    
    /**
     * Set default language.
     * @param string $language language.
     * @return void.
     */
    public function setDefaultLanguage($language)
    {
        $this->defaultLanguage = $language;
    }
    
    /**
     * Set allowed languages.
     * @param array $languages languages.
     */
    public function setLanguages($languages)
    {
        $this->languages = $languages;
    }
    
    /**
     * Allow to use multilingual URLs.
     * @param boolean $status use/or not.
     */
    public function setMultilangEnabled($status)
    {
        $this->multilangEnabled = $status;
    }
}
?>