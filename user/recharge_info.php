<?php
include_once '../inc/common.php';
need_login();
$web_title='填写汇款凭据';

$recharge=get_table(tname('recharge'), $_GET['id']);

if($recharge['status']!='-1'){


		promptMessage($_SERVER['HTTP_REFERER'], '当前充值记录已提交或者不存在');

}


if($_POST){

		$db->query("update ".tname('recharge')." set status='0',content='{$_POST['content']}' where id='{$_GET['id']}'");

	promptMessage('recharge_log.php', '您的充值已经提交，请耐心等待管理员审核');
}



include_once template('user/recharge_info');
?>
