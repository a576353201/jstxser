<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020-8-13
 * Time: 17:16
 */
include_once '../inc/common.php';
$msg=$db->exec("select * from ".tname('chat')." where id='{$_GET['id']}'");
$sender=userinfo($msg['userid']);
$content=msg_content($msg);
$id=$_REQUEST['id'];
$redpacket=$db->exec("select * from ".tname('readpacket')." where id='{$content['id']}'");
$max=0;
$endtime=0;
if($redpacket['id']>0){
    $userids=unserialize($redpacket['userids']);
    if(count($userids)){
        foreach ($userids as $key=> $value){
            $userinfo=userinfo($value['userid']);

            $userids[$key]['avatar']=$userinfo['avatar'];
            $userids[$key]['nickname']=$userinfo['nickname'];
            if($userids[$key]['time']>$endtime) $endtime=$userids[$key]['time'];
            if($value['money']>$max) $max=$value['money'];
        }
        $res['data']=$userids;

    }else{
        $res['data']=array();
    }
    $res['info']=$redpacket;
}


if($redpacket['isgroup']==1 && $redpacket['status']==2 && $endtime>$redpacket['addtime']){
    $lasttime1=$endtime-$redpacket['addtime'];
    if($lasttime1<60) $lasttime=$lasttime1.'秒';
    else if($lasttime1<3600){
        $lasttime=$lasttime1/60;
        $lasttime.="分";
        if($lasttime%60>0)$lasttime.=number_format($lasttime1%60).'秒';
    }else if($lasttime1<86400){
        $lasttime=number_format($lasttime1/3600).'小时';
        $lasttime1=$lasttime1%3600;
        $lasttime.=number_format($lasttime1/60).'分';
        if($lasttime%60>0) $lasttime.=number_format($lasttime1%60).'秒';
    }
    else{
        $lasttime=number_format($lasttime1/86400).'天';
        $lasttime1=$lasttime1%86400;
        $lasttime.=number_format($lasttime1/3600).'小时';
        $lasttime1=$lasttime1%3600;
        $lasttime.=number_format($lasttime1/60).'分';
        if($lasttime%60>0) $lasttime.=number_format($lasttime1%60).'秒';
    }
}

include_once template('chat/redpacket_detail');