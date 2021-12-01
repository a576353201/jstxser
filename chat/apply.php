<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020-3-31
 * Time: 17:06
 */
include_once '../inc/common.php';

$group=GroupInfo($_GET['id']);


include_once template('chat/apply');
