<?php header("Content-type:text/html; charset=utf-8"); include("config.php");?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <title><?php echo $title ?></title>

        <link href="<?php echo $root_dir?>style.css" rel="stylesheet" type="text/css">
        <link href="http://fonts.googleapis.com/css?family=<?php echo $google_font_name?>" rel="stylesheet" type="text/css">
        <link rel="icon" type="image/png" href="favicon.png">
        
        <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    </head>


    <body>

        <h1><?php echo $title ?></h1>
<?php

    $sketch = $_GET[sketch];
    $index = $_GET[index];
    $color = $_GET[color];
    $title = basename($sketch, ".png");
    
    $folder = "big/";
    if ($color) {
        $folder = "color_big/";
    }
    
    if ($nice_urls) {
        $im_url = "images/".$folder.$sketch.".png";
        $link_normal = $root_dir.$index."/".$sketch;
        $link_color = $root_dir.$index."/color/".$sketch;
        $color_filename = "color_big/".$sketch.".png";
    } else {
        $folder = "big/";
        if ($color) {
            $folder = "color_big/";
        }
        $im_url = "watermark.php?img=".$folder.$sketch;
        $link_normal = $root_dir."/single.php?sketch=".$sketch."&index=".$index;
        $link_color = $root_dir."/single.php?color=true&sketch=".$sketch."&index=".$index;
        $color_filename = "color_big/".$sketch;
    }
    
    echo "
        <p>
            <h2>".$title."</h2>
            <a href=\"".$root_dir.$im_url."\"><img class=\"big\" src=\"".$root_dir.$im_url."\"></a>
        </p>";

    if (isset($color)) {
        echo "
        <p class=\"colorlink\"><a href=\"".$link_normal."\">Bleistift-Skizze</a></p>
        ";
    } else {
        if (file_exists($color_filename)) {
            echo "
        <p class=\"colorlink\"><a href=\"".$link_color."\">Coloriert</a></p>
            ";
        }
    }
        
?>


        <h3><a href="<?php echo $root_dir?>#<?php echo $index?>">&lt;&lt; Zurück</a></h3>

        &copy; <?php echo strftime("%Y").", ".$author ?>, <a href="<?php echo $URL ?>"><?php echo $URL ?></a>
        
    </body>
    
</html>
