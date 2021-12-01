<style>

    .userlist{
       margin-top: 10px;


    }
   .userlist ul{
       width: 100%;
       display: table;
       table-layout: fixed;
       cursor: pointer;
       height: 50px;line-height: 50px;
       padding: 5px 0px;
       background-color: #fff;
       margin-bottom: 10px;
   }

    .userlist ul li{
        display: table-cell;
        white-space: nowrap; text-overflow: ellipsis; overflow: hidden; word-break: break-all;
        text-align: center;
        color: #666;

    }
    .userlist ul li:nth-child(1){
        width: 60px;
        text-align: right;
        padding-right: 5px;
    }
    .userlist ul li:nth-child(1) img{
        height: 50px;
        width: 50px;
        vertical-align: middle;
        border-radius: 5px;
    }
    .userlist ul li:nth-child(2){
       calc(100% - 140px);
        text-align: left;
    }
    .userlist ul li:nth-child(3){
        width:80px;
        text-align: right;
        padding-right: 10px;

    }
    .userlist ul li .markname{
        width: 60px;
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

 .btn{
        display: inline-block;
        height: 25px;
        line-height: 25px;
        padding: 0px 8px;
        color: #fff;
        background-color: #2319dc;
        border-radius: 5px;
        vertical-align: middle;
        font-size: 12px;

    }
    .admintools:hover .tools{display: inline-block;width: 100%}
    .admintools:hover .join_time{display:none;}
</style>

<div class="userlist" >

    <?php if(is_array($userlist)){foreach($userlist AS $index=>$value) { ?>

    <?php if($isin==1 || $value['type']=='owner' || $value['type']=='manager'){?>
    <ul id="user_<?php echo $value['id']; ?>"   <?php if($is_owner==1 || $is_manager==1){?>class='admintools'<?php }?>>

        <li onclick="parent.user_detail(<?php echo $value['id']; ?>,group_id)">
            <img src="<?php echo $value['avatar']; ?>" id="avatar_<?php echo $value['id']; ?>"  />


        </li>
        <li>
            <?php if($value['type']=='owner'){?>
            <span class="btn_yellow">群主</span>
            <?php }?>
            <?php if($value['type']=='manager'){?><span class="btn_green">管理员</span><?php }?>
            <?php if($value['isvip']==1){?><span class="btn_blue">计划员</span><?php }?>
            <?php if($value['is_deny']==1){?><span class="btn_grey">禁言</span><?php }?>
          <span class="nickname" id="nickname_<?php echo $value['id']; ?>"><?php if($value['name']!=$value['nickname']){?><?php echo $value['nickname']; ?><?php } else { ?><?php echo $value['name']; ?><?php }?></span>
          <input type="text" class="markname" onblur="sub_markname('<?php echo $value['id']; ?>',this.value);" value="<?php if($value['name']!=$value['nickname']){?><?php echo $value['nickname']; ?><?php }?>">

        </li>
        <li>



                   <?php if($value['id']==$_SESSION['userid'] &&( $group['is_mark']==1 ||  $is_owner==1 || $is_manager==1)){?>

            <div class="btn" onclick="update_markname(<?php echo $value['id']; ?>);" >修改名片</div>

                <?php } else { ?>
                <?php if($is_owner==1){?>
                <?php if($value['type']!='owner'){?>
            <div class="btn" onclick="show_usermenu('<?php echo $value['id']; ?>','<?php echo $value['type']; ?>','<?php echo $value['is_deny']; ?>');">操作</div>
                <?php }?>


                <?php if($is_manager==1){?>
                <!--{if $value['type']=='user'}-->
            <div class="btn"  onclick="show_usermenu('<?php echo $value['id']; ?>','<?php echo $value['type']; ?>','<?php echo $value['is_deny']; ?>');">操作</div>
                <?php }?>

                <?php } else { ?>

                <?php }?>

                <?php }?>


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


var layer_tips=null;
    function show_usermenu(id,type,is_deny) {
        layer.close(layer_tips)
        var html="<div class='usermenu'>"

        html+="<div onclick='parent.user_detail("+id+","+group_id+")'>查看资料</div>";
        if((is_owner==1 || is_manager==1) && type!='owner'){
            if(is_owner==1){
                if(type=='manager'){
                    html+="<div onclick='set_manager("+id+",0)'>取消管理</div>";
                }
                if(type=='user'){
                    html+="<div onclick='set_manager("+id+",1)'>设为管理</div>";
                }
            }

            if(type=='user'){
                if(is_deny==1)
                    html+="<div onclick='set_userdeny("+id+",0)'>解除禁言</div>";

                if(is_deny==0)
                    html+="<div onclick='set_userdeny("+id+",1)'>禁言</div>";
            }

            if(is_owner==1 && type!='owner'){
                html+="<div onclick='delete_user("+id+")'>踢人</div>";
                html+="<div onclick='update_markname("+id+")'>修改名片</div>";
            }
            if(is_manager==1 && type=='user'){
                html+="<div onclick='delete_user("+id+")'>踢人</div>";
                html+="<div onclick='update_markname("+id+")'>修改名片</div>";
            }

        }else{

            return parent.user_detail(id,group_id);
        }


        html+="</div>";
        layer_tips= layer.tips(html, '#nickname_'+id, {tips:[3,'rgba(0,0,0,0.7)']
        });
    }



function set_manager(id,type) {
    layer.close(layer_tips)
    var data={type:'groupset1',mode:'manage',settype:type,group_id:group_id,userid:id,from_uid:userid};
    parent.send_data(JSON.stringify(data));
    layer.close(layer_tips);

    location.href='detail.php?id='+group_id+"&step=1";
}

function  set_userdeny(id,type) {
    layer.close(layer_tips)
    var data={type:'groupset1',mode:'deny',settype:type,group_id:group_id,userid:id,from_uid:userid};
    parent.send_data(JSON.stringify(data));
    layer.close(layer_tips);
    location.href='detail.php?id='+group_id+"&step=1";
}
    function update_markname(userid) {

        $("#user_"+userid+" .markname").show();
        //
        $("#user_"+userid+" .nickname").hide();
        setTimeout(function () {
            $("#user_"+userid+" .markname").focus();
        },200)

        layer.close(layer_tips)

    }

    function  sub_markname(userid,value) {
        $("#user_"+userid+" .markname").hide();

        $("#user_"+userid+" .nickname").show();
        if(value.length>0)
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

    function delete_user(uid) {
      var index=  layer.confirm('确定要踢出该群？', {
            time: 20000, //20s后自动关闭
            btn: ['确定', '取消']
        },function () {
            var data={type:'deleteGroup',userid:uid,group_id:<?php echo $group['id']; ?>,fromid:userid};
            parent.send_data(JSON.stringify(data));
            layer.close(index);
          location.href='detail.php?id='+group_id+"&step=1";
        },function () {

        });
    }


</script>