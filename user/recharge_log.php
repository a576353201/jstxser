<?php
include_once '../inc/common.php';

need_login();
$web_title='充值记录';

if($_GET['type']=='set_status' and $_GET['id']){


$row=get_table(tname('recharge'),$_GET['id']);
if($row['status']==-1)
	$db->query("update ".tname('recharge')." set status='0' where id='{$_GET['id']}'");


}
if($_GET['type']=='delete' and $_GET['id']){

	$db->query("delete from ".tname('recharge')."  where id='{$_GET['id']}'");


}



     if($_POST['begintime']) $str.=" and  addtime>='".strtotime($_POST['begintime'].' 00:00:00')."'";
     if($_POST['endtime']) $str.=" and addtime<='".strtotime($_POST['endtime'].' 23:59:59')."'";
$sql="select * from ".tname('recharge')." where uid='{$_SESSION['userid']}' {$str} order by id desc";
$num=15;
$page=new Page($sql, $num, $_GET['page']);
$sql.=" limit $page->from,$num";
$list=$db->fetch_all($sql);
foreach ($list as $key=>$value) {
	$bank=unserialize($value['bank']);
	$list[$key]['bank_info']=$bank['title'].'-'.$bank['realname'].'-'.substr($bank['number'], 0,3).'****'.substr($bank['number'], strlen($bank['number'])-3,3);
	//$bank[]
}

$page_html=$page->get_page();



include_once template('user/recharge_log');

?>