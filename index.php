<?php

/**
* @author : Onwuka Gideon <dongidomed@gmail.com>  <dongido>
* The root of the app,
* Imager -  gets images from a particlar website
* into clean folders
*/

set_time_limit(0);

require_once( "imager.class.php" );

$app = new Imager;

$app->Run();


