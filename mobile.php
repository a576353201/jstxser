<?php

include_once 'inc/common.php';
$system=get_system();
$gamelist=$db->fetch_all("select * from ".tname('game')." where status='1' order by sortnum asc,id asc");
if($_GET['id']){
    $gameid1=$_GET['id'];
    setcookie("gameid1", $gameid1,time()+3600*24*365, "/");
}
else{
    if($_COOKIE['gameid1'])
        $gameid1=$_COOKIE['gameid1'];
    else{
        setcookie("gameid1", $gamelist[0]['id'],time()+3600*24*365, "/");
        $gameid1=$gamelist[0]['id'];
    }

}


$gamejson=json_encode($gamelist);
$shownode=0;
if($_SESSION['userid']>0){
    $note=$db->exec("select * from ".tname('news')." where type1='9'");
    if(!isset($_SESSION['newsshow']) || $_SESSION['newsshow']!=1){

        $note=$db->exec("select * from ".tname('news')." where type1='9'");
        if($note['id']>0){
            $shownode=1;
            $_SESSION['newsshow']=1;
        }
    }

}
$gamenav=array();
foreach ($game_type_arr as $key=>$value) {
    $list1 = $db->fetch_all("select * from " . tname('game') . " where status='1' and `type`='{$key}' order by sortnum asc");

    if(count($list1)){
        $gamenav[$key]=array();
        foreach ($list1 as $key1=>$value1){
            $gamenav[$key][]=$value1;
        }
    }

}

include_once template('index');
?>
