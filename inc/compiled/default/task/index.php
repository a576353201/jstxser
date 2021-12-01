<?php include_once template("header");?>

<script>


function search_sub(){


document.getElementById('search').submit();
}

</script>

<div class='player_list'>

<div style='height:50px;line-height:50px;padding-top:10px;'>
<form action='index.php'  method='get'  id='search'>

年度：<select name='year' onchange='search_sub();'>
<option value='-1'>不限</option>

<?php  foreach($year_arr as $key=>$value ){



	?>
	<option value='<?php echo $value;?>'  <?php if ($value==$_GET['year']) echo "selected";?>><?php echo $value; ?></option>

	<?php

}?>

</select>


&nbsp;&nbsp;

状态：
<select name='status' onchange='search_sub();'>
<option value='-2'>全部赛事</option>
  <?php
  foreach ($task_status as $key=> $value) {

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

&nbsp;&nbsp;
类别：
<select name='typeid'  onchange='search_sub();'>
<option value=''>不限类别</option>
<?php if(is_array($menu0)){foreach($menu0 AS $index=>$value) { ?>
<option value='<?php echo $value['id']; ?>'  <?php if($_GET['typeid']==$value['id']){?>selected<?php }?>><?php echo $value['title']; ?></option>

<?php }}?>

</select>

&nbsp;&nbsp;
赛事名称：

<input type="text" name="title" value="<?php echo $_GET['title']; ?>" >&nbsp;&nbsp;


<input type='submit' value='搜索' class='btn01'>

</form>

</div>


<?php if(count($list)>0){?>

        <table width="100%" border="0" cellpadding="0" cellspacing="1"  class='table_list'>

          <tr>
            <td><div align="center"><span class="STYLE1">赛事名称</span></div></td>

            <td><div align="center"><span class="STYLE1">赛事类别</span></div></td>
    <td><div align="center">举办地点</div></td>

                      <td><div align="center"><span class="STYLE1">赛事时间</span></div></td>




            <td  class="STYLE1"><div align="center">基本操作</div></td>

          </tr>

 	<?php if(is_array($list)){foreach($list AS $index=>$value) { ?>

          <tr>
            <td><a href='info.php?id=<?php echo $value['id']; ?>' target='_blank'><?php echo $value['title']; ?></a></td>

            <td><?php echo nav_show($value['typeid']); ?></td>
             <td><?php echo $value['province']; ?> <?php echo $value['city']; ?> <?php echo $value['country']; ?></td>

    <td> <?php echo date('Y-m-d',$value['begindate']); ?>至 <?php echo date('Y-m-d',$value['enddate']); ?> </td>




            <td  class="STYLE1">

<a href='info.php?id=<?php echo $value['id']; ?>' target='_blank'>预览</a>
            </td>

          </tr>

           <?php }}?>



           </table>


                    <div class="page" >
                    <?php if($_GET['year'] && $_GET['year']>$year_arr[0]){?>
                    <a  href="index.php?year=<?php echo $_GET['year']-1 ?>"  style='color:#2319dc;'>查看上年度赛程</a>


                    <?php }?>


                    <?php echo $page_html; ?>

                           <?php if($_GET['year'] && $_GET['year']<$year_arr[count($year_arr)-1]){?>
                    <a  href="index.php?year=<?php echo $_GET['year']+1 ?>" style='color:#2319dc;'>查看下年度赛程</a>


                    <?php }?>

                    </div>




<?php } else { ?>
<div  style='height:40px;line-height:40px;text-align:center;'>没有找到<?php if($_GET['status']!=-2){?><?php echo $task_status[$_GET['status']]; ?>的<?php } else { ?>相关<?php }?>赛事

<?php if($_GET['status']!=-2){?>

<a href='index.php?status=-2' style='color:#00aaee;'>点击此处列出全部相关赛事</a>

<?php }?>
</div>



<?php }?>

</div>
















<?php include_once template("footer");?>