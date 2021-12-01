

<div class="group_note" id="note_info">
    <div class="menu">
       名称：<?php echo $group['name']; ?>
        <?php if($is_owner==1 || $is_manager==1){?>
        <div class="btn" onclick="addnote();"><i class="icon-edit"></i>发布公告</div>
<?php }?>
    </div>
<div class="content">

<?php if(is_array($list)){foreach($list AS $index=>$value) { ?>
<div class="list">
    <div class="title">
        <?php
         if(strlen($value['imgs'])>5)$imgs=explode('|',$value['imgs']);
        else $imgs=array();
if(count($imgs)==1){
?>
        <div class="img">

            <img src="../<?php echo $imgs[0]; ?>" >
        </div>
        <?php }?>
        <div id="title_<?php echo $value['id'];?>"  <?php if(strlen($value['content'])>200) echo 'class="moreword"';?>>
            <?php if ($value['istop']==1){ ?><span class="istop">置顶</span><?php } ?>
           <?php echo $value['content']; ?>

        <?php if(strlen($value['content'])>200) echo '<a class="more" onclick="show_more('.$value['id'].');">[更多]</a>';?>
    </div></div>
<?php
if(count($imgs)>1){
    $w=92/count($imgs);
    ?>
    <div class="imgs">
        <?php foreach($imgs as $v){
        ?>
        <li style="width:<?php echo $w; ?>%">
            <img src="../<?php echo $v; ?>" >

        </li>
        <?php
        }?>


    </div>

    <?php
    }
?>

    <div class="timer">

       <?php if($is_owner==1 || $is_manager==1){ ?>
        <span style="float: left">
           <a style="color: #3388ff;margin-right: 3px;font-size: 12px;"  onclick="editnote(<?php echo $value['id']; ?>);">
                <i class="icon-edit"></i>编辑
           </a>

                <a style="color: #3388ff;margin-right: 3px;font-size: 12px;" onclick="delete_note(<?php echo $value['id']; ?>);">
                <i class="icon-cancel"></i>删除
           </a>

        </span>
        <?php } ?>

   <?php echo $value['nickname']; ?>发布于<?php echo date('m-d H:i',$value['addtime']); ?> <span style="color: #3388ff;margin-right: 3px;"><?php echo $value['view']; ?>人已阅读</span>

    </div>
</div>


<?php }}?>

</div>


</div>


<script>
    
    function addnote() {
        layer.open({
            type: 2,
            title: false,
            shadeClose: false,shade: 0.6,
            closeBtn:1,
            area: ['80vw','400px'],
            content: 'noteadd.php?from=layer&group_id='+group_id //iframe的url
        });
    }

    function editnote(id) {
        layer.open({
            type: 2,
            title: false,
            shadeClose: false,shade: 0.6,
            closeBtn:1,
            area: ['80vw','400px'],
            content: 'noteadd.php?from=layer&group_id='+group_id+"&id="+id //iframe的url
        });
    }
    
    function delete_note(id) {
        var index=  layer.confirm('确定要删除？', {
            time: 20000, //20s后自动关闭
            btn: ['确定', '取消']
        },function () {
            var loading=layer.load(1, {
                shade: [0.1,'#fff']
            });
            $.post("../api/group.php?act=deletenote",{id:id}, function(result){
                layer.close(loading);
                var res=JSON.parse(result);

                if(res.code=='200'){
                    parent.layer.msg("删除成功",{ type: 1, anim: 2 ,time:1000});
                    location.href='?id=<?php echo $group['id']; ?>&step=2';
                }else{
                    layer.msg("网络连接超时",{ type: 1, anim: 2 ,time:1000});
                }

            });

        },function () {

        });
    }

    
    
    function show_more(id) {
        if(document.querySelector('#title_'+id).className=='moreword'){
            document.querySelector('#title_'+id).className='';
            document.querySelector('#title_'+id).querySelector('.more').innerHTML='[收起]';
        }else{
            document.querySelector('#title_'+id).className='moreword';
            document.querySelector('#title_'+id).querySelector('.more').innerHTML='[更多]';
        }
    }
</script>

