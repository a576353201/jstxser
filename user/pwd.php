<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020-3-28
 * Time: 20:45
 */
include_once '../inc/common.php';
if($_SESSION['userid']){
    $user=userinfo($_SESSION['userid']);
    if($user['mobile']){
        $mobile=substr($user['mobile'],0,3).'*****'.substr($user['mobile'],strlen($user['mobile'])-3,3);
        $ismobile=1;
        $type='change';
    }
    else {
        $ismobile=0;
        $type='bind';
    }
    $isfrist=0;
    $issafe=0;
   if($_GET['method']=='safe'){
       if($user['pwd1'] && $user['pwd1']!=null)
           $isfrist=0;
       else $isfrist=1;
       $pwdname='资金';
       $issafe=1;
   }
    else $pwdname='登录';



}

else
{
    echo "<script>window.location='login.php';</script>";
    exit();
}
$step=$_GET['step'];
if(!$step) $step=0;

if($issafe==1)
    include_once template('user/pwd_safe');
  else
include_once template('user/pwd');