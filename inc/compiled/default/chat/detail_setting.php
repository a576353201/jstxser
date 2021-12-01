<style>
    .profile{

        min-height: 45px;
        line-height: 45px;
    }
    .detail > div:last-child .info > ul > li:last-child{
        padding-left: 0px;
    }
    .btn2{
        height: 25px;
        line-height: 25px;
        vertical-align: middle;
        border-radius: 5px;
        text-align: center;
        border: 0px;
        background-color: #ddd;
        color: #666;
        padding: 0px 10px;
    }
</style>
<ul class="profile" >
    <li>名称：</li>
    <li><input type="text" class="input1" id="name" value="<?php echo $group['name']; ?>" placeholder="请输入聊天室名称">

    </li>

</ul>

<ul  class="profile">
    <li>介绍：</li>
    <li>
        <textarea id="content" placeholder="请输入聊天室介绍" style="height: 50px;"><?php echo $group['content']; ?></textarea>

    </li>

</ul>

<ul class="profile" >
    <li>加群验证：</li>
    <li>
        <input type="radio" name="no_invite" value="1" <?php if($group['no_invite']==1){?>checked<?php }?>> 需要验证
        &nbsp;
        <input type="radio" name="no_invite" value="0" <?php if($group['no_invite']!=1){?>checked<?php }?>> 无需验证
    </li>

</ul>

<ul class="profile" >
    <li>添加好友：</li>
    <li>
        <input type="radio" name="no_add" value="1" <?php if($group['no_add']==1){?>checked<?php }?>> 禁止添加
        &nbsp;
        <input type="radio" name="no_add" value="0" <?php if($group['no_add']!=1){?>checked<?php }?>> 允许添加
    </li>

</ul>
<ul class="profile" >
    <li>发送超链接：</li>
    <li>
        <input type="radio" name="issendurl" value="1" <?php if($group['issendurl']==1){?>checked<?php }?>> 允许发送
        &nbsp;
        <input type="radio" name="issendurl" value="0" <?php if($group['issendurl']!=1){?>checked<?php }?>> 禁止发送
    </li>

</ul>
<ul class="profile" style="margin-top: -10px;">
    <li>修改备注：</li>
    <li>
        <input type="radio" name="is_mark" value="1" <?php if($group['is_mark']==1){?>checked<?php }?>> 开启
        &nbsp;
        <input type="radio" name="is_mark" value="0" <?php if($group['is_mark']!=1){?>checked<?php }?>> 关闭
         &nbsp;
        <i class="icon-help-circled" style="cursor: pointer;font-size: 18px;color: #2319dc;"
           onclick="layer.tips('是否开启修改群名片功能', '.icon-help-circled', {tips:[3,'rgba(0,0,0,0.8)']});"></i>
    </li>

</ul>
<ul class="profile" style="margin-top: -10px;">
    <li>全体禁言：</li>
    <li>
        <input type="radio" name="no_speaking" value="1" <?php if($group['no_speaking']==1){?>checked<?php }?>> 开启
        &nbsp;
        <input type="radio" name="no_speaking" value="0" <?php if($group['no_speaking']!=1){?>checked<?php }?>> 关闭
    </li>

</ul>

<ul  class="profile">
    <li>标签：</li>
    <li>
        <div class="tagshow">
            <?php if(is_array($tags)){foreach($tags AS $index=>$value) { ?>
            <span><?php echo $value; ?></span>
            <?php }}?>

        </div>

        <div class="add_btn" onclick="add_tags();" style="height: 20px;line-height: 20px;margin-top: 3px;"><i class="icon-cog" ></i>更改</div>
    </li>

</ul>
<ul class="profile" style="margin-top:5px;">
    <li>其他：</li>
    <li style="vertical-align: middle;line-height: 45px;">
    <input type="button" value="<?php if($is_owner==1){?>解散该群<?php } else { ?>退出该群<?php }?>" class="btn2" onclick="return group_quit();">
    </li>

</ul>
<div class="layer_btns ok" onclick="save_info();"><i class="icon-ok"></i>确认</div>
<div class="tags">

    <div class="content">
        <div class="title">选择标签（最多<?php echo $system['tags_sum']; ?>个）</div>
        <?php if(is_array($tags1)){foreach($tags1 AS $key=>$value) { ?>

        <span onclick="click_tags(<?php echo $key; ?>,'<?php echo $value; ?>')" <?php if(in_array($value,$tags)){?>class='active'<?php }?>><b><?php echo $value; ?></b>
    <i class="icon-ok"></i>
    </span>

        <?php }}?>

    </div>

    <i class="close icon-cancel-circle" onclick=" $('.tags').hide();"></i>
</div>
<script>


    var tags_sum=<?php echo $system['tags_sum']; ?>;
    var tags='<?php echo $group['tags']; ?>';
    function click_tags(num) {
        var span = document.querySelector('.tags').querySelectorAll('span');
        var clicknum=0;
        for(var i=0;i<span.length;i++){

            if(span[i].className=='active') clicknum++;

        }
        for(var i=0;i<span.length;i++){
            if(i==num){
                if(span[i].className=='active'){
                    span[i].className='';
                }

                else{
                    if(clicknum>=tags_sum){
                        return  layer.msg("最多可以选择"+tags_sum+"个标签",{ type: 1, anim: 2 ,time:1000});
                    }
                    span[i].className='active';
                }

            }
        }
        var tags_show='';
        tags='';
        for(var i=0;i<span.length;i++){

            if(span[i].className=='active') {
                var html=  span[i].querySelector('b').innerHTML
                tags_show+="<span style='margin-bottom: 5px;'>"+html+"</span>";
                if(tags!='') tags+=',';
                tags+=html;
            }

        }
        $('.tagshow').html(tags_show);
//        var index = parent.layer.getFrameIndex(window.name);
//        parent.layer.iframeAuto(index);

    }
    function  add_tags() {
        $('.tags').show();
    }
    
    function save_info() {
        if($('#name').val()==''){
            layer.msg("请输入聊天室名称",{ type: 1, anim: 2 ,time:2000});
            return false;
        }

        var no_invite=0;
        var radio= document.getElementsByName('no_invite');
        for(var i=0;i<radio.length;i++){
            if(radio[i].checked) no_invite=radio[i].value;
        }
        var no_speaking=0;
        var radio= document.getElementsByName('no_speaking');
        for(var i=0;i<radio.length;i++){
            if(radio[i].checked) no_speaking=radio[i].value;
        }

        var is_mark=0;
        var radio= document.getElementsByName('is_mark');
        for(var i=0;i<radio.length;i++){
            if(radio[i].checked) is_mark=radio[i].value;
        }
        var issendurl=0;
        var radio= document.getElementsByName('issendurl');
        for(var i=0;i<radio.length;i++){
            if(radio[i].checked) issendurl=radio[i].value;
        }
        $.post("../api/group.php?act=updateinfo",{id:<?php echo $group['id']; ?>,name:$('#name').val(),content:$('#content').val(),tags:tags,no_invite:no_invite,no_speaking:no_speaking,is_mark:is_mark,issendurl:issendurl}, function(result){

            var res=JSON.parse(result);
            if(res.code=='200'){
                layer.msg("修改成功",{ type: 1, anim: 2 ,time:1000});
                var data={type:'GroupUpdate',group_id:'<?php echo $group['id']; ?>'};
                parent.send_data(JSON.stringify(data));
              //  $('#group_title').html($('#name').val());
                setTimeout(function () {
                    location.href="detail.php?step=2&id=<?php echo $group['id']; ?>";
                },500)
            }else{

                layer.msg("网络错误",{ type: 1, anim: 2 ,time:1000});

            }

        });
    }
</script>