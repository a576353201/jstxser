<?php
include_once '../inc/header.php';

$title=array('系统基本参数');

$system=get_system();

?>




<form name='myform' enctype="multipart/form-data" action="action.php?from=index&type=<?php echo $_GET['type'] ?>&id=<?php echo $_GET['id'];?>" method="post">
    <table width="98%"  class="tableList" cellpadding="1" cellspacing="1">



        <tr>
            <td align="right">APP分发页面</td>
            <td> <input name="downurl" type="text" size="40" maxlength="400" value="<?php echo $system['downurl'];?>">

            </td>
        </tr>

        <tr>
            <td align="right">Android更新包下载地址</td>
            <td> <input name="down_Android" type="text" size="40" maxlength="400" value="<?php echo $system['down_Android'];?>">

            </td>
        </tr>
        <tr>
            <td align="right">Android版本号</td>
            <td> <input name="version_Android" type="text" size="40" maxlength="40" value="<?php echo $system['version_Android'];?>">

            </td>
        </tr>
        <tr>
            <td align="right">Android更新内容</td>
            <td> <input name="update_Android" type="text" size="40" maxlength="40" value="<?php echo $system['update_Android'];?>">

            </td>
        </tr>
        <tr>
            <td align="right">Android下载二维码</td>
            <td>
                <input name="qrcode_Android" type="text"  size="30" maxlength="200"   value="<?php echo $system['qrcode_Android'];?>">
                <iframe style="padding:0; margin:0;vertical-align: middle" src="../inc/upload.php?returnid=qrcode_Android&path=ico&image=1" frameborder=0 scrolling=no width="350" height="25" ></iframe>
            </td>
        </tr>
        <tr>
            <td align="right">IOS更新包下载地址</td>
            <td> <input name="down_ios" type="text" size="40" maxlength="400" value="<?php echo $system['down_ios'];?>">

            </td>
        </tr>

        <tr>
            <td align="right">TestFight下载地址</td>
            <td> <input name="down_tf" type="text" size="40" maxlength="400" value="<?php echo $system['down_tf'];?>">

            </td>
        </tr>
        <tr>
            <td align="right">IOS版本号</td>
            <td> <input name="version_ios" type="text" size="40" maxlength="40" value="<?php echo $system['version_ios'];?>">

            </td>
        </tr>
        <tr>
            <td align="right">IOS更新内容</td>
            <td> <input name="update_ios" type="text" size="40" maxlength="40" value="<?php echo $system['update_ios'];?>">

            </td>
        </tr>

        <tr>
            <td align="right">IOS下载二维码</td>
            <td>
                <input name="qrcode_ios" type="text"  size="30" maxlength="200"   value="<?php echo $system['qrcode_Android'];?>">
                <iframe style="padding:0; margin:0;vertical-align: middle" src="../inc/upload.php?returnid=qrcode_ios&path=ico&image=1" frameborder=0 scrolling=no width="350" height="25" ></iframe>
            </td>
        </tr>
        <tr >
            <td align="right">用户协议</td>
            <td>
                <textarea name="tipcon1" style="width: 80%;height: 200px"><?php echo $system['tipcon1']?></textarea>
            </td>
        </tr>
        <tr >
            <td align="right">隐私条款</td>
            <td>
                <textarea name="tipcon2" style="width: 80%;height: 200px"><?php echo $system['tipcon2']?></textarea>
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

