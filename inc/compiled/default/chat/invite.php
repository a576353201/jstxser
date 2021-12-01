

<?php include_once template("header");?>
<link rel="stylesheet" href="<?php echo $HttpTemplatePath; ?>static/css/group.css?v=<?php echo $cachekey; ?>" type="text/css" media="screen" />
<script src="/static/js/group.js?v=<?php echo $cachekey; ?>"></script>





<div class="info">

    <div class="left">

        <div class="nav">
            <i class="icon-search" style="vertical-align: middle;font-size: 16px;position: absolute;left:18px;top: 8px;"></i>
            <input name="remark" id="remark" value="" class="input" placeholder="输入用户昵称" style="width: 130px;height:30px;line-height: 30px; padding: 0px 10px;padding-left: 25px;
    font-size: 14px;
    background-color: transparent;
    color: #222;
    border: 1px solid #ccc;
    border-radius: 5px;" maxlength="10" oninput="input(this.value)" >
        </div>
     <div style="margin-top:45px" id="userlist">

         <?php if(is_array($list)){foreach($list AS $index=>$value) { ?>
         <div class="userlist" id="user_<?php echo $value['id']; ?>"  onclick="click_user(<?php echo $value['id']; ?>)">
             <div class="avatar">
                 <img src="<?php echo $value['avatar']; ?>" />
             </div>
             <div class="nickname">
                 <?php echo $value['nickname']; ?>

                 <span class="icon">
                     <i class="icon-plus" style="color: #00aa00"></i>
                 </span>
             </div>
         </div>

         <?php }}?>

     </div>

        <div class="nodata" <?php if(count($list)>0){?>style='display:none;'<?php }?>>
            没有符合条件的用户
        </div>


    </div>

    <div class="right">
        <div class="nav" style="left:240px;">
        已选择<span id="selectnum">0</span>人
        </div>
       <div id="user_select" style="margin-top:45px">


       </div>
    </div>

</div>
<div class="layer_btns cancel" onclick=" var index = parent.layer.getFrameIndex(window.name); parent.layer.close(index);"><i class="icon-cancel"></i>关闭</div>
<div class="layer_btns ok" onclick="save_info();"><i class="icon-ok"></i>确认</div>


<script>
    var userid=parseInt('<?php echo $_SESSION['userid']; ?>');

    var userselected=[];

    function save_info() {
        if(userselected.length<1){
            layer.msg('请先选择用户',{ type: 1, anim: 2 ,time:1000});
            return false;
        }

        var checkbox=userselected.join(',');
        <?php
            if($group['no_add']==0 || $group['is_owner']==1 || $group['is_manager']==1 )
                echo 'var apply=0';
           else  echo 'var apply=1';
        ?>

        var data={type:'inviteIntoGroup',userid:userid,group_id:<?php echo $group['id']; ?>,user_id:checkbox,apply:apply};
        parent.send_data(JSON.stringify(data));
        setTimeout(function () {
            parent.lastchat();
            var index = parent.layer.getFrameIndex(window.name); parent.layer.close(index);
        },1000)

         return false;

    }

    function input(value) {
        var list = document.querySelector('#userlist').querySelectorAll('.userlist');
        if(value!='') {
            var len = 0;

            for (var i = 0; i < list.length; i++) {
                if (list[i].querySelector('.nickname').innerHTML.indexOf(value) > -1) {
                    list[i].style.display = '';
                    len = 1;
                } else {
                    list[i].style.display = 'none';
                }
            }

            if (len == 1) {
             $('.nodata').hide()
            }
            else {
             $('.nodata').show();
            }
        }
        else{
            for (var i = 0; i < list.length; i++) {
                    list[i].style.display = '';
            }
            $('.nodata').hide()
        }


    }

   function click_user(id) {
       var isin=0;
        for(var i=0;i<userselected.length;i++){
            if(id==userselected[i]){
               isin=1;
               break;
            }
        }
        if(isin==0){
            userselected.push(id);
            var html=$('#user_'+id).html();
             html=  html.replace('plus','minus')
            $('#user_select').append('<div class="userlist" id="select_'+id+'" onclick="user_minus('+id+');">'+html+'</div>')
            $('#user_'+id).addClass('active')
        }
        else{

        }
        $('#selectnum').html(userselected.length);
   }

   function user_minus(id) {
       var isin=0;
       for(var i=0;i<userselected.length;i++){
           if(id==userselected[i]){
               userselected.splice(i,1);

               break;
           }
       }
       $('#select_'+id).remove();
       $('#user_'+id).removeClass('active')
       $('#selectnum').html(userselected.length);
   }
</script>
<style>
     .info{
        width: 96%;
         margin-left: 2%;
         display: table;
     }
    .info > div {
        display: table-cell;
        width: 50%;
       height: 300px;
        vertical-align: top;
        overflow-y: scroll;
        overflow-x: hidden;

    }
    .info > div:first-child{
        border-right: 1px solid #ddd;
    }
     .info > div::-webkit-scrollbar{
         display: none;
     }
     .info .nav{
        position: fixed;
        top:5px;
        left: 0px;
        width: 185px;
        height: 40px;
        line-height: 40px;
         padding-left:15px;
         text-align:left;
    }


    .info .userlist{
        height: 40px;
        line-height: 40px;
        vertical-align: top;
        margin:  5px 0px;
       cursor: pointer;

    }
     .info .userlist .icon{
         position: absolute;
         right:5px;
         top:15px;
         display: none;
     }
     .info .userlist:hover, .info .userlist.active{
         background-color: #fafafa;
     }
     .info .userlist:hover .icon{
         display: inline-block;
     }
     .info .userlist .avatar{
         display: inline-block;
         width: 50px;
         text-align: center;
     }
     .info .userlist .avatar img{
         height: 35px;
         width: 35px;
         border-radius: 5px;
         vertical-align: middle;
     }
     .info .userlist .nickname{
         display: inline-block;
         text-align: left;
         font-size: 14px;
         height: 40px;
         line-height: 40px;
         border-bottom: 1px dashed #eee;
         width: calc(100% - 60px);
         position: relative;
     }


</style>

<?php include_once template("footer");?>