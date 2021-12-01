<div class="page">

    <ul class="profile" >
        <li>用户类型：</li>

        <li>
            <input  type="radio" name="isdaili" checked onclick="set_daili(1)">代理   &nbsp;&nbsp;
            <input  type="radio" name="isdaili"  onclick="set_daili(0)">玩家
        </li>
    </ul>
    <ul class="profile" style="display: none" >
        <li>返点比例：</li>

        <li>
          <select name="rebate" id="rebate">
              <?php for($i=$max_rebate;$i>=0;$i=$i-0.5){?>
              <option value="<?php echo $i?>"><?php echo number_format($i,1)?>%</option>

              <?php }?>
          </select>

        </li>
    </ul>

    <ul class="profile" >
        <li>备注：</li>

        <li>
            <input type="text" id="remark" style="width: 150px;" maxlength="10" class="input1" placeholder="请输入备注信息" v-model="form.remark"/>
        </li>
    </ul>


    <div style="margin:15px auto;display:block;width: 80%;">




        <button class="button1" onclick="click_sub()">确认并提交</button>


    </div>

</div>

<script>
    var isdaili=1;
    function set_daili(num) {
        isdaili=num;
        if(num==1){
            document.querySelector('#rebate').value='<?php echo $max_rebate; ?>';
            $('#rebate').attr('disabled',false);
        }
        else{
            document.querySelector('#rebate').value=0;
            $('#rebate').attr('disabled',true);
        }
    }
    
    function click_sub() {
        $.post("../api/user.php?act=invite_add",{userid:<?php echo $_SESSION['userid']; ?>,isdaili:isdaili,remark:$('#remark').val(),rebate:document.querySelector('#rebate').value}, function(result){
            /// layer.close(loading);
            var res=JSON.parse(result);
            if(res.code==200){
               location.href="?method=1"
            }

        });
    }
</script>

<style>


    .profile,.login-lines1{
        background-color: #fff;
        margin: 10px auto;
        width: 100%;
        vertical-align: middle;
    }
    .profile li{
        vertical-align: middle;
    }
    .profile li:first-child{
        width:120px
    }
    .profile li:last-child{
        width:calc(100% - 130px)
    }
</style>