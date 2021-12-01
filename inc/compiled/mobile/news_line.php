
  	<?php if(is_array($news_list)){foreach($news_list AS $index=>$value) { ?>


<div class='news_list'>

<?php if(count($value['img'])==0){?>

<div  class='line'><a href='<?php echo $HttpPath; ?>news/news.php?id=<?php echo $value['id']; ?>'  class='title'><?php echo $value['title']; ?></a></div>

<div class='info'>
<?php echo date('Y-m-d H:i',$value['addtime']); ?>
<span style='float:right'>
阅 <?php echo $value['clicknum']; ?>
</span>
 </div>






<?php } else if(count($value['img'])==1 ||  count($value['img'])==2 ) { ?>

<div style="height:105px;clear:both;width:100%">
<div class='img1' onclick="location.href='<?php echo $HttpPath; ?>news/news.php?id=<?php echo $value['id']; ?>';">
<img src='<?php echo $value[img][0]; ?>'>
</div>
<div style='float:left;  vertical-align:middle;padding-top:1px;width:66%;padding-left:5px;'>


<div class='line'><a href='<?php echo $HttpPath; ?>news/news.php?id=<?php echo $value['id']; ?>' class='title'><?php echo $value['title']; ?></a></div>

<div class='info'>

<?php echo date('Y-m-d H:i',$value['addtime']); ?>
<span style='float:right'>
阅 <?php echo $value['clicknum']; ?>
</span>
 </div>
</div>

</div>
<?php } else { ?>





<div class='line'><a href='<?php echo $HttpPath; ?>news/news.php?id=<?php echo $value['id']; ?>'  class='title'><?php echo $value['title']; ?></a></div>
<div class='img2' onclick="location.href='<?php echo $HttpPath; ?>news/news.php?id=<?php echo $value['id']; ?>';">
<img src='<?php echo $value[img][0]; ?>'>
<img src='<?php echo $value[img][1]; ?>'>
<img src='<?php echo $value[img][2]; ?>'>

</div>

<div class='info'>

<?php echo date('Y-m-d H:i',$value['addtime']); ?>
<span style='float:right'>
阅 <?php echo $value['clicknum']; ?>
</span>
 </div>



<?php }?>







</div>

 <?php }}?>


