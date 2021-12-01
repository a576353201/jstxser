<?php include_once template("header");?>

      <style>

      textarea{width:96%;height:100px;margin:10px auto;padding:5px 2%;font-size:16px;border:1px solid #ccc;}
      </style>

      <div class='user_mian'>
<form action="recharge_info.php?step=sub&id=<?php echo $_GET['id']; ?>"  method="post">
为了方便网站管理员审核，请填写您的汇款凭据<br>
<textarea id='content' name='content'  placeholder="请输入您的汇款凭据" ></textarea>

<input type="submit" class='btn100' value='确认提交' onClick="return order_sub();">


<div style='word-break:break-all;color:#ff0000;display:block;width:100%;line-height:30px;'>
              <?php echo get_textarea($system['recharge_tips1']); ?>
</div>

</form>
        </div>

<script>
function order_sub(){


	if(document.getElementById('content').value==''){
		 window.wxc.xcConfirm('请填写您的汇款凭据',window.wxc.xcConfirm.typeEnum.warning);
        document.getElementById('content').focus();
        return false;
	}



}
</script>
<?php include_once template("footer");?>