<?php

//Create thumbnail for uploaded image
//Thumbnail is used in index.php to display all recent and trending uploads
/**
* @param string $src Path for the image to be used for the thumbnail. 
* @param string $extension Image extension. 
* @param string $dest Thumbnail destination path for the created thumbnail. 
* @param int $w Thumbnail width.
* @param int $h Thumbnail height.
* @return bool Returns true if the thumbnail creation was successful. 
*/
if (!function_exists('create_thumbnail')) {
    function create_thumbnail($src, $extension, $dest, $w = 250, $h = 250) {
        list($imgWidth, $imgHeight) = getimagesize($src);
    
        //Used to create a square thumbnail
        //diff is overflow on the longest dimension on either side.
        if ($imgWidth > $imgHeight) {
            $diff = ($imgWidth - $imgHeight) / 2;
        }  else {
            $diff = ($imgHeight - $imgWidth) / 2;
        }
    
        $allowableExt = ['jpg', 'gif', 'jpeg', 'png'];
    
        if (!in_array($extension, $allowableExt)) return false;
    
        $thumb = null;
        switch($extension) {
            case "jpg":
                $thumb = imagecreatefromjpeg($src);
                break;
            case "jpeg":
                $thumb = imagecreatefromjpeg($src);
                break;
            case "gif":
                $thumb = imagecreatefromgif($src);
                break;
            case "png":
                $thumb = imagecreatefrompng($src);
                break;
            default:
                return false;
        }
    
        //resize thumb and save to file
        $trueColor = imagecreatetruecolor($w, $h);
        if ($imgWidth > $imgHeight) {
            imagecopyresampled($trueColor, $thumb, 0, 0, $diff, 0, $w, $h, $imgWidth - (2 * $diff), $imgHeight);
        } else if ($imgHeight > $imgWidth) {
            imagecopyresampled($trueColor, $thumb, 0, 0, 0, $diff, $w, $h, $imgWidth, $imgHeight - (2 * $diff));
        } else {
            imagecopyresampled($trueColor, $thumb, 0, 0, 0, 0, $w, $h, $imgWidth, $imgHeight);
        }
    
        imagejpeg($trueColor, $dest, 100);
        imagedestroy($trueColor);
        return true;
    }
}