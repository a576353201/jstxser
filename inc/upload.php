
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<script type="text/javascript">
function checkUploadPhoto(prompt)
{
  if(document.myform.imgurl.value == '')
  {
    alert(prompt);
    return false;
  }
  return true;
}

function file_up(){
	document.getElementById('up_sub').click();


}


</script>
<title></title>
</head>
<body style="margin:0px; padding:0px;">
  <form enctype="multipart/form-data" method="POST" name="myform"  action="uploadsave.php?action=add" target="_self">
    <input name="imgurl" type="file"  size="20" maxlength="200"  onchange="file_up();">
    <input type="submit" style="display:none"  value="上传" id='up_sub' onClick="return checkUploadPhoto(<?php echo '\''.$promptIncludeDirEmptyUploadPhotoPath.'\'';?>)"/>
    <input style="display:none" name="returnid" type="text" value="<?php echo $_GET['returnid']; ?>" />
 <input style="display:none" name="path" type="text" value="<?php echo $_GET['path']; ?>" />
  <input style="display:none" name="pre" type="text" value="<?php echo $_GET['pre']; ?>" />
    <input style="display:none" name="mark" type="text" value="<?php echo $_GET['mark']; ?>" />
      <input style="display:none" name="image" type="text" value="<?php echo $_GET['image']; ?>" />
  </form>



</body>


</html>