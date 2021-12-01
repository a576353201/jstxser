<?php
include_once '../inc/header.php';

if($_GET['act']=='delete'){
    $db->query("delete from ".tname('circle')." where id='{$_GET['id']}'");
    add_adminlog('删除了一条朋友圈');

}

?>



<?php



$sql="select * from ".tname('circle')." where 1=1 ";
if($_GET['fromname']) $sql.=" and userid in (select id from ".tname('user')." where (name='{$_GET['fromname']}' or nickname='{$_GET['fromname']}')) ";



$sql.="order by id desc";
$num=20;
$page=new Page($sql, $num, $_GET['page']);
$sql.=" limit $page->from,$num";

?>

<form id='formSort' enctype="multipart/form-data" action='index.php' method='get' style='min-height:50px;line-height:50px;padding-left:10px;'>

    用户：<input type="text" name="name" value="<?php echo $_GET['name']; ?>" style="width: 80px" >





    <input class="btn01" type="submit" name="Submit" value="确定"  >

</form>



<table width="100%" border="0" cellpadding="0" cellspacing="1" class="table_list">

    <tr>






        <th>头像</th>
        <th>用户</th>

        <th style="width: 400px;">
            描述</th>
        <th>
            图片</th>

        <th>点赞数量</th>
        <th>评论数量</th>

        <th>发布时间</th>




        <th>基本操作</th>

    </tr>


    <?php

    $query=$db->query($sql);
    while ($row=$db->fetch_array($query)){

        $user=userinfo($row['userid']);

        $like_num=count(unserialize($row['like']));
        $comment_num=count(unserialize($row['comment']));
       $imgs=unserialize($row['value']);
        ?>
        <tr>



            <td bgcolor="#FFFFFF">
                <img src="<?php echo $HttpPath.$user['avatar'] ?>" style="height: 50px; border-radius: 5px;" onerror="this.src='../../uploads/avatar.jpg'">

            </td>

            <td bgcolor="#FFFFFF"><?php echo $user['nickname'];?></td>



            <td bgcolor="#FFFFFF">
                <?php echo $row['text']?>
            </td>

            <td bgcolor="#FFFFFF">
                <?php
                if(count($imgs)>0){
                    foreach ($imgs as $v){
                        ?>
               <img src="<?php  echo $HttpPath.$v;?>" onclick="showimg(this.src);" style="max-height:50px;padding: 0px 10px;vertical-align: middle">
                <?php
                    }
                }
                ?>
            </td>

            <td  bgcolor="#FFFFFF" style="text-align: center">
            <?php
            echo $like_num;
            ?>

            </td>
            <td bgcolor="#FFFFFF">
                <?php
                echo $comment_num;
                ?>
            </td>

            <td bgcolor="#FFFFFF"><div align="center">
                    <?php
                  echo date('Y-m-d H:i:s',$row['time']);?>
                </div></td>




            <td bgcolor="#FFFFFF">

                <a class="button"        onclick="layer.open({
                    type: 2,
                    title: '详情',
                    maxmin: true,
                    shadeClose: true, //点击遮罩关闭层
                    area : ['500px' , '300px'],
                    content: 'circle_info.php?id=<?php echo $row['id']?>&from=parent'
                    });">详情</a>

                <a href='circle.php?id=<?php echo $row['id']?>&act=delete' onClick="return(confirm('确定要删除吗?删除后不可恢复 '))" class="button">删除</a>

            </td>

        </tr>
    <?php }?>
</table>

<div class="page"><?php echo  $page->get_page();?></div>

<script>
    function showimg(src) {
        var img = "<img src='"+src+"' />";
        layer.open({
            type:1,
            shift: 2,
            maxmin: true,
            shadeClose: true,
            title:'查看图片',

            content:img
        });


    }

</script>



<?php include_once '../inc/footer.php';?>

