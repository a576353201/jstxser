<?php
include_once '../inc/common.php';

$res=array('code'=>200);


$act=trim($_GET['act']);
if($_POST['userid']>0) $userid=$_POST['userid'];
else{
    if($_GET['userid']>0) $userid=$_GET['userid'];
    else
  $userid=$_SESSION['userid'];
}


if($act=='createGroup'){
    $user_id=$_POST['id'];
    $now=time();
    $userinfo=userinfo($_POST['id']);
   $row=$db->exec("select count(*) as num from ".tname('group')." where createid='{$user_id}'");
   if($row['num']>=$system['group_sum'.$userinfo['usertype']]){

       $res['code']=0;
       $res['message']="您最多可以创建{$row['num']}个群组,如需更多请升级为VIP";
    exit(json_encode($res));
   }

    $id=rand_groupid();
    if(!$_POST['avatar']){
        $avatar=list_file('../static/avatar');
        $_POST['avatar']=$avatar[rand(0,count($avatar)-1)];
    }

    //if($userinfo['isvip']==1)$people_max=$system['people_sum1'];else $people_max=$system['people_sum'];
    $people_max=$system['people_sum'.$userinfo['usertype']];
    if($_POST['userlist'] && $_POST['userlist']!=''){
        $user_id=str_replace('@',',',$_POST['userlist']);
    }
    else $user_id=$_POST['id'];

    $sql="insert into ".tname('group')." (id,createid,user_id,old_ids,`name`,nickname,addtime,avatar,tags,content,people_max,no_invite) values('{$id}','{$_POST['id']}','{$user_id}','{$user_id}','{$_POST['name']}','{$_POST['name']}','{$now}','{$_POST['avatar']}','{$_POST['tags']}','{$_POST['content']}','{$people_max}','{$_POST['no_invite']}')";


    $db->query($sql);
    if($db->affected_rows()>0){
        $userids=explode(',',$user_id);
      if(count($userids)>0){
          $nicknames=array();
          $ids='';
          foreach ($userids as $value){
           if($value>0)   $nicknames[]=array('id'=>$value,'name'=>'','jointime'=>time());
           if($ids!='') $ids.=',';
           $ids.=$value;
          }
          $nicknames=serialize($nicknames);
          $db->query("update ".tname('group')." set user_id='{$ids}' where id='{$id}'");
          $db->query("update ".tname('group')." set nicknames='{$nicknames}' where id='{$id}'");
      }


     $res['data']=GroupInfo($id);
        $list=$db->fetch_all("select * from ".tname('group')." where user_id like '%{$user_id}%' and is_delete='0'");
        $groups=array();
        if(count($list)>0){
            foreach ($list as $value){
                $arr=GroupInfo($value['id']);
                $groups[]=array('id'=>$arr['id'],'nickname'=>$arr['nickname'],'avatar'=>$arr['avatar']);
            }
        }$res['groups']=$groups;
     $res['code']=200;
    }else{
    $res['code']=0;
    $res['message']="网络连接失败";
    }
    exit(json_encode($res));

}

if ($act=='updateinfo'){
    $id=$_POST['id'];
    if($id>0){
        foreach ($_POST as $key=>$value){
            if($key!='id'){
                $db->query("update ".tname('group')." set `{$key}`='{$value}' where id='{$id}'");
            }
        }
    }
    $res['data']=GroupInfo($id);
    $res['code']=200;
    exit(json_encode($res));

}
//我的群组

if($act=='getMyGroup'){

    $userid=$_REQUEST['userid'];
    $list=$db->fetch_all("select * from ".tname('group')." where user_id like '%{$userid}%' and is_delete='0'");
    $data=array();
    $res=array();
    $res['code']=200;
    if(count($list)>0){
        foreach ($list as $value){

            $data[]=GroupInfo($value['id']);

        }
    }
    $res['data']=$data;
    die(json_encode($res));

}

//群信息
if($act=='getGroupInfo'){
    $res['data']=GroupInfo($_REQUEST['group_id'],$_REQUEST['from_id']);

    die(json_encode($res));
}
if($act=='getGroupUsers'){
$res['data']=group_users($_REQUEST['group_id']);
    die(json_encode($res));
}
if($act=='setGroupNickname'){

    $group=  GroupInfo($_REQUEST['group_id']);
    $nicknames=unserialize($group['nicknames']);
    if(!$nicknames) $nicknames=[];
    $isin=0;
    if(count($nicknames)){
        foreach ($nicknames as $key=> $value){
            if($value['id']==$_REQUEST['userid']){
                $nicknames[$key]['name']=$_REQUEST['content'];
                $isin=1;
                break;
            }
        }
    }
    if($isin==0){
        $nicknames[]=array('id'=>$_REQUEST['userid'],'name'=>$_REQUEST['content']);
    }
   $nicknames=serialize($nicknames);
    $db->query("update  ".tname('group')." set nicknames='{$nicknames}'where id='{$_REQUEST['group_id']}'");
    $res['data']=GroupInfo($_REQUEST['group_id'],$_REQUEST['userid']);

    die(json_encode($res));
}
if($act=='changeGroupName'){
    $db->query("update  ".tname('group')." set name='{$_REQUEST['name']}',nickname='{$_REQUEST['name']}' where id='{$_REQUEST['group_id']}'");
    $res['data']=true;
    die(json_encode($res));

}
if($act=='changeSpeak'){
    foreach ($_POST as $key=>$value){
        $db->query("update  ".tname('group')." set `{$key}`='{$value}' where id='{$_REQUEST['group_id']}'");
    }
    $res['data']=true;
    die(json_encode($res));
}

//邀请入群

if($act=='inviteIntoGroup'){
    $group=GroupInfo($_REQUEST['group_id']);
    if(strpos($_REQUEST['user_id'],$user_id)===false)
    $user_id=$group['user_id'].','.$_REQUEST['user_id'];
    $user_id=array_unique(explode(',',$user_id));
    $user_id=implode(',',$user_id);
    $db->query("update  ".tname('group')." set `user_id`='{$user_id}' where id='{$_REQUEST['group_id']}'");
    $res['data']=true;
    die(json_encode($res));

}

if($act=='joinGroup'){
    $group=GroupInfo($_REQUEST['group_id']);
    $user_id=$group['user_id'].','.$_REQUEST['userid'];
    if($group['no_invite']==1){
        $res['data']=false;
        $res['message']='群主已经关闭群邀请';
    }else{
        if(strpos($group['user_id'],$_REQUEST['userid'])===false){
            $db->query("update  ".tname('group')." set `user_id`='{$user_id}' where id='{$_REQUEST['group_id']}'");
        }
        $res['data']=true;
    }

    die(json_encode($res));

}


if($act=='setReadTime'){
       if($_POST['isgroup']>0){
           set_readtime($userid,'G'.$_POST['group_id']);
           $res['data']=get_unreadnum($userid,'G'.$_POST['group_id']);
       }else{
           set_readtime($userid,'U'.$_POST['group_id']);
           $res['data']=get_unreadnum($userid,'U'.$_POST['group_id']);
       }

        $res['code']=200;

    die(json_encode($res));

}

if($act=='setReadTime2'){

        set_readtime($userid,$_REQUEST['cache_key']);
        $res['data']=get_unreadnum($userid,$_REQUEST['cache_key']);


    $res['code']=200;

    die(json_encode($res));

}

if($act=='setReadTime3'){
    $fromtime=time()-7*24*3600;
    $cache_key=$_REQUEST['cache_key'];
    $id=substr($cache_key,1,strlen($cache_key)-1);

    if($_REQUEST['unread']==0){
        set_readtime($userid,$_REQUEST['cache_key']);
        if($id==1){
            $db->query("update  ".tname('request')." set `read`='1' where touid='{$userid}'  and del_uids not like '%@{$userid}@%'");
        }
    }

   else{

       if(strpos($cache_key,'G')!==false){
           $id=substr($cache_key,1,strlen($cache_key)-1);
           $sql="select * from ".tname('chat')." where groupid='{$id}' and userid!='{$userid}' and isback='0' and del_uids not like '%@{$userid}@%' and (`type`!='tips' or tip_uid='{$userid}') order by addtime desc";
           $row=$db->exec($sql);
           if($row['addtime']>0){
               $time=$row['addtime']-1;
               set_readtime($userid,$_REQUEST['cache_key'],$time);

           }

       }else{

           if($id=='1'){

               $str="group_id in (select id from ".tname('group')." where (createid='{$userid}' or manager_id like '%{$userid}%') )  and del_uids not like '%@{$userid}@%'  and addtime>='{$fromtime}' ";
               $row=  $db->exec("select * from ".tname('group_apply')." where {$str}  order by addtime desc limit 0,1");
               $res['data']=$id;
               if($row['addtime']>0){
                   $time=$row['addtime']-1;
                   set_readtime($userid,$_REQUEST['cache_key'],$time);

               }
               else{
                   $chat=  $db->exec("select * from ".tname('request')." where touid='{$userid}'  and del_uids not like '%@{$userid}@%'  order by addtime desc limit 0,1");

                   if($chat['id']>0){
                       $db->query("update  ".tname('request')." set `read`='0' where id='{$chat['id']}'");
                   }
               }
           }else{
               $sql="select * from ".tname('chat')." where groupid='0' and touid='{$userid}' and userid='{$id}' and isback='0' and del_uids not like '%@{$userid}@%' and (`type`!='tips' or tip_uid='{$userid}') order by addtime desc";
               $row=$db->exec($sql);
               if($row['addtime']>0){
                   $time=$row['addtime']-1;
                   set_readtime($userid,$_REQUEST['cache_key'],$time);
               }
           }

       }
   }
    //$res['data']=get_unreadnum($userid,$_REQUEST['cache_key']);


    $res['code']=200;

    die(json_encode($res));

}

//最近聊天
if($act=='lastchat'){


    $data=array();
    $unread=0;
    $reading_id=$_REQUEST['reading_id'];

    if($reading_id>-1){
        set_readtime($_SESSION['userid'],'G'.$_GET['id']);
    }

    if($_REQUEST['cache_key']){
        set_readtime($userid,$_REQUEST['cache_key']);
    }
    $res['temp11']=[];

    if($userid>0){
       $res=lastchat($userid);
    }
    die(json_encode($res));

}
//获取成员信息
if($act=='userlist'){
    $group=GroupInfo($_POST['group_id'],$_SESSION['userid']);
    $res['group']=$group;
    $res['userlist']=group_users($_POST['group_id']);
    $res['code']=200;
    die(json_encode($res));
}

if($act=='noteadd'){

    $db->query("insert into ".tname('group_note')." (userid,addtime) values('{$userid}','".time()."')");
    $id=$db->insert_id();
    if($id>0){
        foreach ($_POST as $key=>$value){
            if($key!='id')
            $db->query("update ".tname('group_note')." set `{$key}`='{$value}' where id='{$id}'");
        }
    }
    $res['code']=200;
    die(json_encode($res));

}
if($act=='noteedit'){


    $id=$_POST['id'];
    if($id>0){
        foreach ($_POST as $key=>$value){
            $db->query("update ".tname('group_note')." set `{$key}`='{$value}' where id='{$id}'");
        }
    }
    $res['code']=200;
    die(json_encode($res));

}

if($act=='deletenote'){


    $db->query("delete from ".tname('group_note')." where id='{$_POST['id']}'");
    $res['code']=200;
    die(json_encode($res));
}

if($act=='group_list'){

    if($_POST['act']) $act=$_POST['act'];
    else $act='top';
    if($act=='top'){
        $order=" sortnum asc, top desc,addtime desc";
        $where=" and top>0 ";
    }
    else{
        $order='sortnum asc, addtime desc';
        $where="";
    }
    if($_POST['page']) $page=$_POST['page'];
    else $page=1;
    $from=($page-1)*20;
    $list=$db->fetch_all("select * from ".tname('group')." where is_delete='0' {$where} order by {$order} limit {$from},20");
    if(count($list)>0){

        foreach ($list as $key=>$value){
            $group=GroupInfo($value['id'],$userid);
            $list[$key]=$group;
        }
    }    else $list=array();
    $res['data']=$list;
    $res['code']=200;
    die(json_encode($res));
}


if($act=='group_search'){

     $keyword=$_POST['keyword'];
    $list=$db->fetch_all("select * from ".tname('group')." where is_delete='0' and (`name` like '%{$keyword}%' or tags like '%{$keyword}%') order by top desc,id desc");
    if(count($list)>0){

        foreach ($list as $key=>$value){
            $group=GroupInfo($value['id'],$_SESSION['userid']);
            $list[$key]=$group;
        }
    }
    else{
        $list=array();
    }
    $res['data']=$list;
    $res['code']=200;
    die(json_encode($res));
}

if($act=='mygroup'){
    if($_POST['act']) $act=$_POST['act'];
    else $act='top';
    if($act=='owner'){
        $str=" and createid='{$_SESSION['userid']}'";
    }
    else $str=" and (user_id like '%{$_SESSION['userid']}%' and createid!='{$_SESSION['userid']}')";
    $list=$db->fetch_all("select * from ".tname('group')." where is_delete='0' {$str} order by CONVERT(name USING gbk)");
    if(count($list)>0){

        foreach ($list as $key=>$value){
            $group=GroupInfo($value['id'],$_SESSION['userid']);
            $list[$key]=$group;
        }
    }
    else{
        $list=array();
    }
    $res['data']=$list;
    $res['code']=200;
    die(json_encode($res));

}

if($act=='group_user'){

    $user=group_userinfo(group_users($_POST['group_id']),$_POST['userid']);
    $res['data']=$user;
    $res['code']=200;
    die(json_encode($res));
}

if($act=='msglist'){
    if($_POST['group_id']>0){
        if($_POST['isgroup']==1)
       $msglist= chat_msglist($_POST['group_id'],$_POST['page']);
        else    $msglist= chat_msglist($_POST['group_id'],$_POST['page'],$_SESSION['userid'],0,0);
       if(count($msglist)>0){
           $res['code']=200;
           $html="";
           foreach ($msglist as $value){

               if( $value['type']=='tips'){
                   $html.=" <div class=\"tips\">{$value['content']}</div>";
               }
               else{
                   if( $value['self']==1) $self="self";
                   else $self="";
                   $html.="  <div id=\"msg_{$value['id']}\" class=\"line {$self}\">
                   <div id=\"avatar_{$value['id']}\" class=\"avatar\" onclick=\"avatar_menu({$value['id']},{$value['user']['id']});\">
                       <img src=\"{$value['user']['avatar']}\" onerror=\"this.src='../uploads/avatar.jpg'\"/>
                   </div>
                   <div class=\"msg\">
                       <div class=\"nickname\" ><span onclick=\"avatar_menu({$value['id']},{$value['user']['id']});\">{$value['user']['nickname']}</span></div>
                       <div class=\"info\">{$value['content']}</div>
                   </div>
                   <div class=\"loading\"><img src=\"/static/images/loading.gif\"/></div>
               </div>";

               }

           }
           $res['data']=$html;

       }else{
           $res['code']=0;
       }

    }
    die(json_encode($res));

}

if($act=="messages"){
    if($_POST['id']>-2) {
        $msglist = chat_msglist($_POST['id'],$_POST['fromtime'],$userid,1);
        $res['code']=200;
        $res['data']=$msglist;
    }
    else {
    $res['code']=0;
    $res['message']="参数错误";
    }
die(json_encode($res));

}
if($act=="messages1"){
    if($_POST['id']>-2) {
        $msglist = chat_messages($_POST['id'],$userid,$_POST['fromtime'],$_POST['isgroup']);
        $res['code']=200;
        $res['data']=$msglist;
    }
    else {
        $res['code']=0;
        $res['message']="参数错误";
    }
    die(json_encode($res));

}
if($act=="messages2"){
    if($_REQUEST['id']>-2) {
        $msglist = chat_messages_list($_REQUEST['id'],$userid,$_REQUEST['totime'],$_REQUEST['isgroup']);
        $res['code']=200;
        $res['data']=$msglist?$msglist:array();
    }
    else {
        $res['code']=0;
        $res['message']="参数错误";
    }
    $res['req']=$_REQUEST;
    die(json_encode($res));

}
//删除消息记录
if($act=='delete_msglist'){
    $res['code']=200;
    $groupid=$_REQUEST['groupid'];
    $userid=$_REQUEST['userid'];
    $touid=$_REQUEST['touid'];

    if($groupid>0){
        //群聊记录
       $list= $db->fetch_all("select * from ".tname('chat')." where groupid ='{$groupid}'   and del_uids not like '%{$userid}@%'");
       if(count($list)>0){
           foreach ($list as $value){
               if(!$value['del_uids']) $del_uids="@{$userid}@";
               else $del_uids=$value['del_uids']."{$userid}@";
               $db->query("update ".tname('chat')." set del_uids='{$del_uids}' where id='{$value['id']}'");
           }
       }
    }
    else{
        //私聊记录
        if($touid==1){

            $str="group_id in (select id from ".tname('group')." where (createid='{$userid}' or manager_id like '%{$userid}%') )  and del_uids not like '%@{$userid}@%'  and addtime>='{$fromtime}' ";
            $list= $db->fetch_all("select * from ".tname('group_apply')." where {$str}  order by addtime desc limit 0,1");
              if(count($list)>0){
                foreach ($list as $value){
                    if(!$value['del_uids']) $del_uids="@{$userid}@";
                    else $del_uids=$value['del_uids']."{$userid}@";
                    $db->query("update ".tname('group_apply')." set del_uids='{$del_uids}' where id='{$value['id']}'");
                }
            }
            $list= $db->fetch_all("select * from ".tname('request')." where touid='{$userid}'  and del_uids not like '%@{$userid}@%'  order by addtime desc limit 0,1");
            if(count($list)>0){
                foreach ($list as $value){
                    if(!$value['del_uids']) $del_uids="@{$userid}@";
                    else $del_uids=$value['del_uids']."{$userid}@";
                    $db->query("update ".tname('request')." set del_uids='{$del_uids}' where id='{$value['id']}'");
                }
            }
        }
        else{
            $list= $db->fetch_all("select * from ".tname('chat')." where (userid='{$touid}' or touid='{$touid}' ) and (touid='{$touid}' or userid='{$touid}' ) and groupid='0' and del_uids not like '%@{$userid}@%'");
            if(count($list)>0){
                foreach ($list as $value){
                    if(!$value['del_uids']) $del_uids="@{$userid}@";
                    else $del_uids=$value['del_uids']."{$userid}@";
                    $db->query("update ".tname('chat')." set del_uids='{$del_uids}' where id='{$value['id']}'");
                }
            }
        }

    }

    die(json_encode($res));
}


//
if($act=='saveStore'){
    $res['code']=200;
    $id=$_REQUEST['id'];
    $userid=$_REQUEST['userid'];
    $row= $db->exec("select * from ".tname('chat')." where id='{$id}'");
    if($row['id']>0){

        $sql="insert into ".tname('store')." (user_id,type,time,chat_id,content) values('{$userid}','{$row['type']}','".time()."','".$row['id']."','".$row['content']."')";
        $db->query($sql);
    }
    die(json_encode($res));
}


//删除一条聊天记录
if($act=='clearchatlist'){
    $res['code']=200;
    $id=$_REQUEST['id'];
    $userid=$_REQUEST['userid'];
    $row= $db->exec("select * from ".tname('chat')." where id='{$id}'and del_uids not like '%@{$userid}@%'");
    if($row['id']>0){

            if(!$row['del_uids']) $del_uids="@{$userid}@";
            else $del_uids=$row['del_uids']."{$userid}@";
            $db->query("update ".tname('chat')." set del_uids='{$del_uids}' where id='{$row['id']}'");
    }
    die(json_encode($res));
}


//群通知
if($act=='groupnote'){
$id=$_REQUEST['id'];
if($id>0){
    $group=GroupInfo($id,$userid);

    $is_owner=$group['is_owner'];
    $is_manager=$group['is_manager'];
//$db->query("update ".tname('group_note')."   set `view`=`view`+1 where group_id='{$_GET['id']}'");
    $list=$db->fetch_all("select * from ".tname('group_note')." where group_id='{$id}' order by istop desc, id desc");
    if(count($list)>0){
        foreach ($list as $key=>$value){
            $u=userinfo($value['userid']);

            $list[$key]['nickname']=$u['nickname'];
            $uids=unserialize($uids);
            if(!in_array($_SESSION['userid'])){
                $uids[]=$_SESSION['userid'];
            }
            $uids=serialize($uids);
            $list[$key]['view']=count($uids);
            $db->query("update ".tname('group_note')." set uids='{$uids}' where id='{$value['id']}'");
        }

    }
    $res['data']=$list;
    $res['code']=200;
}
else{
    $res['code']=0;
    $res['message']="参数错误";
}
    die(json_encode($res));

}

if($act=='applyinfo'){
 $row=   $db->exec("select * from ".tname('group_apply')." where id='{$_POST['id']}'");
 if($row) $res['data']=$row;else $res['data']=[];
 $res['code']=200;
    die(json_encode($res));
}
if($act=='applylist'){
    $fromtime=time()-7*24*3600;
    $page=$_REQUEST['page']?$_REQUEST['page']:1;
    $from=($page-1)*10;

    $str="group_id in (select id from ".tname('group')." where (createid='{$userid}' or manager_id like '%{$userid}%') ) and addtime>='{$fromtime}'  and del_uids not like '%@{$userid}@%' ";
    $sql="select * from ".tname('group_apply')." where {$str}  order by addtime desc limit {$from},10";
    $list=   $db->fetch_all($sql);

    if(count($list)>0) {
        $data=array();
        foreach ($list as $key=>$value){

            $value['content1']=unserialize($value['content']);
            $user=userinfo($value['userid']);
            $value['user']=array('id'=>$user['id'],'nickname'=>$user['nickname'],'avatar'=>$user['avatar']);
            $group=GroupInfo($value['group_id'],$value['userid']);
            $value['group']=array('id'=>$group['id'],'nickname'=>$group['nickname'],'avatar'=>$group['avatar']);
            $data[]=$value;
        }
        $res['data']=arr_format($data);
    }else $res['data']=[];
    $res['code']=200;
    set_readtime($userid,'U1');
    die(json_encode($res));
}

if($act=='set_msgtop'){

    if($_REQUEST['istop']=='true'){
        $sql="insert into ".tname('msgtop')." (userid,cache_key,time) values('{$userid}','{$_REQUEST['cache_key']}','".time()."')";

    }
    else{
        $sql="delete from  ".tname('msgtop')." where userid='{$userid}' and cache_key='{$_REQUEST['cache_key']}'";

    }
    $db->query($sql);
    $res['code']=200;
   // $res['data']=$sql.$_REQUEST['istop'];
    die(json_encode($res));

}

if($act=='set_msgnotip'){

    if($_REQUEST['notip']=='true'){
        $sql="insert into ".tname('msgnotip')." (userid,cache_key,time) values('{$userid}','{$_REQUEST['cache_key']}','".time()."')";

    }
    else{
        $sql="delete from  ".tname('msgnotip')." where userid='{$userid}' and cache_key='{$_REQUEST['cache_key']}'";

    }
    $db->query($sql);
    $res['code']=200;
    // $res['data']=$sql.$_REQUEST['istop'];
    die(json_encode($res));

}

if($act=='get_redpacket'){
    $id=$_REQUEST['id'];
    $redpacket=$db->exec("select * from ".tname('readpacket')." where id='{$id}'");
    if($redpacket['id']>0){
        $isget=0;
        $sum=0;
        $thismoney=0;
        $lognum=0;

        $views=unserialize($redpacket['views']);
        if(!in_array($userid,$views)) {
            $views[]=$userid;
            $views=serialize($views);
            $db->query("update  ".tname('readpacket')." set `views`='{$views}' where id='{$id}'");
        }
        if($redpacket['userids']=='') $userids=array();
        else {
            $userids=unserialize($redpacket['userids']);
            if(count($userids)>0){
                foreach ($userids as $key=>$value){
                    if($value['money']>0){

                        $sum+=$value['money'];
                        if($value['userid']== $userid){
                            $isget=1;
                            $thismoney=$value['money'];
                        }
                        $lognum++;
                    }
                    else unset($userids[$key]);

                }
            }else $userids=array();
        }



        $issend=false;
      if($isget>0){
          $res['data']=$thismoney;
      }
      else{
          if($redpacket['status']==1  && time()-$redpacket['addtime']<=$system['redpacket_backtime']*3600){
              $lastnum= $redpacket['num'] -$lognum;
              if($redpacket['isgroup']==1){

                  if($redpacket['type']==1){

                      if($lastnum>1){
                          $money=abc_red(100*($redpacket['summoney'] -$sum),$lastnum);
                          $money=$money/100;
                      }
                      else{

                          $money=$redpacket['summoney'] - $sum;
                      }

                  }else{
                      $money=$redpacket['permoney'];
                  }
                  if($lastnum<=1){
                      $issend=true;
                  }

              }
              else{
                  $issend=true;
                  $money=$redpacket['summoney'];
              }
              if($money>0){
                  $userinfo=userinfo($redpacket['sender_id']);
                  add_money($userid,$money,$userinfo['nickname'].'的红包','redpacket');
                  $userids[]=array('userid'=>$userid,'money'=>$money,'time'=>time());
                  $updata=array('userids'=>serialize($userids));
                  if($issend==true){
                      $updata['endtime']=time();
                      $updata['status']=2;
                  }
                  foreach ($updata as $key=>$value){
                     $db->query("update ".tname('readpacket')." set `{$key}`='{$value}' where id='{$id}'") ;
                  }

              }
            //  $res['tt']=array($redpcket,$redpcket['summoney'] , $sum);
          $res['data']=$money;

          }else{
              $res['data']=$thismoney;
          }
          $res['code']=200;
      }

    }else{
        $res['code']=0;
        $res['message']='红包已不存在';
    }
    die(json_encode($res));
}

if($act=='redpacket_users'){
    $res['code']=200;
    $id=$_REQUEST['id'];
    $redpacket=$db->exec("select * from ".tname('readpacket')." where id='{$id}'");
    if($redpacket['id']>0){
        $userids=unserialize($redpacket['userids']);
        if(count($userids)){
           foreach ($userids as $key=> $value){
               $userinfo=userinfo($value['userid']);
               $userids[$key]['avatar']=$userinfo['avatar'];
               $userids[$key]['nickname']=$userinfo['nickname'];
           }
           $res['data']=$userids;

        }else{
            $res['data']=array();
        }
        $res['info']=$redpacket;
    }
    die(json_encode($res));
}

?>