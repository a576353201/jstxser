<?php
include_once '../inc/header.php';

if(!$_GET['action']) $action='add';
else $action=$_GET['action'];
if($_GET['pid']){
$parent=get_table(tname('info'), $_GET['pid']);
$pid=$_GET['pid'];
}
else $pid=0;
if($_GET[id]){
$info=get_table(tname('info'), $_GET['id']);
$pid=$info['pid'];
$parent=get_table(tname('info'), $pid);
}

?>

<table width="100%" border="0" cellspacing="0" cellpadding="0" class="titlebg">

      <tr>

        <td width="12" height="30"><img src="../style/images/content/tab_03.gif" width="12" height="30" /></td>

        <td>
        
  
         <div style='float:left' ><img src="../style/images/content/tb.gif" width="16" height="16" /></div>

         <div style='float:left'  class="STYLE1"><span class="STYLE3">当前位置:</span>添加项目字段</div>
      
      
      <div style='float:right;padding-right:5px;'><a href='#' onclick="window.history.go(-1);">返回</a></div>
        </td>

        <td width="16"><img src="../style/images/content/tab_07.gif" width="16" height="30" /></td>

      </tr>

  </table>
  


 <form name='myform' enctype="multipart/form-data" action="action.php?from=info&action=<?php echo $action; ?>" onsubmit="return check_add();"method="post">

          <input type='hidden' value='product' name="modelselect" >
          <input name="modeltype" type="hidden" value="1" >
    <?php 
    if($action=='add'){
    ?>
<input type="text" name="pid" value="<?php echo $pid;?>" style="display:none" />
      <?php }else{?>
          <input type="text" name="id" value="<?php echo $info['id']?>" style="display:none" />
    <input type="text" name="pid" value="<?php echo $info['pid']?>" style="display:none" />
      
      <?php }?>



<table width="98%" bgcolor="#FFFFFF" class="tableList" cellpadding="1" cellspacing="1">

  <tr>
    <td align="right">字段名称</td>
    <td align="left"><input type="text" name="title" value="<?php echo $info['title'];?>" size="40" /> <span style="color:#FF0000">*</span></td>
  </tr>

  <tr>
    <td align="right">单位</td>
    <td align="left"><input type="text" name="danwei" value="<?php echo $info['danwei'];?>" size="20" /> </td>
  </tr>



  <tr   >
    <td align="right">排序</td>
    <td align="left">
    <?php 
    if($action=='add'){
    ?>
      <input type="text" name="sortnum" value="10" size="10" />
      <?php }else{?>
            <input type="text" name="sortnum" value="<?php echo $info['sortnum'];?>" size="10" />
      
      <?php }?>
      数字越小，排序越靠前
    </td>
  </tr>
  <tr>
    <td align="right">录入方式</td>
    <td align="left">
    <select name='input'  onchange="set_tabs(this.value);">
    
    
    
    <?php foreach ($input_array as $key=>$value) {
    	
    		if($key==$info['input'])$selected='selected';
    		    else $selected='';
    	
    	
    	?>
    	         
    	        <option value="<?php echo $key; ?>" <?php echo $selected;?>  ><?php echo $value?></option>
 
    	
    	
    	<?php
    }?>
    
</select>
    </td>
  </tr>
      <tr  id='content'  <?php if($action=='add' and $info['input']=='text' and $info['input']=='textarea') echo "style='display:none;'";?>>
    <td align="right">属性信息</td>
    <td align="left">
<textarea rows="5" cols="40"  name='content'><?php echo $info['content']?></textarea>不同信息请用“|”分割
    </td>
  </tr>
  
  <tr>
    <td align="right">是否为必填</td>
    <td align="left">
<input type="radio" name='must' value='0'   <?php if(!$info['must']) echo "checked";?> >否  &nbsp;  &nbsp;
<input type="radio" name='must' value='1'   <?php if($info['must']==1) echo "checked";?> >是
    </td>
  </tr>
  
    <tr>
    <td align="right">是否启用</td>
    <td align="left">
<input type="radio" name='status' value='0'   <?php if(!$info['status'] and $action=='edit'  ) echo "checked";?> >关闭  &nbsp;  &nbsp;
<input type="radio" name='status' value='1'   <?php if($info['status']==1 or $action=='add') echo "checked";?> >启用
    </td>
  </tr>


  
  <tr>
  <td></td>
    <td  align="left" valign="middle">
      <input type="submit" value="确 定" class="button" onclick="return checkMenu()" />
      <input type="reset" value="重 置" class="button" />
    </td>
  </tr>
</table>
</form>

<script type="text/javascript">


function displayDiv(id){

if(id==1){
	document.getElementById('systemModel1').style.display='block';
	document.getElementById('systemModel2').style.display='none';

	
}
else{
	document.getElementById('systemModel2').style.display='block';
	document.getElementById('systemModel1').style.display='none';
}	
}


function  check_add(){

if(document.getElementById('title').value==''){
alert('请输入栏目名称');

	return false;
}


	
}


function  set_tabs(value){
if(value=='text' || value=='textarea'){
	document.getElementById('content').style.display='none';

	
}
else 
	document.getElementById('content').style.display='';
	
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

