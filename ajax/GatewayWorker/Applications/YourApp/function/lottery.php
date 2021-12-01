<?php
use \GatewayWorker\Lib\Gateway;
use \Workerman\Lib\Timer;
class lottery{
    public static $db  =null;
    public static $game=null;
    public  static $log=false;
    public  static $pageSize=1;
    public  static $times=3;
    public function __construct($db)

    {
        self::$db=$db;
       $arr=array();
       $arr[]=array('gamekey'=>'txffc','title'=>'腾讯分分彩','url'=>"https://www.manycai.tj/rest/lottery/list?lotteryId=37&current=1&pageSize=".self::$pageSize,'lastissue'=>'','lasttime'=>0,'time'=>60);
        $arr[]=array('gamekey'=>'hn5fc','title'=>'河内五分彩','url'=>"https://www.manycai.tj/rest/lottery/list?lotteryId=48&current=1&pageSize=".self::$pageSize,'lastissue'=>'','lasttime'=>0,'time'=>300);
        $arr[]=array('gamekey'=>'hn1fc','title'=>'河内1分彩','url'=>"https://www.manycai.tj/rest/lottery/list?lotteryId=50&current=1&pageSize=".self::$pageSize,'lastissue'=>'','lasttime'=>0,'time'=>60);
        $arr[]=array('gamekey'=>'qqffc','title'=>'奇趣分分彩','url'=>"http://qniupin.com/api/tencent/onlineim",'lastissue'=>0,'lasttime'=>0,'time'=>60);
        self::$game=$arr;
       self::start();

    }
    public  function start(){

        foreach (self::$game as $key=>$value){
            $time=($key+1)*0.3;
            Timer::add($time, function($key)
            {
                self::start_lotery($key);

            },array($key),false);
        }
    }
    public function  start_lotery($key){

        $game=self::$game[$key];
      //self::log("准备采集{$game['title']}");
         $url=$game['url'];
        $res=  self::curl($url);
        if($res){
            $data= self::setdata($res,$key);
           if($data)  self::save_data($data,$key);
        }
        if(time()-$game['lasttime']>=$game['time']-10) $times=self::$times-1;
        else $times=self::$times+1;

      //  $times=rand(self::$times-1,self::$times+1);
        Timer::add($times, function($key)
        {
            self::start_lotery($key);
        },array($key),false);
    }

     //解析开奖数据
    public function setdata($data,$key){
        $game=self::$game[$key];
        $data=json_decode($data,true);
         if(strpos($game['url'],'qniupin')!=false){
             $res=array();
             if(count($data)>0){
                 for($i=0;$i<self::$pageSize;$i++){
                     $res[]=  self::get_qqdata($data[$i]);
                 }
             }
           //  print_r($res);
             return $res;
         }else{
             $data=$data['data']['records'];
             $res=array();
             if(count($data)>0){
                 foreach ($data as $value){
                     $arr=array();
                     $arr['expect']=$value['issueNo'];
                     $arr['number']=$value['openCode'];
                     $arr['time']=$value['predictedTime'];
                     $res[]=$arr;
                 }
             }
             return $res;
         }


    }

    //解析奇趣开奖结果
    public  function get_qqdata($data){
        $arr=array();
        $onlinenumber=$data['onlinenumber'];
        $sum=0;
        for($i=0;$i<strlen($onlinenumber);$i++){
            $sum+=substr($onlinenumber,$i,1);
        }
        $sum=$sum%10;
        $arr['number']=$sum.','.substr($onlinenumber,strlen($onlinenumber)-4,1).','.substr($onlinenumber,strlen($onlinenumber)-3,1).','.substr($onlinenumber,strlen($onlinenumber)-2,1).','.substr($onlinenumber,strlen($onlinenumber)-1,1);
        $onlinetime=$data['onlinetime'];
        $arr['time']=substr($onlinetime,0,17).'05';
        $aa=substr($onlinetime,0,4).substr($onlinetime,5,2).substr($onlinetime,8,2);
        $bb=60*substr($onlinetime,11,2)+substr($onlinetime,14,2);
        $bb=sprintf("%04d", $bb);
        $arr['expect']=$aa.'-'.$bb;

          return $arr;

    }

    //保存开奖数据
    public  function save_data($data,$key){
        $game=self::$game[$key];
        $gamekey=$game['gamekey'];
        if(count($data)>0){
            foreach ($data as $value){
        // self::log("提交{$game['title']}第{$value['expect']}期开奖号码{$value['number']}");
                if($game['lastissue']!=$value['expect']){

                    $row=   self::$db->row("select * from app_lottery_{$gamekey} where period='{$value['expect']}' ");
                    if($row['id']>0){
                        self::$game[$key]['lastissue']=$value['expect'];
                    }else{
                        $addtime=time();
                        $lottime=strtotime($value['time']);
                        self::$game[$key]['lasttime']=$addtime;

                        $sql="insert into app_lottery_{$gamekey} (period,`number`,addtime,lottime) values('{$value['expect']}','{$value['number']}','{$addtime}','{$lottime}')";
                      //  self::log($sql);
                        self::$db->query($sql);
                        self::log("{$game['title']}第{$value['expect']}期采集成功");
                        if(date('Y')==0 and date('i')<10) self::clear_lottery();
                    }

                }


            }
        }

       //

    }

    public static function curl($url, $params = false, $ispost = 0)
    {
        if(strpos($url,'https')!==false) $https=1;else $https=0;

        $httpInfo = array();
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2272.118 Safari/537.36');
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        if ($https) {
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); // 对认证证书来源的检查
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE); // 从证书中检查SSL加密算法是否存在
        }
        if ($ispost) {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
            curl_setopt($ch, CURLOPT_URL, $url);
        } else {
            if ($params) {
                if (is_array($params)) {
                    $params = http_build_query($params);
                }
                curl_setopt($ch, CURLOPT_URL, $url . '?' . $params);
            } else {
                curl_setopt($ch, CURLOPT_URL, $url);
            }
        }

        $response = curl_exec($ch);


        curl_close($ch);
        return $response;
    }
    public  function clear_lottery(){

        $system=self::$db->row("select * from app_system where `key`='lotterytime'");
        $lotterytime=$system['value'];
        $fromtime=time()-$lotterytime*24*3600;
        $list= self::$db->query("select * from app_game");
        foreach ($list as $value){
            $showkey=strtolower($value['showkey']);
            self::$db->query("delete from app_lottery_{$showkey} where lottime<'{$fromtime}'");
        }

    }

    public function  log($str){
     $str=  iconv('UTF-8','GBK',$str);
     if(self::$log==true)
        echo date('H:i:s').' '.$str.'
';

    }

}