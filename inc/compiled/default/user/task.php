<?php include_once template("header");?>


 <div class="user_center">
 <div class='u_left'>

<?php include_once template("user/left");?>
 </div>



 <div class='u_right'>

 <div class='user_nav'>
当前位置：<a href='index.php'>个人中心</a> &gt;<a href='task.php'>我参加的比赛</a>

 </div>



<?php if(count($list)>0){?>

        <table width="100%" border="0" cellpadding="0" cellspacing="1"  class='table_list'>

          <tr>
            <td><div align="center"><span class="STYLE1">赛事名称</span></div></td>

            <td><div align="center"><span class="STYLE1">参赛队伍</span></div></td>
    <td><div align="center"><span class="STYLE1">
举办时间</span></div></td>


            <td><div align="center"><span class="STYLE1">报名状态</span></div></td>


  <td><div align="center"><span class="STYLE1">操作</span></div></td>

          </tr>

 	<?php if(is_array($list)){foreach($list AS $index=>$value) { ?>

          <tr>


            <td><div align="center"><span class="STYLE1"><a href='../task/info.php?id=<?php echo $value['task']['id']; ?>' target='_blank'><?php echo $value['task']['title']; ?></a></span></div></td>
    <td  >

    <div align="center"><a href='../team/index.php?id=<?php echo $value['id']; ?>' target='_blank'><?php echo $value['name']; ?></a></div>


    </td>

                      <td><div align="center"><span class="STYLE1"><?php echo date('Y-m-d',$value['task']['begindate']); ?>至 <?php echo date('Y-m-d',$value['task']['enddate']); ?> </span></div></td>

            <td><div align="center">
            <?php
            if($value['sub']==1) echo "报名成功";
            else  echo "未完成";

            ?>

            </div></td>

            <td>

            <div align="center">
            <?php if($user['group']==4){?>
            <a href='../team/add.php?tid=<?php echo $value['tid']; ?>&id=<?php echo $value['id']; ?>'>编辑</a>

            &nbsp;| &nbsp;

            <a onClick="if(confirm('确定要取消报名吗? ')) location.href='task.php?act=delete&id=<?php echo $value['id']; ?>';" >取消报名</a>


          <?php } else { ?>

<a href='../team/index.php?id=<?php echo $value['id']; ?>' target='_blank'>查看报名信息</a>

           <?php }?>
            </div>


            </td>


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