<?php
include_once '../inc/common.php';

needlogin();

$list=getMyFriend($_SESSION['userid']);
if($_GET['groupid']){
    $group=GroupInfo($_GET['groupid'],$_SESSION['userid']);
    $user_id=explode(',',$group['user_id']);
    if(count($list)>0){
        foreach ($list as $key=> $value){
            if(in_array($value['id'],$user_id)) unset($list[$key]);
        }
    }
}


include_once template('chat/invite');
?>