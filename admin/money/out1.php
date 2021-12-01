<?php
header("Content-type:application/vnd.ms-excel");
header("Content-Disposition:filename=提现记录".date('YmsHis').".xls");
include_once '../inc/header.php';

?>
<style>
td{border:1px solid #ccc;height:30px;line-height:30px;}
</style>

  <?php

           if($_GET['username']) $str=" and uid in (select id from ".tname('user')." where name='{$_GET['username']}')";
     if($_GET['begintime']) $str.=" and  time>='".strtotime($_GET['begintime'].' 00:00:00')."'";
     if($_GET['endtime']) $str.=" and time<='".strtotime($_GET['endtime'].' 23:59:59')."'";
     if(isset($_GET['status']) and $_GET['status']!='-1'  and $_GET['status']!=='') $str.=" and status='{$_GET['status']}'";

     $sql="select * from ".tname('plat')." where 1=1 {$str} order by id desc";
          $query=$db->query($sql);
  ?>


        <table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="fff" onmouseover="changeto()"  onmouseout="changeback()" style="margin-left:3px;">

          <tr>


            <td background="../style/images/content/bg.gif" bgcolor="#FFFFFF"><div align="center"><span class="STYLE1">提现用户</span></div></td>
  <td background="../style/images/content/bg.gif" bgcolor="#FFFFFF"><div align="center"><span class="STYLE1">用户名</span></div></td>
            <td background="../style/images/content/bg.gif" bgcolor="#FFFFFF"><div align="center"><span class="STYLE1">提现金额</span></div></td>




            <td background="../style/images/content/bg.gif" bgcolor="#FFFFFF"><div align="center"><span class="STYLE1">汇款 方式</span></div></td>


            <td background="../style/images/content/bg.gif" bgcolor="#FFFFFF"><div align="center"><span class="STYLE1">开户人名称</span></div></td>
            <td background="../style/images/content/bg.gif" bgcolor="#FFFFFF"><div align="center"><span class="STYLE1">汇款账号</span></div></td>

            <td background="../style/images/content/bg.gif" bgcolor="#FFFFFF"><div align="center"><span class="STYLE1">汇款编码</span></div></td>



            <td background="../style/images/content/bg.gif" bgcolor="#FFFFFF"><div align="center"><span class="STYLE1">提现时间</span></div></td>




          </tr>


     <?php


     while ($row=$db->fetch_array($query)){
     	$user=get_user_byid($row['uid']);
     	$bank=unserialize($row['bank']);

     ?>
        <tr>

<td  style="padding-left:5px;" align='center'><?php echo $user['name'];?></td>
 <td  bgcolor="#FFFFFF" style="padding-left:5px;" align='center'><?php if ($user['realname'])echo $user['realname'];else echo "-";?></td>
<td  bgcolor="#FFFFFF" style="padding-left:5px;" align='center'><?php echo $row['money'];?></td>
            <td  bgcolor="#FFFFFF" style="padding-left:5px;" align='center'><?php echo $bank['bankname'];?></td>
            <td  bgcolor="#FFFFFF" style="padding-left:5px;" align='center'>
           <?php echo $bank['realname'];?></td>
            <td  bgcolor="#FFFFFF" style="padding-left:5px;" align='center'>
           <?php echo $bank['banknum'];?></td>


          <td  bgcolor="#FFFFFF" style="padding-left:5px;" align='center'><?php echo $plat_status[$row['status']];?></td>
          <td  bgcolor="#FFFFFF" style="padding-left:5px;" align='center'><?php echo date('Y-m-d H:i:s',$row['time'])?></td>



          </tr>

<?php }?>
        </table>
