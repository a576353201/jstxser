<?php include_once template("header");?>
<link rel="stylesheet" href="<?php echo $HttpTemplatePath; ?>static/css/user.css?v=<?php echo $cachekey; ?>" type="text/css" media="screen" />
<script language="javascript" type="text/javascript" src="/static/js/My97DatePicker/WdatePicker.js"></script>
<link href="/static/js/My97DatePicker/skin/WdatePicker.css" rel="stylesheet" type="text/css">
<div class="header" style="padding: 5px 0px;">
    <span class="back" onclick="history.back();" style="top:5px;"><i class="icon-left-open-3"></i></span>
    <div id="head_nav" class="nav" style="width: 60%;left: 20%;top:5px;">
        <div class="item "  onclick="location.href='recharge.php';">充值</div>
        <div class="item" style="border-left: 1px solid #2319dc;width: 33%"  onclick="location.href='plat.php';" >提现</div>
        <div class="item active" style="border-left: 1px solid #2319dc;" >账单</div>
    </div>

</div>

 <form action="money.php" method="post" target="_self" onchange="document.querySelector('#sub').click();" style="background-color:#fff;line-height:40px;padding-left:10px;padding-top:5px;margin-top: 40px;">
<select name="type" style="height: 30px;line-height: 30px;border-radius: 5px;border: 1px solid #ddd;">
    <option value="">类型</option>
    <?php if(is_array($recharge_type_arr)){foreach($recharge_type_arr AS $index=>$value) { ?>

    <option value="<?php echo $index; ?>" <?php if($index==$_POST['type']){?>selected<?php }?>><?php echo $value; ?></option>
    <?php }}?>
</select>

<input type="text" name="begintime" id="begintime" value="<?php echo $begintime; ?>" class="Wdate" autocomplete="off" style="width:90px;border-radius: 5px;padding-left: 5px;" onclick="WdatePicker({dateFmt:'yyyy-MM-dd',alwaysUseStartDate:false})">
至
	 <input type="text" name="endtime" id="endtime" value="<?php echo $endtime; ?>" class="Wdate"  autocomplete="off" style="width:90px;border-radius: 5px;padding-left: 5px;" onclick="WdatePicker({dateFmt:'yyyy-MM-dd',alwaysUseStartDate:false})">
                                                                  <input type="submit" id="sub" class="button" onclick="" style="height: 30px;line-height: 30px;padding: 0px 5px;" value=" 查询 ">

                        </form>
<?php if(count($list)>0){?>

<ul class="user_list">


    <?php if(is_array($list)){foreach($list AS $index=>$value) { ?>
    <li>

        <div   >

            <span  style="color: #666; ">类型：</span><?php echo $recharge_type_arr[$value['type']]; ?>
            <span style="float: right;font-weight: 600" >
                     <?php if($value['money']>0){?>
            <span style="color:#F73E54">+<?php echo $value['money']; ?>元</span>
                <?php } else { ?>
            <span style="color:green"><?php echo $value['money']; ?>元</span>

                <?php }?>

            </span>


        </div>
        <div style="color: #666; ">
          时间：<?php echo date('Y-m-d H:i:s',$value['time']); ?>

        </div>

        <div  style="color: #666; white-space: nowrap; text-overflow: ellipsis; overflow: hidden; word-break: break-all;">
            说明：<?php echo $value['content']; ?>
        </div>

    </li>

    <?php }}?>
</ul>

<div class="page">
    <?php echo $page_html; ?>

</div>
<?php } else { ?>

<div class="nodata" style="color: #666;text-align: center;line-height: 40px;">
  找不到账单

</div>

<?php }?>


<div style="height: 60px;"></div>



<script>

    window.onload=function () {

        var index = parent.layer.getFrameIndex(window.name);
        parent.layer.iframeAuto(index);
    }
</script>
<?php include_once template("footer");?>