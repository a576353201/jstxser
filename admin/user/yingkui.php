<?php
include_once '../inc/header.php';

if($_GET['action']=='del'){


    $db->query("delete  from ".tname('recharge')." where id='{$_GET['id']}'");

    promptMessage($_SERVER['HTTP_REFERER'], '删除成功');
    exit();
}
$rowarr=array('recharge'=>"充值",'plat'=>'提现','buy'=>'下注','gameback'=>'撤单','prize'=>'中奖','fee'=>'手续费','rebate'=>'佣金','active'=>'活动','zhuang'=>'上庄');

if(!$_POST['begintime'])  $begintime=date('Y-m-d',time()); else $begintime=$_POST['begintime'];
if(!$_POST['endtime'])  $endtime=date('Y-m-d',time());else $endtime=$_POST['endtime'];



?>

<form name='formSort' enctype="multipart/form-data" action="" method="post"  style='height:50px;line-height:50px;padding-left:10px;'>



    用户ID:<input type="text" name='id' value='<?php echo $_POST['id']?>'>
    起止时间:<input type="text" name="begintime"  value="<?php echo $begintime;?>"  class="Wdate" type="text" onclick="WdatePicker({dateFmt:'yyyy-MM-dd',alwaysUseStartDate:false})"/>
    &nbsp;至

    <input type="text" name="endtime"  value="<?php echo $endtime;?>"  class="Wdate" type="text" onclick="WdatePicker({dateFmt:'yyyy-MM-dd',alwaysUseStartDate:false})" />&nbsp;


    <input type="submit" value='搜索'>

</form>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="table_list">



    <tr>
        <td height="22"><div align="center"><span class="STYLE1">用户ID</span></div></td>

        <td height="22" ><div align="center"><span class="STYLE1">用户名</span></div></td>


<?php
foreach ($rowarr as $key=>$value){
    ?>

    <td height="22" ><div align="center"><span class="STYLE1"><?php echo $value; ?></span></div></td>
        <?php
}
?>

    </tr>


    <?php
$begintime=strtotime($begintime.' 00:00:00');
    $endtime=strtotime($endtime.' 23:59:59');
    if($_POST['id']) $str=" and id='{$_POST['id']}' ";


    $sql="select * from ".tname('user')." where `real`='1' {$str} order by id desc";
    $num=20;
    $page=new Page($sql, $num, $_GET['page']);
    $sql.=" limit $page->from,$num";
    $query=$db->query($sql);
    while ($row=$db->fetch_array($query)){


        ?>
        <tr>

            <td height="30" bgcolor="#FFFFFF" style="padding-left:5px;" align='center'><?php echo $row['id'];?></td>
            <td height="30" bgcolor="#FFFFFF" style="padding-left:5px;" align='center'><?php echo show_username_admin($row);?></td>


            <?php
            foreach ($rowarr as $key=>$value){
                ?>

                <td height="22" ><div align="center"><span class="STYLE1"><?php echo get_yingkui(array($row['id']),$key,$begintime,$endtime); ?></span></div></td>
                <?php
            }
            ?>

        </tr>

    <?php }?>
</table>

<div class="page">


    <?php
    echo $page->get_page();
    ?>
</div>
<?php include_once '../inc/footer.php';?>

