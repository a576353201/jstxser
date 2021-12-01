<?php
include_once '../inc/header.php';


?>

<table width="100%" border="0" cellspacing="0" cellpadding="0" class="titlebg">

      <tr>

        <td width="12" height="30"><img src="../style/images/content/tab_03.gif" width="12" height="30" /></td>

        <td>
        
  
         <div style='float:left' ><img src="../style/images/content/tb.gif" width="16" height="16" /></div>

         <div style='float:left'  class="STYLE1"><span class="STYLE3">当前位置:</span><?php echo $menu['title'];?>管理</div>
      
      
      <div style='float:right;padding-right:5px;'><a href='add.php?menuid=<?php echo $_GET['menuid'];?>'>添加<?php echo $menu['title'];?></a></div>
        </td>

        <td width="16"><img src="../style/images/content/tab_07.gif" width="16" height="30" /></td>

      </tr>

  </table>
   <form name='formSort' enctype="multipart/form-data" action="action.php?from=menu&action=sort"method="post">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">


      <tr>

     

        <td>
        <table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="b5d6e6" onmouseover="changeto()"  onmouseout="changeback()" style="margin-left:3px;">

          <tr>


           
            <td width="5%" height="22" background="../style/images/content/bg.gif" bgcolor="#FFFFFF"><div align="center"><span class="STYLE1">ID</span></div></td>

            <td width="30%" height="22" background="../style/images/content/bg.gif" bgcolor="#FFFFFF"><div align="center"><span class="STYLE1">标题</span></div></td>


     
                  
             <td width="10%" background="../style/images/content/bg.gif" bgcolor="#FFFFFF"><div align="center"><span class="STYLE1">排序权值</span></div></td>         
                  
             <td width="10%" background="../style/images/content/bg.gif" bgcolor="#FFFFFF"><div align="center"><span class="STYLE1">添加时间</span></div></td>
                    <td width="10%" background="../style/images/content/bg.gif" bgcolor="#FFFFFF"><div align="center"><span class="STYLE1">修改时间</span></div></td>

            <td width="15%" height="22" background="../style/images/content/bg.gif" bgcolor="#FFFFFF" class="STYLE1"><div align="center">基本操作</div></td>

          </tr>

       
     <?php 
     $sql="select * from ".tname('menu')." where (id='$_GET[menuid]' or pid='$_GET[menuid]' or pid in (select id from ".tname('menu')." where pid='$_GET[menuid]')) and uid='0' order by id desc";
     $num=20;
   $page=new Page($sql, $num, $_GET['page']);
     $query=$db->query($sql);
     while ($row=$db->fetch_array($query)){
     	
     	
     ?>
        <tr>


            <td height="30" bgcolor="#FFFFFF">

              <div align="center"><?php echo $row['id']?></div>

      
            </td>

            <td height="20" bgcolor="#FFFFFF" style="padding-left:5px;" align="center"><?php echo $row['title'];?></td>

          


         <td bgcolor="#FFFFFF"><div align="center">
     <?php echo $row['sortnum'];?>
            </div></td>
             <td bgcolor="#FFFFFF"><div align="center">
     <?php echo date("Y-m-d H:i:s",$row['addtime']);?>
            </div></td>
            <td bgcolor="#FFFFFF"><div align="center">
     <?php echo date("Y-m-d H:i:s",$row['updatetime']);?>
            </div></td>
              
            <td height="20" bgcolor="#FFFFFF">
            <div align="center"><span class="STYLE4">
             
                  <a href='add.php?id=<?php echo $row['id']?>&type=edit'>编辑</a>&nbsp; &nbsp;
     
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
          
<?php echo $page->get_page();?></td>

            <td></td>

        <td width="16"><img src="../style/images/content/tab_20.gif" width="16" height="35" /></td>
      </tr>

    </table>
</form>
<?php include_once '../inc/footer.php';?>

