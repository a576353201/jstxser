

<?php include_once template("header");?>
<link rel="stylesheet" href="<?php echo $HttpTemplatePath; ?>static/css/group.css?v=<?php echo $cachekey; ?>" type="text/css" media="screen" />
<script src="/static/js/group.js?v=<?php echo $cachekey; ?>"></script>





<div class="detail">

    <div>
        <div class="info" style="margin-top: 10px;">
            <img src="<?php echo $group['avatar']; ?>" class="avatar" style="width: 70px;height: 70px;"/>
            <ul>
                <li>彩匠号：</li>
                <li><?php echo $group['number']; ?></li>
            </ul>
            <ul>
                <li>昵称：</li>
                <li>
                    <?php echo $group['nickname']; ?>
                </li>
            </ul>
        </div>

    </div>
    <div>

        <div class="info">
           <textarea id="content" placeholder="我是..."></textarea>

        </div>
    </div>


</div>

<div class="layer_btns cancel" onclick="closethis();"><i class="icon-cancel"></i>关闭</div>
<div class="layer_btns ok" onclick="apply();"><i class="icon-ok"></i>确认</div>
<script>

    window.onload=function () {
        var index = parent.layer.getFrameIndex(window.name);
        parent.layer.iframeAuto(index);
    }
    function closethis() {
        var index = parent.layer.getFrameIndex(window.name);
        parent.layer.close(index);
    }
    var userid=parseInt('<?php echo $_SESSION['userid']; ?>');

    function  apply() {
        var postdata={userid:userid,friend_uid:'<?php echo $group['id']; ?>',mark:$('#content').val(),from:'<?php echo $_GET['from']; ?>'};
             var loading=layer.load();
        $.post("../api/user.php?act=applyAddFriend",postdata, function(result){
            layer.close(loading);
            var res=JSON.parse(result);
            if(res.code=='200'){
                parent.layer.msg(res.data.message,{ type: 1, anim: 2 ,time:1000});

                if(res.data.send==2){

                    parent.open_chatarea(<?php echo $group['id']; ?>,'<?php echo $group['nickname']; ?>','<?php echo $group['avatar']; ?>',0);

                }
                var index = parent.layer.getFrameIndex(window.name);parent.layer.close(index);

            }else{
                layer.msg("网络连接失败",{ type: 1, anim: 2 ,time:1000});
            }

        });


    }




</script>


<?php include_once template("footer");?>