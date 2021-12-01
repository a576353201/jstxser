<?php
use \GatewayWorker\Lib\Gateway;
use \Workerman\Lib\Timer;
class room{
    public static $db  =null;
    public static  $num=0;
    public  static $user;
   public function __construct($db)

   {
       self::$db=$db;
       self::$user=new user($db);
//       $game_open_arr=array('lhd');
//       $roomlist=self::$db->query("select * from app_game where status='1' order by sortnum asc,id asc ");
//       if(count($roomlist)>0){
//         foreach ($roomlist as $value){
//             if(in_array($value['showkey'],$game_open_arr)){
//              self::game_init($value);
//             }
//         }
//       }
//       self::system_plan($game_open_arr);

   }
   public function get_gameinfo($gameid){
      return self::$db->row("SELECT * FROM `app_game` WHERE id='{$gameid}' ");
   }

    public function get_userinfo($userid){
        return self::$db->row("SELECT * FROM `app_user` WHERE id='{$userid}' ");
    }

    //系统计划任务 一小时一次
    public function  system_plan($game_open_arr){
        $formtime=time()-3600;
      foreach ($game_open_arr as $value){

          self::$db->query("delete from app_lottery_{$value} where addtime<'{$formtime}'");

      }


      if(date('H')<1){
          $time=strtotime(date('Y-m-d',time()-24*3600).' 00:00:00');
          self::$db->query("delete from app_user_yingkui where `real`='0' and `time`<='{$time}'");

          $time=strtotime(date('Y-m-d',time()-24*3600*30).' 00:00:00');
          self::$db->query("delete from app_user_yingkui where `real`='1' and `time`<='{$time}'");

          $time=strtotime(date('Y-m-d',time()-24*3600*15).' 00:00:00');
          self::$db->query("delete from app_orders where  `addtime`<='{$time}'");

      }

        if(date('H')>=1 ){

           self::$user->set_rebate();
        }

     //清理3天前的推广记录
        if(date('H')>=2){
            $time=time()-3*24*3600;
            self::$db->query("delete from app_agent where `time`<='{$time}'");
        }



        Timer::add(3600, function($game_open_arr)
        {
            self::system_plan($game_open_arr);

        },array($game_open_arr),false);
    }


   //为所有房间分配初始化资源

    public  function game_init($game){

       self::gameuser_init($game);
       self::set_gametime($game['id']);

    }

    //设置游戏时间

    public function set_gametime($gameid){
       if($gameid>0) {
           $game = self::get_gameinfo($gameid);

           $game_time=self::get_gametime($game);
           $game['timeinfo']=$game_time;

            $isbuy=$game_time['isbuy'];
            if($isbuy==1){

                if($game_time['timer']>0){
                    Timer::add($game_time['timer'], function($game)
                    {
                        self::set_openode($game);

                    },array($game),false);
                }
                else{
                    self::startbuy($game);
                }

            }else{
                self::set_openode($game);

            }




       }

    }

//停止下注，设置开奖号码
    public function  set_openode($game){
        $type=$game['showkey'];
       $gameid=$game['id'];
       if($gameid>0){
           $setting = unserialize($game['setting']);
           $game_time=self::get_gametime($game);

           if($game_time['isbuy']==1){

               $nexttime=$game_time['timer'];
               if($nexttime<1) $nexttime=1;
               Timer::add($nexttime, function($game)
               {
                   self::set_openode($game);

               },array($game),false);

               return false;
           }

           $expect=$game_time['expect'];

           $lottery=  self::$db->row ("select * from app_lottery_{$type} where expect='{$expect}' and gameid='{$gameid}'");

           if(count($lottery)>0 && $lottery['id']>0){


               $cha=$game_time['timer']>=$setting['lottime'];

               if($cha>=0){
                   if($cha==0)
                       self::send_lotinfo($game);
                   else{

                       Timer::add($cha, function($game)
                       {
                           self::send_lotinfo($game);

                       },array($game),false);
                   }
               }

               else{
                   if($game_time['timer']>0){
                       self::startbuy($game);
                   }
                   else {
                       Timer::add($game_time['timer'], function($game)
                       {
                           self::startbuy($game);

                       },array($game),false);
                   }


               }
           }
           else{
               $code=    self::set_lotcode($game,$expect);
               $addtime=time();
               $lottime=time()+$setting['opentime'];

               $sql="insert into app_lottery_{$type}(gameid,expect,`number`,code,addtime,lottime) values('{$gameid}','{$expect}','{$code['number']}','{$code['code']}','{$addtime}','{$lottime}')";

               self::$db->query($sql);
               if(self::$db->lastInsertId()>0){

                   self::set_prize($gameid,$expect,$code['number']);

                   $data=array('type'=>'stopbuy','game_time'=>$game_time,'game'=>$game);

                   Gateway::sendToGroup( $gameid,json_encode($data));
                   if($setting['opentime']>0){
                       Timer::add($setting['opentime'], function($game)
                       {
                           self::send_lotinfo($game);

                       },array($game),false);
                   }
                   else{
                       self::send_lotinfo($game);
                   }

               }
           }


       }



    }
//开奖
 public   function send_lotinfo($game){
        $gameid=$game['id'];

        if($gameid>0){

            $type=$game['showkey'];


            $game_time=self::get_gametime($game);
            $expect=$game_time['expect'];



            $buyinfo=  self::$db->query ("select uid,sum(prize) as prize,sum(fee) as fee,sum(money) as money from app_buylist where expect='{$expect}' and gameid='{$gameid}' and status!='3' GROUP by uid");
            if(count($buyinfo)){
                foreach ($buyinfo as $key=>$value){
                    $user=self::get_userinfo($value['uid']);
                    $buyinfo[$key]['usermoney']=$user['money'];
                }
            }
            $lottery=  self::$db->row ("select * from app_lottery_{$type} where expect='{$expect}' and gameid='{$gameid}'");
            $history=self::get_historylist($game);

            $data=array('type'=>'openlot','game_time'=>$game_time,'lotinfo'=>$lottery,'buyinfo'=>$buyinfo,'history'=>$history);

            Gateway::sendToGroup( $gameid,json_encode($data));


       ;

            if($game_time['timer']>0){

                Timer::add($game_time['timer'], function($game)
                {
                    self::startbuy($game);

                },array($game),false);
            }
            else {
                self::startbuy($game);
            }

//5秒后更新用户资金信息
            Timer::add(5, function($gameid,$expect)
            {
                self::sendGameInfo($gameid);


                self::set_zhuang_prize($gameid,$expect);

            },array($gameid,$expect),false);
        }
        else{


        }

    }
    public function  set_lotcode($game,$expect){
     $setting=unserialize($game['setting']);
     $fee_pre=$setting['fee'];
     if($setting['prizemode']==0) return self::set_code_lhd();
     else {
         $code=self::set_code_lhd();
       $sql="select * from app_buylist where gameid='{$game['id']}' and expect='{$expect}'";
         if($game['adminid']>0) $sql.=" and `real`='0'";
         else $sql.=" and `real`='1'";
     //    echo $sql;
         $list=self::$db->query($sql);
         if(count($list)>0){
         $buy=0;$prize=0;$fee=0;
         foreach ($list as $value){
             $return=self::set_prize_money($value,$code['number'],$fee_pre);
             $buy+=abs($return['buy']);
             $prize+=abs($return['prize']);
             $fee+=abs($return['fee']);
         }

             if($game['adminid']>0){
                 if($prize+$fee>=$buy) return $code;
             }
             else{
//                 echo  $buy.":".$prize.":".$fee."\n";
//                 echo $buy-($prize-$fee);
//                 echo '<br>';
                 if($buy-($prize-$fee)>=0){

                     return $code;
                 }
             }
             return self::set_lotcode($game,$expect);


         }
         else return $code;

     }


    }

    public function set_prize_money($row,$number,$fee_pre=5){

        $rate_arr=array('龙'=>2,'虎'=>2,'和'=>16);
        $rate=$rate_arr[$number] ;
        if($number=='和'){
            if($number!=$row['number']) return array('buy'=>0,'prize'=>0,'fee'=>0);
        }
        else{
            $money=$row['money'];
            if($row['number']==$number){
                $prize=$money*$rate;
                $fee=$prize*$fee_pre/100;
            }else{
                $prize=0;

                $fee=0;
            }


            return array('buy'=>$money,'prize'=>$prize,'fee'=>$fee);
        }

    }

    public function set_code_lhd(){
        $code1=rand(0,51);
        $code2=rand(0,51);
        if(intval($code1/4)>intval($code2/4)){
            $number='龙';
        }
        else    if(intval($code1/4)<intval($code2/4)){
            $number='虎';
        }
        else  $number='和';

        return array('number'=>$number,'code'=>"{$code1},{$code2}");


    }



    //判断是否中奖
    public  function  set_prize($gameid,$expect,$number){
        $rate_arr=array('龙'=>2,'虎'=>2,'和'=>16);
        $game=$this->get_gameinfo($gameid);
        $setting=unserialize($game['setting']);

        $fee_pre=$setting['fee'];
        $now=time();
        $sql="select  *  from app_buylist where gameid='{$gameid}'  and  expect='{$expect}' and status='0'  ";
          $list=self::$db->query($sql);
          if(count($list)>0){
              foreach ($list as $value){
                  $userid=$value['uid'];
                  $money=$value['money'];
                  if($value['number']==$number){
                     $rate=$rate_arr[$number] ;
                     $prize=$money*$rate;
                     $fee=$prize*$fee_pre/100;
                     if($value['prize']==0){

                         self::$db->query("update app_buylist set prize='{$prize}',fee='{$fee}',status='1',lottime='{$now}' where id='{$value['id']}'");
                         self::$user->add_money($userid,$prize-$fee,'prize',$value['id'],$value['real'],'中奖');
                         self::$db->query("update app_room set  prize=prize+{$prize},prizetimes=prizetimes+1 where gameid='{$gameid}' and uid='{$userid}'");
                         if($fee>0){
                             self::$user->set_yingkui($userid,'fee',$fee);
                         }

                     }

                  }
                  else {
                      if($number=='和'){
                          if($value['number']!=$number){
                              self::$db->query("update app_buylist set status='3',lottime='{$now}' where id='{$value['id']}'");
                              self::$user->add_money($userid,$money,'gameback',$value['id'],$value['real'],'和局，撤单');
                          }

                      }
                      else{
                          self::$db->query("update app_buylist set status='2',lottime='{$now}' where id='{$value['id']}'");
                      }
                  }


              }
          }



    }

//庄家盈利信息

public  function  set_zhuang_prize($gameid,$expect){
        $game=self::get_gameinfo($gameid);
        $type=$game['showkey'];
    $lottery=  self::$db->row ("select * from app_lottery_{$type} where expect='{$expect}' and gameid='{$gameid}'");
    $buyinfo=  self::$db->row ("select sum(prize) as prize,sum(money) as money from app_buylist where expect='{$expect}' and gameid='{$gameid}' and status!='3'");
    $sum=$buyinfo['money']-$buyinfo['prize'];
    if($lottery['status']==0){
       self::$db->query("update  app_lottery_{$type} set status='1' where expect='{$expect}' and gameid='{$gameid}'");
       if($game['adminid']>0){
         $admin=  self::$db->row("select * from  app_game_admin  where gameid='{$gameid}' and uid='{$game['adminid']}'");
           if($sum>0){
             //  self::add_money($game['adminid'],$sum,'zhuang',0,1,'庄家盈利');
               self::$db->query("update app_game_admin set money=money+{$sum} where id='{$admin['id']}'");
           }
           else{
               if(-$sum<$admin['money']){
               //    self::add_money($game['adminid'],$sum,'zhuang',0,1,'庄家亏损');
                   self::$db->query("update app_game_admin set money=money+{$sum} where id='{$admin['id']}'");
               }
               else{
                   $admininfo=self::get_userinfo($game['adminid']);
                   if(-$sum-$admin['money']>$admininfo['money']) {
                       $money=$admininfo['money'];

                   }
                   else {

                       $money=-$sum-$admin['money'];
                   }
                   self::$user->add_money($game['adminid'],-$money,'zhuang',0,1,'庄家亏损');
                   self::$db->query("delete from app_game_admin where id='{$admin['id']}'");
                   self::$db->query("update app_game set adminid='0' where id='{$gameid}'");
                   self::zhuang_next($gameid);
                   self::sendUserMoney($admin['id']);



               }
           }
           self::send_adminlist($gameid);
       }


    }
   return $sum;



}

public  function zhuang_next($gameid){
    $adminlist=self::$db->row("select * from  app_game_admin  where gameid='{$gameid}' and status='0' order by id asc ");
    if(count($adminlist)>1){
        self::$db->query("update app_game set adminid='{$adminlist['uid']}' where id='{$gameid}'");
        self::$db->query("update app_game_admin set status='1' where id='{$adminlist['id']}'");
    }
}

//开始下注
    public function startbuy($game){

        $gameid=$game['id'];

        if($gameid>0){
            $game_time=self::get_gametime($game);
            $expect=$game_time['expect'];
            self::$db->query("delete from app_buylist where `real`=0 and expect!='{$expect}' and gameid='{$gameid}'");
            $data=array('type'=>'startbuy','game_time'=>$game_time);

            Gateway::sendToGroup( $gameid,json_encode($data));


            Timer::add(2, function($game)
            {
            self::game_buying($game);

            },array($game),false);


        }

    }

    //下注中

    public  function  game_buying($game){
        $gameid=$game['id'];
        $game_time=self::get_gametime($game);
        $timer_id=  Timer::add(0.2, function($game)
        {
           self::send_buy1($game);

        },array($game));

        Timer::add($game_time['timer'], function($gameid,$timer_id)
        {
            Timer::del($timer_id);
            $game=self::get_gameinfo($gameid);
            self::set_openode($game);

        },array($gameid,&$timer_id),false);
    }


    //设置虚拟下注

   public  function send_buy1($game)
   {
       $gameid = $game['id'];
       $money = self::get_rand_money();
       $uid = self::get_rand_uid($gameid, $money);
       if ($uid > 0 and $money > 0) {
           if ($game['showkey'] == 'lhd') {
               $rand = rand(0, 16);
               if ($rand < 8) $number = '龙';
               else if ($rand < 16) $number = '虎';
               else {
                   $number = '和';
               }
           }
           $game_time = self::get_gametime($game);
           self::add_gamebuy($game, $game_time['expect'], $uid, $money, $number, 0);

       }
   }

    //获取随机金额
public function  get_rand_money(){
    $moneyList=array(1,5,10,50,100,500);
    $rand=rand(0,99);
    if($rand<50) $num=0;
    else if($rand<80) $num=1;
    else if($rand<90) $num=2;
    else if($rand<95) $num=3;
    else if($rand<99) $num=4;
    else  $num=5;
    $money=$moneyList[$num];
    return  $money;
}

//获取随机投注虚拟uid
public  function  get_rand_uid($gameid,$money){

       $userlist=self::$db->query("select uid from app_room where gameid='{$gameid}' and `real`='0' order by rand()");
       if(count($userlist)>0){
           foreach ($userlist as $value){
               $user=self::get_userinfo($value['uid']);
               if($user['money']>$money) return $value['uid'];
           }
       }
return 0;
}


//真实用户请求下注

public function UserGameBuy($gameid,$userid,$money,$number){
    $user=self::get_userinfo($userid);
    if($user['money']<$money){
        Gateway::sendToUid($userid,json_encode(array('type'=>'message','message'=>'您的账户余额不足')));
    }
    else{
        $game=self::get_gameinfo($gameid);
        $game_time=self::get_gametime($game);
        $expect=$game_time['expect'];
        self::add_gamebuy($game,$expect,$userid,$money,$number,1);
    }

}
//下注
public function  add_gamebuy($game,$expect,$userid,$money,$number,$real=1){
       $gameid=$game['id'];
       if($gameid>0){
        $addtime=time();
        $user=self::get_userinfo($userid);
        $usermoney=$user['money']-$money;
           $sql="insert into app_buylist (uid,gameid,expect,`number`,money,`real`,addtime,gametype,usermoney) values ('{$userid}','{$gameid}','{$expect}','{$number}','{$money}','{$real}','{$addtime}','{$game['showkey']}','{$usermoney}')";
            self::$db->query($sql);
            $buyid=self::$db->lastInsertId();
           if($buyid>0){
               self::$db->query("update app_room set  buy=buy+{$money},buytimes=buytimes+1 where gameid='{$gameid}' and uid='{$userid}'");
               $usermoney=    self::$user->add_money($userid,-$money,'buy',$buyid,$real,$number.$money.'元');
               $buyinfo=array('userid'=>$userid,'money'=>$money,'number'=>$number,'usermoney'=>$usermoney);
               $data=array('type'=>'gamebuy','buyinfo'=>$buyinfo);
               Gateway::sendToGroup( $gameid,json_encode($data));
           }
       }

}





     public function  get_gametime($game){
       if($game['id']>0){
             $setting = unserialize($game['setting']);
             $begintime=strtotime(date('Y-m-d',time())." ".$setting['begintime']);
             $endtime=strtotime(date('Y-m-d',time())." ".$setting['endtime']);
             if($setting['endtime']=='23:59:59'){
                 $endtime++;
             }
             $buytime=$setting['buytime'];
             $lottime=$setting['lottime'];
             //  $opentime=$setting['opentime'];
             $temp=($endtime-$begintime)%($buytime+$lottime);
             $endtime=$endtime-$temp;
             $sum=floor(($endtime-$begintime)%($buytime+$lottime));
             $len=strlen($sum);
             $isbuy=0;
             $open=0;
             $islot=0;
             if(time()<$begintime){

                 $expect=date('Ymd',time()).sprintf("%0{$len}d", 1);
                 $timer=$begintime+$lottime-time();
                 $endtime=$begintime+$lottime;
             }else if(time()>$endtime){

                 $expect=date('Ymd',time()+24*3600).sprintf("%0{$len}d", 1);
                 $timer=$begintime+$lottime+24*3600-time();
                 $endtime=$begintime+$lottime+24*3600;
             }else{
                 $open=1;
                 $expect=date('Ymd',time()).sprintf("%0{$len}d", ceil((time()-$begintime)/($buytime+$lottime)));
                 $second=(time()-$begintime)%($buytime+$lottime);
                 if($second<$buytime) {
                     $isbuy=1;
                     $timer=$buytime-$second;
                     $endtime=time()+$timer;
                 }
                 else{
                     $timer=$buytime+$lottime-$second;
                     $endtime=time()+$timer;
                     if($second>=$buytime+$lottime){
                         $islot=1;
                     }

                 }

             }

             $return=array('expect'=>$expect,'open'=>$open,'isbuy'=>$isbuy,'islot'=>$islot,'timer'=>$timer,'endtime'=>$endtime);

             return $return;
         }

     }
//设置虚拟玩家
    public function gameuser_init($game){


       if(is_array($game) ){

           $gameid=$game['id'];
           $setting=unserialize($game['setting']);
           $online_min=$setting['online_min'];
           $online_max=$setting['online_max'];
           $rand=rand($online_min,$online_max);
           $userlist= self::$db->query("select * from `app_room` where gameid='{$gameid}' order by buy desc,prize desc,jointime desc");
           $needuser=$rand-count($userlist);
           if($needuser>0){

               $list=  self::$db->query("select * from app_user where `real`='0' and id not in (select uid from app_room where gameid='{$gameid}') order by rand() limit 0,{$needuser}");
               foreach ($list as $value){
                   $uid=$value['id'];
                   Timer::add(rand(1,60), function($game,$uid)
                   {
                       self::AddUser($game,$uid);
                   },array($game,$uid),false);
               }

           }
           //清理超时虚拟玩家

           $quit_time=time()+60;
           $list=  self::$db->query("select * from app_room where `gameid`='{$gameid}' and quit_time<'{$quit_time}' and `real`='0' order by quit_time asc");
           if(count($list)>0){
               foreach ($list as $value){
                   self::userOut($value['uid'],$gameid,1) ;
               }
           }
       }

    }


    public  function  AddUser($game,$uid){
        $setting=unserialize($game['setting']);
        $min=$setting['onlinetime_min'];
        $max=$setting['onlinetime_max'];
        $onlinetime=rand($min,$max)*60;
        $gameid = $game['id'];
        $room=self::$db->row("SELECT * FROM `app_room` WHERE gameid='{$gameid}' and uid='{$uid}'");
        if($room['id']>0){
            self::sendGameInfo($gameid);
        }
        else {

            $type = $game['showkey'];
            $jointime = time();
            $client_id = 'V_' . time() . rand(10000, 99999);
            $quit_time=time()+$onlinetime;
            $sql = "insert into app_room(gameid,uid,`type`,jointime,client_id,`real`,quit_time) values('{$gameid}','{$uid}','{$type}','{$jointime}','{$client_id}','0','{$quit_time}')";
            self::$db->query($sql);
            if(self::$db->lastInsertId()>0){

                self::sendGameInfo($gameid);
            }

        }

        Timer::add($onlinetime, function($gameid,$uid)
        {
         self::userOut($uid,$gameid);
        },array($gameid,$uid),false);

    }

    public  function JoinGroup($client_id,$data){
        Gateway::joinGroup($client_id, $data['GroupId']);

        $gameinfo=self::$db->row("select * from app_game where id='{$data['GroupId']}'");
        $setting=unserialize($gameinfo['setting']);
        $game_admin=self::$db->query("select * from app_game_admin where gameid='{$data['GroupId']}' and status='0'");
       $gamedata=array('gameinfo'=>$gameinfo,'setting'=>$setting,'game_admin'=>$game_admin);
      $user=self::show_userinfo($data['uid']);
        Gateway::sendToClient($client_id,json_encode(array('type'=>'is_joinroom','roomid'=>$data['GroupId'],'gamedata'=>$gamedata,'userinfo'=>$user,'message'=>"用户{$data['uid']}加入房间{$data['GroupId']}")));

        $gameid=$data['GroupId'];
        $uid=$data['uid'];
        $jointime=time();
        $game=self::$db->row("SELECT * FROM `app_game` WHERE id='{$gameid}'");
        $type=$game['showkey'];
        self::$db->query("update `app_user` set gameid='{$gameid}',gametime='{$jointime}' where id='{$data['uid']}'");
        $room=self::$db->row("SELECT * FROM `app_room` WHERE gameid='{$gameid}' and uid='{$uid}'");
        if($room['id']>0){
            self::$db->query("update `app_room` set client_id='{$client_id}' where gameid='{$gameid}' and uid='{$uid}'");
            self::sendGameInfo($gameid);
        }
        else{

             $sql="insert into app_room(gameid,uid,`type`,jointime,client_id) values('{$gameid}','{$uid}','{$type}','{$jointime}','{$client_id}')";
             self::$db->query($sql);
             if(self::$db->lastInsertId()>0){

              self::sendGameInfo($gameid);
             }

        }
        $game_time=  self::get_gametime($game);
        if($game_time['islot']==0)
        $buylist=self::get_gamebuylist($gameid,$game_time['expect']);
        else $buylist=array();
        $history=self::get_historylist($game);
        $data=json_encode(array('type'=>'game_init','game'=>$game,'game_time'=>$game_time,'buylist'=>$buylist,'history'=>$history,'message'=>'初始化游戏配置'));
        Gateway::sendToGroup( $gameid,$data);
        if($game['adminid']>0){
            self::send_adminlist($gameid);
        }

        self::gameuser_init($game);

    }
//获取游戏历史记录

public  function get_historylist($game,$num=100){
      $gameid=$game['id'];
      $type=$game['showkey'];

    $sql="select  *  from app_lottery_{$type} where gameid='{$gameid}'  order by id desc  limit 0,{$num} ";
    return   self::$db->query($sql);
}



    //获取游戏下注数据

   public function get_gamebuylist($gameid,$expect){

       $sql="select  uid as userid,`number`,money,usermoney  from app_buylist where gameid='{$gameid}'  and  expect='{$expect}' order by id asc  ";
     return   self::$db->query($sql);
   }




//发送游戏信息
    public function sendGameInfo($gameid){

      $userlist= self::$db->query("select * from `app_room` where gameid='{$gameid}' order by buy desc,prize desc,jointime desc");
      if(count($userlist)>0){
          foreach ($userlist as $key=>$value){
             $userlist[$key]=array_merge($value,self::show_userinfo($value['uid']));
          }
      }
      $game=self::get_gameinfo($gameid);

   $game_time=  self::get_gametime($game);

      $data=json_encode(array('type'=>'gameinfo','game'=>$game,'user'=>$userlist,'game_time'=>$game_time));
        Gateway::sendToGroup( $gameid,$data);
    }

    //申请上庄

    public function  apply_admin($gameid,$userid,$money){

        $user=self::get_userinfo($userid);
        $game=self::get_gameinfo($gameid);
        $setting=unserialize($game['setting']);
        if($user['money']<$money or $money<$setting['money']){
            Gateway::sendToUid($userid,json_encode(array('type'=>'message','message'=>'您的携带金额不足，申请上庄失败')));
        }
        else{
            $addtime=time();
            $sql="insert into app_game_admin(gameid,uid,`money`,addtime,status) values('{$gameid}','{$userid}','{$money}','{$addtime}','0')";

            self::$db->query($sql);
            $id=self::$db->lastInsertId();
            if($id>0){
                self::$user->add_money($userid,-$money,'zhuang',0,1,'申请上庄');

                if($game['adminid']==0){
                    self::$db->query("update app_game set adminid='{$userid}' where id='{$gameid}'");
                    self::$db->query("update app_game_admin set status='1' where id='{$id}'");
                }
                self::send_adminlist($gameid);
                Gateway::sendToUid($userid,json_encode(array('type'=>'message','message'=>'申请上庄成功')));
                self::sendUserMoney($userid);
            }
            else{
                Gateway::sendToUid($userid,json_encode(array('type'=>'message','message'=>'申请上庄失败')));
            }
        }
}

    public function  unapply_admin($gameid,$userid){
     $admin=   self::$db->row("select * from app_game_admin where gameid='{$gameid}' and uid='{$userid}'");
        self::$user->add_money($userid,$admin['money'],'zhuang',0,1,'坐庄盈利');

        self::$db->query("delete  from app_game_admin where gameid='{$gameid}' and uid='{$userid}'");
        self::$db->query("update app_game set adminid='0' where id='{$gameid}'");
        self::zhuang_next($gameid);
        self::send_adminlist($gameid);
        self::sendUserMoney($userid);
        Gateway::sendToUid($userid,json_encode(array('type'=>'message','message'=>'下庄成功')));
    }

    public function sendUserMoney($userid){
        $user=self::get_userinfo($userid);
        Gateway::sendToUid($userid,json_encode(array('type'=>'userMoney','money'=>$user['money'])));

    }

//庄家信息
public function game_admin_list($gameid){

    $list=self::$db->query("select * from app_game_admin where gameid='{$gameid}' order by id asc");
    if(count($list)>0){
        foreach ($list as $key=>$value){
            $user=$this->get_userinfo($value['uid']);
            $list[$key]['username']=$this->show_username($user);
            $list[$key]['usermoney']=$user['money'];

        }
    }
    return $list;

}

public function  send_adminlist($gameid){
    $adminlist=self::game_admin_list($gameid);
    $game=self::get_gameinfo($gameid);
    $admininfo=array();
    if($game['adminid']>0){
        $admininfo=self::get_userinfo($game['adminid']);
    }
    $data=json_encode(array('type'=>'adminlist','game'=>$game,'adminlist'=>$adminlist,'admininfo'=>$admininfo));
    Gateway::sendToGroup( $gameid,$data);
}

    //退出房间

    public  function  GameOut($client_id){
        $room=self::$db->row("SELECT * FROM `app_room` WHERE client_id='{$client_id}' ");
        $gameid=$room['gameid'];

        self::userOut($room['uid'],$gameid);

    }
    public  function  userOut($userid,$gameid,$auto=0){
        self::$db->query("delete FROM `app_room` WHERE uid='{$userid}' and gameid='{$gameid}' ");
        self::$db->query("update app_user set gameid='0',gametime='0' where id='{$userid}'");
        if($gameid>0){

            self::sendGameInfo($gameid);

          if($auto==0) {
                 $rand=rand(1,10);
              Timer::add($rand, function($gameid)
              {

                  $game=self::get_gameinfo($gameid);
                  self::gameuser_init($game);
              },array($gameid),false);

          }
        }
    }

    function show_username($user){

        if($user['nickname']) $name=$user['nickname'];
        else {
            $search = '/^0?1[3|4|5|6|7|8|9][0-9]\d{8}$/';
            if ( preg_match( $search, $user['name'] ) ) {
                $name=substr($user['name'],0,3).'*****'.substr($user['name'],strlen($user['name'])-3,3);
            } else {
                $name=$user['name'];
            }

        }

        return $name;

    }

    function show_userinfo($id){
        $return=array();
        $user=self::$db->row("SELECT * FROM `app_user` WHERE id='{$id}'");
        $return['username']=self::show_username($user);
        $return['avatar']=$user['avatar'];
        $return['money']=$user['money'];
        return $return;

    }






}