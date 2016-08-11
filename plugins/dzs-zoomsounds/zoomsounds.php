<?php
/*
  Plugin Name: DZS ZoomSounds
  Plugin URI: http://digitalzoomstudio.net/
  Description: Creates and manages cool audio players with optional playlists.
  Version: 1.63
  Author: Digital Zoom Studio
  Author URI: http://digitalzoomstudio.net/ 
 */



include_once(dirname(__FILE__).'/dzs_functions.php');
if(!class_exists('DZSAudioPlayer')){
    include_once(dirname(__FILE__).'/class-dzsap.php');
}


define("DZSAP_VERSION", "1.63");
$dzsap = new DZSAudioPlayer();