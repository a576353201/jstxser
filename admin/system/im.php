<?php
include_once '../inc/header.php';

$title=array('系统基本参数');

$system=get_system();

?>




<form name='myform' enctype="multipart/form-data" action="action.php?from=index&type=<?php echo $_GET['type'] ?>&id=<?php echo $_GET['id'];?>" method="post">
    <table width="98%"  class="tableList" cellpadding="1" cellspacing="1">


        <tr>
            <td align="right">一个聊天室最多设置多少标签</td>
            <td>
                <input name="tags_sum" type="text" size="20" maxlength="20" value="<?php echo $system['tags_sum'];?>">个

            </td>
        </tr>
        <tr>
            <td align="right">聊天室标签</td>
            <td>
                <textarea rows="4" cols="80" name="tags"><?php echo $system['tags'];?></textarea>（用“|”分隔）

            </td>
        </tr>


        <tr>
            <td  align="right">官方助手ID</td>
            <td align="left" >

                <input name="admin_number" type="text" size="40" maxlength="40" value="<?php echo $system['admin_number'];?>"> （务必谨慎填写）
            </td>
        </tr>
        <tr>
            <td align="right">客服分配方式</td>
            <td>
                <input type="radio" value="all" name="kefu_add" <?php if ($system['kefu_add']=='all') echo 'checked';?>> 添加全部
                <input type="radio" value="rand" name="kefu_add" <?php if ($system['kefu_add']=='rand') echo 'checked';?>> 随机分配
            </td>
        </tr>
        <tr style="display: none">
            <td  align="right">官方助手昵称</td>
            <td align="left" >

                <input name="admin_nickname" type="text" size="40" maxlength="40" value="<?php echo $system['admin_nickname'];?>">
            </td>
        </tr>
        <tr  style="display: none">
            <td  align="right">官方助手头像</td>
            <td align="left" >
                <input type="text" name="admin_logo" value="<?php echo $system['admin_logo']?>" size="40"/>
                &nbsp;<iframe style=" padding:0; margin:0;" src="../inc/upload.php?returnid=admin_logo&image=1&path=ico" frameborder=0 scrolling=no width="350" height="25"></iframe>
            </td>
        </tr>

        <tr>
            <td  align="right">红包金额</td>
            <td align="left" >

                <input name="redpacket_min" type="text" style="width: 60px" value="<?php echo $system['redpacket_min'];?>"> -
                <input name="redpacket_max" type="text" style="width: 60px" value="<?php echo $system['redpacket_max'];?>"> 元
            </td>
        </tr>
        <tr>
            <td  align="right">红包默认标题</td>
            <td align="left" >
                <input name="redpacket_title" type="text" size="40" maxlength="40" value="<?php echo $system['redpacket_title'];?>">
            </td>
        </tr>

        <tr>
            <td align="right">聊天屏蔽关键字</td>
            <td>
                <textarea rows="4" cols="80" name="msg_keywords"><?php echo $system['msg_keywords'];?></textarea>（用“|”分隔，会被替换成“***”）
            </td>
        </tr>
        <tr>
            <td align="right">聊天禁止发送关键字</td>
            <td>
                <textarea rows="4" cols="80" name="msg_keywords1"><?php echo $system['msg_keywords1'];?></textarea>（用“|”分隔，不允许发送）
            </td>
        </tr>

        <tr>
            <td align="right">踢人理由候选词</td>
            <td>
                <textarea rows="4" cols="80" name="logout_words"><?php echo $system['logout_words'];?></textarea>（用“|”分隔，不允许发送）
            </td>
        </tr>
        <tr>
            <td  align="right">踢人候选词最多个数</td>
            <td align="left" >
                <input name="logout_wordsnum" type="text" size="10" maxlength="1" value="<?php echo $system['logout_wordsnum'];?>">个
            </td>
        </tr>
        <tr>
            <td  align="right">红包退回时间</td>
            <td align="left" >
                <input name="redpacket_backtime" type="text" size="10" maxlength="2" value="<?php echo $system['redpacket_backtime'];?>">小时
            </td>
        </tr>
        <tr>
            <td align="right">多久无响应表示掉线</td>
            <td>
                <input name="online_time" type="text" size="10" maxlength="20" value="<?php echo $system['online_time'];?>">秒
            </td>
        </tr>

        <tr>
            <td align="right">客服问候语</td>
            <td>
                <textarea rows="4" cols="80" name="welcome"><?php echo $system['welcome'];?></textarea>

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

