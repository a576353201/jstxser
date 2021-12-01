<?php include_once template("header");?>
<style>
.info .line{line-height: 45px;}
</style>

 <div class="user_center  space"  style='margin-top:60px;'>






<div class='process1'>

<?php

foreach($group_arr as $key=>$value){


	?>




<div id='tit_<?php echo $key;?>'  class='step <?php if($key==0) echo 'cur';?>'  style='width:<?php echo 100/count($group_arr);?>%;'  onclick="set_tabs(<?php echo $key;?>,<?php echo count($group_arr);?>);"; >

<div class='info'><?php echo $value;?></div>
</div>




<?php
}

?>



 </div>

<div class='content_info'>

<div class='info' id='info_0' style='display:block;'>
<?php if($task['title']){?>
<div class='line'>
<span  class='title'>赛事名称：</span>
<a href='../task/info.php?id=<?php echo $task['id']; ?>'><?php echo $task['title']; ?></a>
</div>
<?php }?>


<?php if($user['realname']){?>
<div class='line'>
<span  class='title'>单位名称：</span>
<?php echo $user['realname']; ?>
</div>
<?php }?>

<?php if($team['name']){?>
<div class='line'>
<span  class='title'  >队伍名称：</span>
<span style='font-weight:600'><?php echo $team['name']; ?></span>

</div>
<?php }?>
<div class='line'>
<span  class='title'>填报日期：</span>
<?php echo date('Y-m-d H:i:s',$team['addtime']); ?>

</div>

<?php if(count($lingdui)>0){?>
<div class='line' id='lingdui_div'  style='clear:both;' >
<span  class='title' style='float:left;'>领队信息：</span>

<div  id='lingdui' style='float:left;'>
<?php if(is_array($lingdui)){foreach($lingdui AS $index=>$value) { ?>
<div id="lingdui_<?php echo $index; ?>">
姓名:<?php echo $value['name']; ?>
&nbsp;&nbsp;&nbsp;
 性别:<?php echo $sex_arr[$value['sex']]; ?>
 </div>

<?php }}?>

</div>

</div>

<?php }?>

<?php if(count($fulingdui)>0){?>
<div class='line' id='lingdui_div'  style='clear:both;'  >
<span  class='title' style='float:left;'>副领队信息：</span>

<div  id='lingdui' style='float:left;'>
<?php if(is_array($fulingdui)){foreach($fulingdui AS $index=>$value) { ?>
<div id="lingdui_<?php echo $index; ?>">
姓名:<?php echo $value['name']; ?>
&nbsp;&nbsp;&nbsp;
 性别:<?php echo $sex_arr[$value['sex']]; ?>
 </div>

<?php }}?>

</div>

</div>

<?php }?>


<?php if(count($jiaolian)>0){?>
<div class='line' id='lingdui_div'  style='clear:both;'  >
<span  class='title' style='float:left;'>教练信息：</span>

<div  id='lingdui' style='float:left;'>
<?php if(is_array($jiaolian)){foreach($jiaolian AS $index=>$value) { ?>
<div id="lingdui_<?php echo $index; ?>">
姓名:<?php echo $value['name']; ?>
&nbsp;&nbsp;&nbsp;
 性别:<?php echo $sex_arr[$value['sex']]; ?>
&nbsp;&nbsp;&nbsp;
 是否外籍: <?php if($value['waiji']==1){?>是<?php } else { ?>否<?php }?>&nbsp;&nbsp;&nbsp;
 上年度锦标赛代表单位：<?php echo $value['danwei']; ?>
 </div>

<?php }}?>

</div>

</div>

<?php }?>


<?php if(count($player)){?>

<table style='width:80%;text-align:center;margin:0px auto;line-height:35px;'>

<tr>

  <td>运动员编号</td>
<td>真实姓名</td>
<td>性别</td>

<td>年龄</td>
<td>是否外援</td>
<td>上年度锦标赛参赛单位</td>
</tr>


<?php if(is_array($player)){foreach($player AS $index=>$value) { ?>

<tr  >
  <td><?php echo $value['playerid'];?></td>
<td><a href='../user/space.php?uid=<?php echo $index; ?>'><?php echo $value['realname'];?></a></td>
<td><?php echo $sex_arr[$value['sex']];?></td>

<td><?php echo $value['age'];?></td>
<td> <?php if($value['waiyuan']==1) echo "是";else echo"否";?></td>
<td><?php echo $value['danwei'];?></td>
</tr>

<?php }}?>

</table>
<?php }?>





<?php if($team['other_num']){?>

<div class='line'  style='clear:both;'>
<span  class='title'>其他人数：</span>
<?php echo $team['other_num']; ?>人

</div>
<?php }?>
<?php if($contact['name']){?>
<div class='line'  style='clear:both;'>
<span  class='title'> 联系人姓名：</span>
<?php echo $contact['name']; ?>

</div>
<?php }?>
<?php if($contact['mobile']){?>
<div class='line'  style='clear:both;'>
<span  class='title'>联系人手机：</span>
<?php echo $contact['mobile']; ?>

</div>
<?php }?>
<?php if($contact['tel']){?>
<div class='line'  style='clear:both;'>
<span  class='title'> 联系人固话：</span>
<?php echo $contact['tel']; ?>

</div>
<?php }?>
<?php if($contact['fox']){?>
<div class='line'  style='clear:both;'>
<span  class='title'> 联系传真：</span>
<?php echo $contact['fox']; ?>

</div>
<?php }?>


</div>

<?php if($system['team_view1']==1){?>
<div class='info' id='info_1' style='display:none;'>

<div class='line' id='level_div'  style='clear:both;'>

<?php if(is_array($arrive)){foreach($arrive AS $index=>$value) { ?>

<div class='info00' id='arrive_<?php echo $index; ?>'><div class='title00'>抵达时间<?php echo $num_arr[$index]; ?>


</div>


<div>
<span class='title'>抵达时间：</span><?php echo $value['time']; ?><br>
<span class='title'>航班号(车次)：</span><?php echo $value['hangban']; ?><br>
<?php if($value['mark']){?>
<span class='title'>备注：</span><?php echo $value['mark']; ?><br>
<?php }?>
<span class='title'>人数：</span><?php echo $value['num']; ?>人<br>
<span class='title'>联系人：</span><?php echo $value['contact']; ?><br>
<?php if($value['tel']){?>
<span class='title'>联系人电话：</span><?php echo $value['tel']; ?><br>
<?php }?>
</div>

</div>
<?php }}?>
</div>




<div class='line' id='level_div'  style='clear:both;margin-top:15px;'>
<?php if(is_array($level)){foreach($level AS $index=>$value) { ?>

<div class='info00' id='level_<?php echo $index; ?>'><div class='title00'>离会时间<?php echo $num_arr[$index]; ?>


</div>


<div>
<span class='title'>离会时间：</span><?php echo $value['time']; ?><br>
<span class='title'>航班号(车次)：</span><?php echo $value['hangban']; ?><br>
<?php if($value['mark']){?>
<span class='title'>备注：</span><?php echo $value['mark']; ?><br>
<?php }?>
<span class='title'>人数：</span><?php echo $value['num']; ?>人<br>
<span class='title'>联系人：</span><?php echo $value['contact']; ?><br>
<?php if($value['tel']){?>
<span class='title'>联系人电话：</span><?php echo $value['tel']; ?><br>
<?php }?>
</div>

</div>
<?php }}?>



</div>
</div>
<?php } ?>
<?php if($system['team_view2']==1){?>
<div class='info' id='info_2' style='display:none;'>


<div class='line' id='room_div'  style='clear:both;'>
<?php if(is_array($room)){foreach($room AS $index=>$value) { ?>

<div class='info00' id='room_<?php echo $index; ?>'><div class='title00'>入住需求<?php echo $num_arr[$index]; ?>


</div>


<div>
<span class='title'>户型：</span><?php echo $value['name']; ?><br>
<span class='title'>数量：</span><?php echo $value['num']; ?><br>
<span class='title'>入住时间：</span><?php echo $value['begintime']; ?><br>
<span class='title'>退房时间：</span><?php echo $value['endtime']; ?><br>


<?php if($value['mark']){?>
<div style='clear:both'>
<span class='title'>其他要求：</span>


<?php echo $value['mark']; ?>


</div>
<?php }?>
</div>

</div>
<?php }}?>
</div>




</div>

<?php } ?>
<div class='info' id='info_3' style='display:none;'>
<div class='img_list'>
<?php if($system['team_view3']==1){?>
<?php if(count($file1)>0){?>
<div style='height:35px;line-height:35px;'>报名表盖章扫描件</div>
<?php if(is_array($file1)){foreach($file1 AS $index=>$value) { ?>
<img src='<?php echo $HttpPath; ?><?php echo $value; ?>' onclick="show_img11('<?php echo $HttpPath; ?><?php echo $value; ?>',<?php echo $index; ?>);"  name='img_show'>


<?php }}?>

<?php }?>
<?php } ?>

<?php if($system['team_view3']==1){?>
<?php if(count($file2)>0){?>
<div style='height:35px;line-height:35px;'>外援的协议或有关证明</div>
<?php if(is_array($file2)){foreach($file2 AS $index=>$value) { ?>
<img src='<?php echo $HttpPath; ?><?php echo $value; ?>' onclick="show_img11('<?php echo $HttpPath; ?><?php echo $value; ?>',<?php echo $index; ?>);"  name='img_show'>


<?php }}?>

<?php }?>
<?php } ?>
<?php if(count($file3)>0){?>
<div style='height:35px;line-height:35px;'>团队相册</div>
<?php if(is_array($file3)){foreach($file3 AS $index=>$value) { ?>
<img src='<?php echo $HttpPath; ?><?php echo $value; ?>' onclick="show_img11('<?php echo $HttpPath; ?><?php echo $value; ?>',<?php echo $index; ?>);"  name='img_show'>


<?php }}?>

<?php }?>

</div>

</div>


<?php if(count($task_list)){?>
<div class='info' id='info_4' style='display:none;'>

<table width="100%" border="0" cellpadding="0" cellspacing="1"  class='table_list'>

          <tr>
            <td><div align="center"><span class="STYLE1">赛事名称</span></div></td>

            <td><div align="center"><span class="STYLE1">举办地点</span></div></td>
    <td><div align="center"><span class="STYLE1">
举办时间</span></div></td>


            <td><div align="center"><span class="STYLE1">赛事状态</span></div></td>




          </tr>

 	<?php if(is_array($task_list)){foreach($task_list AS $index=>$value) { ?>

          <tr>


            <td><div align="center"><span class="STYLE1"><a href='../task/info.php?id=<?php echo $value['task_id']; ?>' target='_blank'><?php echo $value['task']['title']; ?></a></span></div></td>
    <td><div align="center">
    <?php

    echo $value['task']['province'].' '.$value['task']['city'].' '.$value['task']['country'];

    ?>

    </div></td>

                      <td><div align="center"><span class="STYLE1"><?php echo date('Y-m-d',$value['task']['begindate']); ?>至 <?php echo date('Y-m-d',$value['task']['enddate']); ?> </span></div></td>

            <td><div align="center"><span class="STYLE1"><?php echo task_status($value['task']['id']); ?></span></div></td>


          </tr>

           <?php }}?>



           </table>








</div>


<?php }?>
</div>
</div>
<script>

function set_tabs(num,sum){


var info=document.querySelector('.content_info').querySelectorAll('.info');
	for(var i=0;i<sum;i++){


		if(i==num){

			document.getElementById('tit_'+i).className='step cur';

			info[i].style.display='block';
		}
		else{
			document.getElementById('tit_'+i).className='step';

			info[i].style.display='none';


		}





	}






}
<?php if($_GET['tabs']){?>
    set_tabs(<?php echo $_GET['tabs'];?>,<?php echo count($group_arr);?>);
 <?php }?>
var img_sum=<?php echo count($file1)+count($file2)+count($file3);?>;
var img_num=0;
function show_img11(src,num){
img_num=num;
	document.getElementById("showbg").style.display='block'
		document.getElementById("show_img").src=src;

}


function show_next(pre){
if(pre==1){

if(img_num==img_sum-1) img_num=0;
else img_num++;
}
else{
if(img_num==0) img_num=img_sum-1;
else img_num--;
}
var img_show=document.getElementsByName("img_show");

	document.getElementById("show_img").src=img_show[img_num].src;

}
</script>


 <div class='rebox'  id='showbg'>

<div class='contents'>

<img src='#'  id='show_img'>

</div>
<div class='pre' onclick="show_next(-1);"></div>
<div class='next' onclick="show_next(1);"></div>
<div class='close' onclick="document.getElementById('showbg').style.display='none';">关闭</div>
</div>

<?php include_once template("footer");?>