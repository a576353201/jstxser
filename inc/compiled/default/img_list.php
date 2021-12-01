    <?php include_once template("header");?>

<div class="bannern width"></div>
<div class="clear"></div>
     <div class="main width">
        <div class="main_l">
    <?php include_once template("left");?>
        </div>
        <div class="main_r">
            <div class="aboutc">
             
             <?php if(is_array($img)){foreach($img AS $key=>$value) { ?>
             
                    <div class="qyzs">
                            <div class="img">
                            
					<a href="<?php echo set_url('img',$value['id'],'show'); ?>" title="<?php echo $value['title']; ?>" >
					<img src="<?php echo $HttpPath; ?><?php echo $value['imgpreurl']; ?>" alt="<?php echo $value['title']; ?>"  width="170" height="120" border="0" />	</a>
					</div>
                            <div class="tt"><a href="<?php echo set_url('img',$value['id'],'show'); ?>" title="<?php echo $value['title']; ?>" ><?php echo $value['title']; ?></a></div>
                        </div>
			<?php }}?>
                 
                        
                        
        </div>
        </div>
        <div class="bjx">
            <div class="pages_menu my_pages" style="text-align:center; padding-right: 30px;
                            line-height: 30px; height: 30px; clear:both;">
                            
<?php echo $page_html; ?>


                    </div>
        </div>
    </div>
    
    <?php include_once template("footer");?>