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
<form action="comment.php?action=sub&id=<?php echo $_GET['id']; ?>" method="POST">
<input type="hidden" name="score" id="score"  value='0' />
			<div class="bm_c">

				<div class="cl">

					<span class="clct_ratestar">
						<span >
						<?php  for($i=1;$i<=5;$i++){?>

						<a href="javascript:;" id='star_<?php echo $i; ?>' onmouseover="rateStarSet(<?php echo $i; ?>)"  onclick="rateStarSet(<?php echo $i; ?>;)"></a>

						<?php   } ?>

                      <span id='con_info' class='btn11' style='line-height:24px;height:24px;padding:0 5px;display:none;'></span>
						</span>

					</span>
				</div>

				<div style='padding-top:20px;'>

		<textarea name="message" id="message" style='padding:2%;border: 1px solid #ccc;width:96%;height:80px;margin:0 auto;' placeholder="内容，2-700个字"></textarea>

	</div>
				<div  style='padding-top:10px;'><button type="submit" class="btn100"  onclick='return add_comment();'><span>确定打分</span></button></div>
			</div>

			</form>
</div>


<script type="text/javascript">

var arr=Array('很差','比较差','一般','比较好','非常好');
function  add_comment(){

	if(document.getElementById('score').value<1){

		alert('您还没有打分！');return false;

	}

	if(document.getElementById('message').value==''){

		alert('您还没有填写评分内容！');return false;

	}



}


function rateStarSet(num){
	for(var i=1;i<=5;i++){

		if(i<=num){

			document.getElementById('star_'+i).className='star11';
		}
		else{
			document.getElementById('star_'+i).className='';

		}

	}
	document.getElementById('score').value=num;
document.getElementById('con_info').innerHTML=arr[num-1];
document.getElementById('con_info').style.display='inline';
}
</script>



<?php include_once template("footer");?>