<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020-3-5
 * Time: 19:41
 */
include_once '../inc/common.php';

$res=array('code'=>200);


$act=trim($_GET['act']);

if($act=='send'){

    $data=json_decode($_REQUEST['data'],true);
    $insert=array();
    $insert['text']=$data['text'];
    $insert['value']=serialize($data['value']);
    $insert['userid']=$_REQUEST['userid'];
    $insert['time']=time();
    $db->query("insert into ".tname('circle')."(userid,`text`,`value`,time) values('{$insert['userid']}','{$insert['text']}','{$insert['value']}','{$insert['time']}')");
    $id=$db->insert();
    if($id>0){
        $res['data']=$id;
    }else{
        $res['code']=0;
        $res['message']='发布失败'.json_encode($insert);
    }
    exit(json_encode($res));
}

if($act=='list'){
    $num=20;
    $page=$_REQUEST['page']?$_REQUEST['page']:1;
    $from=($page-1)*$num;
    $userid=(int) $_REQUEST['userid'];
    $time=$_REQUEST['time'];
    $data=array();
    $sql="select * from ".tname('circle')." where (userid='{$userid}' or userid in (select friendid from ".tname('friend')." where userid='{$userid}')) order by id desc limit {$from},{$num}";
   $list= $db->fetch_all($sql);
   if(count($list)>0){
       foreach ($list as $value){
           $user=userinfo($value['userid']);
           $value['header_image']=$user['avatar'];
           $value['username']=$user['nickname'];
           $value['content']['text']=$value['text'];
           $v=unserialize($value['value']);
           if(count($v)>0) $value['type']=0;else $value['type']=1;
           $value['content']['value']=$v;
           $value['like']=unserialize($value['like']);
           $value['comment']=unserialize($value['comment']);
           $value['gettime']=time();

           $data[]=$value;

       }
   }

   $res['data']=$data;

    exit(json_encode($res));
}

if($act=='mycircle'){
    $userid=(int) $_REQUEST['userid'];
    $page=$_REQUEST['page'];
    if(!$page) $page=1;
    $num=20;
    $from=($page-1)*$num;
    $data=array();
    $sql="select * from ".tname('circle')." where userid='{$userid}' order by id desc limit {$from},{$num}";
    $list= $db->fetch_all($sql);
    if(count($list)>0){
        foreach ($list as $value){
            $user=userinfo($value['userid']);
            $value['header_image']=$user['avatar'];
            $value['username']=$user['nickname'];
            $value['content']['text']=$value['text'];
            $v=unserialize($value['value']);
            if(count($v)>0) $value['type']=0;else $value['type']=1;
            $value['content']['value']=$v;
            $value['like']=unserialize($value['like']);
            $value['comment']=unserialize($value['comment']);
            $value['gettime']=time();

            $data[]=$value;

        }
    }

    $res['data']=$data;

    exit(json_encode($res));
}



if($act=='like'){
    $userid=$_REQUEST['userid'];
    $circle=$db->exec("select * from ".tname('circle')." where id='{$_REQUEST['id']}'");
    $like=unserialize($circle['like']);

     $isin=0;
     $item=array();
     if(count($like)>0){
         foreach ($like as $value){
            if((int) $userid== (int) $value['uid']){
                $isin=1;

            }else{
                $item[]=$value;
            }
         }
     }
     if($isin==0){
         $user=userinfo($userid);
         $item[]=array('uid'=>$userid,'username'=>$user['nickname'],'time'=>time());
     }
     $item=serialize($item);
     $time=time();
     $db->query("update ".tname('circle')." set `like`='{$item}',updatetime='{$time}' where id='{$_REQUEST['id']}'");
     if($isin==0) $action=1;
     else $action=0;
     $res['data']=array('userid'=>$circle['userid'],'action'=>$action);
    exit(json_encode($res));
}


if($act=='comment'){
    $userid=$_REQUEST['userid'];
    $circle=$db->exec("select * from ".tname('circle')." where id='{$_REQUEST['id']}'");
    $comment=unserialize($circle['comment']);
    $user=userinfo($_POST['uid']);
    $comment[]=array('uid'=>$_POST['uid'],'username'=>$user['nickname'],'content'=>$_POST['message'],'reply'=>$_POST['reply'],'replyid'=>$_POST['chat_user_id'],'time'=>time());
    $item=serialize($comment);
    $time=time();
    $db->query("update ".tname('circle')." set `comment`='{$item}',updatetime='{$time}' where id='{$_REQUEST['id']}'");
    $res['data']=array('userid'=>$circle['userid'],'action'=>1);
    exit(json_encode($res));

}

if($act=='msg'){
    $userid=$_REQUEST['userid'];
    $page=$_REQUEST['page'];
    if(!$page) $page=1;
    $num=20;
    $from=($page-1)*$num;
    $list=$db->fetch_all("select * from ".tname('circle_msg')." where to_uid='{$userid}' order by id desc limit {$from},{$num}");
    $data=array();
     if(count($list)>0){
         foreach ($list as $value){
             $user=userinfo($value['from_uid']);
             $value['user']=$user;
             $circle=$db->exec("select * from ".tname('circle')." where id='{$value['cid']}'");
             if($circle['id']>0){
                 $img=unserialize($circle['value']);
                 if(count($img)>0) {
                     $info['type']='img';
                     $info['content']=$img[0];
                 }else{
                     $info['type']='text';
                     $info['content']=$circle['text'];
                 }
             }else{
                 $info['type']='delete';
             }
             $value['info']=$info;
             $data[]=$value;
             $db->query("update ".tname('circle_msg')." set `read`=1 where id='{$value['id']}'");
         }
     }
     $res['data']=$data;
    exit(json_encode($res));
}


if($act=='delete'){
    $id=$_REQUEST['id'];
    $db->query("delete from ".tname('circle')." where id='{$id}'");
    $db->query("delete from ".tname('circle_msg')." where cid='{$id}'");
    $res['data']=1;
    exit(json_encode($res));

}


if($act=='delete_comment'){
    $id=$_REQUEST['id'];
    $index=$_REQUEST['index'];
    $circle=$db->exec("select *  from ".tname('circle')." where id='{$id}'");
    $comment=unserialize($circle['comment']);
    $data=array();
    if(count($comment)>0) {
        foreach ($comment as $item=>$value) {
         if($item!=$index) $data[]=$value;
        }
    }
    $data=serialize($data);
    $time=time();
    $db->query("update ".tname('circle')." set `comment`='{$data}',updatetime='{$time}' where id='{$id}'");
    $res['data']=1;
    exit(json_encode($res));


}
