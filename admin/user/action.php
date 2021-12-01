<?php
include_once '../../inc/common.php';
$action=trim($_GET['action']);

if($action=='add'){

		if($_POST['parent'] ){

					$parent=get_user_byname($_POST['parent']);

					$_POST['pid']=$parent['id'];

				}
				else{
                }
$time=time();
	//	$_POST['endtime']=$_POST['addtime']*365*24*3600+$time;
    $id=rand_uid();

   $db->query("insert into ".tname('user')." (id,`regtime`) values ('{$id}','$now')");
	if($db->affected_rows()>0){
        $avatar=list_file('../../static/avatar');
        $_POST['avatar']=$avatar[rand(0,count($avatar)-1)];
		$_POST['number']=$id;
		$_POST['pwd']=md5($_POST['pwd']);
        $_POST['worker_setting']=serialize( $_POST['worker_setting']);
		if($_POST['status']==-1) $_POST['endtime']=time();
        if($_POST['vip']==1){
            $_POST['vip_time']=strtotime($_POST['vip_time'].' 23:59:59');
        }else{
            $_POST['vip_time']=0;
        }
        if($_POST['isdaili']==0){
            $_POST['rebate']=0;
        }
        if($_POST['parent_name']!=''){
            $parent=$db->exec("select * from ".tname('user')." where name='{$_POST['parent_name']}'");
            if($parent['id']>0){
                if($_POST['rebate']>=$parent['rebate']){
                    promptMessage($_SERVER['HTTP_REFERER'], "返点必须<={$parent['rebate']}%");
                    exit();
                }
                else{
                    $_POST['pid']=$parent['id'];
                }

            }else{
                promptMessage($_SERVER['HTTP_REFERER'], "您填写的上级用户【{$_POST['parent_name']}】不存在");
                exit();
            }
        }
	///	$_POST['bankinfo']=serialize($_POST['bankinfo']);
		$db->update(tname('user'), $_POST, $id);

add_adminlog('新建用户：'.$_POST['name']);

        ?>
        <script>


            parent.location.href=parent.location.href;
        </script>
        <?php
	}


}


if($action=='delete'){
$user=get_table(tname('user'), $_GET['id']);
$id=$_GET['id'];
	if(delete(tname('user'), $_GET['id'])){
     $db->query("delete from ".tname('friend')." where userid='{$_GET['id']}' or friendid='{$_GET['id']}'");
        $db->query("delete from ".tname('chat')." where userid='{$_GET['id']}' or touid='{$_GET['id']}'");
        $db->query("delete from ".tname('group')." where createid='{$_GET['id']}'");

      $list=  $db->fetch_all("select * from ".tname('group')." where user_id like '%{$id}%'");
      if(count($list)>0){
          foreach ($list as $value){
            $user_id=str_replace(",{$id}",'',$value['user_id']);
            $manager_id=str_replace(",{$id}",'',$value['manager_id']);
              $manager_id=str_replace("{$id},",'',$manager_id);
    $db->query("update ".tname('group')." set user_id='{$user_id}',manager_id='{$manager_id}' where id='{$value['id']}'");

          }

      }


		add_adminlog('删除用户：'.$user['name']);

if($_GET['from']=='user'){
	promptMessage('index.php', '恭喜您！删除成功');


}
else{
		if($user['group']==1 or $user['group']==2) $url="index1.php";
			if($user['group']==3) $url="index2.php";
			if($user['group']==4) $url="index3.php";
		promptMessage($url, '恭喜您！删除成功');


}


	}



}
if($action=='edit'){
		$id=$_GET['id'];
    $user=get_table(tname('user'), $id);
		if($_POST['number']!=$_GET['id'] && $_POST['number']!=$user['number']){
         unset($_POST['id']);

	      if( check_id($_POST['number'])){
              promptMessage($_SERVER['HTTP_REFERER'], '您更改的id已经被其他人使用');
	          exit();
          }

        }


     if($user['status']!=2 && $_POST['status']==2){
		    //锁定账号
         $_POST['lock_time']=time()+$_POST['lock_day']*24*3600;

         $content="您的账号因违规操作，已被管理员锁定{$_POST['lock_day']}天<br>预计解封时间：".date('Y-m-d H:i:s',  $_POST['lock_time']);
         if ($_POST['lock_mark']) $content.="<br>违规原因:".$_POST['lock_mark'];
         add_note(0,$id,$content);
         unset($_POST['lock_day']);
     }

     if($_POST['vip']==1){
         $_POST['vip_time']=strtotime($_POST['vip_time'].' 23:59:59');
     }else{
         $_POST['vip_time']=0;
     }
     if($_POST['isdaili']==0){
         $_POST['rebate']=0;
     }
     if($_POST['parent_name']!=''){
         $parent=$db->exec("select * from ".tname('user')." where name='{$_POST['parent_name']}'");
         if($parent['id']>0){
             if($_POST['rebate']>=$parent['rebate']){
               //  promptMessage($_SERVER['HTTP_REFERER'], "返点必须<={$parent['rebate']}%");
               //  exit();
             }
             else{
                 $_POST['pid']=$parent['id'];
             }

         }else{
             promptMessage($_SERVER['HTTP_REFERER'], "您填写的上级用户【{$_POST['parent_name']}】不存在");
             exit();
         }
     }
     //修改客服备注
    if($_POST['iskefu']==1 && $_POST['kefu_name']!=$user['kefu_name']){

         $db->query("update ".tname('friend')." set mark='{$_POST['kefu_name']}' where friendid='{$user['id']}'");
    }

	if($_POST['pwd']){
		$_POST['pwd']=md5($_POST['pwd']);

	}
	else
	unset($_POST['pwd']);

	if($_POST['addtime']>0){
		if($user['endtime']>=$user['regtime']){
			$time=$user['endtime'];

		}
		else $time=time();
	//	$_POST['endtime']=$_POST['addtime']*365*24*3600+$time;

	}
			if($_POST['status']==-1) $_POST['endtime']=time();

//$_POST['file']=serialize($_POST['file']);

	$user=get_table(tname('user'), $id);
     if($_POST['plan_grade']!=$user['plan_grade']){
       //  $_POST['task_day']=$_POST['task_days']=0;
         $tasks=array();
       for($i=0;$i<$_POST['plan_grade'];$i++){
           $tasks[$i]='ok';
       }


         $_POST['tasks']=serialize($tasks);
     }
    $_POST['worker_setting']=serialize( $_POST['worker_setting']);

$db->update(tname('user'), $_POST, $id);

$user=get_user_byid($id);




			add_adminlog('编辑用户：'.$user['realname']);


    ?>
    <script>


        parent.location.href=parent.location.href;


    </script>
    <?php



}

if($action=='pwd'){

	$user=get_table(tname('user'), $_SESSION['adminid']);

	if(md5($_POST['pwd'])==$user['pwd']){
		$array=array('pwd'=>$_POST['pwd1']);
	$db->update(tname('user'), $array, $_SESSION['adminid']);
	promptMessage('pwd.php', '恭喜您！密码修改成功');

	}
	else {

		promptMessage('pwd.php', '旧密码错误');

	}


}

?>