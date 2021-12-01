<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020-4-5
 * Time: 14:52
 */

include_once '../inc/common.php';
$group=GroupInfo($_GET['id'],$_SESSION['userid']);

$is_owner=$group['is_owner'];
$is_manager=$group['is_manager'];


//$db->query("update ".tname('group_note')."   set `view`=`view`+1 where group_id='{$_GET['id']}'");
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


include_once template('chat/note');