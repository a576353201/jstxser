<?php
include_once '../inc/header.php';

$task=get_table(tname('task'),$_GET['tid']);
?>

<table width="100%" border="0" cellspacing="0" cellpadding="0" class="titlebg">

      <tr>

        <td width="12" height="30"><img src="../style/images/content/tab_03.gif" width="12" height="30" /></td>

        <td>


         <div style='float:left' ><img src="../style/images/content/tb.gif" width="16" height="16" /></div>

         <div style='float:left'  class="STYLE1">
         <form action='index.php' method='get'>
         <span class="STYLE3">当前位置:</span><?php echo $task['title'];?> &gt;&gt;入住信息&nbsp; &nbsp;&nbsp; &nbsp;

         </form>
         </div>



        </td>

        <td width="16"><img src="../style/images/content/tab_07.gif" width="16" height="30" /></td>

      </tr>

  </table>
<?php

   $hotal_list= $db->fetch_all("select * from ".tname('hotal')." where  tid='{$_GET['tid']}' order by sortnum asc ,id asc ");



     $sql="select * from ".tname('room')." where tid in (select id from ".tname('team')." where tid='{$_GET['tid']}' )  ";




     if($_GET['hid']) $sql.=" and hid='$_GET[hid]'";

     if($_GET['task_id'] or $_GET['task_title'] ){

      if($_GET['task_id']) {

      	$task=get_table(tname('task'),$_GET['task_id']);
      	if($task) $_GET['task_title']=$task['title'];

      }

       if($_GET['task_title']){
       	if(!$_GET['task_id'])
       	$task=$db->exec("select * from ".tname('task')." where title='{$_GET['task_title']}'");

       	if($task['id']>0)
       	$sql.=" and tid in (select team_id from ".tname('task_active')." where task_id='{$task['id']}'  ) ";

       }


     }

  if($_GET['begintime']){
     	$begintime=strtotime($_GET['begintime']);
         $sql.=" and begintime>='{$begintime}'";
     }
   if($_GET['endtime']){
     	$endtime=strtotime($_GET['endtime']);
         $sql.=" and begintime<='{$endtime}'";
     }
     $sql.="order by id desc";
     $num=20;
   $page=new Page($sql, $num, $_GET['page']);
   $sql.=" limit $page->from,$num";

?>


   <form name='formSort' enctype="multipart/form-data" action='room.php' method='get' style='height:50px;line-height:50px;padding-left:10px;'>




  <input type="hidden" name="tid" value="<?php echo $_GET['tid']?>"/>





          酒店名称：<select name='hid' id='hid'>
          <option value=''>不限</option>
          <?php
          foreach($hotal_list as $value){
          ?>
<option value='<?php echo $value['id']?>' <?php if($value['id']==$_GET['hid'])  echo "selected";?> ><?php echo $value['name']?></option>

<?php
          }
          ?>

          </select>
入住时间：<input type="text" class="Wdate input1" id='begintime' name="begintime" value="<?php echo $_GET['begintime']; ?>" onclick="WdatePicker({dateFmt:'yyyy-MM-dd',alwaysUseStartDate:false})">
-<input type="text" class="Wdate input1" id='endtime' name="endtime" value="<?php echo $_GET['endtime']; ?>" onclick="WdatePicker({dateFmt:'yyyy-MM-dd',alwaysUseStartDate:false})">


                       <input class="button" type="submit" name="Submit" value="确定"  >


</form>

<script>
function out(){

var url='../../out/room.php?tid=<?php echo $_GET['tid'];?>&hid='+document.getElementById('hid').value+'&begintime='+document.getElementById('begintime').value+'&endtime='+document.getElementById('endtime').value;
location.href=url;
}

</script>

        <table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="b5d6e6" onmouseover="changeto()"  onmouseout="changeback()">

          <tr>




            <td bgcolor="#FFFFFF"><div align="center"><span class="STYLE1">团队名称</span></div></td>

            <td bgcolor="#FFFFFF"><div align="center"><span class="STYLE1">酒店名称</span></div></td>
    <td bgcolor="#FFFFFF"><div align="center"><span class="STYLE1">
   房间类型</span></div></td>

                      <td bgcolor="#FFFFFF"><div align="center"><span class="STYLE1">入住时间</span></div></td>





          </tr>


     <?php

     $query=$db->query($sql);
     while ($row=$db->fetch_array($query)){




$hotal=get_table(tname('hotal'), $row['hid']);
$team=get_table(tname('team'), $row['tid']);
$room=unserialize($row['room']);


     ?>
          <tr>





            <td height="20" bgcolor="#FFFFFF"><div align="center"><span class="STYLE1"><?php echo $team['name'];?></span></div></td>

              <td height="20" bgcolor="#FFFFFF"><div align="center"><span class="STYLE1"><?php echo $hotal['name'];?></span></div></td>


                  <td height="20" bgcolor="#FFFFFF">
                  <div align="center">
                  <span class="STYLE1">
                  <?php
                  foreach($room as $value){

                  	echo $value['name']."*".$value['num']." &nbsp; &nbsp; &nbsp;";

                  }


                  ?>
                  </span>

                  </div>


                  </td>

            <td height="20" bgcolor="#FFFFFF"><div align="center"><?php echo date('Y-m-d',$row['begintime'])?></div></td>

                      </tr>
<?php }?>
        </table>
  <table width="100%" border="0" cellspacing="0" cellpadding="0"  background="../style/images/content/tab_19.gif">


      <tr>
    <td width="12" height="35"><img src="../style/images/content/tab_18.gif" width="12" height="35" /></td>



            <td class="STYLE4"><?php echo  $page->get_page();?></td>

            <td>
            &nbsp;&nbsp;&nbsp;
     <input style='float:right;' type="button" class="btn00" value="导出记录" onclick="out();" >

            </td>

        <td width="16"><img src="../style/images/content/tab_20.gif" width="16" height="35" /></td>
      </tr>

    </table>

<?php include_once '../inc/footer.php';?>

