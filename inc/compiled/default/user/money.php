<?php include_once template("header");?>
<link rel="stylesheet" href="<?php echo $HttpTemplatePath; ?>static/css/user.css?v=<?php echo $cachekey; ?>" type="text/css" media="screen" />
<script language="javascript" type="text/javascript" src="/static/js/My97DatePicker/WdatePicker.js"></script>
<link href="/static/js/My97DatePicker/skin/WdatePicker.css" rel="stylesheet" type="text/css">
<ul class="nav1">
    <li class=""  onclick="location.href='recharge.php';">充值</li>
    <li class="" onclick="location.href='plat.php';">提现</li>
    <li class="active" onclick="location.href='money.php';">账单</li>

</ul>
 <form action="money.php" method="post" target="_self" style="background-color:#fff;line-height:40px;padding-left:10px;padding-top:5px;">


<input type="text" name="begintime" id="begintime" value="<?php echo $begintime; ?>" class="Wdate" style="width:100px;border-radius: 5px;padding-left: 5px;" onclick="WdatePicker({dateFmt:'yyyy-MM-dd',alwaysUseStartDate:false})">
至
	 <input type="text" name="endtime" id="endtime" value="<?php echo $endtime; ?>" class="Wdate" style="width:100px;border-radius: 5px;padding-left: 5px;" onclick="WdatePicker({dateFmt:'yyyy-MM-dd',alwaysUseStartDate:false})">
                                                                  <input type="submit" class="button" onclick="" style="height: 30px;line-height: 30px;" value=" 查询 ">

                        </form>
<?php if(count($list)>0){?>

<ul class="user_list" >

    <li>

        <div style="width: 70px;">金额</div>
        <div style="width: 120px;">时间</div>
        <div >说明</div>
    </li>
    <?php if(is_array($list)){foreach($list AS $index=>$value) { ?>
    <li>

        <div  style="width: 70px;" >
            <?php if($value['money']>0){?>
            <span style="color:#F73E54">+<?php echo $value['money']; ?></span>
            <?php } else { ?>
            <span style="color:green"><?php echo $value['money']; ?></span>

            <?php }?>

        </div>
        <div style="color: #666;width: 120px;">
            <?php echo date('Y-m-d H:i',$value['time']); ?>

        </div>

        <div  style="color: #666; white-space: nowrap; text-overflow: ellipsis; overflow: hidden; word-break: break-all;">
            <?php echo $value['content']; ?>
        </div>

    </li>

    <?php }}?>
</ul>

<div class="page">
    <?php echo $page_html; ?>

</div>
<?php } else { ?>

<div class="nodata" style="color: #666;">
  找不到账单

</div>

<?php }?>


<div style="height: 20px;"></div>



<script>

    window.onload=function () {

        var index = parent.layer.getFrameIndex(window.name);
        parent.layer.iframeAuto(index);
    }
</script>
<?php include_once template("footer");?>