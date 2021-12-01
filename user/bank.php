<?php
include_once '../inc/common.php';
need_login();
$web_title='银行卡管理';



$bank=$db->fetch_all("select * from ".tname('bank')." where uid='{$_SESSION['userid']}' order by `default` desc,id asc");

if(count($bank)>0){
    foreach ($bank as $key=> $value){
        $bank[$key]['number']=substr($value['banknum'], 0,4).'******'.substr($value['banknum'], strlen($value['banknum'])-3,3);;
    }
    $realname=$bank[0]['realname'];
   $step=0;
}
else{
  $step=1;
}
include_once template('user/bank');
?>