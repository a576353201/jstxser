<?php
include_once '../inc/common.php';

need_login();
$web_title='账单';

     if($_POST['begintime']) $begintime=$_POST['begintime'];
     else $begintime=date('Y-m-d',time()-30*86400);

         $str.=" and  time>='".strtotime($begintime.' 00:00:00')."'";
if($_POST['endtime']) $endtime=$_POST['endtime'];
else $endtime=date('Y-m-d',time());
 $str.=" and time<='".strtotime($endtime.' 23:59:59')."'";

 if(strlen($_POST['type'])>0) $str.=" and type='{$_POST['type']}'";
$sql="select * from ".tname('money')." where uid='{$_SESSION['userid']}' {$str} order by id desc";
$num=10;
$page=new Page($sql, $num, $_GET['page']);
$sql.=" limit $page->from,$num";
$list=$db->fetch_all($sql);


$page_html=$page->get_page();



include_once template('user/money');

?>