<?php
include_once '../inc/common.php';

needlogin();

$list=getMyFriend($_SESSION['userid']);
$str="ABCDEFGHIJKLMNOPQRSTUVWXYZ#";
$pinyin=array();
for($i=0;$i<strlen($str);$i++){
 $pinyin[]=substr($str,$i,1);
}

include_once template('chat/contact');
?>