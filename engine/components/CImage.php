<?php
/**
 * CImage class file.
 *
 * @author Vlad Gramuzov <vlad.gramuzov@gmail.com>
 * @link http://yonote.org
 * @copyright 2014 Vlad Gramuzov
 * @license http://yonote.org/licence.html
 */

/**
 * Image management class.
 * 
 * @author Vlad Gramuzov <vlad.gramuzov@gmail.com>
 * @since 1.0
 */
class CImage extends CComponent implements IImage
{

    private $_image;
    private $_mime;
    private $_status = false;
    
    /**
     * Class constructor.
     * Create new image object.
     * @param string $path image path.
     */
    public function __construct($path)
    {
        if (file_exists($path))
        {
            $imageInfo = getimagesize($path);
            $mime = $imageInfo['mime'];
            
            switch ($mime){
                case 'image/jpeg':
                    $this->_status = true;
                    $this->_image = imagecreatefromjpeg($path);
                break;
                case 'image/jpg':
                    $this->_status = true;
                    $this->_image = imagecreatefromjpeg($path);
                break;
                case 'image/png':
                    $this->_status = true;
                    $this->_image = imagecreatefrompng($path);
                break;
                case 'image/gif':
                    $this->_status = true;
                    $this->_image = imagecreatefromgif($path);
                break;
            }
        }
    }
    
    /**
     * Get image sides values.
     * @return array width,height.
     */
    public function sides()
    {
        return array(
            imagesx($this->_image),
            imagesy($this->_image)
        );
    }

    /**
     * Resize given image.
     * @param int $w new image width.
     * @param int $h new image height.
     * @param bool $crop crop image.
     * @return CImage instance itself.
     */
    public function resize($w,$h,$crop = false)
    {
        if ($this->_status)
        {
            $widht = imagesx($this->_image);
            $height = imagesy($this->_image);
            
            $newWidth = $w;
            $newHeight = $h;
            
            if ($crop)
            {
                $imgRatio = $widht/$height;
                $newRatio = $w/$h;
                if ($imgRatio >= $newRatio)
                    $newWidth = $widht/($height/$h);
                else
                    $newHeight = $height/($widht/$w);
            }
            
            $newImage = imagecreatetruecolor($w,$h);
            imagealphablending($newImage,false);
            imagesavealpha($newImage,true);
            
            imagecopyresampled(
                $newImage,
                $this->_image,
                0-($newWidth-$w)/2,
                0-($newHeight-$h)/2,
                0,0,$newWidth,$newHeight,
                $widht,$height
            );
            
            $this->_image = $newImage;
            return $this;
        }
    }
    
    /**
     * Put a watermark to the given image.
     * @param string $path watermark path.
     * @param int $offsetH horizontal offset (percents).
     * @param int $offsetV vertical offset (percents).
     * @return CImage instance itself.
     */
    public function watermark($path,$offsetH = 0,$offsetV = 0)
    {
        $watermarkObj = new self($path);
        $watermark = $watermarkObj->getResource();
        
        $widht = imagesx($watermark);
        $height = imagesy($watermark);
        
        $imgWidht = imagesx($this->_image);
        $imgHeight = imagesy($this->_image);
        
        $offsetX = ($imgWidht-$widht)*($offsetH/100);
        $offsetY = ($imgHeight-$height)*($offsetV/100);

        imagecopy($this->_image,$watermark,$offsetX,$offsetY,0,0,$widht,$height);
        
        return $this;
    }
    
    /**
     * Show processed image.
     * @param string $type output image mime-type.
     * @param int $quality image quality (from 0 to 100).
     * @return CImage instance itself.
     */
    public function get($type,$quality = 80)
    {
        if ($type == 'image/jpeg' || $type == 'image/jpg')
            imagejpeg($this->_image,null,$quality);
        else if ($type == 'image/gif')
            imagegif($this->_image,null);
        else
            imagepng($this->_image,null,$quality * (0.09));
        return $this;
    }
    
    
    /**
     * Save processed image.
     * @param string $type output image mime-type.
     * @param string $path path to save.
     * @param int $quality image quality (from 0 to 100).
     * @return CImage instance itself.
     */
    public function save($type,$path,$quality = 80)
    {
        if ($type == 'image/jpeg' || $type == 'image/jpg')
            imagejpeg($this->_image,"{$path}",$quality);
        else if ($type == 'image/gif')
            imagegif($this->_image,"{$path}");
        else
            imagepng($this->_image,"{$path}",$quality * (0.09));
        return $this;
    }
    
    /**
     * Get image resource.
     * @return resource image resource.
     */
    public function getResource()
    {
        return $this->_image;
    }
    
    /**
     * Get image mime-type.
     * @return string mime-type.
     */
    public function mime()
    {
        return $this->_mime;
    }
}
?>