<?php
include_once '../inc/header.php';



?>

<table width="100%" border="0" cellspacing="0" cellpadding="0" class="titlebg">

      <tr>

        <td width="12" height="30"><img src="../style/images/content/tab_03.gif" width="12" height="30" /></td>

        <td>


         <div style='float:left' ><img src="../style/images/content/tb.gif" width="16" height="16" /></div>

         <div style='float:left'  class="STYLE1">
         <form action='index.php' method='get'>
         <span class="STYLE3">当前位置:</span>系统预览

         </form>
         </div>



        </td>

        <td width="16"><img src="../style/images/content/tab_07.gif" width="16" height="30" /></td>

      </tr>

  </table>


  <style>
#info_con_3 tr{line-height:35px;font-size:16px;height:35px;}

.table1 {background-color:#ddd;width:98%;margin:0 auto;}
.table1 td,.table1 th{background-color:#fff;border:0px;margin:0px;text-align:center;}
.table1 tr{line-height:35px;font-size:16px;height:35px;}
.table1 a{color:#3388ff;}
.info1{background-color:#fff;border:1px #ccc solid;width:98%;margin:0 auto;margin-bottom:10px;}
.info1 .title1{text-align:left;line-height:35px;font-size:16px;height:35px;font-weight:800;border-bottom:1px #ccc solid;padding-left:10px;}
.info1 .content1{padding:10px;}
</style>



<div class="info1">

<div class="title1">审核统计

</div>

<div class="content1">

<table style="width:100%;">

  <tbody><tr>
    <td width="48%">

   <table class="table1" cellpadding="1" cellspacing="1">

				                <tbody><tr>
				                  <th>待审核总数</th>

				             <?php

				             foreach($user_group as $key=>$value){
				             	if($key>1){



				             ?>

				              <th><?php echo $value; ?></th>

				             	<?php
				             	}
				             }
				             ?>



				                </tr>




       <tr>


                        <td>
                           <?php
                           $row=$db->exec("select count(*) as num from ".tname('user')." where `update`=1");

                           if(!$row['num']) $row['num']=0;

                           echo $row['num'];
                           ?>
                        </td>
                            <?php

				             foreach($user_group as $key=>$value){
if($key!=2){
if($key==1) $group=2;
else $group=$key;

			             	    $row=$db->exec("select count(*) as num from ".tname('user')." where `group`='{$key}'  and `update`=1");

                           if(!$row['num']) $row['num']=0;
                            $num=$key-1;
                       if($num==0)$num=1;
				             ?>

				              <td><a href='../user/index<?php echo $num;?>.php?update=1'  style="<?php if($row['num']>0) echo "color:#ff0000;font-weight:600;";?>"><?php  echo $row['num']; ?></a></td>

				             	<?php
				             	}

				             }
				             ?>






	            		</tr></tbody></table>

    </td>


    </tr>
    </tbody></table>





</div>


</div>




















<div class="info1">

<div class="title1">用户总数统计

</div>

<div class="content1">

<table style="width:100%;">

  <tbody><tr>
    <td width="48%">

   <table class="table1" cellpadding="1" cellspacing="1">

				                <tbody><tr>
				                  <th>用户总数</th>

				             <?php

				             foreach($user_group as $key=>$value){
				             ?>

				              <th><?php echo $value; ?>总数</th>

				             	<?php
				             }
				             ?>




                        <th>今日注册用户</th>
                                       <th>今日登陆人数</th>


				                </tr>




       <tr>


                        <td>
                           <?php
                           $row=$db->exec("select count(*) as num from ".tname('user')."");

                           if(!$row['num']) $row['num']=0;

                           echo $row['num'];
                           ?>
                        </td>
                            <?php
 $row=$db->exec("select count(*) as num from ".tname('user')." where (`group`='1' or `group`='2') and sub=1");

                           if(!$row['num']) $row['num']=0;


				             ?>

				              <td><a href='../user/index1.php'><?php  echo $row['num']; ?></a></td>

                        <?php
 $row=$db->exec("select count(*) as num from ".tname('user')." where `group`='2' and sub=1");

                           if(!$row['num']) $row['num']=0;


				             ?>

				              <td><a href='../user/index1.php?group=2'><?php  echo $row['num']; ?></a></td>
                        <?php
 $row=$db->exec("select count(*) as num from ".tname('user')." where `group`='3' and sub=1");

                           if(!$row['num']) $row['num']=0;


				             ?>

				              <td><a href='../user/index2.php'><?php  echo $row['num']; ?></a></td>


                        <?php
 $row=$db->exec("select count(*) as num from ".tname('user')." where `group`='4' and sub=1");

                           if(!$row['num']) $row['num']=0;


				             ?>

				              <td><a href='../user/index3.php'><?php  echo $row['num']; ?></a></td>




                        <td>        <?php
                       $today_time=strtotime(date('Y-m-d').' 00:00:00') ;
                           $row=$db->exec("select count(*) as num from ".tname('user')." where regtime>='{$today_time}'");

                           if(!$row['num']) $row['num']=0;

                           echo $row['num'];
                           ?>                       </td>

                               <td>

			 <?php

                           $row=$db->exec("select count(*) as num from ".tname('user')." where logintime>='{$today_time}'");

                           if(!$row['num']) $row['num']=0;


                           ?>
<a href='../user/userlog.php'><?php  echo $row['num']; ?></a>
                               </td>



	            		</tr></tbody></table>

    </td>


    </tr>
    </tbody></table>





</div>


</div>













<div class="info1">

<div class="title1">赛事统计

</div>

<div class="content1">

<table style="width:100%;">

  <tbody><tr>
    <td width="48%">

   <table class="table1" cellpadding="1" cellspacing="1">

				                <tbody><tr>
				                  <th>赛事总数</th>

				             <?php

				             foreach($task_status as $key=>$value){
				             ?>

				              <th><?php echo $value; ?></th>

				             	<?php
				             }
				             ?>




                        <th>今日新增</th>



				                </tr>




       <tr>


                        <td>
                           <?php
                           $row=$db->exec("select count(*) as num from ".tname('task')." where id>0");

                           if(!$row['num']) $row['num']=0;


                           ?>

                           <a href='../task/manage.php'><?php  echo $row['num']; ?></a>
                        </td>
                            <?php

				             foreach($task_status as $key=>$value){

				             	    $row=$db->exec("select count(*) as num from ".tname('task')." where id>0 and  `status`='{$key}'");

                           if(!$row['num']) $row['num']=0;


				             ?>

				              <td><a href='../task/manage.php?status=<?php  echo $key; ?>'><?php  echo $row['num']; ?></a></td>

				             	<?php
				             }
				             ?>


                        <td>        <?php
                       $today_time=strtotime(date('Y-m-d').' 00:00:00') ;
                           $row=$db->exec("select count(*) as num from ".tname('task')." where id>0 regtime>='{$today_time}'");

                           if(!$row['num']) $row['num']=0;

                           echo $row['num'];
                           ?>                       </td>




	            		</tr></tbody></table>

    </td>


    </tr>
    </tbody></table>





</div>


</div>
