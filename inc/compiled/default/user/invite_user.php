
<div class="page">
    <div class="search">
        <i class='icon-search' style='position: absolute;left: 28px;top:16px;font-size: 22px;font-weight: 600;color:#000;'></i>
        <input type="text" class="input" placeholder="请输入团队成员账号" id="username" value="<?php echo $_GET['username']; ?>" maxlength="15" />
        <button onclick='click_search()'>搜索</button>
    </div>
    <?php if(count($parent)>0  && $userid!=$_SESSION['userid']){?>
    <div class="parent" >
        <?php if(is_array($parent)){foreach($parent AS $index=>$m) { ?>
        <?php if($index > 0){?>
        <span > &gt; </span>
        <?php }?>
        <span style='color:#2319DC;cursor: pointer' onclick='user_next(<?php echo $m['id']; ?>)'><?php echo $m['name']; ?></span>

        <?php }}?>
    </div>
    <?php }?>
    <?php if(count($user_list)>0){?>
    <?php if(is_array($user_list)){foreach($user_list AS $index=>$m) { ?>

    <div class="lists" >

        <div>
            <div onclick="open_detail(<?php echo $m['id']; ?>)">
                <img src="<?php echo $m['avatar']; ?>">

            </div>
            <div>
                <div class="title">
                    <span class="online <?php if($m['isonline']==1){?>active<?php }?>"></span>
                    <span style="color: #2319DC"  onclick="open_detail(<?php echo $m['id']; ?>)"> <?php echo $m['name']; ?></span>

                    <?php if($m['id']==$_SESSION['userid']){?>
                    <span class="btn_grey">自己</span>
                    <?php }?>
                    <?php if($m['isdaili']==1){?>
                    <span class="btn_green">代理</span>
                    <?php } else { ?>
                    <span class="btn_yellow">玩家</span>
                    <?php }?>


                    <img src="/static/images/vip<?php if($m['vip']>0){?>1<?php } else { ?>0<?php }?>.png" style="height: 20px;vertical-align: middle;cursor: pointer"
                    <?php if($user['vip']==3 && $user['id']==$m['pid'] && ($m['vip']==0 || $m['vip']==2)){?> title="<?php if($m['vip']>0){?>取消<?php } else { ?>设为<?php }?>VIP"  onclick="setvip(<?php echo $m['id']; ?>,'<?php echo $m['name']; ?>',<?php echo $m['vip']; ?>);" <?php }?>>



                    <span style="float: right;text-align: right;  font-size: 14px;">


 团队人数：  <span style="color: #2319DC"> <?php echo $m['team_num']; ?></span>

                </span>

                </div>
                <div class="info">


                        注册时间：  <span > <?php echo date('Y-m-d H:i',$m['regtime']); ?></span>



                    </span>


                </div>
            </div>

        </div>

        <div class="btns">
                   <span id="set_<?php echo $m['id']; ?>" style="display: none;">
                        <select id="rebate_<?php echo $m['id']; ?>">
   <?php for($i=$max_rebate;$i>=$m['rebate'];$i=$i-0.5){?>
              <option value="<?php echo $i?>" <?php if($i==$m['rebate']) echo "selected";?>><?php echo number_format($i,1)?>%</option>
                            <?php }?>
                        </select>
                        <span class="submit"  onclick="sub_rebate(<?php echo $m['id']; ?>)">确认</span>
                          <span class="submit grey"  onclick="hide_rebate(<?php echo $m['id']; ?>)" >取消</span>
                    </span>

            <span id="btn_<?php echo $m['id']; ?>" >
                <div class="cell">
                    <span class="btn11"   onclick="open_detail(<?php echo $m['id']; ?>)"><i class="icons icon-menu"></i>详情</span>

                </div>


                <div class="cell">
                        <span class="btn11" onclick="user_next(<?php echo $m['id']; ?>)"><i class="icons icon-users"></i>下级</span>

                </div>

                <?php if($user['vip']==3 && $userid==$_SESSION['userid']){?>

                      <div class="cell">
                        <span class="btn11"  <?php if($user['vip']==3 && $user['id']==$m['pid'] && ($m['vip']==0 || $m['vip']==2)){?> title="<?php if($m['vip']>0){?>取消<?php } else { ?>设为<?php }?>VIP"  onclick="setvip(<?php echo $m['id']; ?>,'<?php echo $m['name']; ?>',<?php echo $m['vip']; ?>);" <?php }?>>
                          <?php if($m['vip']>0){?> <i class="icons icon-minus"></i>取消<?php } else { ?> <i class="icons icon-plus"></i>设为<?php }?>VIP
                        </span>

                </div>

                <?php }?>
           </span>


        </div>



    </div>
    <?php }}?>
    <div class="pages"  id="pageshow" style="margin-top: 15px;">




    </div>
    <?php } else { ?>

    <div class="nodata">
        暂时还没有直属下级
    </div>

    <?php }?>

</div>

<script>
    var page=<?php echo $page; ?>;

    function  setpage(sum) {
        pagesum=sum;
        var html=" <li onclick='next_page(-1)'>«</li>";
        if(page>4){
            var from=page-2;
            var to=page+2;
        }
        else {var from=1;
            var to=6;
        }
        if(to>sum)  to=sum;
        if(from>2){
            html+='<li onclick="getpage(1);">1</li><li class="">...</li>';
        }
        for(var i=from;i<=to;i++){
            if(i==page) var active='active';
            else var active="";
            html+="<li  onclick=\"getpage("+i+");\" class=\""+active+" \">"+i+"</li>";
        }
        if(to<sum-1)   html+='<li  onclick="getpage('+sum+');" class="">...</li><li class="">'+sum+'</li>';

        html+=" <li onclick='next_page(1)'>»</li>"
        if(sum>0)  $('#pageshow').html(html);
        else $('#pageshow').hide();

    }
    setpage(<?php echo $pagesum; ?>);
    function getpage(num) {
        location.href="?userid=<?php echo $userid; ?>&page="+num;
    }
    function  next_page(num) {
        var  page1=page+num;
        if(page1>0 && page1<=<?php echo $pagesum; ?>){
            getpage(page1)
        }

    }

    function  setvip(id,name,vip){

        if(vip!=0 && vip!=2){
            layer.msg("您无法设置该用户的VIP",{ type: 1, anim: 2 ,time:1000});

            return  false;
    }

        if(vip==0){
            var content="确认将"+name+"设置为VIP?<br>当前还可以设置<span style='color: #2319DC'><?php echo $vipnum; ?></span>个用户 "
        }
        else{
            var content="确认将"+name+"的VIP权限取消?"
        }
        layer.confirm(content, {
            btn: ['确认','取消'] //按钮
        }, function(){
            subsetvip(id);
        }, function(){

        });
    }

    function  subsetvip(id) {

   // console.log({userid:id,fromid:<?php echo $_SESSION['userid']; ?>});
        $.post("../api/user.php?act=set_vip",{userid:id,fromid:<?php echo $_SESSION['userid']; ?>}, function(result){
             console.log(result);
            var res=JSON.parse(result);
            if(res.code=='200'){
                location.reload();
            }else{

                layer.msg(res.message,{ type: 1, anim: 2 ,time:1000});
            }

        });
    }

    function open_detail(id) {
        var index= parent.layer.open({
            type: 2,
            title: false,
            shadeClose: true,
            shade: 0.6,
            area: ['300px','340px'],
            content: "/user/invite_user1.php?id="+id//iframe的url
        });
    }

    function  click_search(){
        var username = $('#username').val();

        if(username==''){
            layer.msg("请输入用户账号",{ type: 1, anim: 2 ,time:1000});

            return  false;
        }
        $.post("../api/user.php?act=search_invite",{username:username,fromid:<?php echo $_SESSION['userid']; ?>,page:page}, function(result){

            var res=JSON.parse(result);
            if(res.code=='200'){
                location.href="?act=search&username="+username


            }else{

                layer.msg(res.message,{ type: 1, anim: 2 ,time:1000});
            }

        });

    }
    function set_rebate(id,rebate) {

        <?php if(count($parent)>0  && $userid!=$_SESSION['userid']){?>
        layer.msg("无法设置下下级的返点",{ type: 1, anim: 2 ,time:1000});
        return false;

        <?php }?>



        if(parseFloat(rebate)>=<?php echo $max_rebate; ?>){
            layer.msg("当前返点已升到最高，无需提升",{ type: 1, anim: 2 ,time:1000});
            return false;

        }
        else{
            $('#set_'+id).show();
            $('#btn_'+id).hide();

        }


    }
    function hide_rebate(id) {

        $('#set_'+id).hide();
        $('#btn_'+id).show();

    }

    function sub_rebate(id) {
        $.post("../api/user.php?act=set_rebate",{userid:id,rebate:document.querySelector('#rebate_'+id).value}, function(result){

            var res=JSON.parse(result);
            if(res.code=='200'){
                location.reload();


            }else{

                layer.msg(res.message,{ type: 1, anim: 2 ,time:1000});
            }

        });

    }

    function user_next(id) {
        location.href="/user/invite.php?userid="+id;

    }
</script>


<style>
    .page{
        background-color: #fafafa;

        height: 400px;
        overflow-y: scroll;
    }
    .page::-webkit-scrollbar{
        display: none;
    }
    .pages{
        margin: 10px auto;
        text-align: center;
    }
    .search{
        height: 50px;
        line-height: 50px;
        padding-left: 22px;
        text-align: left;
        font-size: 14px;
        background-color: #fff;
        position: relative;
    }
    .search .input{
        height: 30px;line-height:30px;

        border-radius: 16px;
        border: 1px solid #ddd;
        display: inline-block;

        padding: 0px 5px;  font-size: 14px;
        color:#666;
        width: calc(100% - 140px);
        vertical-align: middle;
        padding-left: 35px;

    }
    .search > button{
        display: inline-block;
        width: 70px;
        height: 30px;line-height:30px;
        background-color: #FF4400;
        border-radius: 5px;
        color: #fff;
        font-size: 14px;
        vertical-align: middle;
        margin-left: 5px;
        border: 0px;


    }
    .pages>li{display:inline-block;  width: 43px; height: 33px; line-height: 33px;
        background-color: #ffffff; text-align: center; border-left: 1px #f2f2f2 solid;
        border-top: 1px #f2f2f2 solid; border-bottom: 1px #f2f2f2 solid;vertical-align: middle;cursor: pointer}
    .pages>li:last-child{border-right: 1px #f2f2f2 solid;}
    .pages>li a{display: block; text-decoration: none; color: #777;}
    .pages>li a:hover{background-color: #f7f7f7; text-decoration: none;}
    .pages .disabled{}
    .pages .active{background-color: #2319dc; color: #FFFFFF; font-weight: 800; border-top: #2319dc 1px solid; border-bottom: #009688 1px solid;}

    .parent{
        height: 40px;
        line-height: 40px;
        text-align: left;
        padding-left:20px;
        display: block;
        background-color: #fff;
    }
    .nodata{
        height: 40px;
        line-height: 40px;
        text-align: center;
        color: #666;
    }
    select {
        height: 30px;
        border: solid #ccc 1px;
        line-height: 30px;
        width: 100px;
        border-radius: 5px;
    }
    .lists{
        background-color: #fff;
        margin-top: 10px;
        padding: 5px 10px;
        line-height: 30px;
        clear: both;
        display:  inline-block;
        width: calc(100% - 20px);
        height: 100px;
    }
    .lists > div {
        display:  inline-block;
        width: 100%;
        clear: both;
    }
    .lists > div > div{
        display: inline-block;
        padding-top: 0px;margin-top: 0px;
        vertical-align: top;
    }

    .lists > div > div:first-child{
        text-align: center;
        width:70px;
    }
    .lists > div > div:first-child img{
        height:50px;
        width: 50px;
        vertical-align: middle;
        border-radius: 5px;
        margin-top: 5px;
    }
    .lists > div > div:last-child{
        text-align: left;
        width: calc(100% - 80px);

    }
    .lists > div > div:last-child .title{
        font-size: 16px;;

    }
    .lists > div > div:last-child .info{
        font-size: 14px;
        color: #666;
    }
    .btns{
        background-color: #fff;
        display: inline-block;
        clear: both;
        width: 100%;
        border-top: 1px #eee solid;
        margin-top: 3px;
        padding-top: 3px;

    }
    .btns  .cell{
        display: inline-block;
        width: 49%;
        text-align: center;
    }
    .btn_yellow{
        background-color: yellow;
        color: #000;
        font-size: 12px;
        display: inline-block;
        height:18px;
        line-height: 18px;
        padding: 0px 5px;
        border-radius: 5px;
        text-align: center;
    }
    .online{
        height: 5px;
        line-height: 5px;
        width: 5px;vertical-align: middle;
        margin-right: 2px;
        border-radius: 50%;
        background-color: #CCCCCC;
        display: inline-block;
    }
    .online.active{
        background-color: #00B26A;
    }

    .btn_green{
        background-color: #0aad6c;
        color: #fff;font-size: 12px;
        display: inline-block;
        height: 18px;
        line-height: 18px;
        padding: 0px 5px;
        border-radius: 5px;
        text-align: center;
    }
    .btn_blue{
        background-color: #2319dc;
        color: #fff;font-size: 12px;
        display: inline-block;
        height: 18px;
        line-height: 18px;
        padding: 0px 5px;
        border-radius: 5px;
        text-align: center;
    }

    .btn_grey{
        background-color: #ddd;
        color: #000;font-size: 12px;
        display: inline-block;
        height: 12px;
        line-height: 12px;
        padding: 2px 5px;
        border-radius: 5px;
        text-align: center;

    }
    .btn11{
        display: inline-block;
        height: 25px;
        line-height: 25px;vertical-align: middle;font-size: 14px;

        background-color: #f8f8f8;
        border: 1px #e7e7e7 solid;
        border-radius: 5px;
        width: 82%;
        cursor: pointer;
    }

    .submit{
        display: inline-block;
        height: 25px;
        line-height: 25px;vertical-align: middle;font-size: 14px;
        background-color: #2319DC;
        border: 1px #2319DC solid;
        color:#fff;
        margin: 0px 3px;
        border-radius: 5px;
        width: 80px;
        cursor: pointer;
    }
    .submit.grey{
        background-color: #f8f8f8;
        border: 1px #e7e7e7 solid;
        color: #000;
    }
</style>