<?php
include_once '../inc/header.php';

function get_all_info($pid=0){
	
	global $userid,$db,$modelselect_array,$navshow_array,$input_array;
	  $sql="select * from ".tname('info')." where pid='{$pid}' order by sortnum asc,id asc";
//     $num=20;
//   $page=new Page($sql, $num, $_GET['page']);
     $query=$db->query($sql);
     while ($row=$db->fetch_array($query)){
     	
     	$key=get_menu_key($row['id'],0);
     	$left=5+$key*20;
     ?>
        <tr>
<td height="20" bgcolor="#FFFFFF" style="padding-left:2px;">
                   <input type="text" name="sortnum[<?php echo $row['id'];?>]" value="<?php echo $row['sortnum'];?>"  >
                   </td>



            <td height="20" bgcolor="#FFFFFF"  align="center"><?php echo $row['title'];?></td>

            <td height="20" bgcolor="#FFFFFF"><div align="center"><span class="STYLE1"><?php echo  $input_array[$row['input']];?></span></div></td>

  <td height="20" bgcolor="#FFFFFF"><div align="center"><span class="STYLE1"><?php if($row['must']==1) echo "必填";else  echo "选填";?></span></div></td>
        
            <td bgcolor="#FFFFFF"><div align="center">
           <?php if($row['status']==1) echo "开启";else  echo "关闭";?>
            </div></td>
            
              <td bgcolor="#FFFFFF"><div align="center">
           <?php if($row['danwei']) echo $row['danwei'];else  echo "-";?>
            </div></td>
 
            <td height="20" bgcolor="#FFFFFF"  align="center">
         
     
                  <a href='info_add.php?id=<?php echo $row['id']?>&action=edit'><img src="../style/images/content/edt.gif" width="16" height="16" />编辑</a>&nbsp; &nbsp;
            <a href='action.php?from=info&id=<?php echo $row['id']?>&action=delete' onClick="return(confirm('确定要删除吗?删除后不可恢复 '))"><img src="../style/images/content/del.gif" width="16" height="16" />删除</a></span></div></td>

          </tr>
          
       <?php 
       get_all_info($row['id']);
       
     }
}

       ?>   
	



<table width="100%" border="0" cellspacing="0" cellpadding="0" class="titlebg">

      <tr>

        <td width="12" height="30"><img src="../style/images/content/tab_03.gif" width="12" height="30" /></td>

        <td>
        
  
         <div style='float:left' ><img src="../style/images/content/tb.gif" width="16" height="16" /></div>

         <div style='float:left'  class="STYLE1"><span class="STYLE3">当前位置:</span>项目字段管理</div>
      
      
      <div style='float:right;padding-right:5px;'><a href='info_add.php'>添加项目字段</a></div>
        </td>

        <td width="16"><img src="../style/images/content/tab_07.gif" width="16" height="30" /></td>

      </tr>

  </table>
   <form name='formSort' enctype="multipart/form-data" action="action.php?from=info&action=sort"method="post">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">


      <tr>

     

        <td>
        <table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="b5d6e6" onmouseover="changeto()"  onmouseout="changeback()" style="margin-left:3px;">

          <tr>


            <td width="7%" height="22" background="../style/images/content/bg.gif" bgcolor="#FFFFFF"><div align="center"><span class="STYLE1">排序</span></div></td>
     
            <td width="20%" height="22" background="../style/images/content/bg.gif" bgcolor="#FFFFFF"><div align="center"><span class="STYLE1">字段名称</span></div></td>


            <td width="10%" height="22" background="../style/images/content/bg.gif" bgcolor="#FFFFFF"><div align="center"><span class="STYLE1">输入方式</span></div></td>
            <td width="10%" height="22" background="../style/images/content/bg.gif" bgcolor="#FFFFFF"><div align="center"><span class="STYLE1">是否必填</span></div></td>
                 <td width="10%" background="../style/images/content/bg.gif" bgcolor="#FFFFFF"><div align="center"><span class="STYLE1">是否开启</span></div></td>
            <td width="10%" background="../style/images/content/bg.gif" bgcolor="#FFFFFF"><div align="center"><span class="STYLE1">单位</span></div></td>
            <td width="15%" height="22" background="../style/images/content/bg.gif" bgcolor="#FFFFFF" class="STYLE1"><div align="center">基本操作</div></td>

          </tr>

       
     <?php 
get_all_info(0);
     
     ?>
        </table></td>

        <td width="8" background="../style/images/content/tab_15.gif">&nbsp;</td>

      </tr>
</table>
 
  <table width="100%" border="0" cellspacing="0" cellpadding="0"  background="../style/images/content/tab_19.gif">
  

      <tr>
    <td width="12" height="35"><img src="../style/images/content/tab_18.gif" width="12" height="35" /></td>

     

            <td class="STYLE4">
            <input type="submit"  value="排序"> &nbsp;&nbsp;&nbsp;
</td>

            <td></td>

        <td width="16"><img src="../style/images/content/tab_20.gif" width="16" height="35" /></td>
      </tr>

    </table>
</form>
<?php include_once '../inc/footer.php';?>

