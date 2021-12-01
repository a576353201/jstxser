<?php
include_once '../inc/header.php';

if($_GET['act']=='back'){
    $msg_id=$_GET['id'];
   $chat=$db->exec("select * from ".tname('chat')." where id='{$msg_id}'");
   if($chat){
       if($chat['groupid']>0){
$store='G'.$chat['groupid'];
       }
       else $store='U'.$chat['userid'];
       $data=array('type'=>'chat_back','userid'=>'admin','msg_id'=>$msg_id,'store'=>$store);

       ?>
       <script>
          parent.send_data('<?php echo json_encode($data);?>');

       </script>
       <?php
       add_adminlog('撤回一条聊天记录');
   }else{

   }
?>
    <script>


       location.href='<?php echo $_SERVER['HTTP_REFERER']?>';


    </script>
<?php
    exit();
}


if($_GET['act']=='delete'){
    $db->query("delete from ".tname('chat')." where id='{$_GET['id']}'");
    add_adminlog('删除了一条聊天记录');

}
$emotion=array('微笑','撇嘴', '色', '发呆', '得意', '流泪', '害羞', '闭嘴', '睡', '大哭', '尴尬', '发怒', '调皮', '呲牙', '惊讶', '难过', '酷', '冷汗', '抓狂', '吐', '偷笑', '可爱', '白眼', '傲慢', '饥饿', '困', '惊恐', '流汗', '憨笑', '大兵', '奋斗', '咒骂', '疑问', '嘘', '晕', '折磨', '衰', '骷髅', '敲打', '再见', '擦汗', '抠鼻', '鼓掌', '糗大了', '坏笑', '左哼哼', '右哼哼', '哈欠', '鄙视', '委屈', '快哭了', '阴险', '亲亲', '吓', '可怜', '菜刀', '西瓜', '啤酒', '篮球', '乒乓', '咖啡', '饭', '猪头', '玫瑰', '凋谢', '示爱', '爱心', '心碎', '蛋糕', '闪电', '炸弹', '刀', '足球', '瓢虫', '便便', '月亮', '太阳', '礼物', '拥抱', '强', '弱', '握手', '胜利', '抱拳', '勾引', '拳头', '差劲', '爱你', 'NO', 'OK', '爱情', '飞吻', '跳跳', '发抖', '怄火', '转圈', '磕头', '回头', '跳绳', '挥手', '激动', '街舞', '献吻', '左太极', '右太极');
?>





<?php
if($_GET['action']=='user')
$sql="select * from ".tname('chat')." where groupid='0' ";
else
    $sql="select * from ".tname('chat')." where groupid>0";
if($_GET['fromname']) $sql.=" and userid in (select id from ".tname('user')." where (name='{$_GET['fromname']}' or nickname='{$_GET['fromname']}')) ";
if($_GET['toname']) $sql.=" and touid in (select id from ".tname('user')." where (name='{$_GET['toname']}' or nickname='{$_GET['toname']}')) ";
if($_GET['groupname']) $sql.=" and group in (select id from ".tname('group')." where (name='{$_GET['groupname']}' or nickname='{$_GET['groupname']}')) ";
if(strlen($_GET['isback'])>0){
    $sql.=" and isback='{$_GET['isback']}'";
}

$sql.=" order by id desc";

$num=20;
$page=new Page($sql, $num, $_GET['page']);
$sql.=" limit $page->from,$num";

?>
<style>

    .chatimg{
        max-height: 50px;
    }
</style>
<form id='formSort' enctype="multipart/form-data" action='' method='get' style='min-height:50px;line-height:50px;padding-left:10px;'>
<input type="hidden" name="action" value="<?php echo $_GET['action'];?>">
    发送人：<input type="text" name="fromname" value="<?php echo $_GET['fromname']; ?>" style="width:120px" >
    <?php
    if($_GET['action']=='user'){
        ?>

        接收人：<input type="text" name="toname" value="<?php echo $_GET['toname']; ?>" style="width:120px" >

    <?php
    }
    else{
        ?>
        所在群组：<input type="text" name="groupname" value="<?php echo $_GET['groupname']; ?>" style="width:120px" >

    <?php
    }
    ?>






    <input class="btn01" type="submit" name="Submit" value="确定"  >


</form>



<table width="100%" border="0" cellpadding="0" cellspacing="1" class="table_list">

    <tr>


<?php
if($_GET['action']=='user'){
    ?>
    <th>发送人</th>
    <th>接收人</th>

        <?php
}
else{
    ?>
    <th>所在群组</th>
    <th>发送人</th>
        <?php
}
?>

        <th>类型</th>
        <th style="width: 500px">内容</th>

        <th>发送时间</th>

        <th>基本操作</th>

    </tr>


    <?php
    $type_arr=array('text'=>'文字','image'=>'图片','emotion'=>'表情','voice'=>'语音','apply'=>'申请','tips'=>'提示');
    $query=$db->query($sql);
    while ($row=$db->fetch_array($query)){
        if($row['userid']>0) $fromuser=userinfo($row['userid']);else $fromuser=array('nickname'=>$system['admin_nickname']);
        if($row['touid']>0)  $touser=userinfo($row['touid']);else $touser=array('nickname'=>$system['admin_nickname']);
        if($row['groupid']>0) {
            $group=$db->exec("select * from ".tname('group')." where id='{$row['groupid']}'");
        }
         $type=$row['type'];
     $content=msg_content($row);
        ?>
        <tr>



            <?php
            if($_GET['action']=='user'){
                ?>
                <td height="30" bgcolor="#FFFFFF">
                    <?php
                    echo $fromuser['nickname']
                    ?>
                </td>
                <td bgcolor="#FFFFFF">
                    <?php
                    echo $touser['nickname']
                    ?>

                </td>

                <?php
            }
            else{
                ?>
                <td bgcolor="#FFFFFF">
                    <?php
                    echo $group['nickname']
                    ?>

                </td>
                <td height="30" bgcolor="#FFFFFF">
                    <?php
                    echo $fromuser['nickname']
                    ?>
                </td>


                <?php
            }
            ?>





            <td  bgcolor="#FFFFFF" style="text-align: center">
                <?php
                echo $type_arr[$type];
                ?>

            </td>
            <td  bgcolor="#FFFFFF" style="text-align: center">
                <?php
                echo $content
                ?>

            </td>





            <td bgcolor="#FFFFFF"><div align="center">
                    <?php
                    echo date('Y-m-d H:i:s',$row['addtime'])?>
                </div></td>




            <td bgcolor="#FFFFFF">




                    <a href='?id=<?php echo $row['id']?>&act=delete&action=<?php echo  $_GET['action'] ;?>'  class="button">删除</a>
                <?php
                if($row['isback']==0){
                    ?>
                    <a href='?id=<?php echo $row['id']?>&act=back&action=<?php echo  $_GET['action'] ;?>'  style="display: none" class="button">测回</a>
                <?php
                }
                ?>


            </td>

        </tr>
    <?php }?>
</table>

<div class="page"><?php echo  $page->get_page();?></div>



<script>
    function showimg(src) {
        var img = "<img src='"+src+"' />";
        layer.open({
            type:1,
            shift: 2,

            maxmin: false,
            shadeClose: true,
            title:false,
            area:['auto'],

            content:img
        });


    }

</script>


<?php include_once '../inc/footer.php';?>

