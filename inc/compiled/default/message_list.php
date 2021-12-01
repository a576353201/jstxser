   
   
   
   
    <?php include_once template("header");?>
    

<!-- ===== 头结束 ===== -->


<div class="main">
	
        <?php include_once template("left");?>
    <div class="main_right right_bor">
    	<div class="title_weizhi">
    	<span style='float:right;'><a href="<?php echo set_url('message',$_GET['id'],'show'); ?>" style="float:right;">我要留言</a></span>
    	当前位置：<?php echo show_position($_GET['id']); ?></div>
    	    <?php include_once template("banner");?>
    
    	
    	
        <table class="news_tab">
<?php if(is_array($message)){foreach($message AS $key=>$value) { ?>
		<div   style='padding-left:10px;'>
<div style="text-align:left;background-color:#F4f4f4;line-height:30px;width:100%;border-top:1px dashed  #e5e5e5;">
<?php echo date('Y-m-d H:i:s',$value['addtime']); ?>


</div>
<div style="padding:5px;text-align:left;">
<?php echo $value['content']; ?>

</div>

<?php if($value['replay']==1){?>
<div style='color:red;'>
管理员回复:<?php echo $value['replaycontent']; ?>

</div>
<div style="float:right;padding-right:10px;">回复时间：<?php echo date('Y-m-d H:i:s',$value['replaytime']); ?>
</div>
<div class="clear"></div>
<?php }?>
</div>




			<?php }}?>

        
        	
        </table>
        <div style="clear: both"></div>
<div style='text-align:center;margin-top:5px'>
   		<?php echo $page_html; ?>
    </div>
    </div>
    
</div>

    

<?php include_once template("footer");?>