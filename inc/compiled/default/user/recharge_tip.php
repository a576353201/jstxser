<?php include_once template("header");?>
      <div class='user_mian'>

           <ul >


              <li>开户人姓名：
          <?php echo $bank['realname']; ?>

           </li>

              <li>汇款账号：
          <?php echo $bank['number']; ?>

           </li>

              <li>汇款编号：
          <?php echo $code; ?>

           </li>

           <?php if($bank['qrcode']){?>
                     <li  style='text-align:center;'>识别下面的二维码进行付款<br>
      <img src="<?php echo $HttpPath; ?><?php echo $bank['qrcode']; ?>" style='width:80%;margin:0 auto;' >

           </li>

           <?php }?>


        </ul>



<input type='button' class='btn100' value='我已完成付款，填写付款凭据'   onclick="location.href='recharge_info.php?id=<?php echo $id; ?>'">


        </div>


<?php include_once template("footer");?>