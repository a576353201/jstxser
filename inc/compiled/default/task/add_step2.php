<?php include_once template("header");?>
<style>

.wap_list{border:0px;padding-top:0px;margin-top:-5px;}
.wap_list  .line{width:100%;display:block;clear:both;height:50px;line-height:50px;}
.wap_list  .line ul {padding-top:0px;}
.wap_list  .line  li{float:left;width:100px;}
.wap_list textarea{width:96%;height:100px;margin:0 auto;padding:5px 2%;font-size:16px;border:1px solid #ccc;}
.wap_list  input[type='text']{width:96%;height:35px;line-height:25px;padding:0px 2%;margin:0 auto;font-size:16px;border:1px solid #ccc;}

</style>
<div  style='height:40px;line-height:40px;padding-left:10px;'>

需求分类:<?php echo $nav_show; ?> <a href='add.php' style='color:#3388ff;'>修改</a>
</div>
<div class="wap_list">
<form action="add.php?step=sub"  method="post">
<input type="hidden" name='typeid'   value='<?php echo $_GET['typeid']; ?>'>
<?php if(count($list)>0){?>
<div class='line'  style='height:30px;line-height:30px;'>
需求类型：
<ul>

<?php if(is_array($list)){foreach($list AS $index=>$value) { ?>
<li>
<input type="checkbox" name='typeids[]' value='<?php echo $value['id']; ?>'>
<?php echo $value['title']; ?>
</li>

<?php }}?>
</ul>
</div>
<?php }?>

<div class='line'>
<input name="title" id='title' type="text"  placeholder="请输入需求标题"  value=''>

</div>

<div class='line'  style='min-height:150px;height:auto;'>
<textarea id='content' name='content'  placeholder="请输入需求详细描述" ></textarea>
    <input type="hidden" name='image_list' id='image_list' value='<?php echo $msg['img']; ?>'>

<iframe src='../upload.php?img=<?php echo $msg['img']; ?>'  id='upload_src'  style='width:100%;height:150px;'marginwidth="0px" frameborder="0" scrolling="no" ></iframe>
</div>

<div class='line'>
项目金额：<input name="money" id='money' type="text" style='width:100px' placeholder="最低<?php echo $system['task_min']; ?>元"  value=''>元

</div>

<div class='line'>
截止时间：<input type="text" name="endtime" id="endtime" value="<?php echo $endtime; ?>" class="Wdate" style="width:150px;" onclick="WdatePicker({dateFmt:'yyyy-MM-dd',alwaysUseStartDate:false})">

</div>
<div class='line'>
最大投标人数：<input name="max" id='max' type="text" style='width:100px'   value='<?php echo $system['task_max']; ?>'>人

</div>
<div  style='line-height:30px;padding-top:10px;'>
						<input type="checkbox"  id='rule' name="rule"  value='1' checked><span  onclick='set_display("rule_content");'>同意<?php echo $system['web_title']; ?>网站服务规则</span>
					<textarea id='rule_content' style='width:95%;height:100px;margin:0 auto;display:none;'><?php echo $system['rule2']; ?></textarea>


					</div>

<div>
<input type="submit" class='btn100' value='确认并发布' onClick="return order_sub();">
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
	<?php if(count($list)>0){?>

	var type=document.getElementsByName('typeids[]');
	var num=0;
	for(var i=0;i<type.length;i++){

		if(type[i].checked==true) num++;
	}

	if(num==0){

		   window.wxc.xcConfirm('请选择需求类型',window.wxc.xcConfirm.typeEnum.warning);
 return false;

	}
	<?php }?>

	if(document.getElementById('title').value==''){
		 window.wxc.xcConfirm('请输入需求标题',window.wxc.xcConfirm.typeEnum.warning);
         document.getElementById('title').focus();
         return false;
	}

	if(document.getElementById('content').value==''){
		 window.wxc.xcConfirm('请输入需求详细描述',window.wxc.xcConfirm.typeEnum.warning);
        document.getElementById('content').focus();
        return false;
	}

    if (document.getElementById('money').value == "") {
        window.wxc.xcConfirm('请输入项目金额！',window.wxc.xcConfirm.typeEnum.warning);
        document.getElementById('money').focus();
        return false;
    }

    if (isNaN(document.getElementById('money').value)) {
        window.wxc.xcConfirm('项目金额必须为数字！',window.wxc.xcConfirm.typeEnum.warning);
        document.getElementById('money').focus();
        return false;
    }
    if (parseFloat(document.getElementById('money').value) < <?php echo $system['task_min']; ?>) {
        window.wxc.xcConfirm('项目金额不能低于<?php echo $system['task_min']; ?>元！',window.wxc.xcConfirm.typeEnum.warning);
        document.getElementById('money').focus();
        return false;
    }


    if (document.getElementById('max').value == "") {
        window.wxc.xcConfirm('请输入最大投标人数！',window.wxc.xcConfirm.typeEnum.warning);
        document.getElementById('max').focus();
        return false;
    }

    if (isNaN(document.getElementById('max').value)) {
        window.wxc.xcConfirm('最大投标人数必须为数字！',window.wxc.xcConfirm.typeEnum.warning);
        document.getElementById('max').focus();
        return false;
    }
    if (parseFloat(document.getElementById('max').value) < 1) {
        window.wxc.xcConfirm('最大投标人数必须大于1人！',window.wxc.xcConfirm.typeEnum.warning);
        document.getElementById('max').focus();
        return false;
    }

 if (parseFloat(document.getElementById('max').value) ><?php echo $system['task_max']; ?>) {
        window.wxc.xcConfirm('最大投标人数必须小于<?php echo $system['task_max']; ?>人！',window.wxc.xcConfirm.typeEnum.warning);
        document.getElementById('max').focus();
        return false;
    }

if(document.getElementById('rule').checked==false){


	window.wxc.xcConfirm('您还没有同意网站服务规则 ！',window.wxc.xcConfirm.typeEnum.warning);


	return  false;

}

    if (parseFloat(document.getElementById('money').value) > <?php echo $user['money']; ?>) {

    	if(confirm('您的账户余额不足，当前账户余额为 <?php echo $user['money']; ?>元，请先去充值')){

    		location.href='../user/recharge.php?money='+document.getElementById('money').value;

    	}
    	else {

    		document.getElementById('money').focus();
    	}


        return false;
    }


  	if(confirm('发布该需求，需支付托管金'+document.getElementById('money').value+'元，是否确认？')){

	return true;

	}
	else {

		return false;
	}



}





</script>



<?php include_once template("footer");?>