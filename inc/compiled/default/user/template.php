<?php include_once template("header");?>


<div class="width ">
  <?php include_once template("user/left");?>  
      <div class="right w763 member_background">
    <div class="mem_title member_new_title">模版管理</div>
<div style='padding:10px;line-height:25px;'>
<strong>当前正在使用的模版</strong><br>
<img src='../<?php echo $default['imgpreurl']; ?>' height='150px' width='150px'/> <br/>

<?php echo $default['title']; ?>   &nbsp; &nbsp;  
 <?php if($myurl){?>
<a href='<?php echo $myurl; ?>' target="_blank">预览网站</a> &nbsp;
<?php }?>

</div>
    <div style='padding:10px;line-height:30px;'>
<strong>其他模版</strong><br>
<?php if(is_array($list)){foreach($list AS $key=>$value) { ?>
<div style='width:190px;text-align:center;height:190px;float:left;'>

<img src='../<?php echo $value['imgpreurl']; ?>' height='150px' width='150px'/> <br/>

<?php echo $value['title']; ?>   &nbsp;

<?php if($value['url']){?>
<a href='<?php echo $value['url']; ?>' target="_blank">预览</a> &nbsp;
<?php }?>

<a href='template.php?action=change&id=<?php echo $value['id']; ?>' onClick="return(confirm('确定使用此模版吗? '))">使用此模版</a>

</div>


<?php }}?>

</div>
     <div class="clear"></div>
     
     <div style='text-align:center;height:30px;'>
     
     <?php echo $page_html; ?>
     </div>
    
  </div>
  <div class="clear"></div>
</div>

<?php include_once template("footer");?>