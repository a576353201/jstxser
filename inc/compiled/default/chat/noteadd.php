


<?php include_once template("header");?>
<link rel="stylesheet" href="<?php echo $HttpTemplatePath; ?>static/css/group.css?v=<?php echo time(); ?>" type="text/css" media="screen" />
<script src="/static/js/group.js?v=<?php echo time(); ?>"></script>

<ul class="layer_nav">
    <li class="active"><?php if($note['id']>0) echo '编辑';else echo '发布';?>公告</li>

</ul>
<div class="group_note">
    <div class="menu">
        名称：<?php echo $group['name']; ?>
        <a style="float: right;margin-right: 10px;color: #666;cursor: pointer" onclick="history.back();"><i class="icon-back"></i>返回</a>

    </div>
    <div class="contentadd">

   <textarea id="content" placeholder="请输入要发布的通知内容"><?php echo $note['content'];?></textarea>


        <input type="hidden" name='file[file1]' id='file_add1' value='<?php echo $note['imgs'];?>'>

        <iframe src='../upload_pc.php?fileid=file_add1&img=<?php echo $note['imgs'];?>&iframeid=upload_src1&pc=1&num=3'  id='upload_src1'  style='width:100%;height:100px;'marginwidth="0px" frameborder="0" scrolling="no" ></iframe>
    </div>



    <div class="layer_btns ok" onclick="return click_add();"><i class="icon-ok"></i>确认<?php if($note['id']>0) echo '编辑';else echo '发布';?></div>

</div>
<script>
    var noteid=0;
    <?php if($note['id']>0) echo 'noteid='.$note['id'].';';?>
    function  click_add() {
        if($('#content').val()==''){
            layer.msg("请输入内容",{ type: 1, anim: 2 ,time:1000});
            return false;
        }

        var loading=layer.load(1, {
            shade: [0.1,'#fff']
        });

        $.post("../api/group.php?act=<?php echo $action; ?>",{id:noteid,group_id:<?php echo $group['id']; ?>,content:$('#content').val(),imgs:$('#file_add1').val()}, function(result){
            layer.close(loading);
            var res=JSON.parse(result);

            if(res.code=='200'){
                parent.layer.msg("提交成功",{ type: 1, anim: 2 ,time:1000});
                location.href='note.php?id=<?php echo $group['id']; ?>';
            }else{
                layer.msg("网络连接超时",{ type: 1, anim: 2 ,time:1000});
            }

        });

    }


</script>


<?php include_once template("footer");?>