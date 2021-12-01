<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020-8-12
 * Time: 15:51
 */
include_once '../inc/common.php';
$group_id=$_GET['group_id'];
$userid=$_GET['userid'];
$words=explode('|',$system['logout_words']);
include_once template('chat/logout');