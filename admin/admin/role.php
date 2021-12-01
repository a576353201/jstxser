<?php
include_once '../inc/header.php';

if($_GET['action']=='delete'){
	$role=get_table(tname('role'), $_GET['id']);

		if(delete(tname('role'), $_GET['id'])){

		add_adminlog('删除角色：'.$role['name']);
		promptMessage('role.php', '恭喜您！删除成功');
	}
}
?>



<div style='height: 40px;line-height: 40px;'>
    <a class="btn01" onclick="layer.open({
            type: 2,
            title: '新建角色',
            maxmin: true,
            shadeClose: true, //点击遮罩关闭层
            area : ['800px' , '600px'],
            content: 'role_add.php?from=parent'
            });">新建角色</a></div>
<?php
  $sql="select * from ".tname('role')." where 1=1 ";

     $total=count($db->fetch_all($sql));




     $sql.="order by id desc";
     $num=20;
   $page=new Page($sql, $num, $_GET['page']);
   $sql.=" limit $page->from,$num";

?>





        <table width="100%" border="0" cellpadding="0" cellspacing="1" class="table_list">

          <tr>



            <th>ID</th>




            <th>角色名称</th>



            <th>基本操作</th>

          </tr>


     <?php

     $query=$db->query($sql);
     while ($row=$db->fetch_array($query)){




     ?>
          <tr>



            <td><?php echo $row['id']?></td>


            </td>

            <td ><?php echo $row['name'];?></td>

            <td >
            <div align="center"><span class="STYLE4">
 <a
    onclick="layer.open({
            type: 2,
            title: '编辑角色-<?php echo $row['name'];?>',
            maxmin: true,
            shadeClose: true, //点击遮罩关闭层
            area : ['800px' , '600px'],
            content: 'role_add.php?id=<?php echo $row['id']?>&action=edit&from=parent'
            });"

 ><img src="../style/images/content/edt.gif" width="16" height="16" />编辑</a>&nbsp; &nbsp;
            <a href='role.php?id=<?php echo $row['id']?>&action=delete' onClick="return(confirm('确定要删除吗?删除后不可恢复 '))"><img src="../style/images/content/del.gif" width="16" height="16" />删除</a></span></div></td>

          </tr>
<?php }?>
        </table>


<?php include_once '../inc/footer.php';?>

