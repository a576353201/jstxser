<?php
include_once '../inc/common.php';
$news=$db->fetch_all("select * from ".tname('news')." where type1='9' order by sortnum asc,id desc");
include_once template('user/news');