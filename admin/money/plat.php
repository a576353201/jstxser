<?php
include_once '../inc/header.php';

if($_GET['action']=='delete'){


	$db->query("delete  from ".tname('plat')." where id='{$_GET['id']}'");

	promptMessage($_SERVER['HTTP_REFERER'], '删除成功');
	exit();
}
?>

  <?php

           if($_GET['username']) $str=" and uid in (select id from ".tname('user')." where name='{$_GET['username']}')";
     if($_GET['begintime']) $str.=" and  time>='".strtotime($_GET['begintime'].' 00:00:00')."'";
     if($_GET['endtime']) $str.=" and time<='".strtotime($_GET['endtime'].' 23:59:59')."'";
     if(isset($_GET['status']) and $_GET['status']!='-1') $str.=" and status='{$_GET['status']}'";

     $sql="select * from ".tname('plat')." where  uid in (select id from ".tname('user').") {$str} order by id desc";
          $total=count($db->fetch_all($sql));
  ?>

   <form name='formSort' enctype="multipart/form-data" action="plat.php" method="get"  style='height:50px;line-height:50px;padding-left:10px;'>



   用户名:<input type="text" name='username' value='<?php echo $_GET['username']?>'>
         起止时间:<input type="text" name="begintime"  value="<?php echo $_GET['begintime'];?>" autocomplete="off"  class="Wdate" type="text" onclick="WdatePicker({dateFmt:'yyyy-MM-dd',alwaysUseStartDate:false})"/>
	&nbsp;至

	 <input type="text" name="endtime"  value="<?php echo $_GET['endtime'];?>" autocomplete="off"  class="Wdate" type="text" onclick="WdatePicker({dateFmt:'yyyy-MM-dd',alwaysUseStartDate:false})" />&nbsp;
  状态：
  <select name='status'>
  <option value='-1'>不限</option>
  <?php
  foreach ($plat_status as $key=> $value) {

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

   <input type="submit" value='搜索'>

</form>
  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table_list">


          <tr>


            <th >提现用户</th>

            <th >汇款金额</th>
              <th >手续费</th>



            <th >汇款方式</th>


            <th >开户人名称</th>
            <th >汇款账号</th>

            <th >汇款编码</th>



            <th >提现时间</th>


            <th  class="STYLE1"><div align="center">基本操作</div></th>

          </tr>


     <?php

     $num=20;
   $page=new Page($sql, $num, $_GET['page']);
      $sql.=" limit $page->from,$num";
     $query=$db->query($sql);
     while ($row=$db->fetch_array($query)){
     	$user=get_user_byid($row['uid']);
     	$bank=unserialize($row['bank']);

     ?>
        <tr>

<td>
    <a style="color: #2319dc;cursor:pointer;text-decoration: underline;"       onclick="layer.open({
            type: 2,
            title: ' <?php echo $user['name'];?>',
            maxmin: true,
            shadeClose: true, //点击遮罩关闭层
            area : ['800px' , '700px'],
            content: '../user/add.php?id=<?php echo $row['uid']?>&action=edit&from=parent'
            });">
        <?php echo $user['name'];?></a></td>

<td><?php echo $row['money'];?>元</td>
            <td><?php echo $row['fee'];?>元</td>
            <td><?php echo $bank['bankname'];?></td>
            <td>
           <?php echo $bank['realname'];?></td>
            <td>
           <?php echo $bank['banknum'];?></td>


          <td class="color-<?php echo $row['status']; ?>"><?php echo $plat_status[$row['status']];?></td>
          <td><?php echo date('Y-m-d H:i:s',$row['time'])?></td>

            <td height="30" bgcolor="#FFFFFF">
            <div align="center"><span class="STYLE4">

                  <a  onclick="layer.open({
                          type: 2,
                          title: '提现详情',
                          maxmin: true,
                          shadeClose: true, //点击遮罩关闭层
                          area : ['500px' , '550px'],
                          content: 'plat_info.php?id=<?php echo $row['id']?>&action=edit&from=parent'
                          });"
                      ><img src="../style/images/content/edt.gif" width="16" height="16" />详情</a>&nbsp; &nbsp;

                         <a  onclick="layer.open({
                                 type: 2,
                                 title: '账单流水-<?php echo $user['name']?>',
                                 maxmin: true,
                                 shadeClose: true, //点击遮罩关闭层
                                 area : ['1000px' , '600px'],
                                 content: 'index.php?username=<?php echo $user['name']?>&from=parent'
                                 });"
                         ><img src="../style/images/content/edt.gif" width="16" height="16" />账单</a>&nbsp; &nbsp;
           <?php
           if($row['status']>0){
           ?>

            <a href='plat.php?id=<?php echo $row['id']?>&action=delete' onClick="return(confirm('确定要删除吗?删除后不可恢复 '))"><img src="../style/images/content/del.gif" width="16" height="16" />删除</a>

            <?php }?>
            </span>


            </div></td>

          </tr>

<?php }?>
        </table>

</form>
<div class="page" style="margin: 10px auto;"><?php echo  $page->get_page();?></div>
<?php include_once '../inc/footer.php';?>

