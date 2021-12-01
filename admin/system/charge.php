<?php
include_once '../inc/header.php';


?>

<a onclick="layer.open({
      type: 2,
      title: '新增付款渠道',
      maxmin: true,
      shadeClose: true, //点击遮罩关闭层
      area : ['600px' , '400px'],
      content: 'charge_add.php?from=parent'
    });" class="btn01">新增付款渠道</a>
   <form name='formSort' enctype="multipart/form-data" action="action.php?from=charge&action=sort"method="post">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">


      <tr>



       
            <td  bgcolor="#FFFFFF"><div align="center"><span class="STYLE1">银行名称</span></div></td>

          <td  bgcolor="#FFFFFF"><div align="center"><span class="STYLE1">渠道名称</span></div></td>

            <td  bgcolor="#FFFFFF"><div align="center"><span class="STYLE1">开户姓名</span></div></td>
            <td   bgcolor="#FFFFFF" style="width: 10%"><div align="center"><span class="STYLE1">汇款账号</span></div></td>
          <td bgcolor="#FFFFFF"><div align="center"><span class="STYLE1">单笔最低</span></div></td>
          <td bgcolor="#FFFFFF"><div align="center"><span class="STYLE1">单笔最高</span></div></td>
          <td bgcolor="#FFFFFF"><div align="center"><span class="STYLE1">手续费</span></div></td>
          <td bgcolor="#FFFFFF"><div align="center"><span class="STYLE1">状态</span></div></td>
            <td   bgcolor="#FFFFFF" class="STYLE1"><div align="center">基本操作</div></td>

          </tr>

       
     <?php 
     $sql="select * from ".tname('charge')." where 1=1 order by id desc";
     $num=20;
   $page=new Page($sql, $num, $_GET['page']);
     $query=$db->query($sql);
     while ($row=$db->fetch_array($query)){
     ?>
        <tr>

            <td height="20" bgcolor="#FFFFFF" style="padding-left:5px;" align='center'><?php echo $bank_arr1[$row['bank']];?></td>
            <td height="20" bgcolor="#FFFFFF" style="padding-left:5px;" align='center'><?php echo $row['title'];?></td>
            <td height="20" bgcolor="#FFFFFF" style="padding-left:5px;" align='center'>
           <?php echo $row['realname'];?></td>
            <td height="20" bgcolor="#FFFFFF" style="padding-left:5px;" align='center'>
           <?php echo $row['number'];?></td>
            <td height="20" bgcolor="#FFFFFF" style="padding-left:5px;" align='center'>
                <?php echo $row['min'];?>元</td>
            <td height="20" bgcolor="#FFFFFF" style="padding-left:5px;" align='center'>
                <?php echo $row['max'];?>元</td>
            <td height="20" bgcolor="#FFFFFF" style="padding-left:5px;" align='center'>
                <?php echo $row['fee'];?>%</td>

            <td height="20" bgcolor="#FFFFFF" style="padding-left:5px;" align='center'>
                <?php if($row['status']==1) echo "启用" ;else echo '关闭';?></td>
            <td height="20" bgcolor="#FFFFFF">
            <div align="center"><span class="STYLE4">
        
                  <a
                          onclick="layer.open({
                                  type: 2,
                                  title: '汇款渠道',
                                  maxmin: true,
                                  shadeClose: true, //点击遮罩关闭层
                                  area : ['600px' , '400px'],
                                  content: 'charge_add.php?id=<?php echo $row['id']?>&action=edit&from=parent'
                                  });"
                         ><img src="../style/images/content/edt.gif" width="16" height="16" />编辑</a>&nbsp; &nbsp;
            <a href='action.php?from=charge&id=<?php echo $row['id']?>&action=delete' onClick="return(confirm('确定要删除吗?删除后不可恢复 '))"><img src="../style/images/content/del.gif" width="16" height="16" />删除</a></span></div></td>

          </tr>
      
<?php }?>
        </table>

</form>
<?php include_once '../inc/footer.php';?>

