<?php
include_once '../inc/header.php';


?>


<script>
var player_group = new Array();
<?php
foreach($player_group as $key=>$value){
?>
player_group[<?php echo $key;?>]='<?php echo $system['player_group_'.$key];?>';

<?php
}
?>

function change_group(value){


     var str=player_group[value];
     var arr=str.split('|');
     var html="<select name='player[group2]'>";
 html+="<option value=''>不限</option>";
     for(var i=0;i<arr.length;i++){

     html+="<option value='"+arr[i]+"'>"+arr[i]+"</option>";

     }

     html+="</select>";

document.getElementById('group2').innerHTML=html;
}




</script>
<script type="text/javascript" src="<?php echo $HttpPath;?>static/js/script_area.js"></script>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="titlebg">

      <tr>

        <td width="12" height="30"><img src="../style/images/content/tab_03.gif" width="12" height="30" /></td>

        <td>


         <div style='float:left' ><img src="../style/images/content/tb.gif" width="16" height="16" /></div>

         <div style='float:left'  class="STYLE1">
         <form action='index.php' method='get'>
         <span class="STYLE3">当前位置:</span>裁判员管理&nbsp; &nbsp;&nbsp; &nbsp;

         </form>
         </div>

        </td>

        <td width="16"><img src="../style/images/content/tab_07.gif" width="16" height="30" /></td>

      </tr>

  </table>
<?php
     $sql="select * from ".tname('user')." where `sub`=1 ";
     if($_GET['name']) $sql.=" and name='$_GET[name]'";
          if($_GET['realname']) $sql.=" and realname like '%$_GET[realname]%'";
          if($_GET['playerid']) $sql.=" and playerid='$_GET[playerid]'";


          		$sql.=" and `group`='3'";

          if(strlen($_GET['agree'])>0) $sql.=" and `agree`='{$_GET['agree']}'";
 if(strlen($_GET['update'])>0) $sql.=" and `update`='{$_GET['update']}'";
     if($_GET['status']) {$_GET[status]=$_GET[status]-2;$sql.=" and `status`='$_GET[status]'";}



     if($_GET['sex']) $sql.=" and `sex`='$_GET[sex]'";

     if($_GET['begindate']){
     	$sql.=" and birth>='{$_GET['begindate']}'";
     }

          if($_GET['enddate']){
     	$sql.=" and birth<='{$_GET['enddate']}'";
     }

if($_GET['playkinds']) $sql.=user_search('player','playkinds',$_GET['playkinds']);
if($_GET['player_group']) $sql.=user_search('player','group',$_GET['player_group']);
if($_GET['player_group2']) $sql.=user_search('player','group2',$_GET['player_group2']);

if($_GET['birthprovince']) $sql.=user_search('address','birthprovince',$_GET['birthprovince']);
if($_GET['birthcity']) $sql.=user_search('address','birthcity',$_GET['birthcity']);
if($_GET['birthcountry']) $sql.=user_search('address','birthcountry',$_GET['birthcountry']);

if($_GET['resideprovince']) $sql.=user_search('address','resideprovince',$_GET['resideprovince']);
if($_GET['residecity']) $sql.=user_search('address','residecity',$_GET['residecity']);
if($_GET['residecountry']) $sql.=user_search('address','residecountry',$_GET['residecountry']);

     $total=count($db->fetch_all($sql));




     $sql.="order by id desc";
     $num=20;
   $page=new Page($sql, $num, $_GET['page']);
   $sql.=" limit $page->from,$num";

?>

   <form name='formSort' enctype="multipart/form-data" action='index2.php' method='get' style='min-height:50px;line-height:50px;padding-left:10px;'>

            手机号：<input type="text" name="name" value="<?php echo $_GET['name']; ?>" >
真实姓名3：<input type="text" name="realname" value="<?php echo $_GET['realname']; ?>" >
编号：<input type="text" name="playerid" value="<?php echo $_GET['playerid']; ?>" >

审核：<select name='update'>
<option value=''>不限</option>
<?php  foreach($update_status as $key=>$value){





	?>
	<option value='<?php echo $key;?>'  <?php if ($key==$_GET['update'] and strlen($_GET['update'])>0 ) echo "selected";?>><?php echo $value; ?></option>

	<?php

}?>

</select>


<br>
性别：
<select name='sex' id='sex'>
<option value=''>不限</option>
<option value='1'  <?php if ($_GET['sex']=='1') echo "selected";?> >男</option>
<option value='2' <?php if ($_GET['sex']=='2') echo "selected";?> >女</option>

</select>



<span   id='group2'>
<?php

if($_GET['player_group2']){

$arr= explode('|',$system['player_group_'.$_GET['player_group']]);
?>

<select name='player_group2'>
<?php
foreach($arr as $value) {

?>
<option value='<?php echo $value;?>' <?php if($value==$_GET['player_group2']) echo "selected";?> ><?php echo $value;?></option>
<?php
}
?>

</select>
<?php }?>
</span>

&nbsp;&nbsp;
出生日期（格式:yyyy-mm-dd）：
<input type='text' class='Wdate input1' id='begindate' name='begindate' value='<?php echo $_GET['begindate'];?>'  onclick="WdatePicker({dateFmt:'yyyy-MM-dd',alwaysUseStartDate:false})">
-
<input type='text' class='Wdate input1' id='enddate' name='enddate' value='<?php echo $_GET['enddate'];?>'  onclick="WdatePicker({dateFmt:'yyyy-MM-dd',alwaysUseStartDate:false})">



                       <input class="btn01" type="submit" name="Submit" value="搜 索"  >



</form>



        <table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="b5d6e6" onmouseover="changeto()"  onmouseout="changeback()">

          <tr>



            <td bgcolor="#FFFFFF"><div align="center"><span class="STYLE1">ID</span></div></td>




            <td bgcolor="#FFFFFF"><div align="center"><span class="STYLE1">手机号码</span></div></td>

            <td bgcolor="#FFFFFF"><div align="center"><span class="STYLE1">编号</span></div></td>
    <td bgcolor="#FFFFFF"><div align="center"><span class="STYLE1">
  姓名</span></div></td>

      <td bgcolor="#FFFFFF"><div align="center"><span class="STYLE1">
年龄</span></div></td>
    <td bgcolor="#FFFFFF"><div align="center"><span class="STYLE1">
  性别</span></div></td>
      <td bgcolor="#FFFFFF"><div align="center"><span class="STYLE1">审核</span></div></td>
            <td bgcolor="#FFFFFF"><div align="center"><span class="STYLE1"> 注册时间</span></div></td>



            <td  bgcolor="#FFFFFF" class="STYLE1"><div align="center">基本操作</div></td>

          </tr>


     <?php

     $query=$db->query($sql);
     while ($row=$db->fetch_array($query)){


	if($row['birth']){

	$age=date('Y')-substr($row['birth'],0,4);

	}


     ?>
          <tr>



            <td height="30" bgcolor="#FFFFFF"><div align="center" class="STYLE1">

              <div align="center"><?php echo $row['id']?></div>

            </div>
            </td>

            <td height="20" bgcolor="#FFFFFF"><div align="center"><span class="STYLE1"><?php echo $row['name'];?></span></div></td>

              <td height="20" bgcolor="#FFFFFF"><div align="center"><span class="STYLE1"><?php echo $row['playerid'];?></span></div></td>

 <td height="20" bgcolor="#FFFFFF"><div align="center"><span class="STYLE1"><?php echo $row['realname'];?></span></div></td>
  <td height="20" bgcolor="#FFFFFF"><div align="center"><span class="STYLE1"><?php echo $age;?></span></div></td>
  <td height="20" bgcolor="#FFFFFF"><div align="center"><span class="STYLE1"><?php if($row['sex']==1) echo '男';else echo '女';?></span></div></td>
       <td height="20" bgcolor="#FFFFFF">
    <div align="center"><span class="STYLE1">
                  <?php

echo $update_status[$row['update']];
                  ?></span></div></td>
            <td height="20" bgcolor="#FFFFFF"><div align="center">
            <?php
            echo date('Y-m-d H:i:s',$row['regtime'])?>
            </div></td>

            <td height="20" bgcolor="#FFFFFF">
            <div align="center"><span class="STYLE4">

           <?php
           if($row['update']==1){
           ?>
           <a href='update2.php?id=<?php echo $row['id']?>'  style='color:#ff0000;'>审核</a>   &nbsp; | &nbsp;
<?php }
else{
	?>

                  <a href='add.php?id=<?php echo $row['id']?>&action=edit'>编辑</a>  &nbsp; | &nbsp;
	<?php
}
?>
   <a href='action.php?id=<?php echo $row['id']?>&action=delete' onClick="return(confirm('确定要删除该<?php echo $user_group[$row['group']]; ?>的所有数据吗?删除后不可恢复 '))">删除</a>

            </span></div></td>

          </tr>
<?php }?>
        </table>
  <table width="100%" border="0" cellspacing="0" cellpadding="0"  background="../style/images/content/tab_19.gif">


      <tr>
    <td width="12" height="35"><img src="../style/images/content/tab_18.gif" width="12" height="35" /></td>



            <td class="STYLE4"><?php echo  $page->get_page();?></td>

            <td></td>

        <td width="16"><img src="../style/images/content/tab_20.gif" width="16" height="35" /></td>
      </tr>

    </table>


<script>

function set_player(type,id){

	var tip='';
	var url='index.php?type=set_player&group=<?php echo $_GET['group'];?>&id='+id+'&act='+type;
if(type==1)	{


	tip='确认要同意<?php echo $user_group[$_GET['group']];?>认证么？';

}

if(type==2)	{


	tip='确认要拒绝<?php echo $user_group[$_GET['group']];?>认证么？';

}

if(type==-1)	{


	tip='确认要取<?php echo $user_group[$_GET['group']];?>资格么？';

}
if(confirm(tip))
location.href=url;
}



</script>

<?php include_once '../inc/footer.php';?>

