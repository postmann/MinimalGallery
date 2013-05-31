<?php

    session_start(); 
    header('Content-Type: image/png');
    header("Cache-Control: private, max-age=10800, pre-check=10800");
    header("Pragma: private");
    header("Expires: " . date(DATE_RFC822,strtotime(" 20 day")));
    
    if(isset($_SERVER['HTTP_IF_MODIFIED_SINCE'])){

      // if the browser has a cached version of this image, send 304
      header('Last-Modified: '.$_SERVER['HTTP_IF_MODIFIED_SINCE'],true,304);
      exit;

    } else {

        // no cached image, generate image with watermark
        include("functions.php");
        include("config.php");

        $im_path = $_GET[img];
        $im = ImageCreateFromPNG ($im_path);

        // basic settings for watermark --> maybe move to config file
        $rgb = hex2rgb($font_color);
        $textcolor = ImageColorAllocate ($im, $rgb['r'], $rgb['g'], $rgb['b']);

        // font size as 2% of image width
        $size = imagesx ($im)*0.02;

        $angle = 0;
        $fontfile = "./".$font_file;
        $text = "&copy; ".strftime("%Y").", ".$author;
        
        // compute dimensions of watermark
        $dimensions = imagettfbbox($size, $angle, $fontfile, $text);
        
        // compute width
        $textWidth = abs($dimensions[4] - $dimensions[6]);
        $x = imagesx($im) - $textWidth;
        
        // compute heigth
        $textHeight = abs($dimensions[5] - $dimensions[3]);
        $y = imagesy($im) - $textHeight;
        
        // create watermark
        ImageTTFText ($im, $size, 0, $x-$size, $y+$size/2, $textcolor, $fontfile, $text);
        
        header('Content-type: image/png');
        header("Content-disposition: inline; filename=".str_replace(" ", "_", basename($im_path)));

        // image output
        ImagePNG ($im);
        
        // cleanup
        ImageDestroy ($im);
    
    }

?>
