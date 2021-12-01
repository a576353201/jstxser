<?php include_once template("header");?>


 <div class="user_center">
 <div class='u_left'>

<?php include_once template("user/left");?>
 </div>



 <div class='u_right'>

 <div class='user_nav'>
当前位置：<a href='index.php'>个人中心</a> &gt;<a href='team.php'><?php echo $title; ?></a>

<?php if($user['group']==4){?>
<a style='float:right;' href='<?php echo $HttpPath; ?>team/add.php'>创建队伍</a>&nbsp;


<?php }?>
 </div>



<?php if(count($list)>0){?>

        <table width="100%" border="0" cellpadding="0" cellspacing="1"  class='table_list'>

          <tr>
            <td><div align="center"><span class="STYLE1">队伍名称</span></div></td>

            <td><div align="center"><span class="STYLE1">单位名称</span></div></td>
    <td><div align="center"><span class="STYLE1">
运动员</span></div></td>

                      <td><div align="center"><span class="STYLE1">抵离信息</span></div></td>
      <td><div align="center"><span class="STYLE1">住宿信息</span></div></td>
            <td><div align="center"><span class="STYLE1">申报时间</span></div></td>



            <td  class="STYLE1"><div align="center">基本操作</div></td>

          </tr>

 	<?php if(is_array($list)){foreach($list AS $index=>$value) { ?>

          <tr>
  <td><div align="center"><span class="STYLE1"><a href='../team/index.php?id=<?php echo $value['id']; ?>' target='_blank'><?php echo $value['name']; ?></a></span></div></td>

            <td><div align="center"><span class="STYLE1"><?php echo $value['user']['realname']; ?></span></div></td>

     <td><div align="center"><span class="STYLE1"> <?php echo count($value['player']); ?> </span></div></td>

                      <td><div align="center"><span class="STYLE1"><?php echo count($value['level'])+count($value['arrive']); ?></span></div></td>
      <td><div align="center"><span class="STYLE1"><?php echo count($value['room']); ?></span></div></td>
            <td><div align="center"><span class="STYLE1"><?php echo date('Y-m-d H:i:s',$value['addtime']); ?></span></div></td>



            <td  class="STYLE1">

<a href='../team/index.php?id=<?php echo $value['id']; ?>' target='_blank'>预览</a>
<?php if($user['group']==4){?>
&nbsp; | &nbsp;
<a href='../team/add.php?type=edit&step=1&id=<?php echo $value['id']; ?>' >编辑</a>

<?php }?>

            </td>

          </tr>

           <?php }}?>



           </table>


                    <div class="page" ><?php echo $page_html; ?></div>




<?php } else { ?>
<div  style='height:40px;line-height:40px;text-align:center;'>没有找到相关队伍
<?php if($user['group']==4){?>
&nbsp;
<a  href='<?php echo $HttpPath; ?>team/add.php'>立即创建队伍</a>
<?php }?>
</div>

<?php }?>







</div>
</div>












<?php include_once template("footer");?>