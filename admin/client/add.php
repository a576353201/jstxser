<?php
include_once '../inc/header.php';

if(!$_GET['action']) $action='add';
else $action=$_GET['action'];
$admin=get_table(tname('client'), $_GET['id']);
?>
<script src='<?php echo $HttpPath;?>style/js/script_area.js'></script>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="titlebg">

      <tr>

        <td width="12" height="30"><img src="../style/images/content/tab_03.gif" width="12" height="30" /></td>

        <td>
        
  
         <div style='float:left' ><img src="../style/images/content/tb.gif" width="16" height="16" /></div>

         <div style='float:left'  class="STYLE1"><span class="STYLE3">当前位置:</span>添加客户</div>
      
      
      <div style='float:right;padding-right:5px;'><a href='#' onclick="window.history.go(-1);">返回</a></div>
        </td>

        <td width="16"><img src="../style/images/content/tab_07.gif" width="16" height="30" /></td>

      </tr>

  </table>
  


  <form name='myform' enctype="multipart/form-data" action="action.php?action=<?php echo $action ?>&id=<?php echo $_GET['id'];?>" method="post">
         <table width="100%"  class="tableList" cellpadding="1" cellspacing="1">
          <tr> 
            <td width="30%" align="right">单位名称</td>
            <td width="70%"> 
              <div style="float:left; margin-right:10px">
                <input name="title" type="text" size="40" maxlength="40" onblur="check_name();" value="<?php echo $admin['title'];?>">
               <font color='red'>*</font>
                <span id="name_msg"></span>
              </div>
              <div id="showMessageId" style="display:none; float:left; line-height:16px; margin-top:5px;"></div>
            </td>
          </tr> 
        
          <tr> 
            <td align="right">联系人姓名</td>
            <td> <input name="name" type="text" id='name' size="40" maxlength="40" value="<?php echo $admin['name']?>"></td>
          </tr> 


          <tr> 
            <td align="right">联系电话</td>
            <td> <input name="tel" type="text" size="40" value="<?php echo $admin['tel'];?>" id='tel' maxlength="40">     <font color='red'>*</font></td>
          </tr>
          <tr> 
            <td align="right">邮箱</td>
            <td> <input name="email" type="text" size="40" maxlength="40" value="<?php echo $admin['email']?>" > </td>
          </tr> 
             <tr> 
            <td align="right">所在地区</td>
            <td>
              <select id="province" name='province'></select>
<select id="city"  name='city'></select>
<select id="area"  name='area'></select>
<script type="text/javascript">
<?php if ($admin['province']){ ?>
addressInit('province', 'city', 'area','<?php echo $admin['province']; ?>','<?php echo $admin['city'];?>}','<?php echo $admin['area'];?>');	
<?php }else {?>
addressInit('province', 'city', 'area');	
<?php }?>
</script>        <font color='red'>*</font>
          
            </td>
          </tr> 
             <tr> 
            <td align="right">详细地址</td>
            <td> <input name="address" type="text" size="40" maxlength="40" id="address" value="<?php echo $admin['address']?>" >         <font color='red'>*</font> </td>
          </tr> 
          <tr> 
          <td></td>
            <td height="30" align="left" colspan="1"> 
              <input class="button" type="submit" name="Submit" value="提 交"  onclick="return check_add();" >&nbsp;&nbsp;&nbsp;&nbsp;  
              <input class="button" type="reset" name="Submit" value="重 置" > 
            </td>
          </tr>
        </table>
      </form>
<script type="text/javascript">
var title=document.getElementById('title');
function check_name() {
		Sxmlhttprequest();

		
		xmlHttp.open('GET','check_admin.php?title='+encodeURI(title.value),true);
		xmlHttp.onreadystatechange=byphp;
		xmlHttp.send(null);
	}
function byphp(){

	if(xmlHttp.readyState==1){
		document.getElementById('name_msg').innerHTML="loading....";
	}
	if(xmlHttp.readyState==4){
	var msg=xmlHttp.responseText;

	if(msg.indexOf("1")>0)
	{document.getElementById('name_msg').innerHTML='<img src="../../style/images/error.jpg"><font color=red >单位名称已存在</font>';
	return false;
	}
		 
		 else
			 document.getElementById('name_msg').innerHTML='<img src="../../style/images/right.jpg">'+msg;

	}
}

function   check_add(){

	var pwd=document.getElementById('pwd');
	var pwdcheck=document.getElementById('pwdcheck');	

if(document.getElementById('title').value==''){
alert('请输入单位名称');
	return false;
}

if(document.getElementById('tel').value==''){
	alert('请输入联系电话');
		return false;
	}
if(document.getElementById('area').value=='请选择县区'){
	alert('请选择所在地区');
		return false;
	}
		
if(document.getElementById('address').value==''){
	alert('请输入详细地址');
		return false;
	}
			
}

</script>
 
 
 
 
  <table width="100%" border="0" cellspacing="0" cellpadding="0"  background="../style/images/content/tab_19.gif">
  

      <tr>

        <td width="12" height="35"><img src="../style/images/content/tab_18.gif" width="12" height="35" /></td>

     

            <td class="STYLE4">&nbsp;&nbsp;</td>

            <td></td>

        <td width="16"><img src="../style/images/content/tab_20.gif" width="16" height="35" /></td>

      </tr>

    </table>

<?php include_once '../inc/footer.php';?>

