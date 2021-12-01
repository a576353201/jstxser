<?php
include_once '../inc/header.php';

$now=time();

$msg=$db->exec("select * from ".tname('msg')." where id='{$_GET['id']}'");

 	$user=get_user_byid($msg['uid']);
?>

<table width="100%" border="0" cellspacing="0" cellpadding="0" class="titlebg">

      <tr>

        <td width="12" height="30"><img src="../style/images/content/tab_03.gif" width="12" height="30" /></td>

        <td>
        
  
         <div style='float:left' ><img src="../style/images/content/tb.gif" width="16" height="16" /></div>

         <div style='float:left'  class="STYLE1"><span class="STYLE3">当前位置:</span>查看通知</div>
      
      
      <div style='float:right;padding-right:5px;'><a href='#' onclick="window.history.go(-1);">返回</a></div>
        </td>

        <td width="16"><img src="../style/images/content/tab_07.gif" width="16" height="30" /></td>

      </tr>

  </table>
  


  <form name='myform' enctype="multipart/form-data" action="msg_add.php?action=add" method="post">
         <table width="100%"  class="tableList" cellpadding="1" cellspacing="1"  style='line-height:40px;'>
          <tr> 
            <td width="20%" align="right">用户名：</td>
            <td width="70%"> 
<?php echo $user['name']?>
            </td>
          </tr> 
          <tr> 
            <td align="right">标题：</td>
            <td> <?php echo $msg['title'];?>
              </td>
          </tr> 
             <tr> 
            <td align="right">内容：</td>
            <td > 
<?php echo $msg['content'];?>
            </td>
          </tr> 
         
          <tr> 
          
         <td></td>
            <td height="30" align="left" colspan="1"> 
              <input class="btn" type="button" name="Submit" value="返 回"   onclick="window.history.go(-1);" >
            </td>
          </tr>
        </table>
      </form>
<script type="text/javascript">


function   check_add(){

	if(document.getElementById('users').value==''){

alert('请输入手机号');return false;
		}


	if(document.getElementById('title').value==''){

		alert('请输入标题');return false;
				}


	if(document.getElementById('content').value==''){

		alert('请输入内容');return false;
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

