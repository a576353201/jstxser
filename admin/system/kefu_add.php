<?php
include_once '../inc/header.php';

if(!$_GET['action']) $action='add';
else {$action=$_GET['action'];

$kefu=get_table(tname('kefu'), $_GET['id']);
}
?>

<table width="100%" border="0" cellspacing="0" cellpadding="0" class="titlebg">

      <tr>

        <td width="12" height="30"><img src="../style/images/content/tab_03.gif" width="12" height="30" /></td>

        <td>
        
  
         <div style='float:left' ><img src="../style/images/content/tb.gif" width="16" height="16" /></div>

         <div style='float:left'  class="STYLE1"><span class="STYLE3">当前位置:</span>添加客服</div>
      
      
      <div style='float:right;padding-right:5px;'><a href='#' onclick="window.history.go(-1);">返回</a></div>
        </td>

        <td width="16"><img src="../style/images/content/tab_07.gif" width="16" height="30" /></td>

      </tr>

  </table>
  


 <form name='myform' enctype="multipart/form-data" action="action.php?from=kefu&action=<?php echo $action; ?>" onsubmit="return check_add();"method="post">

    <?php 
    if($action=='edit'){
    ?>

          <input type="text" name="id" value="<?php echo $kefu['id']?>" style="display:none" />

      
      <?php }?>



<table width="98%" bgcolor="#FFFFFF" class="tableList" cellpadding="1" cellspacing="1">

 <tr>
            <td colspan="2">
           
                    <tr> 
                      <td width="20%" align="right">客服标题</td>
                      <td width="80%"> <input name="title" type="text" size="50" maxlength="200" id="title" value="<?php echo $kefu['title'];?>">
                      <font color="#FF0000"> *</font>长度最大值为100字符</td>
                   </tr>
              
          <tr> 
            <td align="right">QQ</td>
            <td> <input name="qq" type="text" size="50" maxlength="200"  id="qq" value="<?php echo $kefu['qq'];?>">
            <font color="#FF0000"> *</font></td>
          </tr>    
          <tr> 
            <td align="right">显示排序</td>
            <td> <input name="sortnum" type="text" size="5" value="<?php if($kefu['sortnum']>0) echo $kefu['sortnum'];else echo '5';?>" maxlength="250">数字越小排序越靠前</td>
          </tr> 
          <tr> 
            <td align="right">状态</td>
            <td> 
              <input name="status" type="radio" value="1" <?php if($kefu['status']!=2) echo "checked";?>>发布
              <input name="status" type="radio" value="2" <?php if($kefu['status']==2) echo "checked";?>>草稿
            </td>
          </tr>
    

  <tr>
  <td></td>
    <td colspan="1" align="left" valign="middle">
      <input type="submit" value="确 定" class="button" onclick="return check_add()" />
      <input type="reset" value="重 置" class="button" />
    </td>
  </tr>
</table>
</form>


 <script type="text/javascript">



function  check_add(){

if(document.getElementById('title').value==''){
alert('请输入名称');

	return false;
}

if(document.getElementById('qq').value==''){
	alert('请输入qq');

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

