<?php
header("Content-type:application/vnd.ms-excel");
header("Content-Disposition:filename=用户数据".date('YmsHis').".xls");
include_once '../inc/header.php';

?>
<style>
td{border:1px solid #ccc;height:30px;line-height:30px;}
</style>




<?php
     $sql="select * from ".tname('user')." where 1=1 ";
     if($_GET['name']) $sql.=" and name='$_GET[name]'";
          if($_GET['realname']) $sql.=" and realname='$_GET[realname]'";
     if($_GET['status']) {$_GET[status]=$_GET[status]-2;$sql.=" and `status`='$_GET[status]'";}

if($_GET['pid'])     $sql.=" and pid='{$_GET['pid']}'";
?>



        <table width="100%"  >

          <tr>



            <td  ><div align="center"><span class="STYLE1">ID</span></div></td>




            <td  ><div align="center"><span class="STYLE1">手机号码</span></div></td>

            <td  ><div align="center"><span class="STYLE1">用户名</span></div></td>

 <td  ><div align="center"><span class="STYLE1">用户级别</span></div></td>
           <td  ><div align="center"><span class="STYLE1">账户余额</span></div></td>
<td  ><div align="center"><span class="STYLE1">冻结金额</span></div></td>
            <td  ><div align="center"><span class="STYLE1">直属人数</span></div></td>
<td><div align="center"><span class="STYLE1">团队人数</span></div></td>

<td ><div align="center"><span class="STYLE1">发布需求</span></div></td>

<td ><div align="center"><span class="STYLE1">参与需求</span></div></td>
<td ><div align="center"><span class="STYLE1">中标需求</span></div></td>
            <td><div align="center"><span class="STYLE1">注册时间</span></div></td>


 <td  ><div align="center"><span class="STYLE1">推荐人</span></div></td>


          </tr>


     <?php

     $query=$db->query($sql);
     while ($row=$db->fetch_array($query)){
     ?>
          <tr>



            <td><div align="center" class="STYLE1">

              <div align="center"><?php echo $row['id']?></div>

            </div>
            </td>

            <td ><div align="center"><span class="STYLE1"><?php echo $row['name'];?></span></div></td>

              <td ><div align="center"><span class="STYLE1"><?php echo $row['realname'];?></span></div></td>


                  <td >
                  <div align="center"><span class="STYLE1">
                  <?php echo $user_group[$row['group']]?></span></div></td>
      <td ><div align="center"><?php echo $row['money']?></div></td>
      <td ><div align="center"><?php echo get_frz_money($row['id'])?></div></td>
              <td ><div align="center"><?php echo get_user_num1($row['id'])?></div></td>
            <td ><div align="center"><?php echo get_user_num2($row['id'])?></div></td>
                   <td ><div align="center"><?php echo get_user_task_num1($row['id'])?></div></td>
                    <td ><div align="center"><?php echo get_user_task_num2($row['id'])?></div></td>
                        <td ><div align="center"><?php echo get_user_task_num3($row['id'])?></div></td>


            <td ><div align="center"><?php echo date('Y-m-d H:i:s',$row['regtime'])?></div></td>

     <td ><div align="center">
     <?php
     if($row['pid']){
     $parent=	get_user_byid($row['pid']);

     if($parent['realname']) echo $parent['realname']."({$parent['name']})";
     else
     	echo $parent['name'];
     }
     else echo '-';
     ?></div></td>
          </tr>
<?php }?>
        </table>