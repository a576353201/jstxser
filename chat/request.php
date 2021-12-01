<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020-7-10
 * Time: 15:46
 */
include_once '../inc/common.php';


set_readtime($_SESSION['userid'],'U1');
$fromtime=time()-7*24*3600;
$page=$_REQUEST['page']?$_REQUEST['page']:1;
$from=($page-1)*50;
$userid=$_SESSION['userid'];
$str="group_id in (select id from ".tname('group')." where (createid='{$userid}' or manager_id like '%{$userid}%') ) and addtime>='{$fromtime}' ";
$sql="select * from ".tname('group_apply')." where {$str}  order by addtime desc limit {$from},50";
$grouplist=   $db->fetch_all($sql);

if(count($grouplist)>0) {
    $data=array();
    foreach ($grouplist as $key=>$value){


        $value['content1']=unserialize($value['content']);
        $user=userinfo($value['userid']);
        $value['user']=array('id'=>$user['id'],'nickname'=>$user['nickname'],'avatar'=>$user['avatar']);
        $group=GroupInfo($value['group_id'],$value['userid']);
        $value['group']=array('id'=>$group['id'],'nickname'=>$group['nickname'],'avatar'=>$group['avatar']);
        $data[]=$value;
    }
    $grouplist=arr_format($data);
}else $grouplist=[];


$sql="SELECT * FROM app_request where touid='{$_SESSION['userid']}'  and del_uids not like '%@{$_SESSION['userid']}@%' order by id desc limit {$from},50";
$row=$db->fetch_all($sql);
$data=array();
if(count($row)>0){
    foreach ($row as $key=>$value){
        $user=userinfo($value['userid']);
        $row[$key]['nickname']=$user['nickname'];

        if(strpos($user['avatar'],'http')!==false) {

        }else{
            $user['avatar']=$HttpPath.$user['avatar'];
        }
        $row[$key]['user']=array('id'=>$user['id'],'nickname'=>$user['nickname'],'avatar'=>$user['avatar']);
        $row[$key]['mark']=unserialize($value['mark']);
        if($value['from']) $row[$key]['fromname']=friend_addmethod($value['from']);
        $db->query("update app_request set `read`='1'  where id='{$value['id']}' ");
    }
    $friendlist=$row;
}
else {
    $friendlist=array();
}
$act=0;
if(count($grouplist)>0 and (count($friendlist)<1 ||  $grouplist[0]['addtime']>$friendlist[0]['addtime'])) $act=1;

include_once template('chat/request');