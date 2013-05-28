<?php header("Content-type:text/html; charset=utf-8"); include("config.php"); include("functions.php");?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<?php
    setup();
?>

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
                    $files = getPngFiles("big");
		
		            // show all files
		            foreach ($files as $file) {
		                $title = basename($file, ".png");
		                $im_small = "small/".$file;
		                $im_big = "big/".$file;
                        $index = count($files)-array_search($file, $files);

		                if (!file_exists($im_small)) {
                            createResizedImage($im_big, $image_small_width, $im_small);
		                }
		                
                        $im_url = "";
                        $single_ref = "";
                        if ($nice_urls) {
                            $im_url = "images/".$im_small;
                            $single_ref = $index."/".basename($file, ".png");
                        } else {
                            $im_url = "watermark.php?&img=".$im_small;
                            $single_ref = "single.php?&sketch=".$file."&index=".$index;
                        }
		                
		                echo "
            <p>
                <h2>".$title."</h2>
	        <a id=\"".$index."\"></a>
	        <a href=\"".$single_ref."\">
            	    <img src=\"".$im_url."\"/>
                </a>
            </p>";
		            }
            ?>


        &copy; <?php echo strftime("%Y").", ".$author ?>, <a href="<?php echo $URL ?>"><?php echo $URL ?></a>
        
    </body>
    
</html>
