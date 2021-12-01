<?php
session_start();


function random($len)
{
  $srcstr = "ABCDEFGHIJKLMNPQRSTUVWXYZ123456789";
  mt_srand();
  $strs = "";
  for($i = 0; $i < $len; $i++)
  {
    $strs .= $srcstr[mt_rand(0, 33)];
  }
  return strtoupper($strs);
}
$str = random(4);                                     
$width = 50;                                           
$height = 25;                                         
@header("Content-Type:image/png");
$_SESSION["code"] = $str;
$im = imagecreate($width, $height);                    
$back = imagecolorallocate($im, 0xFF, 0xFF, 0xFF);
$pix = imagecolorallocate($im, 187, 230, 247);
$font = imagecolorallocate($im, 27, 52, 171);
mt_srand();
for($i = 0; $i < 1000; $i++)
{
  imagesetpixel($im, mt_rand(0, $width), mt_rand(0, $height), $pix);
}
imagestring($im, 5, 7, 5, $str, $font);
imagerectangle($im, 0, 0, $width-1, $height-1, $font);
imagepng($im);
imagedestroy($im);
include_once 'mysql.php';
include_once 'function.php';
session('code',$str);
?>