<?php
include_once '../inc/header.php';


$circle=get_table(tname('circle'),$_GET['id']);
$user=userinfo($circle['userid']);
$imgs=unserialize($circle['value']);
$like=unserialize($circle['like']);
$comment=unserialize($circle['comment']);
?>



    <div style="line-height: 40px;padding: 10px;text-align: left">
<div style="color: #666">
    <?php echo $user['nickname']; ?>发布于：<?php echo date('Y-m-d H:i:s',$circle['time']);?>

</div>

        <div style="line-height: 30px;">
            <?php
            echo $circle['text']
            ?>

        </div>

<div>
    <?php
    if(count($imgs)>0){
        foreach ($imgs as $v){
            ?>
            <img src="<?php  echo $HttpPath.$v;?>" onclick="showimg(this.src);" style="height:100px;width:100px;padding: 0px 10px;vertical-align: middle">
            <?php
        }
    }
    ?>

</div>
 <?php if(count($like)>0){
   ?>
        <div style="color: #00aaee">
            <img src="/static/push/circle/liked.png" style="height: 20px;vertical-align: middle"/>
            <?php
            foreach ($like as $value){
                echo $value['username'] .'&nbsp;';
            }
            ?>


        </div>

        <?php
} ?>


        <?php if(count($comment)>0){
            ?>
            <div style="color: #00aaee">

                <?php
                foreach ($comment as $value){
                   $user=userinfo($value['uid']);
                    ?>

                <div style="padding-left: 10px;background-color: #eee;color: #333;line-height: 30px;border-bottom: 1px dashed #ccc;">

                    <?php
                    echo $user['nickname']
                    ?>
                    :<?php
                    echo $value['content'];
                    ?>
                </div>
                <?php
                }
                ?>


            </div>

            <?php
        } ?>




</div>

    </div>





<script>
    function showimg(src) {
        var img = "<img src='"+src+"' />";
        layer.open({
            type:1,
            shift: 2,
            maxmin: true,
            shadeClose: true,
            title:'查看图片',

            content:img
        });


    }

</script>
