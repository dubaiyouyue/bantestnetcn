<?php

Class Watermark{
var $src_image_name = "";      //Enter image file name (must contain the path name)
var $jpeg_quality = 90;        //jpeg picture quality
var $save_file = "";          //Output file name
var $gz_image_name = "";            //Watermark image file name (must contain the path name.)
var $gz_image_pos = 3;             //The location of the watermark image placement
// 0 = middle
// 1 = top left
// 2 = top right
// 3 = bottom right
// 4 = bottom left
// 5 = top middle
// 6 = middle right
// 7 = bottom middle
// 8 = middle left
//other = 3
var $gz_image_transition = 80;            //Watermark image and the original image fusion degree (1 = 100)

var $gz_text = "";                        //Watermark text (in English and Chinese, as well as support with the \ r \ n of the cross-bank text)
var $gz_text_size = 20;                   //Watermark Text Size
var $gz_text_angle = 5;                   //Watermark text point of view, this value is try not to change the
var $gz_text_pos = 3;                     //Text watermark placement
var $gz_text_font = "";                   //Watermark text font
var $gz_text_color = "#cccccc";           //Watermark font color value


function create($filename="")
{
if ($filename) {
 $this->src_image_name = trim($filename);
}
$dirname=explode("/",$this->src_image_name);
if(!file_exists("$dirname[0]/$dirname[1]/$dirname[2]/$dirname[3]/")){
	@mkdir("$dirname[0]/$dirname[1]/$dirname[2]/$dirname[3]/", 0755);
}
if(stristr(PHP_OS,"WIN")){
	$this->src_image_name = @iconv("utf-8","GBK",$this->src_image_name);
	$this->gz_image_name = @iconv("utf-8","GBK",$this->gz_image_name);
}
$src_image_type = $this->get_type($this->src_image_name);
$src_image = $this->createImage($src_image_type,$this->src_image_name);
if (!$src_image) return;
$src_image_w=ImageSX($src_image);
$src_image_h=ImageSY($src_image);


if ($this->gz_image_name){
       $this->gz_image_name = strtolower(trim($this->gz_image_name));
       $gz_image_type = $this->get_type($this->gz_image_name);
       $gz_image = $this->createImage($gz_image_type,$this->gz_image_name);
       $gz_image_w=ImageSX($gz_image);
       $gz_image_h=ImageSY($gz_image);
       $temp_gz_image = $this->getPos($src_image_w,$src_image_h,$this->gz_image_pos,$gz_image);
       $gz_image_x = $temp_gz_image["dest_x"];
       $gz_image_y = $temp_gz_image["dest_y"];
	   if($this->get_type($this->gz_image_name)=='png'){imagecopy($src_image,$gz_image,$gz_image_x,$gz_image_y,0,0,$gz_image_w,$gz_image_h);}
	   else{imagecopymerge($src_image,$gz_image,$gz_image_x,$gz_image_y,0,0,$gz_image_w,$gz_image_h,$this->gz_image_transition);}
}
if ($this->gz_text){
       $temp_gz_text = $this->getPos($src_image_w,$src_image_h,$this->gz_text_pos);
       $gz_text_x = $temp_gz_text["dest_x"];
       $gz_text_y = $temp_gz_text["dest_y"];
      if(preg_match("/([a-f0-9][a-f0-9])([a-f0-9][a-f0-9])([a-f0-9][a-f0-9])/i", $this->gz_text_color, $color))
      {
         $red = hexdec($color[1]);
         $green = hexdec($color[2]);
         $blue = hexdec($color[3]);
         $gz_text_color = imagecolorallocate($src_image, $red,$green,$blue);
      }else{
         $gz_text_color = imagecolorallocate($src_image, 255,255,255);
      }
       imagettftext($src_image, $this->gz_text_size, $this->gz_text_angle, $gz_text_x, $gz_text_y, $gz_text_color,$this->gz_text_font,  $this->gz_text);
}
if(stristr(PHP_OS,"WIN")){
	$save_files=explode('/',$this->save_file);
	$save_files[count($save_files)-1]=@iconv("utf-8","GBK",$save_files[count($save_files)-1]);
	$this->save_file=implode('/',$save_files);
}
if ($this->save_file)
{
  switch ($this->get_type($this->save_file)){
   case 'gif':$src_img=ImagePNG($src_image, $this->save_file); break;
   case 'jpeg':$src_img=ImageJPEG($src_image, $this->save_file, $this->jpeg_quality); break;
   case 'png':$src_img=ImagePNG($src_image, $this->save_file); break;
   default:$src_img=ImageJPEG($src_image, $this->save_file, $this->jpeg_quality); break;
  }
}
else
{
if ($src_image_type = "jpg") $src_image_type="jpeg";
  header("Content-type: image/{$src_image_type}");
  switch ($src_image_type){
   case 'gif':$src_img=ImagePNG($src_image); break;
   case 'jpg':$src_img=ImageJPEG($src_image, "", $this->jpeg_quality);break;
   case 'png':$src_img=ImagePNG($src_image);break;
   default:$src_img=ImageJPEG($src_image, "", $this->jpeg_quality);break;
  }
}
imagedestroy($src_image);
}

/*+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
/*
createImage     According to the file name and type to create pictures
Internal function

$type:               Image types, including gif, jpg, png
$img_name:  Image file name, including path names, such as ". / Mouse.jpg"
*/
function createImage($type,$img_name){
         if (!$type){
              $type = $this->get_type($img_name);
         }
		 
          switch ($type){
                  case 'gif':
                        if (function_exists('imagecreatefromgif'))
                               $tmp_img=@imagecreatefromgif($img_name);
                        break;
                  case 'jpg':
                        $tmp_img=imagecreatefromjpeg($img_name);
                        break;
                  case 'png':
                        $tmp_img=imagecreatefrompng($img_name);
                        break;
				  case 'jpeg':
                        $tmp_img=imagecreatefromjpeg($img_name);
                        break;
                  default:
                        $tmp_img=imagecreatefromstring($img_name);
                        break;
          }
          return $tmp_img;
}

/*+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
getPos               According to the source image of the length, width, location code, a watermark image id to generate the watermark placed in the location of the source image
Internal function

$sourcefile_width:        Source image width
$sourcefile_height: The original image of the high 
$pos:               Location Code
// 0 = middle 
// 1 = top left
// 2 = top right
// 3 = bottom right
// 4 = bottom left
// 5 = top middle
// 6 = middle right
// 7 = bottom middle
// 8 = middle left
$gz_image:           Watermark Photo ID
*/
function getPos($sourcefile_width,$sourcefile_height,$pos,$gz_image=""){
         if  ($gz_image){
              $insertfile_width = ImageSx($gz_image);
              $insertfile_height = ImageSy($gz_image);
         }else {
              $lineCount = explode("\r\n",$this->gz_text);
              $fontSize = imagettfbbox($this->gz_text_size,$this->gz_text_angle,$this->gz_text_font,$this->gz_text);
              $insertfile_width = $fontSize[2] - $fontSize[0];
              $insertfile_height = count($lineCount)*($fontSize[1] - $fontSize[5]);
			  $fontSizeone =imagettfbbox($this->gz_text_size,$this->gz_text_angle,$this->gz_text_font,'e');
			  $fontSizeone = ($fontSizeone[2] - $fontSizeone[0])/2;
         }
		switch ($pos){
			case 0:
			   $dest_x = ( $sourcefile_width / 2 ) - ( $insertfile_width / 2 );
			   $dest_y = ( $sourcefile_height / 2 ) + ( $insertfile_height / 2 );
			   break;

			case 1:
			   $dest_x = 0;
			   $dest_y = $insertfile_height;
			   break;
			case 2:
			  $dest_x = $sourcefile_width - $insertfile_width-$fontSizeone;
			  $dest_y = $insertfile_height;
			  break;

			case 3:
			  $dest_x = $sourcefile_width - $insertfile_width-$fontSizeone;
			  $dest_y = $sourcefile_height - ($insertfile_height/4);
			  break;

			case 4:
			  $dest_x = 0;
			  $dest_y = $sourcefile_height - ($insertfile_height/4);
			  break;

			case 5:
			 $dest_x = ( ( $sourcefile_width - $insertfile_width ) / 2 );
			 $dest_y = $insertfile_height;
			 break;

			case 6:
			 $dest_x = $sourcefile_width - $insertfile_width -$fontSizeone;
			 $dest_y = ( $sourcefile_height / 2 ) + ( $insertfile_height / 2 );
			 break;

			case 7:
			 $dest_x = ( ( $sourcefile_width - $insertfile_width ) / 2 );
			 $dest_y = $sourcefile_height - ($insertfile_height/4);
			 break;

			case 8:
			 $dest_x = 0;
			 $dest_y = ( $sourcefile_height / 2 ) + ( $insertfile_height / 2 );
			 break;

			default:
			  $dest_x = $sourcefile_width - $insertfile_width;
			  $dest_y = $sourcefile_height - $insertfile_height;
			  break;
		}	
		if($gz_image){
			$dest_y=$dest_y-$insertfile_height;
		}
        return array("dest_x"=>$dest_x,"dest_y"=>$dest_y);
}
/*+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
get_type              Get the picture formats, including jpg, png, gif
Internal function

$img_name：        Image file name, path name may include
*/
function get_type($img_name)//Obtain the image file type
{
$name_array = explode(".",$img_name);
if (preg_match("/\.(jpg|jpeg|gif|png)$/i", $img_name, $matches))
{
  $type = strtolower($matches[1]);
}
else
{
  $type = "string";
}
  return $type;
}

}
?>