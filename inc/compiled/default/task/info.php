<?php include_once template("header");?>

<style>
.info .line{line-height: 45px;}
</style>

 <div class="user_center  space"  style='margin-top:60px;'>

  <div class='user_nav'>
<span class="more">当前位置：<a href='<?php echo $HttpPath; ?>'>首页</a>&gt;&gt;
<a href='<?php echo $HttpPath; ?>task/index.php'>赛事</a>&gt;&gt;
<a href='<?php echo $HttpPath; ?>task/index.php?year=<?php echo date('Y',$task['begindate']); ?>'><?php echo date('Y',$task['begindate']); ?>年</a>&gt;&gt;
</span>
<span><?php echo $task['title']; ?></span>

<span style='float:right;'>
<form action='index.php'  method='get'>
<input type='hidden' name='year' value='-1'>
<input type="text" name="title" value="" style="width: 150px;border: 1px solid #dbdbdb;height: 30px;line-height: 30px;padding: 0 10px;">
<input type='submit' value='搜索' class='btn01'>
</form>
</span>

 </div>

<table style='width:100%;'>
<tr>


<td style='width:260px;text-align:center;'>
<img src="<?php echo task_ico($task['id']); ?>" style='width:200px;max-height:300px;min-height:200px;border:1px solid #ddd;border-radius:5px;padding:3px;'>

</td>

<td  valign='top'  style='line-height:40px;font-size:16px;'>
<div class='task_title'>
<?php echo $task['title']; ?>
</div>
<span class='title'>赛事类别:
<a href='index.php?typeid=<?php echo $task['typeid']; ?>' target="_blank"><?php echo nav_show($task['typeid']); ?></a>
</span>
<br>
<span class='title'>赛事状态:</span>
<a href='index.php?status=<?php echo $task['status']; ?>' target="_blank"><?php echo task_status($task['id']); ?></a>

<br>

<?php if($task['city']){?>
<span class='title'>举办地点:</span>
<a href='index.php?status=-2&province=<?php echo $task['province']; ?>'><?php echo $task['province']; ?></a>
<a href='index.php?status=-2&city=<?php echo $task['city']; ?>'><?php echo $task['city']; ?></a>
<a href='index.php?status=-2&country=<?php echo $task['country']; ?>'><?php echo $task['country']; ?></a> <?php echo $task['address']; ?>
<br>
<?php }?>

<span class='title'>举办时间:</span> <?php echo date('Y-m-d',$task['begindate']); ?>至 <?php echo date('Y-m-d',$task['enddate']); ?><br>
<span class='title'>报名剩余时间:</span><span id='count_down'></span>
<?php if($lasttime>0   ){?>
<input type='button' value='报名参赛' class='btn01' id='bm_btn'   onclick="click_bm();">

<?php }?>

<br>


</td>
</tr>
</table>

<script>

_get_ser_time(<?php echo $lasttime; ?>);
</script>

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





<div class='info' id='info_0' style='display:block;'>

<?php echo $task['content']; ?>

</div>


<div class='info' id='info_1' style='display:none;'>
<?php if(count($active_list)>0){?>
 <table width="100%" border="0" cellpadding="0" cellspacing="1"  class='table_list'>

          <tr>
            <td><div align="center"><span class="STYLE1">编号</span></div></td>
             <td><div align="center"><span class="STYLE1">单位名称</span></div></td>
            <td><div align="center"><span class="STYLE1">队伍名称</span></div></td>

            <td><div align="center"><span class="STYLE1">运动员数量</span></div></td>

            <td><div align="center"><span class="STYLE1">报名时间</span></div></td>





          </tr>

 	<?php if(is_array($active_list)){foreach($active_list AS $index=>$value) { ?>

          <tr>
            <td><div align="center"><span class="STYLE1"><?php echo $value['num']; ?></span></div></td>
   <td><div align="center"><span class="STYLE1"><?php echo $value['user']['realname']; ?></span></div></td>
            <td><div align="center"><a href='../team/index.php?id=<?php echo $value['id']; ?>'  target="_blank"><?php echo $value['name']; ?></a></div></td>
    <td><div align="center"><span class="STYLE1"> <?php echo $value['player_num']; ?> </span></div></td>

            <td><div align="center"><span class="STYLE1"><?php echo date('Y-m-d H:i:s',$value['addtime']); ?></span></div></td>



          </tr>

           <?php }}?>



           </table>


<?php } else { ?>

<div class='nodata'>
暂时没有报名数据
</div>
<?php }?>

</div>

<div class='info' id='info_2' style='display:none;'>

<?php if(count($news_list)>0){?>
 <table width="100%" border="0" cellpadding="0" cellspacing="1"  class='table_list'>

          <tr>
            <td><div align="center"><span class="STYLE1">标题</span></div></td>
            <td><div align="center"><span class="STYLE1">浏览量</span></div></td>



            <td><div align="center"><span class="STYLE1">创建时间</span></div></td>





          </tr>

 	<?php if(is_array($news_list)){foreach($news_list AS $index=>$value) { ?>

          <tr>


            <td><div align="center"><a href='../news/news.php?id=<?php echo $value['id']; ?>'  target="_blank"><?php echo $value['title']; ?></a></div></td>
    <td><div align="center"><span class="STYLE1"> <?php echo $value['clicknum']; ?> </span></div></td>

            <td><div align="center"><span class="STYLE1"><?php echo date('Y-m-d H:i:s',$value['edittime']); ?></span></div></td>



          </tr>

           <?php }}?>



           </table>


<?php } else { ?>

<div class='nodata'>
暂时没有相关新闻
</div>
<?php }?>


</div>



<div class='info' id='info_3' style='display:none;'>


<div class='img_list'>
<?php if(count($file1)>0){?>
<?php if(is_array($file1)){foreach($file1 AS $index=>$value) { ?>
<img src='<?php echo $HttpPath; ?><?php echo $value; ?>' onclick="show_img11('<?php echo $HttpPath; ?><?php echo $value; ?>',<?php echo $index; ?>);"  name='img_show'>


<?php }}?>
<?php } else { ?>
<div class='nodata'>
暂时没有赛事图片
</div>
<?php }?>

</div>


</div>

<div class='info' id='info_4' style='display:none;'>


<div class='file_list' style='padding-left:50px;line-height:35px;'>
<?php if(count($file['file2'])>0){?>
<?php if(is_array($file['file2'])){foreach($file['file2'] AS $index=>$value) { ?>
<div>
<?php echo $index+1;?>、<a href='<?php echo $HttpPath; ?><?php echo $value['src']; ?>' target='_blank'>[<?php echo $value['type']; ?>]<?php echo $value['mark']; ?></a>
</div>

<?php }}?>
<?php } else { ?>
<div class='nodata'>
暂时没有上传附件
</div>
<?php }?>

</div>




</div>


</div>

<script>

function click_bm(){



 <?php if($lasttime>0){?>

location.href='../team/add.php?tid=<?php echo $task['id']; ?>';


 <?php } else { ?>

	window.wxc.xcConfirm('报名已经截止',window.wxc.xcConfirm.typeEnum.warning);

		return  false;


<?php }?>

}





function set_tabs(num,sum){



	for(var i=0;i<sum;i++){


		if(i==num){

			document.getElementById('tit_'+i).className='step cur';

			document.getElementById('info_'+i).style.display='block';
		}
		else{
			document.getElementById('tit_'+i).className='step';

			document.getElementById('info_'+i).style.display='none';


		}





	}






}

var img_sum=<?php echo count($file1);?>;
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