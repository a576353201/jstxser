<?php
include_once '../inc/common.php';

$from=$_GET['from'];
if($from=='index'){
if($_POST){
	foreach ($_POST as $key =>$value){

	    if($key=='admin_number'  and $value!=$system['admin_number']){
	       $user= $db->exec("select * from ".tname('user')." where (id='{$value}'  or `number`='{$value}') and status='0'");
	       if($user['id']>0){
	           $id=$user['id'];
	           update_systemkefu($id);

           }else{
               promptMessage($_SERVER['HTTP_REFERER'], '官方助手ID不存在');
           }
        }

	    if(is_array($value)) $value=serialize($value);
		if($db->exec("select * from ".tname('system')." where `key`='$key' ")){

			$db->query("update ".tname('system')." set `value`='$value' where `key`='$key'");

		}
		else{
			$db->query("insert into ".tname('system')." (`key`,`value`) values('$key','$value')");


		}


	}

	add_adminlog("修改系统基本设置");
	promptMessage($_SERVER['HTTP_REFERER'], '信息更新成功');

}
}

if($from=='info'){


	if($_GET['action']=='add'){
$now=time();
		$db->query("insert into ".tname('info')." (`addtime`) values ('$now')");
		if($db->affected_rows()>0){

			$menuid=$id=$db->insert_id();
			$db->update(tname('info'), $_POST, $id);
				$_POST['edittime']=time();

				promptMessage('info.php', '添加成功');

}
else {

				promptMessage('info.php', '添加失败');

}

	}

		if($_GET['action']=='edit'){



	$db->update(tname('info'), $_POST, $_POST['id']);
					promptMessage('info.php', '更新成功');

		}

	if($_GET['action']=='sort'){
		foreach ($_POST['sortnum'] as $key=>$value) {
			$db->query("update ".tname('info')." set sortnum='$value' where id='$key'");
		}
		promptMessage('info.php', '排序成功');

	}

	if($_GET['action']=='delete'){


		delete(tname('info'), $_GET['id']);
	promptMessage('info.php', '恭喜您！删除成功！');




	}

}
if($from=='menu'){

	if($_GET['action']=='add'){
		$_POST['updatetime']=$now=time();
		$db->query("insert into ".tname('menu')." (`addtime`) values ('$now')");
		if($db->affected_rows()>0){

			$menuid=$id=$db->insert_id();
			$db->update(tname('menu'), $_POST, $id);
				$_POST['edittime']=time();

		$now=time();
 add_adminlog("添加新闻分类【{$_POST['title']}】");



				promptMessage('menu.php', '分类添加成功');
		}
		else {
			promptMessage('menu_add.php', '分类添加失败');
		}
	}




	if($_GET['action']=='edit'){


		$_POST['updatetime']=$now=time();
			if(!$_POST['default']) $_POST['default']=0;
	$db->update(tname('menu'), $_POST, $_POST['id']);
 add_adminlog("编辑新闻分类【{$_POST['title']}】");

	promptMessage('menu.php', '编辑成功');
	}

	if($_GET['action']=='sort'){
		foreach ($_POST['sortnum'] as $key=>$value) {
			$db->query("update ".tname('menu')." set sortnum='$value' where id='$key'");
		}

		add_adminlog('新闻分类排序');
		promptMessage('menu.php', '排序成功');

	}

	if($_GET['action']=='delete'){

		if($db->exec("select * from ".tname('menu')." where pid='$_GET[id]'")){
			promptMessage("menu.php", "删除失败，请先删除子栏目");


		}
	else{
		$row=$db->exec("select * from ".tname('menu')." where id='$_GET[id]'");
		 add_adminlog("删除新闻分类【{$row['title']}】");

		delete(tname('menu'), $_GET['id']);
	promptMessage('menu.php', '恭喜您！删除成功！');
	}



	}


}

if($from=='flink'){

    if(count($_POST)>0){
        foreach ($_POST as $key=>$value){
            if(is_array($value)){
                $_POST[$key]=serialize($value);
            }
        }
    }

	if($_GET['action']=='add'){

		$db->query("insert into ".tname('flink')." (`addtime`) values ('$now')");
		if($db->affected_rows()>0){
			$id=$db->insert_id();
			$db->update(tname('flink'), $_POST, $id);


            ?>
            <script>


                parent.location.href=parent.location.href;


            </script>
            <?php
		}
		else {

            ?>
            <script>


                parent.location.href=parent.location.href;


            </script>
            <?php
		}
	}

	if($_GET['action']=='edit'){

	$db->update(tname('flink'), $_POST, $_POST['id']);

        ?>
        <script>


            parent.location.href=parent.location.href;


        </script>
        <?php
	}

	if($_GET['action']=='sort'){
		foreach ($_POST['sortnum'] as $key=>$value) {
			$db->query("update ".tname('flink')." set sortnum='$value' where id='$key'");
		}
		promptMessage('flink.php', '排序成功');

	}

	if($_GET['action']=='delete'){

		delete(tname('flink'), $_GET['id']);
	promptMessage('flink.php', '恭喜您！删除成功！');

	}

}



if($from=='charge'){

	if($_GET['action']=='add'){

		$db->query("insert into ".tname('charge')." (`addtime`) values ('$now')");
		if($db->affected_rows()>0){
			$id=$db->insert_id();
			$db->update(tname('charge'), $_POST, $id);
?>
            <script>


                parent.location.href=parent.location.href;


            </script>
            <?php
		}
		else {
			promptMessage('charge_add.php', '添加失败');
		}
	}

	if($_GET['action']=='edit'){

	$db->update(tname('charge'), $_POST, $_POST['id']);
	?>

        <script>


            parent.location.href=parent.location.href;
        </script>

    <?php
	}


	if($_GET['action']=='delete'){

		delete(tname('charge'), $_GET['id']);
	promptMessage('charge.php', '恭喜您！删除成功！');

	}

}

if($from=='kefu'){

	if($_GET['action']=='add'){

		$db->query("insert into ".tname('kefu')." (`addtime`) values ('$now')");
		if($db->affected_rows()>0){
			$id=$db->insert_id();
			$db->update(tname('kefu'), $_POST, $id);

				promptMessage('kefu.php', '添加成功');
		}
		else {
			promptMessage('kefu_add.php', '添加失败');
		}
	}

	if($_GET['action']=='edit'){

	$db->update(tname('kefu'), $_POST, $_POST['id']);
	promptMessage('kefu.php', '编辑成功');
	}

	if($_GET['action']=='sort'){
		foreach ($_POST['sortnum'] as $key=>$value) {
			$db->query("update ".tname('kefu')." set sortnum='$value' where id='$key'");
		}
		promptMessage('kefu.php', '排序成功');

	}

	if($_GET['action']=='delete'){

		delete(tname('kefu'), $_GET['id']);
	promptMessage('kefu.php', '恭喜您！删除成功！');

	}

}
?>