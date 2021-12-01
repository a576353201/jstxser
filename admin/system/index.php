<?php
include_once '../inc/header.php';

$title=array('系统基本参数');

$system=get_system();

?>




  <form name='myform' enctype="multipart/form-data" action="action.php?from=index&type=<?php echo $_GET['type'] ?>&id=<?php echo $_GET['id'];?>" method="post">
         <table width="98%"  class="tableList" cellpadding="1" cellspacing="1">

          <tr>
            <td align="right">网站名称</td>
            <td> <input name="title" type="text" size="40" maxlength="40" value="<?php echo $system['title'];?>">
             </td>
          </tr>

            <tr>
            <td  align="right">网站logo</td>
            <td align="left" >
              <input type="text" name="logo" value="<?php echo $system['logo']?>" size="40"/>
              &nbsp;<iframe style=" padding:0; margin:0;" src="../inc/upload.php?returnid=logo&image=1&path=ico" frameborder=0 scrolling=no width="350" height="25"></iframe>
            </td>
          </tr>
             <tr>
                 <td  align="right">手机版logo</td>
                 <td align="left" >
                     <input type="text" name="mobilelogo" value="<?php echo $system['mobilelogo']?>" size="40"/>
                     &nbsp;<iframe style=" padding:0; margin:0;" src="../inc/upload.php?returnid=mobilelogo&image=1&path=ico" frameborder=0 scrolling=no width="350" height="25"></iframe>
                 </td>
             </tr>

             <tr>
                 <td align="right">网站描述</td>
                 <td>
                     <textarea rows="4" cols="80" name="description"><?php echo $system['description'];?></textarea>

                 </td>
             </tr>

             <tr>
                 <td align="right">网站关键词</td>
                 <td>
                     <textarea rows="4" cols="80" name="keywords"><?php echo $system['keywords'];?></textarea>

                 </td>
             </tr>


             <tr style="display: none">
                 <td align="right">PC端底部信息</td>
                 <td>
                     <textarea rows="4" cols="80" name="footer"><?php echo $system['footer'];?></textarea>

                 </td>
             </tr>



             <tr>
                 <td align="right">开启签到</td>
                 <td>
                     <input type="radio" value="1" name="signopen" <?php if ($system['signopen']==1) echo 'checked';?>> 开启
                     <input type="radio" value="0" name="signopen" <?php if ($system['signopen']!=1) echo 'checked';?>> 关闭
                 </td>
             </tr>
             <tr>
                 <td align="right">签到金额</td>
                 <td>
                     <input name="sign_min" type="text"  style="width: 35px"  value="<?php echo $system['sign_min'];?>">
                   -<input name="sign_max" type="text" style="width: 35px" value="<?php echo $system['sign_max'];?>">元
                 </td>
             </tr>


             <tr>
                 <td align="right">开启邀请</td>
                 <td>
                     <input type="radio" value="1" name="inviteopen" <?php if ($system['inviteopen']==1) echo 'checked';?>> 开启
                     <input type="radio" value="0" name="inviteopen" <?php if ($system['inviteopen']!=1) echo 'checked';?>> 关闭
                 </td>
             </tr>

             <tr>
                 <td align="right">默认邀请码</td>
                 <td>
                     <input name="invite_code" type="text"  style="width:50px"  value="<?php echo $system['invite_code'];?>">
                 </td>
             </tr>

             <tr>
                 <td align="right">聊天记录保存时长</td>
                 <td>
                     <input type="radio" value="7" name="chattime" <?php if ($system['chattime']==7) echo 'checked';?>> 7天
                     <input type="radio" value="30" name="chattime" <?php if ($system['chattime']==30) echo 'checked';?>> 一个月
                     <input type="radio" value="180" name="chattime" <?php if ($system['chattime']==180) echo 'checked';?>> 半年
                     <input type="radio" value="3650" name="chattime" <?php if ($system['chattime']==3650) echo 'checked';?>> 永久
                 </td>
             </tr>
             <tr>
                 <td align="right">举报回复后选词语</td>
                 <td>
                     <textarea name="reportdeny_tips"  rows="4" cols="80" ><?php echo $system['reportdeny_tips']?></textarea>(用“|”分隔)
                 </td>
             </tr>
             <tr style="display: none">
                 <td align="right">短信接口ID</td>
                 <td>
                     <input name="sms_uid" type="text"    value="<?php echo $system['sms_uid'];?>">
                 </td>
             </tr>
             <tr  style="display: none">
                 <td align="right">短信接口秘钥</td>
                 <td>
                     <input name="sms_key" type="text"   value="<?php echo $system['sms_key'];?>">
                 </td>
             </tr>


             <tr>

          <td></td>
            <td height="30" align="left" colspan="1">
              <input class="button" type="submit" name="Submit" value="提 交"  >&nbsp;&nbsp;&nbsp;&nbsp;
              <input class="button" type="reset" name="Submit" value="重 置" >
            </td>
          </tr>
        </table>
      </form>





<?php include_once '../inc/footer.php';?>

