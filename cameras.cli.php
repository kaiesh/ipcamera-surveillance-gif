<?php
require_once("Config.php");
require_once("GifCreator.php");

date_default_timezone_set(Config::$timezone);

//create the thumbnail base image
$x = 0;
while(Config::$LOOP_COUNT < 0 || $x < Config::$LOOP_COUNT){
	echo "\nRun ".$x.": ";
	$img_disp = imagecreatetruecolor(Config::$FRAME_DIMENSIONS["x"], Config::$FRAME_DIMENSIONS["y"]);
	for ($i=0; $i < count(Config::$CAMERA_IMAGE_URL_ARR); $i++){
		echo $i." ";
		$im = imagecreatefromjpeg(Config::$CAMERA_IMAGE_URL_ARR[$i]["url"]);
		imagecopyresized(
			$img_disp,
			$im,
			($i%Config::$FRAME_LAYOUT["cols"]) * floor(Config::$FRAME_DIMENSIONS["x"]/Config::$FRAME_LAYOUT["cols"]),
			($i%Config::$FRAME_LAYOUT["rows"]) * floor((Config::$FRAME_DIMENSIONS["y"]-Config::$FRAME_LABEL_Y)/Config::$FRAME_LAYOUT["rows"]),
			0, 0,
			floor(Config::$FRAME_DIMENSIONS["x"]/Config::$FRAME_LAYOUT["cols"]),
			floor(Config::$FRAME_DIMENSIONS["y"]/Config::$FRAME_LAYOUT["rows"]),
			Config::$CAMERA_IMAGE_URL_ARR[$i]["x"], Config::$CAMERA_IMAGE_URL_ARR[$i]["y"]);
	}
	$txt_col = imagecolorallocate($img_disp, 255,255,255);
	imagestring($img_disp, 2, 10,Config::$FRAME_DIMENSIONS["y"]-Config::$FRAME_LABEL_Y+5, "Camera Array ".date("G:i:s d/m/Y"),$txt_col);
	imagejpeg($img_disp, Config::$CURRENT_FRAME_FULLFILEPATH,50);
	imagejpeg($img_disp, Config::$JPEG_LOCATION.date("Ymd-His").".jpg",75);
	imageDestroy($img_disp);
	imageDestroy($im);
	echo " * ";
	$x++;
	sleep(Config::$SLEEP_DURATION);
}

//With the latest JPG frames made, now check if these need to be archived into a GIF
if (!is_file(Config::$GIF_TARGET."gif.lock") && (Config::$CONVERT_TIME=="*" || date("H") === Config::$CONVERT_TIME)){
	$files = scandir(Config::$JPEG_LOCATION);
	$tgt_file = Config::$GIF_TARGET.date("Y-m-d-H-i")."gif";
	$gif_frame_src = array();
	$gif_frame_time = array();
	$filecount = 0;

	$total_files = count($files);
	$gif_file_count = min(array(Config::$MAX_FRAMES_TO_GIF, $total_files));

	if ($total_files > Config::$MIN_FRAMES_TO_GIF){
		echo "Starting GIF creation process... ";
		for($i=0; $i < $gif_file_count ; $i++){
			$filename = $files[$i];
			if ( is_file(Config::$JPEG_LOCATION.$filename) ){
				$filecount++;
				$gif_frame_src[] = Config::$JPEG_LOCATION.$filename;
				$gif_frame_time[] = Config::$ANIM_DURATION;
			}
		}
		if (count($gif_frame_src) > 2){
			//deploy a lock file for GIF processing
			$lh = fopen(Config::$GIF_TARGET."gif.lock", "w");
			fwrite($lh, time());
			fclose($lh);

			$tgt_file = Config::$GIF_TARGET.str_replace(array(Config::$JPEG_LOCATION,".jpg"),
			"", $gif_frame_src[0])."-to-".str_replace(array(Config::$JPEG_LOCATION,".jpg"),"",$gif_frame_src[count($gif_frame_src)-1]).".gif";
			echo count($gif_frame_src)." frames found, starting on them so they get stored in ".$tgt_file."... ";
			$gc = new GifCreator();
			$gc->create($gif_frame_src, $gif_frame_time, 1);
			$gifBinary = $gc->getGif();
			file_put_contents($tgt_file, $gifBinary);
			echo "OK. GIF anim made and stored in ".$tgt_file."\n";
			echo "Cleaning up archive files... ";
			foreach ($gif_frame_src as $frame){
				unlink($frame);
			}
			unset($gc); unset($gifBinary); unset($gif_frame_time); unset($files); unset($filecount);
			echo "OK. Deleted ".count($gif_frame_src)." files\n";
			unset($gif_frame_src);

			//remove lock file
			unlink(Config::$GIF_TARGET."gif.lock");
		}else{
			echo "ERR: **** NO GIF ANIM MADE ****\n";
		}
	}else{
		echo "\n**** NOT ENOUGH FILES TO MAKE A GIF ****\n";
	}
}
