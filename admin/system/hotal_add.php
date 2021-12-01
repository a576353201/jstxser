<?php



if($_POST){



	add_adminlog("新增酒店信息");

$data=array();



$data['room']=serialize($_POST['room']);

$data['room_status']=$_POST['status'];


   $db->update(tname('task'), $data, $tid);

promptMessage('hotal.php?tid='.$tid,'操作成功');exit();


}






$room=unserialize($task['room']);




?>

<table width="100%" border="0" cellspacing="0" cellpadding="0" class="titlebg">

      <tr>

        <td width="12" height="30"><img src="../style/images/content/tab_03.gif" width="12" height="30" /></td>

        <td>


         <div style='float:left' ><img src="../style/images/content/tb.gif" width="16" height="16" /></div>

         <div style='float:left'  class="STYLE1"><span class="STYLE3">当前位置:</span>  <?php echo $task['title'];?> &gt; &gt;房型设置</div>


      <div style='float:right;padding-right:5px;'><a href='#' onclick="window.history.go(-1);">返回</a></div>
        </td>

        <td width="16"><img src="../style/images/content/tab_07.gif" width="16" height="30" /></td>

      </tr>

  </table>



 <form name='myform' enctype="multipart/form-data" action="hotal.php?type=add&tid=<?php echo $tid;?>"method="post">




<table width="98%" bgcolor="#FFFFFF" class="tableList" cellpadding="1" cellspacing="1">
 <tr>
            <td colspan="2">

                    <tr>
                      <td width="20%" align="right">所在赛事</td>
                      <td width="80%">
                 <?php echo $task['title'];?>
                    </td>
                   </tr>
 <tr>
            <td colspan="2">


          <tr><td></td>
            <td   id='room_div'>
            <?php
            if(count($room)>0){

            	foreach($room as $key =>$value){
            		?>

            		<div id="room_<?php echo $key;?>">
            		房型：<input type="text" name="room[<?php echo $key;?>]" value="<?php echo $value;?>" size="20" maxlength="40" autofocus="" required="" autocomplete="off">  &nbsp; &nbsp;  &nbsp;

            		&nbsp;


            				<input type="button" value="新增" onclick="add_room()">

            			&nbsp;

            				<input type="button" value="删除" onclick="remove_room('room_<?php echo $key;?>')">



            		</div>


            		<?php
            	}



            }
            ?>


            </td>
          </tr>

          <tr>
            <td align="right">状态</td>
            <td>
              <input name="status" type="radio" value="1" <?php if($hotal['status']!=2) echo "checked";?>>可预订
              <input name="status" type="radio" value="2" <?php if($hotal['status']==2) echo "checked";?>>禁止预订
            </td>
          </tr>


  <tr>
  <td></td>
    <td colspan="1" align="left" valign="middle">
      <input type="submit" value="确 定" class="button"  />
      <input type="reset" value="重 置" class="button" />
    </td>
  </tr>
</table>
</form>


 <script type="text/javascript">

var room_num=<?php if (count($room)>0) echo count($room);else echo 0;?>;


function add_room(){

	var  str="<div >房型：<input type='text' name='room[]' value='' size='20' maxlength='40' autofocus='' required='' autocomplete='off' />  &nbsp; &nbsp;  &nbsp;"
;

	 str+="<input type='button'  value='新增' onclick='add_room()' />  &nbsp;";
 str+="<input type='button'  value='删除' onclick=\"remove_room('room_"+room_num+"')\" />";

str+="</div>";

$('#room_div').append(str);room_num++;
}


function remove_room(div){
	room_num--;
	$('#'+div).remove();





}
if(room_num<2)
add_room();



</script>




  <table width="100%" border="0" cellspacing="0" cellpadding="0"  background="../style/images/content/tab_19.gif">


      <tr>

        <td width="12" height="35"><img src="../style/images/content/tab_18.gif" width="12" height="35" /></td>



            <td class="STYLE4">&nbsp;&nbsp;</td>

            <td></td>

        <td width="16"><img src="../style/images/content/tab_20.gif" width="16" height="35" /></td>

      </tr>

    </table>


