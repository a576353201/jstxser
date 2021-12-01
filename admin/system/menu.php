<?php
include_once '../inc/header.php';

function get_all_menu($pid=0){

	global $userid,$db,$modelselect_array,$navshow_array;
	  $sql="select * from ".tname('menu')." where pid='$pid' and uid='$userid' order by sortnum asc,id asc";
//     $num=20;
//   $page=new Page($sql, $num, $_GET['page']);
     $query=$db->query($sql);
     while ($row=$db->fetch_array($query)){

     	$key=get_menu_key($row['id'],0);
     	$left=5+$key*20;
     ?>
        <tr>
<td height="40" bgcolor="#FFFFFF" style="padding-left:2px;">
                   <input type="text" name="sortnum[<?php echo $row['id'];?>]" value="<?php echo $row['sortnum'];?>"  >
                   </td>

            <td height="30" bgcolor="#FFFFFF"><div align="center" class="STYLE1">

              <div align="center"><?php echo $row['id']?></div>

            </div>
            </td>


            <td height="20" bgcolor="#FFFFFF" style="padding-left:<?php echo $left;?>px;"><?php echo $row['title'];?>

            </td>



            <td height="20" bgcolor="#FFFFFF">
            <div align="center"><span class="STYLE4">

                 <?php
                 if($key<2){
                 ?>
       <a href='menu_add.php?pid=<?php echo $row['id']?>&action=add'>添加子类</a>&nbsp; &nbsp;

       <?php }?>

                    <?php
                    if($pid>0){
                        ?>
                    <a href='action.php?from=menu&id=<?php echo $row['id']?>&action=delete' onClick="return(confirm('确定要删除吗?删除后不可恢复 '))"><img src="../style/images/content/del.gif" width="16" height="16" />删除</a></span></div></td>

            <?php
                    }
                    ?>
                  <a href='menu_add.php?id=<?php echo $row['id']?>&action=edit'><img src="../style/images/content/edt.gif" width="16" height="16" />编辑</a>&nbsp; &nbsp;

          </tr>

       <?php
       get_all_menu($row['id']);

     }
}

       ?>




   <form name='formSort' enctype="multipart/form-data" action="action.php?from=menu&action=sort"method="post">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">



          <tr>


            <td width="7%" height="22" ><div align="center"><span class="STYLE1">排序</span></div></td>
            <td width="5%" height="22" ><div align="center"><span class="STYLE1">ID</span></div></td>


            <td  height="22" ><div align="center"><span class="STYLE1">栏目名称</span></div></td>

 <td  height="22"  class="STYLE1"><div align="center">基本操作</div></td>

          </tr>


     <?php
get_all_menu(0);

     ?>
        </table>
   <table width="100%" border="0" cellspacing="0" cellpadding="0"  background="../style/images/content/tab_19.gif">


      <tr>
    <td width="12" height="35"><img src="../style/images/content/tab_18.gif" width="12" height="35" /></td>



            <td class="STYLE4"  align="center">

<input type="submit" value='更新排序'>
</td>

            <td></td>

        <td width="16"><img src="../style/images/content/tab_20.gif" width="16" height="35" /></td>
      </tr>

    </table>

</form>
<?php include_once '../inc/footer.php';?>

