<?php
/**
 * CHeaders class file.
 *
 * @author Vlad Gramuzov <vlad.gramuzov@gmail.com>
 * @link http://
 * @copyright 201
 * @license http://
 */

/**
 * Headers management class
 */
class CHeaders extends CApplicationComponent implements IHeaders
{
    /**
     * @var string content charset 
     */
    public $charset = 'utf-8';
    
    /**
     * Set response content-type
     * @param int $flag conent-type flag
     * @param int $lastMod last modified attr
     * @return CHeaders self-object
     * @throws CException if header flag is undefined
     */
    public function mime($flag = self::HEADER_TEXT_HTML,$lastMod = null)
    {
        switch ($flag)
        {
            case self::HEADER_TEXT_HTML : $type = 'text/html';
            break;
        
            case self::HEADER_TEXT_JS : $type = 'text/javascript';
            break;
        
            case self::HEADER_TEXT : $type = 'text/plain';
            break;
        
            case self::HEADER_TEXT_CSS : $type = 'text/css';
            break;
        
            case self::HEADER_IMAGE_PNG : $type = 'image/png';
            break;
        
            case self::HEADER_IMAGE_GIF : $type = 'image/gif';
            break;
        
            case self::HEADER_TEXT_CSV : $type= 'text/csv';
            break;
        
            case self::HEADER_TEXT_XML : $type = 'text/xml';
            break;
        
            case self::HEADER_IMAGE_JPEG : $type = 'image/jpeg';
            break;
        
            case self::HEADER_IMAGE_TIFF : $type = 'image/tiff';
            break;
        
            case self::HEADER_AUDIO_MP4 : $type = 'audio/mp4';
            break;
        
            case self::HEADER_AUDIO_MPEG : $type = 'audio/mpeg';
            break;
        
            case self::HEADER_AUDIO_OGG : $type = 'audio/ogg';
            break;
        
            case self::HEADER_AUDIO_VORBIS : $type = 'audio/vorbis';
            break;
        
            case self::HEADER_AUDIO_WAVE : $type = 'audio/vnd.wave';
            break;
        
            case self::HEADER_AUDIO_WEBM : $type = 'audio/webm';
            break;
        
            case self::HEADER_APP_GZIP : $type = 'application/gzip';
            break;
        
            case self::HEADER_APP_ZIP : $type = 'application/zip';
            break;
        
            case self::HEADER_APP_OGG : $type = 'application/ogg';
            break;
        
            case self::HEADER_APP_PDF : $type = 'application/pdf';
            break;
        
            case self::HEADER_APP_JSON : $type = 'application/json';
            break;
        
            default :
                throw new CException(Yii::t('system','Invalid "Content-type" flag'));;
            break;
        }
        
        header("Content-type:{$type}; Charset={$this->charset}");
        
        if ($lastMod !== null)
        {
            $lastMod = date("D, d M Y H:i:s",$lastMod) . 'GMT';
            header("Last-Modified: {$lastMod}");
        }

        return $this;
    }
    
    /**
     * Set response status
     * @param int $code response code
     * @return CHeaders self-object
     * @throws CException if status code is undefined
     */
    public function status($code)
    {
        
        $status = '';
        switch($code)
        {
            case 100 : $status = '100 Continue';
            break;
        
            case 101 : $status = '101 Switching Protocols';
            break;
        
            case 102 : $status = '102 Processing';
            break;
            
            case 200 : $status = '200 OK';
            break;
        
            case 201 : $status = '201 Created';
            break;
        
            case 202 : $status = '202 Accepted';
            break;
        
            case 203 : $status = '203 Non-Authoritative Information';
            break;
        
            case 204 : $status = '204 No Content';
            break;
        
            case 205 : $status = '205 Reset Content';
            break;
        
            case 206 : $status = '206 Partial Content';
            break;
        
            case 207 : $status = '207 Multi-Status';
            break;
        
            case 226 : $status = '226 IM Used';
            break;
            
            case 300 : $status = '300 Multiple Choices';
            break;
        
            case 301 : $status = '301 Moved Permanently';
            break;
        
            case 302 : $status = '302 Found';
            break;
        
            case 303 : $status = '303 See Other';
            break;
        
            case 304 : $status = '304 Not Modified';
            break;
        
            case 305 : $status = '305 Use Proxy';
            break;
        
            case 307 : $status = '307 Temporary Redirect';
            break;
            
            case 400 : $status = '400 Bad Request';
            break;
        
            case 401 : $status = '401 Unauthorized';
            break;
        
            case 402 : $status = '402 Payment Required';
            break;
        
            case 403 : $status = '403 Forbidden';
            break;
        
            case 404 : $status = '404 Not Found';
            break;
        
            case 405 : $status = '405 Method Not Allowed';
            break;
        
            case 406 : $status = '406 Not Acceptable';
            break;
        
            case 407 : $status = '407 Proxy Authentication Required';
            break;
        
            case 408 : $status = '408 Request Timeout';
            break;
        
            case 409 : $status = '409 Conflict';
            break;
        
            case 410 : $status = '410 Gone';
            break;
        
            case 411 : $status = '411 Length Required';
            break;
        
            case 412 : $status = '412 Precondition Failed';
            break;
        
            case 413 : $status = '413 Request Entity Too Large';
            break;
        
            case 414 : $status = '414 Request-URI Too Large';
            break;
        
            case 415 : $status = '415 Unsupported Media Type';
            break;
        
            case 416 : $status = '416 Requested Range Not Satisfiable';
            break;
        
            case 417 : $status = '417 Expectation Failed';
            break;
        
            case 422 : $status = '422 Unprocessable Entity';
            break;
        
            case 423 : $status = '423 Locked';
            break;
        
            case 424 : $status = '424 Failed Dependency';
            break;
        
            case 425 : $status = '425 Unordered Collection';
            break;
        
            case 426 : $status = '426 Upgrade Required';
            break;
        
            case 449 : $status = '449 Retry With';
            break;
        
            case 456 : $status = '456 Unrecoverable Error';
            break;
            
            case 500 : $status = '500 Internal Server Error';
            break;
        
            case 501 : $status = '501 Not Implemented';
            break;
        
            case 502 : $status = '502 Bad Gateway';
            break;
        
            case 503 : $status = '503 Service Unavailable';
            break;
        
            case 504 : $status = '504 Gateway Timeout';
            break;
        
            case 505 : $status = '505 HTTP Version Not Supported';
            break;
        
            case 506 : $status = '506 Variant Also Negotiates';
            break;
        
            case 507 : $status = '507 Insufficient Storage';
            break;
        
            case 508 : $status = '508 Loop Detected';
            break;
        
            case 509 : $status = '509 Bandwidth Limit Exceeded';
            break;
        
            case 510 : $status = '510 Not Extended';
            break;
        
            default :
                throw new CException(Yii::t('system','Status code "{status}" is undefined',array(
                    '{status}' => $status
                )));
            break;
        }
        
        header("HTTP/1.0 {$status}");

        return $this;
    }
    
    /**
     * Add custom header
     * @param string $header header
     * @param boolean $replace replace headers
     * @return CHeaders self-object
     */
    public function add($header,$replace=true)
    {
        header($header,$replace);
        return $this;
    }
    
    /**
     * Deny caching
     * @return CHeaders self-object
     */
    public function noCache()
    {
        header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
        header("Cache-Control: post-check=0, pre-check=0",false);
        header("Pragma: no-cache");
        return $this;
    }
    
    /**
     * Set default charset
     * @param string $charset
     * @return CHeaders self-object
     */
    public function charset($charset)
    {
        $this->charset = $charset;
        return $this;
    }
    
}
?>