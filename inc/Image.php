<?php
class Image{

	//自动缩图$srcfile原文件，大图；$photo_small目标文件，小图；$dstw,$dsth是小图的宽，高。   

function make_image($srcfile,$dstw='200')  

{   

    $data = getimagesize($srcfile);  
 		$str=explode('.', $srcfile);
		
$photo_small1=time().rand(1000,9999).".".$str[count($str)-1];
   $path=explode("/", $srcfile);
   for ($i=0;$i<count($path)-1;$i++){
   	
   	$p.=$path[$i]."/";
   	
   }
$photo_small=$p.$photo_small1;
    switch ($data[2])  

    {   

        case 1: //图片类型，1是gif图   

            $im = @imagecreatefromgif($srcfile);   

        break;   

        case 2: //图片类型，2是jpg图   

            $im = @imagecreatefromjpeg($srcfile);   

        break;   

        case 3: //图片类型，3是png图   

            $im = @imagecreatefrompng($srcfile);   

        break;  

    }   
//echo $photo_small;
    $srcw=imagesx($im);   

    $srch=imagesy($im);   
    $dsth=($srch/$srcw)*$dstw;
    $ni=imagecreatetruecolor($dstw,$dsth);   

    imagecopyresampled($ni,$im,0,0,0,0,$dstw,$dsth,$srcw,$srch);   
  
switch ($data[2])  

    {   

        case 1: //图片类型，1是gif图   

          imagegif($ni,$photo_small,'70');  

        break;   

        case 2: //图片类型，2是jpg图   

          imagejpeg($ni,$photo_small,'70');   

        break;   

        case 3: //图片类型，3是png图   

            imagepng($ni,$photo_small,'70');  

        break;  

    }  
return $photo_small;
}  


//显示图片
function see_image($srcfile,$dstw,$dsth)  

{   

    $data = getimagesize($srcfile);  
 

    switch ($data[2])  

    {   

        case 1: //图片类型，1是gif图   

            $im = @imagecreatefromgif($srcfile);   

        break;   

        case 2: //图片类型，2是jpg图   

            $im = @imagecreatefromjpeg($srcfile);   

        break;   

        case 3: //图片类型，3是png图   

            $im = @imagecreatefrompng($srcfile);   

        break;  

    }   

    $srcw=imagesx($im);   

    $srch=imagesy($im);   

    $ni=imagecreatetruecolor($dstw,$dsth);   

    imagecopyresampled($ni,$im,0,0,0,0,$dstw,$dsth,$srcw,$srch);   
    imagejpeg($ni); //在显示图片时用，把注释取消，能直接在页面显示出图片。   

}  
//

 /**
  * 类内部的功能函数把#000000转换成255,255,255
  */
 private function convcolor($font_color){
  $rgb = array();
  $color = preg_replace("/#/","",$font_color);
  $c = hexdec($color);
  $r = ($c >> 16) & 0xff;
  $g = ($c >> 8) & 0xff;
  $b = $c & 0xff;
  $rgb[0] = $r;
  $rgb[1] = $g;
  $rgb[2] = $b;
  return $rgb;
 }
 



//设置水印
/*
 $imgSrc：目标图片，可带相对目录地址，
$markImg：水印图片，可带相对目录地址，支持PNG和GIF两种格式，如水印图片在执行文件mark目录下，可写成：mark/mark.gif
$markText：给图片添加的水印文字
$TextColor：水印文字的字体颜色
$markPos：图片水印添加的位置，取值范围：0~9
0：随机位置，在1~8之间随机选取一个位置
1：顶部居左 2：顶部居中 3：顶部居右 4：左边居中
5：图片中心 6：右边居中 7：底部居左 8：底部居中 9：底部居右
$fontType：具体的字体库，可带相对目录地址
$markType：图片添加水印的方式，img代表以图片方式，text代表以文字方式添加水印
$fontSize:水印文字大小

 */
function setMark($imgSrc,$markImg,$markText,$fontType,$TextColor,$markPos,$markType,$fontSize)
{


    $srcInfo = @getimagesize($imgSrc);
    $srcImg_w    = $srcInfo[0];//获取目标图片的宽度和高度
    $srcImg_h    = $srcInfo[1];
        
    switch ($srcInfo[2]) //根据图片类型调用不同的函数，获得操作图像标识符
    { 
        case 1: 
            $srcim =imagecreatefromgif($imgSrc); 
            break; 
        case 2: 
            $srcim =imagecreatefromjpeg($imgSrc); 
            break; 
        case 3: 
            $srcim =imagecreatefrompng($imgSrc); 
            break; 
        default: 
            die("不支持的图片文件类型"); 
            exit; 
    }
        
    if(!strcmp($markType,"img"))//添加图片水印
    {
        if(!file_exists($markImg) || empty($markImg))
        {
            return;
        }
            
        $markImgInfo = @getimagesize($markImg);
        $markImg_w    = $markImgInfo[0];
        $markImg_h    = $markImgInfo[1];
            
        if($srcImg_w < $markImg_w || $srcImg_h < $markImg_h)
        {
            return;
        }
            
        switch ($markImgInfo[2]) 
        { 
            case 1: 
                $markim =imagecreatefromgif($markImg); 
                break; 
            case 2: 
                $markim =imagecreatefromjpeg($markImg); 
                break; 
            case 3: 
                $markim =imagecreatefrompng($markImg); 
                break; 
            default: 
                die("不支持的水印图片文件类型"); 
                exit; 
        }
            
        $logow = $markImg_w;
        $logoh = $markImg_h;
    }
        
    if(!strcmp($markType,"text"))   //文字水印
    {
    
        if(!empty($markText))
        {
            if(!file_exists($fontType))
            {
                return;
            }
        }
        else {
            return;
        }
           // $markText  = iconv('GBK','UTF-8',$markText);   
        $box = @imagettfbbox($fontSize, 0, $fontType,$markText);
        $logow = max($box[2], $box[4]) - min($box[0], $box[6]);
        $logoh = max($box[1], $box[3]) - min($box[5], $box[7]);
    }
        
    if($markPos == 0)//随机位置
    {
        $markPos = rand(1, 9);
    }
        
    switch($markPos)//设置的水印位置
    {
        case 1:
            $x = +5;
            $y = +20;
            break;
        case 2:
            $x = ($srcImg_w - $logow) / 2;
            $y = +20;
            break;
        case 3:
            $x = $srcImg_w - $logow - 5;
            $y = +20;
            break;
        case 4:
            $x = +5;
            $y = ($srcImg_h - $logoh) / 2+15;
            break;
        case 5:
            $x = ($srcImg_w - $logow) / 2;
            $y = ($srcImg_h - $logoh) / 2+15;
            break;
        case 6:
            $x = $srcImg_w - $logow - 5;
            $y = ($srcImg_h - $logoh) / 2+15;
            break;
        case 7:
            $x = +10;
            $y = $srcImg_h - $logoh - 5;
            break;
        case 8:
            $x = ($srcImg_w - $logow) / 2;
            $y = $srcImg_h - $logoh - 5;
            break;
        case 9:
            $x = $srcImg_w - $logow-30;
            $y = $srcImg_h - $logoh -5;
            break;
        default: 
            die("此位置不支持"); 
            exit;
    }
        
    $dst_img = @imagecreatetruecolor($srcImg_w, $srcImg_h);  //新建一个和目标图片大小一致的图片。
    
        
    imagecopy ( $dst_img, $srcim, 0, 0, 0, 0, $srcImg_w, $srcImg_h);
        
    if(!strcmp($markType,"img"))
    {
        imagecopy($dst_img, $markim, $x, $y, 0, 0, $logow, $logoh);
        imagedestroy($markim);
    }
        
    if(!strcmp($markType,"text"))
    {
        $rgb =$this->convcolor($TextColor);
          
        $color = imagecolorallocate($dst_img, $rgb[0], $rgb[1], $rgb[2]);
        imagettftext($dst_img, $fontSize, 0, $x, $y, $color, $fontType,$markText);
    }
        
    switch ($srcInfo[2]) 
    { 
        case 1:
            imagegif($dst_img, $imgSrc); 
            break; 
        case 2: 
            imagejpeg($dst_img, $imgSrc); 
            break; 
        case 3: 
            imagepng($dst_img, $imgSrc); 
            break;
        default: 
            die("不支持的水印图片文件类型"); 
            exit; 
    }
        
    imagedestroy($dst_img);
    imagedestroy($srcim);
} 

//上传图片,$file为原始图片，$path为上传文件夹的路径,如果上传成功返回上传之后的文件名,不加水印
public function up_image($file,$path){
    if(!is_dir($path)) mkdir($path,0755);//判断文件夹是否存在，不存在则创建
    if($file){

        $str=explode('.', $file["name"]);

        $filename=time().rand(1000,9999).".".$str[count($str)-1];

        $type = $file["type"];
        $size = $file["size"];
        $sys['upload_max']=10;
        $upload_max=$sys['upload_max']*1024*1024;
        if($size>$upload_max){


            return array('code'=>0,'msg'=>"上传文件大小不能大于".$sys['upload_max']."MB！");

        }
        $tmp_name = $file["tmp_name"];
        $ok=0;
//判断文件类型
        switch ($type) {
            case 'image/pjpeg' :$ok=1;
                break;
            case 'image/jpeg' :$ok=1;
                break;
            case 'image/gif' :$ok=1;
                break;
            case 'image/png' :$ok=1;
                break;
            case 'image/x-png' :$ok=1;
                break;


        }
        if($ok==1){
            if (move_uploaded_file($tmp_name,$path."/".$filename)){
                $this->make_image($filename);
                return array('code'=>200,'url'=>$filename);

            }
            else
                return false;
        }
        else{
            return array('code'=>0,'msg'=>"非法上传格式");


        }


    }

}

public  function upload1($file,$path){
    if(!is_dir($path)) mkdir($path,0777);//判断文件夹是否存在，不存在则创建
    if($file){

        $str=explode('.', $file["name"]);

        $filename=time().rand(1000,9999).".".$str[count($str)-1];

        $type = $file["type"];
        $size = $file["size"];

        $upload_max=10*1024*1024;
        if($size>$upload_max){


            return array('code'=>0,'msg'=>"上传文件大小不能大于10MB！");

        }
        $tmp_name = $file["tmp_name"];
        $ok=0;
//判断文件类型
        switch ($type) {
            case 'image/pjpeg' :$ok=1;
                break;
            case 'image/jpeg' :$ok=1;
                break;
            case 'image/gif' :$ok=1;
                break;
            case 'image/png' :$ok=1;
                break;
            case 'image/x-png' :$ok=1;
                break;


        }
        if($ok==1){
            if (move_uploaded_file($tmp_name,$path."/".$filename)){
                $this->make_image($filename);
                return array('code'=>200,'url'=>$filename);

            }
            else
                return array('code'=>0,'msg'=>"上传失败");;
        }
        else{
            return array('code'=>0,'msg'=>"非法上传格式");


        }


    }
}

//上传图片并加水印，,$file为原始图片，$path为上传文件夹的路径，$fontType为字体库，必须用相对路径，返回文件名
public function up_mark_image($file,$fontType,$path=''){
global $HttpPath;
if($file){
$imgSrc=$file;
if($_SESSION['userid'])
$result=get_system($_SESSION['userid']);
else
$result=get_system();

		$markImg= $path.$result['ImgWatePath'];
		//echo "<script>alert('$markImg');</script>";echo $result['WateType'];exit();
		$markText=$result['CharacterWateDescription'];
		$fontColor=$result['CharacterWateColor'];
		$markPos=$result['CharacterWateMark'];
		$markType=$result['WateType'];
		$fontSize=$result['CharacterWateSize'];
		if($result['water_open'])
	$mark=$this->setMark($imgSrc,$markImg, $markText, $fontType, $fontColor, $markPos, $markType, $fontSize);
	}

return $mark;

}
}





?>