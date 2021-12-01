<?php
include_once '../inc/header.php';

if(!$_GET['action']) $action='add';
else $action=$_GET['action'];
if($_GET['pid']){
$parent=get_table(tname('menu'), $_GET['pid']);
$pid=$_GET['pid'];
}
else $pid=0;
if($_GET[id]){
$menu=get_table(tname('menu'), $_GET['id']);
$pid=$menu['pid'];
$parent=get_table(tname('menu'), $pid);
}

?>



 <form name='myform' enctype="multipart/form-data" action="action.php?from=menu&action=<?php echo $action; ?>" onsubmit="return check_add();"method="post">

          <input type='hidden' value='product' name="modelselect" >
          <input name="modeltype" type="hidden" value="1" >
    <?php
    if($action=='add'){
    ?>
<input type="text" name="pid" value="<?php echo $pid;?>" style="display:none" />
      <?php }else{?>
          <input type="text" name="id" value="<?php echo $menu['id']?>" style="display:none" />
    <input type="text" name="pid" value="<?php echo $menu['pid']?>" style="display:none" />

      <?php }?>



<table width="98%" bgcolor="#FFFFFF" class="table_add" cellpadding="1" cellspacing="1">
  <tr>
    <td width="30%" align="right">上级栏目名称</td>
    <td width="70%" align="left">
    <?php
    if($pid>0){
    ?>
    <input type="text" name="pname" value="<?php echo  $parent['title'];?>" size="40" readonly="readonly" disabled="disabled"/>
    <?php }else{?>

        <input type="text" name="pname" value="顶级目录" size="40" readonly="readonly" disabled="disabled"/>

    <?php }?>
    </td>
  </tr>

  <tr>
    <td align="right">栏目名称</td>
    <td align="left"><input type="text" name="title" value="<?php echo $menu['title'];?>" size="40" /> <span style="color:#FF0000">*</span></td>
  </tr>

  <tr>
    <td align="right">同级目录排序</td>
    <td align="left">
    <?php
    if($action=='add'){
    ?>
      <input type="text" name="sortnum" value="5" size="10" />
      <?php }else{?>
            <input type="text" name="sortnum" value="<?php echo $menu['sortnum'];?>" size="10" />

      <?php }?>
      数字越小，排序越靠前
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

</script>



