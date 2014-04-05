<?php
/**
 * This file contains core interfaces for YOnote ENGINE.
 *
 * @author Vlad Gramuzov <vlad.gramuzov@gmail.com>
 * @link http://
 * @copyright 201
 * @license http://
 */

/**
 * Application user interface
 * 
 * @author Vlad Gramuzov <vlad.gramuzov@gmail.com>
 * @package application.base
 * @since 1.0
 */
interface IApplicationUser
{
    /**
     * Get user data
     * @param string $username username
     */
    public function find($username);
}

/**
 * Headers interface
 * 
 * @author Vlad Gramuzov <vlad.gramuzov@gmail.com>
 * @package application.base
 * @since 1.0
 */
interface IHeaders
{
    /**
     * Headers constants 
     */
    const HEADER_TEXT_HTML = 0x1;         // HTML text header
    const HEADER_TEXT_JS = 0x2;           // JS text header
    const HEADER_TEXT = 0x4;              // Plain text header
    const HEADER_TEXT_CSS = 0x8;          // CSS text header
    const HEADER_TEXT_CSV = 0x10;         // CSV text header
    const HEADER_TEXT_XML = 0x20;         // XML text header
    const HEADER_IMAGE_PNG = 0x40;        // PNG image header
    const HEADER_IMAGE_GIF = 0x80;        // GIF image header
    const HEADER_IMAGE_JPEG = 0x100;      // JPEG image header
    const HEADER_IMAGE_TIFF = 0x200;      // TIFF image header
    const HEADER_AUDIO_MP4 = 0x400;       // MP4 audio header
    const HEADER_AUDIO_MPEG = 0x800;      // MPEG audio header
    const HEADER_AUDIO_OGG = 0x1000;      // OGG audio header
    const HEADER_AUDIO_VORBIS = 0x2000;   // VORBIS audio header
    const HEADER_AUDIO_WAVE = 0x4000;     // WAVE audio header
    const HEADER_AUDIO_WEBM = 0x8000;     // WEBM audio header
    const HEADER_APP_GZIP = 0x10000;      // GZIP app header
    const HEADER_APP_ZIP = 0x20000;       // ZIP app header
    const HEADER_APP_OGG = 0x40000;       // OGG app header
    const HEADER_APP_PDF = 0x80000;       // PDF app header
    const HEADER_APP_JSON = 0x100000;     // JSON app header
    
    /**
     * Set Content-type header
     * @param int $flag content-type flag
     * @param int $lastMod last modified timestamp
     */
    public function mime($flag,$lastMod );
    /**
     * Set response status
     * @param int $code response code
     */
    public function status($code);
    /**
     * Add custom header
     * @param string $header header
     * @param boolean $replace replace headers
     */
    public function add($header,$replace);
    /**
     * Deny caching
     */
    public function noCache();
    /**
     * Set default charset
     * @param string $charset charset
     */
    public function charset($charset);
}
?>