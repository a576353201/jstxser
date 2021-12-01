<?php include_once template("header");?>
 <form action="recharge_log.php" method="post" target="_self" style="background-color:#fff;line-height:40px;padding-left:10px;padding-top:5px;">


<input type="text" name="begintime" id="begintime" value="<?php echo $_POST['begintime']; ?>" class="Wdate" style="width:100px;" onclick="WdatePicker({dateFmt:'yyyy-MM-dd',alwaysUseStartDate:false})">
至
	 <input type="text" name="endtime" id="endtime" value="<?php echo $_POST['endtime']; ?>" class="Wdate" style="width:100px;" onclick="WdatePicker({dateFmt:'yyyy-MM-dd',alwaysUseStartDate:false})">
                                                                  <input type="submit" class="button" onclick="" value=" 查询 ">

                        </form>
<?php if(is_array($list)){foreach($list AS $key=>$value) { ?>
    <div class="wap_list">


		                               <div>
                                  <span style="color:#d5d5d5;"> 金额：</span>


                                  <span style="color:#F73E54"><?php echo $value['money']; ?>元</span>




                                    <span style="float:right;"><span style="color:#d5d5d5;padding-left:10px"> 状态：</span><span><?php echo $recharge_status[$value['status']]; ?></span></span>
                                                </div>
                                                <div>

  <span style="color:#d5d5d5;"><?php echo date('Y-m-d H:i:s',$value['addtime']); ?></span>
                                                </div>
                                 <div>
 <span style="color:#d5d5d5;">收款账户：</span><?php echo $value['bank_info']; ?>
                                                </div>
                                                <?php if($value['mark']){?>
                                                                                 <div>
 <span style="color:#d5d5d5;">管理员回复：</span> <span style="color:#F73E54"><?php echo $value['mark']; ?></span>
                                                </div>
                                                <?php }?>

                                                       <?php if($value['status']=='-1'){?>
                                                                                 <div  style='text-align:right;'>
<input type='button' class='btn' value='填写汇款凭据'   onclick="location.href='recharge_info.php?id=<?php echo $value['id']; ?>'">  &nbsp;
<input type='button' class='btn' value='删除'  style='background-color:#3388ff;'  onclick="location.href='recharge_log.php?id=<?php echo $value['id']; ?>&type=delete'">
                                                </div>
                                                <?php }?>
</div>

<?php }}?>
<div class='page'>
  <?php echo $page_html; ?>
</div>

<?php include_once template("footer");?>