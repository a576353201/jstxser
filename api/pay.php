<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020-4-28
 * Time: 17:39
 */
include_once '../inc/common.php';
if($_POST['userid']) $userid=$_POST['userid'];
else $userid=$_SESSION['userid'];
$res=array('code'=>200);
$act=trim($_GET['act']);
if($act=='recharge'){
$user=userinfo($userid);
$data=array();
$money=$_REQUEST['money'];
$type=$_REQUEST['type'];
    $order_num=time().rand(1000,9999);
    $data['Merchants'] = "zz66622";
    $data['Type'] = $type;
    $data['Member'] = $user['name'];
    $data['Amount'] =$money;
    $data['OrderNum'] = $order_num;
    $data['CallbackUrl'] = "http://{$_SERVER['HTTP_HOST']}/api/pay.php?act=notify";
    $data['Time'] = time(); /* 十位数的时间戳 */
//
    ksort($data);//排序
    /* 排序为下面的数据进行签名 */
    $temp = '';
    foreach ($data as $x=>$x_value){
        $temp .= $x."=".$x_value."&";
    }
    $key ="48b52215983e46420e88ee08ad268d1559a5";
    $data['Sign'] = strtoupper(md5($temp.'key='.$key));
    $data['Remark'] = $user['name']."充值{$_REQUEST['money']}元";
    $data['UserName'] = $user['name'];
    $url = "http://xapi.hcclc.cn/pay/getWeiPay";
 //   $data['BankCode']='CCB';
    $ch=curl_init($url);

    $ssl=substr($url,0,8)=="https://"?true:false;
    if($data!=''){
        curl_setopt($ch,CURLOPT_POST,1);
        curl_setopt($ch,CURLOPT_POSTFIELDS,$data);
    }
    if($ssl){
        curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,2);
        curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);
    }
    curl_setopt($ch,CURLOPT_USERAGENT,"Mozilla/5.0 (Windows NT 6.2; WOW64; rv:28.0) Gecko/20100101 Firefox/28.0");
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
    curl_setopt($ch,CURLOPT_TIMEOUT,150);
    if($cookie!=''){
        curl_setopt($ch,CURLOPT_COOKIE,$cookie);
    }
    if($header!=''){
//            $header = "Content-type: ".$header;
        curl_setopt($ch,CURLOPT_HTTPHEADER,$header);
    }
    if($referer!=''){
        curl_setopt($ch,CURLOPT_REFERER,$referer);
    }
    if($redirect!=''){
        curl_setopt($ch,CURLOPT_FOLLOWLOCATION,1);
        $text=curl_exec($ch);
        $headers=curl_getinfo($ch);
        return $headers['url']?$headers['url']:'e';
    }
    $text=curl_exec($ch);    // 获取到访问内容

    curl_close($ch);
    $return=json_decode($text,true);
    if($return['code']==0){
        $res['code']=200;
        $res['data']=$return['content']['pay_url'];
        $setting=unserialize($system['recharge_setting']);
        $fee=$setting[$type]['fee'];
        $fee=$money*$fee/100;
        $sql="insert into ".tname('recharge')." (uid,money,status,addtime,code,bank,fee) values('{$userid}','{$money}','-1','{$now}','{$order_num}','{$recharge_arr[$type]}','{$fee}')";
        $db->query($sql);
    }else{
       $res['code']=0;
       $res['message']=$return['msg'];
    }
    die(json_encode($res));
}

if ($act=='recharge1'){
    $bank=json_decode($_POST['bank'],true);
   $money=$_POST['money'];
    $fee=$bank['fee'];
    $fee=$money*$fee/100;

        $bankname=$bank_arr1[$bank['bank']];

//    $res['code']=0;
//
//    $res['message']=json_encode($bank);
//    die(json_encode($res));
    $sql="insert into ".tname('recharge')." (uid,money,status,addtime,code,bank,fee) values('{$userid}','{$money}','-1','{$now}','','{$bankname}','{$fee}')";
    $db->query($sql);
    if($db->affected_rows()>0){
        $res['code']=200;

    }
    else {
        $res['code']=0;
        $res['message']='充值系统故障,请稍后再试';
    }
    die(json_encode($res));
}

if($act=='notify'){

    $data['Merchants'] = "zz66622";
    $data['Type'] = $_REQUEST['Type'];
    $data['Member'] = $_REQUEST['Member'];
    $data['Amount'] =$_REQUEST['Amount'];
    $data['OrderNum'] = $_REQUEST['OrderNum'];;
    $data['Status'] = $_REQUEST['Status']; /* 十位数的时间戳 */
//
    ksort($data);//排序
    /* 排序为下面的数据进行签名 */
    $temp = '';
    foreach ($data as $x=>$x_value){
        $temp .= $x."=".$x_value."&";
    }
    $key ="48b52215983e46420e88ee08ad268d1559a5";
    $data['Sign'] = strtoupper(md5($temp.'key='.$key));
  if($data['Sign']==$_REQUEST['Sign']){
     if($_REQUEST['Status']=='SUCCESS'){
        $row=  $db->exec("select * from ".tname('recharge')." where code='{$data['OrderNum']}'");
         if($row['id']>0){
             agree_recharge($row['id']);
         }
         die('SUCCESS');
     }
     else{
         die('Fail');
     }

  }else{
      die('sign error');
  }

}
if($act=='admin_charge'){

   $user=$db->exec("select * from ".tname('user')." where name='{$_POST['name']}'");
   if($user['id']>0){
       $money=$_POST['money'];
       $content="管理员为您充值<span style=\"color:#2319dc\">{$money}</span>元";
        if($_POST['mark']){
            $mark=$_POST['mark'];
            $content.="<br><span style=\"color: #666\"> 附言：</span>".$mark;
        }
        else {
            $mark="管理员手动充值";
        }
       add_money($user['id'],$money,$mark,'recharge');
       add_note(0,$user['id'],$content);
        $res['code']=200;
        $res['data']="充值成功";
   }else{
       $res['code']=0;
       $res['message']="您输入的用户账号不存在";
   }
    die(json_encode($res));
}
if($act=='plat'){



    $row=$db->exec("select count(*) as num from ".tname('plat')." where uid='{$userid}'");
    if($row['num']>=$system['plat_times']){
        $res['code']=0;
        $res['message']="每天最多可以申请提现{$system['plat_times']}次";

    }
    else{



        $user=userinfo($userid);
        if($user['islock']==1){

            $res['code']=0;
            $res['message']="您的账户存在安全隐患,被限制提现";

        }else{
            if($user['status']!=0){
                $res['code']=0;
                $res['message']="您的账户被冻结，禁止申请提现";

            }else{

                if(md5($_POST['pwd'])!=$user['pwd1']){
                    $res['code']=0;
                    $res['message']="资金密码不正确";
                }
                else{
                    if($_POST['money']>$user['money']){
                        $res['code']=0;
                        $res['message']="提现金额不能大于账户余额";

                    }else{

                        $bank=$db->exec("select * from ".tname('bank')." where id='{$_POST['bankid']}'");

                        $now=time();
                        $money=$_POST['money'];
                        $fee=$money*$system['plat_fee']/100;
                        $sql="insert into ".tname('plat')." (uid,money,fee,status,time,bank) values('{$userid}','{$money}','{$fee}','0','{$now}','".serialize($bank)."')";
                        $db->query($sql);
                        if($db->affected_rows()>0){
                            $id=$db->insert_id();
                            add_money($userid, -$money, "申请提现",'plat',$id);
                            $res['code']=200;
                            $res['message']="操作成功";
                        }
                        else{
                            $res['code']=0;
                            $res['message']="网络连接失败，请稍后再试";
                        }
                    }

                }

            }
        }




    }

    die(json_encode($res));

}

if($act=='paymoney'){
    $user=userinfo($userid);

    if($user['status']!=0){
        $res['code']=0;
        $res['message']="您的账户被冻结";
        die(json_encode($res));
    }
    if(md5($_POST['pwd'])!=$user['pwd1']){
        $res['code']=0;
        $res['message']="资金密码不正确";
    }
    else {
        if ($_POST['money'] > $user['money1']) {
            $res['code'] = 1;
            $res['message'] = "可用余额不足";
        }
        else{
            $type=$_POST['type'];
            if($type=='reward'){
              $status=  plan_reward($_POST['id'],$_POST['money'],$userid);
            }
            else if($type=='plat_buy'){

                $status=  plan_buy($_POST['id'],$_POST['money'],$userid);
            }
            else if($type=='redpacket'){
                if ($_POST['money'] > $user['money1']) {
                    $res['code'] = 1;
                    $res['message'] = "可用余额不足";
                    die(json_encode($res));
                }
                $status=send_redpacket(json_decode($_POST['payinfo'],true),$userid);
            }
            else if($type=='vip'){
                if ($_POST['money'] > $user['money1']) {
                    $res['code'] = 1;
                    $res['message'] = "可用余额不足";
                    die(json_encode($res));
                }
                $status=vip_buy(json_decode($_POST['payinfo'],true),$userid);
            }
            if($status==true or $status>0){
                $res['code']=200;
                $res['message']="支付成功";
                $res['data']=$status;
            }
            else{
                $res['code']=0;

                $res['message']="网络连接失败，请稍后再试";
            }

        }
    }

    die(json_encode($res));
}


if($act=='iospay'){

    $now=time();
//    $content=json_encode($_POST);
//    $db->query("insert into ".tname('iospaylog')."(userid,time,content) values('{$userid}','{$now}','{$content}')");
    if($_POST['type']=='recharge'){
        $fee=$system['iospay_fee'];
        $money=$_POST['money'];
        $fee=$money*$fee/100;
        $sql="insert into ".tname('recharge')." (uid,money,status,addtime,code,bank,fee) values('{$userid}','{$money}','1','{$now}','{$order_num}','苹果内购','{$fee}')";
        $db->query($sql);
        $money1=$money-$fee;
        $mark="ios内购充值{$money}元，实际到账{$money1}元";
        add_money($userid,$money1,$mark,'recharge');
        $res['message']="充值成功";
    }
    else if($_POST['type']=='vip') {
      $money_select=$_POST['money_select'];
      if($money_select<2) $type=1;
      else $type=2;
      if($money_select%2==0) $time=1;else $time=12;
        $user=userinfo($userid);
        if($user['vip']>0 and $user['vip_time']>time()){
            $vip_time=$user['vip_time']+$time*30*24*3600;
        }
        else {
            $vip_time=time()+$time*30*24*3600;
        }
        if($type==2){
            $vip=3;
            $content="购买团队VIP,ios内购支付";
            $db->query("update ".tname('user')." set vip_time='{$vip_time}' where pid='{$userid}' and vip='2'");
        }else{
            $vip=1;
            $content="购买个人VIP,ios内购支付";
        }
        $db->query("update ".tname('user')." set vip='{$vip}',vip_time='{$vip_time}' where id='{$userid}'");
        add_money($userid, 0, $content, 'buy');
        $res['message']="VIP购买成功";
    }
    $res['code']=200;

    die(json_encode($res));

}


die(json_encode($res));
