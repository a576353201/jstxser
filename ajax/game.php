<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/3/3
 * Time: 18:42
 */

include_once '../inc/common.php';

$gamekey=$_POST['gamekey']?$_POST['gamekey']:$_GET['gamekey'];
$action=$_POST['action']?$_POST['action']:$_GET['action'];
if($action=='number'){

$game_number=game_number($gamekey);
unset($game_number['id']);
$game_time=get_now_period($gamekey);
    $game_time['timestamp']=strtotime($game_time['end']);
$game_time['opentime']=date('Y-m-d H:i:s',$game_time['timestamp']);
$game_number['opencode']= json_encode(explode(',',$game_number['number']));
$game_number['opentime']=date('Y-m-d H:i:s',$game_number['lottime']);
$game_time['lastnumber']=$game_number;
echo json_encode($game_time);

    exit();
}

