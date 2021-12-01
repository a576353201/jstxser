<?php
include_once '../inc/header.php';

if($_GET['act']=='update'){
    $id=$_GET['id'];
    $_POST['nickname']=$_POST['name'];
    $db->update(tname('group'),$_POST,$id);


add_adminlog("修改【{$_POST['name']}】资料");
    $data=array('group_id'=>$id,'type'=>'GroupUpdate');
    ?>
    <script>
        parent.parent.send_data('<?php echo json_encode($data);?>');
        parent.layer.msg('发送成功');
        parent.location.reload();
        var index=parent.layer.getFrameIndex(window.name);parent.layer.close(index);

    </script>
    <?php
exit();
}


$row=$group=get_table(tname('group'), $_GET['id']);


?>
<style>
    .info .line .title {

        width: 120px;
        margin-right: 10px;
    }
    .line{
        height:50px;
        line-height: 50px;
    }
</style>


<form name='myform' enctype="multipart/form-data" action="?act=update&id=<?php echo $_GET['id'];?>&from=parent" method="post">




    <div class='info' id='info_0' style="padding-top: 30px;" >


        <?php
        if($user['id']){


            ?>
            <div class='line'>
<span  class='title'>
<img src="<?php echo $HttpPath.$group['avatar'];?>"  style='width:50px;height:50px;border-radius:5px;vertical-align: middle'>

</span>
                <input type="text" name="avatar" value="<?php echo $group['avatar']?>" size="20" readonly="readonly" style="width: 180px;" />
                <iframe style=" padding:0; margin:0;" src="../inc/upload.php?returnid=avatar&image=1&path=avatar" frameborder=0 scrolling=no width="200" height="25"></iframe>


            </div>

        <?php  } ?>

        <div class='line'>
                    <span  class='title'>群名称：</span>



                <input name="name" type="text" size="40" maxlength="40" id="name" required  value="<?php echo $group['name'];?>">

        </div>

        <div class='line' style="height: 120px;">
            <span  class='title'>群名称：</span>

<textarea name="content"><?php echo $group['content'];?></textarea>


        </div>


        <div class='line'>
            <span  class='title'>全员禁言：</span>
            <input type="radio" name="no_speaking" value="0" <?php if(!$group['no_speaking']) echo "checked";?>>关闭 &nbsp;
            <input type="radio" name="no_speaking" value="1" <?php if($group['no_speaking']) echo "checked";?>>开启
        </div>

        <div class='line'>
            <span  class='title'>邀请审核：</span>
            <input type="radio" name="no_invite" value="0" <?php if(!$group['no_invite']) echo "checked";?>>关闭 &nbsp;
            <input type="radio" name="no_invite" value="1" <?php if($group['no_invite']) echo "checked";?>>开启
        </div>




    </div>

    <div class='info' >
        <div class='line'>
            <div style='padding-left:150px;'  id='sub_html'>

                <input class='btn01' type='submit' name='Submit' value='保存' >
                <input type="button" value='关闭' class='button' onclick="var index=parent.layer.getFrameIndex(window.name);

parent.layer.close(index);">
            </div>

        </div>

    </div>
</form>
