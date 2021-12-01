<?php
include_once '../inc/header.php';


?>

<table width="100%" border="0" cellspacing="0" cellpadding="0" class="titlebg">

      <tr>

        <td width="12" height="30"><img src="../style/images/content/tab_03.gif" width="12" height="30" /></td>

        <td>


         <div style='float:left' ><img src="../style/images/content/tb.gif" width="16" height="16" /></div>

         <div style='float:left'  class="STYLE1">
         <form action='index.php' method='get'>
         <span class="STYLE3">当前位置:</span>队伍管理&nbsp; &nbsp;&nbsp; &nbsp;

         </form>
         </div>


      <div style='float:right;padding-right:5px;'><a href='team_add.php'>添加队伍</a></div>
        </td>

        <td width="16"><img src="../style/images/content/tab_07.gif" width="16" height="30" /></td>

      </tr>

  </table>
<?php
     $sql="select * from ".tname('team')." where 1=1 ";
     if($_GET['name']) $sql.=" and name like '%$_GET[name]%'";
          if($_GET['uid']) $sql.=" and uid='$_GET[uid]'";

     $total=count($db->fetch_all($sql));




     $sql.="order by id desc";
     $num=20;
   $page=new Page($sql, $num, $_GET['page']);
   $sql.=" limit $page->from,$num";

?>

   <form name='formSort' enctype="multipart/form-data" action='team.php' method='get' style='height:50px;line-height:50px;padding-left:10px;'>

          队伍名称：<input type="text" name="name" value="<?php echo $_GET['name']; ?>" >

单位名称：
  <select name="uid" >
      <option value="">不限</option>
  <?php
  $dw=$db->fetch_all("select * from ".tname('user')." where `group`=4 and agree='1'");

  foreach($dw as $value){
  	?>
  	 <option value="<?php echo $value['id']?>" <?php if($value['id']==$_GET['uid']) echo "selected"; ?>><?php echo $value['realname'];?></option>


  	<?php
  }
  ?>


  </select>


                       <input class="button" type="submit" name="Submit" value="确定"  >



</form>



        <table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="b5d6e6" onmouseover="changeto()"  onmouseout="changeback()">

          <tr>








            <td bgcolor="#FFFFFF"><div align="center"><span class="STYLE1">队伍名称</span></div></td>

            <td bgcolor="#FFFFFF"><div align="center"><span class="STYLE1">单位名称</span></div></td>
    <td bgcolor="#FFFFFF"><div align="center"><span class="STYLE1">
运动员</span></div></td>

                      <td bgcolor="#FFFFFF"><div align="center"><span class="STYLE1">抵离信息</span></div></td>
      <td bgcolor="#FFFFFF"><div align="center"><span class="STYLE1">住宿信息</span></div></td>
            <td bgcolor="#FFFFFF"><div align="center"><span class="STYLE1">报备时间</span></div></td>



            <td  bgcolor="#FFFFFF" class="STYLE1"><div align="center">基本操作</div></td>

          </tr>


     <?php

     $query=$db->query($sql);
     while ($row=$db->fetch_array($query)){

$user=get_user_byid($row['uid']);

$player=unserialize($row['player']);
$arrive=unserialize($row['arrive']);
$level=unserialize($row['level']);

       $room=$db->exec("select count(*) as num from ".tname('room')." where tid='{$row['id']}'");

     ?>
          <tr>




<td height="20" bgcolor="#FFFFFF"><div align="center"><span class="STYLE1"><?php echo $row['name'];?></span></div></td>
            <td height="20" bgcolor="#FFFFFF"><div align="center"><span class="STYLE1"><?php echo $user['realname'];?></span></div></td>



 <td height="20" bgcolor="#FFFFFF"><div align="center"><span class="STYLE1"><?php echo count($player);;?></span></div></td>
 <td height="20" bgcolor="#FFFFFF"><div align="center"><span class="STYLE1"><?php echo count($arrive)+count($level);;?></span></div></td>
       <td height="20" bgcolor="#FFFFFF">
    <div align="center"><span class="STYLE1">
                  <?php echo $room['num']?></span></div></td>
            <td height="20" bgcolor="#FFFFFF"><div align="center"><?php echo date('Y-m-d H:i:s',$row['addtime'])?></div></td>

            <td height="20" bgcolor="#FFFFFF">
            <div align="center"><span class="STYLE4">
                  <a href='team_add.php?id=<?php echo $row['id']?>&action=edit'>编辑</a>
&nbsp;&nbsp;


<a href='../../team/index.php?id=<?php echo $row['id']?>'  target='_blank'>预览</a>


                  </span></div></td>

          </tr>
<?php }?>
        </table>
  <table width="100%" border="0" cellspacing="0" cellpadding="0"  background="../style/images/content/tab_19.gif">


      <tr>
    <td width="12" height="35"><img src="../style/images/content/tab_18.gif" width="12" height="35" /></td>



            <td class="STYLE4"><?php echo  $page->get_page();?></td>

            <td></td>

        <td width="16"><img src="../style/images/content/tab_20.gif" width="16" height="35" /></td>
      </tr>

    </table>

<?php include_once '../inc/footer.php';?>

