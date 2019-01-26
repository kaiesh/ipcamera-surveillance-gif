# ipcamera-surveillance-gif

## Purpose

Creation of a single frame graphic from all IP camera feeds that I own, in order to make viewing easier. Additionally, auto archival of these frames into a single animated GIF that can be easily reviewed if required.

## Implementation overview

I wanted this to run on my House NAS so that an image was captured every 5 seconds, all image archives were automatically stored on it, and no additional headaches dealing with SFTP, etc. My NAS supports cron and PHP, so this is designed to be run by cron every minute - although if you choose to run it over a different period, you can modify settings in Config.php to match your requirements.

## Getting it up and running

The only file you should need to modify is Config.php. Once your configuration is set, you should be able to execute the cameras.cli.php file and output surveillence frames exactly as you have configured.

You will probably need to create and/or manage perms on the directories that you specify for the graphics to be stored/created.

## Credits

GIF file creation by https://github.com/Sybio/GifCreator
