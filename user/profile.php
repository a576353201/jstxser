<?php
include_once '../inc/common.php';
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

include_once template('user/profile');