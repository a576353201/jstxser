<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020-2-7
 * Time: 11:20
 */
use \GatewayWorker\Lib\Gateway;
use \Workerman\Lib\Timer;
class chat{
public  static $db;
public  static  $user;

    public  static  $system=array();
    public  function __construct($db,$user)

    {
        self::$db = $db;
        self::$user=$user;


        self::$system=self::get_system();
        $time=rand(1,5);
        Timer::add($time, function()
        {
            self::system_plan();

        },array(),false);
    }

  public static function system_plan(){
       Timer::add(30, function()
       {

           //24小时不领取的红包自动退回
           self::redpacket_back();

       },array(),true);

       Timer::add(1, function()
       {
           self::send_msgnote();

       },array(),true);

      Timer::add(3600, function()
      {

          //定时清理聊天记录
          self::delete_chathistory();

      },array(),true);

   }

    /**
     * @return mixed
     */
    public static function delete_chathistory()
    {
         $chatitme=self::$system['chattime'];
         if($chatitme>0 &&  $chatitme<3650){
             $fromtime=time()-$chatitme*3600*24;
             self::$db->query("delete from app_chat where addtime<'{$fromtime}'");
         }

    }

    /**
     * @return mixed
     */
    public static function redpacket_back()
    {
        $fromtime=time()-self::$system['redpacket_backtime']*3600;
        $sql="select * from app_readpacket where status=1 and addtime<='{$fromtime}'";
        $list=self::$db->query($sql);
        if(count($list)>0){
            foreach ($list as $item){
                if($item['isgroup']==1){
                    //群红包
                    $sum=0;
                    if($item['userids']!=''){
                        $userids=unserialize($item['userids']);

                        if(count($userids)){
                            foreach ($userids as $value){
                                $sum+=$value['money'];
                            }
                        }
                    }

                   if($sum<$item['summoney']){
                       $money=$item['summoney']-$sum;
                       self::$db->query("update app_user set money=money+$money,money1=money1+$money where id='{$item['sender_id']}'");
                       $user=self::$db->row("select * from app_user where id='{$item['sender_id']}'");
                       self::$db->query("insert into app_money (uid,money,money1,content,time,`type`) values('{$item['sender_id']}','{$money}','{$user['money']}','红包退回','".time()."','redpacket')");
                       self::$db->query("update app_readpacket set backmoney='{$money}' where id='{$item['id']}'");
                   }

                    $content="您发送的红包，超过".self::$system['redpacket_backtime']."未被抢光，已退还到你的账户余额";
                     self::sendtips($item['sender_id'],$item['chatid'],$content,'show',array(),$item['sender_id']);

                }else{
                    //个人红包
                    $content="您发送的红包，超过".self::$system['redpacket_backtime']."未被领取，已退还到你的账户余额";
                    self::sendtip($item['chatid'],$item['sender_id'],$content,'show',array('tip_uid'=>$item['sender_id']));

                    //更新账户余额
                    $money=$item['summoney'];
                    self::$db->query("update app_user set money=money+$money,money1=money1+$money where id='{$item['sender_id']}'");
                    $user=self::$db->row("select * from app_user where id='{$item['sender_id']}'");
                    self::$db->query("insert into app_money (uid,money,money1,content,time,`type`) values('{$item['sender_id']}','{$money}','{$user['money']}','红包未被领取','".time()."','redpacket')");

                }
                //更新红包状态
                self::$db->query("update app_readpacket set status='2',endtime='".time()."' where id='{$item['id']}'");
            }
        }

       $row=self::$db->query("select * from app_user where vip>0 and vip_time<='".time()."'");
        if(count($row)>0){
            foreach ($row as $value){
                self::$db->query("update app_user set vip_time=0,vip=0 where id='{$value['id']}'");
                self::send(self::$system['admin_id'],$value['id'],"您购买的VIP已经到期请及时续费");
            }

        }



    }




    public static  function  send_msgnote(){

       $list= self::$db->query("select * from app_note");
       if(count($list)>0){
           foreach ($list as $value){
               self::$db->query("delete  from app_note where id='{$value['id']}'");
               self::send($value['userid'],$value['touid'],$value['content'],$value['type']);

           }
       }

    }




    public static function  send($userid,$touid,$content,$type='text',$mid=''){
        if($type=='tips')
            $message=array('type'=>$type,'content'=>array('type'=>'time','text'=>$content));
        else
            $message=array('type'=>$type,'content'=>$content);
           $message=self::textkeyworks($message);
        $check=self::textkeyworks1($message);
        if($check!==true){
            self::sendtip($touid,$userid,$check['msg']);
            return false;
        }
        $now=time();

     if(!$mid) $mid=time().rand(1000,9999);
            if($userid>1){
                $sender=self::$user->userinfo($userid);
                if($sender['status']>0){
                    self::sendtip($touid,$userid,'消息发送失败,您的账号已被冻结');

                    return false;

                }
            }
            else
                {
                if($userid==0){

                    $sender=array('id'=>$userid,'nickname'=>self::$system['admin_nickname'],'avatar'=>self::$system['admin_logo']);
                }else{
                    $sender=array('id'=>$userid,'nickname'=>'验证消息','avatar'=>'static/images/noteico.png');
                }

            }

            $receiver=self::$user->userinfo($touid);
            $time=date('Y-m-d H:i:s',$now);
            $data=array('id'=>$touid,'cache_key'=>'U'.$touid,'self'=>1,'sender_id'=>$userid,'receiver_id'=>intval($touid),'group_id'=>0,'timestamp'=>$now,'time'=>$time,'_mid'=>$mid,'isloading'=>0);
            $data['message']=$message;
            $data['sender']=$sender;
            $data['receiver1']=$receiver;
            $data['nickname']=$receiver['nickname'];
            $data['avatar']=$receiver['avatar'];

             if(in_array($userid,explode(',',$receiver['backlist']))) {
                 self::sendtip($touid,$userid,'消息发送失败，对方已给你拉黑');

                 return false;

             }


            if($userid!=self::$system['admin_id'] && !self::$user->is_friend($userid,$touid)){

                self::sendtip($touid,$userid,'消息发送失败，你们已不是好友关系');

                return false;
            }
            $content=json_encode($content,JSON_UNESCAPED_UNICODE);
            if($type=='image'){
                $content=str_replace('"','',$content);

            }

        $sql="insert into app_chat(userid,touid,content,`type`,addtime) VALUES ('{$userid}','{$touid}','{$content}','{$type}','{$now}')";

        self::$db->query($sql);
        $id=self::$db->lastInsertId();
        if($id>0){
            $data['msg_id']=$id;
            $data1=json_encode(array('type'=>'chat','data'=>$data),JSON_UNESCAPED_UNICODE);
            self::sendToUid( $userid,$data1);
            $data['id']=$userid;
            $data['cache_key']='U'.$userid;
            $data['self']=0;
            $data['nickname']=$sender['nickname'];
            $data['avatar']=$sender['avatar'];

            $data2=json_encode(array('type'=>'chat','data'=>$data),JSON_UNESCAPED_UNICODE);
            self::sendToUid( $touid,$data2);

        }

    }

    public static function  Group_send($userid,$group_id,$content,$type='text',$mid=''){
        if(!$mid) $mid=time().rand(1000,9999);
        $now=time();
        if($type=='tips')
            $message=array('type'=>$type,'content'=>array('type'=>'time','text'=>$content));
        else
            $message=array('type'=>$type,'content'=>$content);
            $message=self::textkeyworks($message);
            $sender= self::group_userinfo($group_id,$userid);
            $group=self::groupinfo($group_id);
            $receiver=array('id'=>$group['id'],'nickname'=>$group['nickname'],'avatar'=>$group['avatar']);
            $uids=explode(',',$group['user_id']);


            $time=date('Y-m-d H:i:s',$now);
            $data=array('id'=>$group_id,'cache_key'=>'G'.$group_id,'self'=>1,'sender_id'=>$userid,'group_id'=>intval($group_id),'timestamp'=>$now,'time'=>$time,'_mid'=>$mid,'isloading'=>0);
            $data['message']=$message;
            $data['sender']=$sender;
            $data['receiver2']=$receiver;



        $check=self::textkeyworks1($message);

        if($check!==true){
            $message=array('type'=>'tips','content'=>array('type'=>'time','text'=>$check['msg']));
            $data['message']=$message;
            $data1=json_encode(array('type'=>'chat','data'=>$data),JSON_UNESCAPED_UNICODE);
            self::sendToUid( $userid,$data1,$group_id);
            return false;
        }

            if($type!='tips'){
                  $user=self::$user->userinfo($userid);;
                if($user['status']>0){
                    $message=array('type'=>'tips','content'=>array('type'=>'time','text'=>'发送失败，您的账号已被冻结'));
                    $data['message']=$message;
                    $data1=json_encode(array('type'=>'chat','data'=>$data),JSON_UNESCAPED_UNICODE);
                    self::sendToUid( $userid,$data1,$group_id);
                    return false;

                }


                if($user['status']>0){
                    $message=array('type'=>'tips','content'=>array('type'=>'time','text'=>'发送失败，发送太频繁,你已被禁言10分钟'));
                    $data['message']=$message;
                    $data1=json_encode(array('type'=>'chat','data'=>$data),JSON_UNESCAPED_UNICODE);
                    self::sendToUid( $userid,$data1,$group_id);
                    return false;

                }
                if($group['issendurl']==0 ){
                       if(strpos($group['manager_id'],$userid)!==false || $group['createid']===$userid ){

                       }else{
                           if($type=='text' || $type=='emotion'){
                               if(is_array($message['content'])){
                                   $text=$message['content']['content'];
                               }else {
                                   $text=$message['content'];
                               }
                               $arr=preg_match("/[http|https]:[\/]{2}[a-z]+[.]{1}[a-z\d\-]+[.]{1}[a-z\d]*[\/]*[A-Za-z\d]*[\/]*[A-Za-z\d]*/",$text);
                               if($arr){
                                   $message=array('type'=>'tips','content'=>array('type'=>'time','text'=>'发送失败，禁止发送超链接'));
                                   $data['message']=$message;
                                   $data1=json_encode(array('type'=>'chat','data'=>$data),JSON_UNESCAPED_UNICODE);
                                   self::sendToUid( $userid,$data1,$group_id);
                                return false;
                               }
                           }
                       }

                }
                if(strpos($group['deny_id'],$userid)!=false ){
                    $message=array('type'=>'tips','content'=>array('type'=>'time','text'=>'发送失败，您已被禁言'));
                    $data['message']=$message;
                    $data1=json_encode(array('type'=>'chat','data'=>$data),JSON_UNESCAPED_UNICODE);
                    self::sendToUid( $userid,$data1,$group_id);
                    return false;
                }
                if((!in_array($userid,$uids) || $group['is_delete']==1) && $userid!=$group['createid']){
                    $message=array('type'=>'tips','content'=>array('type'=>'time','text'=>'发送失败，您已经被移除了本群'));
                    $data['message']=$message;
                    $data1=json_encode(array('type'=>'chat','data'=>$data),JSON_UNESCAPED_UNICODE);
                    self::sendToUid( $userid,$data1,$group_id);
                    return false;
                }
            }


      self::sendGroupMessage($userid,$group_id,$uids,$data,$content,$type);



    }

    public static  function group_userinfo($group_id,$userid){


        $users=self::group_users($group_id);

        if(count($users)>0){
            foreach ($users as $value){
                if($value['id']==$userid){
                    $value['isin']=1;
                    return $value;
                }
            }

        }

       $user=  self::$user->userinfo($userid);
        $user['isin']=0;
    return $user;

     }

    /**
     * @return array|mixed
     */
    public static function setstr($num)
    {
        $str="";
        for($i=0;$i<$num;$i++){
            $str.="*";
           }
           return $str;
    }


    //关键词屏蔽
    public static function textkeyworks($message){
       $type=$message['type'];
       if($type=='text' || $type=='emotion'){
           $content=$message['content'];
           if(is_array($content)){
               $text=$content['content'];
           }else {
               $text=$content;
           }
         $words= explode('|',self::$system['msg_keywords']);
          foreach ($words as $value){
            $text= str_ireplace($value,self::setstr(strlen($value)),$text);
          }
           if(is_array($content)){
               $message['content']['content']=$text;
           }else {
               $message['content']=$text;
           }
       }
         return $message;
    }

    //违禁词退回
    public static function textkeyworks1($message){
        $type=$message['type'];
        if($type=='text' || $type=='emotion'){
            $content=$message['content'];
            if(is_array($content)){
                $text=$content['content'];
                if($content['type']=='remind'){
                    $remind=$content['remind'];
                    $text=str_replace('@{'.$remind['id'].'}','@'.$remind['nickname'],$text);
                }
            }else {
                $text=$content;
            }
          //  echo self::$system['msg_keywords1'];
            $words= explode('|',self::$system['msg_keywords1']);
            foreach ($words as $value){
                if(strpos(strtolower($text),strtolower($value))!==false){
                    return array('code'=>false,'word'=>$value,'msg'=>'消息发送失败，不能包含"'.$value.'"等词汇');
                }
            }
            $res=self::getcontact($text);
            if($res!=false){
                $arr=array('qq'=>'QQ','mobile'=>'手机','email'=>'邮箱','weixin'=>'微信');
                return array('code'=>false,'word'=>$arr[$res],'msg'=>'消息发送失败，不能包含'.$arr[$res].'等联系方式');
            }

        }
        return true;
    }


    //提取联系方式
    public static function getcontact($str=''){
        $res=false;
        if(!$str) $res;
        $phone = '/[^0-9+]*(?P<tel>(\+86[1][368][0-9]{9})|([1][368][0-9]{9}))[^0-9+]*/';//手机号匹配
        $qq = '/^.*\d{5,12}.*$/isu';
        $email = '/^.*[a-zA-Z0-9]+([-_.][a-zA-Z0-9]+)*@([a-zA-Z0-9]+[-.])+([a-z]{2,5}).*$/ims';
        $wchat = '/^.*[_a-zA-Z0-9]{5,19}+.*$/isu';
        ;
        if(preg_match($phone,$str)){
            $res='mobile';
      }
//else if(preg_match($qq,$str)){
//            $res='qq';
//        }
else if(preg_match($email,$str)){
            $res='email';
        }
//else if(preg_match($wchat,$str)){
//            $res='weixin';
//        }
        return $res;
    }


    public static function group_users($group_id){
        $group=self::groupinfo($group_id);
        $user_id=explode(',',$group['user_id']);
        $manager_id=explode(',',$group['manager_id']);
        $uids=array(array('id'=>$group['createid'],'type'=>'owner'));
        if(count($manager_id)){
            foreach ($manager_id as $v){
                if($v!=$group['createid'] && $v>0) $uids[]=array('id'=>$v,'type'=>'manager');
            }
        }
        if(count($user_id)){
            foreach ($user_id as $v){
                if($v!=$group['createid'] and !in_array($v,$manager_id) && $v>0) $uids[]=array('id'=>$v,'type'=>'user');
            }
        }
        if(count($uids)){
            $nicknames=unserialize($group['nicknames']);
            foreach ($uids as $key=> $v){

                $u=self::$user->userinfo($v['id']);
                $uids[$key]['avatar']=$u['avatar'];
                $uids[$key]['nickname']=$u['nickname'];
                $uids[$key]['name']=$u['nickname'];
                $uids[$key]['isvip']=$u['isvip'];
                $temp=self::groupinfo($group_id,$v['id']);
                $uids[$key]['is_deny']=$temp['is_deny'];

                if(count($nicknames)>0){
                    foreach ($nicknames as $k1=>$v1){
                        if($v1['id']==$v['id']){
                            if($v1['name']) $uids[$key]['nickname']=$v1['name'];
                            if($v1['jointime']) $uids[$key]['jointime']=$v1['jointime'];
                        }
                    }
                }

            }
        }
        return $uids;
    }




    public static  function  sendGroupMessage($sender_id,$group_id,$uids,$data,$content,$type,$tip_uid=0){

        $now=time();


        if(is_array($content)){
            $content=json_encode($content,JSON_UNESCAPED_UNICODE);
        }else {
           // $content = preg_replace('/[\xF0-\xF7].../s', '', $content);

          //  $content = preg_replace('/[\x{10000}-\x{10FFFF}]/u', '', $content);
         //   $content=$content;
        }
  //
        if($type=='image'){
            $content=str_replace('"','',$content);

        }
        if(!$tip_uid) $tip_uid=0;
        $sql="insert into app_chat(userid,groupid,content,`type`,addtime,tip_uid) VALUES ('{$sender_id}','{$group_id}','{$content}','{$type}','{$now}','{$tip_uid}')";

        self::$db->query($sql);
        $id=self::$db->lastInsertId();
        if($id>0) {
//        $row=    self::$db->row("select id from app_chat where userid='{$sender_id}' order by id desc limit 0,1");
//        $id=$row['id'];
            $data['msg_id']=$id;
            if (count($uids) > 0) {

                foreach ($uids as $v) {
                    if ($v == $sender_id) $data['self'] = 1;
                    else $data['self'] = 0;
                    $data1 = json_encode(array('type' => 'chat', 'data' => $data), JSON_UNESCAPED_UNICODE);
                    self::sendToUid($v, $data1, $group_id);

                }

            }
            $data1=json_encode(array('type' =>'chat','data' =>$data),JSON_UNESCAPED_UNICODE);
            $now=time();
            $sql="insert into app_offline(userid,content,`time`,group_id,msg_id) values('{$sender_id}','{$data1}','{$now}','{$group_id}','{$id}') ";
         //   self::log($sql);
            self::$db->query($sql);
//
//            Gateway::sendToGroup('G'.$group_id,$data1);

        }


    }
    public static function  log($str){
        $str=  iconv('UTF-8','GBK',$str);

            echo date('H:i:s').' '.$str.'
';

    }
    public static function sendtips($to_uid,$group_id,$content,$msg_type='',$data=array(),$tip_uid=0){

    $group= self::groupinfo($group_id);
    $fromid=$group['createid'];
    $message=array('type'=>'tips','content'=>array('type'=>'time','text'=>$content),'msg_type'=>$msg_type,'data'=>$data);
        $sender=self::$user->userinfo($fromid);
        if(strpos($to_uid,',')!==false)   $uids=explode(',',$to_uid);
        else
         $uids=array($to_uid);
        $now=time();
        $time=date('Y-m-d H:i:s',$now);
        $data=array('id'=>$group_id,'cache_key'=>'G'.$group_id,'self'=>0,'sender_id'=>$fromid,'group_id'=>intval($group_id),'timestamp'=>$now,'time'=>$time,'msg_id'=>0,'tip_uid'=>$tip_uid);
        $data['message']=$message;
        $data['sender']=$sender;
        $data['receiver3']=$group;
        $data['nickname']=$group['nickname'];
        $data['avatar']=$group['avatar'];

        self::sendGroupMessage($fromid,$group_id,$uids,$data,$content,'tips',$tip_uid);
//        if(count($uids)>0){
//            foreach ($uids as $v){
//                $data1=json_encode(array('type'=>'chat','data'=>$data),JSON_UNESCAPED_UNICODE);
//                self::sendToUid( $v,$data1,$group_id);
//            }
//
//        }
    }

    public static function sendtip($fromid,$touid,$content,$msg_type='',$data=array()){

        $receiver=self::$user->userinfo($touid);;

        $message=array('type'=>'tips','content'=>array('type'=>'time','text'=>$content),'msg_type'=>$msg_type,'data'=>$data);
        $sender=self::$user->userinfo($fromid);
        $now=time();
        $time=date('Y-m-d H:i:s',$now);
        $data=array('id'=>$fromid,'cache_key'=>'U'.$fromid,'self'=>0,'sender_id'=>$fromid,'group_id'=>0,'receiver_id'=>intval($touid),'timestamp'=>$now,'time'=>$time,'msg_id'=>0);
        $data['message']=$message;
        $data['sender']=$sender;
        $data['receiver4']=$receiver;
        $data['nickname']=$sender['nickname'];
        $data['avatar']=$sender['avatar'];
     $data1=json_encode(array('type'=>'chat','data'=>$data),JSON_UNESCAPED_UNICODE);
    self::sendToUid( $touid,$data1,0);

    }

   public static function groupsendtips($group_id,$content){
       $group= self::groupinfo($group_id);
          self::sendtips($group['user_id'],$group_id,$content);
   }
    public static function  delete_chat($store,$touid){
        $fromid=substr($store,1,strlen($store)-1);
        if(strpos($store,'G')!==false){
            self::sendtips($touid,$fromid,'','delete_chat',array());
        }else{
            self::sendtip($fromid,$touid,'','delete_chat');
        }
    }

    public static function  chat_back($userid,$msg_id,$store){
        $isadmin=0;
        if($userid=='admin') {
            $isadmin=1;
        }else $user=self::$user->userinfo($userid);;
        $chat=self::chatinfo($msg_id);
        if(strpos($store,'G')!==false){
            $group_id=substr($store,1,strlen($store)-1);
            $data=array('msg_id'=>$chat['id']);
            $group=self::groupinfo($group_id);
            $manager_id=explode(',',$group['manager_id']);
            if($userid!=$group['createid'] and !in_array($userid,$manager_id) and $isadmin==0){
                if(time()-$chat['addtime']>120){
                    $message=array('type'=>'tips','content'=>array('type'=>'time','text'=>'消息发送时间已大于2分钟，无法撤回'));
                    $data['message']=$message;
                    $data1=json_encode(array('type'=>'chat','data'=>$data),JSON_UNESCAPED_UNICODE);
                    self::sendToUid( $userid,$data1,$group_id);
                   // self::sendtips($userid,$group_id,"消息发送时间已大于2分钟，无法撤回");
                    return false;
                }else if($chat['userid']!=$userid){
                    $message=array('type'=>'tips','content'=>array('type'=>'time','text'=>'您无权撤回其他人的消息'));
                    $data['message']=$message;
                    $data1=json_encode(array('type'=>'chat','data'=>$data),JSON_UNESCAPED_UNICODE);
                    self::sendToUid( $userid,$data1,$group_id);
//                    self::sendtips($userid,$group_id,"您无权撤回其他人的消息");
                    return false;
                }
            }
            if($isadmin==1) $content='';
            else $content="{$user['nickname']}撤回了一条消息";
            self::sendtips($group['user_id'],$group_id,$content,'chat_back',$data);
          self::$db->query("delete from app_offline where msg_id='{$chat['id']}'");
            self::$db->query("update app_chat set isback='1' where id='{$chat['id']}'");
        }
        else {
            if($chat['id']>0){
                $data=array('msg_id'=>$chat['id']);
                if(time()-$chat['addtime']>120 and $isadmin==0){
                    self::sendtip($chat['touid'],$userid,"消息发送时间已大于2分钟，无法撤回");
                }else if($chat['userid']!=$userid and $isadmin==0){
                    self::sendtip($chat['touid'],$userid,"您无权撤回其他人的消息");
                }
                else{
                    if($isadmin==1){
                        self::sendtip($chat['touid'],$chat['userid'],"",'chat_back',$data);
                        self::sendtip($chat['userid'],$chat['touid'],"",'chat_back',$data);
                    }else{
                        self::sendtip($chat['touid'],$userid,"您撤回了一条消息",'chat_back',$data);
                        self::sendtip($userid,$chat['touid'],"{$user['nickname']}撤回了一条消息",'chat_back',$data);
                    }

                    self::$db->query("delete from app_offline where msg_id='{$chat['id']}'");
                    self::$db->query("update app_chat set isback='1' where id='{$chat['id']}'");
                }

            }
            else{

            }


        }



    }



    public static function groupinfo($id,$from_id=''){
        $group=    self::$db->row("select * from app_group where id='{$id}'");
       if($group){
           $user_id=explode(',',$group['user_id']);
           $group['people_count']=count($user_id);
           if($from_id==$group['createid']) $group['owner']=1;
           else  $group['owner']=0;
           if($group['avatar']==null or $group['avatar']=='') $group['avatar']='uploads/group.jpg';
           $nicknames=unserialize($group['nicknames']);
           if($from_id>0){
               if(strpos($group['user_id'],$from_id)!==false) $group['isin']=1;
               $userinfo=self::$user->userinfo($from_id);
               $mynickname=$userinfo['nickname'];
               if(count($nicknames)>0){
                   foreach ($nicknames as $key=> $value){
                       if($value['id']==$from_id){
                           $mynickname=$value['name'];
                           break;
                       }
                   }
               }
               $group['mynickname']=$mynickname;
           }
           else $group['isin']=0;
           $group['is_deny']= $group['is_owner']=$group['is_manager']=0;
           if(!$from_id) $group['is_deny']=3;
           else{
               if($group['createid']==$from_id) $group['is_owner']=1;
               if(strpos($group['manager_id'],$from_id)!==false) $group['is_manager']=1;
               if( $group['is_owner']==1 && $group['is_manager']==1)$group['is_deny']=0;
               else{
                   if($group['no_speaking']==1 ){
                       $group['is_deny']=2;
                   }
                   else{
                       if(strpos($group['deny_id'],$from_id)!==false)
                           $group['is_deny']=1;
                   }
               }

           }
       }

        return $group;
    }

    public static function  groupinfo_short($id,$from_id=''){
      $group=  self::groupinfo($id,$from_id);
      $res=array();
      $arr=array('id','nickname','avatar','deny_id','is_delete','createid');
      foreach ($arr  as $key=>$value){
          $res[$key]=$group[$key];
      }
      return $res;
    }

    public static function chatinfo($id){

        $data=    self::$db->row("select * from app_chat where id='{$id}'");
        return $data;
    }


    public static function groupset1($mode,$type,$group_id,$userid,$from_uid){
        $group=self::groupinfo($group_id);
        if($mode=='manage'){
            $uids=explode(',',$group['manager_id']);
             if($type==1) $uids[]=$userid;
             else{

                 $arr=array();
                 if(count($uids)>0){
                     foreach ($uids as $uid){
                         if($uid!=$userid and $uid>0) $arr[]=$uid;
                     }
                 }
                 $uids=$arr;
             }
            $value= implode(',', array_unique($uids));
            self::$db->query("update app_group set manager_id='{$value}' where id='{$group_id}'");
            $user=self::$user->userinfo($userid);;
            if($type==1){
                self::sendtips($group['user_id'],$group_id,$user['nickname']."已被设为管理员2",'',array(),"");
            }else{
                self::sendtips($group['user_id'],$group_id,$user['nickname']."已被取消管理员",'',array(),"");
            }

        }
        if($mode=='deny'){
            $uids=explode(',',$group['deny_id']);
            if($type==1) $uids[]=$userid;
            else{

                $arr=array();
                if(count($uids)>0){
                    foreach ($uids as $uid){

                        if($uid!=$userid and $uid>0) $arr[]=$uid;
                    }
                }
                $uids=$arr;
            }
            $value= implode(',', array_unique($uids));
            self::$db->query("update app_group set deny_id='{$value}' where id='{$group_id}'");
            $user=self::$user->userinfo($userid);;
            if($type==1){
                self::sendtips($group['user_id'],$group_id,$user['nickname']."已被禁言",'',array(),"");
            }else{
               self::sendtips($group['user_id'],$group_id,$user['nickname']."已解除禁言",'',array(),"");
            }

        }
         self::GroupUpdate($group_id);
    }



    function  groupset($mode,$group_id,$value,$from_uid){
        $group=self::groupinfo($group_id);
   if($mode=='manage'){
       self::$db->query("update app_group set manager_id='{$value}' where id='{$group_id}'");
       $deny_id1=explode(',',$group['manager_id']);
       $deny_id2=explode(',',$value);
       foreach ($deny_id2 as $v){
           if(!in_array($v,$deny_id1) and $v>0){
               $user=self::$user->userinfo($v);;
               self::sendtips($group['user_id'],$group_id,$user['nickname']."已被设为管理员1");
           }

       }
       foreach ($deny_id1 as $v){
           if(!in_array($v,$deny_id2) and $v>0){
               $user=self::$user->userinfo($v);;
               self::sendtips($group['user_id'],$group_id,$user['nickname']."已被取消管理员");
           }

       }
   }

   else if($mode=='deny'){
       self::$db->query("update app_group set deny_id='{$value}' where id='{$group_id}'");

       $deny_id1=explode(',',$group['deny_id']);
       $deny_id2=explode(',',$value);
      foreach ($deny_id2 as $v){
          if(!in_array($v,$deny_id1) and $v>0){
              $user=self::$user->userinfo($v);;
              self::sendtips($group['user_id'],$group_id,$user['nickname']."已被禁言");
          }

      }

       foreach ($deny_id1 as $v){
           if(!in_array($v,$deny_id2) and $v>0){
               $user=self::$user->userinfo($v);;
               self::sendtips($group['user_id'],$group_id,$user['nickname']."已被解除禁言");
           }

       }

      // self::sendtips($group_id['user_id'])

   }
        Gateway::sendToUid( $from_uid,json_encode(array('type'=>'group_response','data'=>'设置成功')));

    }

    public static function  GroupUpdate($group_id){
        $group= self::groupinfo($group_id);
        $uids=explode(',',$group['user_id']);
        if(count($uids)){
            foreach ($uids as $uid){
                Gateway::sendToUid($uid,json_encode(array('type'=>'group_update','data'=>$group)));
            }

        }


    }
    public static function group_old_ids($group_id,$invite_id){
        $group= self::groupinfo($group_id);
        $user_id=$group['old_ids'].','.$invite_id;
        $user_id=array_unique(explode(',',$user_id));
        $user_id=implode(',',$user_id);

        self::$db->query("update  app_group set `old_ids`='{$user_id}' where id='{$group_id}'");
    }


     public static function inviteIntoGroup($userid,$group_id,$invite_id,$apply=0){

        if($apply==1){
            $invite_id=array_unique(explode(',',$invite_id));
            if(count($invite_id)>0){
                foreach ($invite_id as $id){
                    self:: Apply_Group($id,$group_id,"",$userid);
                }
            }

        }else{
            $group= self::groupinfo($group_id);
            $user_id=$group['user_id'].','.$invite_id;
            $user_id=array_unique(explode(',',$user_id));
            $user_id=implode(',',$user_id);
            self::$db->query("update  app_group set `user_id`='{$user_id}' where id='{$group_id}'");
            $nicknames=unserialize($group['nicknames']);
            $isin=0;
            if(!$nicknames) $nicknames=array();
            if(count($nicknames)>0){
                foreach ($nicknames as $k1=>$v1){
                    if($v1['id']==$user_id){
                        $nicknames['jointime']=time();
                        $isin=1;
                        break;
                    }
                }
            }
            if($isin==0){
                $nicknames[]=array('id'=>$userid,'name'=>'','jointime'=>time());
            }
            $nicknames=serialize($nicknames);
            self::$db->query("update  app_group set `nicknames`='{$nicknames}' where id='{$group_id}'");
            $user=self::$user->userinfo($userid);
            $content=array();
            $uids=explode(',',$invite_id);
            if(count($uids)>0){
                foreach ($uids as $uid){
                    $u=self::$user->userinfo($uid);
                    if($u['nickname']) $content[]=$u['nickname'];
                }
            }
            if(count($content)>0){
                $content=implode(',',$content);


                        self::sendtips($user_id,$group_id,"{$user['nickname']}邀请了".$content.'进群','','',$uid);


            }


        }
         Gateway::sendToUid( $userid,json_encode(array('type'=>'apply_response','data'=>array('code'=>1,'group'=>$group,'message'=>'邀请成功'))));
     }

     //检查加群上线

    /**
     * @return mixed
     */
    public static function check_group_max($userid)
    {
       $user= self::$db->row("select * from app_user where id='{$userid}'");
        if($user['vip']>0){
            if($user['vip']==3){
                $user['usertype']=3;
            }
            else $user['usertype']=2;
        }
        else{
            if($user['isvip']==1) $user['usertype']=1;
           else $user['usertype']=0;
        }
        $max= self::$system['group_join'.$user['usertype']];
       $row= self::$db->row("select count(*) as num from app_group where user_id like '%{$userid}%'");
       if($row['num']>=$max){
           Gateway::sendToUid( $userid,json_encode(array('type'=>'apply_response','data'=>array('code'=>0,'message'=>"您最多可以加入{$row['num']}个群组,如需更多请升级为VIP"))));
           return false;
       }

       return true;
    }



     //申请入群，无审核
      public static function Join_Group($userid,$group_id,$client_id=''){
           if(self::check_group_max($userid)==false){
               return false;
           }
$group= self::groupinfo($group_id);
$user_id=$group['user_id'].','.$userid;
$user_id=array_unique(explode(',',$user_id));
$user_id=implode(',',$user_id);
self::$db->query("update  app_group set `user_id`='{$user_id}' where id='{$group_id}'");
        if($client_id)  Gateway::joinGroup($client_id, 'G'.$group_id);;
          $nicknames=unserialize($group['nicknames']);
          $isin=0;
          if(!$nicknames) $nicknames=array();
          if(count($nicknames)>0){
              foreach ($nicknames as $k1=>$v1){
                  if($v1['id']==$user_id){
                      $nicknames['jointime']=time();
                      $isin=1;
                      break;
                  }
              }
          }
          if($isin==0){
              $nicknames[]=array('id'=>$userid,'name'=>'','jointime'=>time());
          }
          $nicknames=serialize($nicknames);
          self::$db->query("update  app_group set `nicknames`='{$nicknames}' where id='{$group_id}'");
           $user=self::$user->userinfo($userid);
           self::sendtips($user_id,$group_id,"{$user['nickname']}进入了本群222",'show');
          if($client_id)  Gateway::sendToUid( $userid,json_encode(array('type'=>'apply_response','data'=>array('code'=>1,'group'=>$group,'message'=>'您已成功入群'))));

      }

      //加群申请，提交审核

    public static function  Apply_Group($userid,$group_id,$content,$invite_id=0){
        if(self::check_group_max($userid)==false){
            return false;
        }
        $group= self::groupinfo($group_id);
        if($group['id']>0 and $group['is_delete']==0){
            if(strpos($group['user_id'],$userid)!==false){
                Gateway::sendToUid( $userid,json_encode(array('type'=>'apply_response','data'=>array('code'=>2,'group'=>$group,'message'=>'您已经是该群成员，不要重复申请'))));
            }
           else if(strpos($group['backlist'],$userid)!==false){
                Gateway::sendToUid( $userid,json_encode(array('type'=>'apply_response','data'=>array('code'=>2,'group'=>$group,'message'=>'加群失败'))));
            }
            else{
               $now=time();

              $apply=   self::$db->row("select * from app_group_apply where userid='{$userid}' and group_id='{$group_id}' and status='0'");
              if($apply['id']>0){
                $applyid=$apply['id'];
                $content1=unserialize($apply['content']);
                if($content) $content1[]=$content;
                $content1=serialize($content1);
                  self::$db->query("update app_group_apply set addtime='".time()."',content='{$content1}',del_uids='@' where id='{$applyid}'");

              }else{
                  $content1=serialize(array($content));
                  $sql="insert into app_group_apply(userid,group_id,content,addtime) values('{$userid}','{$group_id}','{$content1}','{$now}')";
                  self::$db->query($sql);
                  $applyid=self::$db->lastInsertId() ;
              }

                if($applyid>0){
                    $uids=array($group['createid']);
                    $manager_id=explode(',',$group['manager_id']);
                    if(count($manager_id)>0){
                        foreach ($manager_id as $uid){
                            if($uid>0 and !in_array($uid,$uids)) $uids[]=$uid;

                        }
                    }
                    $user=self::$user->userinfo($userid);
                    if($invite_id>0) $invite=self::$user->userinfo($invite_id);
                    if(count($uids)>0){
                        if($invite_id>0) $text=$invite['nickname'].'邀请'.$user['nickname']."加入".$group['name'];
                        else $text=$user['nickname']."申请加入".$group['name'];
                        foreach ($uids as $touid){

                       $content=array('type'=>'apply','text'=>$text,'other'=>array('group_id'=>$group_id,'groupname'=>$group['name'],'nickname'=>$user['nickname'],'userid'=>$userid,'avatar'=>$user['avatar'],'applyid'=>$applyid,'content'=>$content,'status'=>0));
                            self::send(1,$touid,$content,'apply');
                        }
                        $time=time();
                        $userids=implode(',',$uids);
                        self::$db->query("insert into app_offline_request (uids,title,content,`time`,`type`) values ('{$userids}','验证消息','{$text}','{$time}','group')");

                    }



                }else{

                    Gateway::sendToUid( $userid,json_encode(array('type'=>'apply_response','data'=>array('code'=>0,'group'=>$group,'message'=>'网络连接失败，请稍后再试'))));
                }



               //

                Gateway::sendToUid( $userid,json_encode(array('type'=>'apply_response','data'=>array('code'=>3,'group'=>$group,'message'=>'申请已提交，请耐心等待管理审核'))));
            }

        }else{
            Gateway::sendToUid( $userid,json_encode(array('type'=>'apply_response','data'=>array('code'=>0,'group'=>$group,'message'=>'该群已经解散'))));
        }


     //

    }

    //处理加群请求
    public static function deal_group_apply($userid,$applyid,$status,$applyinfo){

        $apply=   self::$db->row("select * from app_group_apply where id='{$applyid}'");
        if($apply['status']==0 and $apply['id']>0){
            $group= self::groupinfo($apply['group_id']);
           if($status==1){
             self::Join_Group($apply['userid'],$apply['group_id']);

              // self::send(self::$system['admin_id'],$apply['userid'],"您已经是：<span class=\"groupname\" onclick=\"parent.open_chatarea({$apply['group_id']},\"{$group['name']}\",\"{$group['avatar']}\");\">{$group['name']}</span>的成员，快去跟大家打个招呼吧");
           }else{
               $content="管理员拒绝您加群：<span style=\"color: #2319DC\" onclick=\"parent.group_detail({$apply['group_id']});\">{$group['name']}</span>";
               if($applyinfo['input']!="") $content.="<br>拒绝理由：".$applyinfo['input'];

               self::send(self::$system['admin_id'],$apply['userid'],$content);
               if($applyinfo['rediocheck']==true){
                   $backlist=$group['backlist'];
                   if($backlist!='') $backlist.=',';
                   $backlist.=$apply['userid'];
                   self::$db->query("update app_group set backlist='{$backlist}' where id='{$apply['group_id']}'");
               }

           }
          self::$db->query("update app_group_apply set status='{$status}',apply_uid='{$userid}',apply_content='{$applyinfo['input']}' where id='{$applyid}'");

            $apply=   self::$db->row("select * from app_group_apply where id='{$applyid}' ");
            $uids=array($group['createid']);
            $manager_id=explode(',',$group['manager_id']);
            if(count($manager_id)>0){
                foreach ($manager_id as $uid){
                    if($uid>0 and !in_array($uid,$manager_id)) $uids[]=$uid;

                }
            }
            if(count($uids)>0){
                foreach ($uids as $touid){
                    if($userid==$touid) $message="操作成功";
                    else $message='';
                    Gateway::sendToUid($touid ,json_encode(array('type'=>'deal_response','data'=>array('code'=>1,'from_uid'=>$userid,'applyid'=>$applyid,'apply'=>$apply,'message'=>$message))));
                }

            }
        }
        else{
            if($apply['status']==1) $message='已同意';else $message='已拒绝';
            if($userid!=$apply['userid']) $message="其他管理".$message;
            Gateway::sendToUid( $userid,json_encode(array('type'=>'deal_response','data'=>array('code'=>0,'from_uid'=>$userid,'applyid'=>$applyid,'apply'=>$apply,'message'=>$message))));
        }

    }




     public static function GroupCreatTips($group_id){
         $group= self::groupinfo($group_id);

         $content=array();
         $uids=explode(',',$group['user_id']);
         if(count($uids)>0){
             foreach ($uids as $uid){
                 $u=self::$user->userinfo($uid);
                 if($u['nickname']) $content[]=$u['nickname'];
             }
         }
         $content=implode(',',$content);
         self::sendtips($group['user_id'],$group_id,$content.'进群','show');
     }








     //退群  踢人   解散群
    public static function deleteGroup($fromid,$group_id,$userid,$mark=''){
        $group= self::groupinfo($group_id);
        $user_id=explode(',',$group['user_id']);
        $manager_id=explode(',',$group['manager_id']);
        //解散群
        if($userid==$group['createid'] and $userid==$fromid){

            self::$db->query("delete from app_offline where group_id='{$group_id}'");
            //self::sendtips($group['user_id'],$group_id,"您被移除了该群组","tips");
            self::$db->query("update  app_group set `user_id`='',is_delete='1' where id='{$group_id}'");
          //  Gateway::sendToUid( $userid,json_encode(array('type'=>'group_response','data'=>'群已被解散')));
              if(count($user_id)>0){
                  foreach ($user_id as $uid){
                      self::send(self::$system['admin_id'],$uid,"群组：{$group['name']}已被解散");
                      Gateway::sendToUid( $uid,json_encode(array('type'=>'delete_Group','data'=>$group)));
                  }

              }




        }else{

            if(strpos($userid,$group['createid'])!==false){

                Gateway::sendToUid( $fromid,json_encode(array('type'=>'group_response','data'=>'您无权踢群主')));
                return false;

            }

          //退出群
            $uids= array();
            if(strpos($userid,',')!==false){
                //多人
                $ids=explode(',',$userid);
            }else{
                //一人
                $ids=array($userid);
            }

            if(count($user_id)>0){
                foreach ($user_id as $v){
                    if($v>0 and !in_array($v,$ids)){
                       $uids[]=$v;
                    }
                }
            }
            $user_id=implode(',',$uids);
             $mids=array();
            if(count($manager_id)>0){
                foreach ($manager_id as $v){
                    if($v>0 and  !in_array($v,$ids)){
                        $mids[]=$v;
                    }
                }
            }
            $manager_id=implode(',',$mids);
            self::$db->query("update  app_group set `user_id`='{$user_id}',manager_id='{$manager_id}' where id='{$group_id}'");
            if($fromid==$userid){
                 //主动退群
                Gateway::sendToUid( $userid,json_encode(array('type'=>'group_response','data'=>'退群成功')));
                Gateway::sendToUid( $user_id,json_encode(array('type'=>'delete_Group','data'=>$group)));
            }else{
                //被踢出群
               // self::sendtips($userid,$group_id,"您被移除了该群组");

                self::send(self::$system['admin_id'],$userid,"您被移除了群组：<span class=\"groupname\" onclick=\"parent.group_detail({$group_id});\">{$group['name']}</span>");
                Gateway::sendToUid( $userid,json_encode(array('type'=>'delete_Group','data'=>$group)));
                Gateway::sendToUid( $fromid,json_encode(array('type'=>'group_response','data'=>'操作成功')));
                if($mark!=''){
                    self::logout_mark($userid,$mark);
                }
               $user=  self::$user->userinfo($userid);
                $fromuser=  self::$user->userinfo($fromid);
                $content=$user['nickname']."被{$fromuser['nickname']}移除本群";
                self::sendtips($group['user_id'],$group_id,$content,'show');
            }
        }
        self::GroupUpdate($group_id);
    }
    //踢出理由

    /**
     * @return array|mixed
     */
    public static function logout_mark($userid,$mark)
    {
        $user=  self::$user->userinfo($userid);
        $logout_words=unserialize($user['logout_words']);
          $mark=explode(',',$mark);
          if(count($mark)>0){
              foreach ($mark as $value){
                  if($value!=''){
                 $isin=0;
                   if(count($logout_words)>0){
                       foreach ($logout_words as $key1=> $v1){
                           if($v1['title']==$value){
                               $isin=1;
                               $logout_words[$key1]['num']++;
                               $logout_words[$key1]['time']=time();
                           }
                       }
                   }
                   if($isin==0){
                       $logout_words[]=array('title'=>$value,'num'=>1,'time'=>time());
                   }

                  }
              }
              $logout_words=serialize($logout_words);
              self::$db->query("update app_user set logout_words='{$logout_words}' where id='{$userid}'");
          }


    }
    //清空聊天记录
    public static function clearmsg($group_id){
        self::$db->query("delete from app_offline where group_id='{$group_id}'");
        $group= self::groupinfo($group_id);
        $user_id=explode(',',$group['user_id']);
        $old_ids=explode(',',$group['old_ids']);
        $user_id=array_merge($user_id,$old_ids);
        $data=json_encode(array('type'=>'clearmsg','key'=>'G'.$group_id,'data'=>array('msg_id'=>0)),true);

        if(count($user_id)>0){
            foreach ($user_id as $v){
                self::sendToUid($v,$data);
            }
        }
    }
    public static function  sendToUid($userid,$data,$group_id=0){
        if(Gateway::isUidOnline($userid)){
            $data=json_decode($data,JSON_UNESCAPED_UNICODE);
          if( !isset($data['data']['msg_id']) || !$data['data']['msg_id'])  $data['data']['msg_id']=rand(100000,9999999);

           $data=json_encode($data,JSON_UNESCAPED_UNICODE);
            Gateway::sendToUid( $userid,$data);


        }

       if($group_id==0)      self::push_data($userid,$group_id,$data);
    }
    //推送数据添加到数据库
    public static function push_data($userid,$group_id,$data)
    {
        $now=time();
        $arr=json_decode($data,JSON_UNESCAPED_UNICODE);
        if($userid!=$arr['data']['sender']['id']){
            $row= self::$db->row("select * from app_client where userid='{$userid}'");
            if($row['id']>0  && ($row['isonline']==0 || !Gateway::isUidOnline($userid) )){
                if(isset($arr['data']['msg_id']))
                    $msg_id=$arr['data']['msg_id'];
                if(!$msg_id) $msg_id=0;
                $sql="insert into app_offline(userid,content,`time`,group_id,msg_id) values('{$userid}','{$data}','{$now}','{$group_id}','{$msg_id}') ";

                self::$db->query($sql);

            }

        }
    }
 public   function GBsubstr($str, $start, $length) {
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

    public static function  sendOfffine($userid){
        if(Gateway::isUidOnline($userid)) {
            $list = self::$db->query("select * from app_offline where userid='{$userid}' order by id asc");
            if (count($list) > 0) {
                foreach ($list as $value) {
                ///    echo $value['content'];
                    Gateway::sendToUid( $userid,$value['content']);
                }
                self::$db->query("delete  from app_offline where userid='{$userid}'");
            }
        }
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
   public static function get_system(){


        $row=self::$db->query("select * from app_system");

        foreach ($row as $key=>$value){
            $system[$value['key']]=$value['value'];
        }

        return $system;
    }

}