<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/6/24
 * Time: 20:22
 */
use \GatewayWorker\Lib\Gateway;
use \Workerman\Lib\Timer;
class user
{
    public static $db = null;
    public static $num = 0;
    public  static $imgurl;
    public function __construct($db)

    {
        self::$db = $db;
    }

    public function get_userinfo($userid)
    {
        return self::$db->row("SELECT * FROM `app_user` WHERE id='{$userid}' ");
    }
    function  setimgurl($imgurl){
        self::$imgurl=$imgurl;
    }

    public  function userinfo($id){

        $user=  self::get_userinfo($id);

        if(!$user['avatar']) $avatar='uploads/avatar.jpg';
        else $avatar=$user['avatar'];
       // if(strpos($avatar,'http')!==false)
         //   $avatar=self::$imgurl.$avatar;
        if($user['nickname']) $nickname=$user['nickname'];
        else $nickname=$user['name'];

        $data= array('id'=>$user['id'],'nickname'=>$nickname,'avatar'=>$avatar,'money'=>$user['money'],'province'=>$user['province'],'city'=>$user['city']);
//         $data['note1']=$user['note1'];
//        $data['note2']=$user['note2'];
        return $data;
    }

  //加入所有的群

    public  function join_all_group($userid,$client_id){
      $list=  self::$db->query("select * from app_group where is_delete='0' and (user_id like '{$userid}' or createid='{$userid}')");
      if(count($list)>0){
          foreach ($list as $value){

              Gateway::joinGroup($client_id, 'G'.$value['id']);;
          }

      }


    }


    public  function  is_friend($userid,$friend_id){
        $sql="select * from app_friend where userid='{$friend_id}' and friendid='{$userid}'";
        $row=self::$db->row($sql);
        if($row['id']>0) return true;
        else return false;


    }


    public  function  request_num($touid,$type=1){
        $sql="SELECT * FROM app_request where touid='{$touid}' and `status`='0'";
        $row=self::$db->query($sql);
        return count($row);
    }

    public function  send_setting($userid){
        $data=array();
        $data['newfriendnum']=self::request_num($userid);
        $data['weburl']='https://www.baidu.com';
        $data['msgtop']=self::msgtopList($userid);
        $data['msgnotip']=self::msgnotipList($userid);
        $data1=array('type'=>'setting','data'=>$data);
       Gateway::sendToUid($userid,json_encode($data1));
    }


    public  function msgtopList($userid){

        return self::$db->query("select * from app_msgtop where userid='{$userid}' order by time desc");


    }
    public  function msgnotipList($userid){

        return self::$db->query("select * from app_msgnotip where userid='{$userid}' order by time desc");


    }


    public  function  msgtop($userid,$storekey,$type=1){
        self::$db->query("delete from app_msgtop where userid='{$userid}' and storekey='{$storekey}'");
        $now=time();
        if($type==1){
            self::$db->query("insert into app_msgtop(userid,storekey,time) values('{$userid}','{$storekey}','{$now}')")    ;

        }
        self::send_setting($userid);
    }
    public  function  msgnotip($userid,$storekey,$type=1){
        self::$db->query("delete from app_msgnotip where userid='{$userid}' and storekey='{$storekey}'");
        $now=time();
        if($type==1){
            self::$db->query("insert into app_msgnotip(userid,storekey,time) values('{$userid}','{$storekey}','{$now}')")    ;

        }
        self::send_setting($userid);
    }
    public  function  circle_push($id,$fromid,$action,$userid,$issend){

        self::$db->query("delete from app_circle_push where cid='{$id}'");

        $circle=self::$db->row("select * from app_circle where id='{$id}'");
        if($circle['id']>0) $type='update';else $type='delete';
        if($type=='delete'){
            $info=array();
        }else{
            $info['like']=unserialize($circle['like']);
            $info['comment']=unserialize($circle['comment']);
        }

        $lists= self::$db->query("select * from app_friend where userid='{$userid}'");
        $lists[]=array('friendid'=>$userid);
        if(count($lists)>0){
            foreach ($lists as $value){
                $touid=$value['friendid'];

                $data=array('type'=>'circle_push', 'data'=>array('id'=>$id,'action'=>$type,'info'=>$info));
                self::send_push($touid,$data);
            }

        }
        if($issend==1){
            //发送消息通知
            $fromuser=self::userinfo($fromid);
            $replyid=0;
            if($action=='like') $content="[like]";
            else if($action=='comment'){

              $temp=  $info['comment'][count($info['comment'])-1] ;
              $content=$temp['content'];
              if($temp['replyid']!=$userid) $replyid=$temp['replyid'];
            }
            $now=time();
            if($fromid!=$userid){
                 $sql="insert into app_circle_msg(cid,from_uid,to_uid,`type`,`content`,time) values('{$id}','{$fromid}','{$userid}','{$action}','{$content}','{$now}')";
                 self::$db->query($sql);
                 self::send_circle_tips($userid);
            }
            if($fromid!=$replyid && $replyid>0){
                $sql="insert into app_circle_msg(cid,from_uid,to_uid,`type`,`content`,time) values('{$id}','{$fromid}','{$replyid}','{$action}','{$content}','{$now}')";
                self::$db->query($sql);
                self::send_circle_tips($replyid);
            }



        }


    }

    public  function send_circle_tips($uid){

        $row=self::$db->row("select count(*) as num from app_circle_msg where to_uid='{$uid}' and `read`='0'");
        if(!$row['num']) $row['num']=0;
        $data=json_encode(array('type'=>'data_circle_tips','data'=>$row['num']));
        Gateway::sendToUid($uid,$data);

    }

    public  function  send_push($userid,$data=array()){
        if(Gateway::isUidOnline($userid)) {
            $content=json_encode($data,JSON_UNESCAPED_UNICODE);
             Gateway::sendToUid( $userid,$content);

        }
        else{
            $now=time();
            $content=json_encode($data,JSON_UNESCAPED_UNICODE);
            $cid=$data['data']['id'];
            self::$db->query("insert into app_circle_push(uid,content,time,cid) values ('{$userid}','{$content}','{$now}','{$cid}')");
        }
    }
    public  function  sendpsuh($userid){
        if(Gateway::isUidOnline($userid)) {
            $list = self::$db->query("select * from app_circle_push where uid='{$userid}' order by id desc");
            if (count($list) > 0) {
                foreach ($list as $value) {

                    Gateway::sendToUid( $userid,$value['content']);
                }
                self::$db->query("delete  from app_circle_push where uid='{$userid}'");
            }
        }
    }

    public function recharge_add($userid, $money, $bank)
    {
        $bank = serialize($bank);
        $addtime = time();
        $sql = "insert into  app_recharge(uid,money,addtime,status,bank) values('{$userid}','{$money}','{$addtime}','0','{$bank}')";
        self::$db->query($sql);
        if (self::$db->lastInsertId() > 0) {

            $row = self::$db->row("select count(*) as num from app_recharge where status='0'");
            $data = array('type' => 'recharge', 'money' => $money, 'num' => $row['num']);

            Gateway::sendToGroup('admin', json_encode($data));


        }

    }

    public function plat_add($userid, $money, $bank_type)
    {
        $user=self::get_userinfo($userid);
        $bank = unserialize($user['bankinfo']);
        $bank[$bank_type]['type']=$bank_type;
        $bank=serialize($bank[$bank_type]);
        $addtime = time();
        $pre=self::get_system('plat_fee');
        $fee=number_format($money*$pre/100,2,'.','');
        $money=$money-$fee;
        $sql = "insert into  app_plat(uid,money,fee,`time`,status,bank) values('{$userid}','{$money}','{$fee}','{$addtime}','0','{$bank}')";
        self::$db->query($sql);
        $id=self::$db->lastInsertId();
        if ($id > 0) {
            self::add_money($userid,-$money-$fee,'plat',$id,$user['real'],'提现');
            $row = self::$db->row("select count(*) as num from app_plat where status='0'");
            $data = array('type' => 'plat', 'money' => $money, 'num' => $row['num']);

            Gateway::sendToGroup('admin', json_encode($data));


        }

    }
    public function addmoney($data)
    {

        $user = self::get_userinfo($data['uid']);
        $usermoney = $user['money'];
        Gateway::sendToUid($data['uid'], json_encode(array('type' => 'addmoney', 'money' => $data['money'], 'usermoney' => $usermoney, 'message' => $data['message'])));
    }

    public function set_yingkui($uid, $type, $money, $time = 0)
    {
        if($type=='buy' or $type=='plate')$money = abs($money);
        if (!$time) $time = strtotime(date('Y-m-d', time()) . ' 00:00:00');
        $sql = "select * from app_user_yingkui where uid='{$uid}' and time='{$time}'";
        $row = self::$db->row($sql);
        if ($row['id'] > 0) {

            $sql = "update app_user_yingkui set `{$type}`=`{$type}`+$money where id='{$row['id']}'";
        } else {
            $user = self::get_userinfo($uid);
            $sql = "insert into app_user_yingkui (uid,`time`,`{$type}`,`real`)values('{$uid}','{$time}','{$money}','{$user['real']}')";
        }
        self::$db->query($sql);

    }

    public function get_system($key)
    {
        $row = self::$db->row("select * from app_system where `key`='{$key}'");
        if ($row['id'] > 0) {
            return $row['value'];
        } else {
            self::$db->query("insert into app_system(`key`,`value`) values ('{$key}','')");
            return 0;
        }

    }

    public function update_system($key, $value)
    {
        self::$db->query("update app_system set `value`='{$value}' where `key`='{$key}'");
    }

    public function get_user_pids($uid, $arr = array())
    {
        $user = self::get_userinfo($uid);

        if ($user['pid'] > 0) {
            $arr[] = $user['pid'];
            return self::get_user_pids($user['pid'], $arr);
        } else {
            return $arr;
        }

    }

    function get_yingkui($userid, $type, $fromtime)
    {

        if (count($userid) > 0) {
            $uids = implode(',', $userid);
        } else {
            if ($userid > 0) $uids = $userid;
            else return 0;
        }
        $row = self::$db->row("select sum(`{$type}`) as num from app_user_yingkui where uid in ({$uids}) and `time`='{$fromtime}' ");
        $num = $row['num'];
        if (!$num) $num = 0;
        $num = number_format($num, 0, '.', '');
        return $num;
    }


    public function count_rebate($fromtime, $rule)
    {
        $rebates = array();
        $list = self::$db->query("select * from app_user_yingkui where `time`='{$fromtime}' and fee>0 and `real`=1 order by id asc");

        if (count($list) > 0) {
            foreach ($list as $value) {

                $pids = self::get_user_pids($value['uid']);
                $userbuy = $value['fee'];

                if (count($pids) > 0) {
                    foreach ($pids as $key => $pid) {
                        if (isset($rebates[$pid]) and count($rebates[$pid]) > 0) {
                            $pre = $rebates[$pid]['pre'];
                            $pre1 = pow($pre / 100, $key + 1);
                            $rebates[$pid]['money'] += $userbuy * $pre1;
                        } else {

                            $tt = self::$db->row("select sum(`buy`) as num from app_user_yingkui where uid in (select id from app_user where pid='{$pid}') and `time`='{$fromtime}' ");
                            $buy = $tt['num'];
                            if (!$buy) $buy = 0;

                            $pre = 0;

                            foreach ($rule as $v) {
                                if ($buy >= $v['from']*10000 and $buy < $v['to']*10000) {
                                    $pre = $v['pre'];
                                    break;
                                }
                            }
                            $pre1 = pow($pre / 100, $key + 1);
                            $rebates[$pid] = array('money' => $userbuy * $pre1, 'pre' => $pre);

                        }

                    }
                }


            }
        }

        return $rebates;

    }

    public function set_rebate()
    {

        $rebate_time = self::get_system('rebate_time');
        if ($rebate_time < strtotime(date('Y-m-d', time()) . ' 00:00:00')) {
          self::update_system('rebate_time', time());
            $rule = self::get_system('daili_rule');
            $rule = unserialize($rule);
            $fromtime = strtotime(date('Y-m-d', time() - 24 * 3600) . ' 00:00:00');
            $rebates = self::count_rebate($fromtime, $rule);

            foreach ($rebates as $uid=> $value) {
                $money = number_format($value['money'], 2, '.', '');
                if ($money > 0) {
                    self::add_money($uid,$money,'rebate',0,1,'下级返点');
              }
            }


        } else {

        }
    }

//账变记录
    public function add_money($userid, $money, $type, $buyid, $real, $content = '')
    {
          $money=number_format($money,2,'.','');
        self::$db->query("update app_user set money=money+$money where id='{$userid}'");
        $user = self::get_userinfo($userid);
        if ($real == 1) {

            $addtime = time();
            $sql = "insert into app_orders (uid,money,usermoney,`type`,buyid,`real`,addtime,content) values ('{$userid}','{$money}','{$user['money']}','{$type}','{$buyid}','{$real}','{$addtime}','{$content}')";
            self::$db->query($sql);

        } else {
            if ($user['money'] < 1) {
                self::add_money($userid, rand(100, 10000), 'recharge', '', 0, '虚拟充值');
                $user = self::get_userinfo($userid);

                // self::userOut($userid,$buyid,0);
            }
        }
        if($type!=='plat') self::set_yingkui($userid, $type, $money);


        return $user['money'];

    }
}