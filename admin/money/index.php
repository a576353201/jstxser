<?php
include_once '../inc/header.php';

if($_GET['action']=='delete'){


	$db->query("delete  from ".tname('recharge')." where id='{$_GET['id']}'");

	promptMessage($_SERVER['HTTP_REFERER'], '删除成功');
	exit();
}
?>



  <?php
       if($_GET['username']) $str=" and uid in (select id from ".tname('user')." where name='{$_GET['username']}')";
     if($_GET['begintime']) $str.=" and  time>='".strtotime($_GET['begintime'].' 00:00:00')."'";
     if($_GET['endtime']) $str.=" and time<='".strtotime($_GET['endtime'].' 23:59:59')."'";
  if(strlen($_GET['type'])>0) $str.=" and type='{$_GET['type']}'";
     $sql="select * from ".tname('money')." where 1=1 {$str} order by id desc";
     $total=count($db->fetch_all($sql));
     $num=20;
   $page=new Page($sql, $num, $_GET['page']);
   $sql.=" limit $page->from,$num";

  ?>
   <form name='formSort' enctype="multipart/form-data" action="index.php" method="get"  style='height:50px;line-height:50px;padding-left:10px;'>



   用户名:<input type="text" name='username' value='<?php echo $_GET['username']?>'>

       <select name="type" style="height: 30px;line-height: 30px;border-radius: 5px;border: 1px solid #ddd;" onchange="document.querySelector('#sub').click();">
           <option value="">类型</option>

           <?php
           foreach ($recharge_type_arr as $index => $value) {
               ?>
               <option value="<?php echo $index;?>" <?php if($index==$_GET['type']) echo "selected";?>><?php echo $value;?></option>

               <?php
           }
           ?>
       </select>

         起止时间:<input type="text" name="begintime" autocomplete="off" value="<?php echo $_GET['begintime'];?>"  class="Wdate" type="text" onclick="WdatePicker({dateFmt:'yyyy-MM-dd',alwaysUseStartDate:false})"/>
	&nbsp;至

	 <input type="text" name="endtime"  value="<?php echo $_GET['endtime'];?>" autocomplete="off"  class="Wdate" type="text" onclick="WdatePicker({dateFmt:'yyyy-MM-dd',alwaysUseStartDate:false})" />&nbsp;

   <input type="submit" value='搜索' id="sub">

</form>

        <table width="100%" border="0" cellpadding="0" cellspacing="1" class="table_list">

          <tr>


            <th >用户ID</th>
  <th >用户名</th>

              <th >类型</th>
            <th >金额</th>




            <th >账户余额</th>


            <th >时间</th>
            <th >说明</th>


          </tr>


     <?php

     $query=$db->query($sql);
     while ($row=$db->fetch_array($query)){
     	$user=get_user_byid($row['uid']);


     ?>
        <tr>
            <td><?php echo $user['id'];?></td>
<td>    <a style="color: #2319dc;cursor:pointer;text-decoration: underline;"       onclick="layer.open({
            type: 2,
            title: ' <?php echo $user['name'];?>',
            maxmin: true,
            shadeClose: true, //点击遮罩关闭层
            area : ['800px' , '700px'],
            content: '../user/add.php?id=<?php echo $row['uid']?>&action=edit&from=parent'
            });">
        <?php echo $user['name'];?></a></td>
<td>

    <?php
    echo $recharge_type_arr[$row['type']];
    ?>
</td>

<td><?php if($row['money']>0)echo "<font color='red'>+".$row['money'].'</font>';else echo "<font color='green'>".$row['money'].'</font>';?></td>
            <td><?php echo $row['money1'];?></td>

          <td><?php echo date('Y-m-d H:i:s',$row['time'])?></td>
                   <td><?php echo $row['content'];?></td>


          </tr>

<?php }?>
        </table>


<div class="page" style="margin: 10px auto;"><?php echo  $page->get_page();?></div>

