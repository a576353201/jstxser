    <?php include_once template("header");?>
    
    
    
    
    
    
  
<!-- ===== 头结束 ===== -->


<div class="main">

        <div class='title' style='text-align:center;font-size:16px;font-weight:800;line-height:22px;'><?php echo $msg['title']; ?></div>
        
        <div style='text-align:center;line-height:30px;'>发布时间：<?php echo date('Y-m-d H:i',$msg['addtime']); ?></div>
    

    <div id='con_0'>
    
     <div class='info'>
    
    <?php echo $msg['content']; ?>

        </div>
    
    
        
    
</div>
    
</div>
   

    <?php include_once template("footer");?>
