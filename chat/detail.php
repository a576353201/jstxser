<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020-3-31
 * Time: 17:06
 */
include_once '../inc/common.php';

$group=GroupInfo($_GET['id'],$_SESSION['userid']);
$is_owner=$group['is_owner'];
$is_manager=$group['is_manager'];
$tags=explode(',',$group['tags']);
$userlist=group_users($group['id']);
$isin=0;
$managenum=0;
if($_SESSION['userid']>0){
    foreach ($userlist as $key=> $value){
        if($value['id']==$_SESSION['userid']){
            $isin=1;

        }
        $row= $db->exec("select * from ".tname('chat')."where groupid='{$group['id']}' and userid='{$value['id']}' and isback='0' and `type`!='tips' order by id desc limit 0,1");
        if(!$row['addtime']) $row['addtime']=0;
        if($value['type']=='manager' or $value['type']=='owner') $managenum++;
        $userlist[$key]['lastime']=$row['addtime'];
    }
    $user=userinfo($_SESSION['userid']);
}
$step=$_GET['step'];
if(!$step) $step=0;
$tags1=explode('|',$system['tags']);


$note=$db->exec("select * from ".tname('group_note')." where group_id='{$_GET['id']}' order by istop desc, id desc limit 0,1");
if($note['id']>0){
    $notecontent=$note['content'];
    if($note['istop']==1) $notecontent="<span class='istop'>置顶</span>".$notecontent;
}else{
    $notecontent='<div style="display:block;text-align:center;color:#999">暂无公告</div>';
}
$db->query("update ".tname('group_note')."   set `view`=`view`+1 where group_id='{$_GET['id']}'");
$list=$db->fetch_all("select * from ".tname('group_note')." where group_id='{$_GET['id']}' order by istop desc, id desc");


if(count($list)>0){
    foreach ($list as $key=>$value){
        $u=userinfo($value['userid']);

        $list[$key]['nickname']=$u['nickname'];
        $uids=unserialize($uids);
        if(!in_array($_SESSION['userid'])){
            $uids[]=$_SESSION['userid'];
        }
        $uids=serialize($uids);
        $list[$key]['view']=count($uids);
        $db->query("update ".tname('group_note')." set uids='{$uids}' where id='{$value['id']}'");
    }

}

if($isin==1){
    $row=$db->exec("select * from ".tname('msgtop')." where userid='{$_SESSION['userid']}' and cache_key='G{$group['id']}'");
    if($row) $msgtop=true;else $msgtop=false;

    $row=$db->exec("select * from ".tname('msgnotip')." where userid='{$_SESSION['userid']}' and cache_key='G{$group['id']}'");
    if($row) $msgnotip=true;else $msgnotip=false;
}

include_once template('chat/detail');