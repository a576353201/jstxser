<?php
include_once '../inc/common.php';
need_login();
$value=userinfo($_REQUEST['id']);
;
$value['team_num']=count(get_teamids($value['id']));
$value['team_money']=get_teammoney($value['id']);
$value['money']=number_format($value['money'],2,'.','');
if(time()-$value['online']<60  ){
    $value['isonline']=true;
}else{
    $value['isonline']=false;
}
$value['rebate']=number_format($value['rebate'],1);
$userinfo=$value;
include_once template('user/invite_user1');