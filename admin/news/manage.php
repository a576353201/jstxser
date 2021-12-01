<?php
include_once '../inc/header.php';


?>



  <form name='formSort' enctype="multipart/form-data" action="manage.php" method="get"  style='height:50px;line-height:50px;padding-left:10px;'>

标题:<input type="text" name='title' value='<?php echo $_GET['title']?>'>

类型：
<?php  $type=get_menu_bypid(0);
	?>
<select name='type1' onchange="ShowThirdMenuNav(this.value,'')">
 <option value=''>不限</option>
<?php foreach($type as $value){
	?>

	<option value='<?php echo $value['id']; ?>' <?php  if($value['id']==$_GET['type1']) echo "selected";?>  ><?php echo $value['title'];?></option>

	<?php
}?>

</select>
<span>
         <div id="thirdMenuNavDiv" style="display:inline; padding-left:10px;">



              </div>

</span>


   <input type="submit" value='搜索'  id='sub'>

      <input type="button" value="新增文章" onclick="layer.open({
      type: 2,
      title: '新增文章',
      maxmin: true,
      shadeClose: true, //点击遮罩关闭层
      area : ['1000px' , '600px'],
      content: 'add.php?from=parent'
    });

">

</form>
   <form name='formSort' enctype="multipart/form-data" action="action.php?from=menu&action=sort"method="post">

        <table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="b5d6e6" class="table_list" onmouseover="changeto()"  onmouseout="changeback()" style="margin-left:3px;">

          <tr>



            <td width="5%" height="22" ><div align="center"><span class="STYLE1">ID</span></div></td>

            <td width="30%" height="22" ><div align="center"><span class="STYLE1">标题</span></div></td>



            <td width="10%" height="22" ><div align="center"><span class="STYLE1">栏目</span></div></td>

             <td width="10%" ><div align="center"><span class="STYLE1">修改时间</span></div></td>
            <td width="15%" height="22"  class="STYLE1"><div align="center">基本操作</div></td>

          </tr>


     <?php
     $sql="select * from ".tname('news')." where 1 ";

  if($_GET['title']) $sql.=" and title like '%{$_GET['title']}%'";

         if($_GET['type1']) $sql.=" and type1='{$_GET['type1']}'";
             if($_GET['type2']) $sql.=" and type2='{$_GET['type2']}'";
                 if($_GET['status']) $sql.=" and `status`='{$_GET['status']}'";
     $sql.="  order by sortnum asc,id desc";
     $num=20;
   $page=new Page($sql, $num, $_GET['page']);

   $sql.=" limit $page->from,$num";
     $query=$db->query($sql);
     while ($row=$db->fetch_array($query)){


     ?>
        <tr>


            <td height="30" bgcolor="#FFFFFF">

              <div align="center"><?php echo $row['id']?></div>


            </td>

            <td height="20" bgcolor="#FFFFFF" style="padding-left:5px;" align="center"><?php echo $row['title'];?></td>



  <td height="20" bgcolor="#FFFFFF"><div align="center"><?php $type2=get_menu_byid($row['type1']);echo $type2['title'];?></div></td>


             <td bgcolor="#FFFFFF"><div align="center">
     <?php echo date("Y-m-d H:i:s",$row['edittime']);?>
            </div></td>

            <td height="20" bgcolor="#FFFFFF">
            <div align="center"><span class="STYLE4">

                  <a
                     onclick="layer.open({
      type: 2,
      title: '新增新闻',
      maxmin: true,
      shadeClose: true, //点击遮罩关闭层
      area : ['1000px' , '600px'],
      content: 'add.php?id=<?php echo $row['id']?>&type=edit&from=parent'
    });"
                  ><img src="../style/images/content/edt.gif" width="16" height="16" />编辑</a>&nbsp; &nbsp;



        	   <a href='action.php?from=menu&id=<?php echo $row['id']?>&action=delete' onClick="return(confirm('确定要删除吗?删除后不可恢复 '))"><img src="../style/images/content/del.gif" width="16" height="16" />删除</a></span></div></td>





<?php }?>
        </table>
<div class="page">
    <?php echo  $page->get_page();?>

</div>


</form>
<?php include_once '../inc/footer.php';?>

