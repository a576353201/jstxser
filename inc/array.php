<?php

$status_array=array('0'=>'正常','1'=>'永久封号','2'=>'限制封号');

$input_array=array('text'=>'单行输入框','textarea'=>'多行输入','select'=>'下拉菜单','radio'=>'单选按钮','checkbox'=>'多选按钮','timer'=>'时间输入框');
$recharge_status=array('-1'=>'未确认','0'=>"待审核",'1'=>'充值成功','2'=>'充值失败');
$plat_status=array('0'=>"审核中",'1'=>'提现成功','2'=>'提现失败');
$update_status=array('0'=>"通过",'1'=>'待审核','2'=>'不通过');
$plan_status=array('0'=>"未进行",'1'=>'进行中','2'=>'已完结');
$plan_method=array('0'=>"追号模式",'1'=>'智能模式','2'=>'普通模式','3'=>'自定义模式');
$apply_status=array('0'=>"审核中",'1'=>'审核通过','2'=>'未通过');
//$recharge_arr=array('201'=>'支付宝','301'=>'网银支付');

$recharge_arr=array('alipay'=>'支付宝','weixin'=>'微信支付','bank'=>'银行卡转账');
$plan_grade_arr=array('0'=>'新手','1'=>'初级','2'=>'高级','3'=>'大神');
$sex_arr=array('1'=>'男','2'=>'女');
$num_arr=array('一','二','三','四','五','六','七','八','九','十','十一','十二','十三','十四','十五','十六','十七','十八','十九','二十');

$week_arr=array('日','一','二','三','四','五','六');
$recharge_type_arr=array('recharge'=>"充值",'plat'=>'提现','yongjin'=>'佣金','reward'=>'打赏','sign'=>'签到','task'=>'任务','redpacket'=>'红包','buy'=>'消费');

$bank_arr=array(
    'CBC'=>'工商银行',
    'ABC'=>'农业银行',
    'CITIC'=>'中信银行',
    'CCB'=>'建设银行',
    'BOC'=>'中国银行',
    'PSBC'=>'邮储银行',
    'BOCOM'=>'交通银行',
    'CEB'=>'光大银行',
    'HXB'=>'华夏银行',
    'CMBC'=>'民生银行',
    'GDB'=>'广发银行',
    'PAB'=>'平安银行',
    'CMD'=>'招商银行',
    'BOB'=>'北京银行',
    'SPDB'=>'浦发银行',
    'BOS'=>'上海银行',
    'CIB'=>'兴业银行',
    'NJC'=>'南京银行',
    'HZBANK'=>'杭州银行',
    'BEA'=>'东亚银行',
    'NBCB'=>'宁波银行',
    'BRCB'=>'北京农商行',
    'SRCB'=>'上海农商银行',
    'SDB'=>'深圳发展银行');

$bank_arr1=array_merge(array('alipay'=>'支付宝','weixin'=>'微信支付'),$bank_arr);

$admin_menu1=array('system'=>'系统设置','user'=>'用户管理','money'=>'资金管理','group'=>'群组管理','admin'=>'权限');

//$admin_menu2['system'][]=array('title'=>'系统预览','url'=>'system/welcome.php','nav'=>'1');
$admin_menu2['system'][]=array('title'=>'系统设置','url'=>'system/index.php','nav'=>'1');
$admin_menu2['system'][]=array('title'=>'群组聊天参数','url'=>'system/im.php','nav'=>'1');
$admin_menu2['system'][]=array('title'=>'APP参数设置','url'=>'system/app.php','nav'=>'1');
$admin_menu2['system'][]=array('title'=>'VIP参数设置','url'=>'system/vip.php','nav'=>'1');
$admin_menu2['system'][]=array('title'=>'充值提现设置','url'=>'system/recharge.php','nav'=>'1');
$admin_menu2['system'][]=array('title'=>'汇款账户设置','url'=>'system/charge.php','nav'=>'1');
//$admin_menu2['system'][]=array('title'=>'计划参数设置','url'=>'system/planer.php','nav'=>'1');
//$admin_menu2['system'][]=array('title'=>'首页banner','url'=>'system/flash.php?type=index','nav'=>'1');
//$admin_menu2['system'][]=array('title'=>'计划banner','url'=>'system/flash.php','nav'=>'1');
//$admin_menu2['system'][]=array('title'=>'AAP管理','url'=>'app/index.php','nav'=>'1');
//$admin_menu2['system'][]=array('title'=>'新增APP','url'=>'app/add.php','nav'=>'0');
$admin_menu2['user'][]=array('title'=>'用户管理','url'=>'user/index.php','nav'=>'1');
$admin_menu2['user'][]=array('title'=>'用户私信','url'=>'user/message.php?action=user','nav'=>'1');
$admin_menu2['user'][]=array('title'=>'聊天记录','url'=>'user/msg.php?action=user','nav'=>'1');
$admin_menu2['user'][]=array('title'=>'投诉管理','url'=>'user/report.php','nav'=>'1');
$admin_menu2['user'][]=array('title'=>'银行卡管理','url'=>'user/bank.php','nav'=>'1');
$admin_menu2['user'][]=array('title'=>'用户日志','url'=>'user/userlog.php','nav'=>'1');
$admin_menu2['user'][]=array('title'=>'朋友圈管理','url'=>'user/circle.php','nav'=>'1');
$admin_menu2['money'][]=array('title'=>'账单流水','url'=>'money/index.php','nav'=>'1');
$admin_menu2['money'][]=array('title'=>'充值记录','url'=>'money/recharge.php','nav'=>'1');
$admin_menu2['money'][]=array('title'=>'提现记录','url'=>'money/plat.php','nav'=>'1');
$admin_menu2['group'][]=array('title'=>'群组管理','url'=>'user/group.php','nav'=>'1');
$admin_menu2['group'][]=array('title'=>'聊天记录','url'=>'user/msg.php?action=group','nav'=>'1');
$admin_menu2['system'][]=array('title'=>'发现页面链接','url'=>'system/flink.php','nav'=>'1');
$admin_menu2['system'][]=array('title'=>'发现页面链接','url'=>'system/flink_add.php','nav'=>'0');
$admin_menu2['system'][]=array('title'=>'文章管理','url'=>'news/manage.php','nav'=>'1');
$admin_menu2['system'][]=array('title'=>'发布新闻','url'=>'news/add.php','nav'=>'0');

//$admin_menu2['game'][]=array('title'=>'开奖接口','url'=>'game/game_api.php','nav'=>'1');
//$admin_menu2['game'][]=array('title'=>'新增开奖接口','url'=>'game/game_apiadd.php','nav'=>'0');
//$admin_menu2['game'][]=array('title'=>'玩法规则','url'=>'game/wanfa.php','nav'=>'0');



//$admin_menu2['news'][]=array('title'=>'新闻分类','url'=>'system/menu.php','nav'=>'1');
//$admin_menu2['news'][]=array('title'=>'添加新闻分类','url'=>'system/menu_add.php','nav'=>'0');


$admin_menu2['admin'][]=array('title'=>'角色管理','url'=>'admin/role.php','nav'=>'1');
$admin_menu2['admin'][]=array('title'=>'新建角色','url'=>'admin/role_add.php','nav'=>'0');
$admin_menu2['admin'][]=array('title'=>'管理员管理','url'=>'admin/index.php','nav'=>'1');
$admin_menu2['admin'][]=array('title'=>'添加管理员','url'=>'admin/add.php','nav'=>'0');
$admin_menu2['admin'][]=array('title'=>'管理员日志','url'=>'admin/adminlog.php','nav'=>'1');
$admin_menu2['admin'][]=array('title'=>'修改密码','url'=>'admin/pwd.php','nav'=>'1');
//$admin_menu2['admin'][]=array('title'=>'修改手机','url'=>'admin/mobile.php','nav'=>'1');
?>