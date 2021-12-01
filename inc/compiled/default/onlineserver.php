
<style>
#contracts{position:absolute; right:2px;background-color: #F8E6E6;overflow: hidden;}
#contractinfo {
	width: 120px;
	height:150px;
	padding-top: 10px;
	background-color: #FA7372;
	border-radius: 10px;
}
#contractinfo a {
	text-decoration: none;
	display: block;
	width: 120px;
	text-align: center;
	height: 20;
	line-height: 20px;
	color: white;
}
#contracttools {
	margin:1px;
	background-color: #F7F7F7;
	border-top:solid 1px #CCCCCC;
	height: 26px;
	width: 120px;
	background-image: url("images/bg-xuanfu.jpg");
	background-repeat: repeat-x;
	border-radius: 10px;
}
#contracttools a {
	text-decoration: none;
	color: #666666;
	width: 120px;
	height: 26px;
	display: block;
	text-align: center;
	line-height: 26px;
}


</style>

	<script type="text/javascript">
	window.onscroll = function() {  
		
		var sTop=document.body.scrollTop+document.documentElement.scrollTop;

if(sTop>150)
	document.getElementById('contracts').style.top=sTop+150+'px';
else 
	document.getElementById('contracts').style.top='150px';
	}
	
	
	function set_display(){
		if(document.getElementById('contractinfo').style.display=='block'){
			
			document.getElementById('contractinfo').style.display='none';
			document.getElementById('contracttools_1').innerHTML='+ 显示';
		
		}
		else{
			
			document.getElementById('contractinfo').style.display='block';
			document.getElementById('contracttools_1').innerHTML='- 隐藏';
			
		}
		
	}
	
	</script>







  
<div id="contracts" style='top:150px;'>
	<div id="contractinfo" style='display:block;'>
	        <?php if(is_array($kefu)){foreach($kefu AS $key=>$value) { ?>
	                <?php if(!empty($value['qq'])){?>
    		<a href="http://wpa.qq.com/msgrd?v=3&uin=<?php echo $value['qq']; ?>&site=qq&menu=yes" target="_blank">
			<?php echo $value['title']; ?>：<img src="<?php echo $HttpPath; ?>images/pa.gif" style="vertical-align: -5px;"/>
		</a><br/>
    
     <?php }?>
 
        <?php }}?>
	

	</div>
	<div id="contracttools">
		<a href="#" onclick="set_display();" id='contracttools_1' >- 隐藏</a>
	</div>
</div>


















