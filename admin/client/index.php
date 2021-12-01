<?php
include_once '../inc/header.php';


?>
<script src='<?php echo $HttpPath;?>style/js/calendar.js'></script>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="titlebg">

      <tr>

        <td width="12" height="30"><img src="../style/images/content/tab_03.gif" width="12" height="30" /></td>

        <td>
        
  
         <div style='float:left' ><img src="../style/images/content/tb.gif" width="16" height="16" /></div>
<form action='index.php' method="get" >

<input type='hidden' name='adminid' value="<?php echo $_GET['adminid']?>">
         <div style='float:left'  class="STYLE1"><span class="STYLE3">当前位置:</span>客户管理
         
        &nbsp; &nbsp;&nbsp; &nbsp; 
        起止时间：
        <input type="text" id='fromtime' style="width:100px;border:#ccc 1px double" value="<?php if($_GET['formtime']) echo $_GET['fromtime'];else echo date('Y-m-d',time()-30*24*3600)?>" onfocus="HS_setDate(this,form.fromtime.value)" onblur="set_end_date();" name="fromtime">至
<input type="text" id='totime' style="width:100px;border:#ccc 1px double" value="<?php if($_GET['totime']) echo $_GET['totime'];else echo date('Y-m-d')?>" onfocus="HS_setDate(this,form.totime.value)"   onclick="set_end_date();"  name="totime">
         <input type="submit" value='确定'>
         </div>
      </form>
      
      <div style='float:right;padding-right:5px;'><a href='add.php'>添加客户</a></div>
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

            <td width="10%" height="22" background="../style/images/content/bg.gif" bgcolor="#FFFFFF"><div align="center"><span class="STYLE1">单位名称</span></div></td>


            <td width="10%" height="22" background="../style/images/content/bg.gif" bgcolor="#FFFFFF"><div align="center"><span class="STYLE1">联系人姓名</span></div></td>
      <td width="8%" height="22" background="../style/images/content/bg.gif" bgcolor="#FFFFFF"><div align="center"><span class="STYLE1">联系电话</span></div></td>

            <td width="6%" background="../style/images/content/bg.gif" bgcolor="#FFFFFF"><div align="center"><span class="STYLE1">详细地址</span></div></td>
  <td width="10%" background="../style/images/content/bg.gif" bgcolor="#FFFFFF"><div align="center"><span class="STYLE1">邮箱</span></div></td>



            <td width="15%" height="22" background="../style/images/content/bg.gif" bgcolor="#FFFFFF"><div align="center"><span class="STYLE1">添加时间</span></div></td>

            <td width="15%" height="22" background="../style/images/content/bg.gif" bgcolor="#FFFFFF"><div align="center"><span class="STYLE1">添加人</span></div></td>

            <td width="15%" height="22" background="../style/images/content/bg.gif" bgcolor="#FFFFFF" class="STYLE1"><div align="center">基本操作</div></td>

          </tr>

       
     <?php 
     $sql="select * from ".tname('client')." where 1=1 ";
     if($_SESSION['admingroup']>1){
     	$sql.=" and adminid='$_SESSION[adminid]' ";
     	
     }
     else{
     if($_GET['adminid']) $sql.=" and adminid='$_GET[adminid]'";
     }
     if($_GET['fromtime'] and $_GET['totime']){
					$from=strtotime($_GET['fromtime']." 00:00:00");
					$to=strtotime($_GET['totime']." 23:59:59");
					$sql.=" and addtime>='$from' and addtime<='$to' ";
					
					
				}
     $sql.=" order by id desc";
     $num=20;
   $page=new Page($sql, $num, $_GET['page']);
     $query=$db->query($sql);
     while ($row=$db->fetch_array($query)){
     ?>
          <tr>

       

            <td height="30" bgcolor="#FFFFFF"><div align="center" class="STYLE1">

              <div align="center"><?php echo $row['id']?></div>

            </div>
            </td>

            <td height="20" bgcolor="#FFFFFF"><div align="center"><span class="STYLE1"><?php echo $row['title'];?></span></div></td>

            <td height="20" bgcolor="#FFFFFF"><div align="center"><span class="STYLE1"><?php echo $row['name']?></span></div></td>

  <td height="20" bgcolor="#FFFFFF"><div align="center"><span class="STYLE1"><?php echo $row['tel'];?></span></div></td>
            <td bgcolor="#FFFFFF"><div align="center"><?php echo $row['province'].$row['city'].$row['area'].$row['address'];?></div></td>
 <td bgcolor="#FFFFFF"><div align="center"><?php echo $row['email'];?></div></td>

            <td height="20" bgcolor="#FFFFFF"><div align="center"><?php echo date('Y-m-d H:i:s',$row['addtime'])?></div></td>
     <td height="20" bgcolor="#FFFFFF"><div align="center"><?php $admin=get_admin_byid($row['adminid']); echo $admin['name']?></div></td>
            <td height="20" bgcolor="#FFFFFF">
            <div align="center"><span class="STYLE4">
            
                  <a href='add.php?id=<?php echo $row['id']?>&action=edit'><img src="../style/images/content/edt.gif" width="16" height="16" />编辑</a>&nbsp; &nbsp;
            <a href='action.php?id=<?php echo $row['id']?>&action=delete' onClick="return(confirm('确定要删除吗?删除后不可恢复 '))"><img src="../style/images/content/del.gif" width="16" height="16" />删除</a></span></div></td>

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

