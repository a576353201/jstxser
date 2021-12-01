<?php
include_once '../inc/header.php';

if(!$_GET['action']) $action='add';
else $action=$_GET['action'];
$role=get_table(tname('role'), $_GET['id']);











if($_POST){

	if($_POST['name']){


	$content='';
	foreach ($_POST as  $key=>$value) {

		if(strpos($key, 'role_')!==false){

			foreach ($value as $value1){
				if($content) $content.='|'.$value1;
				else $content=$value1;

			}


		}

	}

	if($content){
		if($_POST['id']>0){


		mysql_query("update ".tname('role')." set name='{$_POST[name]}',content='{$content}' where id='{$_POST[id]}'");

			add_adminlog("编辑角色:".$_POST['name']);

            ?>
            <script>


                parent.location.href=parent.location.href;


            </script>
            <?php
		}

		else{

mysql_query("insert into ".tname('role')." (name,content) values('{$_POST[name]}','{$content}')");

if(mysql_affected_rows()>0){
	add_adminlog("添加新角色:".$_POST['name']);

    ?>
    <script>


        parent.location.href=parent.location.href;


    </script>
    <?php


}
		}
	}

	else{

		echo "<script>alert('您还没选择任何角色');window.history.go(-1); </script>";



	}
	}

	else{

		echo "<script>alert('您还没填写角色名称');window.history.go(-1); </script>";

	}
	exit();
}




?>



  <form name='myform' enctype="multipart/form-data" action="role_add.php?form=<?php $_GET['from']?>" method="post">


  <input type="hidden" name="id" value="<?php echo $_GET['id'];?>"/>


         <table width="100%"  class="table_add" cellpadding="1" cellspacing="1">
          <tr>
            <td>角色名称</td>
            <td>

                <input name="name" type="text" size="40" maxlength="40"  value="<?php echo $role['name'];?>">



            </td>
          </tr>
          <tr>
            <td align="right">权限类型</td>
            <td>

            			<?php
				foreach ($admin_menu1 as $key=>$value) {
					if(count($admin_menu2[$key])>0){

					?>

					<div style='line-height:35px;border-bottom:1px #ddd solid;width:100%;padding-left:5px;'>
					<div style='font-weight:800'>
					<input type='checkbox' value='<?php echo $key;?>'  onclick='click_all("<?php echo $key?>");'  id='menu_<?php echo $key;?>' ><?php echo $value;?>

					</div>
					<div style='font-size:12px;'>
					<?php foreach ($admin_menu2[$key] as $key1=> $value1) {

					if(strpos($role['content'], $value1['url'])!==false) $check='checked';else $check='';
						?>

						<input type='checkbox' <?php echo $check; ?> value='<?php echo $value1['url']?>' name='role_<?php echo $key?>[]'   onclick='click_all1("<?php echo $key?>");' ><?php echo $value1['title'];?>   &nbsp; &nbsp;

						<?php
					}?>
					</div>


					</div>

					<?php
					}
				}

				?>

            </td>
          </tr>


          <tr>
              <td></td>
            <td>
              <input class="btn01" type="submit" name="Submit" value="提 交"  onclick="return check_add();" />&nbsp;&nbsp;&nbsp;&nbsp;
                <input type="hidden" value="关闭"  class="btn00" onclick="parent.layer.close(parent.layer.getFrameIndex(window.name));" />            </td>
          </tr>
        </table>
      </form>

      <script type="text/javascript">


function click_all(id){
	var role=document.getElementsByName('role_'+id+'[]');
if(document.getElementById('menu_'+id).checked == true)
{



	for(var i=0;i<role.length;i++){

role[i].checked=true;

		}

	}

else{


	for(var i=0;i<role.length;i++){

		role[i].checked=false;

				}

}
}


function click_all1(id){
	var role=document.getElementsByName('role_'+id+'[]');
var num=0;
	for(var i=0;i<role.length;i++){

		if(role[i].checked==true){
num++;
			}

				}

	if(num==role.length){

		document.getElementById('menu_'+id).checked = true;
		}
	else
		document.getElementById('menu_'+id).checked = false

}


var name=document.getElementById('name');
function check_name() {
		Sxmlhttprequest();


		xmlHttp.open('GET','check_admin.php?name='+name.value,true);
		xmlHttp.onreadystatechange=byphp;
		xmlHttp.send(null);
	}
function byphp(){

	if(xmlHttp.readyState==1){
		document.getElementById('name_msg').innerHTML="loading....";
	}
	if(xmlHttp.readyState==4){
	var msg=xmlHttp.responseText;

	if(msg.indexOf("1")>0)
	{document.getElementById('name_msg').innerHTML='<img src="../../style/images/error.jpg"><font color=red >会员已存在</font>';
	return false;
	}

		 else
			 document.getElementById('name_msg').innerHTML='<img src="../../style/images/right.jpg">';

	}
}

function   check_add(){

	var pwd=document.getElementById('pwd');
	var pwdcheck=document.getElementById('pwdcheck');
	<?php if($action=='add'){?>
	check_name();
	if(pwd.value==''){
		document.getElementById('pwd_msg').innerHTML='<img src="../../style/images/error.jpg">请输入密码';
		return false;
	}

		 else{
			 document.getElementById('pwd_msg').innerHTML='<img src="../../style/images/right.jpg">';
		 }
	<?php }?>



	if(pwd.value!=pwdcheck.value){
		document.getElementById('pwdcheck_msg').innerHTML='<img src="../../style/images/error.jpg">两次密码输入不一致';
		return false;
	}

		 else{
			 document.getElementById('pwdcheck_msg').innerHTML='<img src="../../style/images/right.jpg">';
		 }


}

</script>





