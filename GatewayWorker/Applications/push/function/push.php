<?php
use \GatewayWorker\Lib\Gateway;
use \Workerman\Lib\Timer;
class push{
    public static $db  =null;
    public static $game=null;
    public  static $log=true;
    public  static $pageSize=1;
    public  static $times=2;
    public  static $plan=null;
    public static $pushurl='http://103.152.132.234/api/push/push.php';
    public  static  $weburl="http://103.152.132.234/";
    public function __construct($db)

    {
        self::$db=$db;

       self::start_push();

    }

    public function  start_push(){
        $list=  self::$db->query("select *  from app_offline ");
        $typearr=array('image'=>'[图片]','redpacket'=>"[红包]",'video'=>'[视频]','voice'=>'[语音]');
        $taskid='';
        if(count($list)>0){
            foreach ($list as $value){
                $userid=$value['userid'];
                $msg_id=$value['msg_id'];
                $group_id=$value['group_id'];
                $data=json_decode($value['content'],JSON_UNESCAPED_UNICODE);
            //if($value['group_id']>0)    self::log(json_encode($data,JSON_UNESCAPED_UNICODE));
                $data=$data['data'];

                    if($group_id>0)
                        $title=$data['receiver5']['nickname'];
                        else $title=$data['nickname'];
                    $type=$data['message']['type'];
                    if($type=='text' || $type=='emotion' || $type=='tips' || $type=='time'){
                        $content=$data['message']['content'];
                        if(is_array($content)){
                            $content=$content['content'];
                        }
                    } else {
                        if(isset($typearr[$type])) $content=$typearr[$type];
                        else $content="给您留言了";
                    }
                    if($type && $type!=null){

                       if($group_id>0){
                           self::push_toGroup($data,$group_id,$title,$content,$msg_id);
                       }else{
                           self::push_toFriend($data,$userid,$title,$content,$msg_id);
                       }

                    }

        self::$db->query("delete from app_offline where id='{$value['id']}'");


            }

        }
        self::push_request();

//
//
        Timer::add(1, function()
        {
            self::start_push();
        },array(),false);
    }

    public static function push_toGroup($data,$group_id,$title,$content,$msg_id){

        $content=$data['sender']['nickname'].":".$content;
        $content=self::set_pushconent($content);
        $payload=json_encode(array('type'=>'group','id'=>$group_id,'title'=>$title,'content'=>$content,'msg_id'=>$msg_id));

        $url=self::$pushurl."?title={$title}&content={$content}&payload={$payload}";
        $fromtime=time()-72*3600;
       $group= self::$db->row("select * from app_group where id='{$group_id}'");
       if($group['id']>0){
           $user_id=$group['user_id'];
           $cache_key="G".$group_id;
           $str=" ";
          $tips= self::$db->query("select * from app_msgnotip where cache_key='{$cache_key}'");
          if(count($tips)>0){
              $uids=array();
              foreach ($tips as $v){
                  $uids[]=$v['userid'];
              }
              $uids=implode(',',$uids);
              $str.=" and userid not in ({$uids}) ";
          }

          $sql="select * from app_client where userid in ($user_id) and userid!='{$group['createid']}' and isonline='0' and time>'{$fromtime}' {$str}";
           $client= self::$db->query($sql);

       }


        if(count($client)>0){
            $cids=array();
            foreach ($client as $item){
                $cids[]=$item['cid'];
            }
            if(count($cids)>0){
                if(count($cids)<2) $sendtype='sign';
                else $sendtype='list';
                $cids=implode(',',$cids);

                $url.="&sendtype=".$sendtype;

            self::curl($url,array('cid'=>$cids,'showtitle'=>true,'type'=>'group'),1);
            self::log($url);
            self::log($cids);
            }
        }
        return true;
    }

    public static function push_toFriend($data,$userid,$title,$content,$msg_id){
        if (self::is_noptip($userid,$data)==false) {
            $content = $title . ':' . $content;
            $content = self::set_pushconent($content);
            $payload = json_encode(array('type' => 'friend', 'id' => $data['sender']['id'], 'title' => $title, 'content' => $content, 'msg_id' => $msg_id));
            $url = self::$pushurl . "?title={$title}&content={$content}&payload={$payload}";
            $client = self::$db->query("select * from app_client where userid='{$userid}' and isonline='0'");
            if (count($client) > 0) {
                $cids = array();
                foreach ($client as $item) {

                    $cids[] = $item['cid'];
                }
                if (count($cids) > 0) {
                    if (count($cids) < 2) $sendtype = 'sign';
                    else $sendtype = 'list';
                    $cids = implode(',', $cids);
                    $url .= "&sendtype=" . $sendtype;

                    self::curl($url, array('cid' => $cids, 'showtitle' => false,'type'=>'friend'), 1);
                    self::log($url);
                }
            }
        }
        return true;
    }


   public  static function is_noptip($userid,$data){
     if($data['group_id']==0){
         $cache_key=$data['cache_key'];

     }else{
       $cache_key="G".$data['group_id'];
       if($userid==$data['sender']['id']) return true;
     }
   ///  self::log("select * from app_msgnotip where userid='{$userid}' and cache_key='{$cache_key}'");
       $row= self::$db->row("select * from app_msgnotip where userid='{$userid}' and cache_key='{$cache_key}'");
       if($row['id']>0) return true;
       else
     return false;
    }


    public static function  set_pushconent($content){
        $content=strip_tags($content);
        $content=str_replace(' ','',$content);
        $content=str_replace('\n','',$content);
        if(strlen($content)>50) $content=self::GBsubstr($content,1,50).'...';
        return $content;
    }

    /**
     * @param null $db
     */
    public static function push_request()
    {
        $list=  self::$db->query("select *  from app_offline_request ");
        if(count($list)>0){
            foreach ($list as $value){
                $title=$value['title'];
                $content=$value['content'];
                $content=self::set_pushconent($content);
                $payload=json_encode(array('type'=>'request','id'=>1,'title'=>$title,'content'=>$content,'msg_id'=>0,'senderid'=>$value['type']));
                $url=self::$pushurl."?title={$title}&content={$content}&payload={$payload}";
                $uids=$value['uids'];
                $fromtime=time()-72*3600;
                self::log($uids);
                $sql="select * from app_client where userid in ($uids) and isonline='0' and time>'{$fromtime}' ";
                $client = self::$db->query($sql);
                if (count($client) > 0) {
                    $cids = array();
                    foreach ($client as $item) {

                        $cids[] = $item['cid'];
                    }
                    if (count($cids) > 0) {
                        if (count($cids) < 2) $sendtype = 'sign';
                        else $sendtype = 'list';
                        $cids = implode(',', $cids);
                        $url .= "&sendtype=" . $sendtype;

                        self::curl($url, array('cid' => $cids, 'showtitle' => true,'type'=>'request'), 1);
                        self::log($url);
                        self::log($cids);
                    }
                }

                self::$db->query("delete from app_offline_request where id='{$value['id']}'");
            }

        }

    }
    public static  function GBsubstr($str, $start, $length) {
// 先正常截取一遍.
        $res = substr( $str , $start , $length );
        $strlen = strlen( $str );
        $s='';
        /* 接着判断头尾各6字节是否完整(不残缺) */
// 如果参数start是正数
        if ( $start >= 0 ){
// 往前再截取大约6字节
            $next_start = $start + $length; // 初始位置
            $next_len = $next_start + 6 <= $strlen ? 6 : $strlen - $next_start;
            $next_segm = substr( $str , $next_start , $next_len );
// 如果第1字节就不是 完整字符的首字节, 再往后截取大约6字节
            $prev_start = $start - 6 > 0 ? $start - 6 : 0;
            $prev_segm = substr( $str , $prev_start , $start - $prev_start );
        }
// start是负数
        else{
// 往前再截取大约6字节
            $next_start = $strlen + $start + $length; // 初始位置
            $next_len = $next_start + 6 <= $strlen ? 6 : $strlen - $next_start;
            $next_segm = substr( $str , $next_start , $next_len );
// 如果第1字节就不是 完整字符的首字节, 再往后截取大约6字节.
            $start = $strlen + $start;
            $prev_start = $start - 6 > 0 ? $start - 6 : 0;
            $prev_segm = substr( $str , $prev_start , $start - $prev_start );
        }
// 判断前6字节是否符合utf8规则
        if ( preg_match( '@^([\x80-\xBF]{0,5})[\xC0-\xFD]?@' , $next_segm , $bytes ) ){
            if ( !empty( $bytes[1] ) ){
                $bytes = $bytes[1];
                $res .= $bytes;
            }
        }
// 判断后6字节是否符合utf8规则
        $ord0 = ord( $res[0] );
        if ( 128 <= $ord0 && 191 >= $ord0 ){
// 往后截取 , 并加在res的前面.
            if ( preg_match( '@[\xC0-\xFD][\x80-\xBF]{0,5}$@' , $prev_segm , $bytes ) ){
                if ( !empty( $bytes[0] ) ){
                    $bytes = $bytes[0];
                    $res = $bytes . $res;
                }
            }
        }
        return $res.$s;

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

    public static function  log($str){
 $str=  iconv('UTF-8','GBK',$str);
     if(self::$log==true)
        echo date('H:i:s').' '.$str.'
';

    }

}