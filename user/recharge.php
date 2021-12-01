<?php


include_once '../inc/common.php';

need_login();
$web_title='充值';

$method=unserialize($system['recharge_method']);
$setting=json_encode(unserialize($system['recharge_setting']));
$method=unserialize($system['recharge_method']);
$setting=unserialize($system['recharge_setting']);
$bank=array();
if(count($method)>0){
    foreach ($method as $key=>$value){
        $row=$db->fetch_all("select * from app_charge where status=1 and method='{$value}' order by id asc");
        if(count($row)>0){
            foreach ($row as $k=>$v){
                $row[$k]['bankname']=$bank_arr1[$v['bank']];
            }
            $bank[$value]=$row;
        }else{
            unset($method[$key]);
        }
    }
}


$rechargeset=array('method'=>$method,'setting'=>$setting,'way'=>$recharge_arr,'bank'=>$bank,'online'=>false);

include_once template('user/recharge');

?>