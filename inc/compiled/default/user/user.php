<?php include_once template("header");?>

<?php if(count($list)>0){?>
<?php if(is_array($list)){foreach($list AS $key=>$value) { ?>
    <div class="wap_list">


		                               <div>
                                  <span style="color:#d5d5d5;"> 手机号：</span>


                                  <span><?php echo $value['name']; ?></span>

    <?php if($value['realname']){?>


                                    <span style="float:right;"><span style="color:#d5d5d5;padding-left:10px">用户名：</span><span  style="color:#F73E54"><?php echo $value['realname']; ?></span></span>
                                  <?php }?>

                                                </div>




                                                                                 <div>
 <span style="color:#d5d5d5;">注册时间：</span> <span ><?php echo date('Y-m-d H:i:s',$value['regtime']); ?></span>
                                                </div>

</div>

<?php }}?>
<div class='page'>
  <?php echo $page_html; ?>
</div>


<?php } else { ?>
<div class='page'>
您还没有邀请任何人注册
</div>

<?php }?>
<?php include_once template("footer");?>