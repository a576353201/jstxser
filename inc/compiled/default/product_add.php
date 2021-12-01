<?php include_once template("header");?>
<script src="<?php echo $HttpPath; ?>Style/js/main.js" type="text/javascript"></script>
		<script language="javascript" type="text/javascript" src="<?php echo $HttpPath; ?>style/My97DatePicker/WdatePicker.js"></script>









<script>
			var editor;
			KindEditor.ready(function(K) {
				editor = K.create('textarea[name="content"]', {
					allowFileManager : true
				});
		
			});

    function show_tabs(div1,div2){



    	document.getElementById(div1).style.display='block';
    	document.getElementById(div2).style.display='none';


        }

			
			
		</script>






<div class="main"  style='line-height:30px;'>

<form name='myform' enctype="multipart/form-data" action="action.php?type=<?php echo $type; ?>" method="post" onsubmit="return check_add();">
     
             
         <input name="author" type="hidden"  size="10" maxlength="200" value="<?php echo $_SESSION['adminname'];?>">
    <?php if ($type=='edit'){?>       <input type="text" name="id" value="<?php echo $_GET['id'];?>" style="display:none;" /> 
     <input type="text" name="imgpreurl" value="<?php echo $news['imgpreurl'];?>" style="display:none;" />
         <input type="text" name="type1" value="<?php echo $news['type1'];?>" style="display:none;" />
    <?php }else{?>
         <input type="text" name="imgpreurl" value="uploads/nopic.jpg" style="display:none;" />
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
                <select name="type2"  onchange="ShowThirdMenuNav(this.value)">
                  <option value="0" selected="selected">一级栏目</option>
                  <?php  echo get_secondmenu(0)?>
                </select>
              </div>
           <div id="thirdMenuNavDiv" style="float:left; display:none;padding-left:10px;">
              </div>
             </td>
          </tr>
          
          
          
          
             <tr>
            <td align="right">显示区域</td>
            <td>
      <?php 
      if(!$news['type']) $news['type']=3;
      
      foreach ($arr_type as $key=> $value) {
      	?>
      	<input type="radio"  value='<?php echo $key?>' <?php if($key==$news['type']) echo "checked";?>  name='type' 
      	 <?php if($key<=2){?> onclick="show_tabs('pic','text');"  <?php }else{?> onclick="show_tabs('text','pic');"  <?php }?>> <?php echo $value;?>
      	
      	<?php 
      }
      ?>

             </td>
          </tr>
   <tr>

            <td  colspan="2">
   <table  id='pic' style='display:<?php if($news['type']<=2) echo "block";else echo "none";?>' width="98%"   >
   
   
        
                 <tr id="imgurls" height="20"  > 
            <td align="right" width="10%" >图片</td>
            <td> 
              <input name="imgurl" type="text" id="imgurl" value="<?php echo $news['imgurl'];?>" size="45" maxlength="200" readonly="readonly">
              <iframe style="padding:0; margin:0;" src="../inc/upload.php?returnid=imgurl&path=product&pre=1&mark=1" frameborder=0 scrolling=no width="350" height="25" ></iframe>
            <font color="#FF0000">*</font>
</td>
          </tr> 
          <tr id="imgurls" height="20" style='display:none;'>   
            <td align="right">缩略图</td>
            <td>
              <?php if ($type=='edit'){?>         
                  <img name="imgurlpre" src="<?php echo $HttpPath.$news['imgpreurl'];?>" border="0" style="margin:10px 10px;"/>
              
    
    <?php }else{?>
               <img name="imgurlpre" src="../../uploads/nopic.jpg" border="0" style="margin:10px 10px;"/>
    <?php }?>
         
            </td>
          </tr>
                
   
   </table>
   
   
   <table id='text' width="98%" style='display:<?php if($news['type']>2) echo "block";else echo  "none";?>'>
   
          
     
   
   
   
   
   </table>
   
   
   
   
   
   

             </td>
          </tr>
          
          
          
                   <tr> 
            <td align="right">详细介绍</td>
            <td>
              <textarea style="width:600px;height:200px;border:#ccc 1px solid;" id="content" name="content" rows="10"><?php echo $news['content'];?></textarea>&nbsp;&nbsp;

            </td>
          </tr> 
          
          
               <tr> 
            <td align="right">截止时间</td>
            <td>
             <input type="text" name="endtime"  value="<?php if($news['endtime']) echo date('Y-m-d',$news['endtime']);?>"  class="Wdate" type="text" onclick="WdatePicker({dateFmt:'yyyy-MM-dd',alwaysUseStartDate:false})"/>
             

            </td>
          </tr> 
          
          

    
        
 
   

   
             <tr>
            <td width="10%" align="right">联系方式</td>
            <td width="90%"> <input name="phone" type="text" id="phone"  value="<?php echo $news['phone'];?>" size="50" maxlength="200"> 
            请填写手机号码</td>
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
      
      </div>
 <script type="text/javascript">

function check_add(){
if(document.getElementById('title').value==''){
alert('请输入标题');
return false;
	
}

}
 
</script>


<?php include_once template("footer");?>
