<?php
include_once '../inc/header.php';



if($_GET['act']=='delete'){
    $db->query("delete from ".tname('chat')." where id='{$_GET['id']}'");
    add_adminlog('删除了一条聊天记录');

}

if($_GET['act']=='read'){

    if($_GET['msg_id']>0){
        $db->query("update ".tname('chat')." set isread=1 where id='{$_GET['msg_id']}'");

    }
}

$emotion=array('微笑','撇嘴', '色', '发呆', '得意', '流泪', '害羞', '闭嘴', '睡', '大哭', '尴尬', '发怒', '调皮', '呲牙', '惊讶', '难过', '酷', '冷汗', '抓狂', '吐', '偷笑', '可爱', '白眼', '傲慢', '饥饿', '困', '惊恐', '流汗', '憨笑', '大兵', '奋斗', '咒骂', '疑问', '嘘', '晕', '折磨', '衰', '骷髅', '敲打', '再见', '擦汗', '抠鼻', '鼓掌', '糗大了', '坏笑', '左哼哼', '右哼哼', '哈欠', '鄙视', '委屈', '快哭了', '阴险', '亲亲', '吓', '可怜', '菜刀', '西瓜', '啤酒', '篮球', '乒乓', '咖啡', '饭', '猪头', '玫瑰', '凋谢', '示爱', '爱心', '心碎', '蛋糕', '闪电', '炸弹', '刀', '足球', '瓢虫', '便便', '月亮', '太阳', '礼物', '拥抱', '强', '弱', '握手', '胜利', '抱拳', '勾引', '拳头', '差劲', '爱你', 'NO', 'OK', '爱情', '飞吻', '跳跳', '发抖', '怄火', '转圈', '磕头', '回头', '跳绳', '挥手', '激动', '街舞', '献吻', '左太极', '右太极');
?>





<?php


  $row= $db->exec("select count(*) as num from ".tname('chat')." where groupid='0' and userid>0 and touid='{$system['admin_id']}' and isread=0 ");
  $isread=$row['num'];

    $sql="select * from ".tname('chat')." where groupid='0' and userid>0 and touid='{$system['admin_id']}' ";

if($_GET['fromname']) $sql.=" and userid in (select id from ".tname('user')." where (name='{$_GET['fromname']}' or nickname='{$_GET['fromname']}' or number='{$_GET['fromname']}' or id='{$_GET['fromname']}')) ";
if(!$_GET['isread']) $_GET['isread']=0;
if($_GET['isread']!=-1){
    $sql.=" and isread='{$_GET['isread']}'";

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

    状态：<select name='isread' onchange="document.getElementById('formSort').submit();">
        <option value="-1"  <?php if($_GET['isread']==-1) echo "selected";?>>不限</option>
        <option value='1' <?php if($_GET['isread']==1) echo "selected";?>>已读</option>
        <option value="0" <?php if($_GET['isread']==0) echo "selected";?>>未读</option>


    </select>


    <input class="btn01" type="submit" name="Submit" value="搜索"  >
  <span style="font-size: 14px">

       未读数量:<span style="color: #ff0000;"><?php echo $isread;?></span>
  </span>

</form>



<table width="100%" border="0" cellpadding="0" cellspacing="1" class="table_list">

    <tr>


        <th>头像</th>

            <th>用户名</th>



        <th style="width: 500px">内容</th>
        <th>状态</th>
        <th>发送时间</th>

        <th>基本操作</th>

    </tr>


    <?php
    $type_arr=array('text'=>'文字','image'=>'图片','emotion'=>'表情','voice'=>'语音','apply'=>'申请');
    $query=$db->query($sql);
    while ($row=$db->fetch_array($query)){
        if($row['userid']>0) $fromuser=userinfo($row['userid']);else $fromuser=array('nickname'=>$system['admin_nickname']);
        if($row['touid']>0)  $touser=userinfo($row['touid']);else $touser=array('nickname'=>$system['admin_nickname']);

        $type=$row['type'];
        $content=msg_content($row);
        ?>
        <tr>


            <td height="30" bgcolor="#FFFFFF">
             <img src="<?php echo $fromuser['avatar']?>" style="height: 40px;border-radius: 5px;">
            </td>


                <td height="30" bgcolor="#FFFFFF">
                    <?php
                    echo $fromuser['nickname']
                    ?>
                </td>






            <td  bgcolor="#FFFFFF" style="text-align: center">
                <?php
                echo $content;
                ?>

            </td>


            <td  bgcolor="#FFFFFF" style="text-align: center">
                <?php if ($row['isread']==0) echo "<span style=\"background-color: red;color: #fff;padding: 0px  5px;border-radius: 3px;\">未读</span>";else  echo '<span style=\"background-color: green;color: #fff;padding: 0px  5px;border-radius: 3px;\">未读</span>"';?>


            </td>



            <td bgcolor="#FFFFFF"><div align="center">
                    <?php
                    echo date('Y-m-d H:i:s',$row['addtime'])?>
                </div></td>




            <td bgcolor="#FFFFFF">

                <a class="button"
                   onclick="layer.open({
                       type: 2,
                       title: '回复-<?php echo  $fromuser['nickname'];?>',
                       maxmin: true,
                       shadeClose: true, //点击遮罩关闭层
                       area : ['500px' , '250px'],
                       content: 'msg_add.php?id=<?php echo $row['userid']?>&from=parent&msg_id=<?php  echo $row['id'];?>'
                       });">回复</a>

                <?php
                if ($row['isread']==0){
                    ?>
                    <a href='?msg_id=<?php echo $row['id']?>&act=read'  class="button">已读</a>
                    <?php
                }
                ?>

                <a href='?id=<?php echo $row['id']?>&act=delete&action=<?php echo  $_GET['action'] ;?>'  class="button">删除</a>


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

