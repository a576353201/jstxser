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
print_r(pushMessageToList(createPushMessage($payload,$intent,$title,$content), $cids));
//print_r(stop('OSS-0911_0c55293a4c2bb0a66b540cb2acf85bd5',$cid));
//$taskid='OSL-0911_5KgGXXejjO84ietYn5ddf1';
//print_r(pushMessageToList(getRevokeTemplateDemo($taskid),$cids));
//print_r(pushMessageToSingle(getRevokeTemplateDemo($taskid),$cid));
//
//print_r(stop('OSS-0911_3c12b2c3cd02ea68e7edeab6731ae420',$cid));