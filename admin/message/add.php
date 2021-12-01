<?php
include_once '../inc/header.php';
if(!$_GET['type']) {$type='add';$typename='添加';}
else $type=$_GET['type'];
if($type=='edit' and $_GET['id']){
	
	$news=get_table(tname('message'), $_GET['id']);
	$typename='回复';
}



?>

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
<form name='myform' enctype="multipart/form-data" action="action.php?type=<?php echo $type; ?>" method="post" onsubmit="return check_add();">
     
             
         <input name="author" type="hidden"  size="10" maxlength="200" value="<?php echo $_SESSION['adminname'];?>">
    <?php if ($type=='edit'){?>       <input type="text" name="id" value="<?php echo $_GET['id'];?>" style="display:none;" /> 
  
         <input type="text" name="type1" value="<?php echo $news['type1'];?>" style="display:none;" />
    <?php }else{?>
    
             <input type="text" name="type1" value="<?php echo $_GET['menuid'];?>" style="display:none;" />
    <?php }?>
        <table width="98%" bgcolor="#F4FAFB" class="tableList" cellpadding="1" cellspacing="1">
          <tr>
            <td width="10%" align="right">标题</td>
            <td width="90%"> <input name="title" type="text" id="title"  value="<?php echo $news['title'];?>" size="50" maxlength="200"> 
            <font color="#FF0000">*</font>长度最大值为100字符</td>
          </tr> 
           
  
          <tr> 
                     
            <td align="right">所属栏目</td>
            <td>
              <div id="secondMenuNavDiv" style="float:left;">
                <select name="type2"  onchange="ShowThirdMenuNav(this.value,<?php echo $news['type3']?>)">
                  <option value="0" selected="selected">二级栏目</option>
                  <?php if ($type=='edit')echo get_secondmenu($news['type1'],$news['type2']); else echo get_secondmenu($_GET['menuid'])?>
                </select>
              </div>
              <div id="thirdMenuNavDiv" style="float:left; display:none;padding-left:10px;padding-top:8px;">
              </div>
             </td>
          </tr>
          <tr> 
            <td align="right">留言人姓名</td>
            <td>
              <input name="name" type="text" value="<?php echo $news['name'];?>"  size="40" maxlength="200">
            </td>
          </tr>
          
          <tr> 
            <td align="right">留言人Email</td>
            <td>
              <input name="email" type="text" value="<?php echo $news['email'];?>"  size="40" maxlength="200">
            </td>
          </tr>
          
            <tr> 
            <td align="right">留言人电话</td>
            <td>
              <input name="tel" type="text" value="<?php echo $news['tel'];?>"  size="40" maxlength="200">
            </td>
          </tr>
           <tr> 
            <td align="right">状态</td>
            <td>
            <?php if($type=='edit'){?>
              <input name="status" type="radio" value="1" <?php if($news['status']==1) echo 'checked="checked"';?> >发布
              <input name="status" type="radio" value="2" <?php if($news['status']==2) echo 'checked="checked"';?>>草稿
              
              <?php }
              else{?>
                    <input name="status" type="radio" value="1" checked="checked">发布
              <input name="status" type="radio" value="2">草稿
              
              <?php }?>
            </td>
          </tr>
          <tr> 
            <td align="right">显示方式</td>
            <td>
            
                    <?php if($type=='edit'){?>
                        <input type="checkbox" name="showindex" value="1" <?php if($news['showindex']==1) echo 'checked="checked"';?>/>显示首页&nbsp;&nbsp;&nbsp;&nbsp;
              <input type="checkbox" name="showsub" value="1"  <?php if($news['showsub']==1) echo 'checked="checked"';?>/>显示子页
         
              
              <?php }
              else{?>
                        <input type="checkbox" name="showindex" value="1" checked="checked"/>显示首页&nbsp;&nbsp;&nbsp;&nbsp;
              <input type="checkbox" name="showsub" value="1" checked="checked"/>显示子页
              
              <?php }?>
          
            </td>
          </tr> 
        
     
  

          <tr>
            <td align="right">排序权值</td>
            <td align="left"><input type="text" name="sortnum" value="<?php if($news['sortnum']) echo $news['sortnum'];else echo "5";?>" size="10" /> 
            &nbsp;&nbsp;权值越小，排序越靠前</td>
          </tr>
          <tr> 
            <td align="right">留言内容</td>
            <td>
              <textarea style="width:540px;height:200px;" id="content" name="content" rows="10"><?php echo $news['content'];?></textarea>&nbsp;&nbsp;

            </td>
          </tr>
                 <tr> 
            <td align="right">回复内容</td>
            <td>
              <textarea style="width:540px;height:200px;" id="replaycontent" name="replaycontent" rows="10"><?php echo $news['replaycontent'];?></textarea>&nbsp;&nbsp;

            </td>
          </tr>
                    <?php
  $type1=get_table(tname('menu'), $news['type1']);
                    
                    if ($userid=='0' and $type1['default']==1 ){?>
    <tr>
    <td align="right">默认数据</td>
    <td align="left">
<input type='checkbox' name="default" value='1' <?php if($news['default']) echo "checked";?>>(勾选之后，其他注册用户将默认显示该数据)
    </td>
  </tr>
  <?php }?>
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

