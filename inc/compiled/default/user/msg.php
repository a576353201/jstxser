<?php include_once template("header");?>


 <div class="user_center">
 <div class='u_left'>

<?php include_once template("user/left");?>
 </div>



 <div class='u_right'>

 <div class='user_nav'>
当前位置：<a href='index.php'>个人中心</a> &gt;<a href='task.php'>我的站内信</a>

 </div>



<?php if(count($list)>0){?>

        <table width="100%" border="0" cellpadding="0" cellspacing="1"  class='table_list'>

          <tr>
            <td><div align="center"><span class="STYLE1">内容</span></div></td>


    <td  style='width:180px;'><div align="center"><span class="STYLE1">
时间</span></div></td>

 <td style='width:80px;'><div align="center"><span class="STYLE1">操作 </span></div></td>




          </tr>

 	<?php if(is_array($list)){foreach($list AS $index=>$value) { ?>

          <tr>


            <td  onclick='set_view(<?php echo $value['id']; ?>);'><div align="center" style='line-height:30px;'>
            <?php if($value['view']==0){?><span style='color:#ff0000;font-weight:600;' id='msg_<?php echo $value['id']; ?>'>[未读]</span><?php }?>
            <?php echo $value['content']; ?>

            </div></td>


       <td><div align="center"><span class="STYLE1"><?php echo date('Y-m-d H:i:s',$value['addtime']); ?> </span></div></td>




 <td><div align="center"><span class="STYLE1" onClick="if(confirm('确定要删除吗? ')) location.href='msg.php?type=delete&id=<?php echo $value['id']; ?>';"> 删除 </span></div></td>

          </tr>

           <?php }}?>



           </table>


                    <div class="page" ><?php echo $page_html; ?></div>




<?php } else { ?>
<div  style='height:40px;line-height:40px;text-align:center;'>没有任何新消息</div>

<?php }?>







</div>
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

	  var msg_num=document.getElementsByName('msg_num');

for(var i=0;i<msg_num.length;i++){
msg_num[i].innerHTML--;

}
	    }
	    else{



	    }




	};
	xmlHttp.send(null);


}


</script>









<?php include_once template("footer");?>