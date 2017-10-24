# Imager
  
  > You can call it anything, but we prefer calling it imager! because it does its JOB well.
  Imager helps you to download every images on a particular Url.

## Notes / System Requirement
   - You must have PHP 5.4+ installed.
   - You must have curl installed.
   - php file_get_content must be enabled.

## Features

 - Images can be downloaded from group of links.
 - Arranges images to folder structure according to where the image is stored on the page.

## How to use
  
  First, Download the file [here](https://github.com/dongido001/Imager/archive/master.zip)

  ### Method 1

  #### Running via Web browser

  1. Extract into your Sever document path.
  2. Input the links to the images that you want to download from into `links.txt`.
  3. Visit the link on your browser - ( eg: http://localhost/imager/ ).
  4. Check the folder where you extracted it to, you will see a newly created folder, that's where your image is!.
    
  ### Method 2

  #### Run via command line.
   > :bulb: This is the method you will likely use if you are doing from  lot of links
  1. Extract the file into a folder.
  2. Open your command prompt, then `CD` into the folder where you extracted the file.
  3. Input the links to the images that you want to download the images from into `links.txt`.
  4. Run this command `php index.php`.
  5. Take a coffee and chill - Your images will be downlod for you!.
    
## Optional/addtional setup ( the setup file is `setup.ini` )

Instead of downloading all images, you may want to specify a particullar image format to download,
  eg: `IMAGE_MATCH = 260x260.jpg`- this will download any image that contains 260x260 in the name.

  You can set this up in the `setup.ini` file.
   
## Thanks

If you have any question, please send an email to me - dongidomed [AT] gmail [DOT] com, I will get back to you as soon as possible.

You are free to contribute - pull, fork, one love open source!.

Have a great day!
