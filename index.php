<?php

/**
* @author : Onwuka Gideon <dongidomed@gmail.com>  <dongido> <pythonBoss>
* The root of the app,
* Imager - a mini project(2hr) for getting images from a particlar website
* into clean folders
*/

set_time_limit(0);

require_once( "imager.class.php" );

$app = new Imager;

$app->Run();


