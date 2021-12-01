<ul>
    <li>群号码：</li>
    <li><?php echo $group['id']; ?></li>
</ul>
<ul>
    <li>群名称：</li>
    <li><?php echo $group['name']; ?></li>
</ul>
<ul>
    <li>群介绍：</li>
    <li>
        <?php if($group['content']){?>
        <?php echo $group['content']; ?>
        <?php } else { ?>
        <span style="color: #999;line-height: 25px;">
            该群创建于<?php echo date('Y-m-d',$group['addtime']); ?>，这个群主很懒，什么也没留下

        </span>
        <?php }?>
    </li>
</ul>
<?php if(count($tags)>0 && $group['tags']){?>
<ul>
    <li>群标签：</li>
    <li >
        <div class="tagshow">
            <?php if(is_array($tags)){foreach($tags AS $index=>$value) { ?>
            <span><?php echo $value; ?></span>
            <?php }}?>

        </div>


    </li>
</ul>

<?php }?>
<ul>
    <li>成员数量：</li>
    <li><?php echo $group['people_count']; ?>/<?php echo $group['people_max']; ?></li>
</ul>

<div class="manage_info">
    <div>群主\管理员：</div>
    <div>
        <?php if(is_array($userlist)){foreach($userlist AS $index=>$value) { ?>
        <?php if($value['type']=='owner' || $value['type']=='manager'){?>
        <span>
    <img src="<?php echo $value['avatar']; ?>" title="<?php echo $value['nickname']; ?>" onclick="parent.user_detail(<?php echo $value['id']; ?>)"/>
    </span>
        <?php }?>
        <?php }}?>

    </div>
</div>
