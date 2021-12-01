
<?php
error_reporting(E_ALL & ~ E_NOTICE);
session_start();

include_once '../inc/header.php';
global $mysqlhost, $mysqluser, $mysqlpwd, $mysqldb;
include_once '../../inc/config.php';

$mysqlhost=$dbhost; //host name
$mysqluser=$dbuser;                //login name
$mysqlpwd=$dbpwd;                //password
$mysqldb=$dbname;          //name of database        //name of database

include("mydb.php");
$d=new db($mysqlhost,$mysqluser,$mysqlpwd,$mysqldb);

/******界面*/if(!$_GET['act']&&!$_SESSION['data_file']){/**********************/

?>
<form action="" method="post" enctype="multipart/form-data" name="restore.php">
<input type="radio" name="restorefrom" value="server" checked style='display:none;'>
<table width="91%" border="0" cellpadding="0" cellspacing="1"  style='line-height:30px;' class='table_add'>
<tr align="center" class="header">

<td  align="left">文件名</td>
<td  align="center">备份时间</td>
<td  align="center">操作</td>
</tr>
<?php
$handle=opendir('./backup');


while ($file = readdir($handle)) {


	    if(preg_match("/^[0-9]{8,8}([0-9a-z_]+)(\.sql)$/",$file)){
	$str=explode('_', $file);



              //获取文件大小

?>
<tr align="center" class="header">

<td  align="left"> <?php echo $file?></td>
<td  align="center"><?php echo date('Y-m-d H:i:s',strtotime($str[0]));?></td>

<td  align="center">

<a href="down.php?file=<?php echo urlencode('backup/'.$file);?>" >下载</a>
<a href="restore.php?restorefrom=server&serverfile=<?php echo $file;?>" onClick="return(confirm('确定要还原吗? '))">还原</a>
<a href="restore.php?type=delete&file=<?php echo $file;?>" onClick="return(confirm('确定要删除吗? '))">删除</a>
</td>
</tr>

<?php
	    }
	    }
closedir($handle);
?>


<?php

if($_GET['type']=='delete'){


	if($_GET['file']){

		@unlink("backup/".$_GET['file']);

		echo "<script>alert('删除成功');</script>";

echo "<script>window.location='".$_SERVER['HTTP_REFERER']."';</script>";
		exit();

	}




}



/**************************界面结束*/}/*************************************/



/***************服务器恢复*/if($_GET['restorefrom']=="server"){/**************/
if(!$_GET['serverfile'])
{$msgs[]="您选择从服务器文件恢复备份，但没有指定备份文件";
    show_msg($msgs); pageend();
}
if(!preg_match("/_v[0-9]+/",$_GET['serverfile']))
{$filename="./backup/".$_GET['serverfile'];
if(import($filename)) $msgs[]="备份文件".$_GET['serverfile']."成功导入数据库";
else $msgs[]="备份文件".$_GET['serverfile']."导入失败";
show_msg($msgs); pageend();
}
else
{
$filename="./backup/".$_GET['serverfile'];
if(import($filename)) $msgs[]="备份文件".$_GET['serverfile']."成功导入数据库";
else {$msgs[]="备份文件".$_GET['serverfile']."导入失败";show_msg($msgs);pageend();}
$voltmp=explode("_v",$_GET['serverfile']);
$volname=$voltmp[0];
$volnum=explode(".sq",$voltmp[1]);
$volnum=intval($volnum[0])+1;
$tmpfile=$volname."_v".$volnum.".sql";
if(file_exists("./backup/".$tmpfile))
    {
    $msgs[]="程序将在3秒钟后自动开始导入此分卷备份的下一部份：文件".$tmpfile."，请勿手动中止程序的运行，以免数据库结构受损";
    $_SESSION['data_file']=$tmpfile;
    show_msg($msgs);

    echo "<script language='javascript'>";
    echo "location='restore.php';";
    echo "</script>";
    }
else
    {
    $msgs[]="此分卷备份全部导入成功";
    show_msg($msgs);
        echo "<script language='javascript'>";
    echo "location='restore.php';";
    echo "</script>";
    }
}

}/********************************************/

function import($fname)
{global $d;
$sqls=file($fname);
foreach($sqls as $sql)
{
str_replace("\r","",$sql);
str_replace("\n","",$sql);
if(!$d->query(trim($sql))) return false;
}
return true;
}
function show_msg($msgs)
{
$title="提示：";
echo "<table width='100%' border='1'    cellpadding='0' cellspacing='1'>";
echo "<tr><td>".$title."</td></tr>";
echo "<tr><td><br><ul>";
while (list($k,$v)=each($msgs))
{
echo "<li>".$v."</li>";
}
echo "</ul></td></tr></table>";
}

function pageend()
{
exit();
}
?>
