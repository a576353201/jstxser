<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/3/2
 * Time: 16:56
 */

include_once '../inc/common.php';
$num=3;


$arr['status']='false';
$ok=3;
if($ok==$num){

    if($_GET['type']=='lottery_add'){
        if($_GET['playkey']){

            $nowtime=date("H:i:s");

            $game_type=$db->exec("select * from ".tname('game')." where showkey='{$_GET['playkey']}'");


            if($game_type) {
                lottory_insert($_GET['playkey'] ,$_GET['period'] ,$_GET['number'],$_GET['opentime']);
                $arr['status']='true';
                $arrs=explode('-',$_GET['period']);
                $num=$arrs[1];
               // echo $num.'|';
//                if($num){
//                    $row=$db->exec("select * from ".tname('game_time')." where gamekey='{$_GET['playkey']}' and endtime>='{$nowtime}' order by endtime asc limit 0,1");
//
//                    if($num==$row['num']-1) $arr['time']=strtotime($row['endtime'])-time();
//                    else $arr['time']=rand(1,2);
//
//                }else{
//                    $arr['time']=5;
//                }


                $arr['time']=rand(1,2);
           if(date('Y')==0 and date('i')<10) clear_lottery();


            }
            else {
                $arr['status']='false';
                $arr['time']='3600';
            }
        }
        else $arr['status']='false';
    }
    else $arr['status']='false';
}
else $arr['status']='false';

echo $arr['status'].'|'.$arr['time'];