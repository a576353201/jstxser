<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020-4-5
 * Time: 14:52
 */

include_once '../inc/common.php';
$group=GroupInfo($_GET['group_id'],$_SESSION['userid']);

if($_GET['id']>0){
    $note=$db->exec("select * from ".tname('group_note')." where id='{$_GET['id']}'");
$action='noteedit';
}else{
$action='noteadd';
}


include_once template('chat/noteadd');