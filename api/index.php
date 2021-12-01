<?php
include_once '../inc/common.php';

$act=$_GET['act'];
$res=array('code'=>200,'success'=>ture);
if($_POST['userid']>0) $userid=$_POST['userid'];
else{
    if($_GET['userid']>0) $userid=$_GET['userid'];
    else
        $userid=$_SESSION['userid'];
}
if($act=='uploadImage'){

    $base64_string = $_POST['imgData'];

    $savename = uniqid().'.jpeg';

    if($_GET['dir']){

        $savepath = '../uploads/images/'.$_GET['dir'].'/'.date('Y').'/'.date('m');
    }
    else
        $savepath = '../uploads/images/'.date('Y').'/'.date('m').'/'.date('d');

    if(!file_exists($savepath)) mkdirs($savepath);
    $savepath = $savepath.'/'.$savename;
    $image = base64_to_img( $base64_string, $savepath );

    if($image){
        $res['code']=200;
        $savepath=str_replace('../','',$savepath);
        $res['url']=$savepath;
        $res['uploaded']=1;
        $res['message']='上传成功';
        if($_GET['type']=='avatar' && $_POST['id']){
            $db->query("update ".tname('user')." set avatar='{$savepath}' where id='{$_POST['id']}'");
        }

        if($_GET['type']=='group' && $_POST['group_id']){
            $db->query("update ".tname('group')." set avatar='{$savepath}' where id='{$_POST['group_id']}'");
        }
    }else{
        $res['code']=0;
        $res['errMsg']='上传失败';

    }
    exit(json_encode($res));
}



if($act=='getlink'){
     $showtype=$_REQUEST['showtype'];

    $list=$db->fetch_all("select id,title,logo,url from ".tname('flink')." where status='1' and showtype like '%{$showtype}%' order by sortnum asc");
    $res['code']=200;
    $res['data']=$list;
    exit(json_encode($res));
}

if($act=='getdata'){
    $data=array();
    $news=array();
    $list=$db->fetch_all("select * from ".tname('news')." order by sortnum asc,id asc");
    if(count($list)>0){
        foreach ($list as $value1){
            $value1['other']=unserialize($value1['other']);
            $news[$value1['type1']][]=$value1;
        }
    }
    $data['news']=$news;
    $data['system']=get_system();
    $res['data']=$data;
    exit(json_encode($res));
}

//二维码
if($act=='getMyQrcodeCard'){
    $url=$HttpPath.'h5/#/pages/group/detail?from=qrcode&id='.$_REQUEST['id'];
    $logo='';
    if($_REQUEST['type']=='qr_user') {
        $url=$HttpPath.'h5/#/pages/friend/detail?from=qrcode&id='.$_REQUEST['id'];
        $user=userinfo($_REQUEST['id']);
        $logo=$HttpPath.$user['avatar'];
       // $url=json_encode(array('action'=>'user','id'=>$_REQUEST['id']));
    }
    if($_REQUEST['type']=='qr_group') {

        $group=GroupInfo($_REQUEST['id']);
        $logo=$HttpPath.$group['avatar'];
       // $url=json_encode(array('action'=>'group','id'=>$_REQUEST['id']));
    }
    if($_REQUEST['type']=='qr_login') {
       if(session('agent')) $agent=session('agent');
       else {
           $agent=time().rand(10000,99999);
           session('agent',$agent);
       }
        $url=json_encode(array('action'=>'login','from'=>'cj666','agent'=>$agent));
    }

    if($_REQUEST['type']=='qr_invite') {
        $url=$HttpPath."?from=invite&invite_code=".$_REQUEST['code'];
    }

    $path=qr_creat($url);
    $res['code']=200;
    $res['statusCode']=200;
    $res['data']=$path;
    exit(json_encode($res));
}
if($act=='qrcode_login'){
    $fromtime=time()-600;
    $agent=session('agent');
    $db->query("delete * from ".tname('qrcode_login')." where time<'{$fromtime}'");
   $row= $db->exec("select * from ".tname('qrcode_login')." where agent='{$agent}' and time>='{$fromtime}'");
   if($row['uid']>0){
       $res['code']=200;
       $res['step']=$row['step'];
       $res['uid']=$row['uid'];
       $userinfo=userinfo($row['uid']);
       if($row['step']==1){
        $res['message']=$userinfo['nickname']."请在手机APP上确认登录";
       }
       if($row['step']==2){
           $res['message']="登录中，请稍后...";
           login($res['uid'],0);
       }
   }
   else{
     $res['code']=0;
   }
    exit(json_encode($res));
}

if($act=='qrcode_sublogin'){
    $agent=$_REQUEST['agent'];
    $step=$_REQUEST['step'];
    $uid=$_REQUEST['uid'];
    if($step==0){
        $db->query("delete  from ".tname('qrcode_login')." where agent='{$agent}'");
    }
    else{
        $db->query("delete  from ".tname('qrcode_login')." where agent='{$agent}'");
        $db->query("insert into ".tname('qrcode_login')." (uid,agent,time,step) values('{$uid}','{$agent}','".time()."','{$step}')");
    }
    $res['code']=200;

    exit(json_encode($res));
}

//APP初始化
if($act=='init'){
    $res['code']=200;

    $res['data']['system']=$system;
//    $res['data']['']=$wanfa_arr;
//    $res['data']['wanfa1']=$wanfa_arr1;
    $res['data']['note']=$db->fetch_all("select * from ".tname('news')." where type1='9' order by sortnum asc,id desc");;
    exit(json_encode($res));
}
if($act=='getnote'){
    $res['code']=200;

    $res['data']=$db->fetch_all("select * from ".tname('news')." where type1='9' order by sortnum asc,id desc");;
    exit(json_encode($res));
}
if($act=='update'){

    $sys=get_system();
    if ($_POST['osname']=='Android')  $osname='Android';else $osname='ios';
    $version=$sys['version_'.$osname];
    if($version==$_POST['version']){
        $data['status']=0;
    }else{
        $data['status']=1;
        $data['downurl']=$sys['down_'.$osname];
        $data['content']=$sys['update_'.$osname];
    }
    $res['code']=200;
    $res['data']=$data;
    exit(json_encode($res));

}
if($act=='bindcid'){
    $cid=$_REQUEST['cid'];
    $userid=$_REQUEST['userid'];
    $osname=$_REQUEST['osname'];
    $time=time();
  $row=  $db->exec("select * from ".tname('client')." where cid='{$cid}'");
  if($row['id']>0){
      $db->query("update ".tname('client')." set uerid='{$userid}',osname='{$osname}',time='{$time}',isonline='1' where cid='{$cid}'");
  }
  else{
      $db->query("insert into ".tname('client')."(cid,userid,osname,time,isonline) values('{$cid}','{$userid}','{$osname}','{$time}','1')");
  }
    $res['code']=200;
}


if($act=='quitcid'){
    $cid=$_REQUEST['cid'];

    $time=time();
     $db->query("delete  from ".tname('client')." where cid='{$cid}'");

    $res['code']=200;
}

if($act=='client_change'){

    $cid=$_REQUEST['cid'];
    $isonline=$_REQUEST['isonline'];
    $time=time();
    $db->query("update ".tname('client')." set isonline='{$isonline}',time='{$time}' where cid='{$cid}'");
    $res['code']=200;
    $res['data']=time();
}

if($act=='search'){
    $keyword=$_REQUEST['keyword'];
    $page=$_REQUEST['page']?$_REQUEST['page']:1;
    $type=$_REQUEST['type'];
    if($type=='all')$num=3;else $num=10;
    $from=($page-1)*$num;
    $data=array();

    //搜索用户
    if($type=='all' or $type=='user'){
        $sql="select * from " . tname('user') . " where ((id ='{$keyword}' and `number`='')  or `number`='{$keyword}' or nickname like '%{$keyword}%' or name='{$keyword}') and status='0' order by vip desc,id desc limit {$from},{$num}";
        $list=$db->fetch_all($sql);
        if(count($list)>0){
            $arr=array();
            foreach ($list as $key=>$value){
                $user=userinfo($value['id']);
                $row[$key]['nickname']=$user['nickname'];

                if(strpos($user['avatar'],'http')!==false) {

                }else{
                    $user['avatar']=$HttpPath.$user['avatar'];
                }
                if($name==$user['id'] || $name==$user['number']) $from1='search_id';
                else if($name==$user['mobile']) $from1='search_mobile';
                else $from1='search_name';
                $user['from']=$from1;
                $arr[]=$user;
            }
            $data['user']=$arr;
        }
        else $data['user']=array();
    } else $data['user']=array();

    //搜索群组
    if($type=='all' or $type=='group'){
        $sql="select * from ".tname('group')." where is_delete='0' and (`name` like '%{$keyword}%' or id='{$keyword}') order by top desc,id desc limit {$from},{$num}";
        $list=$db->fetch_all($sql);
        if(count($list)>0){
            $arr=array();
            foreach ($list as $key=>$value){
                $arr[]=GroupInfo($value['id'],$userid);
            }
            $data['group']=$arr;
        }
        else $data['group']=array();
    }
    else $data['group']=array();

    $res['data']=$data;
    $res['code']=200;
}

die(json_encode($res));
?>

