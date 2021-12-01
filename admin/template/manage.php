<?php
include_once '../inc/header.php';



?>

<table width="100%" border="0" cellspacing="0" cellpadding="0" class="titlebg">

      <tr>

        <td width="12" height="30"><img src="../style/images/content/tab_03.gif" width="12" height="30" /></td>

        <td>
        
  
         <div style='float:left' ><img src="../style/images/content/tb.gif" width="16" height="16" /></div>

         <div style='float:left'  class="STYLE1"><span class="STYLE3">当前位置:</span>模版管理</div>
      
      
      <div style='float:right;padding-right:5px;'>
      <a href='manage.php'>最新</a> &nbsp;&nbsp;
        <a href='manage.php?type=hot'>最热</a>
      <a href='add.php'>添加模版</a></div>
        </td>

        <td width="16"><img src="../style/images/content/tab_07.gif" width="16" height="30" /></td>

      </tr>

  </table>
   <form name='formSort' enctype="multipart/form-data" action="action.php?action=sort"method="post">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">


      <tr>

     

        <td>
        <table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="b5d6e6" onmouseover="changeto()"  onmouseout="changeback()" style="margin-left:3px;">

          <tr>

<td width="8%" height="22" background="../style/images/content/bg.gif" bgcolor="#FFFFFF"><div align="center"><span class="STYLE1">排序</span></div></td>
           
            <td width="5%" height="22" background="../style/images/content/bg.gif" bgcolor="#FFFFFF"><div align="center"><span class="STYLE1">ID</span></div></td>
  <td width="8%" height="22" background="../style/images/content/bg.gif" bgcolor="#FFFFFF"><div align="center"><span class="STYLE1">图片</span></div></td>
            <td width="20%" height="22" background="../style/images/content/bg.gif" bgcolor="#FFFFFF"><div align="center"><span class="STYLE1">标题</span></div></td>


     
            <td width="10%" height="22" background="../style/images/content/bg.gif" bgcolor="#FFFFFF"><div align="center"><span class="STYLE1">目录</span></div></td>
                <td width="10%" height="22" background="../style/images/content/bg.gif" bgcolor="#FFFFFF"><div align="center"><span class="STYLE1">分类</span></div></td>
    <td width="10%" height="22" background="../style/images/content/bg.gif" bgcolor="#FFFFFF"><div align="center"><span class="STYLE1">域名</span></div></td>
       
                    <td width="5%" background="../style/images/content/bg.gif" bgcolor="#FFFFFF"><div align="center"><span class="STYLE1">修改时间</span></div></td>
             <td width="10%" background="../style/images/content/bg.gif" bgcolor="#FFFFFF"><div align="center"><span class="STYLE1">状态</span></div></td>
            <td width="15%" height="22" background="../style/images/content/bg.gif" bgcolor="#FFFFFF" class="STYLE1"><div align="center">基本操作</div></td>

          </tr>

       
     <?php 
     if($_GET['type']=='hot') $order=' sortnum asc ,';
     else $order='';
     
     $sql="select * from ".tname('template')."  order by $order id desc";
     
     
     
     $num=20;
   $page=new Page($sql, $num, $_GET['page']);
   $sql.=" limit $page->from,$num";

     $query=$db->query($sql);
     while ($row=$db->fetch_array($query)){
     	
     	
     ?>
        <tr>
<td height="20" bgcolor="#FFFFFF" style="padding-left:2px;">
                   <input type="text" name="sortnum[<?php echo $row['id'];?>]" value="<?php echo $row['sortnum'];?>">
                   </td>

            <td height="30" bgcolor="#FFFFFF">

              <div align="center"><?php echo $row['id']?></div>

      
            </td>
<td height="20" bgcolor="#FFFFFF" style="padding-left:5px;" align="center"><img src="<?php echo $HttpPath.$row['imgpreurl'];?>" height='60px'/> </td>
            <td height="20" bgcolor="#FFFFFF" style="padding-left:5px;" align="center"><?php echo $row['title'];?></td>

          

  <td height="20" bgcolor="#FFFFFF"><div align="center"><?php echo $row['dir'];?></div></td>
    <td height="20" bgcolor="#FFFFFF"><div align="center"><?php $menu=get_menu_byid($row['type1']); echo $menu['title'];?></div></td>
  <td height="20" bgcolor="#FFFFFF"><div align="center"><?php if($row['url']){?><a href="<?php echo $row['url']?>" target="_blank"><?php echo $row['url']?></a><?php }else {?>-<?php }?></div></td>
                  <td bgcolor="#FFFFFF"><div align="center">
     <?php if($row['status']==1) echo "发布";if($row['status']==2) echo "草稿";?>
            </div></td>
             <td bgcolor="#FFFFFF"><div align="center">
     <?php echo date("Y-m-d H:i:s",$row['edittime']);?>
            </div></td>
              
            <td height="20" bgcolor="#FFFFFF">
            <div align="center"><span class="STYLE4">
             
                  <a href='add.php?id=<?php echo $row['id']?>&type=edit'><img src="../style/images/content/edt.gif" width="16" height="16" />编辑</a>&nbsp; &nbsp;
            <a href='action.php?from=menu&id=<?php echo $row['id']?>&action=delete' onClick="return(confirm('确定要删除吗?删除后不可恢复 '))"><img src="../style/images/content/del.gif" width="16" height="16" />删除</a></span></div></td>

          </tr>
     
          
<?php }?>
        </table></td>

        <td width="8" background="../style/images/content/tab_15.gif">&nbsp;</td>

      </tr>
</table>
 
  <table width="100%" border="0" cellspacing="0" cellpadding="0"  background="../style/images/content/tab_19.gif">
  

      <tr>
    <td width="12" height="35"><img src="../style/images/content/tab_18.gif" width="12" height="35" /></td>

     

            <td class="STYLE4"  align="center">
            <a href='action.php?action=updateurl' onClick="return(confirm('确定要更新所有演示地址吗? '))" >更新所有演示地址 </a> &nbsp;&nbsp;&nbsp; <input type="submit"  value="排序"> &nbsp;&nbsp;&nbsp;     
<?php echo  $page->get_page();?></td>

            <td></td>

        <td width="16"><img src="../style/images/content/tab_20.gif" width="16" height="35" /></td>
      </tr>

    </table>
</form>
<?php include_once '../inc/footer.php';?>

