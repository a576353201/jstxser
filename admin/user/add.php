<?php
include_once '../inc/header.php';

if(!$_GET['action']) $action='add';
else $action=$_GET['action'];
$user=$admin=get_table(tname('user'), $_GET['id']);
if($user['pid']==0) $rebate_max=$system['invite_pre'];
else {
    $parent=userinfo($user['pid']);
    $rebate_max=$parent['rebate']-1;
}


    $group_arr=array('基本信息','计划员信息',"计划列表");


?>
<style>
    .info .line .title {

        width: 120px;
        margin-right: 10px;
    }

    .info .line .title1{

        width: 80px;
        margin-right: 10px;
        display: inline-block;
        text-align: right;
    }
    .line{
        height:45px;
        line-height:45px;
    }
    input[type='date']{
        width:150px;
        border: 1px solid #dbdbdb;
        height: 35px;
        line-height: 35px;
        padding-left: 5px;
        border-radius: 5px;
    }
    input[type='text'],input[type='password']{
    width: 180px !important;
    }
</style>

<script src="/static/js/script_area.js"></script>

<?php
if($action=='edit'){

    ?>
    <div class='process1' style="display: none">

        <?php

        foreach($group_arr as $key=>$value){


            ?>

            <div id='tit_<?php echo $key;?>'  class='step <?php if($key==0) echo 'cur';?>'  style='<?php if(!$value) echo "display:none;";?>width:<?php echo 100/count($group_arr);?>%;'  onclick="set_tabs(<?php echo $key;?>,<?php echo count($group_arr);?>);"; >

                <div class='info'><?php echo $value;?></div>
            </div>
          <?php
        }

        ?>
    </div>

    <?php

}
?>
<form name='myform' enctype="multipart/form-data" action="action.php?action=<?php echo $action ?>&id=<?php echo $_GET['id'];?>" method="post">




    <div class='info' id='info_0' >


        <?php
        if($user['id']){
              $row=userinfo($user['id']);

            ?>
            <div class='line'>
<span  class='title'>
<img src="<?php echo $row['avatar'];?>"  style='width:40px;height:40px;border-radius:5px;vertical-align: middle'>

</span>
                <input type="text" name="avatar" value="<?php echo $user['avatar']?>" size="20" readonly="readonly" style="width: 180px;" />
           <iframe style=" padding:0; margin:0;" src="../inc/upload.php?returnid=avatar&image=1&path=avatar" frameborder=0 scrolling=no width="200" height="25"></iframe>


            </div>
            <div class='line'>
                <span  class='title'><span class='must'>*</span>ID：</span>
                <input name="number" type="text" size="20" maxlength="40" id="number"  value="<?php echo $row['number'];?>">

            </div>
        <?php  } ?>

        <div class='line'>
            <span  class='title'><span class='must'>*</span>用户名：</span>
                <input name="name" type="text" size="20" maxlength="40" id="name" <?php if($action!='edit') {?>  onblur="check_name();" <?php } ?> value="<?php echo $admin['name'];?>">



            <span id="name_msg"></span>
            <span  class='title1'>密码：</span>
            <input name="pwd" type="password" size="20" maxlength="40" >
        </div>
        <div class='line'>
            <span  class='title'>手机号：</span>
            <input name="mobile" type="text" size="20" maxlength="40" value="<?php echo $user['mobile'];?>">
            <span  class='title1'>昵称：</span>
            <input name="nickname" type="text" size="40" maxlength="40" value="<?php echo $admin['nickname'];?>" style="width: 180px">


        </div>


        <div class='line'>

            <span  class='title'>性别：</span>

            <input name="sex" type="radio" value="1"  <?php if($admin['sex']==1 or $action=='add'){?>  checked="checked" <?php }?>>男 &nbsp;
            <input name="sex" type="radio" value="2" <?php if($admin['sex']==2 and $action!=='add' ){?>  checked="checked" <?php }?>>女
            <span  class='title'>客服：</span>

            <input name="iskefu" type="radio" value="1"  <?php if($admin['iskefu']==1 or $action=='add'){?>  checked="checked" <?php }?>>是 &nbsp;
            <input name="iskefu" type="radio" value="0" <?php if($admin['iskefu']==0 and $action!=='add' ){?>  checked="checked" <?php }?>>否

            客服备注：<input name="kefu_name" placeholder="客服备注" type="text" size="20" maxlength="40" value="<?php echo $admin['kefu_name'];?>" style="width:120px !important;">

        </div>




        <div class='line' >
            <span  class='title'>VIP：</span>

            <input name="vip" type="radio" onclick="$('#vip_time').show();" value="<?php if($admin['vip']) echo $admin['vip'];else echo '1';?>"  <?php if($admin['vip']>0 ){?>  checked="checked" <?php }?>>是 &nbsp;
            <input name="vip" type="radio" onclick="$('#vip_time').hide();" value="0" <?php if($admin['vip']==0 or $action=='add'){?>  checked="checked" <?php }?>>否
        <span id="vip_time" style="padding-left: 20px;<?php if($admin['vip']==0 or $action=='add') echo "display:none;"; ?>">
             到期时间：<input type="date" name="vip_time" value="<?php if($admin['vip']) echo date('Y-m-d',$admin['vip_time']) ;else echo date('Y-m-d') ?>">
        </span>

        </div>

        <div class='line'>
            <span  class='title'>上级代理：</span>
             <input type="text" name="parent_name" placeholder="<?php if($admin['pid']==0) echo '当前是顶级代理';?>" value="<?php if($admin['pid']>0) echo $parent['name']?>">
        </span>

        </div>


        <div class='line'>
            <span  class='title'>代理：</span>

            <input name="isdaili" type="radio" onclick="$('#rebate').show();" value="1"  <?php if($admin['isdaili']!=0 or $action=='add'){?>  checked="checked" <?php }?>>是 &nbsp;
            <input name="isdaili" type="radio" onclick="$('#rebate').hide();" value="0" <?php if($admin['isdaili']==0 and $action!='add'){?>  checked="checked" <?php }?>>否

        </span>

        </div>

        <div class='line'>
            <span  class='title'>所在地：</span>

            <select class="provinceTarget inputEle selectTag" id="province" name="province" onchange="privicechange();">
                <option data-index="-1" value="省份">省份</option>
            </select>

            <!--城市选项列表-->
            <select class="cityTarget inputEle selectTag" id="city" name="city">
                <option data-index="-1" value="城市">城市</option>
            </select>
        </div>

        <div class='line'>
            <span  class='title'>个性签名：</span>
            <input name="sign" type="text" size="40" maxlength="40" value="<?php echo $admin['sign'];?>">

        </div>

        <?php
        if($admin['status']==2){
            ?>
            <div class='line'  >
                <span  class='title'>账号已锁定：</span>
                <span style="font-size: 12px;">
                                   解封时间<?php echo date('Y-m-d H:i',$admin['lock_time'])?>
                    <?php if($admin['lock_mark']) {?> 原因：<?php echo $admin['lock_mark']?><?php }?>

                </span>

                <input type="button" value='解封' class='button' onclick="unlock();">


            </div>
            <?php
        }
        else{
            ?>

            <div class='line' >
                <span  class='title'>状态：</span>

                <select name="status"  onchange="set_status(this.value);" >
                    <?php

                    foreach ($status_array as $key=>$value){
                        ?>
                        <option value="<?php echo $key;?>" <?php if($key==$admin['status']) echo "selected";?>><?php echo $value;?></option>
                        <?php
                    }
                    ?>

                </select>

                <span id="lock_html" style="display: none;">锁定<input type="text" style="width:40px;" name="lock_day" value="3">天&nbsp;
                原因：<input type="text" style="width: 150px;" name="lock_mark" value="<?php echo $admin['lock_mark']?>">
                </span>

            </div>
        <?php
        }
        ?>
        <div class='line'>
            <span  class='title'>提现冻结：</span>

            <input name="islock" type="radio" value="1"  <?php if($admin['islock']==1 ){?>  checked="checked" <?php }?>>禁止提现 &nbsp;
            <input name="islock" type="radio" value="0" <?php if($admin['islock']!=1 ){?>  checked="checked" <?php }?>>允许提现

        </div>
    </div>

    <div class='info' id='info_1'  style="display: none">



    </div>

    <div class='info' id='info_2'  style="display: none">




    </div>
    <div class='info' >
        <div class='line'>
            <div style='padding-left:150px;'  id='sub_html'>

                <input class='btn01' type='submit' name='Submit' value='保存' onclick='check_add(); '>
                <input type="button" value='关闭' class='button' onclick="var index=parent.layer.getFrameIndex(window.name);parent.layer.close(index);">
            </div>

        </div>
    </div>
</form>
<script type="text/javascript">

    var step=0;
    var exit=0;
    var  group_sum=<?php echo count($group_arr);?>;


    function change_type(type) {
        if(type=='ssc'){
            $('#ssc').show();$('#11x5').hide();
           var checked= document.querySelectorAll('.11x5');

        }else{
            $('#ssc').hide();$('#11x5').show();
            var checked= document.querySelectorAll('.ssc');
        }

        for(var i=0;i<checked.length;i++){
            checked[i].checked=false;
        }
    }


  function set_status(value) {

      if(value==2){
          $('#lock_html').show();
      }
      else{
          $('#lock_html').hide();
      }
  }

  function unlock() {
      var index=  layer.confirm("是否确认解封该账号", {
          title:'提示',
          time: 20000, //20s后自动关闭
          btn: ['解封', '取消']
      },function () {

          $.post("/api/user.php?act=unlock",{id:<?php echo $admin['id']?>}, function(result){
              result=JSON.parse(result);
              var data=result.data;

              parent.layer.msg("账号已经解封",{ type: 1, anim: 2 ,time:1000});
              setTimeout(function () {
                  location.reload();
              },200)
          });

          layer.close(index);
      },function () {

      });
  }

    function check_name() {
        Sxmlhttprequest();

        var name=document.getElementById('name').value;
        //alert(name);
        xmlHttp.open('GET','check_admin.php?name='+name,true);
        xmlHttp.onreadystatechange=byphp;
        xmlHttp.send(null);
    }
    function byphp(){

        if(xmlHttp.readyState==1){
            document.getElementById('name_msg').innerHTML="loading....";
        }
        if(xmlHttp.readyState==4){
            var msg=xmlHttp.responseText;

            if(msg.indexOf('1')>0)
            {exit=0;
                alert('手机号已存在');
                return false;
            }
            else{

                exit=1;
            }


        }
    }

    function   check_add(){


        var pwd=document.getElementById('pwd');
        var pwdcheck=document.getElementById('pwdcheck');
        <?php if($action=='add'){?>

        if(document.getElementById('name').value==''){

            alert('请输入账号');
            return false;

        }

        check_name();
        if(exit!=1){
            alert('账号已经存在');
            return false;

        }

        if(pwd.value==''){
            alert('请输入密码');
            return false;
        }


        <?php }?>



        if(pwd.value!=pwdcheck.value){
            alert('两次密码输入不一致');
            return false;
        }

    }








    function set_tabs(num,sum){



        for(var i=0;i<sum;i++){


            if(i==num){

                document.getElementById('tit_'+i).className='step cur';

                document.getElementById('info_'+i).style.display='block';
            }
            else{
                document.getElementById('tit_'+i).className='step';

                document.getElementById('info_'+i).style.display='none';


            }

        }


    }

   window.onload=function () {
       var index = parent.layer.getFrameIndex(window.name);
       parent.layer.iframeAuto(index);
       loadCityData();
       <?php
       if($user['city']){
       ?>
       updateLocationInfo('<?php echo $user['province'];?>', '<?php echo $user['city'];?>');
       <?php
       }
       ?>
       <?php
       if($_GET['planer']==1){
       ?>
       set_tabs(1,2);
       <?php
       }
       ?>
   }


    var index = parent.layer.getFrameIndex(window.name);
    parent.layer.iframeAuto(index);

</script>

