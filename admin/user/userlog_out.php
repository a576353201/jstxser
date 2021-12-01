<?php
header("Content-type:application/vnd.ms-excel");
header("Content-Disposition:filename=用户日志".date('YmsHis').".xls");
include_once '../inc/header.php';

?>
<style>
td{border:1px solid #ccc;height:30px;line-height:30px;background-color:#fff;}
</style>


<?php
    $sql="select * from ".tname('userlog')." where 1=1 ";

     if($_GET['name']) $sql.=" and name='$_GET[name]'";

?>



   <table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="b5d6e6" onmouseover="changeto()"  onmouseout="changeback()" style="margin-left:3px;">


          <tr>





            <td ><div align="center">手机号码</div></td>

            <td ><div align="center">操作</div></td>
    <td ><div align="center">IP</div></td>

                      <td ><div align="center">所在城市</div></td>

            <td ><div align="center">时间</div></td>


          </tr>


     <?php

     $query=$db->query($sql);
     while ($row=$db->fetch_array($query)){
     ?>
          <tr>



            <td ><div align="center"><span class="STYLE1"><?php echo $row['name'];?></span></div></td>

              <td ><div align="center"><span class="STYLE1"><?php echo $row['content'];?></span></div></td>

 <td ><div align="center"><span class="STYLE1"><?php echo $row['ip'];?></span></div></td>
 <td ><div align="center"><span class="STYLE1"><?php echo $row['address'];?></span></div></td>
            <td ><div align="center"><?php echo date('Y-m-d H:i:s',$row['time'])?></div></td>
          </tr>
<?php }?>
        </table>