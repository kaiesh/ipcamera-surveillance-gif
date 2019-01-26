<?php
/**
 * This file is intended to hold variables that are specific to your Configuration
 **/

class Config{

  //********************************
  //***** General operations *******
  //********************************

  //Set your timezone so that datestamps on images are as expected!
  public static $timezone = "Asia/Singapore";

  //Number of loops to run each time the file is executed, -1 for a never ending loop
  public static $LOOP_COUNT = 19;

  //Time to sleep between loops (in seconds)
  public static $SLEEP_DURATION = 3;

  //Minimum number of frames required before a GIF archive file is created
  public static $MIN_FRAMES_TO_GIF = 1200;

  //Maximum number of frames to put into one GIF. You may need to play around with this value as it will depend on your image sizes, available memory to PHP, and your PC processing+memory capacity
  public static $MAX_FRAMES_TO_GIF = 1500;

  //Set the time for the animated GIF archive to be created
  //this will check to see if the requisite number of files exists during this hour, and if so compile the GIF accordingly
  //Use '*' if creation time does not matter, or specify the hour in 24h format (e.g. 23 = 11pm)
  public static $CONVERT_TIME = "*"; //convert the JPGs in GIF archives as soon as the min number of frames is met

  //*********************************************
  //***** File system and storage options *******
  //*********************************************

  //Full path and filename for where the latest frame should be stored
  public static $CURRENT_FRAME_FULLFILEPATH = "./camfile.jpg";

  //Where should JPG frames be stored before they are used for GIFs?
  public static $JPEG_LOCATION = "./archive/";

  //Where should GIF animaion archives be stored?
  public static $GIF_TARGET = "./gifs/";

  //*************************************************
  //***** Details for each surveillance frame *******
  //*************************************************

  //Most IP cameras allow you to access the current frame via a specific URL, simply create an array of all of your camera frame URLs, and the expected source dimensions
  public static $CAMERA_IMAGE_URL_ARR = array(
    array("url"=>'http://camera.url:port/endpoint', "x"=>640, "y"=>480),
    array("url"=>'http://camera.url:port/endpoint', "x"=>640, "y"=>480),
    array("url"=>'http://camera.url:port/endpoint', "x"=>640, "y"=>480),
    array("url"=>'http://camera.url:port/endpoint', "x"=>640, "y"=>480),
    array("url"=>'http://camera.url:port/endpoint', "x"=>640, "y"=>480),
    array("url"=>'http://camera.url:port/endpoint', "x"=>640, "y"=>480)
  );

  //How much veritcal space should be left for your frame label text (which is approx 10px high and has a 5px margin at the top)
  public static $FRAME_LABEL_Y = 20;

  //What should the final dimensions of your surveillance graphic be (including frame label space)?
  public static $FRAME_DIMENSIONS = array("x"=>640, "y"=>340);

  //How many rows and columns of images should exist on the surveillance frame?
  public static $FRAME_LAYOUT = array("cols"=>3, "rows"=>2);


  //********************************************
  //***** GIF archive animation settings *******
  //********************************************

  //How many milliseconds should each frame stay on screen for?
  public static $ANIM_DURATION = 33;


}
