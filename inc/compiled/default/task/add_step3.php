<?php include_once template("header");?>
<style>

.wap_list{border:0px;padding-top:0px;}
.wap_list  .line{width:100%;display:block;clear:both;height:50px;line-height:50px;}
.wap_list  .line ul {padding-top:0px;}
.wap_list  .line  li{float:left;width:100px;}
.wap_list textarea{width:96%;height:100px;margin:0 auto;padding:5px 2%;font-size:16px;border:1px solid #ccc;}
.wap_list  input[type='text']{width:96%;height:35px;line-height:25px;padding:0px 2%;margin:0 auto;font-size:16px;border:1px solid #ccc;}

</style>

<div class="wap_list">
<form action="add.php?step=company"  method="post">
<input type="hidden" name='typeid'   value='0'>


<div class='line'>
<input name="title" id='title' type="text"  placeholder="请输入单位名称"  value=''>

</div>

<div class='line'  style='min-height:150px;height:auto;'>
<textarea id='content' name='content' >联系人：
联系方式：
实际经营业务：
</textarea>
    <input type="hidden" name='image_list' id='image_list' value='<?php echo $msg['img']; ?>'>

<iframe src='../upload.php?img=<?php echo $msg['img']; ?>'  id='upload_src'  style='width:100%;height:150px;'marginwidth="0px" frameborder="0" scrolling="no" ></iframe>
</div>

<div class='line'>
请上传企业营业执照
</div>


<div  style='line-height:30px;padding-top:10px;'>
						<input type="checkbox"  id='rule' name="rule"  value='1' checked><span  onclick='set_display("rule_content");'>同意<?php echo $system['web_title']; ?>网站服务规则</span>
					<textarea id='rule_content' style='width:95%;height:100px;margin:0 auto;display:none;'><?php echo $system['rule2']; ?></textarea>


					</div>

<div>
<input type="submit" class='btn100' value='确认并提交' onClick="return order_sub();">
</div>
</form>
</div>



<script>
function set_display(div){
	if(document.getElementById(div).style.display=='none'){


		document.getElementById(div).style.display='block';

	}
	else
		document.getElementById(div).style.display='none';

}






function order_sub(){


	if(document.getElementById('title').value==''){
		 window.wxc.xcConfirm('请输入单位名称',window.wxc.xcConfirm.typeEnum.warning);
         document.getElementById('title').focus();
         return false;
	}

	if(document.getElementById('content').value==''){
		 window.wxc.xcConfirm('请输入企业描述',window.wxc.xcConfirm.typeEnum.warning);
        document.getElementById('content').focus();
        return false;
	}

if(document.getElementById('image_list').value==''){
		 window.wxc.xcConfirm('请上传企业营业执照',window.wxc.xcConfirm.typeEnum.warning);
        document.getElementById('content').focus();
        return false;
	}


if(document.getElementById('rule').checked==false){


	window.wxc.xcConfirm('您还没有同意网站服务规则 ！',window.wxc.xcConfirm.typeEnum.warning);


	return  false;

}


  	if(confirm('是否要提交企业认证信息')){

	return true;

	}
	else {

		return false;
	}



}





</script>



<?php include_once template("footer");?>