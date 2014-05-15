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
     * @var boolean redirect if language param was not given. 
     */
    public $redirectOnDefault = false;
    /**
     * @var string settings component identifier. 
     */
    public $settingsComponentId = 'settings';
    /**
     * @var string default website language version. 
     */
    public $defaultLanguage = 'en';
    
    private $_language;
    private $_languages = array();
    
    /**
     * URL parsing rules
     * @param CHttpRequest $request the request object.
     * @return string parsed URL.
     * @throws CException if no allowed languages were specified.
     * @throws CHttpException if something goes wrong.
     */
    public function parseUrl($request)
    {
        $settings = Yii::app()->getComponent($this->settingsComponentId);
        $this->_languages = explode(',',$settings->get('system','languages'));
        if (!in_array($this->defaultLanguage,$this->_languages))
            throw new CException(Yii::t('system','message.language.undefined',array(
                '{language}' => $this->defaultLanguage
            )));
        if($this->getUrlFormat() === self::PATH_FORMAT)
        {
            $rawPathInfo=$request->getPathInfo();
            $pathInfo=$this->removeUrlSuffix($rawPathInfo,$this->urlSuffix);
            if (($pos = strpos($pathInfo,'/')) === false)
                $pos = mb_strlen($pathInfo);
            $lang = mb_strtolower(substr($pathInfo,0,$pos));
            if (preg_match('/^[a-z]{2,3}$/i',$lang))
            {
                if (!empty($this->_languages))
                {
                    if (in_array($lang,$this->_languages))
                    {
                        $this->_language = $lang;
                        $pathInfo = (string) substr($pathInfo,$pos + 1);
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
            foreach($this->rules as $i => $rule)
            {
                if(is_array($rule))
                        $this->rules[$i] = $rule=Yii::createComponent($rule);
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
            $this->processGetUrlLanguage($_GET['language'],$request,$_GET[$this->routeVar]);
            return $_GET[$this->routeVar];
        }
        elseif(isset($_POST[$this->routeVar]))
        {
            $this->processGetUrlLanguage($_POST['language'],$request,$_POST[$this->routeVar]);
            return $_POST[$this->routeVar];
        }
        else
        {
            $this->processGetUrlLanguage($_GET['language'],$request,'');
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
    public function createUrlDefault($route,$params,$ampersand)
    {
        if($this->getUrlFormat() === self::PATH_FORMAT)
        {
            $slash = ($route{0} == '/') ? '/' : '';
            $lang = $this->_language;
            if (isset($params['language']))
            {
                $lang = $params['language'];
                unset($params['language']);
            }
            if (in_array($lang,$this->_languages))
                $route = $slash.$lang.'/'.$route;
        }
        else
            $params += array('language' => $this->_language);
        return parent::createUrlDefault($route,$params,$ampersand);
    }
    
    /**
     * Used in {@link parseUrl()} method.
     * Checks if necessary language param given and saves current language.
     * If not, redirects to default language secified by the {@link $defaultLanguage}.
     * @param array $param request param to check ($_POST or $_GET).
     * @param CHttpRequest $request request object.
     * @return void.
     */
    public function processGetUrlLanguage($param,$request,$route)
    {
        $param = mb_strtolower($param);
        if (in_array($param,$this->_languages))
            $this->_language = mb_strtolower($param);
        else if ($param == null)
        {
            $this->_language = $this->defaultLanguage;
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
    
    /**
     * Get current URL parsed language.
     * @return string URL language.
     */
    public function getUrlLanguage()
    {
        return $this->_language;
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
     * Sett settings component identifier.
     * @param string $componentId component identifier.
     * @return void.
     */
    public function setSettingsComponentId($componentId)
    {
        $this->settingsComponentId = $componentId;
    }
}
?>