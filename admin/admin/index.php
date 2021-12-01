<?php
include_once '../inc/header.php';


?>
<div style='height: 40px;line-height: 40px;'>
    <a class="btn01" onclick="layer.open({
            type: 2,
            title: '新建管理员',
            maxmin: true,
            shadeClose: true, //点击遮罩关闭层
            area : ['600px' , '500px'],
            content: 'add.php?from=parent'
            });">新建管理员</a></div>


        <table width="100%" border="0" cellpadding="0" cellspacing="1" class="table_list">

          <tr>



            <th>ID</th>

            <th>用户名</th>

              <th>真实姓名</th>



              <th>管理员类型</th>

              <th>性别</th>
              <th></th>
              <th>添加时间</th>

              <th>最后登录时间</th>


            <th>基本操作</th>

          </tr>


     <?php
     $sql="select * from ".tname('admin')." order by id desc";
     $num=20;
   $page=new Page($sql, $num, $_GET['page']);
     $query=$db->query($sql);
     while ($row=$db->fetch_array($query)){

     	$role=$db->exec("select * from ".tname('role')." where id='{$row['group']}'");
     ?>
          <tr>



            <td ><?php echo $row['id']?>

            </td>

            <td><?php echo $row['name'];?></td>

            <td><?php echo $row['realname']?></td>

  <td><?php echo $role['name'];?></td>
            <td ><?php echo get_sex($row['sex']);?></div></td>

            <td ><?php echo date('Y-m-d H:i:s',$row['addtime'])?></div></td>
     <td ><?php
if($row['logintime'])
echo date('Y-m-d H:i:s',$row['logintime']);else echo '-';?></td>

            <td ">

                  <a onclick="layer.open({
            type: 2,
            title: '编辑管理员',
            maxmin: true,
            shadeClose: true, //点击遮罩关闭层
            area : ['600px' , '500px'],
            content: 'add.php?id=<?php echo $row['id']?>&action=edit&add.php&from=parent'
            });"
                  
                  ><img src="../style/images/content/edt.gif" width="16" height="16" />编辑</a>&nbsp; &nbsp;


          <?php
          if($row['name']!='admin'){
          ?>
            <a href='action.php?id=<?php echo $row['id']?>&action=delete' onClick="return(confirm('确定要删除吗?删除后不可恢复 '))"><img src="../style/images/content/del.gif" width="16" height="16" />删除</a>
<?php } ?>
       </td>
          </tr>
<?php }?>
        </table>

<?php include_once '../inc/footer.php';?>

