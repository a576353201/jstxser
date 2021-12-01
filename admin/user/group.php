<?php
include_once '../inc/header.php';

if($_GET['act']=='delete'){


    $group_id=$_GET['id'];
    $sql="select * from ".tname('group')." where id='{$group_id}' order by id desc";
    $group=$db->exec($sql);
    $db->query("delete from  ".tname('group')." where id='{$group_id}'");
    add_adminlog("删除群组[{$group['name']}]");

}

if($_GET['act']=='settop'){


    $group_id=$_GET['id'];
    $sql="select * from ".tname('group')." where id='{$group_id}' order by id desc";
    $group=$db->exec($sql);
    if($group['top']==0) $group['top']=time();
    else $group['top']=0;
    $db->query("update  ".tname('group')." set top='{$group['top']}' where id='{$group_id}'");
}

if($_GET['act']=='sortnum'){
    foreach ($_POST['sortnum'] as $key=>$value){
        $db->query("update  ".tname('group')." set sortnum='{$value}' where id='{$key}'");
    }
}


if($_GET['act']=='remove'){


    $group_id=$_GET['id'];
    $sql="select * from ".tname('group')." where id='{$group_id}' order by id desc";
    $group=$db->exec($sql);
    $data=array('fromid'=>$group['createid'],'userid'=>$group['createid'],'group_id'=>$group['id'],'type'=>'deleteGroup');
    $data1=array('group_id'=>$group['id'],'type'=>'GroupUpdate');
    ?>
    <script>
        parent.send_data('<?php echo json_encode($data);?>');
        parent.send_data('<?php echo json_encode($data1);?>');
        layer.msg('操作成功');
        //  location.reload();
        // layer.close(index);
        location.href='group.php';
    </script>
    <?php
    add_adminlog("解散群组[{$group['name']}]");

    exit();
}


if($_GET['act']=='clearmsg'){


    $group_id=$_GET['id'];
    $sql="select * from ".tname('group')." where id='{$group_id}' order by id desc";
    $group=$db->exec($sql);

    $db->query("delete from ".tname('chat')." where groupid='{$group_id}'");
    add_adminlog("清空群组[{$group['name']}]聊天记录");

    exit();
}
?>



<?php
$sql="select * from ".tname('group')." where 1=1 ";
if($_GET['name']) $sql.=" and name like '%{$_GET['name']}%'";
if(!$_GET['is_delete']) $_GET['is_delete']=0;
if(strlen($_GET['is_delete'])>0  and $_GET['is_delete']!='-1'){
    $sql.=" and is_delete='{$_GET['is_delete']}' ";
}

$sql.="order by sortnum asc,top desc, id desc";
$num=20;
$page=new Page($sql, $num, $_GET['page']);
$sql.=" limit $page->from,$num";

?>

<form id='formSort' enctype="multipart/form-data" action='group.php' method='get' style='min-height:50px;line-height:50px;padding-left:10px;'>

    群名称：<input type="text" name="name" value="<?php echo $_GET['name']; ?>" style="width:150px" >
    状态：<select name='is_delete' onchange="document.getElementById('formSort').submit();">
        <option value="-1"<?php if($_GET['is_delete']==-1) echo "selected";?>>不限</option>
        <option value='1' <?php if($_GET['is_delete']==1) echo "selected";?>>已解散</option>
        <option value="0" <?php if($_GET['is_delete']==0 and strlen($_GET['is_delete'])==1) echo "selected";?>>正常</option>






        <input class="btn01" type="submit" name="Submit" value="确定"  >


        <input class="btn00" type="button" name="button" value="更新排序"  onclick="document.querySelector('#sub_update').submit();" >

</form>


<form action="?act=sortnum" method="post" id="sub_update">


    <table width="100%" border="0" cellpadding="0" cellspacing="1" class="table_list">

        <tr>


            <th>排序</th>
            <th>ID</th>


            <th>头像</th>
            <th>群名称</th>

            <th>群主</th>
            <th>成员</th>

            <th>状态</th>
            <th>创建时间</th>





            <th>基本操作</th>

        </tr>


        <?php

        $query=$db->query($sql);
        while ($row=$db->fetch_array($query)){

            $creat=userinfo($row['createid']);
            $temp=explode(',',$row['user_id']);
            $friend_num=0;
            if(count($temp)>0){
                foreach ($temp as $value){
                    if($value>0) $friend_num++;
                }

            }


            ?>
            <tr>

                <td bgcolor="#FFFFFF">

                    <input type="text" class="sortnum" name="sortnum[<?php echo $row['id']?>]" value="<?php echo $row['sortnum']?>" style="width: 50px;">
                </td>

                <td height="30" bgcolor="#FFFFFF"><div align="center" class="STYLE1">

                        <div align="center"><?php echo $row['id']?></div>

                    </div>
                </td>
                <td bgcolor="#FFFFFF">
                    <img src="<?php echo $HttpPath.$row['avatar'] ?>" style="height: 50px; border-radius: 5px;"  onerror="this.src='../../uploads/group.jpg'">

                </td>
                <td bgcolor="#FFFFFF"><?php if($row['top']>0) echo '<span style="background-color:green;color: #fff;padding: 0px  5px;border-radius: 3px;">推荐</span>' ;echo $row['name'];?></td>
                <td bgcolor="#FFFFFF">
                    <a  onclick="layer.open({
                            type: 2,
                            title: '修改用户-<?php echo $creat['nickname'];?>',
                            maxmin: true,
                            shadeClose: true, //点击遮罩关闭层
                            area : ['800px' , '700px'],
                            content: 'add.php?id=<?php echo $creat['id']?>&action=edit&from=parent'
                            });" style="color:#2319dc;cursor: pointer;">

                        <?php echo $creat['nickname'];?>
                    </a>
                </td>




                <td  bgcolor="#FFFFFF" style="text-align: center">

                    <a  style="color: #2319dc;text-decoration:underline;cursor: pointer"
                        onclick="layer.open({
                                type: 2,
                                title: '<?php echo $row['nickname'];?>的成员',
                                maxmin: true,
                                shadeClose: true, //点击遮罩关闭层
                                area : ['600px' , '400px'],
                                content: 'group_user1.php?id=<?php echo $row['id']?>&from=parent'
                                });"> <?php
                        echo $friend_num;
                        ?>
                </td>



                <td bgcolor="#FFFFFF"><div align="center">
                        <?php
                        if($row['is_delete']==1) echo '已解散';else  echo  '正常';

                        ?>
                    </div></td>


                <td bgcolor="#FFFFFF"><div align="center">
                        <?php
                        echo date('Y-m-d H:i:s',$row['addtime'])?>
                    </div></td>




                <td bgcolor="#FFFFFF">


                    <?php
                    if($row['top']>0){
                        ?>

                        <a href='?id=<?php echo $row['id']?>&act=settop' class="button">取消推荐</a>

                        <?php
                    }else{
                        ?>

                        <a href='?id=<?php echo $row['id']?>&act=settop' class="button">推荐</a>
                        <?php
                    }
                    ?>


                    <?php
                    if($row['is_delete']==1){
                        ?>

                        <a href='?id=<?php echo $row['id']?>&act=delete' onClick="return(confirm('确定要删除吗?删除后不可恢复 '))"  class="button">删除</a>

                        <?php
                    }else{
                        ?>
                        <a class="button"        onclick="layer.open({
                                type: 2,
                                title: '修改<?php echo $row['name'];?>',
                                maxmin: true,
                                shadeClose: true, //点击遮罩关闭层
                                area : ['800px' , '520px'],
                                content: 'group_edit.php?id=<?php echo $row['id']?>&from=parent'
                                });">修改</a>
                        <a href='?id=<?php echo $row['id']?>&act=remove' onClick="return(confirm('确定要解散吗?解散后不可恢复 '))"  class="button">解散</a>
                        <?php
                    }
                    ?>
                    <a href='?id=<?php echo $row['id']?>&act=clearmsg' onClick="return(confirm('确定要清空该群所有聊天记录吗?不可恢复 '))"  class="button">清空记录</a>
                </td>

            </tr>
        <?php }?>
    </table>

</form>
<div class="page"><?php echo  $page->get_page();?></div>





<?php include_once '../inc/footer.php';?>

