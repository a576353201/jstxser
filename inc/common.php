<?php
session_start();
//error_reporting(E_ALL);
error_reporting(E_ERROR);
date_default_timezone_set('PRC');
header("Access-Control-Allow-Origin: *");

$now = time();
$ServerRoot = substr(dirname(__FILE__), 0, -4).'/';
if($_GET['client']) $_SESSION['client']=$_GET['client'];


function isMobile()
{
    global $_SESSION,$_GET;

	if($_SESSION['client']=='mobile') return true;
    // 如果有HTTP_X_WAP_PROFILE则一定是移动设备
    if (isset ($_SERVER['HTTP_X_WAP_PROFILE']))
        {
        return true;
    }
    // 如果via信息含有wap则一定是移动设备,部分服务商会屏蔽该信息
    if (isset ($_SERVER['HTTP_VIA']))
    {
        // 找不到为flase,否则为true
        return stristr($_SERVER['HTTP_VIA'], "wap") ? true : false;
    }
    // 脑残法，判断手机发送的客户端标志,兼容性有待提高
    if (isset ($_SERVER['HTTP_USER_AGENT']))
    {
        $clientkeywords = array ('nokia',
            'sony',
            'ericsson',
            'mot',
            'samsung',
            'htc',
            'sgh',
            'lg',
            'sharp',
            'sie-',
            'philips',
            'panasonic',
            'alcatel',
            'lenovo',
            'iphone',
            'ipod',
            'blackberry',
            'meizu',
            'android',
            'netfront',
            'symbian',
            'ucweb',
            'windowsce',
            'palm',
            'operamini',
            'operamobi',
            'openwave',
            'nexusone',
            'cldc',
            'midp',
            'wap',
            'mobile',
         'iphone',
         'ipad'
            );
        // 从HTTP_USER_AGENT中查找手机浏览器的关键字
        if (preg_match("/(" . implode('|', $clientkeywords) . ")/i", strtolower($_SERVER['HTTP_USER_AGENT'])))
        {
            return true;
        }
    }
    // 协议法，因为有可能不准确，放到最后判断
    if (isset ($_SERVER['HTTP_ACCEPT']))
    {
        // 如果只支持wml并且不支持html那一定是移动设备
        // 如果支持wml和html但是wml在html之前则是移动设备
        if ((strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') !== false) && (strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === false || (strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') < strpos($_SERVER['HTTP_ACCEPT'], 'text/html'))))
        {
            return true;
        }
    }
    return false;
}



define('ABSOLUTE_PATH', $ServerRoot);

define('TEMPLATE_PATH', $ServerRoot.'template');
define('COMPILED_PATH', $ServerRoot.'inc/compiled/');
$HostName = $_SERVER['HTTP_HOST'];
$rootLen = strlen($_SERVER['DOCUMENT_ROOT']);
function is_https() {
    if ( !empty($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) !== 'off') {
        return true;
    } elseif ( isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https' ) {
        return true;
    } elseif ( !empty($_SERVER['HTTP_FRONT_END_HTTPS']) && strtolower($_SERVER['HTTP_FRONT_END_HTTPS']) !== 'off') {
        return true;
    }
    return false;
}

if(substr($_SERVER['DOCUMENT_ROOT'], $rootLen-1, 1) == '/')$rootLen = $rootLen-1;
$ServerRelativPath = substr($ServerRoot, $rootLen, strlen($ServerRoot)-$rootLen);
if(is_https()) $http='https';
else $http='http';
$HttpPath = str_replace('\\', '/', $http."://{$HostName}{$ServerRelativPath}");
$AbsolutePath = str_replace('\\', '/', ABSOLUTE_PATH);
include_once 'array.php';
include_once 'mysql.php';
include_once 'function.php';
include_once 'page.php';


if(!$_COOKIE['auth']){
    setcookie("auth", 'auth_'.time().rand(1000,9999),time()+3600*24*365, "/");
}


if($_COOKIE['userid']>0 and !$_SESSION['userid']){

       login($_COOKIE['userid'],1);
}

if($_SESSION['userid']>0){

        $userid=$_SESSION['userid'];

}
else {$userid=0;}


function is_weixin() {
    if (strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false) {
        return true;
    } return false;
}
$system=get_system();
if(isMobile() ){

 $TemplateName='mobile';
}
else
 $TemplateName='default';
$HttpTemplatePath=$HttpPath."template/".$TemplateName."/";


$web_title=$system['web_title'];
if($system['seo_title']) $web_title=$web_title."-".$system['seo_title'];
$web_keywords=$system['web_keywords'];
$web_description=$system['web_description'];



if(count($_POST)>0){
	foreach($_POST as $key=>$value){
		if(is_array($value) and count($value)>0){
		foreach($value as $key1=>$value1){
				if(is_array($value1) and count($value1)>0){
				}
				else
			$_POST[$key][$key1]=stripslashes($value1);
		}


		}
		else{


			$_POST[$key]=stripslashes($value);

		}

	}

}


$islock=0;
$locktime=0;
if($_SESSION['userid']   && !$_SESSION['adminid']){
    $now=time();
    $db->query("update " . tname('user') . " set `online`='{$now}' where id='{$_SESSION['userid']}'");
    $user=userinfo($_SESSION['userid']);

    if($user['id']>0 && $user['status']!=1){

        if($user['status']==2){
            if($user['lock_time']>time()){
              $islock=1;
              $locktime=$user['lock_time'];
            }else{
                $db->query("update ".tname('user')." set `status`='0' ,lock_time='0' where id='{$_SESSION['userid']}'");
            }

        }

    }else{
        echo "<script>window.location='/user/quit.php';</script>";
        exit();
    }

}


$task=unserialize($system['plan_task']);
if($_SESSION['userid']>0){
    $sql="select count(*) as num from ".tname('plan')." where  userid='{$_SESSION['userid']}'";
    $row=$db->exec($sql);
    $lastaddnum=$task[$user['plan_grade']]['addnum']-$row['num'];
    $task_delete=$task[$user['plan_grade']]['isdelete'];
}

$cachekey=2020052721;
?>

