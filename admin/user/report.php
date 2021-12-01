<?php
include_once '../inc/header.php';

if($_GET['act']=='delete'){
    $db->query("delete from ".tname('user_report')." where id='{$_GET['id']}'");
    add_adminlog('删除了一条举报记录');

}
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

?>





<?php
$status=array('未处理','举报成功','举报失败');
    $sql="select * from ".tname('user_report')." where 1";
if($_GET['fromname']) $sql.=" and fromid in (select id from ".tname('user')." where (name='{$_GET['fromname']}' or nickname='{$_GET['fromname']}')) ";
if($_GET['toname']) $sql.=" and userid in (select id from ".tname('user')." where (name='{$_GET['toname']}' or nickname='{$_GET['toname']}')) ";

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
    发起人：<input type="text" name="fromname" value="<?php echo $_GET['fromname']; ?>" style="width:120px" >


        被举报用户：<input type="text" name="toname" value="<?php echo $_GET['toname']; ?>" style="width:120px" >







    <input class="btn01" type="submit" name="Submit" value="确定"  >


</form>



<table width="100%" border="0" cellpadding="0" cellspacing="1" class="table_list">

    <tr>


            <th>发起人</th>
            <th>被举报用户</th>



        <th style="width: 500px">举报内容</th>
        <th>处理意见</th>
        <th>时间</th>
        <th>状态</th>
        <th>基本操作</th>

    </tr>


    <?php

    $query=$db->query($sql);
    while ($row=$db->fetch_array($query)){
        if($row['fromid']>0) $fromuser=userinfo($row['fromid']);else $fromuser=array('nickname'=>$system['admin_nickname']);
        if($row['userid']>0)  $touser=userinfo($row['userid']);else $touser=array('nickname'=>$system['admin_nickname']);
        ?>
        <tr>



                <td height="30" bgcolor="#FFFFFF">
                    <?php
                    echo $fromuser['nickname']
                    ?>
                </td>
                <td bgcolor="#FFFFFF" style="color: #2319DC">
                    <a     onclick="layer.open({
                        type: 2,
                        title: '被举报用户-<?php echo $touser['nickname'] ?>',
                        maxmin: true,
                        shadeClose: true, //点击遮罩关闭层
                        area : ['800px' , '700px'],
                        content: 'add.php?id=<?php echo $row['userid']?>&action=edit&from=parent'
                        });" >
                    <?php echo $touser['nickname'] ?>
                    </a>

                </td>






            <td  bgcolor="#FFFFFF" style="text-align: center">
                <?php
                echo $row['content'];
                ?>

            </td>
            <td  bgcolor="#FFFFFF" style="text-align: center">
                <?php
                if($row['replay']) echo $row['replay'];else echo '-';
                ?>

            </td>





            <td bgcolor="#FFFFFF"><div align="center">
                    <?php
                    echo date('Y-m-d H:i',$row['time'])?>
                </div></td>


            <td bgcolor="#FFFFFF"><div align="center">
                    <?php
                    echo $status[$row['status']]


                    ?>
                </div></td>

            <td bgcolor="#FFFFFF">





                    <a  onclick="layer.open({
                        type: 2,
                        title: '举报详情',
                        maxmin: true,
                        shadeClose: true, //点击遮罩关闭层
                        area : ['600px' , '500px'],
                        content: 'report_info.php?id=<?php echo $row['id']?>&from=parent'
                        });" class="button"
                    ><?php   if($row['status']==0) echo '处理';else echo '详情'; ?></a>

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

