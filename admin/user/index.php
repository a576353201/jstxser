<?php
include_once '../inc/header.php';



?>



<?php

$logintime=time()-$system['online_time'];

$row=$db->exec("select count(*) as num from ".tname('user')." where online>='{$logintime}'");
$loginnum=$row['num'];

     $sql="select * from ".tname('user')." where 1=1 ";
     if($_GET['name']) $sql.=" and name='$_GET[name]'";
if($_GET['nickname']) $sql.=" and nickname='$_GET[nickname]'";
if($_GET['mobile']) $sql.=" and nickname='$_GET[mobile]'";
          if($_GET['realname']) $sql.=" and realname like '%$_GET[realname]%'";
          if($_GET['id']) $sql.=" and (id='$_GET[id]' or number='{$_GET['id']}')";
if($_GET['pid']) $sql.=" and pid='$_GET[pid]'";

           if(strlen($_GET['isvip'])>0) $sql.=" and `isvip`='{$_GET['isvip']}'";
if(strlen($_GET['iskefu'])>0) $sql.=" and `iskefu`='{$_GET['iskefu']}'";
if(strlen($_GET['vip'])>0) $sql.=" and `vip`='{$_GET['vip']}'";
if(strlen($_GET['isdaili'])>0) $sql.=" and `isdaili`='{$_GET['isdaili']}'";
         //  else $sql.=" and   `kefu`='1' ";
if(strlen($_GET['isonline'])>0) {
    if($_GET['isonline']==1) $sql.=" and `online`>='{$logintime}'";
    else $sql.=" and (`online`<'{$logintime}'  or online is null)";

}

if($_GET['pid'])     $sql.=" and pid='{$_GET['pid']}'";




     $sql.="order by iskefu desc, regtime desc";
     $num=20;
   $page=new Page($sql, $num, $_GET['page']);
   $sql.=" limit $page->from,$num";

?>

   <form id='formSort' enctype="multipart/form-data" action='index.php' method='get' style='min-height:50px;line-height:40px;padding-left:10px;'>
       ID：<input type="text" name="id" value="<?php echo $_GET['id']; ?>" style="width:60px" >
       昵称：<input type="text" name="nickname" value="<?php echo $_GET['nickname']; ?>" style="width: 100px">
 用户名：<input type="text" name="name" value="<?php echo $_GET['name']; ?>" style="width: 100px" >
       手机号：<input type="text" name="mobile" value="<?php echo $_GET['mobile']; ?>" style="width: 100px" >
       当前在线人数：<?php echo $loginnum;?>
<br>


       客服：<select name='iskefu' onchange="document.getElementById('formSort').submit();">
           <option value="">不限</option>
           <option value='1' <?php if($_GET['iskefu']==1) echo "selected";?>>是</option>
           <option value="0" <?php if($_GET['iskefu']==0 and strlen($_GET['iskefu'])==1) echo "selected";?>>否</option>
       </select>

       VIP：<select name='vip' onchange="document.getElementById('formSort').submit();" >
           <option value="">不限</option>
           <option value='1' <?php if($_GET['vip']==1) echo "selected";?>>是</option>
           <option value="0" <?php if($_GET['vip']==0 and strlen($_GET['vip'])==1) echo "selected";?>>否</option>
       </select>

       代理：<select name='isdaili' onchange="document.getElementById('formSort').submit();">
           <option value="">不限</option>
           <option value='1' <?php if($_GET['isdaili']==1) echo "selected";?>>是</option>
           <option value="0" <?php if($_GET['isdaili']==0 and strlen($_GET['isdaili'])==1) echo "selected";?>>否</option>
       </select>
       在线状态：<select name='isonline' onchange="document.getElementById('formSort').submit();">
           <option value="">不限</option>
           <option value='1' <?php if($_GET['isonline']==1) echo "selected";?>>是</option>
           <option value="0" <?php if($_GET['isonline']==0 and strlen($_GET['isonline'])==1) echo "selected";?>>否</option>


       </select>





                       <input class="btn01" type="submit" name="Submit" value="确定"  >



       <a  class="button" style="float: right"
          onclick="layer.open({
                  type: 2,
                  title: '新增用户',
                  maxmin: true,
                  shadeClose: true, //点击遮罩关闭层
                  area : ['800px' , '520px'],
                  content: 'add.php?action=add&from=parent'
                  });">新增用户</a>

</form>



        <table width="100%" border="0" cellpadding="0" cellspacing="1" class="table_list">

          <tr>



            <th>ID</th>


              <th>头像</th>
            <th>用户名</th>

              <th>手机号</th>
              <th>账户余额</th>

              <th>
   昵称</th>
    <th>
   性别</th>


              <th>
                  好友数量</th>
              <th>
   群组数量</th>
              <th>用户类型</th>
              <th>登录状态</th>
              <th>账户状态</th>
              <th>最近登录</th>
            <th>注册时间</th>




            <th>基本操作</th>

          </tr>


     <?php

     $query=$db->query($sql);
     while ($row=$db->fetch_array($query)){

      $user=userinfo($row['id']);
      $temp=$db->exec("select count(*) as num from ".tname('friend')." where userid='{$user['id']}'");
      $friend_num=$temp['num'];

         $temp=$db->exec("select count(*) as num from ".tname('group')." where user_id like '%{$row['id']}%' and is_delete='0'");
         $group_num=$temp['num'];
         if($user['online']<$logintime) $online=0;else $online=1;

     ?>
          <tr>



            <td height="30" bgcolor="#FFFFFF"><div align="center" class="STYLE1">

              <div align="center"><?php echo $user['number']?></div>

            </div>
            </td>
              <td bgcolor="#FFFFFF">
                  <img src="<?php echo $user['avatar'] ?>" style="height: 50px; border-radius: 5px;" onerror="this.src='../../uploads/avatar.jpg'">

              </td>
              <td bgcolor="#FFFFFF"><?php echo $row['name'];?></td>
              <td bgcolor="#FFFFFF"><?php echo $row['mobile'];?></td>

              <td bgcolor="#FFFFFF">
                  <a  style="color: #2319dc;text-decoration:underline;cursor: pointer"
                      onclick="layer.open({
                              type: 2,
                              title: '向【<?php echo $row['nickname'];?>】充值',
                              maxmin: true,
                              shadeClose: true, //点击遮罩关闭层
                              area : ['450px' , '270px'],
                              content: 'money_add.php?id=<?php echo $row['id']?>&from=parent'
                              });"> <?php
                      echo $user['money'];
                      ?>
                  </a>
              </td>

              <td bgcolor="#FFFFFF"><?php echo $row['nickname'];?></td>



 <td bgcolor="#FFFFFF"><?php if ($row['sex']==1) echo '男';else if($row['sex']==2) echo '女';else echo '未知';?></td>


              <td  bgcolor="#FFFFFF" style="text-align: center">
                  <a  style="color: #2319dc;text-decoration:underline;cursor: pointer"
                      onclick="layer.open({
                              type: 2,
                              title: '<?php echo $row['nickname'];?>-联系人',
                              maxmin: true,
                              shadeClose: true, //点击遮罩关闭层
                              area : ['800px' , '520px'],
                              content: 'friend.php?id=<?php echo $row['id']?>&from=parent'
                              });"> <?php
                      echo $friend_num;
                      ?>
                  </a>

              </td>
              <td bgcolor="#FFFFFF">
                  <a  style="color: #2319dc;text-decoration:underline;cursor: pointer"
                      onclick="layer.open({
                              type: 2,
                              title: '<?php echo $row['nickname'];?>-加入的群组',
                              maxmin: true,
                              shadeClose: true, //点击遮罩关闭层
                              area : ['600px' , '400px'],
                              content: 'group_user.php?id=<?php echo $row['id']?>&from=parent'
                              });"> <?php
                      echo $group_num;
                      ?>
                  </a>
                      </td>
              <td bgcolor="#FFFFFF">

                  <?php if ($row['vip']>0) echo '<span class="btn_yellow">VIP</span>';?>

                  <?php if ($row['isdaili']==1) echo '<span class="btn_blue">代理</span>';else echo  '<span class="btn_grey">用户</span>';?>
                  <?php
                  if($row['iskefu']==1) echo "<span class='btn_yellow'>客服</span>";
                  ?>
              </td>
              <td bgcolor="#FFFFFF"><?php if ($online==1) echo "<span style=\"background-color: green;color: #fff;padding: 0px  5px;border-radius: 3px;\">在线</span>";else  echo '离线';?></td>

              <td bgcolor="#FFFFFF"><?php
                  echo $status_array[$row['status']];
                  ;?></td>

            <td bgcolor="#FFFFFF"><div align="center">
            <?php
            if($row['logintime']>0)echo date('Y-m-d H:i',$row['logintime']);else echo '-';?>
            </div></td>

              <td bgcolor="#FFFFFF"><div align="center">
                      <?php
                      echo date('Y-m-d H:i',$row['regtime'])?>
                  </div></td>




            <td bgcolor="#FFFFFF">

                    <a class="button"
                       onclick="layer.open({
                               type: 2,
                               title: '向<?php echo $row['name'];?>发送消息',
                               maxmin: true,
                               shadeClose: true, //点击遮罩关闭层
                               area : ['500px' , '300px'],
                               content: 'msg_add.php?id=<?php echo $row['id']?>&from=parent'
                               });">发送消息</a>

          <a class="button"        onclick="layer.open({
                  type: 2,
                  title: '修改用户',
                  maxmin: true,
                  shadeClose: true, //点击遮罩关闭层
                  area : ['800px' , '700px'],
                  content: 'add.php?id=<?php echo $row['id']?>&action=edit&from=parent'
                  });">修改</a>

            <a href='action.php?id=<?php echo $row['id']?>&action=delete&from=user' onClick="return(confirm('确定要删除吗?删除后不可恢复 '))" class="button">删除</a>

            </td>

          </tr>
<?php }?>
        </table>

            <div class="page"><?php echo  $page->get_page();?></div>

<style>
    .btn_yellow{
        background-color: yellow;
        color: #000;
        font-size: 12px;
        display: inline-block;
        height:18px;
        line-height: 18px;
        padding: 0px 5px;
        border-radius: 5px;
        text-align: center;
    }
    .btn_green{
        background-color: #0aad6c;
        color: #fff;font-size: 12px;
        display: inline-block;
        height: 18px;
        line-height: 18px;
        padding: 0px 5px;
        border-radius: 5px;
        text-align: center;
    }
    .btn_blue{
        background-color: #2319dc;
        color: #fff;font-size: 12px;
        display: inline-block;
        height: 18px;
        line-height: 18px;
        padding: 0px 5px;
        border-radius: 5px;
        text-align: center;
    }

    .btn_grey{
        background-color: #ddd;
        color: #000;font-size: 12px;
        display: inline-block;
        height: 12px;
        line-height: 12px;
        padding: 2px 5px;
        border-radius: 5px;
        text-align: center;

    }
</style>



<?php include_once '../inc/footer.php';?>

