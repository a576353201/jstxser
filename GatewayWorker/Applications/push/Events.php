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
require_once "function/push.php";


/**
 * 主逻辑
 * 主要是处理 onConnect onMessage onClose 三个方法
 * onConnect 和 onClose 如果不需要可以不用实现并删除
 */
class Events
{
    public static $db = null;
    public  static $lottery;
    public  static $room;
    public  static $user;
    public  static $chat;
    public  static  $plan;


    public static function onWorkerStart($worker)
    {
        date_default_timezone_set('PRC');
        self::$db = new \Workerman\MySQL\Connection('localhost', '3306', 'root', 'tE9MKDewI5hfA5gT', 'pcchat');

        self::$lottery=new push(self::$db);

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
