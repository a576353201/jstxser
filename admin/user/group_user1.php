<?php
include_once '../inc/header.php';


?>



<?php
$id=$_GET['id'];
$sql="select * from ".tname('group')." where id='{$id}' order by id desc";
$group=$db->exec($sql);
$manager_id=explode(',',$group['manager_id']);
$deny_id=explode(',',$group['deny_id']);
$uids=explode(',',$group['user_id']);

?>




<table width="100%" border="0" cellpadding="0" cellspacing="1" class="table_list">

    <tr>






        <th>头像</th>


        <th>昵称</th>
        <th>状态</th>
        <th>发言数量</th>
        <th>最近发言时间</th>



    </tr>


    <?php

    if(count($uids)>0){
        foreach ($uids as $uid){


            $chat=$db->fetch_all("select * from ".tname('chat')." where userid='{$uid}' and groupid='{$id}' and isback='0' order by id desc");
            $chat_num=count($chat);
            if($chat_num>0)
                $chat_time=date('Y-m-d H:i:s',$chat[0]['addtime']);

            else $chat_time='-';
            $user=userinfo($uid);
            ?>


            <tr>
                <td bgcolor="#FFFFFF"><img src="<?php echo $user['avatar'];?>" style="height: 40px" onerror="this.src='../../uploads/avatar.jpg'"></td>
                <td bgcolor="#FFFFFF"><?php echo $user['nickname'];?></td>
                <td bgcolor="#FFFFFF">
                    <?php
                    if($group['createid']==$uid) echo '群主';
                    else if(in_array($uid,$manager_id)) echo '管理员';
                    else if(in_array($uid,$deny_id)) echo '禁言';
                    else echo '-';

                    ?></td>


                <td bgcolor="#FFFFFF"><?php echo $chat_num;?></td>

                <td bgcolor="#FFFFFF"><div align="center">
                        <?php
                        echo $chat_time
                        ?>
                    </div></td>





            </tr>
            <?php

        }


    } ?>
</table>
