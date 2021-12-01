

<?php include_once template("header");?>
<link rel="stylesheet" href="<?php echo $HttpTemplatePath; ?>static/css/group.css" type="text/css" media="screen" />
<script src="/static/js/group.js"></script>
<div class="group_nav" style="display: none">
    <div class="search_line">

        <div class="search">
            <input type="text" class="input" name="keyword" value="" placeholder="请输入要搜索的聊天室"><button class="button"><i class="icon-search"></i>搜索</button>

        </div>

    </div>


</div>
<div class="grouptop">
    <span class="back" onclick="history.back();"><i class="icon-left-open-3"></i></span>
    <ul class="menu">
        <li class="active" onclick="change_menu(0);">我创建的群</li>
        <li  onclick="change_menu(1);">我加入的群</li>
    </ul>
    <i class="icon-plus-1" style="margin-right: 8px;font-size: 28px;" onclick="show_addnav1();"></i>
</div>
<div class="addnav"  id="addnav_1" style="top:47px;">
    <?php if($user['isvip']==1){?>
    <li  onclick="plan_add();"><i class="icon-plus-circle"></i>发布计划</li>
    <?php } else { ?>
    <li class="button" onclick="plan_apply();">  <i class="icon-chart"></i>申请计划员</li>
    <?php }?>
    <li onclick="group_create();"><i class="icon-user-add"></i>创建群聊</li>
    <li onclick="location.href='/user/recharge.php';"><i class="icon-coin-of-dollar"></i>我要充值</li>
    <li onclick="location.href='/user/plat.php';"><i class="icon-cash"></i>我要提现</li>
</div>

<ul id="grouplist" class="grouplist">


</ul>

<div class="loading">

    <img src="/static/images/loading.gif" ><span>加载中</span>
</div>


<script>
    var act='top';
    var page=1;
    var menuid=4;
    function  chat(id) {
        location.href='chat.php?id='+id;
    }
    var loading=null;
    function get_list(act,page) {

        $.post("../api/group.php?act=mygroup",{act:act}, function(result){
            layer.close(loading);
            var res=JSON.parse(result);
            if(res.code=='200'){
                var html="";
            console.log(res);
                if(res.data.length>0){

                    for(var i=0;i<res.data.length;i++){
                        var value=res.data[i];
                        if(value.isin==1){
                            var click="parent.open_chatarea("+value.id+",'"+value.name+"','"+value.avatar+"');";
                        }else{
                            var click="parent.group_detail("+value.id+");";
                        }

                        html+="<li onclick=\""+click+"\">";
                        html+="<div class='avatar'><img src='"+value['avatar']+"'  onerror=\"this.src='../uploads/group.jpg'\" /></div>";
                        html+="<div class=\"info\">\n" +
                            "                <div class=\"title\">"+value.name+"</div>\n" +
                            "                <div ><i class=\"icon-users-1\"></i>"+value['people_count']+"/"+value['people_max']+"人</div>\n" +
                            "                <div class=\"tag\">"+value['tags']+"</div>\n" +
                            "            </div>";
                        html+="</li>";
                    }
                    //console.log(res);

                        $('#grouplist').html(html);



                }
                else{
                    if(act=='join') var nodata="<div class='nodata'>没有加入任何群</div>";
                    else  var nodata="<div class='nodata'>没有创建任何群</div>";

                    $('#grouplist').html(nodata);
                }


            }else{
                layer.msg("网络连接失败",{ type: 1, anim: 2 ,time:1000});
            }

        });
    }


    function get_data(act1) {
        act=act1;
        page=1;
        loading=layer.load(1, {
            shade: [0.1,'#fff']
        });
        get_list(act,page);
    }

    function  change_menu(num) {
        if(num==0) act='owner';else act='join';
        var li=   document.querySelector('.menu').querySelectorAll('li');
        for(var i=0;i<li.length;i++){
            if(i==num) li[i].className='active';
            else li[i].className='';
        }

        get_data(act);


    }

    change_menu('<?php echo $type; ?>');

</script>



<?php include_once template("footer");?>