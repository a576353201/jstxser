<?php

include_once 'inc/common.php';


$nav_index=1;
$news=1;

$content=get_textarea($system[$_GET['type']]);
if($_GET['type']=='news_content')  $web_title=$system['news_title'];

else $web_title='关于我们';



include_once template('news_show');
?>
