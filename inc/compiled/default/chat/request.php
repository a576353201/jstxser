
<?php include_once template("header");?>
<link rel="stylesheet" href="<?php echo $HttpTemplatePath; ?>static/css/group.css?v=<?php echo $cachekey; ?>" type="text/css" media="screen" />
<script src="/static/js/group.js?v=<?php echo $cachekey; ?>"></script>

<div class="nav">

    <span class="item active"onclick="click_tabs(0)">
        好友
    </span>
    <span class="item" onclick="click_tabs(1)">
        群组
    </span>
</div>
<div style="height: 45px;"></div>

<div class="content" style="width: 100%">

    <div  class="step">
        <?php if(count($friendlist)>0){?>

        <?php if(is_array($friendlist)){foreach($friendlist AS $index=>$m) { ?>
        <view class="lines">
            <view>
                <img src="<?php echo $m['user']['avatar']; ?>" class="avatar"  onclick='parent.user_detail(<?php echo $m['user']['id']; ?>,0)' />

            </view>
            <view>
                <div >
                    <span class='nickname' onclick='parent.user_detail(<?php echo $m['user']['id']; ?>,0)'><?php echo $m['user']['nickname']; ?></span>
              申请添加您为好友
                    <?php if($m['from']  && $m['from']!='layer'){?>
                   ,来源: <?php echo friend_addmethod($m['from']); ?>

                    <?php }?>


                    <span class="times"><?php echo date('Y-m-d H:i:s',$m['addtime']); ?></span>
                </div>

                <?php if(count($m['content1'])>0){?>
                <div class="mark">

                    <?php if(is_array($m['content1'])){foreach($m['content1'] AS $index1=>$m1) { ?>
                    <?php if($m1!=''){?>
                    <?php echo $m1; ?><br>
                    <?php }?>
                    <?php }}?>

                </div>
                <?php }?>
                <?php if($m['status']==0){?>
                <div id="frieind_status_<?php echo $m['id']; ?>" >

                    <button class="btns ok" onclick="deal_userapply(<?php echo $m['id']; ?>,1)">
                        <i class="icon-ok"></i>
                        同意</button>
                    <button class="btns clear" onclick="deal_userapply(<?php echo $m['id']; ?>,2)">
                        <i class="icon-cancel"></i>拒绝</button>


                </div>
                <?php } else { ?>
                <div  style="color:#666;font-size: 14px;">
                 <?php if($m['status']==1){?>已同意<?php } else { ?>已拒绝<?php }?>

                </div>
                <?php }?>
            </view>
        </view>
        <?php }}?>
        <?php } else { ?>
        <div style="height: 30px;line-height: 30px;text-align: center;color:#666;width: 100%;display: block">
            暂无好友验证消息

        </div>

        <?php }?>



    </div>


    <div class="step" style="display: none">

        <?php if(count($grouplist)>0){?>

        <?php if(is_array($grouplist)){foreach($grouplist AS $index=>$m) { ?>
        <view class="lines">
            <view>
                <img src="<?php echo $m['user']['avatar']; ?>" class="avatar"  onclick='parent.user_detail(<?php echo $m['user']['id']; ?>,0)' />

            </view>
            <view>
                <div >
                    <span class='nickname' onclick='parent.user_detail(<?php echo $m['user']['id']; ?>,0)'><?php echo $m['user']['nickname']; ?></span>
                    申请加入<span class='nickname' onclick='parent.group_detail(<?php echo $m['group']['id']; ?>);'><?php echo $m['group']['nickname']; ?></span>

                    <span class="times"><?php echo date('Y-m-d H:i:s',$m['addtime']); ?></span>
                </div>

                <?php if(count($m['content1'])>0){?>
                <div class="mark">

                    <?php if(is_array($m['content1'])){foreach($m['content1'] AS $index1=>$m1) { ?>
                    <?php if($m1!=''){?>
                    <?php echo $m1; ?><br>
                    <?php }?>
                    <?php }}?>

                </div>
                <?php }?>
                <?php if($m['status']==0){?>
                <div id="status_<?php echo $m['id']; ?>" >

                    <button class="btns ok" onclick="deal_apply(<?php echo $m['id']; ?>,1)">
                        <i class="icon-ok"></i>
                        同意</button>
                    <button class="btns clear" onclick="deal_apply(<?php echo $m['id']; ?>,2)">
                        <i class="icon-cancel"></i>拒绝</button>


                </div>
                <?php } else { ?>
                <div  style="color:#666;font-size: 14px;">
                    <?php if($m['apply_uid']!=$userid){?>其他管理员<?php }?><?php if($m['status']==1){?>已同意<?php } else { ?>已拒绝<?php }?>

                </div>
                <?php }?>
            </view>
        </view>
        <?php }}?>
        <?php } else { ?>
        <div style="height: 30px;line-height: 30px;text-align: center;color:#666;width: 100%;display: block">
            暂无群组验证消息

        </div>

        <?php }?>

    </div>



</div>
<div class="modalhtml" style="display: none">
    <div class="modal">
        <div class="title">确认拒绝申请？</div>
        <div class="content11">
            <input class="input" placeholder="请输入拒绝申请的理由" id="input" value="" />

            <div style="text-align: left;padding: 0px 0px;" >
               <input type="radio" id="rediocheck" >同时加入黑名单

            </div>
        </div>
        <div class="btns">
            <span onclick="$('.modalhtml').hide();">取消</span>
            <span  onclick="sub_applay();">确认</span>
        </div>
    </div>


</div>

<script>

var senddata={};
var sendtype='friend';
var applyid=0;
   function deal_userapply(applyid,status) {


       if(status==1){

           $.post("../api/user.php?act=handleFriendApply",{userid:<?php echo $userid; ?>,id:applyid,status:status}, function(result){

               result=JSON.parse(result);

               if(result.code==200) {
                   if (status == 1) {
                       $("#frieind_status_" + applyid).html("已同意")
                   }
                   else {
                       $("#frieind_status_" + applyid).html("已拒绝")

                   }
                   //location.reload();
               }
               else{
                   layer.msg(result.message,{ type: 1, anim: 2 ,time:1000});
               }
           });
   }else{
           senddata={userid:<?php echo $userid; ?>,id:applyid,status:status};
           sendtype='friend';

           $('.modalhtml').show();
           return false;
   }



    }

    function sub_applay() {
        var data=senddata;
        data['apply']={input:document.querySelector('#input').value,rediocheck:document.querySelector('#rediocheck').checked}
        if(sendtype=='group'){
            parent.send_data(JSON.stringify(data));
             document.querySelector('#status_'+data.applyid).innerHTML='已拒绝';
            group_update();
        }
        else{
            data['apply']=JSON.stringify(data['apply'])
            $.post("../api/user.php?act=handleFriendApply",data, function(result){

                result=JSON.parse(result);
               var applyid=data.id;
                if(result.code==200) {
                    if (status == 1) {
                        $("#frieind_status_" + applyid).html("已同意")
                    }
                    else {
                        $("#frieind_status_" + applyid).html("已拒绝")

                    }


                    //location.reload();
                }
                else{
                    layer.msg(result.message,{ type: 1, anim: 2 ,time:1000});
                }
            });

        }
        $('.modalhtml').hide();
    }
    function  deal_apply(applyid,status){


     if(status==1){

         senddata={type:'deal_group_apply',userid:<?php echo $userid; ?>,applyid:applyid,status:status};
         var data=senddata;

             parent.send_data(JSON.stringify(data));
             document.querySelector('#status_'+data.applyid).innerHTML='已同意';
             group_update();

    }else{
         senddata={type:'deal_group_apply',userid:<?php echo $userid; ?>,applyid:applyid,status:status};
         sendtype='group';


         $('.modalhtml').show();
         return false;

     }





    }
    function group_update() {
        location.reload();
    }

    function click_tabs(num) {
      var item=  document.querySelector('.nav').querySelectorAll('.item');
        var step=  document.querySelector('.content').querySelectorAll('.step');
      for(var i=0;i<item.length;i++){
          if(i==num) {
              item[i].className='item active';
              step[i].style.display="";
          }

          else{

              item[i].className='item';
              step[i].style.display="none";
          }

      }

    }
    click_tabs(<?php echo $act; ?>);

    parent.lastchat();
</script>


    <style>
        .nav{
            height: 25px;
            line-height: 25px;
            padding: 10px 0px;
            position: fixed;
            left: 0px;
            width: 100%;
            top:0px;
        }



        .nav .item{
            padding: 0px 15px;
            margin: 0px 10px;
            height: 25px;
            line-height: 25px;
            border-radius: 5px;
            border:1px solid #666;
            color:#666;
            display: inline-block;
            cursor: pointer;
        }
        .nav .item.active{
            border:1px solid #2319DC;
            background-color: #2319DC;
            color: #fff;
        }

        .content {
            display: inline-block;
            max-height:450px;
            overflow-y: scroll;
            background-color: #fafafa;
        }
        .content::-webkit-scrollbar{
            display: none;
        }
        .content11::-webkit-scrollbar{
            display: none;
        }

        .lines{
            margin: 0px auto;
            background-color: #fff;

            margin-top: 10px;
            padding: 5px 0px;
            width: 100%;
            display: table;
            table-layout: fixed;
        }
        .lines > view{
            display: table-cell;
        }
        .lines > view:first-child{
            width: 60px;
            text-align: right;
        }
        .lines > view:nth-child(2){

            text-align: left;
            padding-left: 10px;;
            line-height: 20px;
            vertical-align: top;
        }
        .lines .avatar{
            height: 50px;
            width: 50px;
            border-radius: 5px;
            vertical-align: middle;
        }
        .lines .nickname{
            color: #2319DC;
            display: inline-block;
            cursor: pointer;
        }
        .lines .btns{
            padding: 0px 10px;
            height: 25px;
            line-height: 25px;
            text-align: center;
            border-radius: 5px;
            font-size: 14px;
            display: inline-block;
            vertical-align: middle;
            cursor: pointer;
            margin-right: 20px;

        }
        .lines .btns.clear{
            border: 1px solid #666;
            color: #666;
            background-color: #fff;

        }
        .lines .btns.ok{
            background: -webkit-linear-gradient(left top, #3388ff , #2319dc);
            background: -o-linear-gradient(bottom right, #3388ff, #2319dc);
            background: -moz-linear-gradient(bottom right, #3388ff, #2319dc);
            background: linear-gradient(to bottom right, #3388ff , #2319dc);
            border:0px;
            color: #fff;
        }
        .lines .mark{
            color: #666;
            font-size: 12px;;
            height: auto;
            display: inline-block;
            line-height: 16px;;
        }
        .times{

            text-align: right;
            float: right;
            padding-right: 10px;
            color: #999;
            font-size: 12px;
        }
        .modalhtml{
            position: fixed;
            z-index: 999;
            top:0px;
            width: 100%;
            left: 0px;height:460px;
            background-color: rgba(0,0,0,0.3);
            font-size: 14px;;
        }
        .modalhtml .modal{
            background-color: #fff;
            border-radius: 10px;;
            top:100px;
            width: 50%;
            left: 25%;
            position: fixed;
            border: 1px #ddd solid;
        }
        .modalhtml .modal .title{
            text-align: center;
            height: 35px;
            line-height: 35px;
            color: #000;;
            font-size: 16px;;
            font-weight: 600;
            margin-top: 5px;;
        }

        .modalhtml .modal .content11{
            padding: 5px 10px;
            max-height: 160px;;

            line-height: 30px;;
            overflow-y: scroll;
            font-size: 14px;
        }
        .modalhtml .modal .content11 .input{
            height: 30px;
            line-height: 30px;
            display: inline-block;
            padding: 0px 5px;
            border: 1px #eee solid;
            border-radius: 5px;
            font-size: 14px;
            width: calc(100% - 12px);
        }
        .modalhtml .modal .btns{
            text-align: center;
            height: 35px;
            line-height: 35px;
            color: #000;;
            font-size: 16px;;
            font-weight: 600;
            border-top: #eee 1px solid;
        }
        .modalhtml .modal .btns >span{
            display: inline-block;
            width: calc(50% - 10px);
            height: 35px;
            line-height: 35px;
        }
        .modalhtml .modal .btns >span:last-child{
            border-left: #eee 1px solid;
            color:#2319DC
        }
    </style>
</block>
</block>



