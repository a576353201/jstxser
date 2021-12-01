

<ul style="margin-top: 10px;">
    <li>置顶：</li>
    <li>
        <input type="radio" name="istop" value="1" <?php if($msgtop){?>checked<?php }?> onclick="setmsgtop(true);">置顶  &nbsp;&nbsp;&nbsp;

        <input type="radio" name="istop" value="0" <?php if(!$msgtop){?>checked<?php }?> onclick="setmsgtop(false);">取消置顶
    </li>
</ul>


<ul style="margin-top: 10px">
    <li>免打扰：</li>
    <li>
        <input type="radio" name="notip" value="1" <?php if($msgnotip){?>checked<?php }?> onclick="setmsgnotip(true);">开启  &nbsp;&nbsp;&nbsp;

        <input type="radio" name="notip" value="0" <?php if(!$msgnotip){?>checked<?php }?> onclick="setmsgnotip(false);">关闭
    </li>
</ul>

<?php if($isin==1 && $is_owner==0 && $is_manager==0){?>
<ul style="margin-top: 10px;text-align: center">
    <div class="quit_btn" onclick="return group_quit();"><i class="icon-logout"></i>退出该群</div>
</ul>
    <?php }?>


<script>

    function setmsgtop(status) {


        var  data = {cache_key:'G<?php echo $group['id']; ?>',userid:userid,istop:status};


        $.get("../api/group.php?act=set_msgtop",data, function(result){
            parent.lastchat();
        });

    }
    function setmsgnotip(status) {


        var  data = {cache_key:'G<?php echo $group['id']; ?>',userid:userid,notip:status};


        $.get("../api/group.php?act=set_msgnotip",data, function(result){

        });

    }
</script>