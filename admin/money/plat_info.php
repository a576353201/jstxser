<?php
include_once '../inc/header.php';



$plat=get_table(tname('plat'), $_GET['id']);
$user=get_user_byid($plat['uid']);
$bank=unserialize($plat['bank']);

if($_POST){
	if($_POST['status']==2) {
        add_money($plat['uid'], $plat['money'], '提现失败','plat',$_GET['id']);
        $content="您申请的<span style=\"color:#2319dc\">{$plat['money']}</span>元提现，审核<span style=\"color:#ff4d51\">未通过</span>";
        if($_POST['mark']){
            $content.="<br><span style=\"color: #999\"> 理由：</span>".$_POST['mark'];
        }

    }else{
        $content="恭喜您！您申请的<span style=\"color:#2319dc\">{$plat['money']}</span>元提现，<span style=\"color:#ff4d51\">已到账</span>";

        if($_POST['mark']){
            $content.="<br><span style=\"color: #999\"> 理由：</span>".$_POST['mark'];
        }

       //
    }
    $db->update(tname('plat'), $_POST, $_GET['id']);
    add_note(0,$plat['uid'],$content);
?>
  <script>

      parent.layer.msg('操作成功',{ type: 1, anim: 2 ,time:1000});
//      var index = parent.layer.getFrameIndex(window.name);
//      parent.layer.close(index);
      setTimeout(function () {
          parent.location.reload();
      },1000)
  </script>

<?php
	exit();
}


?>


  <style>
ul{margin: 0 auto; width:95%;line-height:40px;padding-left: 30px;}
      ul li span:first-child{
          display: inline-block;
          width: 80px;
          padding-right: 10px;
          text-align: right;
      }
</style>
   <form name='formSort' enctype="multipart/form-data" action="plat_info.php?type=sub&id=<?php echo $_GET['id'];?>&from=parent"  method="post">

 <ul >
      <li><span>用户名：</span>
         <?php echo $user['name']?>
           
           </li>
               
     <li><span>汇款金额：</span>
         <span style="color: #2319dc"><?php echo $plat['money']-$plat['fee']?></span> 元


         <input class="button" type="button" value="复制" style="height: 20px;line-height: 20px;padding: 0px 8px;" onclick="copy('<?php echo $plat['money']-$plat['fee']?>');">
           </li>

     <?php
     if($plat['fee']>0){
         ?>
         <li><span>手续费：</span>
             <?php echo $plat['fee']?>元

         </li>

     <?php
     }
     ?>
      
           <li><span>提现方式：</span>
          <?php echo $bank['bankname']; ?>
           
           </li>
     <li><span>开户行：</span>

   <?php echo $bank['province'].$bank['city'].$bank['mark']; ?>

     </li>
     <li><span>开户人姓名：</span>

         <span style="color: #2319dc"><?php echo $bank['realname']; ?></span>
         <input class="button" type="button" value="复制" style="height: 20px;line-height: 20px;padding: 0px 8px;" onclick="copy('<?php echo $bank['realname'];?>');">
           </li>
           
              <li><span>提现卡号：</span>

                  <span style="color: #2319dc"> <?php echo $bank['banknum']; ?></span>
                  <input class="button" type="button" value="复制" style="height: 20px;line-height: 20px;padding: 0px 8px;" onclick="copy('<?php echo $bank['banknum'];?>');">
           </li>



           <?php 
           
           if($plat['status']==0){
           ?>
    
               <li><span>审核状态：</span>
               
               <input type="radio"  name='status' value='1'>同意提现
   &nbsp;   &nbsp;   &nbsp;
              <input type="radio"  name='status' value='2'>拒绝提现
           </li>
    
    <?php }else{?>       
           
               <li><span>提现状态：</span><?php echo $plat_status[$plat['status']]?>
   
           
           </li> 
           
           <?php }?>
     <?php
     $tips=explode('|',$system['platdeny_tips']);
      if(count($tips)>0){
          ?>
          <li id="mark1"><span>备注：</span>

              <select name="markselect" onchange="change_mark(this.value);">
                  <option value="">请选择</option>
                  <?php
                  foreach ($tips as  $key=>$value){
                      ?>
                  <option value="<?php echo $value;?>" <?php if($value== $plat['mark']) echo "selected"; ?>><?php echo $value;?></option>
                  <?php
                  }
                  ?>
                  <option value="-1">自定义</option>
              </select>

          </li>
     <?php
      }
     ?>


             <li  id="mark2" <?php if(count($tips)>0) echo "style='display:none'"; ?>><span>备注：</span>
    <textarea style="width:300px;height: 80px;" name='mark' id="mark"><?php echo $plat['mark']?></textarea>
           
           </li>

           <li  style='margin-top:15px;'>
               <span></span>
      	<input type="submit" class='btn100' value='确认并提交' <?php  if($plat['status']==0){ ?>onclick="return click_sub();" <?php } ?>>
           </li>
        </ul>
</form>


<script type="text/javascript">

    function  change_mark( value) {

        if(value=='-1'){

            document.querySelector('#mark2').style.display='';
        }
        else{

            document.querySelector('#mark2').style.display='none';
            document.querySelector('#mark').value=value;
        }
    }

function click_sub(){

	var sta=document.getElementsByName('status');
	
var  temp=0;
  for(var i=0;i<sta.length;i++){
if(sta[i].checked)  temp=sta[i].value;
	  }
	if(temp==0) {

alert('请选择审核状态'); return false;
		}
}
//    var index = parent.layer.getFrameIndex(window.name);
//parent.layer.close(index);

</script>

