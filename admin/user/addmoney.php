<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/6/26
 * Time: 15:22
 */
include_once '../inc/header.php';

?>


<?php

if($_POST){

    if($_POST['username']){
        $user= $db->exec("select * from app_user where `{$_POST['type']}`='{$_POST['username']}'");
        if($user){
            $userid=$user['id'];
            $money=$_POST['money'];
            if($_POST['method']=='recharge'){


                $mark='手动转账 ';
                if($_POST['mark']){
                    $mark=$_POST['mark'];
                }

                $iid=add_recharge($userid,$money,$mark,1);
                if($iid>0){


                    add_adminlog("向【{$user['name']}】手动转账:{$money}元");
                }
            }
            else{

                $mark="活动赏金赠送";
                if($_POST['mark']){
                    $mark=$_POST['mark'];
                }

                if( $db->affected_rows()>0){

                    add_money($userid,$money, 'active',$mark);

                }
                add_adminlog("向【{$user['username']}】赠活动赏金:{$money}元");
            }

            $tip= "充值成功";
            $return=true;


        }
        else{
            $tip= "您输入的用户名或者UID不存在";
            $return=false;

        }


    }
    else{

        $tip= "您还没有输入用户名或者UID";
        $return=false;
    }


    echo "<div style='padding-top: 20px;text-align: center'>{$tip}</div>";


    ?>
    <script>

        setTimeout(function () {
         <?php
            if($return==true){
            if($_GET['level']==2){
                ?>



            parent.parent.money_add(<?php echo $userid;?>,<?php echo $money;?>);
            parent.location.reload();
                <?php
            }else{
            ?>
           parent.money_add(<?php echo $userid;?>,<?php echo $money;?>);
            var index=parent.layer.getFrameIndex(window.name);

            parent.layer.close(index);
            <?php
            }
        }


                ?>


        },1000)

    </script>

    <?php



    exit();
}

if($_GET['id']){

    $user=get_user_byid($_GET['id']);
    $username=$user['name'];
}
else $username='';


?>



<form method="POST" action="?from=<?php echo $_GET['from']?>&level=<?php echo $_GET['level'];?>"  name="form" id="form">

    <table width="100%" border="0" cellpadding="4" cellspacing="1"  align=left   id='info_con_1' class="table_add" >
        <TR align=left>
            <td width="120px" ><div style=text-align:right;margin-right:5px;>选择充值：</div></td>
            <td >

                <input type="radio" name="type" value="name" checked>用户名
                &nbsp;


                <input type="radio" name="type" value="id" > USERID
            </td>
        </tr>
        <TR align=left>
            <td ><div style=text-align:right;margin-right:5px;>用户名或ID：</div></td>
            <td >

                <input name="username" id="username" type="text" size="30" value="<?php echo $username;?>"   style="width: 200px"  required >

            </td>
        </tr>
        <TR align=left>
            <td ><div style=text-align:right;margin-right:5px;>充值金额：</div></td>
            <td >

                <input name="money" id="money" type="text" size="30" value=""  style="width: 120px"  required>元


                <span style="padding-left: 10px;color: #ff0000;font-size: 12px;">正数为加，负数为减</span>

            </td>
        </tr>
        <TR align=left>
            <td  ><div style=text-align:right;margin-right:5px;>充值渠道：</div></td>
            <td >

                <input type="radio" name="method" value="recharge" >银行转账
                &nbsp;


                <input type="radio" name="method" value="active" checked>活动赠送
            </td>
        </tr>

        <TR align=left>

            <td  ><div style=text-align:right;margin-right:5px;>备注：</div></td>
            <td >
                <input type="text" name="mark" value="">
            </td>
        </tr>

    </table>

    <table  width="100%" border="0" cellpadding="4" cellspacing="1"  style='clear:both;' class="table_add" >
        <tr  align=left>
            <td colspan=2 >
                <div style=height:30px;line-height:30px;text-align:left;margin:10px;padding-left:20%; >
                    <input type="submit" class=button value="保存" type="submit"  id=submit name="submit" >
                    &nbsp;&nbsp;
                    <input type="button" value='关闭' class='button' onclick="var index=parent.layer.getFrameIndex(window.name);

parent.layer.close(index);">
                </div>
            </td>
        </tr>

    </table>

</form>
