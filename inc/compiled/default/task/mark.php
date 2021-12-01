<?php include_once template("header");?>
<style>

.wap_list{border:0px;}
.wap_list  .line{width:100%;display:block;clear:both;height:50px;line-height:50px;}
.wap_list  .line ul {padding-top:0px;}
.wap_list  .line  li{float:left;width:100px;}
.wap_list textarea{width:96%;height:100px;margin:0 auto;padding:5px 2%;font-size:16px;border:1px solid #ccc;}
.wap_list  input[type='text']{width:120px;height:35px;line-height:25px;padding:0px 2%;margin:0 auto;font-size:16px;border:1px solid #ccc;}

</style>

<div class="wap_list">
<form action="mark.php?action=sub&id=<?php echo $_GET['id']; ?>" method="POST">

			<div class="bm_c">



				<div style='padding-top:10px;'>

		<textarea name="mark" id="mark" style='padding:2%;border: 1px solid #ccc;width:96%;height:80px;margin:0 auto;' placeholder="内容，2-700个字"></textarea>

	</div>
				<div  style='padding-top:10px;'><button type="submit" class="btn100"  onclick='return add_comment();'><span>确定补充</span></button></div>
			</div>

			</form>
</div>


<script type="text/javascript">


function  add_comment(){



	if(document.getElementById('mark').value==''){

		alert('您还没有填写补充内容！');return false;

	}



}



</script>



<?php include_once template("footer");?>