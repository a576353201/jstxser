<?php
include_once '../inc/common.php';
need_login();
$userid=$_REQUEST['userid']?$_REQUEST['userid']:$_SESSION['userid'];
$row=$db->exec("select count(*) as num from ".tname('user')." where pid='{$userid}'");
$pagesum=ceil($row['num']/$num);
$total=$row['num'];


if($_REQUEST['act']=='search'){
    $page=$_REQUEST['page']?$_REQUEST['page']:1;
    $num=10;
    $from=($page-1)*$num;
    $uids=get_teamids($userid);
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


        //$res['pids']=get_teamids($userid);
        $user_list=$list;

    }
    else{
      $user_list=array();
    }

}
else{
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
    $invite_list=$db->fetch_all("select * from ".tname('invite')." where userid='{$userid}' order by id desc");
    $page=$_REQUEST['page']?$_REQUEST['page']:1;
    $num=10;
    $from=($page-1)*$num;
    if($page==1)   $myuser=$db->fetch_all("select * from ".tname('user')." where id='{$userid}' ");

    $user_list=$db->fetch_all("select * from ".tname('user')." where pid='{$userid}' order by regtime desc limit {$from},{$num}");
    if(count($user_list)>0){
        if($page==1) $user_list=array_merge($myuser,$user_list);
    }
    else{
        if($page==1) $user_list=$myuser;
        else $user_list=[];
    }
    $row=$db->exec("select count(*) as num from ".tname('user')." where pid='{$userid}'");
    $pagesum=ceil($row['num']/$num);
    $total=$row['num'];
    if(count($user_list)>0){
        foreach ($user_list as $key=> $value){
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
            $user_list[$key]=$value;
        }
    }else{
        $user_list=array();
    }
}


$row=$db->exec("select  count(*) as num from app_user where pid='{$_SESSION['userid']}' and vip='2'");
$vipnum=$system['vip1_max']-$row['num']-1;

$max_rebate=$user['rebate']-0.5;

$method=$_GET['method']?$_GET['method']:0;
include_once template('user/invite');