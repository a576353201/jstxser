<div class="group_detail">

    <ul class="avatarline" style="position: relative;">
        <li >
            <img src="<?php echo $group['avatar']; ?>" class="avatar" />
        </li>
        <li>
            <div class="title" id="group_title"><?php echo $group['name']; ?></div>
            <div>
                ID:<?php echo $group['id']; ?>
            </div>
        </li>


        <i class="icon-qrcode" style="position: absolute;right: 10px;top:0px;font-size: 26px;color: #3388ff" onclick="qrcode();"></i>
    </ul>
    <div class="mark">
        <div>
            该群创建于<?php echo date('Y-m-d',$group['addtime']); ?>
        </div>
        <div>
            <?php if($group['content']){?>
            <?php echo $group['content']; ?>
            <?php } else { ?>
            这个群主很懒，什么也没留下

            <?php }?>
        </div>

    </div>
    <ul class="lines"     <?php if($is_owner==1 || $is_manager==1){?>onclick="change_tab(3);add_tags();"<?php }?>>
        <li>
            群标签
        </li>
        <li>
            <div class="tagshow" style="width: 100%;">
                <?php if(is_array($tags)){foreach($tags AS $index=>$value) { ?>
                <span><?php echo $value; ?></span>
                <?php }}?>

            </div>
        </li>
        <li >

            <?php if($is_owner==1 || $is_manager==1){?>
            <i class="icon-right-open-1"></i>
        <?php }?>

        </li>

    </ul>
    <ul class="lines"  style="height: 30px;line-height: 30px;"  onclick="change_tab(1);">
        <li>
            管理员
        </li>
        <li style="text-align: right" >
            共<?php echo $managenum; ?>人
        </li>
        <li >
            <i class="icon-right-open-1"></i>
        </li>

    </ul>

    <div class="users">
        <div>
            <?php if(is_array($userlist)){foreach($userlist AS $index=>$value) { ?>
            <?php if($value['type']=='owner' || $value['type']=='manager'){?>
            <li onclick="parent.user_detail(<?php echo $value['id']; ?>,group_id)">
                <img src="<?php echo $value['avatar']; ?>" /><br>
                <?php echo $value['name']; ?>

            </li>
            <?php }?>
            <?php }}?>



        </div>


    </div>

    <ul class="lines" style="height: 30px;line-height: 30px;"  onclick="change_tab(1);">
        <li>
            群成员
        </li>
        <li>
            共<?php echo $group['people_count']; ?>人
        </li>
        <li >


            <i class="icon-right-open-1"></i>
        </li>

    </ul>
    <?php if($group['people_count']!=$managenum){?>
    <div class="users">
        <div>
            <?php if(is_array($userlist)){foreach($userlist AS $index=>$value) { ?>
            <?php if($value['type']=='user'  && $index<13){?>
            <li onclick="parent.user_detail(<?php echo $value['id']; ?>,group_id)">
                <img src="<?php echo $value['avatar']; ?>" /><br>
                <?php echo $value['name']; ?>

            </li>
            <?php }?>
            <?php }}?>
                  <li >
                      <img src="/static/images/icon-plus.png" onclick="qrcode();"/>

                  </li>

            <?php if($is_owner==1 || $is_manager==1){?>
            <li >
                <img src="/static/images/icon-mins.png" onclick="change_tab(1);"/>

            </li>
            <?php }?>




        </div>
        <?php if($group['people_count']-$managenum>13){?>
        <span class="nodata" onclick="change_tab(1);">

            查看全部群成员
        </span>
        <?php }?>

    </div>

    <?php }?>
    <?php if($isin==1 && ($is_owner!=1 && $is_manager!=1)){?>
    <ul class="lines" >
        <li>其他：</li>
        <li style="text-align: left">
            <input type="button" value="退出该群" class="btn2" onclick="return group_quit();">
        </li>
<li>

</li>
    </ul>

    <?php }?>
</div>
<?php if($_SESSION['userid']>0){?>


<?php if($isin==1){?>
<div class="group_btn" onclick="go_chat();"><i class="icon-chat"></i>发消息</div>
<?php } else { ?>
<div class="group_btn" onclick="apply_group(<?php echo $group['no_invite']; ?>);"><i class="icon-plus-circle"></i>申请入群</div>
<?php }?>

<?php } else { ?>
<div class="group_btn" onclick="login_btn();">立即登录</div>
<?php }?>