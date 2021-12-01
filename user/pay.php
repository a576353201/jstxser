<?php
include_once '../inc/common.php';

need_login();
$web_title='支付';
$money_title="金额";
$type=$_GET['type'];
$money='';
$payinfo=array();
$isgroup=$_REQUEST['isgroup']?$_REQUEST['isgroup']:0;
if($type=='reward'){

    $web_title="打赏计划员";
    $money_title="打赏金额";
}
else if($type=='plat_buy'){

    $plan=plan_detail($_GET['id']);
    if($plan['status']==1){
        $money=$plan['money'];
        $web_title="购买-".$plan['title'];
        $money_title="金额";
    }else{

        exit("<div style='text-align:center;padding-top:30px;'>该计划已完结</div>");
    }
}
else if($type=='redpacket'){
   // isgroup:isgroup,redtype:redtype,permoney:$('#money').val(),num:rednum,title:title,chatid:{$id},summoney:moneytotal
    $payinfo['isgroup']=$_REQUEST['isgroup'];
    $payinfo['type']=$_REQUEST['redtype'];
    $payinfo['permoney']=$_REQUEST['permoney'];
    $payinfo['num']=$_REQUEST['num'];
    $payinfo['title']=$_REQUEST['title'];
    $payinfo['chatid']=$_REQUEST['chatid'];
    $payinfo['summoney']=$_REQUEST['summoney'];
    $money=$_REQUEST['summoney'];
}
else if($type=='vip'){
    $web_title="确认支付";
    $money=$_REQUEST['money'];
    $payinfo['time']=$_REQUEST['buytime'];
    $payinfo['money']=$_REQUEST['money'];
    $payinfo['userid']=$_SESSION['userid'];
    $payinfo['viptype']=$_REQUEST['viptype'];

}

$payinfo=json_encode($payinfo);

include_once template('user/pay');

?>