<?php
include_once '../inc/header.php';

if($_GET['action']=='add'){

    $userid=$_GET['id'];

    $fromid=$system['admin_id'];
    if(!is_friend($fromid,$userid)) add_friend($fromid,$userid);
    $data=array('userid'=>$fromid,'friend_uid'=>$userid,'content'=>$_POST['content'],'msgtype'=>'text','type'=>'chat');

    ?>
    <script>
        parent.parent.send_data('<?php echo json_encode($data);?>');
        parent.layer.msg('发送成功');
        var index=parent.layer.getFrameIndex(window.name);parent.layer.close(index);

    </script>
    <?php
    add_adminlog('发消息');

 exit();
}

if($_GET['msg_id']>0){
    $db->query("update ".tname('chat')." set isread=1 where id='{$_GET['msg_id']}'");

}


?>


<form name='myform' enctype="multipart/form-data" action="msg_add.php?action=add&from=<?php echo $_GET['from'];?>&id=<?php echo $_GET['id'];?>" method="post">
<div style="line-height: 40px;padding-top: 10px;text-align: center">

    <textarea style='width:90%;height: 130px;padding:2px 10px' name='content'  name='content' id='content' placeholder="请输入要发送的内容......"></textarea>
    <br>
    <input class="btn" type="submit" name="Submit" value="确认并发送"  onclick="return check_add();" >&nbsp;&nbsp;&nbsp;&nbsp;
    <input class="button" type="reset" name="Submit" value="关闭" onclick="var index=parent.layer.getFrameIndex(window.name);parent.layer.close(index);" >

</div>


</form>
<script type="text/javascript">


    function   check_add(){

	if(document.getElementById('content').value==''){

        layer.msg('请输入内容');return false;
				}





    }

</script>



