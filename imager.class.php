<?php

/**
* @author : Onwuka Gideon <dongidomed@gmail.com>  <dongido>
* The helper class of the app,
* Imager - Downloads images from a given url to your PC, places it in a well defined folder..
*/

require_once("html.php");

class Imager extends simple_html_dom_node{

   /**
   *
   *  Array of links
   */

   private $links;


   /**
   *
   *  Array of config information
   */

   private $config;

   /**
   *
   *  int - counts the number of image downloaded
   */

   private $imageCount;

  //construct__ -- prepares the input.
   public function __construct(){
      
      $this->links  = self::getLinks();
      $this->config = parse_ini_file('setup.ini');
      $this->imageCount = 0;

   }

   /**
   *
   * Gets all links in the "links.txt" file if exits
   * @param: none
   * @return: array - one dimentional array of links
   */

	public static function getLinks()
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
   * @return: string - the folder created...
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
   * @return: string
   */

	public static function getImages($url, $image_name, $folder)
   {
       $image = file_get_contents($url);
       return file_put_contents("{$folder}/{$image_name}", $image);
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

   public function getImagePregMatched( $dom , $link ){

      foreach(@$dom->find('img') as $element){
        if( preg_match('<'. $this->config['IMAGE_MATCH'] .'>', $element->src) AND $this->config['IMAGE_MATCH'] != "" AND $this->config['IMAGE_MATCH'] != NULL ){
          $folder =  preg_replace('*'.$this->config['REPLACE'].'*i', "", $link);
          $img_ex =  explode('/', $element->src); 
          $res    =  self::getImages( $element->src, $img_ex[count($img_ex) - 1], self::createFolder($folder) );
         
          $this->imageCount += ( $res ) ? 1 : 0 ;

          echo $element->src . " <br /> " . PHP_EOL;
        }
      }
   }

   public function getImageWithoutPregMatched( $dom , $link ){
      foreach(@$dom->find('img') as $element){

        $folder =  preg_replace('*'.$this->config['REPLACE'].'*i', "", $link);
        $img_ex = explode('/', $element->src); 
        $res    = self::getImages( $element->src, $img_ex[count($img_ex) - 1], self::createFolder( $folder ) );

        $this->imageCount += ( $res ) ? 1 : 0 ;

        echo $element->src . " <br /> " . PHP_EOL;
      }
   }
   
   //<// Triggers >>//
   public function Run(){
      
      foreach( $this->links as $link ) {
         $dom = str_get_html( self::Request($link) );

        $linkArray = parse_url($link);
        $linkArray['scheme'] .= ( !empty($linkArray['scheme']) ) ? '://' : '';

        if( empty($this->config['REPLACE']) AND $this->config['REPLACE'] != $link) { 
          $this->config['REPLACE'] = $linkArray['scheme'].$linkArray['host'].'/';
        } 

         if( empty($this->config['IMAGE_MATCH']) OR $this->config['IMAGE_MATCH'] == NULL ){
              $this->getImageWithoutPregMatched( $dom , $link );
         }
         else{
              $this->getImagePregMatched( $dom , $link );
         }

     }

     echo " \n\n AM DONE! {$this->imageCount} Images Downloaded, thanks to imager! :) ";

   }

}