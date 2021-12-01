<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020-8-13
 * Time: 12:22
 */
include_once '../inc/common.php';
$msg=$db->exec("select * from ".tname('chat')." where id='{$_GET['id']}'");
$sender=userinfo($msg['userid']);

$content=msg_content($msg);

include_once template('chat/redpacket_open');