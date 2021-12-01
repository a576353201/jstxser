<?php
include_once '../inc/header.php';

if($_GET['action']=='delete'){


	$db->query("delete  from ".tname('recharge')." where id='{$_GET['id']}'");

	promptMessage($_SERVER['HTTP_REFERER'], '删除成功');
	exit();
}

if($_GET['action']=='set'){

   if($_GET['status1']==1){
       agree_recharge($_GET['id']);
   }
   else{
       $data=array();
       $data['agreetime']=time();
   $data['status']=2;
    $db->update(tname('recharge'), $data, $_GET['id']);
   }
//    $db->query("delete  from ".tname('recharge')." where id='{$_GET['id']}'");

}

?>


   <form name='formSort' enctype="multipart/form-data" action="recharge.php" method="get"  style='height:50px;line-height:50px;padding-left:10px;'>



   用户名:<input type="text" name='username' value='<?php echo $_GET['username']?>'>
         起止时间:<input type="text" name="begintime"  value="<?php echo $_GET['begintime'];?>"  autocomplete="off"   class="Wdate" type="text" onclick="WdatePicker({dateFmt:'yyyy-MM-dd',alwaysUseStartDate:false})"/>
	&nbsp;至

	 <input type="text" name="endtime"  value="<?php echo $_GET['endtime'];?>"  autocomplete="off"   class="Wdate" type="text" onclick="WdatePicker({dateFmt:'yyyy-MM-dd',alwaysUseStartDate:false})" />&nbsp;
  状态：
  <select name='status' onchange="document.querySelector('#sub').click();">
  <option value='-2'>不限</option>
  <?php
  foreach ($recharge_status as $key=> $value) {

  	if($key==$_GET['status'] and isset($_GET['status'])){

  		$select='selected';
  	}
  	else $select='';
  	?>
  	<option value='<?php echo $key;?>' <?php echo $select;?>><?php echo $value;?></option>

  	<?php
  }
  ?>
  </select>

   <input type="submit" value='搜索' id="sub">

</form>
  <table width="100%" border="0" cellspacing="0" cellpadding="0"  class="table_list">


          <tr>


            <th>充值用户</th>


            <th>金额</th>
              <th>手续费</th>



            <th>支付方式</th>




            <th>状态</th>


            <th>充值时间</th>


            <th>基本操作</th>

          </tr>


     <?php
          if($_GET['username']) $str=" and uid in (select id from ".tname('user')." where name='{$_GET['username']}')";
     if($_GET['begintime']) $str.=" and  time>='".strtotime($_GET['begintime'].' 00:00:00')."'";
     if($_GET['endtime']) $str.=" and time<='".strtotime($_GET['endtime'].' 23:59:59')."'";
     if(isset($_GET['status']) and $_GET['status']!='-2') $str.=" and status='{$_GET['status']}'";
//else $str.=" and status!='-1'";
     $sql="select * from ".tname('recharge')." where 1=1 {$str} order by id desc";

     $num=20;
   $page=new Page($sql, $num, $_GET['page']);
      $sql.=" limit $page->from,$num";
     $query=$db->query($sql);
     while ($row=$db->fetch_array($query)){
     	$user=get_user_byid($row['uid']);
     	$bank=unserialize($row['bank']);

     	$bank1=$db->exec("select * from ".tname('bank')." where uid='{$row['uid']}'");
     ?>
        <tr>

<td>    <a style="color: #2319dc;cursor:pointer;text-decoration: underline;"       onclick="layer.open({
            type: 2,
            title: ' <?php echo $user['name'];?>',
            maxmin: true,
            shadeClose: true, //点击遮罩关闭层
            area : ['800px' , '700px'],
            content: '../user/add.php?id=<?php echo $row['uid']?>&action=edit&from=parent'
            });">
        <?php echo $user['name'];?></a></td>

<td><?php echo $row['money'];?></td>
            <td><?php echo $row['fee'];?></td>
            <td><?php echo $row['bank'];?></td>

          <td class="color-<?php echo $row['status'];?>"><?php echo $recharge_status[$row['status']];?></td>
          <td><?php echo date('Y-m-d H:i:s',$row['addtime'])?></td>

            <td height="30" bgcolor="#FFFFFF">
            <div align="center"><span class="STYLE4">


                    <?php
                    if($row['status']<1){
                        ?>
                       <input type="button" class="button" value="已到账" onclick="location.href='recharge.php?id=<?php echo $row['id']?>&action=set&status1=1'">

                        <input type="button" class="button" value="未到账"  onclick="location.href='recharge.php?id=<?php echo $row['id']?>&action=set&status1=2'">
                    <?php
                    }
                    else{
                        ?>
                        <a href='recharge.php?id=<?php echo $row['id']?>&action=delete' onClick="return(confirm('确定要删除吗?删除后不可恢复 '))"><img src="../style/images/content/del.gif" width="16" height="16" />删除</a>

                        <?php
                    }
                    ?>


            </span>


            </div></td>

          </tr>

<?php }?>
        </table>
</form>
<div class="page" style="margin: 10px auto;"><?php echo  $page->get_page();?></div>
<?php include_once '../inc/footer.php';?>


