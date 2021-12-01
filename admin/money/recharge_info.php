<?php
include_once '../inc/header.php';



$recharge=get_table(tname('recharge'), $_GET['id']);
$user=get_user_byid($recharge['uid']);
$bank=unserialize($recharge['bank']);

if($_POST){
	if($_POST['status']==1) {add_money($recharge['uid'], $recharge['money'], '充值成功');

	$_POST['agreetime']=time();
	}
$db->update(tname('recharge'), $_POST, $_GET['id']);

			promptMessage('recharge.php', '操作成功');
	exit();
}


?>

<table width="100%" border="0" cellspacing="0" cellpadding="0" class="titlebg">

      <tr>

        <td width="12" height="30"><img src="../style/images/content/tab_03.gif" width="12" height="30" /></td>

        <td>


         <div style='float:left' ><img src="../style/images/content/tb.gif" width="16" height="16" /></div>

         <div style='float:left'  class="STYLE1"><span class="STYLE3">当前位置:</span>充值详情</div>


      <div style='float:right;padding-right:5px;'><a href='recharge.php'>返回</a></div>
        </td>

        <td width="16"><img src="../style/images/content/tab_07.gif" width="16" height="30" /></td>

      </tr>

  </table>

  <style>
ul{margin: 0 auto; width:95%;line-height:40px;}
</style>
   <form name='formSort' enctype="multipart/form-data" action="recharge_info.php?type=sub&id=<?php echo $_GET['id'];?>"  method="post">

 <ul >
      <li>用户名：
         <?php echo $user['name']?>

           </li>

               <li>汇款金额：
         <?php echo $recharge['money']?>元

           </li>

           <li>汇款方式：
          <?php echo $bank['title']; ?>

           </li>

              <li>开户人姓名：

                 <?php echo $bank['realname']; ?>
           </li>

              <li>汇款账号：

                 <?php echo $bank['number']; ?>
           </li>

              <li>汇款凭据：
      <?php echo get_textarea($recharge['content']);?>

           </li>

           <?php

           if($recharge['status']==0){
           ?>

               <li>审核状态：

               <input type="radio"  name='status' value='1'>同意充值
   &nbsp;   &nbsp;   &nbsp;
              <input type="radio"  name='status' value='2'>拒绝充值
           </li>

    <?php }else{?>

               <li>审核状态：<?php echo $recharge_staus[$recharge['status']]?>


           </li>

           <?php }?>
             <li>备注：
    <textarea rows="4" cols="50" name='mark'><?php echo $recharge['mark']?></textarea>

           </li>

           <li  style='margin-top:15px;'>
      	<input type="submit" class='btn100' value='确认并提交' <?php  if($recharge['status']==0){ ?>onclick="return click_sub();" <?php } ?>>
           </li>
        </ul>
</form>


<script type="text/javascript">

function click_sub(){

	var sta=document.getElementsByName('status');

var  temp=0;
  for(var i=0;i<sta.length;i++){
if(sta[i].checked)  temp=sta[i].value;
	  }
	if(temp==0) {

alert('请选择审核状态'); return false;
		}
}


</script>
<?php include_once '../inc/footer.php';?>

