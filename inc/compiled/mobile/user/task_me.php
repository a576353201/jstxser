<?php include_once template("header");?>


 <div class="user_center">



<?php if(count($list)>0){?>






 	<?php if(is_array($list)){foreach($list AS $index=>$value) { ?>




  <div class="wap_list">
<div class='item'>
<a href='../task/info.php?id=<?php echo $value['id']; ?>' target='_blank'><?php echo $value['title']; ?></a>
</div>


                                                <div>

 <span style="color:#d5d5d5;">报名数量</span>
  <a style="color:#222;" href='task_edit.php?type=playerlist&id=<?php echo $value['id']; ?>'><?php echo $value['player_num']; ?></a>

    <span style="float:right;"> <span style="color:#d5d5d5;">赛事状态</span><?php echo task_status($value['id']); ?></span>
                                                </div>

               <div>
                                  <span style="color:#d5d5d5;"> 举办时间：</span>

           <?php echo date('Y-m-d',$value['begindate']); ?>至 <?php echo date('Y-m-d',$value['enddate']); ?>





                                                </div>
<div  style='text-align:center;' >


     <a href='task_edit.php?type=file&id=<?php echo $value['id']; ?>'> 上传附件
       |
       <a href='task_edit.php?type=image&id=<?php echo $value['id']; ?>'>  上传图片</a> |
  <a  href='task_edit.php?type=playerlist&id=<?php echo $value['id']; ?>'>查看报名成员</a>
         |  <a href='task_edit.php?type=playeradd&id=<?php echo $value['id']; ?>'>添加报名成员</a>

</div>

</div>







           <?php }}?>



                    <div class="page" ><?php echo $page_html; ?></div>




<?php } else { ?>
<div  style='height:40px;line-height:40px;text-align:center;'>没有找到相关比赛</div>

<?php }?>







</div>











<?php include_once template("footer");?>