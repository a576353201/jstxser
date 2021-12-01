<?php
include_once '../inc/common.php';

$type=$_GET['type']?$_GET['type']:0;
$user=userinfo($_SESSION['userid']);
if($user['vip_time']>time()){
    $lasttime= ceil(($user['vip_time'] - time())/86400);
}
else $lasttime=0;

include_once template('user/joinvip');