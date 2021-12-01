<?php
include_once '../inc/common.php';

need_login();
$web_title='提现记录';

     if($_POST['begintime']) $str.=" and  time>='".strtotime($_POST['begintime'].' 00:00:00')."'";
     if($_POST['endtime']) $str.=" and time<='".strtotime($_POST['endtime'].' 23:59:59')."'"; 
$sql="select * from ".tname('plat')." where uid='{$_SESSION['userid']}' {$str} order by id desc";
$num=15;
$page=new Page($sql, $num, $_GET['page']);
$sql.=" limit $page->from,$num";
$list=$db->fetch_all($sql);
foreach ($list as $key=>$value) {
	$bank=unserialize($value['bank']);
	
	
	$list[$key]['bank_info']=$bank['bankname'].'-'.$bank['realname'].'-'.substr($bank['banknum'], 0,3).'****'.substr($bank['banknum'], strlen($bank['banknum'])-3,3);
	//$bank[]
}

$page_html=$page->get_page();



include_once template('user/plat_log');

?>