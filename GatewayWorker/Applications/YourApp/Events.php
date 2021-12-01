<?php
/**
 * This file is part of workerman.
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the MIT-LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @author walkor<walkor@workerman.net>
 * @copyright walkor<walkor@workerman.net>
 * @link http://www.workerman.net/
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 */

/**
 * 用于检测业务代码死循环或者长时间阻塞等问题
 * 如果发现业务卡死，可以将下面declare打开（去掉//注释），并执行php start.php reload
 * 然后观察一段时间workerman.log看是否有process_timeout异常
 */
//declare(ticks=1);

use \GatewayWorker\Lib\Gateway;
use \Workerman\Lib\Timer;
require_once 'mysql-master/src/Connection.php';
require_once "function/room.php";
require_once "function/user.php";
require_once "function/chat.php";

/**
 * 主逻辑
 * 主要是处理 onConnect onMessage onClose 三个方法
 * onConnect 和 onClose 如果不需要可以不用实现并删除
 */
class Events
{
    public static $db = null;
    public  static $room;
    public  static $user;
    public  static $chat;


    public static function onWorkerStart($worker)
    {
        date_default_timezone_set('PRC');
        self::$db = new \Workerman\MySQL\Connection('localhost', '3306', 'root', 'tE9MKDewI5hfA5gT', 'pcchat');

        self::$room=  new room(self::$db);
        self::$user=  new user(self::$db);
        self::$chat=  new chat(self::$db,self::$user);
    }

    /**
     * 当客户端连接时触发
     * 如果业务不需此回调可以删除onConnect
     * 
     * @param int $client_id 连接id
     */

    public static function onConnect($client_id)
    {
        // 向当前client_id发送数据 
        Gateway::sendToClient($client_id, json_encode(array('type'=>'bindsuccess','message'=>$client_id)));
        // 向所有人发送
       // Gateway::sendToAll("$client_id Login\r\n");
    }
    
   /**
    * 当客户端发来消息时触发
    * @param int $client_id 连接id
    * @param mixed $message 具体消息
    */
   public static function onMessage($client_id, $message)
   {
       // 向所有人发送
       $data=json_decode($message,true);
       //echo $message;
       switch ($data['type']) {
           case 'login':
               $time = date('Y-m-d H:i:s');
        //        Gateway::sendToUid('user_' + $data['token'], json_encode(array('type' => 'otherlogin', 'time' => $time)));
//
//               Gateway::joinGroup($client_id, 'user_' + $data['token']);
               Gateway::bindUid($client_id, $data['token']);
               if ($data['imgUri']) self::$user->setimgurl($data['imgUri']);

//               $userinfo = self::$user->userinfo($data['token']);
//
//               Gateway::sendToUid($data['token'], json_encode(array('type' => 'userinfo', 'data' => json_encode($userinfo))));
//
//               self::$user->send_setting($data['token']);
//               self::$user->sendpsuh($data['token']);

//               Timer::add(1, function ($data) {
//                   //echo $data['token'];
//                   self::$chat->sendOfffine($data['token']);
//                   $request_num = self::$user->request_num($data['token'], 1);
//                   Gateway::sendToUid($data['token'], json_encode(array('type' => 'request', 'num' => $request_num)));
//                   self::$user->send_circle_tips($data['token']);
//               }, array($data), false);
               // var_export(Gateway::getAllUidList());
               break;


           case 'send_newfriendnum':
               $request_num = self::$user->request_num($data['userid'], 1);
               Gateway::sendToUid($data['userid'], json_encode(array('type' => 'request', 'num' => $request_num)));
               //  echo  $data['token'].'login';
               break;
           case 'setting':
               self::$user->send_setting($data['token']);
               break;
           case 'otherlogin':
               $time = date('Y-m-d H:i:s');
              $user=self::$db->row("select * from app_user where id='{$data['uid']}'");
              if($user['vip']>0){
                  Gateway::sendToUid($data['uid'], json_encode(array('type' => 'otherlogin', 'time' => $time)));
              }

               Gateway::bindUid($client_id, $data['uid']);
               break;
           case 'php_send':
               print_r($data);
               break;
           case 'chat':
               if (!isset($data['mid'])) $data['mid'] = time() . rand(1000, 99999);
               self::$chat->send($data['userid'], $data['friend_uid'], $data['content'], $data['msgtype'], $data['mid']);
               break;
           case 'group':

               if (!isset($data['mid'])) $data['mid'] = time() . rand(1000, 99999);
               self::$chat->Group_send($data['userid'], $data['group_id'], $data['content'], $data['msgtype'], $data['mid']);
               break;
           case 'GroupCreatTips':
               self::$chat->GroupCreatTips($data['group_id']);
               break;
           case 'deleteGroup':
               self::$chat->deleteGroup($data['fromid'], $data['group_id'], $data['userid'],$data['mark']);
               break;
           case 'inviteIntoGroup':

               self::$chat->inviteIntoGroup($data['userid'], $data['group_id'], $data['user_id'],$data['apply']);
               break;

           case 'clearmsg':

               self::$chat->clearmsg($data['group_id']);
               break;
           case 'sendtip':

               self::$chat->sendtips($data['fromid'], $data['touid'], $data['content'],$data['msgtype'],array($data['tip_uid']));
               break;
           case 'sendtips':

               self::$chat->sendtips($data['user_id'], $data['group_id'], $data['content'], $data['msgtype'],array(),$data['tip_uid']);
               break;

           case 'groupsendtips':

               self::$chat->groupsendtips($data['group_id'], $data['content']);
               break;

           case 'logout':
               Gateway::unbindUid($client_id, $data['token']);
               break;
           case 'chat_back':

               self::$chat->chat_back($data['userid'], $data['msg_id'], $data['store']);
               break;
           case 'delete_chat':
               self::$chat->delete_chat($data['store'], $data['userid']);
               break;
           case 'GroupSet':
               self::$chat->groupset($data['mode'], $data['group_id'], $data['value'], $data['from_uid']);
               break;
           case 'groupset1':
               self::$chat->groupset1($data['mode'],$data['settype'], $data['group_id'], $data['userid'], $data['from_uid']);
               break;
           case 'GroupUpdate':
               self::$chat->GroupUpdate($data['group_id']);
               break;

           case 'msgtop':
               self::$user->msgtop($data['userid'], $data['storekey'], $data['istop']);
               break;

           case 'msgnotip':
               //   echo $message;
               self::$user->msgnotip($data['userid'], $data['storekey'], $data['no_tip']);
               break;
           case 'circle_push':

               self::$user->circle_push($data['id'], $data['fromid'], $data['action'], $data['userid'], $data['issend']);
               break;


           case 'test':

               Gateway::sendToClient($client_id, json_encode(array('type' => 'response', 'message' => 'this is test')));
               echo 'test';
               break;
           case 'bind':
               Gateway::bindUid($client_id, $data['uid']);
               Gateway::sendToUid($data['uid'], json_encode(array('type' => 'bindsuccess', 'message' => $data['uid'] . '绑定成功')));
               self::$user->join_all_group($data['uid'],$client_id);
               break;

           case "sendToUid":
               Gateway::sendToUid($data['uid'], json_encode(array('type' => 'message', 'message' => $data['message'])));
           case "sendToUser":
               Gateway::sendToUid($data['uid'], json_encode($data));

               break;
           case "addmoney":
               self::$user->addmoney($data);
               break;
           case "joinGroup":
               Gateway::joinGroup($client_id, $data['GroupId']);
               break;
           case "Join_Group":
                self::$chat->Join_Group($data['userid'],$data['group_id'],$client_id);
               break;
           case "Apply_Group":
               self::$chat->Apply_Group($data['userid'],$data['group_id'],$data['content']);
               break;
           case "deal_group_apply":
               self::$chat->deal_group_apply($data['userid'],$data['applyid'],$data['status'],$data['apply']);
               break;
           case "UserGameBuy":

               self::$room->UserGameBuy($data['roomid'], $data['uid'], $data['money'], $data['number']);
               break;
           case "apply_admin":

               self::$room->apply_admin($data['roomid'], $data['uid'], $data['money']);
               break;
           case "unapply_admin":

               self::$room->unapply_admin($data['roomid'], $data['uid']);
               break;
           case "recharge_add":

               self::$user->recharge_add($data['uid'], $data['money'], $data['bank']);
               break;
           case "plat_add":

               self::$user->plat_add($data['uid'], $data['money'], $data['banktype']);
               break;

           case "sendAll":
               Gateway::sendToAll(json_encode(array('type' => 'message', 'message' => $data['message'])));
               break;
           case 'ping':
              // print_r($data);
             $uid=   Gateway::getUidByClientId($client_id);
            if($uid>0) self::$db->query("update app_user set online='".time()."' where id='{$uid}'");
               break;

           default:
               break;
       }
   }
   
   /**
    * 当用户断开连接时触发
    * @param int $client_id 连接id
    */
   public static function onClose($client_id)
   {
       // 向所有人发送
//       session_start();
//      echo $_SESSION['uid'];

       //self::$room->GameOut($client_id);

      // GateWay::sendToAll("$client_id 已断开\r\n");
   }


   //////////////////////////////////////////////////////////////////////////
    ///
    ///

//    public  function JoinGroup($client_id,$data){
//        Gateway::joinGroup($client_id, $data['GroupId']);
//        Gateway::sendToClient($client_id,json_encode(array('type'=>'is_joinroom','roomid'=>$data['GroupId'],'message'=>"用户{$data['uid']}加入房间{$data['GroupId']}")));
//        Gateway::sendToGroup( $data['GroupId'],json_encode(array('type'=>'message','message'=>"用户{$data['uid']}加入房间{$data['GroupId']}")));
//    }
//

}
