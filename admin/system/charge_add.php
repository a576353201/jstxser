<?php
include_once '../inc/header.php';

if(!$_GET['action']){
    $action='add';
}
else {
    $action=$_GET['action'];

$charge=get_table(tname('charge'), $_GET['id']);
}
?>




 <form name='myform' enctype="multipart/form-data" action="action.php?from=charge&action=<?php echo $action; ?>" onsubmit="return check_add();"method="post">
     <input type="hidden" id="method" name="method" value="<?php echo $charge['method'] ?>">
    <?php 
    if($action=='edit'){
    ?>

          <input type="text" name="id" value="<?php echo $charge['id']?>" style="display:none" />

      
      <?php }?>



<table width="98%" bgcolor="#FFFFFF" class="tableList" cellpadding="1" cellspacing="1">



    <tr>
        <td align="right">充值银行</td>
        <td>
            <select name="bank"  id="bank" onchange="change_bank(this.value,1)">
                <?php

                foreach ($bank_arr1 as $key=>  $value){
                    ?>
                   <option value="<?php echo $key?>" <?php if($key==$charge['bank']) echo "selected" ?>><?php  echo $value;?></option>
                    <?php
                }
                ?>

            </select>

        </td>
    </tr>

  <tr> 
            <td width="20%" align="right">渠道名称</td>
            <td width="80%"> 
            <input name="title" type="text" size="50" maxlength="200" id="title" value="<?php echo $charge['title'];?>">
            </td>
          </tr>
          
          
          
            <tr> 
            <td width="20%" align="right">收款账户名</td>
            <td width="80%"> 
            <input name="realname" type="text" size="50" maxlength="200" id="realname" value="<?php echo $charge['realname'];?>">
            </td>
          </tr>
                    
            <tr> 
            <td width="20%" align="right">银行账号</td>
            <td width="80%"> 
            <input name="number" type="text" size="50" maxlength="200" id="number" value="<?php echo $charge['number'];?>">
            </td>
          </tr>
          
       <tr>
            <td width="20%" align="right">付款二维码</td>
            <td width="80%"> 
                <input name="qrcode" type="text" size="50" maxlength="200" style="width: 120px"  value="<?php echo $charge['qrcode'];?>" id="qrcode">
                        <iframe style="padding:0; margin:0;" src="../inc/upload.php?returnid=qrcode&path=bank&image=1" frameborder=0 scrolling=no width="150" height="25"></iframe>
                                   
            </td>
          </tr>
    <tr>
        <td align="right">  金额设置</td>
        <td>
            最低:<input name="min" type="text" size="5" style="width: 40px"  value="<?php echo $charge['min'];?>">元

            最高：<input name="max" type="text" size="5"  style="width: 40px"    value="<?php echo $charge['max'];?>">元
            手续费：<input name="fee" type="text" size="5"  style="width: 40px"    value="<?php echo $charge['fee'];?>">%

        </td>
    </tr>
    <tr>
        <td align="right">状态</td>
        <td> <input name="status" type="radio" value="1" <?php if($flink['status']!=2) echo 'checked'; ?> >启用&nbsp;
            <input name="status" type="radio" value="2" <?php if($flink['status']==2) echo 'checked'; ?>>关闭
        </td>
    </tr>

  
  <tr>
  <td></td>
    <td colspan="1" align="left" valign="middle">
      <input type="submit" value="确 定" class="button" onclick="return check_add()" />
      <input type="button" value="关闭" class="button" onclick="var index=parent.layer.getFrameIndex(window.name);parent.layer.close(index);"/>
    </td>
  </tr>
</table>
</form>


 <script type="text/javascript">


     function change_bank(value,ischange) {
         if(value=='alipay' || value=='weixin') document.querySelector('#method').value=value;
         else document.querySelector('#method').value='bank';
         if(document.querySelector("#title").value=='' || ischange==1){
           var bank=document.querySelector('#bank');

             document.querySelector("#title").value=bank.options[bank.selectedIndex].text;
         }

     }



function  check_add(){

if(document.getElementById('title').value==''){
alert('请输入渠道名称');

	return false;
}
var bank=document.querySelector('#bank').value;
if(bank=='weixin' || bank=='alipay' ){
    if(document.getElementById('qrcode').value==''){
        alert('请上传付款二维码');

        return false;
    }



}else{
    if(document.getElementById('realname').value==''){
        alert('请输入开户姓名');

        return false;
    }
    if(document.getElementById('number').value==''){
        alert('请输入汇款账号');

        return false;
    }

}

	
}
change_bank(document.querySelector('#bank').value,0);
</script>
 


