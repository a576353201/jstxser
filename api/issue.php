<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020-3-21
 * Time: 17:01
 */

include_once '../inc/common.php';
if(time()-$_SESSION['jointime']<3){
    $res['code']=400;
    die(json_encode($res));
}
$_SESSION['jointime']=time();

$res=array();

$gamekey=$_GET['gamekey'];
$gamekey1=strtoupper($gamekey);
$expect=$_GET['expect'];
$sql="select * from ".tname('game')." where (showkey='{$gamekey}' or showkey='{$gamekey1}') and status='1'";

$game=$db->exec($sql);

if($game['id']>0){
$showkey=$game['showkey'];
$row=$db->exec("select * from ".lottery_table($showkey)." where period='{$expect}'");
if($row['id']>0){
    $res['result']='success';
$data=array();
$data['code']=$row['number'];
$data['cur_online']=-1;
    $data['issue']=$row['period'];
    $data['lotterycode']=strtolower($showkey);
    $data['officialissue']=$row['period'];
    $data['opendate']=date('Y-m-d H:i:s',$row['lottime']);
    $res['data']=$data;

    die(json_encode($res));
}
else{
    $res['error']='no data';
}

}else{
    $res['error']='lottery code';
}
die(json_encode($res));