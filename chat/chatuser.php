<?php
include_once '../inc/common.php';
$group=array('id'=>0,'name'=>$system['admin_nickname'],'avatar'=>$system['admin_logo']);
if($group){
    if($_SESSION['userid']>0) set_group_readtime($_SESSION['userid'],$group['id']);


    $msglist=array();
    $timeshow=$timeshow1=0;
    $list = $db->fetch_all("select * from ".tname('chat')." where groupid='0' and ((userid='{$group['id']}' and touid='{$_SESSION['userid']}') or (touid='{$group['id']}' and userid='{$_SESSION['userid']}') ) and isback='0' order by id desc limit 0,100");
    if(count($list)>0){
        for($i=count($list)-1;$i>=0;$i--){
            $item=$list[$i];
            if($item['type']!='tips' && ($item['addtime']-$timeshow>=300 || $item['addtime']-$timeshow1>=900)){
                $msglist[]=array('type'=>'tips','content'=>timestamp($item['addtime']));
                $timeshow=$item['addtime'];
            }
            $timeshow1=$item['addtime'];
             if($item['userid']>0)
            $user=userinfo($item['userid']);
             else {
                 if($item['type']=='apply'){

                     $content=json_decode($item['content'],true);
                     $user=userinfo($content['other']['userid']);
                 } else
                 $user=array('id'=>0,'nickname'=>$system['admin_nickname'],'avatar'=>$HttpPath.$system['admin_logo']);
             }
            $item['user']=array('nickname'=>$user['nickname'],'avatar'=>$user['avatar'],'id'=>$user['id']);
            if($item['userid']==$_SESSION['userid']) $item['self']=1;else $item['self']=0;
            if($item['type']=='apply'){

                $apply=$db->exec("select * from ".tname('group_apply')." where id='{$content['other']['applyid']}'");
          $group1=GroupInfo($apply['group_id']);
                     if(isMobile()){
                         $parent="";
                     }else $parent="parent.";
                $content1="<span class='groupname' onclick='{$parent}user_detail({$item['user']['id']});'>{$item['user']['nickname']}</span>申请加入群：<span class='groupname' onclick='{$parent}group_detail({$apply['group_id']});'>{$group1['name']}</span>";
            //    if($content['other']['content'])
                    $content1.="<div><span style='color: #666'>附言：</span>{$content['other']['content']}</div>";
                if($apply['status']==0){
                    $mark="<div class='btns cancel' onclick='deal_apply({$apply['id']},2)'>拒绝</div>";
                    $mark.="<div class='btns ok' onclick='deal_apply({$apply['id']},1)'>同意</div>";
                    $content1.="<div class='apply' name='apply_{$apply['id']}'>{$mark}</div>";
                }else{
                    if($apply['status']==1) $mark="已同意";else $mark='已拒绝';
                    if($_SESSION['userid']!=$apply['apply_uid']) $mark="其他管理".$mark;
                    $content1.="<div class='applymsg'>{$mark}</div>";

                }

                $item['content']=$content1;
            } else
            $item['content']=msg_content($item);
            $msglist[]=$item;

        }

    }


}

$user=userinfo($_SESSION['userid']);

include_once template('chat/chatuser');
?>