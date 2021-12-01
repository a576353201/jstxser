
<div class="page">

    <?php if(count($invite_list)>0){?>
    <?php if(is_array($invite_list)){foreach($invite_list AS $index=>$m) { ?>

    <div  class="lists11" id="list_<?php echo $m['id']; ?>">
        <div>
        <span ><span class='title1'>类型：</span>
            <?php if($m['isdaili']==1){?>
                <span class="btn_green">代理</span>
            <?php } else { ?>
                <span class="btn_yellow">玩家</span>
            <?php }?>
        </span>
            <span style="display: none"><span class='title1'>返点：</span><span style='color:#2319DC'><?php echo $m['rebate']; ?>%</span></span>

        </div>
        <div>
                       <span ><span class='title1'>邀请码：</span>
                       <?php echo $m['randcode']; ?>
                       <button class="btn1" onclick="copy('<?php echo $m['randcode']; ?>')">复制</button>
                       </span>
            <span ><span class='title1'>发展人数：</span>
                        <?php echo $m['regnum']; ?>
                      </span>

        </div>

        <div style='color:#777;font-size: 12px;'>
                       <span  >
                       创建于:<?php echo date('Y-m-d',$m['addtime']); ?>
                       </span>
            <span >
                           <?php if($m['remark']==1){?><?php echo $m['remark']; ?><?php }?>


                          </span>

        </div>

        <div class="btns">
            <button class="btn2"  onclick="open_qrcode('<?php echo $m['randcode']; ?>')">查看二维码</button>
            <button class="btn2" onclick="copy_url('<?php echo $m['randcode']; ?>')">复制邀请链接</button>
            <button class="btn2 delete" onclick="delete_url(<?php echo $m['id']; ?>)">
                <uni-icons type='closeempty'></uni-icons>
                删除</button>
        </div>

    </div>

    <?php }}?>

    <?php } else { ?>

    <div class="nodata">
        还有推广链接，<span style='color: #2319DC;' onclick="change_tab(2)">立即新增推广链接</span>
    </div>

    <?php }?>


</div>








<script>

    var randcode='';
    var qrcode='';
    function copy_url(code){

        var url="<?php echo $HttpPath; ?>?from=invite&invite_code="+code;
        copy(url);
    }
    function open_qrcode(code) {
         if(code==randcode){
             parent.layer.open({
                 type: 1,
                 title: false,
                 closeBtn: true,
                 area: ['200px','205px'],
                 skin: 'layui-layer-nobg', //没有背景色
                 shadeClose: true,
                 content:"<img src='"+qrcode+"' style='width: 200px;width: 200px;'>"
             });
         }
        else{
           code=randcode;
            qrcode='';
             $.get("../api/index.php?act=getMyQrcodeCard",{type:'qr_invite',code:code}, function(result){
                 /// layer.close(loading);
                 var res=JSON.parse(result);
                 if(res.code==200){
                     var img=res.data;
                     qrcode=img;
                     parent.layer.open({
                         type: 1,
                         title: false,
                         closeBtn: true,
                         area: ['200px','205px'],
                         skin: 'layui-layer-nobg', //没有背景色
                         shadeClose: true,
                         content:"<img src='"+img+"' style='width: 200px;width: 200px;'>"
                     });
                 }

             });
         }


    }
    function delete_url(id) {
        var index=  layer.confirm('确认要删除吗', {
            title:'提示',
            time: 20000, //20s后自动关闭
            btn: ['删除', '取消']
        },function () {
            //
            $.get("../api/user.php?act=invite_delete",{userid:<?php echo $_SESSION['userid']; ?>,id:id}, function(result){
                /// layer.close(loading);
                var res=JSON.parse(result);
                if(res.code==200){

                }

            });
            $('#list_'+id).remove();
            layer.close(index);
        },function () {

        });
    }
    function copy(text) {
        console.log(text);
        Clipboard.copy(text);
    }
    window.Clipboard = (function(window, document, navigator) {
        var textArea,
            copy;

        // 判断是不是ios端
        function isOS() {
            return navigator.userAgent.match(/ipad|iphone/i);
        }
        //创建文本元素
        function createTextArea(text) {
            textArea = document.createElement('textArea');
            textArea.innerHTML = text;
            textArea.value = text;
            document.body.appendChild(textArea);
        }
        //选择内容
        function selectText() {
            var range,
                selection;

            if (isOS()) {
                range = document.createRange();
                range.selectNodeContents(textArea);
                selection = window.getSelection();
                selection.removeAllRanges();
                selection.addRange(range);
                textArea.setSelectionRange(0, 999999);
            } else {
                textArea.select();
            }
        }

        //复制到剪贴板
        function copyToClipboard() {
            try{
                if(document.execCommand("Copy")){

                    layer.msg('复制成功',{ type: 1, anim: 2 ,time:1000});
                }else{

                    layer.msg('复制失败！请手动复制！',{ type: 1, anim: 2 ,time:1000});
                }
            }catch(err){

                layer.msg('复制错误！请手动复制！',{ type: 1, anim: 2 ,time:1000});

            }
            document.body.removeChild(textArea);
        }

        copy = function(text) {
            createTextArea(text);
            selectText();
            copyToClipboard();
        };

        return {
            copy: copy
        };
    })(window, document, navigator);

</script>



<style>


    .lists11{
        background-color: #fff;
        margin-top: 10px;
        padding: 5px 10px;
        line-height: 25px;
        clear: both;
        display:  inline-block;
        width: calc(100% - 20px);
    }
    .lists11 > div{
        clear: both;
    }
    .lists11 > div > span{
        display: inline-block;
    }
    .lists11 > div > span:first-child{
        text-align: left;
        float: left;
    }
    .lists11 > div > span:last-child{
        text-align: right;
        float: right;
    }
    .lists11 > div .title1{
        color: #666;
    }
    .btn1{
        display: inline-block;
        height: 22px;
        line-height: 22px;vertical-align: middle;font-size: 14px;
        margin-left: 4px;
        background-color: #f8f8f8;
        border: 1px #e7e7e7 solid;
        border-radius: 5px;
        padding: 0px 5px;
    }

    .btn2{
        display: inline-block;
        height: 28px;
        line-height: 28px;vertical-align: middle;font-size: 14px;

        background-color: #2319dc;
        border: 1px #2319dc solid;
        color:#fff;
        border-radius: 5px;
        padding: 0px 10px;
        margin: 0px 5px;
    }
    .btn2.delete{
        background-color: #f8f8f8;
        border: 1px #e7e7e7 solid;
        color:#222;
        padding: 0px 10px;
    }
    .lists11 > div.btns{
        height: 30px;line-height: 30px;text-align: center;
    }

    .qrcode{
        background-color: rgba(0,0,0,0.5);
        position: fixed;
        left: 0px;
        width: 100%;
        height: 100vh;
        top:0px;
    }
    .qrcode .code{
        height: 200px;
        width: 200px;
        top:calc(50% - 150px);
        left: calc(50% - 100px);
        position: fixed;
    }
    .qrcode .close{
        bottom: 80px;;
        left: calc(50% - 20px);
        position: fixed;
        height: 40px;width: 40px;
    }

</style>