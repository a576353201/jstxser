<?php
include_once '../inc/header.php';



$info=$plat=get_table(tname('user_report'), $_GET['id']);
$user=userinfo($info['userid']);


if($_POST){
    if($_POST['status']==2) {

        $content="您投诉的用户：<span style=\"color:#2319dc\">{$user['nickname']}</span>,投诉<span style=\"color:#ff4d51\">失败</span>";
        if($_POST['mark']){
            $content.="<br><span style=\"color: #999\"> 原因：</span>".$_POST['mark'];
        }

    }else{
        $content="您投诉的用户：<span style=\"color:#2319dc\">{$user['nickname']}</span>,投诉<span style=\"color:#ff4d51\">成功</span>";

        if($_POST['mark']){
            $content.="<br><span style=\"color: #999\"> 处理结果：</span>".$_POST['mark'];
        }

        //
    }
    $db->update(tname('user_report'), $_POST, $_GET['id']);
    add_note(0,$info['fromid'],$content);
    ?>
    <script>

        parent.layer.msg('操作成功',{ type: 1, anim: 2 ,time:1000});
        //      var index = parent.layer.getFrameIndex(window.name);
        //      parent.layer.close(index);
        setTimeout(function () {
            parent.location.reload();
        },1000)
    </script>

    <?php
    exit();
}


?>


<style>
    ul{margin: 0 auto; width:95%;line-height:40px;padding-left: 30px;}
    ul li span:first-child{
        display: inline-block;
        width: 100px;
        padding-right: 10px;
        text-align: right;
    }
</style>
<form name='formSort' enctype="multipart/form-data" action="?type=sub&id=<?php echo $_GET['id'];?>&from=parent"  method="post">

    <ul >
        <li><span>被举报人账号：</span>
            <?php echo $user['name']?>

        </li>

        <li><span>被举报人昵称：</span>
            <?php echo $user['nickname']?>

        </li>

        <li><span>举报理由：</span>
            <?php
            echo $info['content']
            ?>
        </li>







        <?php

        if($plat['status']==0){
            ?>

            <li><span>处理状态：</span>

                <input type="radio"  name='status' value='1'>举报成功
                &nbsp;   &nbsp;   &nbsp;
                <input type="radio"  name='status' value='2'>举报失败
            </li>

        <?php }else{?>

            <li><span>提现状态：</span><?php echo $plat_status[$plat['status']]?>


            </li>

        <?php }?>
        <?php
        $tips=explode('|',$system['reportdeny_tips']);
        if(count($tips)>0){
            ?>
            <li id="mark1"><span>备注：</span>

                <select name="markselect" onchange="change_mark(this.value);">
                    <option value="">请选择</option>
                    <?php
                    foreach ($tips as  $key=>$value){
                        ?>
                        <option value="<?php echo $value;?>" <?php if($value== $plat['mark']) echo "selected"; ?>><?php echo $value;?></option>
                        <?php
                    }
                    ?>
                    <option value="-1">自定义</option>
                </select>

            </li>
            <?php
        }
        ?>


        <li  id="mark2" <?php if(count($tips)>0) echo "style='display:none'"; ?>><span>备注：</span>
            <textarea style="width:300px;height: 80px;" name='mark' id="mark"><?php echo $plat['mark']?></textarea>

        </li>

        <li  style='margin-top:15px;'>
            <span></span>
            <input type="submit" class='btn100' value='确认并提交' <?php  if($plat['status']==0){ ?>onclick="return click_sub();" <?php } ?>>
        </li>
    </ul>
</form>


<script type="text/javascript">

    function  change_mark( value) {

        if(value=='-1'){

            document.querySelector('#mark2').style.display='';
        }
        else{

            document.querySelector('#mark2').style.display='none';
            document.querySelector('#mark').value=value;
        }
    }

    function click_sub(){

        var sta=document.getElementsByName('status');

        var  temp=0;
        for(var i=0;i<sta.length;i++){
            if(sta[i].checked)  temp=sta[i].value;
        }
        if(temp==0) {

            alert('请选择处理状态'); return false;
        }
    }
    //    var index = parent.layer.getFrameIndex(window.name);
    //parent.layer.close(index);

</script>

