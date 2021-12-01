

<?php include_once template("header");?>
<link rel="stylesheet" href="<?php echo $HttpTemplatePath; ?>static/css/group.css?v=<?php echo $cachekey; ?>" type="text/css" media="screen" />
<script src="/static/js/group.js?v=<?php echo $cachekey; ?>"></script>
<style>
    .nodata{
        height: 35px;
        line-height: 35px;
        color: #666;
        font-size: 12px;
        text-align: center;
    }
    .pinyin{
        font-size: 14px;
        height: 25px;
        line-height: 25px;
        width: calc(100% - 20px);
        background-color:#eee;
        padding:0px  10px;

    }
    .istop{
        background-color: #fdfdfd;
    }
    .pinyin_right{
        position: fixed;
        right: 7px;
        top:96px;
        height: auto;
        width: 18px;
        line-height: 20px;
        text-align: center;
        font-size: 12px;
        color: #333;
        min-height: 400px;
    }
    .pinyin_right a{
        height:15px;
        line-height: 15px;
        text-align: center;
        cursor: pointer;
        display: block;
        width: 100%;
        color: #333;   font-size: 12px;
    }
    .pinyin_right a:hover{
        background-color: #3388ff;
        border-radius: 50%;
        color: #fff;
    }
    .friends{
        padding: 5px 0px;

        height: 35px;
        line-height: 35px;
        display: table;
        table-layout: fixed;
        width: calc(100% - 0px);
        cursor: pointer;

    }
    .friends:hover{
        background-color: #ccc;
    }
    .friends .avatar{
        display: table-cell;
        width: 60px;
        text-align: center;
    }
    .friends .avatar  img{
        height: 35px;
        width: 35px;
        border-radius: 5px;;
        vertical-align: middle;
    }
    .friends .showname {
        text-align:left;
        display: table-cell;
        font-size: 16px;

        color: #333;
        line-height: 35px;;
        vertical-align: middle;
        margin: 0px 0px;
        padding: 0px 0px;
        border-bottom: 1px #EFEFEF solid;
    }
   .addbtn{
       margin: 5px  auto;
       display: block;
       width: 120px;
       height:30px;
       line-height: 30px;
       background-color: #fff;
       border:1px solid #ddd;
       text-align: center;
       border-radius: 5px;
       cursor: pointer;
   }
</style>
<div class="grouptop">

    <span class="title">
       联系人
    </span>
    <i class="icon-search" onclick="show_search();"></i>
</div>

<div class="seacrchtop">
    <li onclick="show_search();"><i class="icon-left-open"></i> </li>
    <li><input class="input1" id="keyword" value="" placeholder="搜索联系人"> </li>

    <li>
        <div class="btn" onclick="go_search();"><i class="icon-search"></i>搜索</div>
    </li>

</div>

<ul id="grouplist" class="grouplist">
    <div class="friends"  onclick='location.href="mygroup.php?type=0";'>

        <view class="avatar" >
            <img src="/static/images/group_add.png" style="height: 40px;width:40px ;"></img>
        </view>
        <view class="showname" style="padding-left: 10px;" >
            我创建的群组
        </view>
    </div>

    <div class="friends" style="margin-top: 5px;"  onclick='location.href="mygroup.php?type=1";'>

        <view class="avatar" >
            <img src="/static/images/mygroup.png" style="height: 40px;width:40px ;"></img>
        </view>
        <view class="showname" style="padding-left: 10px;" >
            我加入的群组
        </view>
    </div>

    <div class="addbtn" onclick="parent.group_create();"><i class="icon-user-add"></i>新建群组</div>
<?php if(count($list)>0){?>
    <?php
   $py='';
    ?>
    <?php if(is_array($list)){foreach($list AS $index=>$item) { ?>
    <?php if($item['iskefu']>0){?>
    <?php
  if($py!='官方'){
   $py='官方';
 ?>

    <div class="pinyin" id="char_<?php echo $py;?>"><?php echo $py;?></div>

    <?php } ?>
    <div class="friends" onclick="parent.open_chatarea(<?php echo $item['id']; ?>,'<?php echo $item['nickname']; ?>','<?php echo $item['avatar']; ?>',0);">

        <div class="avatar">
            <img src="<?php echo $item['avatar']; ?>" />
        </div>
        <div class="showname">
            <?php echo $item['nickname']; ?>

            <?php if($item['iskefu']==1){?><span class="btn_green">客服</span><?php }?>

            <?php if($item['iskefu']==2){?><span class="btn_yellow">官方</span><?php }?>
            <?php if($item['iskefu']==3){?><span class="btn_green">上级</span><?php }?>
        </div>
    </div>

      <?php }?>
    <?php }}?>

    <?php if(is_array($list)){foreach($list AS $index=>$item) { ?>
    <?php if($item['iskefu']==0){?>
    <?php
  if($py!=substr($item['pinyin'],0,1)){
   $py=substr($item['pinyin'],0,1);
 ?>

    <div class="pinyin" id="char_<?php echo $py;?>"><?php echo $py;?></div>

    <?php } ?>
    <div class="friends" onclick="parent.open_chatarea(<?php echo $item['id']; ?>,'<?php echo $item['nickname']; ?>','<?php echo $item['avatar']; ?>',0);">

        <div class="avatar">
           <img src="<?php echo $item['avatar']; ?>" />
        </div>
        <div class="showname">
               <?php echo $item['nickname']; ?>

            <?php if($item['iskefu']==1){?><span class="btn_green">客服</span><?php }?>

            <?php if($item['iskefu']==2){?><span class="btn_yellow">官方</span><?php }?>
        </div>
    </div>

    <?php }?>
    <?php }}?>
    <div class="nodata">共有 <?php echo count($list); ?> 位好友  </div>

    <div class="pinyin_right">
       <?php if(is_array($pinyin)){foreach($pinyin AS $index=>$value) { ?>
            <a href="#char_<?php echo $value;?>" ><?php echo $value; ?></a>
        <?php }}?>
    </div>
    <?php } else { ?>

    <div class="nodata">暂无好友</div>
    <?php }?>

</ul>
<ul id="searchlist" class="grouplist" style="display: none">


</ul>
<div class="loading">

    <img src="/static/images/loading.gif" ><span>加载中</span>
</div>


<script>
    var act='top';
    var page=1;
    function  chat(id) {
        location.href='chat.php?id='+id;
    }
    var loading=null;





    function  change_menu(num) {
        if(num==0) act='top';else act='new';
        var li=   document.querySelector('.menu').querySelectorAll('li');
        for(var i=0;i<li.length;i++){
            if(i==num) li[i].className='active';
            else li[i].className='';
        }




    }
    function show_search() {
        if(document.querySelector('.seacrchtop').style.display=='table'){
            document.querySelector('.seacrchtop').style.display='none';
            document.querySelector('#grouplist').style.display='';
            document.querySelector('#searchlist').style.display='none';
        }else{
            document.querySelector('.seacrchtop').style.display='table';
            $('#grouplist').hide();
            document.querySelector('#searchlist').style.display='';
        }

    }



    function go_search() {
        if($('#keyword').val()==''){
            layer.msg("关键字不能为空",{ type: 1, anim: 2 ,time:2000});
            return false;
        }
        var keyword=$('#keyword').val();
        $.get("../api/user.php?act=searchUser",{keywords:keyword}, function(result){
            layer.close(loading);
            var res=JSON.parse(result);
            if(res.code=='200'){
                var html="";

                if(res.data.length>0){
               var item=res.data[0];
              parent.user_detail1(item.id,item.from)

                }
                else{
                    $('#searchlist').html("<div class='nodata'>没有找到相关的用户</div>");
                }


            }else{
                layer.msg("网络连接失败",{ type: 1, anim: 2 ,time:1000});
            }

        });


    }

</script>



<?php include_once template("footer");?>