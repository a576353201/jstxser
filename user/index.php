<?php
include_once '../inc/common.php';
need_login();
if($_SESSION['userid']){
    $user=userinfo($_SESSION['userid']);
    $userlog=$db->exec("select * from ".tname('userlog')." where userid='{$_SESSION['userid']}' order by  id desc limit 0,1" );
    if($user['mobile']){
        $mobile=substr($user['mobile'],0,3).'*****'.substr($user['mobile'],strlen($user['mobile'])-3,3);
        $ismobile=1;
        $type='change';
    }
    else {
        $ismobile=0;
        $type='bind';
    }
    if($_GET['type']==2) $type='new';

}

else
{
    echo "<script>window.location='login.php';</script>";
    exit();
}
$step=$_GET['step'];
if(!$step) $step=0;
if($user['pwd1'] && $user['pwd1']!=null)
    $issetpwd=1;
else $issetpwd=0;

$fromtime=strtotime(date('Y-m-d',time())." 00:00:00");

$row=$db->exec("select sum(money) as money from ".tname('money')."  where (`type`='sale' or `type`='reward') and uid='{$_SESSION['userid']}' and time>='{$fromtime}' ");
$yongjin=$row['money'];
if(!$yongjin) $yongjin=0;
$row=$db->exec("select sum(money) as money from ".tname('money')."  where `type`='yongjin' and uid='{$_SESSION['userid']}' and time>='{$fromtime}' ");
$dashang=number_format($row['money'],2,'.','');
if(!$dashang) $dashang=0;


$row=$db->exec("select * from ".tname('money')." where  `type`='sign' and uid='{$_SESSION['userid']}' and time>='{$fromtime}'");
if($row['id']>0){
    $is_signed=1;
}
else $is_signed=0;

include_once template('user/index');