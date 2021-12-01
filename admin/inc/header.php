<?php
include_once 'check_login.php';

if($_GET['menuid']){

$menu=get_menu_byid($_GET['menuid']);

}



?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script src="<?php echo $AdminHttpPath;?>style/js/jquery1.8.1.js" type="text/javascript"></script>
<script src="<?php echo $AdminHttpPath;?>style/js/main.js?v=1" type="text/javascript"></script>
    <script src="<?php echo $HttpPath;?>static/layui/layui.all.js" type="text/javascript"></script>

<link rel="stylesheet" href="../style/css/style.css" type="text/css" />
    <link href="<?php echo $AdminHttpPath;?>style/images/style.css" rel="stylesheet" type="text/css" />
	<script charset="utf-8" src="<?php echo $HttpPath;?>style/kindeditor/kindeditor-all.js"></script>
		<script charset="utf-8" src="<?php echo $HttpPath;?>style/kindeditor/lang/zh_CN.js"></script>
		<script language="javascript" type="text/javascript" src="<?php echo $HttpPath;?>static/js/My97DatePicker/WdatePicker.js"></script>
</head>


<body style="padding: 0px 10px;">


<?php

$arr=explode('/',$_SERVER['PHP_SELF'] );
$url=$arr[count($arr)-2].'/'.$arr[count($arr)-1];
$row=$db->exec("select * from ".tname('role')." where id='{$_SESSION['admingroup']}'");

$role=$row['content'];
if($_GET['from']!='parent') {
    if (strpos($role, $url) !== false) {


        foreach ($admin_menu1 as $key => $value) {
            foreach ($admin_menu2[$key] as $key1 => $value1) {
                if (strpos($value1['url'] , $url)!==false) {

                    $title2 = $value1['title'];
                    $title1 = $value;
                    break;
                }
            }
        }


        ?>

        <div id="secondary_bar">
            <div class="breadcrumbs_container">
                <article class="breadcrumbs"><a>当前位置：<strong>后台</strong></a>
                    <div class="breadcrumb_divider"></div>
                    <span id="position"><a><?php echo $title1; ?></a>

                                <div class="breadcrumb_divider"></div><a
                                class="current"><?php echo $title2; ?></a></span></article>
            </div>

            <input type="button" style="float: right;margin-right: 10px;" class="btn" value="刷新"
                   onclick='location.href=location.href;'/>
        </div>

        <div style="height: 50px;width: 100%;display: block">&nbsp;</div>

        <?php
    } else {
        echo "<script>alert('您无权限访问该页面');window.history.go(-1);;</script>";

        exit();
    }
}
?>