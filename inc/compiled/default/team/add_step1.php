

<input type='hidden' id='player_sum' value='<?php echo count($player); ?>'>
<input type='hidden' id='player_sum1' value='0'>
<input type='hidden' id='player_sum2' value='0'>
<input type='hidden' name='tid' value='<?php echo $_GET['tid']; ?>'>
<script>
var danwei_list = new Array();
<?php if(is_array($danwei)){foreach($danwei AS $index=>$value) { ?>

danwei_list[<?php echo $index; ?>]='<?php echo $value['realname']; ?>';
<?php }}?>

var lingdui_num=<?php echo count($lingdui); ?>;
var fulingdui_num=<?php echo count($fulingdui); ?>;
var jiaolian_num=<?php echo count($jiaolian); ?>;
</script>


<div class='line'>
<span  class='title'><span class='must'>*</span>赛事名称：</span>
<?php echo $task['title']; ?>
</div>



<div class='line'>
<span  class='title'><span class='must'>*</span>队伍名称：</span>
<input type='text' class='input' id='name' name='name' value='<?php echo $team['name']; ?>' minlength="2" maxlength="30" autofocus="" required="" autocomplete="off">

</div>

<div class='line'  style='clear:both;'>
<span  class='title'> 领队人数：</span>
<select name='lingdui_num'  onchange="add_lingdui(this.value)">
<?php  for($i=0;$i<=$team_con['num1'];$i++){?>
<option value='<?php echo $i; ?>' <?php if($i==count($lingdui)){?>selected<?php }?>><?php echo $i; ?></option>


<?php } ?>
</select>人

</div>

<div class='line' id='lingdui_div'  style='<?php if(count($lingdui)<1){?>display:none;<?php }?>clear:both;'>
<span  class='title' style='float:left;'>领队信息：</span>

<div  id='lingdui' style='float:left;'>
<?php if(is_array($lingdui)){foreach($lingdui AS $index=>$value) { ?>
<div id="lingdui_<?php echo $index; ?>">
姓名:<input type="text" class="input1" name="lingdui[<?php echo $index; ?>][name]" value="<?php echo $value['name']; ?>" minlength="2" maxlength="10" autofocus="" required="" autocomplete="off">
&nbsp;&nbsp;&nbsp;
 性别:<input type="radio" name="lingdui[<?php echo $index; ?>][sex]" value="1" required=""  <?php if($value['sex']==1){?>checked<?php }?>>男&nbsp;&nbsp;
 <input type="radio" name="lingdui[<?php echo $index; ?>][sex]" value="2" required="" <?php if($value['sex']==2){?>checked<?php }?>>女
 </div>

<?php }}?>

</div>

</div>


<div class='line'  style='clear:both;'>
<span  class='title'> 副领队人数：</span>
<select name='fulingdui_num'  onchange="add_fulingdui(this.value)">
<?php  for($i=0;$i<=$team_con['num2'];$i++){?>
<option value='<?php echo $i; ?>' <?php if($i==count($fulingdui)){?>selected<?php }?>><?php echo $i; ?></option>


<?php } ?>
</select>人

</div>
<div class='line' id='fulingdui_div'  style='<?php if(count($fulingdui)<1){?>display:none;<?php }?>clear:both;'>
<span  class='title' style='float:left;'>副领队信息：</span>

<div  id='fulingdui' style='float:left;'>

<?php if(is_array($fulingdui)){foreach($fulingdui AS $index=>$value) { ?>
<div id="fulingdui_<?php echo $index; ?>">
姓名:<input type="text" class="input1" name="fulingdui[<?php echo $index; ?>][name]" value="<?php echo $value['name']; ?>" minlength="2" maxlength="10" autofocus="" required="" autocomplete="off">
&nbsp;&nbsp;&nbsp;
 性别:<input type="radio" name="fulingdui[<?php echo $index; ?>][sex]" value="1" required=""  <?php if($value['sex']==1){?>checked<?php }?>>男&nbsp;&nbsp;
 <input type="radio" name="fulingdui[<?php echo $index; ?>][sex]" value="2" required="" <?php if($value['sex']==2){?>checked<?php }?>>女
 </div>

<?php }}?>
</div>

</div>


<div class='line'  style='clear:both;'>
<span  class='title'>教练人数：</span>
<select name='jiaolian_num'  onchange="add_jiaolian(this.value)">
<?php  for($i=0;$i<=$team_con['num3'];$i++){?>
<option value='<?php echo $i; ?>' <?php if($i==count($jiaolian)){?>selected<?php }?>><?php echo $i; ?></option>


<?php } ?>
</select>人

</div>


<div class='line' id='jiaolian_div'  style='<?php if(count($jiaolian)<1){?>display:none;<?php }?>clear:both;'>
<span  class='title' style='float:left;'>教练信息：</span>

<div   style='float:left;width:700px;line-height:40px;text-align:center;'>

<table  style='width:100%;'  id='jiaolian'>
<tr>
<td>
姓名
</td>
<td>
性别
</td>
<td>
是否外籍
</td>
<td>
上年度锦标赛代表单位
</td>
</tr>
<?php if(count($jiaolian)>0){?>
<?php

foreach($jiaolian as $index =>$value) {



?>


<tr id="jiaolian_<?php echo $index; ?>">
<td>
<input type="text" class="input1" name="jiaolian[<?php echo $index; ?>][name]" value="<?php echo $value['name']; ?>" minlength="2" maxlength="10" autofocus="" required="" autocomplete="off">
</td>
<td>
<input type="radio" name="jiaolian[<?php echo $index; ?>][sex]" value="1" required=""  <?php if($value['sex']==1){?>checked<?php }?>>男&nbsp;&nbsp;
 <input type="radio" name="jiaolian[<?php echo $index; ?>][sex]" value="2" required="" <?php if($value['sex']==2){?>checked<?php }?>>女
</td>

<td>
<input type="radio" name="jiaolian[<?php echo $index; ?>][waiji]" value="1" required="" <?php if($value['waiji']==1){?>checked<?php }?>>是&nbsp;&nbsp;
 <input type="radio" name="jiaolian[<?php echo $index; ?>][waiji]" value="2" required="" <?php if($value['waiji']==2){?>checked<?php }?>>否
</td>
<td  style='position: relative;'>
  <input type="text" style="width:180px;" placeholder="上年度锦标赛代表单位" id='jiaolian_danwei1_<?php echo $index; ?>' name="jiaolian[<?php echo $index; ?>][danwei]" value="<?php echo $value['danwei']; ?>" minlength="2" maxlength="10" autofocus=""  autocomplete="off"  onclick="set_danwei(this.value,<?php echo $index; ?>,'jiaolian',0);" oninput="set_danwei(this.value,<?php echo $index; ?>,'jiaolian',1);">
<div class='jiaolian_danwei'  id='jiaolian_danwei_<?php echo $index; ?>'></div>
</td>

</tr>
<?php } ?>

<?php }?>
</table>



</div>

</div>
<div class='line'  style='clear:both;'>
<span  class='title' style='float:left;'> <span class='must'>*</span>搜索运动员：</span>
<div   style='float:left;'>
编号:<input type='text' id='playerid' class='input1' value=''> &nbsp; &nbsp;
姓名:<input type='text' id='realname' class='input1' value=''> &nbsp; &nbsp;
性别:<select id='playersex'>
<option value=''>不限</option>
<option value='1'>男</option>
<option value='2'>女</option>
</select>

<input type='button' class='btn01' style='width:80px;' value='搜索'  onclick="return search_player()"; >

<div class='search_box'  id='search_info'>

</div>

<div id='search_num'></div>
<div id='player_html'>
    <ul id='player_ul'  >
        <?php if(is_array($player)){foreach($player AS $index=>$value) { ?>

    <li  id='playerid_<?php echo $index; ?>'>
        <a href='<?php echo $HttpPath;?>user/space.php?uid=<?php echo $index; ?>' target='_blank'><?php echo $value['realname'];?></a>
        <img src="<?php echo $HttpPath; ?>static/images/del.png"  onclick="delete_player(<?php echo $index; ?>);" title='删除'/>

        <input type='hidden'  name="playerids[]" value="<?php echo $index; ?>">
          <input type='hidden'  name="player[<?php echo $index; ?>][waiyuan]" value="<?php echo $value['waiyuan']; ?>">
          <input type='hidden'  name="player[<?php echo $index; ?>][danwei]" value="<?php echo $value['danwei']; ?>">

        </li>
    <?php }}?>


</ul>

    </div>
 <div  id='player_nums'  style='clear:both;'>当前已有<span id="player_num"><?php echo count($player); ?></span>名运动员报名</div>

</div>
</div>


<div class='line'  style='clear:both;'>
<span  class='title'>其他人数：</span>
<input type='text' class='input1' id='other_num' name='other_num' value='<?php echo $team['other_num']; ?>'>人

</div>

<div class='line'  style='clear:both;'>
<span  class='title'> <span class='must'>*</span>联系人姓名：</span>
<input type='text'  id='contact_name' name='contact[name]' value='<?php echo $contact['name']; ?>' minlength="2" maxlength="20" autofocus="" required="" autocomplete="off">

</div>

<div class='line'  style='clear:both;'>
<span  class='title'> <span class='must'>*</span>联系人手机：</span>
<input type='text'  id='contact_mobile' name='contact[mobile]' value='<?php echo $contact['mobile']; ?>' minlength="11" maxlength="11" autofocus="" required="" autocomplete="off">

</div>
<div class='line'  style='clear:both;'>
<span  class='title'> 联系人固话：</span>
<input type='text'  id='contact_tel' name='contact[tel]' value='<?php echo $contact['tel']; ?>' minlength="8" maxlength="13">

</div>

<div class='line'  style='clear:both;'>
<span  class='title'> 联系传真：</span>
<input type='text'  id='contact_fox' name='contact[fox]' value='<?php echo $contact['fox']; ?>' minlength="8" maxlength="13" >

</div>

<div class='line'>

<div style='padding-left:200px;'>

<input type='submit' class='btn01' value='下一步'  onclick="return click_sub(<?php echo $step; ?>)"; >

</div>
</div>

