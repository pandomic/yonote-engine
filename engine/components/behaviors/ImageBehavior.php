<?php
/**
 * ImageBehavior class file.
 *
 * @author Vlad Gramuzov <vlad.gramuzov@gmail.com>
 * @link http://yonote.org
 * @copyright 2014 Vlad Gramuzov
 * @license http://yonote.org/licence.html
 */

/**
 * Image processing behavior.
 * 
 * @author Vlad Gramuzov <vlad.gramuzov@gmail.com>
 * @since 1.0
 */
class ImageBehavior extends CBehavior
{
    private $_error;
    
    const ERROR_NULL = true;               // No any errors
    const ERROR_SIDES_SMALL = 0x2;         // Sides are too small
    const ERROR_SIDES_BIG = 0x3;           // Sides are too large
    const ERROR_FILE_EMPTY = 0x4;          // File not found
    
    /**
     *
     * @var string file field.
     */
    public $fileField;
    /**
     * @var string image save path.
     */
    public $savePath;
    /**
     *
     * @var boolean check image sides.
     */
    public $checkSides = false;
    /**
     * @var int image min width.
     */
    public $minWidth;
    /**
     * @var int image min height.
     */
    public $minHeight;
    /**
     * @var int image max width.
     */
    public $maxWidth;
    /**
     * @var int image max height.
     */
    public $maxHeight;
    /**
     * @var boolean resize image.
     */
    public $resizeImage = false;
    /**
     * @var boolean crop image on resize.
     */
    public $cropOnResize = false;
    /**
     * @var int resize width.
     */
    public $resizeWidth;
    /**
     * @var int resize height.
     */
    public $resizeHeight;
    /**
     * @var int image quality.
     */
    public $quality = 80;
    
    /**
     * Set image error.
     * @param int $code error code.
     * @return CImage instance itself.
     */
    public function setImageError($code)
    {
        $this->_error = $code;
        return $this->getOwner();
    }
    
    /**
     * Get image error code.
     * @return int error code.
     */
    public function getImageError()
    {
        return $this->_error;
    }
    
    /**
     * Process image.
     * @return boolean|string false if any error occurred, or image saved path.
     */
    public function processImage()
    {
        $photo = CUploadedFile::getInstance($this->getOwner(),$this->fileField);
        
        if ($photo !== null)
        {
            $w = 0;
            $h = 0;
            
            $image = new CImage($photo->getTempName());
            
            if ($this->checkSides)
            {
                list($w,$h) = $image->sides();
                if ($w < $this->minWidth || $h < $this->minHeight)
                {
                    $this->_error = self::ERROR_SIDES_SMALL;
                    return false;
                }
                else if ($w > $this->maxWidth || $h > $this->maxHeight)
                {
                    $this->_error = self::ERROR_SIDES_BIG;
                    return false;
                }
            }

            $name = uniqid();
            $path = "{$this->savePath}/{$name}.{$photo->getExtensionName()}";

            if ($this->resizeImage)
                $image->resize(
                    $this->resizeWidth,
                    $this->resizeHeight,
                    $this->cropOnResize
                );
            
            $image->save($image->mime(),$path,$this->quality);
            return "{$name}.{$photo->getExtensionName()}";
        }
        
        $this->_error = self::ERROR_FILE_EMPTY;
        return false;
    }
    
}
?>