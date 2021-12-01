<?php
include_once '../inc/common.php';
if($_GET['type']=='add' and $_POST){

	$now=time();
	$db->query("insert into ".tname('news')."(`addtime`,`edittime`) values('$now','$now')");
	if($db->affected_rows()>0){
		$id=$db->insert_id();
        $_POST['other']=serialize($_POST['other']);
		$db->update(tname('news'), $_POST, $id);

		add_adminlog("添加新闻【{$_POST['title']}】");
	?>
        <script>


            parent.location.href=parent.location.href;


        </script>
<?php
        exit();
	}


}

if($_GET['type']=='edit' and $_POST){
	$_POST['edittime']=time();
if(!$_POST['showsub'])$_POST['showsub']=0;
$_POST['other']=serialize($_POST['other']);
		$id=$_POST['id'];

		$db->update(tname('news'), $_POST, $id);
			add_adminlog("编辑新闻【{$_POST['title']}】");
    ?>
    <script>


        parent.location.href=parent.location.href;


    </script>
    <?php


exit();

}


	if($_GET['action']=='delete' and $_GET['id']){
$news=$db->exec("select * from ".tname('news')." where id='$_GET[id]'");
add_adminlog("删除新闻【{$news['title']}】");
			$db->query("delete from ".tname('news')." where id='$_GET[id]'");
							promptMessage($_SERVER['HTTP_REFERER'],'恭喜您，删除成功');

	}



	if($_GET['action']=='history' and $_GET['id']){
$news=$db->query("update ".tname('news')." set `status`=3 where id='$_GET[id]'");
add_adminlog("新闻【{$news['title']}】放入回收站");

							promptMessage($_SERVER['HTTP_REFERER'],'恭喜您，操作成功');

	}
?>