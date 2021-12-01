<?php
include_once '../../inc/common.php';
header('Access-Control-Allow-Origin: *');


require_once(dirname(__FILE__).'/'.'igetui.php');
require_once(dirname(__FILE__).'/'.'igetui/template/notify/IGt.Notify.php');


// 返回错误信息
function error($des){
    header('Content-type: text/plain; charset=utf-8');
    echo '!!ERROR!!'.PHP_EOL;
    echo $des;
    echo PHP_EOL;
}




$cid = '';
$title = '';
$content = '';
$payload = '';
$package = PACKAGENAME;//包名

//switch (@$_SERVER['REQUEST_METHOD']) {
//    case 'POST':
//        $cid = @$_POST['cid'];
//        $title = @$_POST['title'];
//        $content = @$_POST['content'];
//        $payload = @$_POST['payload'];
//        break;
//    case 'GET':
//        $cid = @$_GET['cid'];
//        $title = @$_GET['title'];
//        $content = @$_GET['content'];
//        $payload = @$_GET['payload'];
//        break;
//    default:
//        break;
//}

$cid = @$_REQUEST['cid'];
$title = @$_REQUEST['title'];
$content = @$_REQUEST['content'];
$payload = @$_REQUEST['payload'];
$sendtype=@$_REQUEST['sendtype'];
$showtitle=@$_REQUEST['showtitle'];
if(empty($cid)){
    error('无效的终端标识（cid）');
    return;
}else if(empty($title)){
    error('无效的通知标题（title）');
    return;
}else if(empty($content)){
    error('无效的通知内容（content）');
    return;
}


// 生成指定格式的intent支持厂商推送通道
$intent = "intent:#Intent;action=android.intent.action.oppopush;launchFlags=0x14000000;component={$package}/io.dcloud.PandoraEntry;S.UP-OL-SU=true;S.title={$title};S.content={$content};S.payload={$payload};end";
if($sendtype=='sign'){
    $res=pushMessageToSingle(createPushMessage($payload,$intent,$title,$content,$showtitle), $cid);
    $taskid=$res['taskId'];
}
else{
    $cids=explode(',',$cid);
    $res=pushMessageToList(createPushMessage($payload,$intent,$title,$content,$showtitle),$cids);
    $taskid=$res['contentId'];
}

if($taskid){
    $payload=json_decode($payload,true);
    $msg_id=$payload['msg_id'];
    if($payload['msg_id']){
       $row=$db->exec("select * from app_chat where id='{$msg_id}'");
       if($row['pushid']){
           $pushid=$row['pushid'].",".$taskid;
       }
       else $pushid=$taskid;
        $db->query("update app_chat set pushid='{$pushid}' where id='{$msg_id}'");
    }

}
echo json_encode($res);
