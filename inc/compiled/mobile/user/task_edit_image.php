<?php include_once template("header");?>


 <div class="user_center">



<div class='info' style='padding-left:10px;'>
<form action='task_edit.php?type=<?php echo $type; ?>&id=<?php echo $_GET['id']; ?>' method='post'>

<div class='line'  style='height:auto;clear:both;'>


    <span style='font-size:20px;'>赛事照片</span><span style='font-size:14px;'>(请上传小于10MB的照片)</span>


    <input type="hidden" name='file[file1]' id='file_add1' value='<?php echo $file['file1'];?>'>

<iframe src='../upload_mobile.php?fileid=file_add1&img=<?php echo $file['file1'];?>&iframeid=upload_src1&num=100'  id='upload_src1'  style='width:100%;height:100px;'marginwidth="0px" frameborder="0" scrolling="no" ></iframe>
</div>

<div class='line'  style='clear:both;'>
<div style='padding-left:50px;'>


 <input class="btn01" type="submit" name="Submit" value="提 交"  onclick="return check_add();" >
 <input class="btn00" type="button" value="返回"  onclick="window.history.go(-1); " >



</div>

</div>

</div>
</form>
</div>

</div>











<?php include_once template("footer");?>