<?php
include_once '../inc/header.php';

if(!$_GET['action']) $action='add';
else {$action=$_GET['action'];

$flink=get_table(tname('flink'), $_GET['id']);
}
?>



 <form name='myform' enctype="multipart/form-data" action="action.php?from=flink&action=<?php echo $action; ?>" onsubmit="return check_add();"method="post">

    <?php 
    if($action=='edit'){
    ?>

          <input type="text" name="id" value="<?php echo $flink['id']?>" style="display:none" />

      
      <?php }?>



<table width="98%"  class="table_add" cellpadding="1" cellspacing="1">


 <tr>

                      <td width="20%" align="right">标题</td>
                      <td width="80%"> <input name="title" type="text" size="20" maxlength="200" id="title" value="<?php echo $flink['title'];?>">

            </td>
          </tr>
          <tr> 
            <td align="right">链接</td>
            <td> <input name="url" type="text" size="20" maxlength="200"  id="url" value="<?php echo $flink['url'];?>">
            </td>
          </tr>
    <tr>
        <td align="right">LOGO</td>
        <td align="left" style="position: relative" colspan="3">
            <input type="text" id="logo"  name="logo" value="<?php echo $flink['logo'];?>" size="20" required/>
            <iframe style=" padding:0;;" src="../inc/upload.php?returnid=logo&image=1&path=app" frameborder="0" scrolling="no" width="150" height="22"></iframe>
        </td>
    </tr>
    <tr>
        <td align="right">排序</td>
        <td> <input name="sortnum" type="text" size="20" maxlength="200"  id="url" value="<?php echo $flink['sortnum'];?>">
        </td>
    </tr>
    <tr>
        <td align="right">显示方式</td>
        <td>
            <?php
            $arr=array('Android','iOS','H5','PcWeb');
            $showtype=unserialize($flink['showtype']);
            foreach ($arr as $v){

                ?>
<input type="checkbox" name="showtype[]" value="<?php echo $v;?>" <?php if($action=='add' || in_array($v,$showtype)) echo 'checked'?>> <?php echo $v;?> &nbsp;&nbsp;
            <?php
            }
            ?>
        </td>
    </tr>

    <tr>
        <td align="right">是否显示</td>
        <td> <input name="status" type="radio" value="1" <?php if($flink['status']!=2) echo 'checked'; ?> >显示 &nbsp;
            <input name="status" type="radio" value="2" <?php if($flink['status']==2) echo 'checked'; ?>>隐藏
        </td>
    </tr>

    <tr>
  <td></td>
    <td colspan="1" align="left" valign="middle">
      <input type="submit" value="确 定" class="button" onclick="return check_add()" />

    </td>
  </tr>
</table>
</form>


 <script type="text/javascript">



function  check_add(){

if(document.getElementById('title').value==''){
alert('请输入网站名称');

	return false;
}

if(document.getElementById('url').value==''){
	alert('请输入网站url');

		return false;
	}

	
}

</script>
