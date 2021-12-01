<?php include_once '../../inc/common.php';?>
<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
<?php

$returnid=$_POST['returnid'];

include_once '../../inc/Image.php';
if($_FILES['imgurl']['name'] != ''  )
{
	if($_POST['image']==1){
	$path='../../uploads/';
	if($_POST['path']) $path=$path.$_POST['path']."/";
   $img =new Image();

  $filename= $img->up_image($_FILES['imgurl'], $path);
 if($filename and $_POST['pre']==1){
 	$pre=$img->make_image($path.$filename);

 }
 if($filename and $_POST['mark']==1)
 $img->up_mark_image($path.$filename, '../../inc/simhei.ttf',"../../");
 $path1=str_replace("../../", "", $path);
  $pre1=str_replace("../../", "", $pre);
   $filesize=number_format($_FILES['imgurl']['size']/1024,0);
  echo "<SCRIPT language=javascript>\n";
  echo "parent.document.myform.".$returnid.".value='".$path1.$filename['url']."';\n";
   if($_POST['pre']==1) {
   	echo "parent.document.myform.imgurlpre.src='".$pre."';\n";
   echo "parent.document.myform.imgpreurl.value='".$pre1."';\n";

   }

  echo "parent.layer.msg('上传成功,图片大小".$filesize."K');location.href='upload.php?returnid=$returnid&path=$_POST[path]&image=1&pre=$_POST[pre]&mark=$_POST[mark]";

  echo "&fromPage=uploadsave.php";
  echo "'; </script>";
}
else{


	$path='../../uploads/';
	if($_POST['path']>-1) $path=$path.$_POST['path']."/";

  $filename= up_file($_FILES['imgurl'], $path);


 $path1=str_replace("../../", "", $path);

   $filesize=number_format($_FILES['imgurl']['size']/1024,0);
  echo "<SCRIPT language=javascript>\n";
  echo "parent.document.getElementById('".$returnid."').value='".$path1.$filename."';\n";

  echo "parent.layer.msg('上传成功,附件大小".$filesize."K');location.href='upload.php?returnid=$returnid&path=$_POST[path]&pre=$_POST[pre]&mark=$_POST[mark]";

  echo "&fromPage=uploadsave.php";
  echo "'; </script>";



}

}

?>