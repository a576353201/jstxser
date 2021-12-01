<?php include_once template("header");?>


 <div class="user_center">

<div style='height:80px;line-height:40px;padding-left:5px;'>
共有 <?php echo count($active_list); ?>个参赛队伍
<br>
 <input class="btn01" type="button" name="Submit" value="新增参赛队伍"  onclick="location.href='task_edit.php?type=playeradd&id=<?php echo $_GET['id']; ?>';" >


<?php
if(count($active_list)>0){

?>

 <input class="btn00" type="button" value="导出参赛队伍"  onclick="location.href='../out/team.php?id=<?php echo $_GET['id']; ?>';" >

<?php } ?>
</div>


<?php if(count($active_list)>0){?>

        <table width="100%" border="0" cellpadding="0" cellspacing="1"  class='table_list'>

        <tr>
            <td><div align="center"><span class="STYLE1">编号</span></div></td>
            <td><div align="center"><span class="STYLE1">队伍名称</span></div></td>

            <td><div align="center"><span class="STYLE1">运动员数量</span></div></td>

            <td><div align="center"><span class="STYLE1">报名时间</span></div></td>


 <td><div align="center"><span class="STYLE1">操作</span></div></td>


          </tr>

 	<?php if(is_array($active_list)){foreach($active_list AS $index=>$value) { ?>

           <tr>
            <td><div align="center"><span class="STYLE1"><?php echo $value['num'];?></span></div></td>

            <td><div align="center"><a href='../team/index.php?id=<?php echo $value['team_id'];?>' ><?php echo $value['team_name'];?></a></div></td>
    <td><div align="center"><span class="STYLE1"> <?php echo $value['player_num'];?> </span></div></td>

            <td><div align="center"><span class="STYLE1"><?php echo date('Y-m-d H:i:s',$value['addtime']);?></span></div></td>

<td>
<a onclick="del_player('<?php echo $value['id'];?>');">删除</a>

</td>

          </tr>

           <?php }}?>



           </table>


                    <div class="page" ><?php echo $page_html; ?></div>




<?php } else { ?>
<div  style='height:40px;line-height:40px;text-align:center;'>没有找到相关参赛队伍</div>

<?php }?>







</div>




<script>




function del_player(id){

	if(confirm('确定要删除吗? ')){

location.href='task_edit.php?type=playerlist&action=delete&id=<?php echo $_GET['id']; ?>&active_id='+id;

	}


}




</script>








<?php include_once template("footer");?>