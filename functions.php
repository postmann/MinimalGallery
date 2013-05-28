<?php

    function getPngFiles ($filesdir)
    {
        $files = array();
        
        // get all png files
        $dir = dir($filesdir);
        while($entry=$dir->read()) {
            $info = pathinfo($entry);
            if($info['extension'] == "png") {
                $files[] = $entry;
            }
        }
        $dir->close();
        
        // sort like a human
        natsort ($files);
    
        // latest first
        $files = array_reverse ($files);
        
        return $files;
    }

    /*
     * function taken from http://stackoverflow.com/questions/8751697/triple-hex-code-to-rgb..
    */
    function hex2rgb($hex)
    {
        // Ensure we're working only with upper-case hex values,
        // toss out any extra characters.
        $hex = preg_replace('/[^A-F0-9]/', '', strtoupper($hex));

        // Convert 3-letter hex RGB codes into 6-letter hex RGB codes
        $hex_len = strlen($hex);
        if ($hex_len == 3) {
            $new_hex = '';
            for ($i = 0; $i < $hex_len; ++$i) {
                $new_hex .= $hex[$i].$hex[$i];
            }
            $hex = $new_hex;
        }

        // Calculate the RGB values
        $rgb['r'] = hexdec(substr($hex, 0, 2));
        $rgb['g'] = hexdec(substr($hex, 2, 2));
        $rgb['b'] = hexdec(substr($hex, 4, 2));

        return $rgb;
    }

    function createResizedImage($filename, $new_width, $new_filename)
    {
        $image = ImageCreateFromPNG ($filename);
        $orig_width = imagesx($image);
        $orig_new_height = imagesy($image);
        
        if ($new_width<$orig_width) {
            $new_height = (($orig_new_height * $new_width) / $orig_width);        
            $new_image = imagecreatetruecolor($new_width, $new_height);
            imagecopyresampled($new_image, $image, 0, 0, 0, 0, $new_width, $new_height, $orig_width, $orig_new_height);
        } else {
            $new_image = $image;
        }
        imagepng($new_image, $new_filename, 9);
    }
    
    function setup()
    {
        if (!file_exists('big')) {
            mkdir('big');
        }
        if (!file_exists('big_color')) {
            mkdir('big_color');
        }
        if (!file_exists('small')) {
            mkdir('small');
        }
    }

?>
