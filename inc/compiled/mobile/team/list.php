   <?php include_once template("header");?>












<div class='player_list'>

<div style='min-height:50px;line-height:50px;padding-top:10px;padding-left:5px;'>

<form action='list.php'  method='get'>
<input type="text" name="name" value="<?php echo $_GET['name']; ?>" style='width:110px;' placeholder="请输入队伍名称" >&nbsp;
<input type="text" name="dw_name" value="<?php echo $_GET['dw_name']; ?>" style='width:110px;' placeholder="请输入单位名称" >
<input type='submit' value='搜索' class='btn01'>
</form>






</div>



<?php if(count($list)>0){?>





 	<?php if(is_array($list)){foreach($list AS $index=>$value) { ?>
<div class='wap_list' onclick="location.href='index.php?id=<?php echo $value['id']; ?>';">
        <div class='item'><?php echo $value['name']; ?></div>


   <div>

 <span style="color:#d5d5d5;">单位:</span> <?php echo $value['user']['realname']; ?>

                                                </div>

   <div>

 <span style="color:#d5d5d5;">申报时间:<?php echo date('Y-m-d H:i:s',$value['addtime']); ?></span> <?php echo $value['clicknum']; ?>


                                                </div>


</div>












           <?php }}?>




                    <div class="page" ><?php echo $page_html; ?></div>




<?php } else { ?>
<div  style='height:40px;line-height:40px;text-align:center;'>没有找到相关队伍</div>

<?php }?>



</div>
<?php include_once template("footer");?>
