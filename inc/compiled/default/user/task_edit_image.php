<?php include_once template("header");?>


 <div class="user_center">
 <div class='u_left'>

<?php include_once template("user/left");?>
 </div>



 <div class='u_right'>

 <div class='user_nav'>
当前位置：<a href='index.php'>个人中心</a> &gt;<a href='task_me.php'>我管理的比赛</a>&gt;<a href='task_edit.php?type=<?php echo $type; ?>&id=<?php echo $_GET['id']; ?>'><?php echo $task['title']; ?></a> &gt;上传图片

 </div>

<div class='info' style='padding-left:50px;'>
<form action='task_edit.php?type=<?php echo $type; ?>&id=<?php echo $_GET['id']; ?>' method='post'>

<div class='line'  style='height:auto;clear:both;'>


    <span style='font-size:20px;'>赛事照片</span><span style='font-size:14px;'>(请上传小于2MB的照片,格式限于jpg、png)</span>


    <input type="hidden" name='file[file1]' id='file_add1' value='<?php echo $file['file1'];?>'>

<iframe src='../upload_pc.php?fileid=file_add1&img=<?php echo $file['file1'];?>&iframeid=upload_src1&pc=1&num=100'  id='upload_src1'  style='width:100%;height:100px;'marginwidth="0px" frameborder="0" scrolling="no" ></iframe>
</div>

<div class='line'  style='clear:both;'>
<div style='padding-left:140px;'>


 <input class="btn01" type="submit" name="Submit" value="提 交"  onclick="return check_add();" >
 <input class="btn00" type="button" value="返回"  onclick="window.history.go(-1); " >



</div>

</div>

</div>
</form>
</div>

</div>


    <script language="JavaScript" type="text/javascript" >

    var file_num=<?php echo count($file['file2']);?>;


    function file_add(){

var str="<div id='room_"+file_num+"'  style='margin-top:5px;margin-bottom:5px;'>"
+"<select  name='file[file2]["+file_num+"][type]' ><?php foreach($type_list as $value){ ?><option value='<?php echo $value; ?>'><?php echo $value; ?></option><?php } ?></select>"
+"<input name='file[file2]["+file_num+"][src]' type='text' id='file_"+file_num+"'value='' size='45'  readonly='readonly'>"
+"<iframe style='padding:0; margin:0;vertical-align:middle;' src='../inc/upload.php?returnid=file_"+file_num+"&path=file' frameborder=0 scrolling=no width='70' height='25' ></iframe>";


if(file_num==0)
str+="<span class='icon_add1' onclick='file_add();'></span>";
else
str+="<span class='icon_add2' onclick='room_remove(\"room_"+file_num+"\");'></span>";
str+="</div>"

$('#file_div').append(str);
file_num++;
}


function room_remove(div){
$('#'+div).remove();
file_num--;
}


if(file_num==0)file_add();




    </script>

















    <style>


    .rebox { position: fixed; width: 100%; height: 100%; top: 0; left: 0;bottom:0px;right:0px; z-index: 10000000;
background-color:#000;
filter:alpha(opacity=100);
-moz-opacity:1;
opacity:1;display:none;
}
.rebox .contents {
background-color:#000;display:block;
}

.rebox .contents img { 	max-width: 100%; max-height: 100%; position: absolute; top: 0; left: 0; right: 0; bottom: 0; margin: auto;
background-color:#000;
}

.rebox .close{
	position: absolute;
    z-index: 99999999999999999999999999;
    min-width: 50px;
    height: 50px;
    line-height: 50px;
    background:#000;
    text-decoration: none;
    font-size: 24px;
    color: #fff;
    text-align: center;
    vertical-align: middle;
    -webkit-border-radius: 32px;
    border-radius: 32px;
    -webkit-transition: all 0.3s;
    transition: all 0.3s;
    left:46%;bottom:20px;

}


    </style>



    <div class='rebox'  id='showbg'>

<div class='contents'>

<img src='#'  id='show_img'>

</div>
<div class='close' onclick="document.getElementById('showbg').style.display='none';">关闭</div>
</div>







<?php include_once template("footer");?>