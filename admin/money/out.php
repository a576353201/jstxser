<?php
header("Content-type:application/vnd.ms-excel");
header("Content-Disposition:filename=资金流水".date('YmsHis').".xls");
include_once '../inc/header.php';

?>
<style>
td{border:1px solid #ccc;height:30px;line-height:30px;}
</style>




<?php
      if($_GET['username']) $str=" and uid in (select id from ".tname('user')." where name='{$_GET['username']}')";
     if($_GET['begintime']) $str.=" and  time>='".strtotime($_GET['begintime'].' 00:00:00')."'";
     if($_GET['endtime']) $str.=" and time<='".strtotime($_GET['endtime'].' 23:59:59')."'";
     $sql="select * from ".tname('money')." where 1=1 {$str} order by id desc";

?>



        <table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="b5d6e6" >

          <tr>


            <td height="22" background="../style/images/content/bg.gif" bgcolor="#FFFFFF"><div align="center"><span class="STYLE1">手机号</span></div></td>
  <td height="22" background="../style/images/content/bg.gif" bgcolor="#FFFFFF"><div align="center"><span class="STYLE1">用户名</span></div></td>
            <td height="22" background="../style/images/content/bg.gif" bgcolor="#FFFFFF"><div align="center"><span class="STYLE1">金额</span></div></td>




            <td height="22" background="../style/images/content/bg.gif" bgcolor="#FFFFFF"><div align="center"><span class="STYLE1">账户余额</span></div></td>


            <td height="22" background="../style/images/content/bg.gif" bgcolor="#FFFFFF"><div align="center"><span class="STYLE1">时间</span></div></td>
            <td height="22" background="../style/images/content/bg.gif" bgcolor="#FFFFFF"><div align="center"><span class="STYLE1">说明</span></div></td>


          </tr>


     <?php

     $query=$db->query($sql);
     while ($row=$db->fetch_array($query)){
     	$user=get_user_byid($row['uid']);


     ?>
        <tr>

<td height="30" bgcolor="#FFFFFF" style="padding-left:5px;" align='center'><?php echo $user['name'];?></td>

<td height="30" bgcolor="#FFFFFF" style="padding-left:5px;" align='center'><?php if ($user['realname'])echo $user['realname'];else echo "-";?></td>
<td height="30" bgcolor="#FFFFFF" style="padding-left:5px;" align='center'><?php if($row['money']>0)echo "<font color='red'>+".$row['money'].'</font>';else echo "<font color='green'>".$row['money'].'</font>';?></td>
            <td height="30" bgcolor="#FFFFFF" style="padding-left:5px;" align='center'><?php echo $row['money1'];?></td>

          <td height="30" bgcolor="#FFFFFF" style="padding-left:5px;" align='center'><?php echo date('Y-m-d H:i:s',$row['time'])?></td>
                   <td height="30" bgcolor="#FFFFFF" style="padding-left:5px;" align='center'><?php echo $row['content'];?></td>


          </tr>

<?php }?>
        </table>
