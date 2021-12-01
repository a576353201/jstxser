<?php
include_once '../inc/header.php';

if($_GET['action']=='delete'){


		if(delete(tname('userlog'), $_GET['id'])){

		add_adminlog('删除用户日志');
		promptMessage('userlog.php', '恭喜您！删除成功');
	}
}

if($_GET['action']=='deletes'){


   	if(strpos($_GET['ids'],',')!==false)
		$ids=explode(',',$_GET['ids']);
		else $ids[]=$_GET['ids'];

		foreach($ids as $value){

			$db->query("delete from ".tname('userlog')." where id='{$value}'");

		}



		add_adminlog('批量删除用户日志');
		promptMessage('userlog.php', '恭喜您！删除成功');

}

if($_GET['action']=='delete_all'){




			$db->query("delete from ".tname('userlog')."");




		add_adminlog('清空用户日志');
		promptMessage('userlog.php', '恭喜您！删除成功');

}
?>


<?php
if($_GET['id']){

	$admin = $db->exec ( "select * from ".tname('user')." where (id='{$uid}' or `number`='{$uid}')" );
	if($admin['name']) $_GET['name']=$admin['name'];
}

     $sql="select * from ".tname('userlog')." where 1=1 ";
     if($_GET['name']) $sql.=" and name='$_GET[name]' ";
if($_GET['ip']) $sql.=" and ip='$_GET[ip]' ";

     $total=count($db->fetch_all($sql));




     $sql.=" order by id desc";
     $num=20;
   $page=new Page($sql, $num, $_GET['page']);
   $sql.=" limit $page->from,$num";


?>

   <form name='formSort' enctype="multipart/form-data" action='userlog.php' method='get' style='height:50px;line-height:50px;padding-left:10px;'>

        用户账号：<input type="text" name="name" value="<?php echo $_GET['name']; ?>" id='name' >

IP:<input type="text" name="ip" value="<?php echo $_GET['ip']; ?>" id='ip' >
                       <input class="button" type="submit" name="Submit" value="确定"  >


&nbsp;&nbsp;&nbsp;
     <input class="button" type="button" class="btn00" value="清空所有记录"  onclick="delete_all();" >

</form>



        <table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="b5d6e6" onmouseover="changeto()"  onmouseout="changeback()">

          <tr>

<td bgcolor="#FFFFFF"  align="center">
  <input type="checkbox" value="1"   onclick="click_all(this);"/>
  </td>

            <td bgcolor="#FFFFFF"><div align="center"><span class="STYLE1">用户ID</span></div></td>




            <td bgcolor="#FFFFFF"><div align="center"><span class="STYLE1">用户名</div></td>

            <td bgcolor="#FFFFFF"><div align="center"><span class="STYLE1">操作</span></div></td>
    <td bgcolor="#FFFFFF"><div align="center"><span class="STYLE1">
  IP</span></div></td>

                      <td bgcolor="#FFFFFF"><div align="center"><span class="STYLE1">所在城市</span></div></td>
              <td bgcolor="#FFFFFF"><div align="center"><span class="STYLE1">手机型号</span></div></td>

            <td bgcolor="#FFFFFF"><div align="center"><span class="STYLE1">时间</span></div></td>



            <td  bgcolor="#FFFFFF" class="STYLE1"><div align="center">基本操作</div></td>

          </tr>


     <?php

     $query=$db->query($sql);
     while ($row=$db->fetch_array($query)){


$user=userinfo($row['uid']);
$deviceInfo=unserialize($row['deviceInfo']);
     ?>
          <tr>

<td bgcolor="#FFFFFF"  align="center">
  <input type="checkbox" name="id[]" value="<?php echo $row['id']?>" />

  </td>

            <td height="30" bgcolor="#FFFFFF"><div align="center" class="STYLE1">

              <div align="center"><?php echo $user['number']?></div>

            </div>
            </td>

            <td height="20" bgcolor="#FFFFFF"><div align="center"><span class="STYLE1">

            <?php
            echo $user['name']
            ?>
            </span></div></td>

              <td height="20" bgcolor="#FFFFFF"><div align="center"><span class="STYLE1"><?php echo $row['content'];?></span></div></td>

 <td height="20" bgcolor="#FFFFFF"><div align="center"><span class="STYLE1"><?php echo $row['ip'];?></span></div></td>
 <td height="20" bgcolor="#FFFFFF"><div align="center"><span class="STYLE1"><?php echo $row['address'];?></span></div></td>
              <td height="20" bgcolor="#FFFFFF"><div align="center"><span class="STYLE1"><?php echo $deviceInfo['mobile'];?></span></div></td>
            <td height="20" bgcolor="#FFFFFF"><div align="center"><?php echo date('Y-m-d H:i:s',$row['time'])?></div></td>

            <td height="20" bgcolor="#FFFFFF">
            <div align="center"><span class="STYLE4">

            <a href='userlog.php?id=<?php echo $row['id']?>&action=delete' onClick="return(confirm('确定要删除吗?删除后不可恢复 '))"><img src="../style/images/content/del.gif" width="16" height="16" />删除</a></span></div></td>

          </tr>
<?php }?>
        </table>


<div class="page" style='height:50px;line-height:50px;padding-left:10px;'>
  <input type="checkbox" value="1"   onclick="click_all(this);"/> 全选

  &nbsp;    &nbsp;    &nbsp;
        <input type='button' value='批量删除' class='btn00'  onclick="sub_add();">

                    &nbsp;    &nbsp;    &nbsp;

                   <?php echo  $page->get_page();?>
                   &nbsp;&nbsp;&nbsp;

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

	location.href='userlog.php?action=deletes&ids='+str;

}

}


function delete_all(){

if(confirm('确定要全部清空吗? ')){

		location.href='userlog.php?action=delete_all&from=parent';

}


}
</script>
<?php include_once '../inc/footer.php';?>

