<?php
include_once '../inc/header.php';


?>



<?php
$userid=$_GET['id'];
$sql="select * from ".tname('group')." where user_id like '%{$userid}%' order by id desc";

?>




<table width="100%" border="0" cellpadding="0" cellspacing="1" class="table_list">

    <tr>






        <th>群组名称</th>


        <th>发言数量</th>
        <th>最近发言时间</th>



    </tr>


    <?php

    $query=$db->query($sql);
    while ($row=$db->fetch_array($query)){

       $chat=$db->fetch_all("select * from ".tname('chat')." where userid='{$userid}' and groupid='{$row['id']}' and isback='0' order by id desc");
       $chat_num=count($chat);
       if($chat_num>0)
       $chat_time=date('Y-m-d H:i:s',$chat[0]['addtime']);

         else $chat_time='-';
        ?>
        <tr>





            <td bgcolor="#FFFFFF"><?php echo $row['nickname'];?></td>



            <td bgcolor="#FFFFFF"><?php echo $chat_num;?></td>

            <td bgcolor="#FFFFFF"><div align="center">
                    <?php
                    echo $chat_time
                    ?>
                </div></td>





        </tr>
    <?php }?>
</table>
