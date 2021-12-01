<?php
include_once '../inc/header.php';

if($_GET['act']=='delete'){
    $userid=$_GET['id'];
    $friendid=$_GET['friendid'];
    $db->query("delete from ".tname('friend')." where userid='{$userid}' and friendid='{$friendid}'");
    $db->query("delete from ".tname('friend')." where friendid='{$userid}' and userid='{$friendid}'");
}



?>



<?php
$userid=$_GET['id'];
$sql="select * from ".tname('friend')." where userid='{$userid}' order by id desc";

?>




<table width="100%" border="0" cellpadding="0" cellspacing="1" class="table_list">

    <tr>






        <th>头像</th>


        <th>昵称</th>
        <th>来源</th>

        <th>添加时间</th>

        <th>基本操作</th>

    </tr>


    <?php

    $query=$db->query($sql);
    while ($row=$db->fetch_array($query)){

        $user=userinfo($row['friendid']);

        ?>
        <tr>




            <td bgcolor="#FFFFFF">
                <img src="<?php echo $user['avatar'] ?>" style="height: 50px; border-radius: 5px;">

            </td>

            <td bgcolor="#FFFFFF"><?php echo $user['nickname'];?></td>



            <td bgcolor="#FFFFFF"><?php echo friend_addmethod($row['from']);?></td>

            <td bgcolor="#FFFFFF"><div align="center">
                    <?php
                    echo date('Y-m-d H:i:s',$row['time'])?>
                </div></td>




            <td bgcolor="#FFFFFF">



                <a href='?id=<?php echo $row['userid']?>&friendid=<?php echo $row['friendid']?>&act=delete&from=parent' onClick="return(confirm('确定要删除吗?删除后不可恢复 '))" class="button">删除</a>

            </td>

        </tr>
    <?php }?>
</table>
