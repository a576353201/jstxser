<?php include_once template("header");?>


 <div class="user_center">



<?php if(count($list)>0){?>
  <div class="search-list list-view" id="J_SearchList">

<ul>
 	<?php if(is_array($list)){foreach($list AS $index=>$value) { ?>
<div class='page-container'  onclick="location.href='<?php echo $HttpPath; ?>task/info.php?id=<?php echo $value['task']['id']; ?>';">

<li>
<div class="list-item">
<div class="p">

<img class="p-pic" src="<?php echo task_ico($value['tid']); ?>" style="visibility: visible;">

</div>
<div class="d">

<div class="d-title"><?php echo $value['task']['title']; ?></div>


<div >

    <div align="left"><a href='../team/index.php?id=<?php echo $value['id']; ?>' ><?php echo $value['name']; ?></a></div>


</div>

<div>

        <?php if($user['group']==4){?>
            <a href='../team/add.php?tid=<?php echo $value['tid']; ?>&id=<?php echo $value['id']; ?>'>编辑</a>

            &nbsp;| &nbsp;

            <a onClick="if(!confirm('确定要取消报名吗? '))return false; "href="task.php?act=delete&id=<?php echo $value['id']; ?>" >取消报名</a>


          <?php } else { ?>

<a href='../team/index.php?id=<?php echo $value['id']; ?>' target='_blank'>查看报名信息</a>

           <?php }?>

</div>
</div></div>

</li>
</div>
           <?php }}?>

</ul>


</div>




                    <div class="page" ><?php echo $page_html; ?></div>




<?php } else { ?>
<div  style='height:40px;line-height:40px;text-align:center;'>没有找到相关比赛</div>

<?php }?>







</div>













<?php include_once template("footer");?>