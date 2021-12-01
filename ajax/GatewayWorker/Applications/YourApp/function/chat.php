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
    public function __construct($db,$user)

    {
        self::$db = $db;
        self::$user=$user;
    }


    public function  send($userid,$touid,$content,$type='text',$mid=''){
        if($type=='tips')
            $message=array('type'=>$type,'content'=>array('type'=>'time','text'=>$content));
        else
            $message=array('type'=>$type,'content'=>$content);

        $now=time();

     if(!$mid) $mid=time().rand(1000,9999);

            $sender=self::$user->userinfo($userid);
            $receiver=self::$user->userinfo($touid);
            $time=date('Y-m-d H:i:s',$now);
            $data=array('id'=>$touid,'cache_key'=>'U'.$touid,'self'=>1,'sender_id'=>$userid,'receiver_id'=>intval($touid),'group_id'=>0,'timestamp'=>$now,'time'=>$time,'_mid'=>$mid,'isloading'=>0);
            $data['message']=$message;
            $data['sender']=$sender;
            $data['receiver6']=$receiver;
            $data['nickname']=$receiver['nickname'];
            $data['avatar']=$receiver['avatar'];
            if(!self::$user->is_friend($userid,$touid)){

                self::sendtip($touid,$userid,'消息发送失败，你们已不是好友关系');

                return false;
            }
            $content=json_encode($content,JSON_UNESCAPED_UNICODE);
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

    public function  Group_send($userid,$group_id,$content,$type='text',$mid=''){
        if(!$mid) $mid=time().rand(1000,9999);
        $now=time();
        if($type=='tips')
            $message=array('type'=>$type,'content'=>array('type'=>'time','text'=>$content));
        else
            $message=array('type'=>$type,'content'=>$content);
            $sender=self::$user->userinfo($userid);
            $receiver=self::groupinfo($group_id);
            $uids=explode(',',$receiver['user_id']);


            $time=date('Y-m-d H:i:s',$now);
            $data=array('id'=>$group_id,'cache_key'=>'G'.$group_id,'self'=>1,'sender_id'=>$userid,'group_id'=>intval($group_id),'timestamp'=>$now,'time'=>$time,'_mid'=>$mid,'isloading'=>0);
            $data['message']=$message;
            $data['sender']=$sender;
            $data['receiver7']=$receiver;
           if(strpos($receiver['deny_id'],$userid)!=false){
               $message=array('type'=>'tips','content'=>array('type'=>'time','text'=>'发送失败，您已被禁言'));
               $data['message']=$message;
               $data1=json_encode(array('type'=>'chat','data'=>$data),JSON_UNESCAPED_UNICODE);
               self::sendToUid( $userid,$data1,$group_id);
               return false;
           }
        if((!in_array($userid,$uids) || $receiver['is_delete']==1) && $userid!=$receiver['createid']){
            $message=array('type'=>'tips','content'=>array('type'=>'time','text'=>'发送失败，您已经被移除了本群'));
            $data['message']=$message;
            $data1=json_encode(array('type'=>'chat','data'=>$data),JSON_UNESCAPED_UNICODE);
            self::sendToUid( $userid,$data1,$group_id);
            return false;
        }
        $content=json_encode($content,JSON_UNESCAPED_UNICODE);
        $sql="insert into app_chat(userid,groupid,content,`type`,addtime) VALUES ('{$userid}','{$group_id}','{$content}','{$type}','{$now}')";

        self::$db->query($sql);
        $id=self::$db->lastInsertId();
        if($id>0) {
         $data['msg_id']=$id;
            if (count($uids) > 0) {

                foreach ($uids as $v) {
                    if ($v == $userid) $data['self'] = 1;
                    else $data['self'] = 0;
                    $data1 = json_encode(array('type' => 'chat', 'data' => $data), JSON_UNESCAPED_UNICODE);
                    self::sendToUid($v, $data1, $group_id);

                }

            }

//            $data1 = json_encode(array('type' => 'chat', 'data' => $data), JSON_UNESCAPED_UNICODE);
//            Gateway::sendToGroup('G'.$group_id,$data1);

        }


    }

    public  function sendtips($user_id,$group_id,$content,$msg_type='',$data=array()){

    $group= self::groupinfo($group_id);
    $fromid=$group['createid'];
    $message=array('type'=>'tips','content'=>array('type'=>'time','text'=>$content),'msg_type'=>$msg_type,'data'=>$data);
        $sender=self::$user->userinfo($fromid);
        if(strpos($user_id,',')!==false)   $uids=explode(',',$user_id);
        else
         $uids=array($user_id);
        $now=time();
        $time=date('Y-m-d H:i:s',$now);
        $data=array('id'=>$group_id,'cache_key'=>'G'.$group_id,'self'=>0,'sender_id'=>$fromid,'group_id'=>intval($group_id),'timestamp'=>$now,'time'=>$time,'msg_id'=>0);
        $data['message']=$message;
        $data['sender']=$sender;
        $data['receiver8']=$group;
        $data['nickname']=$group['nickname'];
        $data['avatar']=$group['avatar'];


        if(count($uids)>0){
            foreach ($uids as $v){
                $data1=json_encode(array('type'=>'chat','data'=>$data),JSON_UNESCAPED_UNICODE);
                self::sendToUid( $v,$data1,$group_id);
            }

        }
    }

    public  function sendtip($fromid,$touid,$content,$msg_type='',$data=array()){

        $receiver=self::$user->userinfo($touid);;

        $message=array('type'=>'tips','content'=>array('type'=>'time','text'=>$content),'msg_type'=>$msg_type,'data'=>$data);
        $sender=self::$user->userinfo($fromid);
        $now=time();
        $time=date('Y-m-d H:i:s',$now);
        $data=array('id'=>$fromid,'cache_key'=>'U'.$fromid,'self'=>0,'sender_id'=>$fromid,'group_id'=>0,'receiver_id'=>intval($touid),'timestamp'=>$now,'time'=>$time,'msg_id'=>0);
        $data['message']=$message;
        $data['sender']=$sender;
        $data['receiver9']=$receiver;
        $data['nickname']=$sender['nickname'];
        $data['avatar']=$sender['avatar'];
     $data1=json_encode(array('type'=>'chat','data'=>$data),JSON_UNESCAPED_UNICODE);
    self::sendToUid( $touid,$data1,0);

    }

   public function groupsendtips($group_id,$content){
       $group= self::groupinfo($group_id);
          self::sendtips($group['user_id'],$group_id,$content);
   }
    public  function  delete_chat($store,$touid){
        $fromid=substr($store,1,strlen($store)-1);
        if(strpos($store,'G')!==false){
            self::sendtips($touid,$fromid,'','delete_chat',array());
        }else{
            self::sendtip($fromid,$touid,'','delete_chat');
        }
    }

    public  function  chat_back($userid,$msg_id,$store){
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
                    self::sendtips($userid,$group_id,"消息发送时间已大于2分钟，无法撤回");
                    return false;
                }else if($chat['userid']!=$userid){
                    self::sendtips($userid,$group_id,"您无权撤回其他人的消息");
                    return false;
                }
            }
            if($isadmin==1) $content='';
            else $content="{$user['nickname']}撤回了一条消息";
            self::sendtips($group['user_id'],$group_id,$content,'delete_chat',$data);
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



    public function groupinfo($id,$from_id=''){
        $group=    self::$db->row("select * from app_group where id='{$id}'");
       if($group){
           $user_id=explode(',',$group['user_id']);
           $group['people_count']=count($user_id);
           if($from_id==$group['createid']) $group['owner']=1;
           else  $group['owner']=0;
           if($group['avatar']==null or $group['avatar']=='') $group['avatar']='uploads/group.jpg';
       }

        return $group;
    }

    public  function chatinfo($id){

        $data=    self::$db->row("select * from app_chat where id='{$id}'");
        return $data;
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
               $this->sendtips($group['user_id'],$group_id,$user['nickname'],"已被设为管理员");
           }

       }
       foreach ($deny_id1 as $v){
           if(!in_array($v,$deny_id2) and $v>0){
               $user=self::$user->userinfo($v);;
               $this->sendtips($group['user_id'],$group_id,$user['nickname']."已被取消管理员");
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
              $this->sendtips($group['user_id'],$group_id,$user['nickname']."已被禁言");
          }

      }

       foreach ($deny_id1 as $v){
           if(!in_array($v,$deny_id2) and $v>0){
               $user=self::$user->userinfo($v);;
               $this->sendtips($group['user_id'],$group_id,$user['nickname']."已被解除禁言");
           }

       }

      // self::sendtips($group_id['user_id'])

   }
        Gateway::sendToUid( $from_uid,json_encode(array('type'=>'group_response','data'=>'设置成功')));

    }

    public function  GroupUpdate($group_id){
        $group= self::groupinfo($group_id);
        Gateway::sendToGroup($group_id,json_encode(array('type'=>'group_update','data'=>$group)));
    }
    public function group_old_ids($group_id,$invite_id){
        $group= self::groupinfo($group_id);
        $user_id=$group['old_ids'].','.$invite_id;
        $user_id=array_unique(explode(',',$user_id));
        $user_id=implode(',',$user_id);

        self::$db->query("update  app_group set `old_ids`='{$user_id}' where id='{$group_id}'");
    }


     public  function inviteIntoGroup($userid,$group_id,$invite_id){
         self::group_old_ids($group_id,$invite_id);
         $group= self::groupinfo($group_id);
         $user_id=$group['user_id'].','.$invite_id;
         $user_id=array_unique(explode(',',$user_id));
         $user_id=implode(',',$user_id);

         self::$db->query("update  app_group set `user_id`='{$user_id}' where id='{$group_id}'");
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
             $uids=explode(',',$user_id);
             if(count($uids)>0){
                 foreach ($uids as $uid){
                     if(strpos($invite_id,$uid)!==false) $msg_type='show';
                     else $msg_type='';
                     self::sendtips($uid,$group_id,"{$user['nickname']}邀请了".$content.'进群',$msg_type);
                 }
             }

         }
         Gateway::sendToUid( $userid,json_encode(array('type'=>'group_response','data'=>'邀请成功')));
     }

     //申请入群
      public  function Join_Group($userid,$group_id,$client_id){

          $group= self::groupinfo($group_id);
          $user_id=$group['user_id'].','.$userid;
          $user_id=array_unique(explode(',',$user_id));
          $user_id=implode(',',$user_id);
          self::$db->query("update  app_group set `user_id`='{$user_id}' where id='{$group_id}'");
          Gateway::joinGroup($client_id, 'G'.$group_id);;
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
          self::sendtips($user_id,$group_id,"{$user['nickname']}进入了本群111");
          Gateway::sendToUid( $userid,json_encode(array('type'=>'apply_response','data'=>array('code'=>1,'group'=>$group,'message'=>'您已成功入群'))));

      }



     public  function GroupCreatTips($group_id){
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
    public  function deleteGroup($fromid,$group_id,$userid){
        $group= self::groupinfo($group_id);
        $user_id=explode(',',$group['user_id']);
        //解散群
        if($userid==$group['createid'] and $userid==$fromid){

            self::$db->query("delete from app_offline where group_id='{$group_id}'");
            self::sendtips($group['user_id'],$group_id,"您被移除了该群组","tips");
            self::$db->query("update  app_group set `user_id`='',is_delete='1' where id='{$group_id}'");
            Gateway::sendToUid( $userid,json_encode(array('type'=>'group_response','data'=>'群已被解散')));

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
            self::$db->query("update  app_group set `user_id`='{$user_id}' where id='{$group_id}'");
            if($fromid==$userid){
                 //主动退群
                Gateway::sendToUid( $userid,json_encode(array('type'=>'group_response','data'=>'退群成功')));
            }else{
                //被踢出群
                self::sendtips($userid,$group_id,"您被移除了该群组");
                Gateway::sendToUid( $fromid,json_encode(array('type'=>'group_response','data'=>'操作成功')));
            }
        }
    }
    //清空聊天记录
    public function clearmsg($group_id){
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
    public function  sendToUid($userid,$data,$group_id=0){
        if(Gateway::isUidOnline($userid)){
            Gateway::sendToUid( $userid,$data);
        }
        else{
            $now=time();
            $arr=json_decode($data,true);
            if(isset($arr['data']['msg_id']))
            $msg_id=$arr['data']['msg_id'];
            if(!$msg_id) $msg_id=0;
            $sql="insert into app_offline(userid,content,`time`,group_id,msg_id) values('{$userid}','{$data}','{$now}','{$group_id}','{$msg_id}') ";
           // echo $sql;
            self::$db->query($sql);
        }
    }


    public  function  sendOfffine($userid){
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



}