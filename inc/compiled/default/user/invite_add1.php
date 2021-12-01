<div class="page">


    <ul class="profile" >
        <li>登录账号：</li>

        <li style='position: relative;'>
            <input type="text" id="username" style="width: 150px;" maxlength="10" class="input1" placeholder="请输入登录账号" onblur="check_name(this.value);" />

            <i id="name_tips" class="tips"></i>
        </li>
    </ul>
    <ul class="profile" >
        <li>登录密码：</li>

        <li>
            <input type="password" id="password" style="width: 150px;" maxlength="10" class="input1" placeholder="默认密码:123456" v-model="form.password"/>
        </li>
    </ul>
    <ul class="profile" >
        <li>用户类型：</li>

        <li>
            <input  type="radio" name="isdaili" checked onclick="set_daili1(1)">代理   &nbsp;&nbsp;
            <input  type="radio" name="isdaili"  onclick="set_daili1(0)">玩家
        </li>
    </ul>

    <ul class="profile"  style="display: none">
        <li>返点比例：</li>

        <li>
            <select name="rebate" id="rebate1">
                <?php for($i=$max_rebate;$i>=0;$i=$i-0.5){?>
                <option value="<?php echo $i?>"><?php echo number_format($i,1)?>%</option>

                <?php }?>
            </select>
            <span style="margin-left:10px;color:#666;" id="rebate1_tips">
             ( 打赏分润占比  )



                       </span>

        </li>
    </ul>



    <div style="margin:15px auto;display:block;width: 80%;">

        <button class="button1" onclick="return click_sub11()">确认并提交</button>
    </div>



    <div class="modalhtml" >

        <div class="modal">
            <div class="title">
                开户成功
            </div>
            <div class="content11" id="tips_ok" style="text-align: left">

            </div>
            <div class="btns" >
                <span onclick="$('.modalhtml').hide();">关 闭</span>
                <span style="color:#2319DC;font-weight: 600;" onclick="click_copyinfo()">复 制</span>
            </div>
        </div>

    </div>

    
</div>
<script>
    function set_daili1(num) {
        isdaili=num;
        if(num==1){
            document.querySelector('#rebate1').value='<?php echo $max_rebate; ?>';
            $('#rebate1').attr('disabled',false);
            $('#rebate1_tips').html('(打赏分润占比)')
        }
        else{
            document.querySelector('#rebate1').value=0;
            $('#rebate1').attr('disabled',true);
            $('#rebate1_tips').html('(玩家账号无分润)')
        }
    }
    var name_status=false;

    function check_name(value) {
        name_status=false;
        var reg = /^[\d\w]+$/;
        if (reg.test(value)) {
            if (value.length > 5) {
                $.post("../api/user.php?act=checkname", {username: value}, function (result) {
                    var res = JSON.parse(result);

                    if (res.code == 200) {
                        document.querySelector('#name_tips').className = 'tips icon-ok-circle';
                        name_status = true;
                    } else {
                        document.querySelector('#name_tips').className = 'tips icon-cancel-circle';
                        name_status = false;
                        layer.msg("该账号已经被注册", {type: 1, anim: 2, time: 1000});
                    }

                });

            } else {
                document.querySelector('#name_tips').className = 'tips icon-cancel-circle';
                name_status = false;

            }


        } else {
            document.querySelector('#name_tips').className = 'tips icon-cancel-circle';
            name_status = false;

        }
    }
   var postdata={};
      function click_sub11(){



          if($('#username').val().length<6){
              layer.msg("用户长度不能小于6位",{ type: 1, anim: 2 ,time:1000});
              return false;
          }
          var reg=/^[\d\w]+$/;
          if(!reg.test($('#username').val())){
              layer.msg("用户名只能包含字母或数字",{ type: 1, anim: 2 ,time:1000});
              return false;
          }
          var password=$('#password').val();
          if(password==''){
              password='123456';
          }

          if(password.length<6){
              layer.msg("密码长度不能小于6位",{ type: 1, anim: 2 ,time:1000});
              return false;
          }

          if(name_status===false){
              layer.msg("该账号已经被注册",{ type: 1, anim: 2 ,time:1000});
              return false;
          }
           postdata={username:$('#username').val(),password:password,rebate:document.querySelector('#rebate1').value,isdaili:isdaili,userid:'<?php echo $_SESSION['userid']; ?>'};

          $.post("../api/user.php?act=user_add",postdata, function(result){
              var res=JSON.parse(result);
            console.log(res);
              if(res.code==200){
                var str=copyinfo(postdata);
                  $('.modalhtml').show();
                 $('#tips_ok').html(str.replace(/\n/g,"<br>"));
              }else{

                  layer.msg(res.message,{ type: 1, anim: 2 ,time:1000});
              }

          });


        }

   function  copyinfo(form){
        var str="登录账号："+form.username+"\n";
        str+="登录密码："+form.password+"\n";
        str+="账号类型：";
        if(form.isdaili) str+="代理";
        else str+="玩家";
        str+="\n";
        str+="返点比例："+form.rebate+"\n";
        str+="访问网址：<?php echo $HttpPath; ?>\n";
          return str;
    }

    function click_copyinfo() {
        $('.modalhtml').hide();
        copy(copyinfo(postdata))
    }


</script>
<style>
    .profile .tips {
        position: absolute;
        right: 110px;
        top: 7px;
    }
    .modalhtml{
        display: none;
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
        width: 60%;
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
    .modalhtml .modal .content11::-webkit-scrollbar{
        display: none;
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
        cursor: pointer;
    }
    .modalhtml .modal .btns >span:last-child{
        border-left: #eee 1px solid;
        color:#2319DC
    }

</style>