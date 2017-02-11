<?php

/**
* @author : Onwuka Gideon <dongidomed@gmail.com>  <dongido> <pythonBoss>
* The root of the app,
* Imager - a mini project(2hr) for getting images from a particlar website
*/

require_once("html.php");

class Imager extends simple_html_dom_node{

   /**
   *
   *  Array of links ...
   */

   private $links;


  //construct__
   public function __construct(){
      
      $this->links = self::getLinks();
   }

   /**
   *
   * Gets all links in the "links.txt" file if exits
   * @param: none
   * @return: array - one dimentional array of links
   */

	public function getLinks()
   {
      $r = [];
      $urls = file_get_contents("links.txt");
      preg_match_all('#(www\.|https?://)?[a-z0-9]+\.[a-z0-9]{2,4}\S*#i', $urls, $r);
      
      return $r[0];

	}

   /**
   *
   * Creates a folder if not exist
   * @param: String - folder name to create.
   * @return: bool - true, if created, else false...
   */

	public static function createFolder($folder)
   {
      $folders = explode('/', $folder);
      
      $next_dir = "";

      foreach( $folders as $dir ){
         if( !is_dir( $next_dir.$dir )  ){
           mkdir( $next_dir.$dir );
         }

           $next_dir .=  $dir . '/';

      }
      return $next_dir;
	}


   /**
   *
   * Downloads the images
   * @param 1: String - url - link to the image.
   * @param 2: String - folder to store the image.
   * @return: String - content of the wbpage
   */

	public static function getImages($url, $image_name, $folder)
   {
       $image = file_get_contents($url);
       file_put_contents("{$folder}/{$image_name}", $image);

       return true;
	}

   /**
   *
   * Makes http request
   * @param: String - url - link to the image.
   * @return: String - result of the request
   */

   public static function Request($url)
   {
      
      if( empty($url) ) { return False; }

      $curl = curl_init($url);
      curl_setopt($curl, CURLOPT_FAILONERROR, true);
      curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
      curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
      curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);  
      
      return curl_exec($curl);
   }

   public function Run(){
      
      foreach( $this->links as $link ) {
         $dom = str_get_html( self::Request($link) );
         // Find all images
        foreach($dom->find('img') as $element)
         
         //this is the image i want to download - thats why i wrote this script :D
         if( preg_match('/(\d{3,})(x)(\d{3,}.jpg)/', $element->src) ){

           $folder =  preg_replace('*http://beautiphic.com/product-category/*i', "", $link);
           $img_ex = explode('/', $element->src); 
           self::getImages( $element->src, $img_ex[count($img_ex) - 1], self::createFolder( $folder ) );
           echo $element->src . '<br>';
         }
        }

   }

}