    <?php include_once template("header");?>
    

<!-- ===== 头结束 ===== -->


<div class="main">
	
        <?php include_once template("left");?>
    <div class="main_right right_bor">
    	<div class="title_weizhi">当前位置：<?php echo show_position($_GET['id']); ?> &gt;&gt;我要留言</div>
    	    <?php include_once template("banner");?>
    
    	
    	<form method="POST" name="myform" action="message.php?id=<?php echo $_GET['id']; ?>&action=add" onsubmit="return checkmessageadd();">

           
            <table id='' cellspacing="0" border="0" style="line-height:35px;width:100%">
        
            <tr style="height:35px;">
              <td align="right"><font color=red>*</font>留言内容 </td>
              <td colspan="3"><textarea name="content" id="content" cols="80" rows="5"></textarea></td>
            </tr>
                    <tr style="height:35px;">
              <td align="right"><font color=red>*</font>验证码 </td>
              <td colspan="3">
              
             <input type="text"  style='width:80px;' id='code' name='code'>
              <img id="validateCodeImg" onClick="changeValidateImg()" title="看不清？换一张" src="../inc/checkcode.inc.php" style="cursor:pointer; height:24px; margin-top:8px;" />
		<a onClick="changeValidateImg()" style="margin-left:5px;text-decoration:underline;color:gray;" href="javascript:;">看不清</a>
              </td>
            </tr>
 
            <tr>
              <td colspan="4" align="center" style="height:35px;">                        
                <input type="submit" name="Submit" value="提交"  class="button" />
                <input type="reset" name="Submit" value="重置"  class="button" >
              </td>
            </tr>
            </table>
          </form>
          </form>
          
          <script>
function checkmessageadd(){
	if(document.getElementById('content').value==''){
		alert('请输入留言内容！');
		return false;
			
		}
	
	if(document.getElementById('code').value==''){
		alert('请输入验证码！');
		return false;
			
		}	
	
	
	
}
function changeValidateImg(){
	document.getElementById("validateCodeImg").src="../inc/checkcode.inc.php?rand" + parseInt(Math.random() * 1000);
}

</script>
        <div style="clear: both"></div>

    </div>
    
</div>


    <?php include_once template("footer");?>


