<?php
//header('Access-Control-Allow-Origin: *');
//header("Content-Type: text/html; charset=utf-8");

require_once(dirname(__FILE__) . '/' . 'config.php');
require_once(dirname(__FILE__) . '/' . 'igetui/IGt.APNPayload.php');
require_once(dirname(__FILE__) . '/' . 'IGt.Push.php');


/**
 * 创建普通通知
 * @param $t  推送通知标题
 * @param $c  推送通知内容
 * @param $p  推送透传内容(客户端暂时未处理此数据)
 * @return IGtNotificationTemplate
 */
function createNotiMessage( $t, $c, $p ){
    $template =  new IGtNotificationTemplate();
    $template->set_appId(APPID);//应用appid
    $template->set_appkey(APPKEY);//应用appkey
    $template->set_transmissionType(1);//透传消息类型，Android平台控制点击消息后是否启动应用
    if(!empty($p)){
        $template->set_transmissionContent($p);//透传内容，点击消息后触发透传数据
    }
    $template->set_title($t);//通知栏标题
    $template->set_text($c);//通知栏内容
//    $template->set_logo("http://wwww.igetui.com/logo.png");//通知栏logo，不设置使用默认程序图标
    $template->set_isRing(true);//是否响铃
    $template->set_isVibrate(true);//是否震动
    $template->set_isClearable(true);//通知栏是否可清除

    return $template;
}


/**
 * 创建链接通知
 * @param $t  推送通知标题
 * @param $c  推送通知内容
 * @param $l  推送通知链接地址
 * @return IGtLinkTemplate
 */
function createLinkMessage($t, $c, $l){
    $template =  new IGtLinkTemplate();
    $template ->set_appId(APPID);//应用appid
    $template ->set_appkey(APPKEY);//应用appkey
    $template ->set_title($t);//通知栏标题
    $template ->set_text($c);//通知栏内容
//    $template->set_logo("http://wwww.igetui.com/logo.png");//通知栏logo，不设置使用默认程序图标
    $template ->set_isRing(true);//是否响铃
    $template ->set_isVibrate(true);//是否震动
    $template ->set_isClearable(true);//通知栏是否可清除
    $template ->set_url($l);//打开连接地址
    //$template->set_duration(BEGINTIME,ENDTIME); //设置ANDROID客户端在此时间区间内展示消息

	return $template;
}


/**
 * 创建下载通知
 * @param $t  推送通知标题
 * @param $c  推送通知内容
 * @param $pt  点击通知后弹框标题
 * @param $pc  点击通知后弹框内容
 * @param $dt  下载进度框标题
 * @param $dl  下载链接地址
 * @return IGtNotyPopLoadTemplate
 */
function createDownMessage($t, $c, $pt, $pc, $dt, $dl ){
    $template =  new IGtNotyPopLoadTemplate();

    $template ->set_appId(APPID);//应用appid
    $template ->set_appkey(APPKEY);//应用appkey
    //通知栏
    $template ->set_notyTitle($t);//通知栏标题
    $template ->set_notyContent($c);//通知栏内容
    $template ->set_notyIcon("");//通知栏logo
    $template ->set_isBelled(true);//是否响铃
    $template ->set_isVibrationed(true);//是否震动
    $template ->set_isCleared(true);//通知栏是否可清除
    //弹框
    $template ->set_popTitle($pt);//弹框标题
    $template ->set_popContent($pc);//弹框内容
//    $template ->set_popImage("");//弹框图片
    $template ->set_popButton1("下载");//左键
    $template ->set_popButton2("取消");//右键
    //下载
//    $template ->set_loadIcon("");//弹框图片
    $template ->set_loadTitle($dt);
    $template ->set_loadUrl($dl);
    $template ->set_isAutoInstall(false);
    $template ->set_isActived(true);
    //$template->set_duration(BEGINTIME,ENDTIME); //设置ANDROID客户端在此时间区间内展示消息

    return $template;
}


/**
 * 创建透传通知
 * @param $p  推送数据内容
 * @return IGtNotificationTemplate
 */
function createTranMessage($p){
    $template =  new IGtTransmissionTemplate();
    $template->set_appId(APPID);//应用appid
    $template->set_appkey(APPKEY);//应用appkey
    $template->set_transmissionType(2);//透传消息类型:1为激活客户端启动
    $template->set_transmissionContent($p);//透传内容
    //$template->set_duration(BEGINTIME,ENDTIME); //设置ANDROID客户端在此时间区间内展示消息

    //当透传消息满足格式{title:'',content:'',payload:''}时兼容支持厂商推送通道
    $jp = json_decode($p, true);
    if(!empty($jp) && !empty($jp['title']) && !empty($jp['content'])){
        $title = $jp['title'];
        $content = $jp['content'];
        $paload = empty($jp['payload'])?'':$jp['payload'];
        $pn = PACKAGENAME;

        $notify = new IGtNotify();
        $notify->set_title($jp['title']);
        $notify->set_content($jp['content']);
        $notify->set_intent("intent:#Intent;action=android.intent.action.oppopush;component={$pn}/io.dcloud.PandoraEntry;S.UP-OL-SU=true;S.title={$title};S.content={$content};S.payload={$payload};end");
        $notify->set_type(NotifyInfo_type::_intent);

        $template->set3rdNotifyInfo($notify);
    }

    return $template;
}



// 创建推送对象
$igt = new IGeTui(HOST,APPKEY,MASTERSECRET);


/**
 * 单推APN接口示例
 * @param $token  推送的客户端APN标识
 * @param $c  推送消息显示的内容
 * @param $p  推送消息的数据内容
 */
function apnMessageToSingle($token,$c,$p){
    global $igt;

    $template = new IGtAPNTemplate();
    //$template ->set_pushInfo($actionLocKey,$badge,$message,$sound,$payload,$locKey,$locArgs,$launchImage);
    $template->set_pushInfo("", 1, $c, "", $p, "", "", "");

    //单个用户推送接口
    $message = new IGtSingleMessage();
    $message->set_data($template);
    $ret = $igt->pushAPNMessageToSingle(APPID, $token, $message);
   return $ret;
}


/**
 * 单推接口示例
 * @param $template: 推送的消息模板
 * @param $cid: 推送的客户端标识
 */
function pushMessageToSingle($template, $cid){
    global $igt;

    //个推信息体
	$message = new IGtSingleMessage();
	$message->set_isOffline(true);//是否离线
	$message->set_offlineExpireTime(3600*72*1000);//离线时间
	$message->set_data($template);//设置推送消息类型
	$message->set_PushNetWorkType(0);//设置是否根据WIFI推送消息，1为wifi推送，0为不限制推送
	//接收方
	$target = new IGtTarget();
	$target->set_appId(APPID);
	$target->set_clientId($cid);
//    $target->set_alias(Alias);

    try {
        $rep = $igt->pushMessageToSingle($message, $target);

    }catch(RequestException $e){
        $requstId =e.getRequestId();
        $rep = $igt->pushMessageToSingle($message, $target, $requstId);
    }
    return $rep;
}


//多推接口案例
function pushMessageToList($template,$cids){
    global $igt;

   // $template = IGtNotificationTemplateDemo();


    //定义"ListMessage"信息体
    $message = new IGtListMessage();
    $message->set_isOffline(true);//是否离线
    $message->set_offlineExpireTime(3600*72*1000);//离线时间
    $message->set_data($template);//设置推送消息类型
   $message->set_PushNetWorkType(0);//设置是否根据WIFI推送消息，1为wifi推送，0为不限制推送，在wifi条件下能帮用户充分节省流量
    $contentId = $igt->getContentId($message);
    $targetList=array();
    foreach ($cids as $value){
        $target1 = new IGtTarget();
        $target1->set_appId(APPID);
        $target1->set_clientId($value);
        $targetList[] = $target1;
    }

    $rep = $igt->pushMessageToList($contentId, $targetList);
    return $rep;
}

function stop($taskid,$cid){
    global  $igt;
  $res=  $igt->cancelContentId($taskid);
 //$req=   pushMessageToSingle($res,$cid);
  return $res;
}


function getRevokeTemplateDemo($taskid){
    $revoke = new IGtRevokeTemplate();
    $revoke->set_appId(APPID);
    $revoke->set_appkey(APPKEY) ;
    $revoke->set_oldTaskId($taskid);
    $revoke->set_force(true);
   // $notify = new IGtNotify();

//    $notify->set_intent($i);
//    $notify->set_type(NotifyInfo_type::_intent);
//    $revoke->set3rdNotifyInfo($notify);
    return $revoke;
}

/**
 * 判断终端是否在线
 * @param $cid: 客户端标识
 */
function isOnline($cid){
    global $igt;

    $status = $igt->getClientIdStatus(APPID,$cid);

    if(is_array($status)&&'Online'==$status['result']){
        return true;
    }
    return false;
}



function IGtNotificationTemplateDemo(){
    $template = new IGtNotificationTemplate();
    $template->set_appId(APPID);                      //应用appid
    $template->set_appkey(APPKEY);                    //应用appkey
    $template->set_transmissionType(1);               //透传消息类型
    //$template->set_transmissionContent("测试离线");   //透传内容
    $template->set_title("请填写通知标题");                     //通知栏标题
    $template->set_text("请填写通知内容");        //通知栏内容
   // $template->set_logo("logo.png");                  //通知栏logo
    //$template->set_logoURL("http://wwww.igetui.com/logo.png"); //通知栏logo链接
    $template->set_isRing(true);                      //是否响铃
    $template->set_isVibrate(true);                   //是否震动
    $template->set_isClearable(true);                 //通知栏是否可清除
//    $template->set_channel("set_channel");
//    $template->set_channelName("set_channelName");
//    $template->set_channelLevel(3);
    //$template->set_notifyId(12345678);
    return $template;
}

// 创建支持厂商通道的透传消息
function createPushMessage($p, $i, $t, $c,$showtitle){
    $template =  new IGtTransmissionTemplate();
    $template->set_appId(APPID);//应用appid
    $template->set_appkey(APPKEY);//应用appkey
    //$template->set_transmissionType(2);//透传消息类型:1为激活客户端启动

    //为了保证应用切换到后台时接收到个推在线推送消息，转换为{title:'',content:'',payload:''}格式数据，UniPush将在系统通知栏显示
    //如果开发者不希望由UniPush处理，则不需要转换为上述格式数据（将触发receive事件，由应用业务逻辑处理）
    //注意：iOS在线时转换为此格式也触发receive事件
    $payload = array('title'=>$t, 'content'=>$c);
    $pj = json_decode($p, TRUE);
    $payload['payload'] = is_array($pj)?$pj:$p;
    $template->set_transmissionContent(json_encode($payload));//透传内容

    //兼容使用厂商通道传输
    $notify = new IGtNotify();
    $notify->set_title($t);
    $notify->set_content($c);
    $notify->set_intent($i);
    $notify->set_type(NotifyInfo_type::_intent);
    $template->set3rdNotifyInfo($notify);


    //iOS平台设置APN信息，如果应用离线（不在前台运行）则通过APNS下发推送消息
    $apn = new IGtAPNPayload();
    $apn->alertMsg = new DictionaryAlertMsg();
    $apn->alertMsg->body = $c;
   // $apn->alertMsg->title=$t;
  if($showtitle!=false) {
      $apn->alertMsg->title=$t;
     // $apn->alertMsg->launchImage='http://www.cj66.net/logo.png';
  }
    $apn->add_customMsg('payload', is_array($pj)?json_encode($pj):$p);//payload兼容json格式字符串

    $template->set_apnInfo($apn);
    //个推老版本接口: $template ->set_pushInfo($actionLocKey,$badge,$message,$sound,$payload,$locKey,$locArgs,$launchImage);
    //$template->set_pushInfo('', 0, $c, '', $p, '', '', '');

    return $template;
}
function IGtStartActivityTemplateDemo($p, $i, $t, $c){
    $template = new IGtNotificationTemplate();

    $template->set_appId(APPID);//应用appid
    $template->set_appkey(APPKEY);//应用appkey
  // $template->set_intent($i);

    $template->set_title($t);//通知栏标题
    $template->set_text($c);//通知栏内容
 //   $template->set_logo("");//通知栏logo
//    $template->set_logoURL("");
    $template->set_isRing(true);//是否响铃
    $template->set_isVibrate(true);//是否震动
    $template->set_isClearable(true);//通知栏是否可清除
    return $template;
// $template->set_channel(90123);
// $template->set_channelName("	推送通知");
//  $template->set_channelLevel(3);
    //$template->set_duration("XXXX-XX-XX XX:XX:XX","XXXX-XX-XX XX:XX:XX");
    //$smsMessage = new SmsMessage();//设置短信通知
    //$smsMessage->setPayload("1234");
    //$smsMessage->setUrl("http://www/getui");
    //$smsMessage->setSmsTemplateId("123456789");
    //$smsMessage->setOfflineSendtime(1000);
    //$smsMessage->setIsApplink(true);
    //$template->setSmsInfo($smsMessage);
//   $template->set_notifyId(90123);
    //兼容使用厂商通道传输4
//    $payload = array('title'=>$t, 'content'=>$c);
//    $pj = json_decode($p, TRUE);
//    $payload['payload'] = is_array($pj)?$pj:$p;
   // $template->set_transmissionContent(json_encode($payload));//透传内容
//    $notify = new IGtNotify();
//    $notify->set_title($t);
//    $notify->set_content($c);
//    $notify->set_intent($i);
//    $notify->set_type(NotifyInfo_type::_intent);
//    $template->set3rdNotifyInfo($notify);


    //iOS平台设置APN信息，如果应用离线（不在前台运行）则通过APNS下发推送消息
//    $apn = new IGtAPNPayload();
//    $apn->alertMsg = new DictionaryAlertMsg();
//    $apn->alertMsg->body = $c;
//    $template->set_apnInfo($apn);
    return $template;
}
?>