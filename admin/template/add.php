<?php
include_once '../inc/header.php';
if(!$_GET['type']) {$type='add';$typename='添加';}
else $type=$_GET['type'];
if($type=='edit' and $_GET['id']){
	
	$template=get_table(tname('template'), $_GET['id']);
	$typename='编辑';
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

         <div style='float:left'  class="STYLE1"><span class="STYLE3">当前位置:</span>模版管理</div>
      
      
      <div style='float:right;padding-right:5px;'><a href='#' onclick="window.history.go(-1);">返回</a></div>
        </td>

        <td width="16"><img src="../style/images/content/tab_07.gif" width="16" height="30" /></td>

      </tr>

  </table>
<form name='myform' enctype="multipart/form-data" action="action.php?type=<?php echo $type; ?>" method="post" onsubmit="return check_add();">
     
             
      
    <?php if ($type=='edit'){?>       <input type="text" name="id" value="<?php echo $_GET['id'];?>" style="display:none;" /> 
     <input type="text" name="imgpreurl" value="<?php echo $template['imgpreurl'];?>" style="display:none;" />
         <input type="text" name="type1" value="<?php echo $template['type1'];?>" style="display:none;" />
    <?php }else{?>
         <input type="text" name="imgpreurl" value="uploads/nopic.jpg" style="display:none;" />
             <input type="text" name="type1" value="<?php echo $_GET['menuid'];?>" style="display:none;" />
    <?php }?>
        <table width="98%" bgcolor="#F4FAFB" class="tableList" cellpadding="1" cellspacing="1">
          <tr>
            <td width="10%" align="right">标题</td>
            <td width="90%"> <input name="title" type="text" id="title"  value="<?php echo $template['title'];?>" size="50" maxlength="200"> 
            <font color="#FF0000">*</font>长度最大值为100字符</td>
          </tr> 
           
                 <tr id="imgurls" height="20"> 
            <td align="right">图片</td>
            <td> 
              <input name="imgurl" type="text" id="imgurl" value="<?php echo $template['imgurl'];?>" size="45" maxlength="200" readonly="readonly">
              <iframe style="padding:0; margin:0;" src="../inc/upload.php?returnid=imgurl&path=tempalte&pre=1&mark=1" frameborder=0 scrolling=no width="350" height="25" ></iframe>
            <font color="#FF0000">*</font>
</td>
          </tr> 
          <tr id="imgurls" height="20"> 
            <td align="right">缩略图</td>
            <td>
              <?php if ($type=='edit'){?>         
                  <img name="imgurlpre" src="<?php echo $HttpPath.$template['imgpreurl'];?>" border="0" style="margin:10px 10px;"/>
              
    
    <?php }else{?>
               <img name="imgurlpre" src="../../uploads/nopic.jpg" border="0" style="margin:10px 10px;"/>
    <?php }?>
         
            </td>
          </tr>
          <tr> 
                     
            <td align="right">所属栏目</td>
            <td>
              <div id="secondMenuNavDiv" style="float:left;">
                <select name="type1"  onchange="ShowThirdMenuNav(this.value,<?php echo $template['type1']?>)">
                  <option value="0" selected="selected">一级级栏目</option>
                  <?php if ($template['type1'])echo get_secondmenu(6,$template['type1']); else echo get_secondmenu(6)?>
                </select>
              </div>
              <div id="thirdMenuNavDiv" style="float:left; display:none;padding-left:10px;padding-top:8px;">
              </div>
             </td>
          </tr>
                      <tr id="imgurls" height="20"> 
            <td align="right">模版目录</td>
            <td> 
              <input name="dir" type="text"  size="45" id="dir" value="<?php echo $template['dir'];?>" maxlength="200">
                        <font color="#FF0000">*</font>
</td>
          </tr> 
         
        
           <tr> 
            <td align="right">状态</td>
            <td>
            <?php if($type=='edit'){?>
              <input name="status" type="radio" value="1" <?php if($template['status']==1) echo 'checked="checked"';?> >发布
              <input name="status" type="radio" value="2" <?php if($template['status']==2) echo 'checked="checked"';?>>草稿
              
              <?php }
              else{?>
                    <input name="status" type="radio" value="1" checked="checked">发布
              <input name="status" type="radio" value="2">草稿
              
              <?php }?>
            </td>
          </tr>
     
        
     
          <tr> 
            <td align="right">演示地址</td>
            <td>
              <input  type="text" name="url" value="<?php echo $template['url'];?>" size="40"/>&nbsp;&nbsp;&nbsp;&nbsp;
            </td>
          </tr> 
  

          <tr>
            <td align="right">排序权值</td>
            <td align="left"><input type="text" name="sortnum" value="<?php if($template['sortnum']) echo $template['sortnum'];else echo "5";?>" size="10" /> 
            &nbsp;&nbsp;权值越小，排序越靠前</td>
          </tr>
          <tr> 
            <td align="right">详细内容</td>
            <td>
              <textarea style="width:640px;height:300px;visibility:hidden;" id="content" name="content" rows="10"><?php echo $template['content'];?></textarea>&nbsp;&nbsp;

            </td>
          </tr>

    <tr>
    <td align="right">默认</td>
    <td align="left">
<input type='checkbox' name="default" value='1' <?php if($template['default']) echo "checked";?>>(用户默认模版)
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

if(document.getElementById('dir').value==''){
	alert('请输入模版目录');
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

