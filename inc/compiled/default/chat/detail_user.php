<style>
    .usertop{
        position: absolute;
        height: 50px;
        line-height: 30px;
        top:0px;
        width: 100%;
        left: 0px;
    }
    .usertop >div:first-child{
        height: 25px;
        line-height: 20px;

        width: 100%;
    }

    .usertop >div:first-child .update{
        float: right;
        color: #3388ff;
        text-decoration: underline;
        cursor: pointer;

    }
    .usertop >div:last-child{
        height: 25px;
        line-height: 25px;
        background-color: #eee;
        width: 100%;
        display: table;
    }
    .usertop >div:last-child li{
        display: table-cell;
        white-space: nowrap; text-overflow: ellipsis; overflow: hidden; word-break: break-all;
        text-align: center;
    }
    .usertop >div:last-child li:nth-child(1){
        width: 20px;
    }
    .usertop >div:last-child li:nth-child(2){
        width: 100px;
        text-align: left;
    }
    .usertop >div:last-child li:nth-child(3){
        width:60px;

    }

    .userlist{
       margin-top: 50px;
        line-height: 30px;


    }
   .userlist ul{
       width: 100%;
       display: table;
       table-layout: fixed;
       cursor: pointer
   ;
   }
    .userlist ul:hover{
        background-color: #efefef;
    }
    .userlist ul li{
        display: table-cell;
        white-space: nowrap; text-overflow: ellipsis; overflow: hidden; word-break: break-all;
        text-align: center;
        color: #666;
    }
    .userlist ul li:nth-child(1){
        width: 20px;
    }
    .userlist ul li:nth-child(2){
        width: 100px;
        text-align: left;
    }
    .userlist ul li:nth-child(3){
        width:60px;

    }
    .userlist ul li .markname{
        width: calc(100% - 8px);
        padding: 0px 3px;
        height: 22px;
        line-height: 22px;
        border: 1px #ddd solid;
        border-radius: 3px;
        font-size: 12px;
        display: none;
    }
    .tools{
        display: none;
        text-align: center;
    }
    .admintools:hover .tools{display: inline-block;width: 100%}
    .admintools:hover .join_time{display:none;}
</style>

<div class="usertop">
    <div>
     管理员数量：<?php echo $managenum; ?>
        <?php if($group['is_mark']==1 ||  $is_owner==1 || $is_manager==1){?>
        <a class="update" href="#user_<?php echo $_SESSION['userid']; ?>" onclick="update_markname(<?php echo $_SESSION['userid']; ?>);"><i class="icon-edit"></i>修改我的名片</a>
        <?php }?>


    </div>
    <div>
        <li></li>
<li>昵称</li>
<li>群名片</li>
        <li>加群时间</li>
    </div>

</div>

<div class="userlist" >

    <?php if(is_array($userlist)){foreach($userlist AS $index=>$value) { ?>

    <?php if($isin==1 || $value['type']=='owner' || $value['type']=='manager'){?>
    <ul id="user_<?php echo $value['id']; ?>"   <?php if($is_owner==1 || $is_manager==1){?>class='admintools'<?php }?>>
        <li>
            <?php if($value['type']=='owner'){?>
            <img src="/static/images/group1.png" style="height: 16px;vertical-align: middle;" title="群主"/>
            <?php } else if($value['type']=='manager') { ?><img src="/static/images/group2.png" style="height: 16px;vertical-align: middle;" title="管理员"/>
            <?php } else if($value['isvip']==1) { ?><img src="/static/images/isvip.png" style="height: 16px;vertical-align: middle;" title="计划员"/>
            <?php } else { ?>

            <?php }?>

        </li>
        <li onclick="parent.user_detail(<?php echo $value['id']; ?>,group_id)">
            <img src="<?php echo $value['avatar']; ?>" style="height: 20px;width: 20px;border-radius: 3px;vertical-align: middle"/>
            <?php echo $value['name']; ?>

        </li>
        <li>

          <span class="nickname"><?php if($value['name']!=$value['nickname']){?><?php echo $value['nickname']; ?><?php }?></span>
          <input type="text" class="markname" onblur="sub_markname('<?php echo $value['id']; ?>',this.value);" value="<?php if($value['name']!=$value['nickname']){?><?php echo $value['nickname']; ?><?php }?>">

        </li>
        <li>
            <span class="join_time">
                <?php if($value['type']=='owner'){?> <?php echo date('Y-m-d',$group['addtime']); ?>
            <?php } else if($value['jointime']>0) { ?><?php echo date('Y-m-d',$value['jointime']); ?>
            <?php } else { ?>
            -
            <?php }?>
            </span>

            <span class="tools" >

                   <?php if($value['id']==$_SESSION['userid']){?>
             <i class="icon-edit" title="修改名片" onclick="update_markname(<?php echo $value['id']; ?>);" ></i>
                <?php } else { ?>
                <?php if($is_owner==1){?>
                <!--{if $value['type']!='owner'}-->
               <i class="icon-edit" title="修改名片" onclick="update_markname(<?php echo $value['id']; ?>);" ></i>
                 <i class="icon-cancel" title="从本群中移除" onclick="delete_user(<?php echo $value['id']; ?>,'<?php echo $value['name']; ?>');"></i>
                <?php }?>
                <?php }?>


                <?php if($is_manager==1){?>
                <?php if($value['type']=='user'){?>
             <i class="icon-edit" title="修改名片" onclick="update_markname(<?php echo $value['id']; ?>);" ></i>
                <i class="icon-cancel"  title="从本群中移除" onclick="delete_user(<?php echo $value['id']; ?>,'<?php echo $value['name']; ?>');"></i>
                <?php }?>



                <?php }?>


            </span>
        </li>
    </ul>
    <?php }?>

    <?php }}?>
    <?php if($isin==0){?>
    <div class="nodata" onclick="apply_group(<?php echo $group['no_invite']; ?>);">

        查看更多群成员，请先加入该群
    </div>

    <?php }?>
</div>

<script>

    function update_markname(userid) {

//
//         var ul=  document.querySelector('.userlist').querySelectorAll('ul');
//        for(var i=0;i<=ul.length;i++){
//
//                ul[i].querySelector('.nickname').style.display='inline-block';
//                ul[i].querySelector('.markname').style.display='none';
//
//        }
        $("#user_"+userid+" .markname").show();
        //
        $("#user_"+userid+" .nickname").hide();
        setTimeout(function () {
            $("#user_"+userid+" .markname").focus();
        },200)

    }

    function  sub_markname(userid,value) {
        $("#user_"+userid+" .markname").hide();

        $("#user_"+userid+" .nickname").show();

        $("#user_"+userid+" .nickname").html(value);
        $.post("../api/group.php?act=setGroupNickname",{group_id:<?php echo $group['id']; ?>,content:value,userid:userid}, function(result){

            var res=JSON.parse(result);
            if(res.code=='200'){
               // layer.msg("修改成功",{ type: 1, anim: 2 ,time:1000});
                var data={type:'GroupUpdate',group_id:'<?php echo $group['id']; ?>'};
                parent.send_data(JSON.stringify(data));
            }else{

                layer.msg("网络错误",{ type: 1, anim: 2 ,time:1000});

            }

        });
    }

    function delete_user(uid,nickname) {
        parent.layer.open({
            type: 2,
            title: "选择踢出用户理由",
            shadeClose: false,shade: 0.6,
            area: ['300px','250px'],
            content: '/chat/logout.php?from=layer&userid='+uid+"&group_id="+<?php echo $group['id']; ?> //iframe的url
        });

//      var index=  layer.confirm('确定要踢出'+nickname, {
//            time: 20000, //20s后自动关闭
//            btn: ['确定', '取消']
//        },function () {
//            var data={type:'deleteGroup',userid:uid,group_id:<?php echo $group['id']; ?>,fromid:userid};
//            parent.send_data(JSON.stringify(data));
//            layer.close(index);
//
//        },function () {
//
//        });
    }


</script>