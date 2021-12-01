<?php include_once template("header");?>

 <div class="user_center  space  info">
<form action="active.php?step=sub"  method="post">
<input type="hidden" name='tid'   value='<?php echo $_GET['id']; ?>'>


<div class='line'>

<span class='title'  style='float:left'>选择参赛队伍: </span>
<span  style='float:left;line-height:40px;padding-left:15px;'>
<?php if(is_array($team)){foreach($team AS $index=>$value) { ?>
<input type='checkbox' name='team_id[]' value='<?php echo $value['id']; ?>'>
<a href='../team/index.php?id=<?php echo $value['id']; ?>' target='_blank'><?php echo $value['name']; ?></a>
<br>
<?php }}?>
</span>

</div>


<div  style='clear:both;padding-left:250px;'>
<input type="submit" class='btn01' value='确认参赛' onClick="return order_sub();">
</div>
</form>
</div>



<script>

function order_sub(){
var  tid=document.getElementsByName('team_id[]');

var num=0;
  for(var i=0;i<tid.length;i++){

   if(tid[i].checked) num++;

  }
  if(num==0){
  	 window.wxc.xcConfirm('请先选择参赛队伍',window.wxc.xcConfirm.typeEnum.warning);

         return false;

  }


  return true;


}





</script>



<?php include_once template("footer");?>