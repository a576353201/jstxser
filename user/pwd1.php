<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020-3-28
 * Time: 20:45
 */
include_once '../inc/common.php';
$pwdname='登录';
$step=$_GET['step'];
if(!$step) $step=0;

include_once template('user/pwd1');