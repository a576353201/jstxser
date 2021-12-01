 <script>
 function show_pid(id,div){

	 if(document.getElementById('pid_'+id).style.display=='none'){
		 document.getElementById('pid_'+id).style.display='block';	 
		 div.innerHTML='-';
	 }
	
	 else {
		 document.getElementById('pid_'+id).style.display='none'	 
			 div.innerHTML='+'
	 }
	
 }
 
 </script>
 
 <div class="main_left">
    	<div class="left_menu">
        	<h2><a href="<?php echo $HttpPath; ?><?php echo get_model_path(); ?>/index.php?id=<?php echo $top_menu['id']; ?>" <?php if($top_menu['id']==$_GET['id']){?>class='cur'<?php }?>><?php echo $top_menu['title']; ?></a></h2>

            <ul>
            
                    		<?php if(is_array($frist_nav)){foreach($frist_nav AS $key=>$value) { ?>

             	<li><a href="<?php echo $HttpPath; ?><?php echo get_model_path(); ?>/index.php?id=<?php echo $value['id']; ?>" title='<?php echo $value['title']; ?>'  <?php if($value['id']==$_GET['id']){?>class='cur'<?php }?>><?php echo $value['title']; ?></a></li>
            
            <?php }}?>

            </ul>
        </div>
    
    </div>