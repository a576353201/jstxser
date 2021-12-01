<?php include_once template("header");?>
 <div class="user_center">


<table cellspacing="0" cellpadding="0" class="tfm">

<h2 class="xs2">当前我的头像</h2>

<tr>
<td   id='avatar_img'  ><img src='<?php if($user['avatar']){?>../<?php echo $user['avatar']; ?><?php } else { ?>../uploads/avatar.jpg<?php }?>' class='avatar'></td>
</tr>

<tr>
<td>
    <input type="hidden" name='image_list' id='image_list' value=''>
<iframe src='../avatar.php'  id='upload_src'  style='width:100%;height:150px;'marginwidth="0px" frameborder="0" scrolling="no" ></iframe>
</td>
</tr>
</table>


</div> 

  


    
         
<?php include_once template("footer");?>