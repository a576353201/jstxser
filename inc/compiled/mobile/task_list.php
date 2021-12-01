<div class="search-list list-view" id="J_SearchList">

<ul>
 	<?php if(is_array($list)){foreach($list AS $index=>$value) { ?>
<div class='page-container'  onclick="location.href='<?php echo $HttpPath; ?>task/info.php?id=<?php echo $value['id']; ?>';">

<li>
<div class="list-item">
<div class="p">

<img class="p-pic" src="<?php echo task_ico($value['id']); ?>" style="visibility: visible;">

</div>
<div class="d">

<div class="d-title"><?php echo $value['title']; ?></div>


<div ><?php echo $value['province']; ?>  <?php echo $value['city']; ?>  <?php echo $value['country']; ?>
</div>
<div class="d-main">
<?php echo date('Y-m-d',$value['begindate']); ?>至 <?php echo date('Y-m-d',$value['enddate']); ?>
</div></div></div>

</li>
</div>
           <?php }}?>

</ul>


</div>