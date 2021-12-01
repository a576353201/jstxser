<?php
include_once '../inc/common.php';

$group=GroupInfo($_GET['id'],$_SESSION['userid']);
$url=$HttpPath.'chat/detail.php?from=qrcode&id='.$_GET['id'];

$logo=$group['avatar'];

$path=qr_creat($url);
include_once template('chat/qrcode');