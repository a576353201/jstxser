<?php
include_once '../inc/header.php';
if(!$_GET['type']) {$type='add';$typename='添加';}
else $type=$_GET['type'];
if($type=='edit' and $_GET['id']){

	$news=get_table(tname('news'), $_GET['id']);
	$other=unserialize($news['other']);
	$typename='编辑';
}



?>
<script>
			var editor;
			KindEditor.ready(function(K) {
				editor = K.create('textarea[name="content"]', {
					allowFileManager : true,
					afterBlur:function(){this.sync();}
				});

			});
		</script>

<form name='myform' enctype="multipart/form-data" action="action.php?type=<?php echo $type; ?>" method="post" onsubmit="return check_add();">
  <input type="hidden" name="status" id='status' value="<?php if($news['status'])echo $news['status'];else echo '1';?>"/>


         <input name="author" type="hidden"  size="10" maxlength="200" value="<?php echo $_SESSION['adminname'];?>">
    <?php if ($type=='edit'){?>       <input type="text" name="id" value="<?php echo $_GET['id'];?>" style="display:none;" />

         <input type="text" name="type1" value="<?php echo $news['type1'];?>" style="display:none;" />
    <?php }else{?>

             <input type="text" name="type1" value="<?php echo $_GET['menuid'];?>" style="display:none;" />
    <?php }?>
        <table width="98%" bgcolor="#F4FAFB" class="table_add" cellpadding="1" cellspacing="1">
          <tr>
            <td align="right">标题</td>
            <td colspan="3"> <input name="title" type="text" id="title"  value="<?php echo $news['title'];?>" required="" size="50" maxlength="200">
            <font color="#FF0000">*</font>长度最大值为100字符</td>
          </tr>


          <tr>

            <td align="right">所属栏目</td>
            <td>
              <div id="secondMenuNavDiv" style="float:left;">
                <select name="type1" required="" onchange="ShowThirdMenuNav(this.value,<?php echo $news['type2']?>)">

                  <?php if ($type=='edit')echo get_secondmenu(0,$news['type1']); else echo get_secondmenu($_GET['type1'])?>
                </select>
              </div>
              <div id="thirdMenuNavDiv" style="float:left; padding-left:10px;">

              </div>
             </td>

            <td align="right">排序权值</td>
            <td align="left"><input type="text" name="sortnum" value="<?php if($news['sortnum']) echo $news['sortnum'];else echo "5";?>" size="10" />
            &nbsp;&nbsp;权值越小，排序越靠前</td>
          </tr>
            <tr>
                <td>主标题</td>
                <td> <input type="text" name="other[cn_title]" value="<?php  echo $other['cn_title']?>" style="width: 250px;"> </td>
                <td>英文标题</td>
                <td> <input type="text" name="other[en_title]" value="<?php  echo $other['en_title']?>" style="width: 250px;"> </td>
            </tr>
            <tr>
                <td>标题描述</td>
                <td colspan="3"> <input type="text" name="other[tit]" value="<?php  echo $other['tit']?>" style="width: 400px;"> </td>

            </tr>
          <tr>
            <td align="right">详细内容</td>
            <td colspan="3">
              <textarea style="width: 100%;height:200px;visibility:hidden;" id="content" name="content" rows="10"><?php echo $news['content'];?></textarea>&nbsp;&nbsp;

            </td>
          </tr>

          <tr>
          <td></td>
            <td height="30" colspan="3" align="left"  >
              <input class="btn01" type="submit" name="Submit" value="立即发布"  onclick="return check_add11(1);" >&nbsp;&nbsp;&nbsp;&nbsp;


            </td>
          </tr>
        </table>
      </form>
 <script type="text/javascript">

function check_add11(type){

	document.getElementById('status').value=type;

if(document.getElementById('title').value==''){
alert('请输入标题');
return false;

}


}
</script>

