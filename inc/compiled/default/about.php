

    <?php include_once template("header");?>
    
    
    
    
    
    
  
<!-- ===== 头结束 ===== -->


<div class="main">
	    <?php include_once template("left");?>

    <div class="main_right right_bor">
    	<div class="title_weizhi">当前位置：<?php echo show_position($_GET['id']); ?></div>
    	   <?php include_once template("banner");?>
        <div class="contact">
        <div class='title' style='text-align:center;font-size:20px;font-weight:800;line-height:50px;'><?php echo $about['title']; ?></div>
        <div  style='text-align:center;line-height:30px'>
        <?php if($about['copyfrom']){?>
	来源地址:<a href="<?php echo $news['copyfrom']; ?>" target="_blank"><?php echo $about['copyfrom']; ?></a>&nbsp;&nbsp;
	<?php }?>
	     更新时间:<?php echo date('Y-m-d H:i:s',$about['addtime']); ?>&nbsp;&nbsp;

             	     点击次数:<?php echo $about['clicknum']; ?>
        </div>
        <p><?php echo $about['content']; ?></p>
		
		
        </div>
        
    </div>
    
</div>
    

   
    
    <?php include_once template("footer");?>


