<?php
include_once '../inc/header.php';


?>

<a onclick="layer.open({
      type: 2,
      title: '新增发现链接',
      maxmin: true,
      shadeClose: true, //点击遮罩关闭层
      area : ['600px' , '400px'],
      content: 'flink_add.php?from=parent'
    });" class="btn01">新增发现链接</a>
   <form name='formSort' enctype="multipart/form-data" action="action.php?from=flink&action=sort"method="post">
       <table width="100%" border="0" cellpadding="0" cellspacing="10" class="table_list" style="margin-left:3px;">




          <tr>


            <th width="7%" height="22" ><div align="center"><span class="STYLE1">排序</span></div></th>
            <th width="5%" height="22" ><div align="center"><span class="STYLE1">Logo</span></div></th>

            <th width="20%" height="22" ><div align="center"><span class="STYLE1">名称</span></div></th>



                        <th  ><div align="center"><span class="STYLE1">链接</span></div></th>
              <th  ><div align="center"><span class="STYLE1">显示位置</span></div></th>
              <th  ><div align="center"><span class="STYLE1">是否显示</span></div></th>
            <th width="15%" height="22"  class="STYLE1"><div align="center">基本操作</div></th>

          </tr>

       
     <?php
     $arr11=array('Android','iOS','H5','PcWeb');

     $sql="select * from ".tname('flink')." where 1 order by sortnum asc,id desc";
     $num=20;
   $page=new Page($sql, $num, $_GET['page']);
     $query=$db->query($sql);
     while ($row=$db->fetch_array($query)){
     ?>
        <tr>
<td height="20" bgcolor="#FFFFFF" style="padding-left:2px;">
                   <input type="text" name="sortnum[<?php echo $row['id'];?>]" style="width: 60px" value="<?php echo $row['sortnum'];?>">
                   </td>

            <td height="30" bgcolor="#FFFFFF"><div align="center" class="STYLE1">

              <div align="center">

                  <img src="../../<?php echo $row['logo'];?>" style="height: 45px;" />

              </div>

            </div>
            </td>

            <td height="20" bgcolor="#FFFFFF" style="padding-left:5px;" align='center'><?php echo $row['title'];?></td>
            <td height="20" bgcolor="#FFFFFF" style="padding-left:5px;" align='center'><a href='<?php echo $row['url']?>' target="_blank"><?php echo $row['url'];?></a></td>
            <td height="20" bgcolor="#FFFFFF" style="padding-left:5px;" align='center'>

                <?php
                $showtype=unserialize($row['showtype']);
                if(count($showtype)>0){
                    foreach ($showtype as $v){
                        echo $v."&nbsp;";
                    }
                }
                else{
                    echo '-';
                }
                ?>

            </td>


            <td height="20" bgcolor="#FFFFFF" style="padding-left:5px;" align='center'><?php if($row['status']==1) echo '显示';else echo '隐藏';?></td>
            

            <td height="20" bgcolor="#FFFFFF">
            <div align="center"><span class="STYLE4">
        
                  <a
                     onclick="layer.open({
      type: 2,
      title: '友情链接',
      maxmin: true,
      shadeClose: true, //点击遮罩关闭层
      area : ['600px' , '400px'],
      content: 'flink_add.php?id=<?php echo $row['id']?>&action=edit&from=parent'
    });"
                  ><img src="../style/images/content/edt.gif" width="16" height="16" />编辑</a>&nbsp; &nbsp;
            <a href='action.php?from=flink&id=<?php echo $row['id']?>&action=delete' onClick="return(confirm('确定要删除吗?删除后不可恢复 '))"><img src="../style/images/content/del.gif" width="16" height="16" />删除</a></span></div></td>

          </tr>
      
<?php }?>
        </table>
 

</form>
<?php include_once '../inc/footer.php';?>

