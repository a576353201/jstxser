<?php include_once template("header");?>


   <div class="user_info"  style='text-align:center;'>
   我的二维码<br>

   <img src='<?php echo $qrcode; ?>'  width='80%'/><br>



   我的邀请地址<br>
   <a href='<?php echo $url; ?>' target='_blank'><?php echo $url; ?></a>

   </div>
<?php include_once template("footer");?>

