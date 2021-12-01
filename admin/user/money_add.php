<?php
include_once '../inc/header.php';

if(!$_GET['action']) $action='add';
else $action=$_GET['action'];
$user=$admin=get_table(tname('user'), $_GET['id']);


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



    <div class='info' id='info_0' style="padding-top: 5px;" >




        <div class='line'>
            <span  class='title'>账号：</span>
            <input name="name" type="text" style="width: 180px" id="name" value="<?php echo $admin['name'];?>">

        </div>
        <div class='line'>
            <span  class='title'>充值金额：</span>
            <input id="money" type="text" size="30" maxlength="40" value="" placeholder="整数新增负数扣除" style="width: 120px">元

        </div>
        <div class='line'>
            <span  class='title'>备注：</span>
            <input id="mark" type="text" size="30" maxlength="40" value="" placeholder="请输入备注" style="width: 180px">

        </div>

    </div>

    <div class='info' >
        <div class='line'>
            <div style='padding-left:130px;'  id='sub_html'>

                <input class='btn01' type='button' name='Submit' value='确定' onclick='check_add(); '>
                <input type="button" value='关闭' class='button' onclick="var index=parent.layer.getFrameIndex(window.name);parent.layer.close(index);">
            </div>

        </div>

    </div>

<script type="text/javascript">


    function   check_add(){
            var name=$('#name').val();
            var money=$('#money').val();
            if(name==''){
                parent.layer.msg('请输入账号！',{ type: 1, anim: 2 ,time:1000});
                document.getElementById('name').focus();
                return false;
            }
        if(money=='' || money==0){
            parent.layer.msg('请输入充值金额！',{ type: 1, anim: 2 ,time:1000});
            document.getElementById('money').focus();
            return false;
        }
        if (isNaN(money)) {
            parent.layer.msg('充值金额必须为数字！',{ type: 1, anim: 2 ,time:1000});
            document.getElementById('money').focus();
            return false;
        }
        var loading=layer.load(1, {
            shade: [0.1,'#fff']
        });
        $.post("/api/pay.php?act=admin_charge",{money:money,name:name,mark:$('#mark').val()}, function(result){
            layer.close(loading);
            result=JSON.parse(result);

            if(result.code==200){
                var data=result.data;
                parent.layer.msg('充值成功！',{ type: 1, anim: 2 ,time:1000});
                setTimeout(function () {
                    parent.location.reload();
                },1000)
            }
            else{
                parent.layer.msg(result.message,{ type: 1, anim: 2 ,time:1000});
            }



        });


    }












</script>

