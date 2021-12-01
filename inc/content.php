<?php


$banner=$db->fetch_all("select * from ".tname('flash')." where `index`='1' and src!='' order by num asc");


$menu=$db->fetch_all("select * from ".tname('menu')." where pid='0' order by sortnum asc,id asc");

$task_list=array();
for($i=0;$i<3;$i++){

if($i>=0) $str=" and `status`='{$i}' ";
else $str='';
	$task_list[$i]=$db->fetch_all("select * from ".tname('task')." where  id>0 {$str} order by id desc limit 0,3");


}


$user_list=array();
for($i=1;$i<=3;$i++){

if($i>=0) $str=" and `group`='{$i}' ";
else $str='';
	$user_list[$i]=$db->fetch_all("select * from ".tname('user')." where  id>0 and `status`=1 and agree=1 {$str} order by view desc limit 0,4");


}

$new_top=$db->exec("select * from ".tname('news')." where `status`='1' and (content like '%<img%' ) order by sortnum asc,clicknum desc,addtime desc limit 0,1");

$news_list=$db->fetch_all("select * from ".tname('news')." where `status`='1' and type1='5'  order by sortnum asc,addtime desc limit 0,3");

//print_r(getImgSrc($new_top['content']));

?>