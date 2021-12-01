<?php include_once template("header");?>
<link rel="stylesheet" href="<?php echo $HttpTemplatePath; ?>css/task.css?v=<?php echo time(); ?>" type="text/css" media="screen" />
<script>


function search_sub(){


document.getElementById('search').submit();
}

</script>


<div style='margin:10px auto;padding-left:5px;line-height:40px;'>
<form action='index.php'  method='get'  id='search'>

<input type="text" name="title" value="<?php echo $_GET['title']; ?>" class='input' placeholder="请输入赛事标题"  >&nbsp;&nbsp;
<br>

<select name='year'>
<option value='-1'>年度</option>

<?php  foreach($year_arr as $key=>$value ){



	?>
	<option value='<?php echo $value;?>'  <?php if ($value==$_GET['year']) echo "selected";?>><?php echo $value; ?></option>

	<?php

}?>

</select>






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
<select name='typeid'  onchange='search_sub();'>
<option value=''>不限类别</option>
<?php if(is_array($menu0)){foreach($menu0 AS $index=>$value) { ?>
<option value='<?php echo $value['id']; ?>'  <?php if($_GET['typeid']==$value['id']){?>selected<?php }?>><?php echo $value['title']; ?></option>

<?php }}?>

</select>


<input type='submit' value='搜索' class='btn01'>






</form>
       <?php if($_GET['year'] && $_GET['year']>$year_arr[0]){?>
       <div style='width:100%;text-align:center;'>
                    <a  href="index.php?year=<?php echo $_GET['year']-1 ?>"  style='color:#2319dc;'>查看上年度赛程</a>

</div>
                    <?php }?>

</div>





    <article class="task-list-wrapper data-list-wrapper">

<?php if(count($list)>0){?>

                   <?php include_once template("task_list");?>



                    <p style="width: 100%;height:10px ;background: #f5f5f5;position: relative;"></p>    </article>


                    <div class="page"  <?php if($_GET['year'] && $_GET['year']<$year_arr[count($year_arr)-1]){?>style='height:70px;'<?php }?>>



                    <?php echo $page_html; ?>

                           <?php if($_GET['year'] && $_GET['year']<$year_arr[count($year_arr)-1]){?>
                             <div style='width:100%;text-align:center;'>
                    <a  href="index.php?year=<?php echo $_GET['year']+1 ?>" style='color:#2319dc;'>查看下年度赛程</a>

</div>
                    <?php }?></div>




<?php } else { ?>
<div  style='height:40px;line-height:40px;text-align:center;'>没有找到相关赛事</div>

<?php }?>










<?php include_once template("footer");?>