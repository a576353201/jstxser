<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020-09-10
 * Time: 16:26
 */
include_once '../../inc/common.php';
header('Access-Control-Allow-Origin: *');

require_once(dirname(__FILE__).'/'.'igetui.php');
require_once(dirname(__FILE__).'/'.'igetui/template/notify/IGt.Notify.php');


$cids=array('4320d53f73ccac4513772ec17f1de3a0','a0daed8ca0d3e67c566ebaed5a2b8245');
$intent = "intent:#Intent;action=android.intent.action.oppopush;launchFlags=0x14000000;component={$package}/io.dcloud.PandoraEntry;S.UP-OL-SU=true;S.title={$title};S.content={$content};S.payload={$payload};end";

$title="群发标题";
$content='群发内容'.date('H:i:s');
$payload=json_encode(array('type'=>'friend','id'=>86668));
//
$cid='4320d53f73ccac4513772ec17f1de3a0';
//$res=pushMessageToList(IGtStartActivityTemplateDemo($payload,$intent,$title,$content), $cids);
//print_r($res);

print_r(pushMessageToSingle(IGtStartActivityTemplateDemo($payload,$intent,$title,$content), $cid));
$taskid='OSS-0911_631bc2b259b316fccabb4997b2e1ac58';
//echo $taskid;
//print_r(pushMessageToList(getRevokeTemplateDemo($taskid),$cids));
//print_r(pushMessageToSingle(getRevokeTemplateDemo($taskid),$cid));
