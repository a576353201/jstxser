<?php include_once template("header");?>


 <div class="user_center">


<?php if(count($list)>0){?>


 	<?php if(is_array($list)){foreach($list AS $index=>$value) { ?>




  <div class="wap_list">
<div class='item' onclick='set_view(<?php echo $value['id']; ?>);'>
  <?php if($value['view']==0){?><span style='color:#ff0000;font-weight:600;' id='msg_<?php echo $value['id']; ?>'>[未读]</span><?php }?>
            <?php echo $value['content']; ?>
</div>



               <div>
                                  <span style="color:#d5d5d5;"> <?php echo date('Y-m-d H:i:s',$value['addtime']); ?> </span>

        <span style='float:right;'><span class="STYLE1" onClick="if(confirm('确定要删除吗? ')) location.href='msg.php?type=delete&id=<?php echo $value['id']; ?>';"> 删除 </span></span>





                                                </div>

</div>





           <?php }}?>




                    <div class="page" ><?php echo $page_html; ?></div>




<?php } else { ?>
<div  style='height:40px;line-height:40px;text-align:center;'>没有任何新消息</div>

<?php }?>

</div>








<script>
var xmlHttp;
function Sxmlhttprequest(){
	if(window.ActiveXObject){
		xmlHttp = new ActiveXObject('Microsoft.XMLHTTP');
	}
	else if(window.XMLHttpRequest){
		xmlHttp = new XMLHttpRequest();
	}

}
function  set_view(id){

document.getElementById('msg_'+id).style.display='none';


Sxmlhttprequest();
	xmlHttp.open('GET','msg_view.php?id='+id,true);
	xmlHttp.onreadystatechange=function(){
	var msg=xmlHttp.responseText;
 if(msg.indexOf('1')>-1){

	    }
	    else{



	    }




	};
	xmlHttp.send(null);


}



</script>





<?php include_once template("footer");?>