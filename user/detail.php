<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020-3-31
 * Time: 17:06
 */
include_once '../inc/common.php';
$issetname=$user['issetname'];
$user=userinfo($_GET['id'],$_SESSION['userid']);

if($_GET['group_id']>0){

    $group=GroupInfo($_GET['group_id'],$_GET['id']);
    if($_GET['id']==$group['createid']){

        $jointime=date('Y-m-d H:i:s',$group['addtime']);
    }else{
        $group_users=group_users($_GET['group_id']);
        if(count($group_users)>0){

            foreach ($group_users as $value){
                if($value['id']==$_GET['id']){

                    $jointime=date('Y-m-d H:i:s',$value['jointime']);
                }
            }
        }
    }

    $fromtime=time()-7*24*3600;
   $chat= $db->exec("select * from ".tname('chat')." where userid='{$_GET['id']}' and groupid='{$_GET['group_id']}' and isback='0' and addtime>='{$fromtime}' order by id desc limit 0,1");
   if($chat['id']>0){
       $chattime=date('Y-m-d H:i:s',$chat['addtime']);
   }
   else $chattime='七天前';
   $fromgroup=1;
   $myinfo==GroupInfo($_GET['group_id'],$_SESSION['userid']);

}
else{
    $group=array();
    $fromgroup=0;
}
if ($user['isvip']==1){
    $rate1=$rate2=0;
    $row=  $db->exec("select max(rate) as rate from ".tname('plan')." where userid='{$_GET['id']}' and updatetime>='{$fromtime1}'");
    $rate1=$row['rate'];
    if(!$rate1)$rat1e=0;
     $rate2=$user['rate'];
    $gameshow='';
    $sql="SELECT gamekey,sum(prize_num)/sum(plantimes) FROM ".tname('plan')." where  userid='{$user['id']}'  group by gamekey order by sum(prize_num)/sum(plantimes)  desc limit 0,3";
    $temp1=$db->fetch_all($sql);

    if(count($temp1)>0){
        foreach ($temp1 as $value){
            $row=$db->exec("select * from ".tname('game')." where showkey='{$value['gamekey']}'");
            if($row['id']>0)
            $gameshow.="<span style='padding: 0px 2px;'>".$row['title']."</span>";
        }
    }

    $tags='';
    $sql="SELECT wf1,sum(prize_num)/sum(plantimes) FROM ".tname('plan')." where userid='{$user['id']}' group by wf1 order by sum(prize_num)/sum(plantimes)  desc limit 0,3";
     $wanfa=$db->fetch_all($sql);
     if(count($wanfa)>0){
         foreach ($wanfa as $value){
            $tags.="<span>".$wanfa_arr['ssc'][$value['wf1']]."</span>";
         }
     }
}
$isuseraction=0;
if($_SESSION['userid']>0 && $user['isvip']==1){
    $row=  $db->exec("select * from ".tname('user_action')." where userid='{$_SESSION['userid']}' and touid='{$user['id']}'");
    if($row['id']>0) $isuseraction=1;

}

$row=$db->exec("select * from ".tname('msgtop')." where userid='{$_SESSION['userid']}' and cache_key='U{$user['id']}'");
if($row) $msgtop=true;else $msgtop=false;

$row=$db->exec("select * from ".tname('msgnotip')." where userid='{$_SESSION['userid']}' and cache_key='U{$user['id']}'");
if($row) $msgnotip=true;else $msgnotip=false;

include_once template('user/detail');