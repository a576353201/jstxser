    <?php include_once template("header");?>


<div class="main">
	    <?php include_once template("left");?>

    <div class="main_right right_bor">
    	<div class="title_weizhi">当前位置：<?php echo show_position($_GET['id']); ?></div>
    	    <?php include_once template("banner");?>
    
        <table class="products_tab">
                            
                    				<?php if(is_array($product)){foreach($product AS $key=>$value) { ?>

      	<tr>
        	
            	<th><a href="<?php echo set_url('product',$value['id'],'show'); ?>" title='<?php echo $value['title']; ?>'><img src="<?php echo $HttpPath; ?><?php echo $value['imgurl']; ?>"  width='100px' /></a></th>
                <td><a href="<?php echo set_url('product',$value['id'],'show'); ?>" title='<?php echo $value['title']; ?>'><h2><?php echo $value['title']; ?></h2></a>
                <h3  style='display:none;'>零售价：<span>￥<?php echo $value['price']; ?></span></h3>
                <p>	<?php echo GBsubstr(strip_tags($value['content']),0,300);; ?></p>
                <a href="<?php echo set_url('product',$value['id'],'show'); ?>" class="ckxq">查看详情</a></td>
            	      </tr>
  


			<?php }}?>
  
        	
        </table>
        <div style='text-align:center;margin-top:5px'>
   		<?php echo $page_html; ?>
    </div>
    </div>
    
</div>

    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
 
    
    <?php include_once template("footer");?>