<?php
include_once '../inc/header.php';
if($_GET['menuid']) $_GET['id']=$_GET['menuid'];
if(!$_GET['type']) {$type='add';$typename='添加';}
else $type=$_GET['type'];
if( $_GET['id']){

	$news=get_table(tname('menu'), $_GET['id']);
	$typename='编辑';
}

if($_POST){
	$db->update(tname('menu'), $_POST, $_POST['id']);
	promptMessage('manage.php?menuid='.$_POST[id], '恭喜您！编辑成功');
	
	
}

?>
<script>
			var editor;
			KindEditor.ready(function(K) {
				editor = K.create('textarea[name="content"]', {
					allowFileManager : true
				});
		
			});
		</script>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="titlebg">

      <tr>

        <td width="12" height="30"><img src="../style/images/content/tab_03.gif" width="12" height="30" /></td>

        <td>
        
  
         <div style='float:left' ><img src="../style/images/content/tb.gif" width="16" height="16" /></div>

         <div style='float:left'  class="STYLE1"><span class="STYLE3">当前位置:</span><?php echo $menu['title'].$typename;?></div>
      
      
      <div style='float:right;padding-right:5px;'><a href='#' onclick="window.history.go(-1);">返回</a></div>
        </td>

        <td width="16"><img src="../style/images/content/tab_07.gif" width="16" height="30" /></td>

      </tr>

  </table>
<form name='myform' enctype="multipart/form-data" action="add.php?type=<?php echo $type; ?>" method="post" onsubmit="return check_add();">
       <input type="text" name="id" value="<?php echo $_GET['id'];?>" style="display:none;" /> 
             
         <input name="author" type="hidden"  size="10" maxlength="200" value="<?php echo $_SESSION['adminname'];?>">

        <table width="98%" bgcolor="#F4FAFB" class="tableList" cellpadding="1" cellspacing="1">
          <tr>
            <td width="10%" align="right">标题</td>
            <td width="90%"> <input name="title" type="text" id="title"  value="<?php echo $news['title'];?>" size="50" maxlength="200"> 
            <font color="#FF0000">*</font>长度最大值为100字符</td>
          </tr> 
           
                 

          <tr> 
            <td align="right">内容关键词</td>
            <td>
              <input name="keywords" type="text" value="<?php echo $news['keywords'];?>"  size="40" maxlength="200">用于搜索引擎优化，多个关键词请用用英文版逗号（“,”）隔开
            </td>
          </tr>
          <tr> 
            <td align="right">内容简短描述<br>用于搜索引擎优化</td>
            <td><textarea name="description" cols="60" rows="5"><?php echo $news['description'];?></textarea></td>
          </tr>
        
        
          <tr> 
            <td align="right">点击次数</td>
            <td><input name="clicknum" type="text" id="clicknum" size="10" maxlength="200" value="<?php if($news['clicknum']) echo $news['clicknum'];else echo "1";?>"> 
            
            
            <font color="#FF0000">*</font>（点击次数越多，热门信息中排名越靠前）</td>
          </tr>
     
       
          <tr>
            <td align="right">排序权值</td>
            <td align="left"><input type="text" name="sortnum" value="<?php if($news['sortnum']) echo $news['sortnum'];else echo "5";?>" size="10" /> 
            &nbsp;&nbsp;权值越小，排序越靠前</td>
          </tr>
          <tr> 
            <td align="right">详细内容</td>
            <td>
              <textarea style="width:640px;height:300px;visibility:hidden;" id="content" name="content" rows="10"><?php echo $news['content'];?></textarea>&nbsp;&nbsp;

            </td>
          </tr>

          <tr> 
          <td></td>
            <td height="30" colspan="1" align="left" > 
              <input class="button" type="submit" name="Submit" value="提 交" >&nbsp;&nbsp;&nbsp;&nbsp;  
              <input class="button" type="reset" name="Submit" value="重 置" > 
            </td>
          </tr>
        </table>
      </form>
 <script type="text/javascript">

function check_add(){
if(document.getElementById('title').value==''){
alert('请输入标题');
return false;
	
}

if(document.getElementById('imgurl').value==''){
	alert('请上传图片');
	return false;
		
	}
}
 
</script>
  <table width="100%" border="0" cellspacing="0" cellpadding="0"  background="../style/images/content/tab_19.gif">
  

      <tr>
    <td width="12" height="35"><img src="../style/images/content/tab_18.gif" width="12" height="35" /></td>

     

            <td class="STYLE4">
        &nbsp;&nbsp;&nbsp;
</td>

            <td></td>

        <td width="16"><img src="../style/images/content/tab_20.gif" width="16" height="35" /></td>
      </tr>

    </table>

<?php include_once '../inc/footer.php';?>

