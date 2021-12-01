

<?php include_once template("header");?>

<link rel="stylesheet" href="<?php echo $HttpTemplatePath; ?>static/css/plan_layer.css?v=<?php echo $cachekey; ?>" type="text/css" media="screen" />
<script src="/static/js/plan.js?v=<?php echo $cachekey; ?>"></script>
<ul class="layer_nav">
    <li class="active">申请成为计划员</li>

</ul>


<ul class="addline" style="margin-top: 10px;">
    <li>计划员名称：</li>
    <li>
     <input type="text" id="title" class="input1" value="" maxlength="5" onblur="check_name(this.value);" autocomplete="off" placeholder="最多5个字，如XX计划">

        <i id="name_tips" class="tips"></i>
    </li>
</ul>
<ul class="addline">
    <li>计划员签名：</li>
    <li>
        <input type="text" id="sign" class="input1" value="" maxlength="100" autocomplete="off" placeholder="请输入您发布计划的签名">

    </li>
</ul>
<div class="plan_bottom" style="display:block;text-align: center">
    <div class="btns clear" onclick="close_box();" style="float: none;"><i class="icon-cancel"></i>关闭</div>
    <div class="btns ok" onclick="click_public();" style="float: none;"><i class="icon-ok"></i>提交申请</div>


</div>

<script>
    var name_status=false;
    function check_name(value) {

            if(value.length>1){
                $.post("../api/plan.php?act=checkname",{username:value}, function(result){
                    var res=JSON.parse(result);
                    console.log(res);
                    if(res.code==200){
                        document.querySelector('#name_tips').className='tips icon-ok-circle';
                        name_status=true;
                    }else{
                        document.querySelector('#name_tips').className='tips icon-cancel-circle';
                        name_status=false;
                        layer.msg("该计划名已经被使用",{ type: 1, anim: 2 ,time:1000});
                    }

                });

            }else{
                document.querySelector('#name_tips').className='tips icon-cancel-circle';
                name_status=false;

            }





    }
    
    function click_public() {
        if ($('#title').val() == "") {
            parent.layer.msg("请输入计划名称",{ type: 1, anim: 2 ,time:1000});
            document.getElementById('title').focus();
            return false;
        }

        if ($('#title').val().length<2 || $('#title').val().length>5 ) {
            parent.layer.msg("计划名称最多5个字，最少2个字",{ type: 1, anim: 2 ,time:1000});
            document.getElementById('title').focus();
            return false;
        }

        var reglx = /^[\u0391-\uFFE5]+$/;
        if(!reglx.test($('#title').val())){
            layer.msg("计划名称只能包含中文",{ type: 1, anim: 2 ,time:1000});
            document.getElementById('title').focus();
            return false;
        }
        if ($('#sign').val() == "") {
            parent.layer.msg("请输入计划签名",{ type: 1, anim: 2 ,time:1000});
            document.getElementById('sign').focus();
            return false;
        }

        if ($('#sign').val().length<2 || $('#sign').val().length>100 ) {
            parent.layer.msg("计划名称最多100个字，最少2个字",{ type: 1, anim: 2 ,time:1000});
            document.getElementById('sign').focus();
            return false;
        }
        if(name_status==false){
            layer.msg("该计划化名已经被使用",{ type: 1, anim: 2 ,time:1000});
            return false;
        }
        var index=  layer.confirm("请确认您提交的内容，提交之后不能修改", {
            title:'申请提示',
            time: 20000, //20s后自动关闭
            btn: ['确认申请', '取消']
        },function () {
            //
            apply_public();
            layer.close(index)
        },function () {

        });

    }
    
    function apply_public() {
        $.post("../api/plan.php?act=apply",{title:$("#title").val(),sign:$("#sign").val()}, function(result){

            result=JSON.parse(result);
            if(result.code==200){
                parent.layer.msg("申请已提交",{ type: 1, anim: 2 ,time:1000});

                setTimeout(function () {
                    var index = parent.layer.getFrameIndex(window.name);
                    parent.layer.close(index);
                },100)
            }
            else{
                parent.layer.msg(result.message,{ type: 1, anim: 2 ,time:1000});
            }
        });
    }
    
    
    function close_box() {
        var index = parent.layer.getFrameIndex(window.name);
        parent.layer.close(index);
    }
    
    
    window.onload=function () {

        var index = parent.layer.getFrameIndex(window.name);
        parent.layer.iframeAuto(index);
    }

</script>
<?php include_once template("footer");?>