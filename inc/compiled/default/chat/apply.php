

<?php include_once template("header");?>
<link rel="stylesheet" href="<?php echo $HttpTemplatePath; ?>static/css/group.css?v=<?php echo $cachekey; ?>" type="text/css" media="screen" />
<script src="/static/js/group.js?v=<?php echo $cachekey; ?>"></script>





<div class="detail">

    <div>
        <div class="info" style="margin-top: 10px;">
            <img src="<?php echo $group['avatar']; ?>" class="avatar" style="width: 70px;height: 70px;"/>
            <ul>
                <li>群名称：</li>
                <li><?php echo $group['name']; ?></li>
            </ul>
            <ul>
                <li>群介绍：</li>
                <li style="line-height: 25px;">
                    <?php if($group['content']){?>
                    <?php echo $group['content']; ?>
                    <?php } else { ?>
                    <span style="color: #999;">
            该群创建于<?php echo date('Y-m-d',$group['addtime']); ?>，这个群主很懒，什么也没留下

        </span>
                    <?php }?>
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
        var data={type:'Apply_Group',userid:userid,group_id:'<?php echo $group['id']; ?>',content:$('#content').val()};
        parent.send_data(JSON.stringify(data));
        var index = parent.layer.getFrameIndex(window.name);
        parent.layer.close(index);
        parent.layer_loading=layer.load(1, {
            shade: [0.1,'#fff']
        });
        parent.layer_name= parent.layer.getFrameIndex(window.name);;
    }




</script>


<?php include_once template("footer");?>