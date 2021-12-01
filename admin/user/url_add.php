<?php

include_once '../inc/header.php';
if($_POST){
	if(!$_POST['name']){
		promptMessage('url_add.php', '您还没有输入用户名');
	exit();
	}
	if(!$_POST['url'] or $_POST['url']=='http://'){
		promptMessage('url_add.php', '您还没有输入域名');
	exit();
	}
	
	if($user=get_user_byname($_POST['name'])){
	if(get_url_exist($_POST['url'])){
			promptMessage('url_add.php', '您输入域名已经被占用');
		
	}	
		else{
			
			$db->query("insert into ".tname('url')."(`uid`,`url`) values('$user[id]','$_POST[url]')");
			
			if($db->affected_rows()>0){
				promptMessage('url.php', '恭喜您添加成功！');
			}
		}
	}
else{
	promptMessage('url_add.php', '您输入的用户名不存在');
}	
	
}

?>

<table width="100%" border="0" cellspacing="0" cellpadding="0" class="titlebg">

      <tr>

        <td width="12" height="30"><img src="../style/images/content/tab_03.gif" width="12" height="30" /></td>

        <td>
        
  
         <div style='float:left' ><img src="../style/images/content/tb.gif" width="16" height="16" /></div>

         <div style='float:left'  class="STYLE1"><span class="STYLE3">当前位置:</span>添加域名</div>
      
      
      <div style='float:right;padding-right:5px;'><a href='#' onclick="window.history.go(-1);">返回</a></div>
        </td>

        <td width="16"><img src="../style/images/content/tab_07.gif" width="16" height="30" /></td>

      </tr>

  </table>
  <script type="text/javascript">


function   check_add1122(){
	alert('请输入手机号');

	return false;
if(document.getElementById('name').value==''){
alert('请输入手机号');

return false;
	
}
if(document.getElementById('url').value=='' or document.getElementById('url').value=='http://'){
	alert('请输入域名');

	return false;
		
	}


		
}

</script>


  <form name='myform' enctype="multipart/form-data" action="url_add.php?action=add" onsubmit="return check_add1122();" method="post">
         <table width="100%"  class="tableList" cellpadding="1" cellspacing="1">
          <tr> 
            <td width="30%" align="right">用户名/企业编号</td>
            <td width="70%"> 
              <div style="float:left; margin-right:10px">
                <input name="name" type="text" size="40" maxlength="40" id="name"  value="">
                <span id="name_msg"></span>
              </div>

            </td>
          </tr> 
     
          <tr> 
            <td align="right">域名</td>
            <td> <input name="url" type="text" size="40" maxlength="40" value="http://"></td>
          </tr> 
            
          <tr> 
          <td>
          </td>
            <td height="30" align="left" colspan="1"> 
              <input class="button" type="submit" name="Submit" value="提 交"  onclick="return check_add1122();" >&nbsp;&nbsp;&nbsp;&nbsp;  
              <input class="button" type="reset" name="Submit" value="重 置" > 
            </td>
          </tr>
        </table>
      </form>

 
 
 
 
  <table width="100%" border="0" cellspacing="0" cellpadding="0"  background="../style/images/content/tab_19.gif">
  

      <tr>

        <td width="12" height="35"><img src="../style/images/content/tab_18.gif" width="12" height="35" /></td>

     

            <td class="STYLE4">&nbsp;&nbsp;</td>

            <td></td>

        <td width="16"><img src="../style/images/content/tab_20.gif" width="16" height="35" /></td>

      </tr>

    </table>

<?php include_once '../inc/footer.php';?>

