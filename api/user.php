<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/12/22
 * Time: 16:43
 */



include_once '../inc/common.php';

$act=trim($_GET['act']);
if($_POST['userid']>0) $userid=$_POST['userid'];
else{
    if($_GET['userid']>0) $userid=$_GET['userid'];
    else
        $userid=$_SESSION['userid'];
}

if($act=='sendVerifyCode'){

    $return=array('code'=>0,'rand'=>rand(100000,999999));

    die(json_encode($return));


}

if($act=='checkname'){
    $name = $_POST['username'];

    if (check_id($name)) {

        $res['code']=0;
        $res['message']="用户名已存在";

    }else{
        $res['code'] = 200;
    }
    die(json_encode($res));
}

if($act=='checkname1'){
    $name = $_POST['username'];
    $res['code'] = 200;
    if (check_id($name)) {

        $res['status']=0;
        $res['message']="用户名已存在";

    }else{
        $res['status'] = 200;
    }
    die(json_encode($res));
}
if($act=='findpwd0'){
    $res['code']=0;
    $name = $_POST['username'];
   $user= $db->exec("select * from ".tname('user')." where name='{$name}' or `number`='{$name}'");
   if($user['id']>0){
       if($user['mobile']){
           $res['code']=200;
           $res['data']=$user;
       }else{
           $res['message']="该用户未绑定手机号，无法找回密码";
       }

   }else{
       $res['message']="该用户名不存在";
   }

    die(json_encode($res));
}

if($act=='findpwd1'){
    if($_POST['randcode']!=session('ranndcode')){
        $res['code']=0;
        $res['message']="验证码错误";

    }
    else  if($_POST['mobile']!=session('mobile')){
        $res['code']=0;
        $res['message']="绑定手机号错误";

    }
    else{
        $res['code']=200;
    }
    die(json_encode($res));
}

if($act=='findpwd2'){

    $pwd=md5($_POST['pwd']);
    $id=$_POST['id'];
    $db->query("update ".tname('user')." set pwd='{$pwd}' where id='{$id}'");
    $res['code']=200;
    die(json_encode($res));
}

if($act=='checkcode'){

    if (strtolower($_POST['randcode'])!=strtolower(session('code'))) {

        $res['code']=0;
    }else{
        $res['code'] = 200;
    }
    die(json_encode($res));
}


if($act=='checkcode1'){
       $res['code'] = 200;

    if (strtolower($_POST['randcode'])!=strtolower(session('code'))) {
        $res['message']=session('code');
        $res['status']=0;
    }else{
        $res['status'] = 200;
    }
    die(json_encode($res));
}

//注册
if($act=='reg'){


    $res = array();
    if(strtolower($_POST['randcode'])!=strtolower(session('code'))){
        $res['code']=0;
        $res['message']="验证码错误";
    }
    else{
        $name = $_POST['username'];

        if (check_id($name)) {

            $res['code']=0;
            $res['message']="用户名已存在";

        }else{


            if($system['inviteopen']==1 && $_REQUEST['invite_code']==''){
                $res['code']=0;
                $res['message']="请输入邀请码";
                die(json_encode($res));
            }

                $data = array();
                if($system['inviteopen']==1){
                    $invite=  $db->exec("select * from ".tname('invite')." where randcode='{$_REQUEST['invite_code']}'");
                    if($invite['id']>0){

                        $data['pid']=$invite['userid'];
                        $data['randcode']=$invite['randcode'];
                        $data['rebate']=$invite['rebate'];
                        $data['isdaili']=$invite['isdaili'];
                     $db->query("update ".tname('invite')." set regnum=regnum+1 where id='{$invite['id']}'");
                    }else{
                        $res['code']=0;
                        $res['message']="邀请码不正确";
                        die(json_encode($res));
                    }

                }



                $now = time();
                $_POST['regip'] = $_SERVER['REMOTE_ADDR'];
                $id=rand_uid();
                $avatar=list_file('../static/avatar');

                $db->query("insert into " . tname('user') . " (`id`,`regtime`,`edittime`) values ('{$id}','$now','$now')");
                if ($db->affected_rows() > 0) {
                    $data['number']=$id;
                    $data['name'] = $_POST['username'];
                    $data['nickname'] = $_POST['nickname'];
                    $data['pwd'] = md5($_POST['password']);
                    $data['avatar']=$avatar[rand(0,count($avatar)-1)];
                    $data['accessToken'] = set_randcode(32);
                    $data['deviceInfo'] = serialize($_POST['deviceInfo']);

                    $db->update(tname('user'), $data, $id);
                    $res['data'] = userinfo($id);
                    $res['code'] = 200;
                    if($system['welcome']){

                        $sql="insert into ".tname('chat')."(userid,touid,`type`,`content`,addtime,groupid) values('{$system['admin_id']}','{$id}','text','\"{$system['welcome']}\"','{$now}','0')";
                        $db->query($sql);

                    }
                    if($system['admin_id']) add_friend($id,$system['admin_id'],'system');
                    $kefulist= $db->fetch_all("select * from ".tname('user')." where iskefu='1'")    ;
                    if(count($kefulist)>0){
                        if($system['kefu_add']=='rand'){
                            $list=array();
                            $list[]=$kefulist[rand(0,count($kefulist)-1)];
                        }
                        else $list=$kefulist;
                        foreach ($list as $value){
                            add_friend($id,$value['id'],'system');
                        }

                    }
                    if($system['inviteopen']==1 && $data['pid']>0){

                        add_friend($id,$data['pid'],'invite');
                    }
                    login($id,0);
                } else {
                    $res['code'] = 0;
                    $res['message'] = '注册失败';
                }

            }


    }


    die(json_encode($res));
}


if($act=='userlogin') {
    $res = array();


    if ($_POST['username'] && $_POST['password']) {
        $name = $_POST['username'];
        $pwd=md5($_POST['password']);
        $sql="select * from " . tname('user') . " where (name='{$name}'  or mobile='{$name}' or `number`='{$name}' )and pwd='{$pwd}' ";
        $user = $db->exec($sql);
        if ($user['id'] > 0) {

            if($user['status']==1){
                $res['code'] = 0;
                $res['message'] = '您的账号已被永久封号！';

            }else{
                $res['data'] =userinfo($user['id']);
               $res['friends']=getMyFriend($user['id']);
                $list=$db->fetch_all("select * from ".tname('group')." where user_id like '%{$user['id']}%' and is_delete='0'");
                $groups=array();
                if(count($list)>0){
                    foreach ($list as $value){
                       $arr=GroupInfo($value['id']);
                       $groups[]=array('id'=>$arr['id'],'nickname'=>$arr['nickname'],'avatar'=>$arr['avatar']);
                    }
                }
                $res['groups']=$groups;

                $res['code'] = 200;

                login($user['id'],$_POST['save']);

            }

        } else {

                $res['code'] = 0;
                $res['message'] = '账号或密码错误';

        }

    }
    else {

        $res['code'] = 0;
        $res['message'] = '请输入登录账号';

    }
    die(json_encode($res));
}

if($act=='profile'){
  $id=$_REQUEST['id'];
  foreach ($_POST as $key=>$value) {
      $db->query("update " . tname('user') . " set `{$key}`='{$value}' where id='{$id}'");
  }
    $res['code'] = 200;
    $res['data']=userinfo($id);
    die(json_encode($res));
}

if($act=='mobile'){
    $id=$_REQUEST['id'];
    if($_POST['randcode']!=session('ranndcode')){
        $res['code']=0;
        $res['message']="验证码错误";

    }
    else   if($_POST['mobile']!=session('mobile')){
        $res['code']=0;
        $res['message']="手机号错误";

    }
    else {
        foreach ($_POST as $key => $value) {
            $db->query("update " . tname('user') . " set `mobile`='{$_POST['mobile']}' where id='{$id}'");
        }
        $res['code'] = 200;
    }
    die(json_encode($res));
}

if($act=='sendCode'){

    $post_data = $_REQUEST;
    $return_data = [
        'code'=>200,
        'msg' => 'success',
    ];

    $db_data= $db->exec("select * from ".tname('user')." where mobile='{$post_data['mobile']}'");
    if($db_data){
        $method='login';
    }
    else $method='reg';
    if(($post_data['type']=='new' or $post_data['type']=='bind') && $method=='login') {
        $return_data['data']=array('method'=>'error','msg'=>'手机号码已被其他用户使用');
        exit (json_encode($return_data));
    }
    if(($post_data['type']=='pwd' || $post_data['type']=='change') && $method=='reg') {
        $return_data['data']=array('method'=>'error','msg'=>'手机号码尚未注册');
        exit (json_encode($return_data));
    }
    session('mobile',$post_data['mobile']);
    session('ranndcode',rand(100000,999999));
//   if($post_data['type']=='pwd')
//     $message="您的验证码为：".session('ranndcode')."，您正在修改账号密码。（验证码告知他人将影响账号安全，请勿泄露）";
//       else if($post_data['type']=='change')
//    $message="您的验证码为：".session('ranndcode')."，您正在解绑账号。（验证码告知他人将影响账号安全，请勿泄露）";
//else
//    $message="您的验证码为：".session('ranndcode')."，您正在绑定账号。（验证码告知他人将影响账号安全，请勿泄露）";

    $message="验证码：".session('ranndcode').'。【哈哈网】';

    $msg= http_sendsms($post_data['mobile'],$message);

    $return_data['data']=array('method'=>$method,'msg'=>$msg);
    exit(json_encode($return_data));


}
if($act=='change_pwd'){
    $id=$_REQUEST['id'];
    $user= $db->exec("select * from ".tname('user')." where id='{$id}'");
    if($_POST['method']=='login'){
        $pwd=$user['pwd'];
    }else{
        $pwd=$user['pwd1'];
    }
    if(md5($_POST['oldpwd'])!=$pwd && !$_POST['isfrist']){
        $res['code']=0;
        $res['message']="原始密码错误";
        die(json_encode($res));
    }
    else{
        $pwd=md5($_POST['password']);
        if($_POST['method']=='login'){
            $type='pwd';
        }else{
            $type='pwd1';
        }

        $db->query("update " . tname('user') . " set `{$type}`='{$pwd}' where id='{$id}'");
        $res['code'] = 200;
        die(json_encode($res));
    }

}

if($act=='reset_pwd'){
    $id=$_REQUEST['id'];
    if($_POST['randcode']!=session('ranndcode')){
        $res['code']=0;
        $res['message']="验证码错误";

    }
    else   if($_POST['mobile']!=session('mobile')){
        $res['code']=0;
        $res['message']="手机号错误";

    }
    else {
        $pwd=md5($_POST['pwd']);
        if($_POST['method']=='login'){
            $type='pwd';
        }else{
            $type='pwd1';
        }

        $db->query("update " . tname('user') . " set `{$type}`='{$pwd}' where id='{$id}'");
        $res['code'] = 200;

    }
    die(json_encode($res));
}
if($act=='online'){
    $res['data']='ok';
    if($_SESSION['userid']>1000){

        if($user['id']>0 && $user['status']!=1){
            $now=time();

            $db->query("update " . tname('user') . " set `online`='{$now}' where id='{$_SESSION['userid']}'");

        }else{
         $res['data']='logout';
         if($user['status']==1){
             $res['message']="您的账号已被封号！";
         }
         else {
             $res['message']="您的账号存在异常，已退出登录";
         }

        }


    }

    $res['code'] = 200;
    die(json_encode($res));
}

if($act=='bank_add'){
    $user=userinfo($userid);
    if(md5($_POST['pwd'])!=$user['pwd1']){
        $res['code']=0;
        $res['message']="资金密码不正确";
    }
    else{
       $row= $db->exec("select * from ".tname('bank')." where banknum='{$_POST['banknum']}'");
        if($row['id']>0){
            $res['code']=0;
            $res['message']="该银行卡号已经被使用，请更换其他银行账号";

        }else{

            $now=time();
            $db->query("insert into ".tname('bank')."(uid,time) values('{$userid}','{$now}')");
            if($db->affected_rows()>0){
                $id=$db->insert_id();
                if($_POST['default']==1) $db->query("update ".tname('bank')." set default=0 where uid='{$userid}'");
                foreach ($_POST as $key=>$value){
                    $db->query("update ".tname('bank')." set `{$key}`='{$value}' where id='{$id}'");
                }
                $res['code']=200;
                $res['message']="操作成功";
            }
            else{
                $res['code']=0;
                $res['message']="网络连接失败，请稍后再试";
            }

        }



    }

    die(json_encode($res));
}

if($act=='sign'){

    if($system['signopen']==1){
        $fromtime=strtotime(date('Y-m-d',time())." 00:00:00");
        $row=$db->exec("select * from ".tname('money')." where  `type`='sign' and uid='{$userid}' and time>='{$fromtime}'");
        if($row['id']>0){
            $res['code']=0;
            $res['message']="您今日已经签到过了";

        }
        else {
            $money=rand($system['sign_min'],$system['sign_max']);
            add_money($userid,$money,'签到奖励','sign');
            $res['message']="签到成功，奖励<span style='color: #ff2600;font-size: 16px;'>{$money}</span>元";
            $res['data']="签到成功，奖励{$money}元";
            $res['code']=200;
        }
    }
    else{
        $res['code']=0;
        $res['message']="签到功能已关闭";
    }



    die(json_encode($res));
}
if($act=='usermoney'){
    $res['code']=200;
     $res['data']=$user['money'];
    die(json_encode($res));
}

if ($act=='unlock'){

    $id=$_POST['id'];
    if($id>0){
        $db->query("update ".tname('user')." set `status`='0' ,lock_time='0' where id='{$id}'");
        add_note(0,$id,"恭喜您，账号已被解封");
        $res['code']=200;
        $res['data']=1;
    }
    else{
        $res['code']=0;
        $res['message']="用户id不存在";
    }
    die(json_encode($res));
}

if ($act=='ismobile'){
    if($user['mobile']){
        $res['code']=200;
    }
    else {
        $res['code']=0;
    }

    die(json_encode($res));
}
//获取用户信息
if($act=='getUserInfo'){

    $id=$_REQUEST['friend_uid'];
    $from_uid=$_REQUEST['from_uid'];
    if($id>0){
        $user=userinfo($id);

        if($from_uid)  {
            if(is_friend($from_uid,$id) and is_friend($id,$from_uid))$user['is_friend']=1;
            else $user['is_friend']=0;

            $friends=  $db->exec("select * from ".tname('friend')." where userid='{$from_uid}' and friendid='{$id}'");
            $user['from']=$friends['from'];
            $user['mark']=$friends['mark'];
            if($user['mark']==null) $user['mark']='';
        }
        else $user['is_friend']=0;
        $res['data'] =$user;
        $res['code'] = 200;
    }
    else{
        $res['code'] = 0;
        $res['msg'] = '用户id错误';
    }
    die(json_encode($res));
}




//获取用户信息
if($act=='getUserStore'){

//    return json(VendorService::getUserStore(array_merge(Request::post(),['user_id'=>USER_ID])))

    $type=$_REQUEST['type'];
    $from_uid=$_REQUEST['userid'];
    if($from_uid>0){
        //$user=userinfo($id);

        $list = $db->fetch_all("select * from " . tname('store') . " where user_id='{$from_uid}' and type='{$type}'");
        $res['data'] =$list;
        $res['code'] = 200;
    }
    else{
        $res['code'] = 0;
        $res['msg'] = '用户id错误';
    }
    die(json_encode($res));
}
//设置好友备注

if ($act=='setmark'){
    $friend_uid=$_REQUEST['friend_uid'];
    $userid=$_REQUEST['userid'];
    $db->query("update ".tname('friend')." set mark='{$_REQUEST['mark']}' where userid='{$userid}' and friendid='{$friend_uid}' ");

    $res['data'] =true;
    $res['code'] = 200;
    die(json_encode($res));
}


//好友申请

if($act=='applyAddFriend'){
    if($_POST['userid'] and $_POST['friend_uid']){
        $userinfo=userinfo($_POST['userid']);
        $row=$db->exec("select count(*) as num from ".tname('group')." where createid='{$user_id}'");
        if($row['num']>=$system['friend_num'.$userinfo['usertype']]){
            $res['code']=0;
            $res['message']="您最多可以添加{$row['num']}个好友，如需更多请升级为VIP";
            exit(json_encode($res));
        }


        $now=time();
        //好友也像你发起申请
        if($db->exec("select * from ".tname('request')." where touid='{$_POST['userid']}' and userid='{$_POST['friend_uid']}' and status=0")){
            add_friend($request['userid'],$request['touid'],$_REQUEST['from']);
            $res['data']['message'] ='添加好友成功';
            $res['data']['send']=2;
            $res['code']=200;
            $mark=$_REQUEST['mark']?$_REQUEST['mark']:'我们已经是好友了，很高兴认识你';
            add_note($_POST['userid'],$_POST['friend_uid'],$mark);
            $db->query("update app_request set status='1' where touid='{$_POST['userid']}' and userid='{$_POST['friend_uid']}'");
            die(json_encode($res));
        }

        $touser=userinfo($_POST['friend_uid']);
        if(strpos($touser['backlist'],$_POST['userid'])!==false){

            $res['code'] = 0;
            $res['message'] = '添加好友失败';
            die(json_encode($res));
        }



        $old=$db->exec("select * from ".tname('request')." where userid='{$_POST['userid']}' and touid='{$_POST['friend_uid']}'");
        if($old){
            $mark=unserialize($old['mark']);
        }
        $mark1=array();
        if(count($mark)){
            foreach ($mark as $value){
                if($value){
                    $mark1[]=$value;
                }
            }
        }
        if($_POST['mark']) $mark1[]=$_POST['mark'];
        $mark1=serialize($mark1);

        $sql="insert into ".tname('request')."(userid,touid,mark,addtime,`type`,`from`) values('{$_POST['userid']}','{$_POST['friend_uid']}','{$mark1}','{$now}',1,'{$_REQUEST['from']}')";
        $db->query($sql);
        if($db->affected_rows()>0){

            $res['data']['message'] ='好友申请已经提交';
            $res['data']['send']=1;
            if($old) $db->query("delete from ".tname('request')." where id='{$old['id']}'");
            $userinfo=userinfo($_POST['userid']);
            $content=$userinfo['nickname']."申请添加您为好友";
            $time=time();
            $db->query("insert into ".tname('offline_request')." (uids,title,content,`time`,`type`) values ('{$_POST['friend_uid']}','验证消息','{$content}','{$time}','friend')");

        }else {
            $res['data']['message'] ='网络异常，请稍后再试';
            $res['data']['send']=0;
        }


        $res['code'] = 200;


    }
    else{
        $res['code'] = 0;
        $res['msg'] = '参数错误';
    }
    die(json_encode($res));


}

//好友申请的列表
if($act=='getFriendApply'){
   ;
    if($_REQUEST['read']==1){
        $db->query("update app_request set `read`='1'  where touid='{$userid}' and `type`='1'");
        $str='';
    }
    else $str="and `read`=0 ";
    $page=$_REQUEST['page']?$_REQUEST['page']:1;
    $num=10;
    $from=($page-1)*$num;
    $sql="SELECT * FROM app_request where touid='{$userid}'  and del_uids not like '%@{$userid}@%' order by id desc limit {$from},{$num}";
    $row=$db->fetch_all($sql);
    $data=array();
    if(count($row)>0){
        foreach ($row as $key=>$value){
            $user=userinfo($value['userid']);
            $row[$key]['nickname']=$user['nickname'];

            if(strpos($user['avatar'],'http')!==false) {

            }else{
                $user['avatar']=$HttpPath.$user['avatar'];
            }
            $row[$key]['user']=array('id'=>$user['id'],'nickname'=>$user['nickname'],'avatar'=>$user['avatar']);
            $row[$key]['mark']=unserialize($value['mark']);
            $db->query("update app_request set `read`='1'  where id='{$value['id']}' ");
        }
    }
    else $row=array();
    $res['code'] = 200;
    $res['data']=$row;

    die(json_encode($res));

}
//好友申请数量
if($act=='getFriendApplyCount'){
    $sql="SELECT * FROM app_request where touid='{$touid}' and  status='0'  order by id desc";
    $row=$db->fetch_all($sql);
    $data=array();
    $res['code'] = 200;
    $res['data']=count($row);
    die(json_encode($res));
}


//处理好友申请
if($act=='handleFriendApply'){
    $id=$_REQUEST['id'];
    $status=$_REQUEST['status'];

    $request=$db->exec("select * from app_request where id='{$id}'");
    if($request){
        $res['code'] = 200;

        if($status==1){
            $mark=unserialize($request['mark']);
            $mark=$mark[count($mark)-1];
            $mark=$mark?$mark:'我们已经是好友了，很高兴认识你';
            add_note($request['userid'],$request['touid'],$mark);
            add_friend($request['userid'],$request['touid'],$request['from']);
            $res['data']=1;
        }
        else{
            $res['data'] = 0;
             $apply=json_decode($_REQUEST['apply'],true);
            $user=userinfo($request['touid']);
             if($apply['input']!=''){

                 add_note(0,$request['userid'],$user['nickname']."拒绝你的添加好友请求<br />拒绝理由：{$apply['input']}")   ;
                 $db->query("update app_request set apply_content='{$apply['input']}' where id='{$id}'");

             }
             if($apply['rediocheck']==true){
                 $backlist=$user['backlist'];
                 if($backlist!='') $backlist.=',';
                 $backlist.=$request['userid'];
                 $db->query("update app_user set backlist='{$backlist}' where id='{$request['touid']}'");
             }
           //
        }
        $db->query("update app_request set status='{$status}' where id='{$id}'");
    }else{
        $res['code'] = 0;
        $res['msg'] = '参数错误';
    }

    die(json_encode($res));

}

//加入黑名单

if ($act=='backlist'){
    $id=$_REQUEST['id'];
    $user=userinfo($userid);
    $backlist=explode(',',$user['backlist']);
    if(!in_array($id,$backlist)){
        $backlist[]=$id;
    }else{
        foreach ($backlist as $key=> $value){
            if($value==$id) unset($backlist[$key]);
        }
    }
    $backlist=implode(',',$backlist);
    $db->query("update app_user set backlist='{$backlist}' where id='{$userid}'");
    $res['code'] = 200;
    $res['data']=$backlist;
    die(json_encode($res));
}

if($act=='getbacklist'){
    $user=userinfo($userid);
    $backlist=$user['backlist'];
    if($backlist!=''){

        $list=$db->fetch_all("select id from ".tname('user')." where id in ({$backlist}) order BY CONVERT(nickname USING gbk)");


        if(count($list)>0) {
            foreach ($list as $key => $value) {

                $user11 = userinfo($value['id']);
               if(!$user11['nickname']) $user11['nickname']=$user11['name'];
                $list[$key] = array('id' => $user11['id'], 'nickname' => $user11['nickname'], 'avatar' => $user11['avatar']);

            }
        }
        else{
            $list=array();
        }

    }else{
        $list=array();
    }
    $res['code'] = 200;
    $res['data']=$list;
    die(json_encode($res));

}

//搜索用户

if($act=='searchUser'){
    $res=array();
    $name=$_GET['keywords'];
    if($name){

        $list = $db->fetch_all("select * from " . tname('user') . " where (((id ='{$name}' and `number`='') or `number`='{$name}' ) or name='{$name}')and status='0' order by id desc ");
        $res['code']=200;
        $res['data']['total']=count($list);
        $arr=array();
        if(count($list)>0){

            foreach ($list as $value){
                $user=userinfo($value['id']);
                $row[$key]['nickname']=$user['nickname'];

                if(strpos($user['avatar'],'http')!==false) {

                }else{
                    $user['avatar']=$HttpPath.$user['avatar'];
                }
               if($name==$user['id'] || $name==$user['number']) $from='search_id';
                else if($name==$user['mobile']) $from='search_mobile';
                else $from='search_name';
                $user['from']=$from;
                $arr[]=$user;

            }

        }

        $res['data']=$arr;

    }
    else{
        $res['code'] = 0;
        $res['message'] = '请输入搜索信息';
    }
    die(json_encode($res));

}


//好友列表
if ($act=='getMyFriend'){
    $userid=$_REQUEST['userid'];

    $res['code']=200;
    $res['data']=getMyFriend($userid);
    die(json_encode($res));

}

if ($act=='getchatinfo'){
    $id=$_REQUEST['id'];
//
//    $res['code']=200;
//    $res['data']=getMyFriend($userid);

    $data=    $db->exec("select * from app_chat where id='{$id}'");
    $res['code']=200;
    $res['data']=$data;
    die(json_encode($res));

}


if ($act=='getMyFriend1'){
   $userid=$_REQUEST['userid'];
//
   $res['code']=200;
  $res['data']=friendList($userid);

    $str='{"code":200,"data":{"data":{"24":{"letter":"Y","data":[{"photo":"default_man/300.jpg","user_id":10126,"name":"123456"}],"index":24},"25":{"letter":"d","data":[{"photo":"default_man/300.jpg","user_id":539372,"name":"45678"}],"index":25}},"member":[5880,6114,1]}}';
   // die($str);

    die(json_encode($res));

}
//删除好友
if($act=='deleteFriend'){
    $res['code']=200;
    if($_REQUEST['userid'] && $_REQUEST['friendid']){
        $db->query("delete from ".tname('friend')." where userid='{$_REQUEST['userid']}' and friendid='{$_REQUEST['friendid']}'");
        $db->query("delete from ".tname('friend')." where friendid='{$_REQUEST['userid']}' and userid='{$_REQUEST['friendid']}'");
        $res['data']=1;
    }
    else {
        $res['code'] = 0;
        $res['message'] = '好友不存在';
    }

    die(json_encode($res));
}


if($act=="userdetail"){
    $res['code']=200;
    $user=userinfo($_REQUEST['id'],$userid);
    if($_REQUEST['group_id']>0){

        $group=GroupInfo($_REQUEST['group_id'],$_REQUEST['id']);
        if($_REQUEST['id']==$group['createid']){

            $jointime=date('Y-m-d H:i:s',$group['addtime']);
        }else{
            $group_users=group_users($_REQUEST['group_id']);
            if(count($group_users)>0){

                foreach ($group_users as $value){
                    if($value['id']==$_REQUEST['id']){

                        $jointime=date('Y-m-d H:i:s',$value['jointime']);
                    }
                }
            }
        }

        $fromtime=time()-7*24*3600;
        $chat= $db->exec("select * from ".tname('chat')." where userid='{$_REQUEST['id']}' and groupid='{$_REQUEST['group_id']}' and isback='0' and addtime>='{$fromtime}' order by id desc limit 0,1");
        if($chat['id']>0){
            $chattime=date('Y-m-d H:i:s',$chat['addtime']);
        }
        else $chattime='七天前';

    }
    if ($user['isvip']==1){
        $rate1=$rate2=0;
        $row=  $db->exec("select max(rate) as rate from ".tname('plan')." where userid='{$_REQUEST['id']}' and updatetime>='{$fromtime1}'");
        $rate1=$row['rate'];
        if(!$rate1)$rat1e=0;
        $rate2=$user['rate'];
        $gameshow=[];
        $sql="SELECT gamekey,sum(prize_num)/sum(plantimes) FROM ".tname('plan')." where  userid='{$user['id']}'  group by gamekey order by sum(prize_num)/sum(plantimes)  desc limit 0,3";
        $temp1=$db->fetch_all($sql);

        if(count($temp1)>0){
            foreach ($temp1 as $value){
                $row=$db->exec("select * from ".tname('game')." where showkey='{$value['gamekey']}'");
                if($row['id']>0)
                    $gameshow[]=$row['title'];
            }
        }

        $tags=array();
        $sql="SELECT wf1,sum(prize_num)/sum(plantimes) FROM ".tname('plan')." where userid='{$user['id']}' group by wf1 order by sum(prize_num)/sum(plantimes)  desc limit 0,3";
        $wanfa=$db->fetch_all($sql);
        if(count($wanfa)>0){
            foreach ($wanfa as $value){
                $tags[]=$wanfa_arr['ssc'][$value['wf1']];
            }
        }
    }
    $isuseraction=0;
    if($userid>0 && $user['isvip']==1){
        $row=  $db->exec("select * from ".tname('user_action')." where userid='{$_SESSION['userid']}' and touid='{$user['id']}'");
        if($row['id']>0) $isuseraction=1;

    }

    $data=array('jointime'=>$jointime,'chattime'=>$chattime,'rate1'=>$rate1,'rate2'=>$rate2,'isuseraction'=>$isuseraction,'gameshow'=>$gameshow,'tags'=>$tags,'grade_name'=>$plan_grade_arr[$user['plan_grade']]);
    $res['data']=array_merge($user,$data,$_REQUEST);
    die(json_encode($res));
}


if($act=='userinfo'){
    if($_POST['id']>0){
        $res['code']=200;
        $user=userinfo($_POST['id']);
        $userid=$_POST['id'];
        $fromtime=strtotime(date('Y-m-d',time())." 00:00:00");

        $row=$db->exec("select sum(money) as money from ".tname('money')."  where (`type`='sale' or `type`='reward') and uid='{$userid}' and time>='{$fromtime}' ");
        $yongjin=$row['money'];
        if(!$yongjin) $yongjin=0;
        $row=$db->exec("select sum(money) as money from ".tname('money')."  where `type`='yongjin' and uid='{$userid}' and time>='{$fromtime}' ");
        $dashang=number_format($row['money'],2,'.','');
        if(!$dashang) $dashang=0;


        $row=$db->exec("select * from ".tname('money')." where  `type`='sign' and uid='{$userid}' and time>='{$fromtime}'");
        if($row['id']>0){
            $is_signed=1;
        }
        else $is_signed=0;
        $bank=$db->exec("select count(*) as num from ".tname('bank')." where uid='{$userid}' order by `default` desc,id asc");
        $user['yongjin']=$yongjin;
        $user['dashang']=$dashang;
        $user['is_signed']=$is_signed;
        $user['banknum']=$bank['num'];
        $res['data']=$user;
    }
    else{
        $res['code']=0;
        $res['message']='参数错误';
    }
    die(json_encode($res));
}

if($act=='mybank'){
    $bank=$db->fetch_all("select * from ".tname('bank')." where uid='{$userid}' order by `default` desc,id asc");

    if(count($bank)>0){
        foreach ($bank as $key=> $value){
            $bank[$key]['number']=$value['bankname'].'-'.$value['realname'].'-'.substr($value['banknum'], 0,4).'******'.substr($value['banknum'], strlen($value['banknum'])-3,3);;
        }
    }
    $res['code']=200;
    $res['data']=$bank;
    $res['num']=count($bank);
    $res['banklist']=$bank_arr;
    die(json_encode($res));
}

if($act=='orderlist'){
    if($_POST['begintime']) $begintime=$_POST['begintime'];
    else $begintime=date('Y-m-d',time()-30*86400);

    $str.=" and  time>='".strtotime($begintime.' 00:00:00')."'";
    if($_POST['endtime']) $endtime=$_POST['endtime'];
    else $endtime=date('Y-m-d',time());
    $str.=" and time<='".strtotime($endtime.' 23:59:59')."'";

    if(strlen($_POST['type'])>0) $str.=" and type='{$_POST['type']}'";
    $sql="select * from ".tname('money')." where uid='{$userid}' {$str} order by id desc";
    $num=20;
    $page=$_REQUEST['page']?$_REQUEST['page']:1;
    $page=new Page($sql, $num, $page);
    $sql.=" limit $page->from,$num";
    $list=$db->fetch_all($sql);
    if(count($list)>0){

    }else $list=[];
    $res['code']=200;
    $res['data']=$list;

    die(json_encode($res));
}
if($act=="rechargeset"){
    $method=unserialize($system['recharge_method']);
    $setting=unserialize($system['recharge_setting']);
    $bank=array();
    if(count($method)>0){
        foreach ($method as $key=>$value){
            $row=$db->fetch_all("select * from app_charge where status=1 and method='{$value}' order by id asc");
            if(count($row)>0){
                foreach ($row as $k=>$v){
                    $row[$k]['bankname']=$bank_arr1[$v['bank']];
                }
                $bank[$value]=$row;
            }else{
                unset($method[$key]);
            }
        }
    }

    $res['code']=200;
    $res['data']=array('method'=>$method,'setting'=>$setting,'way'=>$recharge_arr,'bank'=>$bank,'online'=>false);

    die(json_encode($res));
}

if($act=='invite_add'){
    $user=userinfo($userid);
    if($user['isdaili']==1){
       $randcode=get_invite_code();
       if($_REQUEST['rebate']>=$user['rebate']) $_REQUEST['rebate']=$user['rebate']-0.5;
       $now=time();
       $sql="insert into ".tname('invite')."(userid,addtime,rebate,isdaili,randcode,remark) values('{$userid}','{$now}','{$_REQUEST['rebate']}','{$_REQUEST['isdaili']}','{$randcode}','{$_REQUEST['remark']}')";
       $db->query($sql);
        $id=$db->insert_id();
       if($id>0){
           $res['data']=$db->exec("select * from ".tname('invite')." where id='{$id}'");
           $res['code']=200;

       }else{
           $res['code']=0;
           $res['message']="操作失败，请稍后再试";
       }
    }else{
        $res['code']=0;
        $res['message']="您不是代理，无法添加邀请链接";
    }

    die(json_encode($res));

}
if($act=='invite_list'){
    $res['data']=$db->fetch_all("select * from ".tname('invite')." where userid='{$userid}' order by id desc");
    $res['code']=200;
    die(json_encode($res));
}

if($act=='invite_delete'){
    $db->query("delete from ".tname('invite')." where id='{$_REQUEST['id']}' and userid='{$userid}'");
    $res['data']=$db->fetch_all("select * from ".tname('invite')." where userid='{$userid}' order by id desc");
    $res['code']=200;
    die(json_encode($res));
}
if($act=='search_invite'){
    $page=$_REQUEST['page']?$_REQUEST['page']:1;
    $num=10;
    $from=($page-1)*$num;
    $uids=get_teamids($_REQUEST['fromid']);
    $uids=implode(',',$uids);
    $row=$db->exec("select * from ".tname('user')." where name='{$_REQUEST['username']}' and id in ({$uids})");
    if($row['id']>0){
        $userid=$row['id'];
        if($page==1)   $myuser=$db->fetch_all("select * from ".tname('user')." where id='{$userid}' ");
        $list=$db->fetch_all("select * from ".tname('user')." where pid='{$userid}' order by regtime desc limit {$from},{$num}");
        if(count($list)>0){
            if($page==1) $list=array_merge($myuser,$list);
        }
        else{
            if($page==1) $list=$myuser;
            else $list=[];
        }

        if(count($list)>0){
            foreach ($list as $key=> $value){
                $value=userinfo($value['id'])   ;
                $value['team_num']=count(get_teamids($value['id']));
                $value['team_money']=get_teammoney($value['id']);
                $value['money']=number_format($value['money'],2,'.','');
                if(time()-$value['online']<60  ){
                    $value['isonline']=true;
                }else{
                    $value['isonline']=false;
                }
                $value['rebate']=number_format($value['rebate'],1);
                $list[$key]=$value;
            }
        }else{
            $list=array();
        }
        $row=$db->exec("select count(*) as num from ".tname('user')." where pid='{$userid}'");
        $res['pagesum']=ceil($row['num']/$num);
        $res['total']=$row['num'];
        if($_REQUEST['fromid']!=$userid){
            $pids=get_userpids($userid);
            $parent=array();
            if(count($pids)>0){
                for($i=count($pids)-1;$i>=0;$i--){
                    $parent[]=$pids[$i];
                    if($pids[$i]==$_REQUEST['fromid']) break;
                }
            }
            $myuser=userinfo($userid);
            $parent[]=array('id'=>$myuser['id'],'name'=>$myuser['name']);
        }else{
            $parent=array();
        }

        $res['parent']=$parent;


        //$res['pids']=get_teamids($userid);
        $res['data']=$list;
        $res['code']=200;
    }
    else{
        $res['code']=0;
        $res['message']='您搜索的账号暂时不存在';
    }



    die(json_encode($res));
}

if($act=='set_vip'){
    $fromid=$_REQUEST['fromid'];
    $userinfo=userinfo($userid);
    if($userinfo['vip']==2){
        $db->query("update ".tname('user')." set vip='0' ,vip_time='0' where id='{$userid}'");
        add_note(0,$userid,'您的上级取消了您的VIP权限');
        $res['code']=200;
    }else{
       if($userinfo['vip']!=0){
           $res['code']=0;
           $res['message']='您无法取消该用户的VIP';
       }else{
           $row=$db->exec("select  count(*) as num from app_user where pid='{$fromid}' and vip='2'");
           $vipnum=$system['vip1_max']-$row['num']-1;
           if($vipnum<=0){
               $res['code']=0;
               $res['message']='您的VIP配额已经没有剩余了';
           }else{
               $fromuser=userinfo($fromid);
               $db->query("update ".tname('user')." set vip='2' ,vip_time='{$fromuser['vip_time']}' where id='{$userid}'");
               add_note(0,$userid,'恭喜您!您的上级为您设置了VIP权限');
               $res['code']=200;
           }

       }
    }
    die(json_encode($res));
}

if($act=='my_invite'){

    $page=$_REQUEST['page']?$_REQUEST['page']:1;
    $num=10;
    $from=($page-1)*$num;
    if($page==1)   $myuser=$db->fetch_all("select * from ".tname('user')." where id='{$userid}' ");
    $list=$db->fetch_all("select * from ".tname('user')." where pid='{$userid}' order by regtime desc limit {$from},{$num}");
    if(count($list)>0){
        if($page==1) $list=array_merge($myuser,$list);
    }
    else{
        if($page==1) $list=$myuser;
        else $list=[];
    }

    if(count($list)>0){
        foreach ($list as $key=> $value){
            $value=userinfo($value['id'])   ;
            $value['team_num']=count(get_teamids($value['id']));
            $value['team_money']=get_teammoney($value['id']);
            $value['money']=number_format($value['money'],2,'.','');
            if(time()-$value['online']<60  ){
                $value['isonline']=true;
            }else{
                $value['isonline']=false;
            }
            $value['rebate']=number_format($value['rebate'],1);
            $list[$key]=$value;
        }
    }else{
        $list=array();
    }
    $row=$db->exec("select count(*) as num from ".tname('user')." where pid='{$userid}'");
    $res['pagesum']=ceil($row['num']/$num);
    $res['total']=$row['num'];
    if($_REQUEST['fromid']!=$userid){
        $pids=get_userpids($userid);
        $parent=array();
        if(count($pids)>0){
            for($i=count($pids)-1;$i>=0;$i--){
                $parent[]=$pids[$i];
                if($pids[$i]==$_REQUEST['fromid']) break;
            }
        }
        $myuser=userinfo($userid);
        $parent[]=array('id'=>$myuser['id'],'name'=>$myuser['name']);
    }else{
        $parent=array();
    }

    $res['parent']=$parent;
    $row=$db->exec("select  count(*) as num from app_user where pid='{$fromid}' and vip='2'");
    $vipnum=$system['vip1_max']-$row['num']-1;
    $res['vipnum']=$vipnum;

    //$res['pids']=get_teamids($userid);
    $res['data']=$list;
    $res['code']=200;
    die(json_encode($res));


}


if($act=='user_add'){
    if (check_id($_POST['username'])) {

        $res['code']=0;
        $res['message']="用户名已存在";

    }else {
        $data = array();
        $now = time();
        $_POST['regip'] = $_SERVER['REMOTE_ADDR'];
        $id = rand_uid();
        $avatar = list_file('../static/avatar');

        $db->query("insert into " . tname('user') . " (`id`,`regtime`,`edittime`) values ('{$id}','$now','$now')");
        if ($db->affected_rows() > 0) {
            $data['pid'] = $userid;
            $data['isdaili'] = $_POST['isdaili'];
            $data['rebate'] = $_POST['rebate'];
            $data['number'] = $id;
            $data['name'] = $_POST['username'];
            $data['pwd'] = md5($_POST['password']);
            $data['avatar'] = $avatar[rand(0, count($avatar) - 1)];
            $data['accessToken'] = set_randcode(32);
            $data['deviceInfo'] = serialize($_POST['deviceInfo']);
            $db->update(tname('user'), $data, $id);
            $res['data'] = userinfo($id);
            $res['code'] = 200;

            if ($system['admin_id']) add_friend($id, $system['admin_id'], 'system');
            $kefulist = $db->fetch_all("select * from " . tname('user') . " where iskefu='1'");
            if (count($kefulist) > 0) {
                if ($system['kefu_add'] == 'rand') {
                    $list = array();
                    $list[] = $kefulist[rand(0, count($kefulist) - 1)];
                } else $list = $kefulist;
                foreach ($list as $value) {
                    add_friend($id, $value['id'], 'system');
                }
            }

            add_friend($id, $data['pid'], 'invite');


        } else {
            $res['code'] = 0;
            $res['message'] = '注册失败';
        }
    }
    die(json_encode($res));
}
if($act=='set_rebate'){
    $db->query("update ".tname('user')." set rebate='{$_REQUEST['rebate']}' where id='{$userid}'");
    $res['code']=200;
    $res['message']='操作成功';
    die(json_encode($res));
}

//朋友圈三张图片

if ($act=='circleImg'){
    $list=  $db->fetch_all("select * from ".tname('circle')." where userid='{$_REQUEST['id']}' order by id desc");
    $data=array();
    if(count($list)>0){
        foreach ($list as $value){
            $imgs=unserialize($value['value']);
            for($i=0;$i<count($imgs);$i++){
                if(count($data)<3) $data[]=$imgs[$i];
                else break;

            }
            if(count($data)>=3) break;
        }

    }
    $res['code']=200;
    $res['data']=$data;
    die(json_encode($res));
}


//投诉用户
if($act=='toreport'){
    $now=time();
    $sql="insert into ".tname('user_report')."(userid,fromid,content,time,status) values('{$_REQUEST['id']}','{$userid}','{$_REQUEST['content']}','{$now}','0')";
    $db->query($sql);
    if($db->affected_rows()>0){
        $res['code']=200;
    }else{
        $res['code']=0;
        $res['message']='当前网络存在异常，请稍后再试';
    }
    die(json_encode($res));
}