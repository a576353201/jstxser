<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/3/2
 * Time: 17:20
 */

function lottery_table($gamekey){
    $gamekey=strtolower($gamekey);
    return tname('lottery_'.$gamekey);
}

//插入开奖结果

function lottory_insert($gamekey,$period,$number,$opentime=''){
    global $db;


        $row=$db->exec("select * from ".lottery_table($gamekey)." where period='{$period}'");
        if(!$row){
              $addtime=time();
            $lottime=strtotime($opentime);
            $sql="insert into ".lottery_table($gamekey)."(period,`number`,addtime,lottime) values('{$period}','{$number}','{$addtime}','{$lottime}')";

            $db->query($sql);

            $id=$db->insert_id();

            return $id;
        }



    return false;
}


function check_id($id){
    global $db;
    $uu= $db->exec("select * from ".tname('user')." where (id='{$id}' or  `number`='{$id}' or name='{$id}'  or mobile='{$id}')");
    if($uu['id']>0) return true;
    else return false;
}

function rand_uid(){
    global $db;
    $id=rand(10000,99999);
    if(check_id($id)) return rand_uid();
    else return $id;
}

function rand_groupid(){
    global $db;
    $id=rand(100000,999999);
    $row= $db->exec("select * from ".tname('group')." where id='{$id}'");
    if($row['id']>0) return rand_groupid();
    else return $id;
}
function list_file($date){
    //1、首先先读取文件夹
    $temp=scandir($date);
    //遍历文件夹
    $res=array();
    foreach($temp as $v){

        $a=$date.'/'.$v;
        if(is_dir($a)){
        }else{
            //echo $a,"<br/>";
            $res[]=str_replace('../','',$a);
        }

    }
    return $res;
}


function  file_write($filename,$content){


    if (file_exists($filename) ){unlink($filename);}
    $file_pointer = fopen($filename,"a+");

    fwrite($file_pointer,$content);
    fclose($file_pointer);

}


/**
 *
 */
function rewardlist($fromtype=''){
    global  $db,$system;
    $icon=array('icon-speaker-5','icon-thumbs-up');
    $res=array();
  $list=  $db->fetch_all("select * from ".tname("plan_buy")." order by id desc limit 0,20");
  if(count($list)>0){
      foreach ($list as $value){
          $plan=plan_detail($value['plan_id']);
          $user=userinfo($value['userid']);
          $res[]="<i class='{$icon[0]}'></i><span class='name'>{$user['nickname']}</span> 购买了<span class='name'>{$plan['showtitle']}</span>";
      }
  }
    $list=  $db->fetch_all("select * from ".tname("plan_reward")." order by id desc limit 0,20");

    if(count($list)>0){
        foreach ($list as $value){
            $from=userinfo($value['from_uid']);
            $to=userinfo($value['to_uid']);
            if($value['money']>=50)
                $res[]="<i class='{$icon[1]}'></i><span class='name'>{$from['nickname']}</span>真是太土豪了，竟然打赏了<span class='name'>{$to['plan_title']}</span><span class='money'>{$value['money']}</span>元";
                else
            $res[]="<i class='{$icon[1]}'></i><span class='name'>{$to['plan_title']}</span>收到了<span class='name'>{$from['nickname']}</span>的<span class='money'>{$value['money']}</span>元打赏";
        }
    }

    $list=explode("\n",$system['plan_notes']);
    if(count($list)>0){
        foreach ($list as $value){
            $res[]="<i class='{$icon[1]}'></i>".$value;
        }
    }
    shuffle($res);

    if($fromtype=='app') return $res;
    else {
        $html='';
        if(count($res)>0){
            foreach ($res as $key=>$value){
                if($key==0) $html.="<li class='active'>{$value}</li>";
                else $html.="<li >{$value}</li>";
            }

        }

        return $html;
    }


}



function BetweenDays ($time1, $time2)
{

    if ($time1 < $time2) {
        $tmp = $time2;
        $time2 = $time1;
        $time1 = $tmp;
    }


    $time1=strtotime(date('Y-m-d',$time1)." 00:00:00");
    $time2=strtotime(date('Y-m-d',$time2)." 00:00:00");

    return ($time1 - $time2) / 86400;
}

//获取当前开奖期号
function get_now_period($gamekey,$plan=0){
    global $db;
    if($plan==0) game_plan_code($gamekey);
    $game=$db->exec("select * from ".tname('game')." where showkey='{$gamekey}'");

    $nowtime=date('H:i:s');

    $sql="select count(*) as num from ".tname('game_time')." where gamekey='{$gamekey}' ";
    $row=$db->exec($sql);
    $sum=$row['num'];
    $sql="select * from ".tname('game_time')." where gamekey='{$gamekey}' order by num asc limit 0,1 ";
    $row=$db->exec($sql);
    $fristtime=$row['endtime'];
    $sql="select * from ".tname('game_time')." where gamekey='{$gamekey}' order by num desc limit 0,1 ";
    $row=$db->exec($sql);
    $lasttime=$row['endtime'];
    $period='';
    $lastsecond=0;
    $stoptime=0;
    $lotNum=0;
    $return=array();

    if($fristtime<=$lasttime){
        if($nowtime>=$lasttime) $num=$sum;
        else {
            $row= $db->exec("select count(*) as num from ".tname('game_time')." where gamekey='{$gamekey}' and endtime<'{$nowtime}' ");
            $num=$row['num'];
        }
        //今日已开

        $game_time= $db->exec("select * from ".tname('game_time')." where gamekey='{$gamekey}' and endtime>='{$nowtime}' order by num asc limit 0,1");
        if($game_time['num']>0){
            //今日未结束
            $period=date('Ymd',time()).'-'.$game_time['num'];
            $lastsecond=strtotime(date('Ymd',time()).' '.$game_time['endtime'])-time();
            $lotNum=$game_time['num'];
            $return['begin']=$game_time['begintime'];
            $return['end']=$game_time['endtime'];


        }
        else{
//今日已结束

            $game_time= $db->exec("select * from  ".tname('game_time')."  where gamekey='{$gamekey}' order by num asc limit 0,1");
            $period=date('Ymd',time()+24*3600).'-'.$game_time['num'];
            $lastsecond=strtotime(date('Y-m-d',time()+24*3600).' '.$game_time['endtime'])-time();
            $lotNum=$game_time['num'];
            $return['begin']=$game_time['begintime'];
            $return['end']=$game_time['endtime'];


        }
        $game_time_frist= $db->exec("select * from  ".tname('game_time')."  where gamekey='{$gamekey}'  order by num asc limit 0,1");
        $game_time_end= $db->exec("select * from  ".tname('game_time')."  where gamekey='{$gamekey}'  order by num desc limit 0,1");
        $return['frist_end']=$game_time_frist['endtime'];
        $return['last_end']=$game_time_end['endtime'];
        //计算上一期开奖期号
        if($num==0 or time()<strtotime($game_time_frist['endtime'])){
            $game_time= $db->exec("select * from  ".tname('game_time')."  where gamekey='{$gamekey}'  order by num desc limit 0,1");

            $pre_period=date('Ymd',time()-24*3600).'-'.$game_time['num'];


        }else if($num==$sum){

            $game_time= $db->exec("select * from  ".tname('game_time')."  where gamekey='{$gamekey}'  order by num desc limit 0,1");
            $pre_period=date('Ymd',time()).'-'.$game_time['num'];
        }

        else{

            if(strpos($period,'-')!==false){
                $arr=explode('-',$period);
                $num1=$arr[1]-1;
                $len=strlen($arr[1]);
               $num1= sprintf("%0{$len}d",$num1);
                $pre_period=$arr['0'].'-'.$num1;
            }
            else
            $pre_period=$period-1;
        }


    }
    else{
        $game_time_frist= $db->exec("select * from  ".tname('game_time')."  where gamekey='{$gamekey}'  order by num asc limit 0,1");
        $game_time_end= $db->exec("select * from  ".tname('game_time')."  where gamekey='{$gamekey}'  order by num desc limit 0,1");
        $return['frist_end']=$game_time_frist['endtime'];
        $return['last_end']=$game_time_end['endtime'];

        if(strtotime($nowtime)<strtotime($fristtime) and strtotime( $nowtime)>strtotime($lasttime)) {

            $num=0;

            $period=date('Ymd',time()).'-'.$game_time_frist['num'];
            $lastsecond=strtotime(date('Ymd',time()).' '.$game_time_frist['endtime'])-time();
            $lotNum=$game_time_frist['num'];
            $return['begin']=$lasttime;
            $return['end']=$game_time_frist['endtime'];
        }
          else{


              $game_time= $db->exec("select * from ".tname('game_time')." where gamekey='{$gamekey}' and endtime>='{$nowtime}' and begintime<'{$nowtime}' order by num desc limit 0,1");
               if($game_time['num']>0){


               }
               else{

                   if(date('H',time())==23){

                       $sql="select * from ".tname('game_time')." where gamekey='{$gamekey}' and begintime<'{$nowtime}' order by begintime desc limit 0,1";
                   }else {
                       $sql="select * from ".tname('game_time')." where gamekey='{$gamekey}' and endtime>='{$nowtime}' order by endtime asc limit 0,1";

                   }

                   $game_time= $db->exec($sql);

               }


              $num=$game_time['num']-1;
             if($nowtime<$lasttime)
                 $period=date('Ymd',time()-24*3600).'-'.$game_time['num'];
                 else
              $period=date('Ymd',time()).'-'.$game_time['num'];
              $lastsecond=strtotime(date('Ymd',time()).' '.$game_time['endtime'])-time();
              $lotNum=$game_time['num'];
              $return['begin']=$game_time['begintime'];
              $return['end']=$game_time['endtime'];

        }


        //计算上一期开奖期号
        if($num==0 ){
            $game_time= $db->exec("select * from  ".tname('game_time')."  where gamekey='{$gamekey}'  order by num desc limit 0,1");

            $pre_period=date('Ymd',time()-24*3600).'-'.$game_time['num'];


        }
        else{
            if(strpos($period,'-')!==false){
                $arr=explode('-',$period);
                $num1=$arr[1]-1;
                $len=strlen($arr[1]);
                $num1= sprintf("%0{$len}d",$num1);
                $pre_period=$arr['0'].'-'.$num1;
            }
            else
                $pre_period=$period-1;
        }



    }





    if($gamekey=='bjk3'){
        $start=strtotime('2018-07-25 08:57:33');
        $BetweenDays=BetweenDays(time(),$start);
        if(time()>strtotime(date('Y-m-d').' 23:47:33')){
            $BetweenDays++;
            $sec=0;
        }
        else{
            $sec=floor((time()-strtotime(date('Y-m-d').' 08:57:33'))/600);
            if($sec<0) $sec=0;

        }
        //echo $sec."<br>";
        $period=115687+($BetweenDays)*89+$sec;
        $pre_period=$period-1;
        //echo strtotime('2016-12-18 09:00:00')."<br>";
    }

    //特殊开奖期号重新处理
    if($gamekey=="3D" or $gamekey=="P5(P3)"  or $gamekey=="PL3" or   strpos($gamekey, 'KL8')!==false or  $gamekey=="bjpk10" or $gamekey=='pcdd' or $gamekey=='bjkl8'or $gamekey=='F1' or $gamekey=='jssc' or $gamekey=='azxy10' ){




        if($gamekey=='bjpk10'){
            $start=strtotime('2019-02-15 09:10:00');
            $BetweenDays=BetweenDays(time(),$start);
            if(time()>strtotime(date('Y-m-d').' 23:50:00')){
                $BetweenDays++;
                $sec=-1;
            }
            else{
                if(time()<strtotime(date('Y-m-d').' 09:30:00',time()))
                    $sec=-1;
                else{
                    $sec=floor((time()-strtotime(date('Y-m-d').' 09:30:00',time()))/1200);
                }

               // if($sec<0) $sec=0;

            }
            //echo $sec."<br>";
            $period=729569+($BetweenDays)*44+$sec;
        }

        if($gamekey=='pcdd'){
            $start=strtotime('2019-03-02 09:00:00');
            $BetweenDays=BetweenDays(time(),$start);
            if(time()>strtotime(date('Y-m-d').' 23:55:00')){
                $BetweenDays++;

                $sec=0;
            }
            else{
                $sec=floor((time()-strtotime(date('Y-m-d').' 09:00:00'))/300);
                if($sec<0) $sec=0;

            }
            //echo $sec."<br>";
            $period=938770+($BetweenDays)*179+$sec;
        }

        if($gamekey=='bjkl8'){
            $start=strtotime('2019-03-04 09:00:00');
            $BetweenDays=BetweenDays(time(),$start);
            if(time()>strtotime(date('Y-m-d').' 23:55:00')){
                $BetweenDays++;
                $sec=0;
            }
            else{


                $sec=floor((time()-strtotime(date('Y-m-d').' 09:00:00'))/300);
                if($sec<0) $sec=0;

            }

            $period=939128+($BetweenDays)*179+$sec;

        }

        if($gamekey=='F1'){
            $start=strtotime('2019-03-24 14:52:00');
            $sec=floor((time()-$start)/300);
            $period=216319372+$sec;
        }

        if($gamekey=='jssc'){
            $start=strtotime('2019-03-24 16:48:00');
            $sec=floor((time()-$start)/75);
            $period=31008120+$sec;
        }

        if($gamekey=='azxy10'){
            $start=strtotime('2019-03-25 11:13:40');
            $sec=floor((time()-$start)/300);
            $period=20573173+$sec;
        }
//

        if($gamekey=='JNDKL8'){
//	$lotpriod++;
            if(time()>strtotime(date('Y-m-d').' 21:00:00'))$period++;
        }
        if(strpos($period,'-')!==false){
            $arr=explode('-',$period);
            $num1=$arr[1]-1;
            $len=strlen($arr[1]);
            $num1= sprintf("%0{$len}d",$num1);
            $pre_period=$arr['0'].'-'.$num1;
        }
        else
            $pre_period=$period-1;



    }
    if($lastsecond<0)
        $lastsecond=strtotime(date('Ymd',time()+24*3600).' '. $return['end'])-time();
 //   $period=str_replace(date('Ymd'),date('Ymd').'-',$period);
    $arr=array('gamekey'=>$gamekey,'period'=>$period,'lastsecond'=>$lastsecond,'stoptime'=>$stoptime,'num'=>$num,'sum'=>$sum,'pre_period'=>$pre_period,'lotnum'=>$lotNum);

    return array_merge($arr,$return);

}

function plan_delete($id){
    global $db;
    $plan=plan_detail($id,'list');
    $list=  $row=$db->fetch_all("select * from ".tname('plan_action')." where plan_id='{$id}'");
    if(count($list)>0){
        foreach ($list as $value){
            add_note(0,$value['uid'],"你收藏的计划[<span style=\"color: #2319dc\">{$plan['showtitle1']}</span>]已被计划员删除，请关注其他计划");
        }
    }
    $db->query("delete from ".tname('plan_action')." where plan_id='{$id}' ");
    $db->query("delete from ".tname('plan_view')." where plan_id='{$id}' ");
    $db->query("delete from ".tname('plan')." where id='{$id}' ");
 //   $db->query("delete from ".tname('plan_reward')." where plan_id='{$id}' ");

}


function game_planinfo($gamekey,$plan_id=0,$userid=''){
   global $db,$system;
   if($userid=='')$userid=$_SESSION['userid'];
    $task=unserialize($system['plan_task']);

    $game=$db->exec("select * from ".tname('game')." where showkey='{$gamekey}'");
    if($game['id']>0){

        $period= get_now_period($game['showkey']);
        $max_num=$period['sum']-$period['num'];
        $qi_num=$max_num;
        if($qi_num>20) $qi_num=20;
       // else if($qi_num<10) $qi_num=10;
        $qi_arr=array();
        //总期号
       // $max_num=100;
        $user=userinfo($userid);
        if($max_num>$task[$user['plan_grade']]['addmax']) $max_num=$task[$user['plan_grade']]['addmax'];
         if($plan_id>0){
             $planinfo=plan_info($plan_id);
             $method=$planinfo['method'];
             $status=$planinfo['status'];
             if($status==1){
                 if($method==2){
                     $max_num=$max_num+$planinfo['donum']-count(json_decode($planinfo['content'],true));

                 }else{
                     $max_num=$max_num+$planinfo['plantimes']-$planinfo['expect_sum'];
                 }

             }


         }
        $plan_num=array();
        $i=1;
        while ($i<=$max_num){
            $plan_num[]=$i;
            if($i<10 or $plan_id>0)$i++;
            else if($i<50) $i=$i+5;
            else $i=$i+10;
        }
        if($max_num<1) $plan_num[]=0;

        $expect=explode('-',$period['period']);
     //$qi_num=60;
        for($i=0;$i<$qi_num;$i++){
            $len=strlen($expect[1]);
            $max=$expect[1]+$i;
            if($max>$period['sum']) {
                $max=$max_num-$max;
                 $day=date('Ymd',time()+24*3600);
            }else{
               $day=$expect[0];
            }
            $num1= sprintf("%0{$len}d",$max);
            $qi_arr[]=$day.'-'.$num1;
        }
        $lottery=$db->fetch_all("select period,number from ".lottery_table($gamekey)." where period<'{$period['period']}' order by period desc limit 0,100");

        return array('id'=>$game['id'],'period'=>$period,'qi_arr'=>$qi_arr,'plan_num'=>$plan_num,'lottery'=>json_encode($lottery),'addmax'=>$max_num);
    }else{
        return false;
    }
}

/**
 * @param $gamekey
 */
function game_number($gamekey){

    global  $db;
    $now=time();
   return  $db->exec("select * from ".lottery_table($gamekey)." where lottime<='{$now}' order by period desc limit 0,1");


}


function get_game_next_time($gamekey){
    global  $db;
    $now=date('H:i:s',time());
    $db->exec("select * from ".tname('game_time')." where gamekey='{$gamekey}' and endtime>='{$now}' order by endtime asc ");

}


function game_info($gamekey){
    global  $db;

    return $db->exec("select * from ".tname('game')." where showkey='{$gamekey}'");

}
function abs1($num){

    if($num<0) return -$num;
    else return $num;
}
function arr_cha($arr) {
    $min = 1000000;
    $max = 0;

    for($i = 1; $i <=count ( $arr )-1; $i ++) {

        for($j = 0; $j < $i; $j ++) {
            if (abs1 ( $arr [$i] - $arr [$j] ) < $min)
                $min = abs1 ( $arr [$i] - $arr [$j] );
            if (abs1 ( $arr [$i] - $arr [$j] ) > $max)
                $max = abs1 ( $arr [$i] - $arr [$j] );

        }
    }
    // print_r($arr);exit();
    return array ($min, $max );
}
function arr_min($arr){
    $min=9999999;
    foreach ($arr as $value){
        if($value<$min) $min=$value;
    }
    return $min;
}

function arr_max($arr){
    $min=-999999;
    foreach ($arr as $value){
        if($value>$min) $min=$value;
    }
    return $min;
}
function arr_long($arr){
   $max=arr_max($arr);
   if($max>0){
       $sum=0;
       foreach ($arr as $value){
          if($value>0) $sum+=$value;
       }
       return $sum;
   }
   else return $max;



}

function lottery_dongtai($gamekey,$pos){
    global $db;
    $res=array();
    $lottery=$db->fetch_all("select * from ".lottery_table($gamekey)." order by id desc limit 0,100");

    $number=explode(',',$lottery[0]['number']);
    $res['last']=array($number[$pos]);


    $arr_yl=array();
    $arr_times=array();

    for($i=0;$i<=9;$i++){
        $arr_yl[$i]=1000;
        $arr_times[$i]=0;
    }

    foreach ($lottery as $key=>$value){
        $number=explode(',',$value['number']);
        $number=$number[$pos];
        for($i=0;$i<=9;$i++){
            if($number==$i){
                $arr_times[$i]++;
                if($arr_yl[$i]=1000)$arr_yl[$i]=$key;
            }
        }
    }
    $max=0;
    $miss=array();
    foreach ($arr_yl as $key=>$value){
        if($value>$max)$max=$value;
    }
    foreach ($arr_yl as $key=>$value){
        if($value==$max)$miss[]=$key;
    }
    $max=0;
    $min=1000;
    $hot=array();
    $cloud=array();
    foreach ($arr_times as $key=>$value){
        if($value>$max)$max=$value;
        if($value<$min) $min=$value;
    }
    foreach ($arr_times as $key=>$value){
        if($value==$max)$hot[]=$key;
        if($value==$min)$cloud[]=$key;
    }
    $res['miss']=$miss;
    $res['hot']=$hot;
    $res['cloud']=$cloud;

    return $res;
}

function lot_type($i_array){
    $lot_a=$i_array[0];$lot_b=$i_array[1];$lot_c=$i_array[2];

    $cha=arr_cha($i_array);

    if($lot_a-$lot_b==0 and $lot_b-$lot_c==0){$re_value="豹子";}
    else if($lot_b-$lot_a==0 or $lot_c-$lot_b==0 or $lot_c-$lot_a==0){$re_value="对子";}
    else if($cha[0]==$cha[1] and $cha[0]==1){$re_value="顺子";}
    else if( $cha[0]==1 and $cha[1]>1){$re_value="半顺";}
    else $re_value="杂六";

    return $re_value;
}

function lot_type2($i_array){
    $lot_a=$i_array[0];$lot_b=$i_array[1];$lot_c=$i_array[2];

    if($lot_a-$lot_b==0 and $lot_b-$lot_c==0){$re_value="豹子";}
    else if($lot_b-$lot_a==0 or $lot_c-$lot_b==0 or $lot_c-$lot_a==0){$re_value="组三";}

    else $re_value="组六";

    return $re_value;
}

function lot_typek3($i_array){
    $lot_a=$i_array[0];$lot_b=$i_array[1];$lot_c=$i_array[2];

    $cha=arr_cha($i_array);

    if($lot_a-$lot_b==0 and $lot_b-$lot_c==0){$re_value="三同号";}
    else if($lot_b-$lot_a==0 or $lot_c-$lot_b==0 or $lot_c-$lot_a==0){$re_value="二同号";}
    else $re_value="三不同";

    return $re_value;
}

function lot_typepcdd($i_array){
    $lot_a=$i_array[0];$lot_b=$i_array[1];$lot_c=$i_array[2];

   $sum=$lot_a+$lot_b+$lot_c;
   $green=array('1','4','7','10','16','19','22','25');
    $blue=array('2','5','8','11','17','20','23','26');
    $red=array('3','6','9','12','15','18','21','25');
    if(in_array($sum,$green)) return 'green';
    else if(in_array($sum,$blue)) return 'blue';
    else if(in_array($sum,$red)) return 'red';
    else return 'grey';
}
function trend_number($gamekey,$period=30,$date='', $filter=0){
    global  $db;
    $now=time();
    $sql="select * from ".lottery_table($gamekey)." where lottime<='{$now}' ";
    if($filter==2 or $filter==3) {
        $game_time=get_now_period($gamekey);
        $game_number=game_number($gamekey);
        if($game_time['pre_period']==$game_number['period']){
            $now_period=$game_time['period'];
        }else{
            $now_period=$game_time['pre_period'];
        }

        if($filter==2)
            $qi=substr($now_period,strlen($now_period)-2,2);
        if ($filter==3)  $qi=substr($now_period,strlen($now_period)-1,1);
        $sql.=" and period like '%{$qi}'";

    }
    if( $filter==4){
        $game_time=get_now_period($gamekey);
        $game_number=game_number($gamekey);
        if($game_time['pre_period']==$game_number['period']){
            $time=strtotime($game_time['end']);
        }else{
            $time=strtotime($game_time['begin']);
        }
        $sql.=" and ( ";
        for($i=1;$i<$period;$i++){
            $lot=$time-86400*$i;

            if($i>1) $sql.=" or ";
            $sql.="  lottime='{$lot}' ";
        }
        $sql.=" ) ";

    }
    if($filter==5){
        $sql.=" and (period like '%1' or period like '%3' or  period like '%5' or period like '%7' or  period like '%9')";
    }
    if($filter==6){
        $sql.=" and (period like '%0' or period like '%2' or  period like '%4' or period like '%6' or  period like '%8')";
    }
    if($period>0  and strpos($period,'db')===false){

        $sql.=" order by period desc ";
        $sql.=" limit 0,{$period}";
    }
    else{
        if(strpos($period,'db')!=false){
            $num=substr($period,0,1);
            $date=date('Y-m-d',time()-$num*86400);
        }


        $game_time=get_now_period($gamekey);
        if($game_time['frist_end']<$game_time['last_end']){
            $fromtime=strtotime($date.' 00:00:00');
        }
        else{
            $fromtime=strtotime($date.' '.$game_time['frist_end']);
        }

        $totime=$fromtime+24*3600;
        $sql.=" and lottime>='{$fromtime}' and lottime<'{$totime}' ";
        $sql.=" order by period desc ";
    }
return   $db->fetch_all($sql);
}



function trend_pk10($gamekey,$period=30,$date='', $filter=0, $pos=1, $from=1){



    $list=array();
    $arr_old=array();
    $number_list= trend_number($gamekey,$period,$date,$filter);
    if(count($number_list)>0) {
        foreach ($number_list as $key => $value) {
            $arr=array();
            $arr['expect']=$value['period'];
            $arr['opentime']=$value['lottime'];
            $number=explode(',',$value['number']);
            if($pos==1){

                foreach ($number as $k=>$v){
                    $wei=$k+1;
                    $arr['num'.$wei]=$v;
                    if($v<=5)   $arr['dx_'.$wei]="小";else $arr['dx_'.$wei]='大';
                    if($v%2==1)   $arr['ds_'.$wei]="单";else $arr['ds_'.$wei]='双';
                    if($v==1 or $v==2 or $v==3 or $v==5 or $v==7)  $arr['zh_'.$wei]="质";else $arr['zh_'.$wei]='合';
                    $arr['012_'.$wei]=$v%3;
                    if($key==0)       $arr['spj_'.$wei]='平';
                    else{
                        $prenumber=explode(',',$number_list[$key-1]['number']);
                        if($v>$prenumber[$k])$arr['spj_'.$wei]='升';
                        else if($v<$prenumber[$k])$arr['spj_'.$wei]='降';
                        else $arr['spj_'.$wei]='平';
                    }


                }
            }
            if($pos==2){
                $pos_arr=array('冠','亚','三','四','五','六','七','八','九','十');
              $arr['num']=$number;
              $car=array();
              for($i=1;$i<=10;$i++){
                  for ($j=0;$j<10;$j++){
                      if($i==$number[$j]){
                          $car[$i]=$j;
                          break;
                      }
                  }
              }
              $arr['car']=$car;
              foreach ($number as $k=>$v){
               $num=$car[$v];
                  $arr['car'.$v]=$pos_arr[$num];
               if($num<5) $arr['qh_'.$v]='前';else $arr['qh_'.$v]='后';
                  if($num%2==1) $arr['ds_'.$v]='双';else $arr['ds_'.$v]='单';
                  if($key==0)    $arr['spj_'.$v]='平';
                  else{
                      if($arr['car'][$v]>$arr_old['car'][$v]) $arr['spj_'.$v]='升';
                      else if ($arr['car'][$v]<$arr_old['car'][$v]) $arr['spj_'.$v]='降';
                      else   $arr['spj_'.$v]='平';
                  }
              }


            }

            if($pos==3){
                $arr['num']=$number;
                $sum=$number[0]+$number[1];
                $arr['sum_val']=$sum;
                if($sum<=10)   $arr['sum_dx']="小";else $arr['sum_dx']='大';
                if($sum%2==1)   $arr['sum_ds']="单";else $arr['sum_ds']='双';
                $arr['sum_012']=$sum%3;
                if($key==0)    $arr['sum_spj']='平';
                else{
                    if($arr['sum_val']>$arr_old['sum_val']) $arr['sum_spj']='升';
                    else if($arr['sum_val']<$arr_old['sum_val']) $arr['sum_spj']='降';
                    else    $arr['sum_spj']='平';
                }

            }

            if($pos==4){
                $arr['num']=$number;
               for($i=0;$i<5;$i++){
                   $wei=$i+1;
                   if($number[$i]>$number[9-$i]) $arr['lh_'.$wei]='龙';
                   else  $arr['lh_'.$wei]='虎';
               }

            }
            if($pos==5){
                $arr['num']=$number;
                foreach ($number as $k=>$v){
                    $wei=$k+1;
                    $arr['num'.$wei]=$v;
                    $str='';
                    if($v>5) $str.="大";else $str.='小';
                    if($v%2==1) $str.="单";else $str.='双';

                    $arr['dxds_'.$wei]=$str;

                }

            }

            $list[]=$arr;
            $arr_old=$arr;

        }
    }


    $list=json_encode(array_reverse($list));
    return $list;

}




function trend_ssc($gamekey,$period=30,$date='', $filter=0, $pos=1, $from=1){



    $list=array();
    $arr_old=array();
    $number_list= trend_number($gamekey,$period,$date,$filter);
    $number_list=array_reverse($number_list);
    if(count($number_list)>0) {
        foreach ($number_list as $key => $value) {
            $arr=array();
            $arr['expect']=$value['period'];
            $arr['opentime']=$value['lottime'];
            $number=explode(',',$value['number']);
            $sum=0;
            foreach ($number as $k=>$v){
                $sum+=$v;
                $wei=$k+1;
                $arr['num'.$wei]=$v;

            }
            $arr['sum_val']=$sum;
            if($pos==2){

                foreach ($number as $k=>$v){
                    $wei=$k+1;
                    if($v>=5) $arr['dx_'.$wei]='大';else  $arr['dx_'.$wei]='小';
                    if($v%2==1) $arr['ds_'.$wei]='单';else  $arr['ds_'.$wei]='双';
                    if($v==0 or  $v==1 or $v==2 or $v==3 or $v==5 or $v==7) {$arr['zh_'.$wei]='质';}else $arr['zh_'.$wei]='合';
                    $arr['012_'.$wei]=$v%3;
                    if($key==0) {$arr['spj_'.$wei]='平';}
                    else{
                        if($v>$arr_old['num'.$wei]) {$arr['spj_'.$wei]='升';}else if($v<$arr_old['num'.$wei]) $arr['spj_'.$wei]='降';else {$arr['spj_'.$wei]='平';}
                    }

                }


            }else {
                if($pos==3) $number=array($number[0],$number[1]);
                if($pos==4) $number=array($number[3],$number[4]);
                if($pos==5) $number=array($number[0],$number[1],$number[2]);
                if($pos==6) $number=array($number[1],$number[2],$number[3]);
                if($pos==7) $number=array($number[2],$number[3],$number[4]);
                if($pos==8) $number=array($number[0],$number[1],$number[2],$number[3]);
                if($pos==9) $number=array($number[1],$number[2],$number[3],$number[4]);
                $long=count($number);
                $sum=0;
                foreach ($number as $k=>$v){
                    $sum+=$v;
                }
                $arr['sum_val']=$sum;
                if($sum>=5*$long) $arr['sum_dx']='大';else $arr['sum_dx']='小';
                if($sum%2==1) $arr['sum_ds']='单';else $arr['sum_ds']='双';
                if($number[0]>$number[1]) $arr['lh']='龙';else if($number[0]<$number[1]) $arr['lh']='虎';else $arr['lh']='和';
                if($long==5){
                    $arr['pre3']=lot_type(array($number[0],$number[1],$number[2]));
                    $arr['cen3']=lot_type(array($number[1],$number[2],$number[3]));
                    $arr['aft3']=lot_type(array($number[2],$number[3],$number[4]));
                }else{
                    $arr['status'] =$arr['status2']=lot_type($number);
                    $arr['status1']=lot_type2($number);
                }

                $str012='';
                $strzh='';
                $strds='';
                $strdx='';
                $spj='';
                $dx_num=0;
                $ds_num=0;
                $zh_num=0;
                $num0=0;
                $num1=0;
                $s_num=0;
                $p_num=0;
                foreach ($number as $k=>$v){
                 $str012.=$v%3;
                 if($v%3==0) $num0++;  if($v%3==1) $num1++;
                    if($v==0 or  $v==1 or $v==2 or $v==3 or $v==5 or $v==7) {$strzh.='质';$zh_num++;}else $strzh.='合';
                    if($v>4) {$strdx.='大';$dx_num++;  }else $strdx.='小';
                    if($v%2==1) {$strds.='单';$ds_num++;}else $strds.='双';
                    if($key==0) {$spj.='平';$p_num++;}
                    else{
                        $wei=$k+1;
                        if($v>$arr_old['num'.$wei]) {$spj.='升';$s_num++;}else if($v<$arr_old['num'.$wei]) $spj.='降';else {$spj.='平';$p_num++;}
                    }
                    if($v>4) $arr['num'.$wei.'dx']='大';else $arr['num'.$wei.'dx']='小';
                    if($v%2==1) $arr['num'.$wei.'ds']='单';else $arr['num'.$wei.'ds']='双';
                    $arr['num'.$wei.'012']=$v%3;
                    if($v==0 or  $v==1 or $v==2 or $v==3 or $v==5 or $v==7) {$arr['num'.$wei.'zh']='质';}else $arr['num'.$wei.'zh']='合';
                }
                $arr['spj']=$spj;
                $arr['012']=$str012;
                $arr['zh']=$strzh;
                $arr['dx']=$strdx;
                $arr['ds']=$strds;
                $arr['dx_p']=$dx_num.':'.($long-$dx_num);
                $arr['ds_p']=$ds_num.':'.($long-$ds_num);
                $arr['zh_p']=$zh_num.':'.($long-$zh_num);
                $arr['012_p']=$num0.':'.$num1.':'.($long-$num0-$num1);
                $arr['spj_p']=$s_num.':'.$p_num.':'.($long-$s_num-$p_num);
                if($sum<=2) $arr['sum_range']='0-2';
                else if($sum<=7) $arr['sum_range']='3-7';
                else if($sum<=12) $arr['sum_range']='8-12';
                else if($sum<=17) $arr['sum_range']='13-17';
                else if($sum<=22) $arr['sum_range']='18-22';
                else if($sum<=27) $arr['sum_range']='23-27';
                else if($sum<=32) $arr['sum_range']='28-32';
                else if($sum<=37) $arr['sum_range']='33-37';
                else if($sum<=38) $arr['sum_range']='38-42';
                else $arr['sum_range']='42-55';
                $arr['sum_012']=$sum%3;
                if($key==0) {$arr['sum_spj']='平';}
                else{
                    if($sum>$arr_old['sum_val']) {$arr['sum_spj']='升';}else if($sum<$arr_old['sum_val']) $arr['sum_spj']='降';else {$arr['sum_spj']='平';}
                }
                $arr['sum_tail']=$sum%10;
                if($arr['sum_tail']>4) $arr['sum_tail_dx']='大';else $arr['sum_tail_dx']='小';
                if($arr['sum_tail']%2==1) $arr['sum_tail_ds']='单';else $arr['sum_tail_ds']='双';
                if($arr['sum_tail']==0 or $arr['sum_tail']==1 or $arr['sum_tail']==2 or $arr['sum_tail']==3 or $arr['sum_tail']==5 or $arr['sum_tail']==7) {$arr['sum_tail_zh']='质';}else $arr['sum_tail_zh']='合';
                $arr['sum_tail_012']=$arr['sum_tail']%3;
                if($key==0) {$arr['sum_tail_spj']='平';}
                else{
                    if($arr['sum_tail']>$arr_old['sum_tail']) {$arr['sum_tail_spj']='升';}else if($arr['sum_tail']<$arr_old['sum_tail']) $arr['sum_tail_spj']='降';else {$arr['sum_tail_spj']='平';}
                }
                $num=0;
                $repeat='';
                foreach ($number as $k=>$v){
                if(in_array($v,explode(',',$number_list[$key-1]['number']))){
                    $num++;
                    if($repeat!='') $repeat.=',';
                    $repeat.=$v;
                }
                }
                $arr['repeat']=$repeat;
                $arr['repeat_num']=$num;
                if($arr['repeat_num']>2) $arr['repeat_dx']='大';else $arr['repeat_dx']='小';
                if($arr['repeat_num']%2==1) $arr['repeat_ds']='单';else $arr['repeat_ds']='双';
                $arr['repeat_012']=$arr['repeat_num']%3;
                if($key==0) {$arr['repeat_spj']='平';}
                else{
                    if($arr['repeat_num']>$arr_old['repeat_num']) {$arr['repeat_spj']='升';}else if($arr['repeat_num']<$arr_old['repeat_num']) $arr['repeat_spj']='降';else {$arr['repeat_spj']='平';}
                }
                if($long==5){
                    $aera=$number[0].$number[1].$number[2].$number[3].$number[4];
                    if($aera<25000) $arr['area']='A';else if($aera<=50000) $arr['area']='B';else if($aera<75000) $arr['area']='C';else $arr['area']='D';
                }
                if($long==4){
                    $aera=$number[0].$number[1].$number[2].$number[3];
                    if($aera<2500) $arr['area']='A';else if($aera<=5000) $arr['area']='B';else if($aera<7500) $arr['area']='C';else $arr['area']='D';
                }
                if($long==3){
                    $aera=$number[0].$number[1].$number[2];
                    if($aera<250) $arr['area']='A';else if($aera<=500) $arr['area']='B';else if($aera<750) $arr['area']='C';else $arr['area']='D';
                }
                if($long==2){
                    $aera=$number[0].$number[1];
                    if($aera<25) $arr['area']='A';else if($aera<=50) $arr['area']='B';else if($aera<75) $arr['area']='C';else $arr['area']='D';
                }

                if($key==0) {$arr['area_spj']='平';}
                else{
                    if($arr['area']>$arr_old['area']) {$arr['area_spj']='升';}else if($arr['area']<$arr_old['area']) $arr['area_spj']='降';else {$arr['area_spj']='平';}
                }
                $arr['min']=arr_min($number);
                if($arr['min']>4) $arr['min_dx']='大';else $arr['min_dx']='小';
                if($arr['min']%2==1) $arr['min_ds']='单';else $arr['min_ds']='双';
                if($arr['min']==0 or $arr['min']==1 or $arr['min']==2 or $arr['min']==3 or $arr['min']==5 or $arr['min']==7) {$arr['min_zh']='质';}else $arr['min_zh']='合';
                $arr['min_012']=$arr['min']%3;
                if($key==0) {$arr['min_spj']='平';}
                else{
                    if($arr['min']>$arr_old['min']) {$arr['min_spj']='升';}else if($arr['min']<$arr_old['min']) $arr['min_spj']='降';else {$arr['min_spj']='平';}
                }

                $arr['max']=arr_max($number);
                if($arr['max']>4) $arr['max_dx']='大';else $arr['max_dx']='小';
                if($arr['max']%2==1) $arr['max_ds']='单';else $arr['max_ds']='双';
                if($arr['max']==0 or  $arr['max']==1 or $arr['max']==2 or $arr['max']==3 or $arr['max']==5 or $arr['max']==7) {$arr['max_zh']='质';}else $arr['max_zh']='合';
                $arr['max_012']=$arr['max']%3;
                if($key==0) {$arr['max_spj']='平';}
                else{
                    if($arr['max']>$arr_old['max']) {$arr['max_spj']='升';}else if($arr['max']<$arr_old['max']) $arr['max_spj']='降';else {$arr['max_spj']='平';}
                }

                $arr['span']=$arr['max']-$arr['min'];
                if($arr['span']>4) $arr['span_dx']='大';else $arr['span_dx']='小';
                if($arr['span']%2==1) $arr['span_ds']='单';else $arr['span_ds']='双';
                if($arr['span']==0 or  $arr['span']==1 or $arr['span']==2 or $arr['span']==3 or $arr['span']==5 or $arr['span']==7) {$arr['span_zh']='质';}else $arr['span_zh']='合';
                $arr['span_012']=$arr['span']%3;
                if($key==0) {$arr['span_spj']='平';}
                else{
                    if($arr['span']>$arr_old['span']) {$arr['span_spj']='升';}else if($arr['span']<$arr_old['span']) $arr['span_spj']='降';else {$arr['span_spj']='平';}
                }

            }





            $list[]=$arr;
            $arr_old=$arr;

        }
    }


    $list=json_encode($list);
    return $list;

}


function trend_k3($gamekey,$period=30,$date='', $filter=0, $pos=1, $from=1)
{


    $list = array();
    $arr_old = array();
    $number_list = trend_number($gamekey, $period, $date, $filter);
    $number_list = array_reverse($number_list);
    if (count($number_list) > 0) {
        foreach ($number_list as $key => $value) {
            $arr = array();
            $arr['expect'] = $value['period'];
            $arr['opentime'] = $value['lottime'];
            $number = explode(',', $value['number']);
            $sum = 0;
            foreach ($number as $k => $v) {
                $sum += $v;
                $wei = $k + 1;
                $arr['num' . $wei] = $v;

            }
            $arr['sum_val'] = $sum;
            //if($pos==1){
                if($sum>10) $arr['sum_dx']='大';else $arr['sum_dx']='小';
                if($sum%2==1) $arr['sum_ds']='单';else $arr['sum_ds']='双';
                if(isPrime($sum)) $arr['sum_prime']='质'; else $arr['sum_prime']='合';
                $arr['sum_012']=$sum%3;
                if($key==0) {$arr['sum_spj']='平';}
                else{
                    if($sum>$arr_old['sum_val']) {$arr['sum_spj']='升';}else if($sum<$arr_old['sum_val']) $arr['sum_spj']='降';else {$arr['sum_spj']='平';}
                }
                $arr['status1']=lot_typek3($number);
                $arr['status2']=lot_type($number);
            $arr['different2']=array();
                if($arr['status1']=='三同号')$arr['same3']=$number[0].$number[1].$number[2];
                else {
                    $arr['same3']='';
                 if($arr['status1']=='二同号'){
                     $arr['same2_single']=$number[0].$number[1].$number[2];
                     if($number[0]==$number[1]){ $arr['same2_multi']=$number[0].$number[1];  $arr['different2']=$number[0].$number[2];}
                     else if($number[0]==$number[2]) {$arr['same2_multi']=$number[0].$number[2];$arr['different2']=$number[0].$number[1];}
                     else  {$arr['same2_multi']=$number[1].$number[2];$arr['different2']=$number[1].$number[2];}
                     $arr['different2']=array( $arr['different2']);
                 }
                 else{
                     $arr['different3']=$number[0].$number[1].$number[2];
                     $arr['different2']=array($number[0].$number[1],$number[0].$number[2],$number[1].$number[2]);

                 }
                }
                    $odd=0;$big=0;
                    $road012='';
                    $big_small='';
                    $odd_even='';
                    $road0=0;
                    $road1=0;
                    foreach ($number as $v){
                        if($v%2==1) $odd++;
                        if($v>3) $big++;
                        $road012.=$v%2;
                        if($v>2)$big_small++;
                        if($v%2==1) $odd_even++;
                       if($v%3==0) $road0++;
                       if($v%3==1) $road1++;
                    }

                    $arr['odd_num']=$odd;
                    $arr['big_num']=$big;
                    $arr['road012']=$road012;
                    $arr['road0']=$road0;
            $arr['road1']=$road1;
                $arr['road2']=3-$road0-$road1;

                    if($big_small==3) $arr['big_small']='全大';else if($big_small==0) $arr['big_small']='全小';else $arr['big_small']=$big_small.'大'.(3-$big_small).'小';
            if($odd_even==3) $arr['odd_even']='全单';else if($odd_even==0) $arr['odd_even']='全双';else $arr['odd_even']=$odd_even.'单'.(3-$odd_even).'双';

                $arr['min']=arr_min($number);
                if($arr['min']>2) $arr['min_dx']='大';else $arr['min_dx']='小';
                if($arr['min']%2==1) $arr['min_ds']='单';else $arr['min_ds']='双';
                if($arr['min']==0 or $arr['min']==1 or $arr['min']==2 or $arr['min']==3 or $arr['min']==5 or $arr['min']==7) {$arr['min_zh']='质';}else $arr['min_zh']='合';
                $arr['min_012']=$arr['min']%3;
                if($key==0) {$arr['min_spj']='平';}
                else{
                    if($arr['min']>$arr_old['min']) {$arr['min_spj']='升';}else if($arr['min']<$arr_old['min']) $arr['min_spj']='降';else {$arr['min_spj']='平';}
                }

                $arr['max']=arr_max($number);
                if($arr['max']>2) $arr['max_dx']='大';else $arr['max_dx']='小';
                if($arr['max']%2==1) $arr['max_ds']='单';else $arr['max_ds']='双';
                if($arr['max']==0 or  $arr['max']==1 or $arr['max']==2 or $arr['max']==3 or $arr['max']==5 or $arr['max']==7) {$arr['max_zh']='质';}else $arr['max_zh']='合';
                $arr['max_012']=$arr['max']%3;
                if($key==0) {$arr['max_spj']='平';}
                else{
                    if($arr['max']>$arr_old['max']) {$arr['max_spj']='升';}else if($arr['max']<$arr_old['max']) $arr['max_spj']='降';else {$arr['max_spj']='平';}
                }

                $arr['span']=$arr['max']-$arr['min'];
                if($arr['span']>2) $arr['span_dx']='大';else $arr['span_dx']='小';
                if($arr['span']%2==1) $arr['span_ds']='单';else $arr['span_ds']='双';
                if($arr['span']==0 or  $arr['span']==1 or $arr['span']==2 or $arr['span']==3 or $arr['span']==5 or $arr['span']==7) {$arr['span_zh']='质';}else $arr['span_zh']='合';
                $arr['span_012']=$arr['span']%3;
                if($key==0) {$arr['span_spj']='平';}
                else{
                    if($arr['span']>$arr_old['span']) {$arr['span_spj']='升';}else if($arr['span']<$arr_old['span']) $arr['span_spj']='降';else {$arr['span_spj']='平';}
                }
          //  }
            $list[]=$arr;
            $arr_old=$arr;
        }


    }



$list=json_encode($list);
return $list;

}

function trend_11x5($gamekey,$period=30,$date='', $filter=0, $pos=1, $from=1)
{


    $list = array();
    $arr_old = array();
    $number_list = trend_number($gamekey, $period, $date, $filter);
    $number_list = array_reverse($number_list);
    if (count($number_list) > 0) {
        foreach ($number_list as $key => $value) {
            $arr = array();
            $arr['expect'] = $value['period'];
            $arr['opentime'] = $value['lottime'];
            $number = explode(',', $value['number']);
            $sum = 0;
            foreach ($number as $k => $v) {
                $sum += $v;
                $wei = $k + 1;
           //     if($v<10 && strlen($v)==2) $v=substr($v,1,1);
                $arr['num' . $wei] = $v;

            }
            $arr['sum_val'] = $sum;


                foreach ($number as $k => $v) {
                    if($v<10 && strlen($v)==2) $v=substr($v,1,1);
                    $wei = $k + 1;
                    if ($v >= 6) $arr['dx_' . $wei] = '大'; else  $arr['dx_' . $wei] = '小';
                    if ($v % 2 == 1) $arr['ds_' . $wei] = '单'; else  $arr['ds_' . $wei] = '双';
                    if (isPrime($v)) {
                        $arr['zh_' . $wei] = '质';
                    } else $arr['zh_' . $wei] = '合';
                    $arr['012_' . $wei] = $v % 3;
                    if ($key == 0) {
                        $arr['spj_' . $wei] = '平';
                    } else {
                        if ($v > $arr_old['num' . $wei]) {
                            $arr['spj_' . $wei] = '升';
                        } else if ($v < $arr_old['num' . $wei]) $arr['spj_' . $wei] = '降'; else {
                            $arr['spj_' . $wei] = '平';
                        }
                    }

                }

            $list[]=$arr;
            $arr_old=$arr;
        }
    }
    $list=json_encode($list);
    return $list;
}



function trend_kl10($gamekey,$period=30,$date='', $filter=0, $pos=1, $from=1)
{


    $list = array();

    $number_list = trend_number($gamekey, $period, $date, $filter);
    $number_list = array_reverse($number_list);
    if (count($number_list) > 0) {
        foreach ($number_list as $key => $value) {
            $arr = array();
            $arr['expect'] = $value['period'];
            $arr['opentime'] = $value['lottime'];
            $number = explode(',', $value['number']);
            $sum = 0;
            foreach ($number as $k => $v) {
                $sum += $v;
                $wei = $k + 1;
            //    if($v<10 && strlen($v)==2) $v=substr($v,1,1);
                $arr['num' . $wei] = $v;

            }
            $arr['sum_val'] = $sum;
            if($sum>84) $arr['sum_dx']='大';elseif($sum==84)$arr['sum_dx']='和'; else $arr['sum_dx']='小';
            if($sum%2==1) $arr['sum_ds']='单';else  $arr['sum_ds']='双';
            $arr['sum_tail']=$sum%10;
            if($arr['sum_tail']>4) $arr['sum_tail_dx']='大';else $arr['sum_tail_dx']='小';
            if($arr['sum_tail']%2==1) $arr['sum_tail_ds']='单';else $arr['sum_tail_ds']='双';
             $da=0;
             $dan=0;
            foreach ($number as $k => $v) {
                if($v<10 && strlen($v)==2) $v=substr($v,1,1);
                $wei = $k + 1;
                if ($v > 10){ $arr['num' . $wei.'dx'] = '大'; $da++;}else  $arr['num' . $wei.'dx'] = '小';
                if ($v % 2 == 1) {$arr['num' . $wei.'ds'] = '单'; $dan++;}else  $arr['num' . $wei.'ds'] = '双';
            }
            $arr['dx_num']=$da.':'.(8-$da);
            $arr['ds_num']=$dan.':'.(8-$dan);
            $list[]=$arr;

        }
    }
    $list=json_encode($list);
    return $list;
}


function isPrime($n)
{
    if ($n <= 3) {
        return true;
    } else if ($n % 2 === 0 || $n % 3 === 0) { // 排除能被2整除的数(2x)和被3整除的数(3x)
        return false;
    } else { // 排除能被6x+1和6x+5整除的数
        for ($i = 5; $i * $i <= $n; $i += 6) {
            if ($n % $i === 0 || $n % ($i + 2) === 0) {
                return false;
            }
        }
        return true;
    }
}


// 阶乘
function factorial($n) {
    return array_product(range(1, $n));
}

// 排列数
function A($n, $m) {
    return factorial($n)/factorial($n-$m);
}

// 组合数
function C($n, $m) {
    return A($n, $m)/factorial($m);
}

// 排列
function arrangement($a, $m) {
    $r = array();

    $n = count($a);
    if ($m <= 0 || $m > $n) {
        return $r;
    }

    for ($i=0; $i<$n; $i++) {
        $b = $a;
        $t = array_splice($b, $i, 1);
        if ($m == 1) {
            $r[] = $t;
        } else {
            $c = arrangement($b, $m-1);
            foreach ($c as $v) {
                $r[] = array_merge($t, $v);
            }
        }
    }

    return $r;
}

// 组合
function combination($a, $m) {
    $r = array();

    $n = count($a);
    if ($m <= 0 || $m > $n) {
        return $r;
    }

    for ($i=0; $i<$n; $i++) {
        $t = array($a[$i]);
        if ($m == 1) {
            $r[] = $t;
        } else {
            $b = array_slice($a, $i+1);
            $c = combination($b, $m-1);
            foreach ($c as $v) {
                $r[] = array_merge($t, $v);
            }
        }
    }

    return $r;
}

function arr_pl($Arr ,$num,$status=1){
    $result=array();
    for ($i=0;$i<count($Arr);$i++){
      for($j=0;$j<count($Arr);$j++){

          for($k=0;$k<count($Arr);$k++){
              for($x=0;$x<count($Arr);$x++){

                   for($y=0;$y<count($Arr);$y++){
                 $result[]=array($Arr[$i],$Arr[$j],$Arr[$k],$Arr[$x],$Arr[$y]);

                  }
              }

          }
      }

    }
    $return=array();
    foreach ($result as $value){
        $temp=array();
        foreach ($value as $k=>$v){
          if($k<$num)
            $temp[]=$v;
        }
        if(!in_array($temp,$return))
        $return[]=$temp;
    }
    if($status==2){
        $return1=array();

       foreach ($return as $key=>$value){
           if(count($Arr)==2){
               $a=0;
               foreach ($value as $k1=>$v1){
                   if($v1==$Arr[0]) $a++;
               }

               $str=$a.$Arr[0].(count($value)-$a).$Arr[1];
               if(!in_array($str,$return1)) $return1[]=array($str);

           }
           else{
               $a=array();
               foreach ($Arr as $k2=>$v2){
                 $a[$k2]=0;
               }
             //  $value=sort($value);
               foreach ($value as $k1=>$v1){
                   foreach ($Arr as $k2=>$v2){
                       if($v1==$v2) $a[$k2]++;
                   }
               }

               $str="";
               foreach ($Arr as $k2=>$v2){
                   if($str!='') $str.=':';
                   $str.=$a[$k2];
               }
               if(!in_array($str,$return1)) $return1[]=array($str);

           }


       }

  return $return1;
    }
    else{
        return $return;
    }




}




function sysSortArray($ArrayData, $KeyName1, $SortOrder1 = "SORT_ASC", $SortType1 = "SORT_REGULAR") {
    if (! is_array ( $ArrayData )) {
        return $ArrayData;
    }
    // Get args number.
    $ArgCount = func_num_args ();
    // Get keys to sort by and put them to SortRule array.
    for($I = 1; $I < $ArgCount; $I ++) {
        $Arg = func_get_arg ( $I );
        if (! eregi ( "SORT", $Arg )) {
            $KeyNameList [] = $Arg;
            $SortRule [] = '$' . $Arg;
        } else {
            $SortRule [] = $Arg;
        }
    }
    // Get the values according to the keys and put them to array.
    foreach ( $ArrayData as $Key => $Info ) {
        foreach ( $KeyNameList as $KeyName ) {
            ${$KeyName} [$Key] = $Info [$KeyName];
        }
    }
    // Create the eval string and eval it.
    $EvalString = 'array_multisort(' . join ( ",", $SortRule ) . ',$ArrayData);';
    eval ( $EvalString );
    return $ArrayData;
}

function miss_arr_min($result,$arr){
    $min=9999999999;

    foreach ($result as $value){
        if($arr[$value]<$min) $min=$arr[$value];
    }

    return $min;
}




function count_rate($num){
    $money=100;
    $list=array();
    for($i=0;$i<$num;$i++){
        $sum=0;
        foreach ($list as $v){
            $sum+=$v;
        }
        $list[]=  abc_red($money-$sum,$num-count($list));

    }
    foreach ($list as $key=>$value){
        $list[$key]=floatval(number_format($value/100,2,'.',''));

    }
    return $list;

}

function get_out_rate($gamekey,$pos,$target,$result){
    global $db;
  $temp=  get_now_period($gamekey);
  $sql="select * from ".tname('game_rate')." where gamekey='{$gamekey}' and period='{$temp['period']}' and pos='{$pos}' and target='{$target}'";
  $row=$db->exec($sql);
  if($row['id']>0){

      return unserialize($row['rate']);
  }
  else{
    $db->query("delete from ".tname('game_rate')." where gamekey='{$gamekey}' and pos='{$pos}' and target='{$target}'");

     $list=count_rate(count($result));
      $rate=array();
    foreach ($result as $key=> $value){
        $rate[$value['num']]=$list[$key];
    }
    $rate=serialize($rate);
     $db->query("insert into ".tname('game_rate')." (gamekey,period,pos,target,rate) values('{$gamekey}','{$temp['period']}', '{$pos}','{$target}','{$rate}')");
     return unserialize($rate);
  }


}
//get_out_rate('cqssc',0,8));

function long_arr_min($result,$arr,$pos){

    $sum=0;
    $pre_num=-1;
    foreach ($result as $key=> $value){
        $number=explode(',',$value['number']);
        $number=$number[$pos];
        if(in_array($number,$arr)){
            if($key==0) $sum=1;
            else{
                if(in_array($pre_num,$arr)){
                    $sum++;
                }
                else{
                $sum=-$key;
                }

            }
        }else{
            if(in_array($pre_num,$arr)) break;

        }
        $pre_num=$number;

    }

    return $sum;
}
function numberlot_format($number,$pos,$type){
    if($type=='ssc'){
        if($pos!=-1){
            if($pos<5) $number=array($number[$pos]);
            if($pos==5) $number=array($number[0],$number[1]);
            if($pos==6) $number=array($number[3],$number[4]);
            if($pos==7) $number=array($number[0],$number[1],$number[2]);
            if($pos==8) $number=array($number[1],$number[2],$number[3]);
            if($pos==9) $number=array($number[2],$number[3],$number[4]);
            if($pos==10) $number=array($number[0],$number[1],$number[2],$number[3]);
            if($pos==11) $number=array($number[1],$number[2],$number[3],$number[4]);
        }


    }
    elseif($type=='pk10'){
        if($pos!=-1){
            if($pos<10) $number=array($number[$pos]);
            if($pos==10) $number=array($number[0],$number[1]);

        }
    }
    elseif($type=='k3'){

    }
    else {
        $number=array($number[$pos]);
    }
return $number;

}


function pos_list_result($list,$pos,$target,$status=1,$gametype='ssc'){

    $result=array();
    foreach ($list as $value){


        if($target!=30){
            $number=numberlot_format(explode(',',$value['number']),$pos,$gametype);
            $temp=array();
            foreach ($number as $k1=>$v1){
                if($target<9) $temp[]=$v1;
                if($gametype=='ssc'){
                    if($target==9 and $pos==0){
                        $arr=explode(',',$value['number']);
                        if($v1>$arr[4]) $temp[]='龙';else   if($v1<$arr[4]) $temp[]='虎';else $temp[]='和';
                    }

                    if($target==10){
                        if($v1>=5) $temp[]='大';else $temp[]='小';
                    }




                }
                else if($gametype=='pk10'){

                    if($target==9 and $pos<5){
                        $arr=explode(',',$value['number']);
                        if($v1>$arr[9-$pos]) $temp[]='龙';else $temp[]='虎';
                    }

                    if($target==10){
                        if($v1>5) $temp[]='大';else $temp[]='小';
                    }
                    if($target==30){
                        if($v1>5) $temp[]='后';else $temp[]='前';
                    }

                }
                else if($gametype=='k3'){


                    if($target==10){
                        if($v1>2) $temp[]='大';else $temp[]='小';
                    }

                }
                else if($gametype=='11x5'){


                    if($target==10){
                        if($v1>5) $temp[]='大';else $temp[]='小';
                    }

                }
                else if($gametype=='kl10'){


                    if($target==10){
                        if($v1>10) $temp[]='大';else $temp[]='小';
                    }

                }


                if($target==11){
                    if($v1%2==1) $temp[]='单';else $temp[]='双';
                }
                if($target==14){
                    $temp[]=$v1%3;
                }
                if($target==16 or $target==17 or $target>=20) $temp[]=$v1;

            }
            if($target==12){
                $temp[]=array_sum($number);
            }
            if($target==13){
                $temp[]=array_sum($number)%10;
            }

            if($target==15){
                $cha=arr_cha($number);
                $temp[]=$cha[1];
            }
            if($target==18){
                $t=lot_type($number);
                if($t=='半顺')  $temp[]='1连';
                else if($t=='顺子')  $temp[]='2连';
                else  $temp[]='0连';
            }


            if($target==19){
                if($gametype=='ssc')
                    $temp[]=lot_type($number);
                else $temp[]=lot_typek3($number);
            }
            if($status==0 ){
                if($gametype=='ssc'){

                    $sum= array_sum($number);
                    if($pos=='12'){
                        if($target==10)    if($sum>=23) $temp=array('大');else $temp=array('小');
                        if($target==11)    if($sum%2==1) $temp=array('单');else $temp=array('双');
                    }


                }
                if($gametype=='k3'){

                    $sum= array_sum($number);

                        if($target==10)    if($sum>=10) $temp=array('大');else $temp=array('小');
                        if($target==11)    if($sum%2==1) $temp=array('单');else $temp=array('双');



                }


            }

            if($status==2 && ($target==10 or $target==11 or  $target==14)){

                $a=0;
                $b=0;
                foreach ($temp as $k1=>$v1){
                    if($target==10 && $v1=='大') $a++;
                    if($target==11 && $v1=='单') $a++;
                    if($target==14){
                        if($v1==0) $a++;  if($v1==1) $b++;
                    }
                }
                $str=array();
                if($target==10){
                    $str[]=$a.'大'.(count($temp)-$a).'小';
                }
                if($target==11){
                    $str[]=$a.'单'.(count($temp)-$a).'双';
                }
                if($target==14){
                    $str[]=$a.':'.$b.':'.(count($temp)-$a-$b);
                }


                $result[]=$str;

            }
            else{
                $result[]=$temp;
            }
        }

        else{



        $number=explode(',',$value['number']);

        foreach ($number as $k1=> $v1){
            if($v1==$pos) {
                if($k1<5) $result[]=array('前');else $result[]=array('后');
            }

        }


        }


    }

return $result;

}

function is_in_number($num,$number,$target,$status){


    if($target>=23){
        $lot=lot_type2($number);
        if($status==2 and $lot!='组六'){
            return false;
        }
        if($status==1 and $lot=='组六'){
            return false;
        }
    }

    if(count($number)== count($num)){
        if($target>=21){sort($number);sort($num);}
        sort($number);sort($num);
        if($num==$number) return true;
        else return false;
    }
    else{

        if(count($num)>=count($number)){
            $times=0;
            foreach ($number as $value){

                foreach ($num as $v1){
                    if($v1==$value) $times++;
                }
            }

            if($times>=count($number)) return true;
            else return false;
        }
        else{
            $times=0;
            foreach ($number as $value){

                foreach ($num as $v1){
                    if($v1==$value) $times++;
                }
            }
            if($times>=count($num)) return true;
            else return false;
        }


    }


}

function analyz_list($gamekey,$pos,$target,$search,$status,$total=100){
    $game=game_info($gamekey);
    $gametype=$game['type'];
    $list=lottery_list($gamekey,$total);

    $lottery_list=array_reverse($list);

    $list= pos_list_result($lottery_list,$pos,$target,$status,$gametype,1);

    $result=array();
    $num_arr=explode(',',$search);
    $times=0;

    $last_num=-1;
    $expect1='';
    $expect2='';
    foreach ($list as $key=>$value){
        $return=is_in_number($num_arr,$value,$target,$status);

        if($key==0) $expect1=$lottery_list[$key]['period'];

        if($key>0 and $last_num!=$return){
            if($times>0) $num='赢';else $num='输';
            $expect=$expect1.'-'.$expect2;
            $result[]=array('times'=>$times,'num'=>$num,'time'=>$search,'expect'=>$expect);

            $expect1=$lottery_list[$key]['period'];
            $times=0;
        }
        if($return){

            $times++;
        }
        else{
            $times--;

        }

        $expect2=$lottery_list[$key]['period'];
        $last_num=$return;

    }


    return $result;

}



function set_number_result($list,$num,$target,$status,$lottery_list,$info=0){
    $result=array();
    $times=0;
    $max_arise=0;

   $max_miss=0;
   $miss_times=0;
   $miss_sum=0;
   $times_sum=0;
  $list=array_reverse($list);
    $expect1='';
    $expect2='';
    $last_num=-1;

    $temparr=array();

    foreach ($list as $key=>$row){
     $return=is_in_number($num, $row,$target,$status);

        if($key==0) $expect1=$lottery_list[$key]['period'];

        if($key>0 and $last_num!=$return){
            if($times>0) $num1='赢';else $num1='输';
            $expect=$expect1.'-'.$expect2;


                $before=array('num'=>$list[$key-2][0],'expect'=>$lottery_list[$key-2]['period']);
                $after=array('num'=>$list[$key+1][0],'expect'=>$lottery_list[$key+1]['period']);
                $temparr[]=array('times'=>$times,'num'=>$num1,'time'=>implode(',',$num),'expect'=>$expect,'before'=>$before,'after'=>$after);


            $expect1=$lottery_list[$key]['period'];


            $times=0;
        }

     if($return){
            $times++;
         $times_sum++;

     }
     else{
            $times--;


     }
        $expect2=$lottery_list[$key]['period'];
     $last_num=$return;


    }


        if($times>0) $num1='赢';else $num1='输';
        $expect=$expect1.'-'.$expect2;

        $temparr[]=array('times'=>$times,'num'=>$num1,'time'=>implode(',',$num),'expect'=>$expect,'before'=>array(),'after'=>array());

   foreach ($temparr as $value){
      $tt=$value['times'];
      if($tt>0){
         if($tt>$max_arise) $max_arise=$tt;
      }else{

          if(-$tt>$max_miss){
              $max_miss=-$tt;
          }
          $miss_times++;
          $miss_sum=$miss_sum-$tt;
      }

   }



   $long_num=$times;

    $arise=$long_num;


    $result['times']=$times_sum;
    $result['max_arise']=$max_arise;
    $result['arise']=$arise;
    $result['miss']=-$long_num;
    $result['max_miss']=$max_miss;
    $result['avg_miss']=floatval(number_format($miss_sum/$miss_times,2,'.',''));;
 if($info==1) $result['ball']=$temparr;
    return $result;
}
function get_pos_wei($pos){
    if($pos<5) $wei=1;
    else if($pos<7) $wei=2;
    else if($pos<10) $wei=3;
    else if($pos<12) $wei=4;
    else $wei=5;
return $wei;
}

function set_target_name($target,$pos,$status,$gametype){
    $wei=get_pos_wei($pos);
    if($gametype=='ssc'){
        if($target<9){
            $wei_arr=array(0,1,2,3,4,5,6,7,8,9);
            $numarr= combination($wei_arr,$target+1);
        }
        if($target==9){
            $wei_arr=array('龙','虎','和');
            $numarr= combination($wei_arr,1);
        }

        if($status==0){
            if($target==10){
                $wei_arr=array('大','小');

            }
            if($target==11){
                $wei_arr=array('单','双');

            }
            $numarr= combination($wei_arr,1);

        }
        else{
            if($target==10){
                $wei_arr=array('大','小');
                $numarr= arr_pl($wei_arr,$wei,$status);
            }
            if($target==11){
                $wei_arr=array('单','双');
                $numarr= arr_pl($wei_arr,$wei,$status);
            }
        }

        if($target==12){
            if($pos<7) $max=18;
            else  if($pos<10) $max=27;
            else  if($pos<12) $max=36;
            else $max=45;
            $wei_arr=array();
            for($i=0;$i<$max;$i++){
                $wei_arr[]=$i;
            }
            $numarr= combination($wei_arr,1);
        }
        if($target==14){
            $wei_arr=array(0,1,2);
            $numarr= arr_pl($wei_arr,$wei,$status);
        }
        if($target==13 or $target==15 or $target==16){
            $wei_arr=array(0,1,2,3,4,5,6,7,8,9);
            $numarr= combination($wei_arr,1);
        }
        if( $target==17){
            $wei_arr=array(0,1,2,3,4,5,6,7,8,9);
            $numarr= combination($wei_arr,2);
        }
        if( $target==18){
            $wei_arr=array('0连','1连','2连');
            $numarr= combination($wei_arr,1);
        }
        if( $target==19){
            $wei_arr=array('豹子','顺子','半顺','对子','杂六');
            $numarr= combination($wei_arr,1);
        }
        if($target==20){

            $wei_arr=array(0,1,2,3,4,5,6,7,8,9);
            $numarr= arrangement($wei_arr,$wei);
        }
        if($target>=21 and $target<=27){

            $wei_arr=array(0,1,2,3,4,5,6,7,8,9);
            if($target<=21)
                $numarr= combination($wei_arr,$wei);
            else         $numarr= combination($wei_arr,$target-19);
        }

    }else if($gametype=='pk10'){
        if($target<9){
            $wei_arr=array(1,2,3,4,5,6,7,8,9,10);
            $numarr= combination($wei_arr,$target+1);
        }
        if($target==9){
            $wei_arr=array('龙','虎');
            $numarr= combination($wei_arr,1);
        }
        if($target==10){
            $wei_arr=array('大','小');
            $numarr= combination($wei_arr,1);
        }
        if($target==11){
            $wei_arr=array('单','双');
            $numarr= combination($wei_arr,1);
        }
        if($target==12){
            for($i=3;$i<=19;$i++){
                $wei_arr[]=$i;
            }
            $numarr= combination($wei_arr,1);
        }

    }else if($gametype=='11x5'){
        if($target<9){
            $wei_arr=array(1,2,3,4,5,6,7,8,9,10,11);
            $numarr= combination($wei_arr,$target+1);
        }

    }

    elseif($gametype=='k3'){

        if($target<9){
            $wei_arr=array(1,2,3,4,5,6);
            $numarr= combination($wei_arr,$target+1);
        }

        if($target==10){
            $wei_arr=array('大','小');
            $numarr= arr_pl($wei_arr,3,1);
        }
        if($target==11){
            $wei_arr=array('单','双');
            $numarr= arr_pl($wei_arr,3,1);
        }
        if($target==12){
            $wei_arr=array(3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18);
            $numarr= combination($wei_arr,1);
        }
        if($target==19){
            $wei_arr=array('三同号','二同号','三不同');
            $numarr= combination($wei_arr,1);
        }
    }
    elseif($gametype=='kl10'){
        if($target<9){
            $wei_arr=array(1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20);
            $numarr= combination($wei_arr,$target+1);
        }

        if($target==10){
            $wei_arr=array('大','小');
            $numarr= combination($wei_arr,1);
        }
        if($target==11){
            $wei_arr=array('单','双');
            $numarr= combination($wei_arr,1);
        }
        if($target==12){
            for($i=25;$i<=150;$i++){
                $wei_arr[]=$i;
            }
            $numarr= combination($wei_arr,1);
        }
    }



    return $numarr;
}

function lottery_list($gamekey,$total){
    global  $db;
    $now=time();
    $sql="select * from ".lottery_table($gamekey)." where lottime<='{$now}'";
    if(strpos($total,'db')!==false)
    {
        $num=substr($total,0,1);
        $time=24*3600*$num;
        $from=strtotime(date('Y-m-d',time()-$time).' 00:00:00');
        $to=$from+24*3600;
        $sql.=" and lottime>='{$from}'  and lottime<='{$to}' order by period desc ";
    }
    else
        $sql.=" order by period desc limit 0 ,{$total}";
   // echo $sql;
    $list=$db->fetch_all($sql);
    return $list;
}

function get_game_arr($gametype){
    if($gametype=='ssc'){
        $pos_arr=array('万位','千位','百位','十位','个位','前二','后二','前三','中三','后三','前四','后四','五星');

        $target_arr=array('1码','2码','3码','4码','5码','6码','7码','8码','9码','龙虎','大小','单双','和值','和尾','012','跨度','不定胆','三星两码','连号','形态','直选单式','组选单式','组选复式3码','组选复式4码','组选复式5码','组选复式6码','组选复式7码','组选复式8码');
    }else if($gametype=='pk10'){
        $pos_arr=array('冠军','亚军','第三名','第四名','第五名','第六名','第七名','第八名','第九名','第十名','冠亚和');
        $target_arr=array('1码','2码','3码','4码','5码','6码','7码','8码','9码','龙虎','大小','单双','和值',30=>"前后");
    }
    else if($gametype=='11x5'){
        $pos_arr=array('第一球','第二球','第三球','第四球','第五球');
        $target_arr=array('1码','2码','3码','4码','5码','6码','7码','8码','9码',10=>'大小',11=>'单双');
    }
    else if($gametype=='kl10'){
        $pos_arr=array('第一球','第二球','第三球','第四球','第五球','第六球','第七球','第八球');
        $target_arr=array('1码','2码','3码','4码','5码','6码','7码','8码','9码',10=>'大小',11=>'单双');
    }
    else if($gametype=='k3'){
        $pos_arr=array('三星');
        $target_arr=array('1码','2码','3码','4码','5码',10=>'大小',11=>'单双',12=>'和值','19'=>'形态');

    }
    return array('pos'=>$pos_arr,'target'=>$target_arr);

}
function set_ball2_num($target,$value){
    if($target=='11') {
        if($value=='单') $ball2=1;else $ball2=2;
    }
    if($target==10) {
        if($value=='大') $ball2=1;else $ball2=2;
    }
    if($target==9) {
        if($value=='龙') $ball2=1;else $ball2=2;
    }
    if($target==30) {
        if($value=='前') $ball2=1;else $ball2=2;
    }


    return $ball2;


}
function rball_list($gamekey,$pos,$target,$total,$status=1){
    $pos--;
    $target--;
    global  $db;
    $game=$db->exec("select * from ".tname('game')." where showkey='{$gamekey}'");
    $gametype=$game['type'];
   $gamearr= get_game_arr($gametype);

    $lottery_list=lottery_list($gamekey,$total);
    $lottery_list=array_reverse($lottery_list);
    $list= pos_list_result($lottery_list,$pos,$target,$status,$gametype);

$result=array();
$result['key']=$pos.'_'.$target;
$result['pos']=$pos;
$result['target']=$target;
if($target==30)
    $result['pos_name']=$pos.'号';
    else
$result['pos_name']=$gamearr['pos'][$pos];
    $result['target_name']=$gamearr['target'][$target];
    $last_num='';
    $ballArr=Array();
    $count1=$count2=0;

foreach ($list as $key=>$value){
    $result['ball'][]=$value[0];
      $ball2=set_ball2_num($target,$value[0]);
    if($ball2==1) $count1++;
    else $count2++;
    if($key>0)$result['ball2'].=',';
    $result['ball2'].=$ball2;

    if($value[0]==$last_num and $key>0)
        $ballArr[count($ballArr)-1][]=$value[0];
    else{
        $ballArr[]=array($value[0]);
    }


  $last_num=$value[0];

}
    foreach ($ballArr as $value){
        $ball2=set_ball2_num($target,$value[0]);

       if(count($value)>$result['maxCout']['maxCount'.$ball2])$result['maxCout']['maxCount'.$ball2]=count($value);

    }

    $result['count']=array('count1'=>$count1,'count2'=>$count2);
    $result['bal1Arr']=$ballArr;
    $result['sp_name']='独角兽';
    $result['sp']=4;
    return $result;
}

function miss_pos_ssc($gamekey,$pos,$target='',$times='',$search='',$desc=1,$sort='miss',$limit=10,$page=1,$total=100,$status=1,$type='miss',$lottery_list=array(),$info=0){
    global  $db;
    $game=$db->exec("select * from ".tname('game')." where showkey='{$gamekey}'");
    $gametype=$game['type'];
    if(count($lottery_list)>0){
        $list=$lottery_list;

    }
    else{
;    $list=lottery_list($gamekey,$total);
    }

 $arr=   get_game_arr($gametype);
$pos_arr=$arr['pos'];
$target_arr=$arr['target'];

$pos--;
  $target--;

    $result=array();
$numarr=set_target_name($target,$pos,$status,$gametype);

    if($pos==-1){
      if($gametype=='pk10') $long=10;
        else if($gametype=='kl10') $long=8;
      else $long=5;

        for($i=0;$i<$long;$i++){
            $list11= pos_list_result($list,$i,$target,$status,$gametype);
            $times11=0;

            foreach ($numarr as $key=>$value){

                $return=set_number_result($list11,$value,$target,$status,$list,$info);
                $times11+=$return['times'];

                $result[]=array_merge(array('pos'=>$i,'target'=>$target,'pos_name'=>$pos_arr[$i],'count'=>count($list),'target_name'=>$target_arr[$target],'num'=>implode(',',$value)),$return);

            }

        }
    }


    else
    {
        $list11= pos_list_result($list,$pos,$target,$status,$gametype);
        $times11=0;

        foreach ($numarr as $key=>$value){

            $return=set_number_result($list11,$value,$target,$status,$list,$info);
            $times11+=$return['times'];

            $result[]=array_merge(array('pos'=>$pos,'target'=>$target,'count'=>count($list),'pos_name'=>$pos_arr[$pos],'target_name'=>$target_arr[$target],'num'=>implode(',',$value)),$return);

        }


    }

  //  $rate=get_out_rate($gamekey,$pos,$target,$result);
    foreach ($result as $key=>$value){
        if($target==9){
         if($value['num']=='和'){
             $result[$key]['t_arise']=10;
             $result[$key]['t_miss']=10;
         }
         else{
             $result[$key]['t_arise']=45;
             $result[$key]['t_miss']=2.22;
         }


        }else{
            $result[$key]['t_arise']=floatval(number_format($times11/count($numarr),2,'.',''));
            $result[$key]['t_miss']=floatval(number_format(100/$result[$key]['t_arise'],2,'.',''));
        }
       // $result[$key]['out_rate']=$rate[$value['num']];
        $result[$key]['rate']=floatval(number_format($value['times']/$value['count'],2,'.',''));

    }

    if($desc==1) $desc='SORT_DESC';
    else $desc='SORT_ASC';
    $result=sysSortArray($result,$sort,$desc);


//    $showarr1=array();
    if(count($result)>0){
        if(strlen($search)>0) {
         foreach ($result as $key=>$value){
                if( $value['num']==$search)  $showarr1[]=$value;
                else unset($result[$key]);
            }
        }

        if($times!='') {
            foreach ($result as $key=>$value){
                if( $value[$sort]>=$times)  $showarr1[]=$value;
                else unset($result[$key]);

            }
        }


    }
    $sum=count($result);
    $list=array();
    foreach ($result as $key=>$value){
           if($key>=($page-1)*$limit and $key<$page*$limit){


           }
           else unset($result[$key]);

        }


    return array('list'=>$result,'count'=>$sum);
}


function miss_ssc($gamekey,$pos,$target='',$times='',$search='',$type='miss'){




    global  $db;

    $game=game_info($gamekey);
    $gametype=$game['type'];
    $now=time();
    $sql="select * from ".lottery_table($gamekey)." where lottime<='{$now}' order by period desc limit 0,30";
    $lottery_list=$db->fetch_all($sql);
 if($gametype=='ssc'){
     $pos_num=array('1'=>array(29,1,2,3,4,5,6,7,8,9),'2'=>array(21,13),'3'=>array(21,17,13),'4'=>array(17,13),'5'=>array(17,13));
 }else if($gametype=='pk10'){
     $pos_num=array('1'=>array(29,1,2,3,4,5,6,7,8,9),'2'=>array(13));
 }
 else if($gametype=='k3'){
     $pos_num=array('1'=>array(29,1,2,3,4,5));
 }
 else if($gametype=='11x5'){
     $pos_num=array('1'=>array(1,2,3,4,5,6,7,8,9));
 }
 else if($gametype=='kl10'){
     $pos_num=array('1'=>array(29,1,2,3));
 }

//    if($type=='miss')
//        $miss_arr= miss_ssc_list($lottery_list);
//    else     $miss_arr= long_ssc_list($lottery_list);
    $result=array();
    foreach ($pos_num as $key=>$value){

        foreach ($value as $k=>$v){

   //$result['star'.$key][$v]=show_ssc_posnum($miss_arr,$key,$v,$pos,$times,$search,$type);
$result['star'.$key][$v]=   show_ssc_posnum_new($gamekey,$v,$pos,$times,$search,$type,10,$key,$lottery_list,$gametype);
        }

    }

    return $result;
}


function show_ssc_posnum_new($gamekey,$target,$pos,$times='',$search='',$type,$shownum=10,$star=1,$lottery_list,$gametype='ssc'){

      if($pos<1){
         if($gametype=='ssc'){
             if($star==5)       $pos_arr=array(13);
             else if($star==4)       $pos_arr=array(11,12);
             else if($star==3)       $pos_arr=array(8,9,10);
             else if($star==2)       $pos_arr=array(6,7);
             else $pos_arr=array(0);

         }else if($gametype=='pk10'){
             if($star==1)$pos_arr=array(0);
             else {$pos_arr=array(11);}
         }
         else if($gametype=='k3'){
             $pos_arr=array(1);
         }
         else if($gametype=='11x5'){
             $pos_arr=array(0);
         }
         else if($gametype=='kl10'){
             $pos_arr=array(0);
         }

      }
      else {
          $pos_arr=array($pos);
      }

      if($type!='miss') $type='arise';
    $showarr=array();
foreach ($pos_arr as $pos){
    if($target==29){
       if($gametype=='k3' or $gametype=='kl8')
           $arr=array(11,12);
           else
           $arr=array(10,11,12);
      foreach ($arr as $target){
          $result=   miss_pos_ssc($gamekey,$pos,$target,$times,$search,1,$type,$shownum,1,10,1,$type,$lottery_list);

          foreach ( $result['list'] as $value){
              if((in_array($value['num'],Array('龙','虎','和')) && $value['pos']==0)  or !in_array($value['num'],Array('龙','虎','和')))
              $showarr[]=array('pos_name'=>$value['pos_name'],'num'=>$value['num'],'miss'=>$value[$type]);

          }
      }

    }else{
        $result=   miss_pos_ssc($gamekey,$pos,$target,$times,$search,1,$type,$shownum,1,1000,1,$type,$lottery_list);

        foreach ( $result['list'] as $value){

            $showarr[]=array('pos_name'=>$value['pos_name'],'num'=>$value['num'],'miss'=>$value[$type]);

        }
    }



}
    $showarr=sysSortArray($showarr,'miss','SORT_DESC');
    foreach ($showarr as $key=>$value){
        if($gametype=='k3'){
            if($key>=6) unset($showarr[$key]);
        }else
        if($key>=10) unset($showarr[$key]);

    }

 return $showarr;
}



function show_ssc_posnum($result_arr,$star,$traget,$pos,$times='',$search='',$type,$shownum=10){
    $result=array();$pos_arr=array('万位','千位','百位','十位','个位','前二','后二','前三','中三','后三','前四','后四','五星');

   if($pos<1) {
       if($star==1) $result=array($result_arr[0],$result_arr[1],$result_arr[2],$result_arr[3],$result_arr[4]);
       if($star==2) $result=array($result_arr[5],$result_arr[6]);
       if($star==3) $result=array($result_arr[6],$result_arr[7],$result_arr[8]);

   }
   else {
       $pos=$pos-1;
       $result[$pos]=$result_arr[$pos];
   }
$showarr=array();
    if($star==1){
        if($traget==29){
            $wei_arr=array('大','小','单','双','龙','虎','和');
            foreach ($result as $key1=>$value1){
                foreach ($value1 as $key2=>$value2){
             if(in_array($key2,$wei_arr) and !is_numeric($key2))
             $showarr[]=array('pos_name'=>$pos_arr[$key1],'num'=>$key2,'miss'=>$value2);
                }
            }

        }

        if ($traget>0 and $traget<=9){
            $wei_arr=array(0,1,2,3,4,5,6,7,8,9);

            foreach ($result as $key1=>$value1){
                $numarr= combination($wei_arr,$traget);
                foreach ($numarr as $value2){
                    if($type=='miss')
                $showarr[]=array('pos_name'=>$pos_arr[$key1],'num'=>implode(',',$value2),'miss'=> miss_arr_min($value2,$value1));
                    else
                $showarr[]=array('pos_name'=>$pos_arr[$key1],'num'=>implode(',',$value2),'miss'=> long_arr_min($result_arr['list'],$value2,$key1));

                }
            }

        }

    }

    if($star==2 or $star==3 or $star==4 or $star==5){
        if($traget==21){

            foreach ($result as $key1=>$value1){
                foreach ($value1 as $key2=>$value2){
                       $pos_key=$key1;
                        if($star==2  and $key1<5) $pos_key=$key1+5;
                        if($star==3 and $key1<7) $pos_key=$key1+7;
                        $showarr[]=array('pos_name'=>$pos_arr[$pos_key],'num'=>$key2,'miss'=>$value2);
                }
            }
        }

        if($traget==17){
            //不定位
            $wei_arr=array(0,1,2,3,4,5,6,7,8,9);


                if ($pos > 0) $pos_arr = array($pos_arr[$pos]);
                else    {
                     if($star==3)
                    $pos_arr = array('前三', '中三', '后三');
                    if($star==4)
                        $pos_arr = array('前四', '后四');
                    if($star==5)
                        $pos_arr = array('五星');
                }

          foreach ($pos_arr as $key=>$value){

              foreach ($wei_arr as $k1=>$v1){
                  if($value=='前三'){
                      $arrtemp=array($result_arr[0][$v1],$result_arr[1][$v1],$result_arr[2][$v1]);

                  }
                  if($value=='中三'){
                      $arrtemp=array($result_arr[1][$v1],$result_arr[2][$v1],$result_arr[3][$v1]);

                  }
                  if($value=='后三'){
                      $arrtemp=array($result_arr[2][$v1],$result_arr[3][$v1],$result_arr[4][$v1]);

                  }
                  if($value=='前四'){
                      $arrtemp=array($result_arr[0][$v1],$result_arr[1][$v1],$result_arr[2][$v1],$result_arr[3][$v1]);

                  }
                  if($value=='后四'){
                      $arrtemp=array($result_arr[1][$v1],$result_arr[2][$v1],$result_arr[3][$v1],$result_arr[4][$v1]);

                  }
                  if($value=='五星'){
                      $arrtemp=array($result_arr[0][$v1],$result_arr[1][$v1],$result_arr[2][$v1],$result_arr[3][$v1],$result_arr[4][$v1]);

                  }
                  if($type=='miss')
                  $miss=  arr_min($arrtemp);
                  else $miss=arr_long($arrtemp);
                  $showarr[]=array('pos_name'=>$value,'num'=>$v1,'miss'=>$miss);
              }
          }
        }

        if($traget==13){
//和值

            if ($pos > 0) $pos_arr = array($pos_arr[$pos]);
            else    {
                if($star==2)
                    $pos_arr = array('前二', '后二');
                if($star==3)
                    $pos_arr = array('前三', '中三', '后三');
                if($star==4)
                    $pos_arr = array('前四', '后四');
                if($star==5)
                    $pos_arr = array('五星');
            }


            $wei_arr=array();
            for ($i=0;$i<9*$star;$i++){
                $wei_arr[]=$i;

            }

            foreach ($pos_arr as $key=>$value){
                if($value=='前二'){
                    $num=0;

                }
                if($value=='后二'){
                    $num=1;
                }

                if($value=='前三'){
                    $num=2;

                }
                if($value=='中三'){
                    $num=3;

                }
                if($value=='后三'){
                    $num=4;

                }
                if($value=='前四'){
                    $num=5;
                }
                if($value=='后四'){
                    $num=6;

                }
                if($value=='五星'){
                    $num=7;

                }

                foreach ($wei_arr as $k1=>$v1){

                    $showarr[]=array('pos_name'=>$value,'num'=>$v1,'miss'=>$result_arr['sum'][$num][$v1]);

                }




            }



        }

    }

    $showarr=sysSortArray($showarr,'miss','SORT_DESC');
    $showarr1=array();
    if(count($showarr)>0){
        foreach ($showarr as $key=>$value){
      if($times>0 and $search!='') {
          if( $value['miss']>=$times and $value['num']==$search)  $showarr1[]=$value;
      }
      else{
          if($times>0){
              if( $value['miss']>=$times)  $showarr1[]=$value;
          }
          elseif($search!='') {
              if($value['num']==$search) $showarr1[]=$value;
          }
          else
          $showarr1[]=$value;
      }

      if(count($showarr1)>=$shownum) break;
        }

    }

return $showarr1;

}



function miss_ssc_list($list){
    $wei_arr=array('大','小','单','双','龙','虎','和');
    for($i=0;$i<10;$i++){
        $wei_arr[]=$i;
    }
  $result=array();
    $pos_arr=array('万位','千位','百位','十位','个位','前二','后二','前三','中三','后三','前四','后四','五星');
    foreach ($pos_arr as $k1=>$v1){
               if($k1<5){

                   foreach ($wei_arr as $value){
                       $num=-1;
                       foreach ($list as $v11){
                           if($num==0) $num++;
                           $number=explode(',',$v11['number']);
                           $val=$number[$k1];


                           if($value>-1 and $value<=9 and is_numeric($value)){
                               if($val==$value){
                                   $result[$k1][$value]=$num;
                                   break;
                               }
                           }
                           else{
                               if($value=='大'){
                                   if($val>=5){
                                       $result[$k1][$value]=$num;
                                       break;
                                   }
                               }
                               if($value=='小'){
                                   if($val<5){
                                       $result[$k1][$value]=$num;
                                       break;
                                   }
                               }

                               if($value=='单'){
                                   if($val%2==1){
                                       $result[$k1][$value]=$num;
                                       break;
                                   }
                               }
                               if($value=='双'){
                                   if($val%2==0){
                                       $result[$k1][$value]=$num;
                                       break;
                                   }
                               }
                               if($k1<1){

                                   if($value=='龙'){
                                       if($val>$number[4-$k1]){

                                           $result[$k1][$value]=$num;
                                           break;
                                       }
                                   }
                                   if($value=='虎'){
                                       if($val<$number[4-$k1]){

                                           $result[$k1][$value]=$num;

                                           break;
                                       }
                                   }
                                   if($value=='和'){
                                       if($val==$number[4-$k1]){
                                           $result[$k1][$value]=$num;
                                           break;
                                       }
                                   }
                               }

                           }

                           $num++;
                       }

                   }

               }


               else if($k1<10){
                   $wei_arr=array(0,1,2,3,4,5,6,7,8,9);

                   if($k1<7)
                   $numarr= arrangement($wei_arr,2);
                   else if($k1<10)
                       $numarr= arrangement($wei_arr,3);



                   foreach ($numarr as $k2=>$v2){
                         $num=-1;
                       foreach ($list as $v11) {
                           if($num==0) $num++;
                           $number = explode(',', $v11['number']);
                           if($k1==5) $number=array($number[0],$number[1]);
                           if($k1==6) $number=array($number[3],$number[4]);
                           if($k1==7) $number=array($number[0],$number[1],$number[2]);
                           if($k1==8) $number=array($number[1],$number[2],$number[3]);
                           if($k1==9) $number=array($number[2],$number[3],$number[4]);


                           if($number==$v2){
                               $result[$k1][implode('',$v2)]=$num;

                            break;
                           }
                        $num++;
                       }
                   }





               }


    }
    $pos_arr=array('前二','后二','前三','中三','后三','前四','后四','五星');
    foreach ($pos_arr as $k1=>$value){
        if($k1<2) $star=2;
        else if($k1<5) $star=3;
        else if($k1<7) $star=4;
        else $star=5;
        for ($i=0;$i<9*$star;$i++){
              $num=-1;
            $result['sum'][$k1][$i]=count($list);
            foreach ($list as $k2=>$v2){
                $result_arr=explode(',',$v2['number']);
                if($value=='前二'){
                    $arrtemp=$result_arr[0]+$result_arr[1];

                }
                if($value=='后二'){
                    $arrtemp=$result_arr[3]+$result_arr[4];
                }

                if($value=='前三'){
                    $arrtemp=$result_arr[0]+$result_arr[1]+$result_arr[2];

                }
                if($value=='中三'){
                    $arrtemp=$result_arr[1]+$result_arr[2]+$result_arr[3];

                }
                if($value=='后三'){
                    $arrtemp=$result_arr[2]+$result_arr[3]+$result_arr[4];

                }
                if($value=='前四'){
                    $arrtemp=$result_arr[0]+$result_arr[1]+$result_arr[2]+$result_arr[3];
                }
                if($value=='后四'){
                    $arrtemp=$result_arr[1]+$result_arr[2]+$result_arr[3]+$result_arr[4];

                }
                if($value=='五星'){
                    $arrtemp=$result_arr[0]+$result_arr[1]+$result_arr[2]+$result_arr[3]+$result_arr[4];

                }

                if($i==$arrtemp){
                    $result['sum'][$k1][$i]=$num;
                    break;
                }
                $num++;

            }

        }


    }



    return $result;

}









function long_ssc_list($list){
    $wei_arr=array('大','小','单','双','龙','虎','和');
    for($i=0;$i<10;$i++){
        $wei_arr[]=$i;
    }
    $result=array();
    $pos_arr=array('万位','千位','百位','十位','个位','前二','后二','前三','中三','后三','前四','后四','五星');
    foreach ($pos_arr as $k1=>$v1){
        if($k1<5){
            foreach ($wei_arr as $value){
                $num=0;
                foreach ($list as $k11=>$v11){
                    $number=explode(',',$v11['number']);
                    $val=$number[$k1];
                    if($k11>0){
                        $k22=$k11-1;
                        $number1=explode(',',$list[$k22]['number']);
                        $val_pre=$number1[$k1];
                    }


                    if($value>-1 and $value<=9 and is_numeric($value)){
                        if($val==$value){
                           // if($k1==0 and $value==5) echo $num."<br>";
                            if($num<1)  {
                                $result[$k1][$value]=1;

                            }
                            else {
                             if($val==$val_pre){
                                 $result[$k1][$value]= $result[$k1][$value]+1;

                             }
                             else {
                                 $result[$k1][$value]=-$num;
                                 break;
                             }
                            }

                        }
                        else{
                            if( $result[$k1][$value]==1) break;
                        }

                    }
                    else{
                        if($value=='大'){
                            if($val>=5){
                                if($num<1){
                                    $result[$k1][$value]=1;

                                }
                                else {
                                    if($val_pre>=5){
                                        $result[$k1][$value]= $result[$k1][$value]+1;

                                    }
                                    else {
                                        $result[$k1][$value]=-$num;
                                        break;
                                    }
                                }
                            }
                            else{
                                if( $result[$k1][$value]==1) break;
                            }

                        }
                        if($value=='小'){
                            if($val<5){
                                if($num<1){
                                    $result[$k1][$value]=1;
                                }
                                else {
                                    if($val_pre<5){
                                        $result[$k1][$value]= $result[$k1][$value]+1;
                                    }
                                    else {
                                        $result[$k1][$value]=-$num;
                                        break;
                                    }
                                }
                            }
                            else{
                                if( $result[$k1][$value]==1) break;
                            }
                        }

                        if($value=='单'){
                            if($val%2==1){
                                if($num<1){
                                    $result[$k1][$value]=1;
                                }
                                else {
                                    if($val_pre%2==1){
                                        $result[$k1][$value]= $result[$k1][$value]+1;
                                    }
                                    else {
                                        $result[$k1][$value]=-$num;
                                        break;
                                    }
                                }
                            }
                            else{
                                if( $result[$k1][$value]==1) break;
                            }
                        }
                        if($value=='双'){
                            if($val%2==0){
                                if($num<1){
                                    $result[$k1][$value]=1;
                                }
                                else {
                                    if($val_pre%2==0){
                                        $result[$k1][$value]= $result[$k1][$value]+1;
                                    }
                                    else {
                                        $result[$k1][$value]=-$num;
                                        break;
                                    }
                                }
                            }
                            else{
                                if( $result[$k1][$value]==1) break;
                            }
                        }
                        if($k1<1){

                            if($value=='龙'){
                                if($val>$number[4-$k1]){

                                    if($num<1){
                                        $result[$k1][$value]=1;
                                    }
                                    else {
                                        if($val_pre>$number1[4-$k1]){
                                            $result[$k1][$value]= $result[$k1][$value]+1;
                                        }
                                        else {
                                            $result[$k1][$value]=-$num;
                                            break;
                                        }
                                    }
                                }
                                else{
                                    if( $result[$k1][$value]==1) break;
                                }
                            }
                            if($value=='虎'){
                                if($val<$number[4-$k1]){
                                    if($num<1){
                                        $result[$k1][$value]=1;
                                    }
                                    else {
                                        if($val_pre<$number1[4-$k1]){
                                            $result[$k1][$value]= $result[$k1][$value]+1;
                                        }
                                        else {
                                            $result[$k1][$value]=-$num;
                                            break;
                                        }
                                    }
                                }
                                else{
                                    if( $result[$k1][$value]==1) break;
                                }
                            }
                            if($value=='和'){
                                if($val==$number[4-$k1]){
                                    if($num<1){
                                        $result[$k1][$value]=1;
                                    }
                                    else {
                                        if($val_pre==$number1[4-$k1]){
                                            $result[$k1][$value]= $result[$k1][$value]+1;
                                        }
                                        else {
                                            $result[$k1][$value]=-$num;
                                            break;
                                        }
                                    }
                                }
                                else{
                                    if( $result[$k1][$value]==1) break;
                                }
                            }
                        }

                    }

                    $num++;
                }

            }

        }


        else if($k1<10){
            $wei_arr=array(0,1,2,3,4,5,6,7,8,9);

            if($k1<7)
                $numarr= arrangement($wei_arr,2);
            else if($k1<10)
                $numarr= arrangement($wei_arr,3);

            foreach ($numarr as $k2=>$v2){
                $num=0;
                $sum=0;
                $pre_num='-1';
                foreach ($list as $v11) {
                    $number = explode(',', $v11['number']);
                    if($k1==5) $number=array($number[0],$number[1]);
                    if($k1==6) $number=array($number[3],$number[4]);
                    if($k1==7) $number=array($number[0],$number[1],$number[2]);
                    if($k1==8) $number=array($number[1],$number[2],$number[3]);
                    if($k1==9) $number=array($number[2],$number[3],$number[4]);


                    if($number==$v2){
                        if($num==0) $result[$k1][implode('',$v2)]=1;
                        else{
                           if($number==$pre_num) $result[$k1][implode('',$v2)]++;
                           else
                            $result[$k1][implode('',$v2)]=-$num;
                        }

                    }
                    else{
                        if (isset($result[$k1][implode('',$v2)])) break;

                    }

                    $pre_num=$number;
                    $num++;
                }
            }


        }


    }
    $pos_arr=array('前二','后二','前三','中三','后三','前四','后四','五星');
    foreach ($pos_arr as $k1=>$value){
        if($k1<2) $star=2;
        else if($k1<5) $star=3;
        else if($k1<7) $star=4;
        else $star=5;
        $pre_num=-1;
        for ($i=0;$i<9*$star;$i++){


            foreach ($list as $k2=>$v2){
                $result_arr=explode(',',$v2['number']);
                if($value=='前二'){
                    $arrtemp=$result_arr[0]+$result_arr[1];

                }
                if($value=='后二'){
                    $arrtemp=$result_arr[3]+$result_arr[4];
                }

                if($value=='前三'){
                    $arrtemp=$result_arr[0]+$result_arr[1]+$result_arr[2];

                }
                if($value=='中三'){
                    $arrtemp=$result_arr[1]+$result_arr[2]+$result_arr[3];

                }
                if($value=='后三'){
                    $arrtemp=$result_arr[2]+$result_arr[3]+$result_arr[4];

                }
                if($value=='前四'){
                    $arrtemp=$result_arr[0]+$result_arr[1]+$result_arr[2]+$result_arr[3];
                }
                if($value=='后四'){
                    $arrtemp=$result_arr[1]+$result_arr[2]+$result_arr[3]+$result_arr[4];

                }
                if($value=='五星'){
                    $arrtemp=$result_arr[0]+$result_arr[1]+$result_arr[2]+$result_arr[3]+$result_arr[4];

                }

                if($i==$arrtemp){
                    if($i==0)$result['sum'][$k1][$i]=1;
                    else{
                        if($pre_num==$i) $result['sum'][$k1][$i]++;
                        else $result['sum'][$k1][$i]=-$i;
                    }

                }
                else{
                    if(isset($result['sum'][$k1][$i])) break;
                }


                $pre_num=$i;

                $num++;

            }

        }


    }

        $result['list']=$list;



    return $result;

}
function array_init($min,$max,$wei=1){
$arr=array();
for($i=$min;$i<=$max;$i++){
    if($wei==2 and $i<10){
     $num='0'.$i;
    }else $num=$i;
  $arr[]=$num;
}

return $arr;
}
function get_arr_num($arr,$num){
    $arr1=array();

    foreach ($arr as $key=>$value){
        if($key<$num) $arr1[]=$value;

    }

    return $arr1;

}
function get_arr_rand($arr){
    $rand=rand(0,count($arr)-1);

    return $arr[$rand];

}

function game_plan_code($gamekey){
global  $db;
  $game=  game_info($gamekey);
  $gametype=$game['type'];


  if($gametype=='ssc'){
      $min=0;
      $max=9;
      $pos_arr=array('万位','千位','百位','十位','个位','龙虎');
  }
  else if($gametype=='11x5'){
      $min=1;
      $max=11;
      $pos_arr=array('第一球','第二球','第三球','第四球','第五球');
  }
  else if($gametype=='pk10'){
      $min=1;
      $max=10;
      $pos_arr=array('冠军','亚军','第三名','第四名','第五名','第六名','第七名','第八名','第九名','第十名','冠亚和');
  }
  else if($gametype=='k3'){
      $min=3;
      $max=18;
      $line=1;
      $pos_arr=array('号码总和');
  }
  else if($gametype=='kl10'){
      $min=1;
      $max=20;
      $pos_arr=array('第一球','第二球','第三球','第四球','第五球','第六球','第七球','第八球');
  }
  else if($gametype=='pcdd'){
      $min=1;
      $max=27;
      $line=1;
      $pos_arr=array('推荐号码');
  } else if($gametype=='kl8'){
      $min=1;
      $max=80;
      $line=1;
      $pos_arr=array('推荐号码');
  }

$code_arr=array_init($min,$max);

    $result=array();
    foreach ($pos_arr as $key=>$value){
        $temp=array();
        if($value=='龙虎'){
            shuffle($code_arr);

            $temp['code']=get_arr_rand(array('龙','虎','和'));
            $result[$value]=$temp;

        } else if($value=='冠亚和'){



            $code_arr1=array_init(3,17);
                     shuffle($code_arr1);
            $temp['code']=get_arr_num($code_arr1,5);
            $temp['dx']=get_arr_rand(array('大','小'));
            $temp['ds']=get_arr_rand(array('单','双'));
            $result[$value]=$temp;

        }

        else{
            shuffle($code_arr);
            $temp['code']=  get_arr_num($code_arr,5);
            if($value=='推荐号码' || $value=='号码总和'){
                $temp['dx']=get_arr_rand(array('总和大','总和小'));
                $temp['ds']=get_arr_rand(array('总和单','总和双'));
            }

                else{
                    $temp['dx']=get_arr_rand(array('大','小'));
                    $temp['ds']=get_arr_rand(array('单','双'));
                }

            $result[$value]=$temp;
        }

    }

   $game_time= get_now_period($gamekey,1);
    $period=$game_time['period'];
   $row= $db->exec("select * from ".tname('game_plan')."  where gamekey='{$gamekey}' and `period`='{$period}'");
   if($row['id']>0){

   }else{
       $code=serialize($result);
    $sql="insert into ".tname('game_plan')."(period,gamekey,code) values('{$period}','{$gamekey}','{$code}')";
    $db->query($sql);
    $time=time()-72*3600;
    $db->query("delete from ".tname('game_plan')." where lottime>0 and lottime<'{$time}'");
   }

return true;
}



function agree_recharge($id){
    global $db;
   $item= $db->exec("select * from ".tname('recharge')." where id='{$id}'");
   if($item['status']<1){
       $now=time();
       $db->query("update ".tname('recharge')." set status=1  where id='{$id}'");
       if($db->affected_rows()>0){
           $money=$item['money']-$item['fee'];
           add_money($item['uid'],$money,$item['bank']."充值到账",'recharge');
           $content="您{$item['bank']}充值".$item['money']."元";
           if($item['fee']==0) $content.="已到账";
           else $content.="已到账{$money}元,扣除手续费{$item['fee']}元";
           add_note(0,$item['uid'],$content);
           $db->query("update ".tname('recharge')." set agreetime='{$now}' where id='{$id}'");
       }

   }

}

function add_note($uerid,$touid,$content,$type='text'){
    global  $db,$system;
    if($uerid==0) $uerid=$system['admin_id'];
    $sql="insert into ".tname('note')."(userid,touid,type,content) values('{$uerid}','{$touid}','{$type}','{$content}')";
    $db->query($sql);


}


