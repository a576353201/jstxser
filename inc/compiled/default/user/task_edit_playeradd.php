<?php include_once template("header");?>


 <div class="user_center">
 <div class='u_left'>

<?php include_once template("user/left");?>
 </div>



 <div class='u_right'>

 <div class='user_nav'>
当前位置：<a href='index.php'>个人中心</a> &gt;<a href='task_me.php'>我管理的比赛</a>&gt;<a href='task_edit.php?type=playerlist&id=<?php echo $_GET['id']; ?>'><?php echo $task['title']; ?></a> &gt;添加报名成员


 </div>

<div class='info'>
<div class='line'style='height:60px;line-height:60px;padding-left:15px;'>

<form action='task_edit.php'  method='get'>

  <input type="hidden" name="type" value="playeradd" />
  <input type="hidden" name="action" value="search" />
  <input type="hidden" name="id" value="<?php echo $_GET['id'];?>" />


队伍名称：<input type="text"   style='width:180px;' name="name" value="<?php echo $_GET['name']; ?>" >&nbsp;&nbsp;
单位名称：<input type="text"  style='width:180px;' name="dw_name" value="<?php echo $_GET['dw_name']; ?>" >&nbsp;&nbsp;

&nbsp;&nbsp;
<input type='submit' value='搜索' class='btn01'>

&nbsp;&nbsp;&nbsp;&nbsp;

<a href="task_edit.php?type=playerlist&id=<?php echo $_GET['id']; ?>">查看已报名成员</a>

</form>

</div>


<?php
if($_GET['action']=='search'){
	?>

<?php if (count($list)>0){

	?>



        <table width="100%" border="0" cellpadding="0" cellspacing="1"  class='table_list'>

          <tr>
          <td>
  <input type="checkbox" value="1"   onclick="click_all(this);"/>
          </td>
            <td><div align="center"><span class="STYLE1">队伍名称</span></div></td>
                 <td><div align="center"><span class="STYLE1">单位名称</span></div></td>



    <td><div align="center"><span class="STYLE1">
运动员</span></div></td>


            <td><div align="center"><span class="STYLE1">创建时间</span></div></td>



            <td  class="STYLE1"><div align="center">基本操作</div></td>

          </tr>
<?php foreach($list as $index=>$value){


?>


          <tr>
          <td>
  <input type="checkbox" name="id[]" value="<?php echo $value['id']?>" onclick="player_num();" <?php if(in_array($value['id'],$ids)) echo "checked"; ?>/>

  </td>

               <td><div align="center"><a href='../team/index.php?id=<?php echo $value['id']; ?>' target='_blank'><?php echo $value['name'];?></a></div></td>
            <td><div align="center"><span class="STYLE1"><?php echo $value['user']['realname'];?></span></div></td>


    <td><div align="center"><span class="STYLE1"> <?php echo count($value['player']);?> </span></div></td>


            <td><div align="center"><span class="STYLE1"><?php echo date('Y-m-d H:i:s',$value['addtime']);?></span></div></td>



            <td  class="STYLE1">

<a href='task_edit.php?type=playeradd&action=sub&id=<?php echo $_GET['id'];?>&ids=<?php echo $value['id']?>' >确认报名</a>
            </td>

          </tr>

         <?php } ?>



           </table>


                    <div class="page" style='line-height:50px;padding-left:20px;'>
                    <input type='button' value='批量报名' class='btn00'  onclick="sub_add();">

                    &nbsp;    &nbsp;    &nbsp;
                    <?php echo $page_html;?></div>




<?php }else{


?>
<div  style='height:40px;line-height:40px;text-align:center;'>没有找到可以报名的队伍</div>





	<?php
}
}


?>




</div>
</div>
</div>




<script>
function click_all(div){

var playerid=document.getElementsByName('id[]');

for(var i=0;i<playerid.length;i++){

if(div.checked==true)playerid[i].checked=true;

else playerid[i].checked=false;
}

}



function sub_add(){

	var playerid=document.getElementsByName('id[]');
var str='';
for(var i=0;i<playerid.length;i++){

if(playerid[i].checked==true){

if(str!='') str+=',';
str+=playerid[i].value;

}

}
if(str==''){

	alert('至少要选择一个队伍');
	return false;
}

else{

	location.href='task_edit.php?type=playeradd&action=sub&&id=<?php echo $_GET['id'];?>&ids='+str;

}

}

</script>




<?php include_once template("footer");?>