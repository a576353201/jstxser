<?php
include_once '../inc/header.php';

if($_GET['action']=='delete'){


		if(delete(tname('adminlog'), $_GET['id'])){

		add_adminlog('删除用户管理员日志');
		promptMessage('adminlog.php', '恭喜您！删除成功');
	}
}



if($_GET['action']=='deletes'){


   	if(strpos($_GET['ids'],',')!==false)
		$ids=explode(',',$_GET['ids']);
		else $ids[]=$_GET['ids'];

		foreach($ids as $value){

			$db->query("delete from ".tname('adminlog')." where id='{$value}'");

		}

add_adminlog('批量删除管理员日志');
		promptMessage('adminlog.php', '恭喜您！删除成功');

}
?>


<?php
if($_GET['id']){

	$admin = $db->exec ( "select * from ".tname('admin')." where id='{$uid}'" );
	if($admin['name']) $_GET['name']=$admin['name'];
}

     $sql="select * from ".tname('adminlog')." where 1=1 ";
     if($_GET['name']) $sql.=" and name='$_GET[name]'";


     $total=count($db->fetch_all($sql));




     $sql.="order by id desc";
     $num=20;
   $page=new Page($sql, $num, $_GET['page']);
   $sql.=" limit $page->from,$num";

?>

   <form name='formSort' enctype="multipart/form-data" action='adminlog.php' method='get' style='height:50px;line-height:50px;padding-left:10px;'>

         管理员账号：<input type="text" name="name" value="<?php echo $_GET['name']; ?>" >


                       <input class="button" type="submit" name="Submit" value="确定"  >



</form>



        <table width="100%" border="0" cellpadding="0" cellspacing="1"  class="table_list">

          <tr>

<th>
  <input type="checkbox" value="1"   onclick="click_all(this);"/>
  </th>

            <th>ID</th>




            <th>管理员账号</th>

            <th>操作</th>
    <th>
  IP</th>

                      <th>所在城市</th>

            <th>时间</th>



            <th>基本操作</th>

          </tr>


     <?php

     $query=$db->query($sql);
     while ($row=$db->fetch_array($query)){




     ?>
          <tr>

<td bgcolor="#FFFFFF"  align="center">
  <input type="checkbox" name="id[]" value="<?php echo $row['id']?>" />

  </td>

            <td height="30" bgcolor="#FFFFFF"><div align="center" class="STYLE1">

              <div align="center"><?php echo $row['id']?></div>

            </div>
            </td>

            <td height="20" bgcolor="#FFFFFF"><div align="center"><span class="STYLE1"><?php echo $row['name'];?></span></div></td>

              <td height="20" bgcolor="#FFFFFF"><div align="center"><span class="STYLE1"><?php echo $row['content'];?></span></div></td>

 <td height="20" bgcolor="#FFFFFF"><div align="center"><span class="STYLE1"><?php echo $row['ip'];?></span></div></td>
 <td height="20" bgcolor="#FFFFFF"><div align="center"><span class="STYLE1"><?php echo $row['address'];?></span></div></td>
            <td height="20" bgcolor="#FFFFFF"><div align="center"><?php echo date('Y-m-d H:i:s',$row['time'])?></div></td>

            <td height="20" bgcolor="#FFFFFF">
            <div align="center"><span class="STYLE4">

            <a href='adminlog.php?id=<?php echo $row['id']?>&action=delete' onClick="return(confirm('确定要删除吗?删除后不可恢复 '))"><img src="../style/images/content/del.gif" width="16" height="16" />删除</a></span></div></td>

          </tr>
<?php }?>
        </table>

<div class="page" style='height:50px;line-height:50px;padding-left:10px;'>
  <input type="checkbox" value="1"   onclick="click_all(this);"/> 全选

  &nbsp;    &nbsp;    &nbsp;
        <input type='button' value='批量删除' class='btn00'  onclick="sub_add();">

                    &nbsp;    &nbsp;    &nbsp;

                   <?php echo  $page->get_page();?>
                   </div>
<script>

function click_all(div){

var playerid=document.getElementsByName('id[]');

for(var i=0;i<playerid.length;i++){

if(div.checked==true)playerid[i].checked=true;

else playerid[i].checked=false;
}

}




function sub_add(){

	var playerid=document.getElementsByName('id[]');
var str='';
for(var i=0;i<playerid.length;i++){

if(playerid[i].checked==true){

if(str!='') str+=',';
str+=playerid[i].value;

}

}
if(str==''){

	alert('至少要选择一条记录');
	return false;
}

else{

	location.href='adminlog.php?action=deletes&ids='+str;

}

}
</script>
<?php include_once '../inc/footer.php';?>

