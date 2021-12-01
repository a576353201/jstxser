<?php include_once template("header");?>
<style>
.category1{}
.category1 .cat1-tit{height:45px;line-height:45px;color:#666;font-size:14px;background-color:#eee;padding:0 10px}
.category1 .cat1-list{background-color:#fff}
.category1 .cat1-item {}
.category1 .cat1-item .cat1-item-1{display:block;height:64px;border-bottom:1px solid #ededed;position:relative;padding:0 10px}
.category1 .cat1-item .cat1-item-1 .font{font-family:iconfont!important;color:#999;position:absolute;top:20px;right:10px;font-size:18px}
.category1 .cat1-item-img{float:left;width:40px;height:40px;border-radius:50%;background-color:#eee;margin-top:17px}
.category1 .cat1-item-tit{margin-left:50px;padding-top:20px;font-size:15px;color:#333;width:76%;overflow:hidden;text-overflow:ellipsis;white-space:nowrap}
.category1 .cat1-item-sub{margin-left:50px;font-size:12px;color:#b0b0b0;padding-top:4px}
.category2 .cat2-tit{height:45px;line-height:45px;color:#666;font-size:14px;background-color:#eee;}
.category2 .cat2-list{background-color:#fff;border-bottom:5px solid #ededed;}
.category2 .cat2-item{height:45px;line-height:45px;padding-left:5%;border-bottom:1px solid #ededed;width:45%;float:left;-moz-box-shadow:-1px 0 0 0 #ededed inset;-webkit-box-shadow:-1px 0 0 0 #ededed inset;box-shadow:-1px 0 0 0 #ededed inset}
.category2 .cat2-item-tit{font-size:15px;color:#333;width:76%;overflow:hidden;text-overflow:ellipsis;white-space:nowrap}
</style>


  <div class="category1">
   <h2 class="cat1-tit pl-15">您需要的需求类型是？</h2> 
   <ul class="cat1-list">
   
       <?php if(is_array($menu[0])){foreach($menu[0] AS $index=>$value) { ?>
        

    <li class="cat1-item">
    <a href="<?php if(count($menu[$value['id']])>0){?>javascript:set_display('cat_<?php echo $value['id']; ?>');<?php } else { ?>add.php?step=2&typeid=<?php echo $value['id']; ?><?php }?>" class="cat1-item-1 pl-15 clearfix">
    <img src="<?php echo $HttpPath; ?><?php echo $value['ico']; ?>" alt="" class="cat1-item-img" /> <p class="cat1-item-tit"><?php echo $value['title']; ?></p> <i class="icon-down-arrow font"></i></a> 
     <div class="category2 "  id='cat_<?php echo $value['id']; ?>'  style='display:none;'>
      <ul class="cat2-list clearfix">
      <?php if(is_array($menu[$value['id']])){foreach($menu[$value['id']] AS $index1=>$value1) { ?>
       <li class="cat2-item ti-25"><a href="add.php?step=2&typeid=<?php echo $value1['id']; ?>" class="clearfix" data-linkid="10096255"><p class="cat2-item-tit"><?php echo $value1['title']; ?></p></a></li>
      <?php }}?>
      </ul>
     </div>
     </li>

           <?php }}?>
   

    
   </ul>
  </div>




<div class="clear"></div>

<script>
function set_display(div){
	if(document.getElementById(div).style.display=='none'){
		
		
		document.getElementById(div).style.display='block';
		
	}
	else
		document.getElementById(div).style.display='none';	
	
}






</script>

<?php include_once template("footer");?>