<?php
include_once '../inc/header.php';

if($_GET['action']=='delete'){
	
	
	delete(tname('url'), $_GET['id']);
	promptMessage('url.php', '恭喜您，删除成功！');
}
?>

<table width="100%" border="0" cellspacing="0" cellpadding="0" class="titlebg">

      <tr>

        <td width="12" height="30"><img src="../style/images/content/tab_03.gif" width="12" height="30" /></td>

        <td>
        
  
         <div style='float:left' ><img src="../style/images/content/tb.gif" width="16" height="16" /></div>

         <div style='float:left'  class="STYLE1"><span class="STYLE3">当前位置:</span>域名管理</div>
      
      
      <div style='float:right;padding-right:5px;'><a href='url_add.php'>添加域名</a></div>
        </td>

        <td width="16"><img src="../style/images/content/tab_07.gif" width="16" height="30" /></td>

      </tr>

  </table>
  
  <table width="100%" border="0" cellspacing="0" cellpadding="0">


      <tr>

     

        <td>
        <table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="b5d6e6" onmouseover="changeto()"  onmouseout="changeback()">

          <tr>



            <td width="3%" height="22" background="../style/images/content/bg.gif" bgcolor="#FFFFFF"><div align="center"><span class="STYLE1">ID</span></div></td>

            <td width="8%" height="22" background="../style/images/content/bg.gif" bgcolor="#FFFFFF"><div align="center"><span class="STYLE1">企业编号</span></div></td>
        <td width="8%" height="22" background="../style/images/content/bg.gif" bgcolor="#FFFFFF"><div align="center"><span class="STYLE1">单位名称</span></div></td>

            <td width="8%" height="22" background="../style/images/content/bg.gif" bgcolor="#FFFFFF"><div align="center"><span class="STYLE1">域名</span></div></td>

      

            <td width="10%" height="22" background="../style/images/content/bg.gif" bgcolor="#FFFFFF" class="STYLE1"><div align="center">基本操作</div></td>

          </tr>

       
     <?php 
     $sql="select * from ".tname('url')." order by id desc";
     if($_GET['id'])
          $sql="select * from ".tname('url')." where uid='$_GET[id]' order by id desc";
     $num=20;
   $page=new Page($sql, $num, $_GET['page']);
     $query=$db->query($sql);
     while ($row=$db->fetch_array($query)){
     	$user=get_user_byid($row['uid']);
     ?>
          <tr>

       

            <td height="30" bgcolor="#FFFFFF"><div align="center" class="STYLE1">

              <div align="center"><?php echo $row['id']?></div>

            </div>
            </td>

            <td height="20" bgcolor="#FFFFFF"><div align="center"><span class="STYLE1"><a href='add.php?id=<?php echo $row['uid']?>' ><?php echo $user['name'];?></a></span></div></td>
 <td height="20" bgcolor="#FFFFFF"><div align="center"><span class="STYLE1"><a href='add.php?id=<?php echo $row['uid']?>' ><?php echo $user['cname'];?></a></span></div></td>
            <td height="20" bgcolor="#FFFFFF"><div align="center"><span class="STYLE1"><a href='<?php echo $row['url']?>' target="_blank"><?php echo $row['url']?></a></span></div></td>


            <td height="20" bgcolor="#FFFFFF">
            <div align="center"><span class="STYLE4">
            

            <a href='url.php?id=<?php echo $row['id']?>&action=delete' onClick="return(confirm('确定要删除吗?删除后不可恢复 '))"><img src="../style/images/content/del.gif" width="16" height="16" />删除域名</a></span></div></td>

          </tr>
<?php }?>
        </table></td>

        <td width="8" background="../style/images/content/tab_15.gif">&nbsp;</td>

      </tr>
</table>
 
  <table width="100%" border="0" cellspacing="0" cellpadding="0"  background="../style/images/content/tab_19.gif">
  

      <tr>
    <td width="12" height="35"><img src="../style/images/content/tab_18.gif" width="12" height="35" /></td>

     

            <td class="STYLE4"><?php echo  $page->get_page();?></td>

            <td></td>

        <td width="16"><img src="../style/images/content/tab_20.gif" width="16" height="35" /></td>
      </tr>

    </table>

<?php include_once '../inc/footer.php';?>

