
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="titlebg">

      <tr>

        <td width="12" height="30"><img src="../style/images/content/tab_03.gif" width="12" height="30" /></td>

        <td>


         <div style='float:left' ><img src="../style/images/content/tb.gif" width="16" height="16" /></div>

         <div style='float:left'  class="STYLE1">
         <form action='index.php' method='get'>
         <span class="STYLE3">当前位置:</span>  <?php echo $task['title'];?> &gt; &gt;住宿信息&nbsp; &nbsp;&nbsp; &nbsp;

         </form>
         </div>


      <div style='float:right;padding-right:5px;'><a href='hotal.php?type=add&tid=<?php echo $tid; ?>'>房型设置</a></div>
        </td>

        <td width="16"><img src="../style/images/content/tab_07.gif" width="16" height="30" /></td>

      </tr>

  </table>
<?php
     $sql="select * from ".tname('team')." where tid='{$tid}' ";




     if($_GET['name']) $sql.=" and name like '%{$_GET[name]}%'";

     $sql.="order by id asc";
     $num=20;
   $page=new Page($sql, $num, $_GET['page']);
   $sql.=" limit $page->from,$num";

?>


   <form name='formSort' enctype="multipart/form-data" action='hotal.php' method='get' style='height:50px;line-height:50px;padding-left:10px;'>
<input type="hidden" name="tid" value="<?php echo $_GET['tid']; ?>" >
          队伍名称：<input type="text" id='name' name="name" value="<?php echo $_GET['name']; ?>" >




                       <input class="button" type="submit" name="Submit" value="确定"  >



</form>
<script>
function out(){

var url='../../out/room.php?name='+document.getElementById('name').value+'&tid=<?php echo $_GET['tid']; ?>';
location.href=url;
}

</script>


        <table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="b5d6e6" onmouseover="changeto()"  onmouseout="changeback()">

          <tr>




            <td bgcolor="#FFFFFF"><div align="center"><span class="STYLE1">队伍</span></div></td>
   <td bgcolor="#FFFFFF"><div align="center"><span class="STYLE1">房型</span></div></td>
            <td bgcolor="#FFFFFF"><div align="center"><span class="STYLE1">数量</span></div></td>
    <td bgcolor="#FFFFFF"><div align="center"><span class="STYLE1">
   入住时间</span></div></td>
          <td bgcolor="#FFFFFF"><div align="center"><span class="STYLE1">退房时间</span></div></td>
                      <td bgcolor="#FFFFFF"><div align="center"><span class="STYLE1">备注</span></div></td>


          </tr>


     <?php

     $query=$db->query($sql);
     while ($row=$db->fetch_array($query)){




    $room=unserialize($row['room']);

if(count($room)>0){

foreach($room as $value){

	?>

          <tr>

	            <td bgcolor="#FFFFFF"><div align="center"><span class="STYLE1"><?php echo $row['name'];?></span></div></td>
   <td bgcolor="#FFFFFF"><div align="center"><span class="STYLE1"><?php echo $value['name'];?></span></div></td>
            <td bgcolor="#FFFFFF"><div align="center"><span class="STYLE1"><?php echo $value['num'];?></span></div></td>
    <td bgcolor="#FFFFFF"><div align="center"><span class="STYLE1">
   <?php echo $value['begintime'];?></span></div></td>
          <td bgcolor="#FFFFFF"><div align="center"><span class="STYLE1"><?php echo $value['endtime'];?></span></div></td>
                      <td bgcolor="#FFFFFF"><div align="center"><span class="STYLE1"><?php echo $value['mark'];?></span></div></td>


</tr>

	<?php

}


     }

     ?>


<?php }?>
        </table>
  <table width="100%" border="0" cellspacing="0" cellpadding="0"  background="../style/images/content/tab_19.gif">


      <tr>
    <td width="12" height="35"><img src="../style/images/content/tab_18.gif" width="12" height="35" /></td>



            <td class="STYLE4"><?php echo  $page->get_page();?></td>

            <td>
                     <input  type="button" class="btn00" value="导出记录"  style='float:right;' onclick="out();" >
            </td>

        <td width="16"><img src="../style/images/content/tab_20.gif" width="16" height="35" /></td>
      </tr>

    </table>