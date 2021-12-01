<?php include_once template("header");?>


 <div class="user_center">
 <div class='u_left'>

<?php include_once template("user/left");?>
 </div>



 <div class='u_right'>

 <div class='user_nav'>
当前位置：<a href='index.php'>个人中心</a> &gt;<a href='task_me.php'>我管理的比赛</a>



 </div>



<?php if(count($list)>0){?>

        <table width="100%" border="0" cellpadding="0" cellspacing="1"  class='table_list'>

          <tr>
            <td><div align="center"><span class="STYLE1">赛事名称</span></div></td>

            <td><div align="center"><span class="STYLE1">报名数量</span></div></td>
    <td><div align="center"><span class="STYLE1">
举办时间</span></div></td>


            <td><div align="center"><span class="STYLE1">赛事状态</span></div></td>


 <td><div align="center"><span class="STYLE1">基本操作</span></div></td>

          </tr>

 	<?php if(is_array($list)){foreach($list AS $index=>$value) { ?>

          <tr>


            <td><div align="center"><span class="STYLE1"><a href='../task/info.php?id=<?php echo $value['id']; ?>' target='_blank'><?php echo $value['title']; ?></a></span></div></td>
    <td><div align="center"><a href='task_edit.php?type=playerlist&id=<?php echo $value['id']; ?>'> <?php echo $value['player_num']; ?></a></div></td>

                      <td><div align="center"><span class="STYLE1"><?php echo date('Y-m-d',$value['begindate']); ?>至 <?php echo date('Y-m-d',$value['enddate']); ?> </span></div></td>

            <td><div align="center"><span class="STYLE1"><?php echo task_status($value['id']); ?></span></div></td>

      <td><div align="center"><span class="STYLE1">
     <a href='task_edit.php?type=file&id=<?php echo $value['id']; ?>'> 上传附件
       |
       <a href='task_edit.php?type=image&id=<?php echo $value['id']; ?>'>  上传图片</a>

         |  <a href='task_edit.php?type=playeradd&id=<?php echo $value['id']; ?>'>添加报名成员</a></span></div></td>


          </tr>

           <?php }}?>



           </table>


                    <div class="page" ><?php echo $page_html; ?></div>




<?php } else { ?>
<div  style='height:40px;line-height:40px;text-align:center;'>没有找到相关比赛</div>

<?php }?>







</div>
</div>












<?php include_once template("footer");?>