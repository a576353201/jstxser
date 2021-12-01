<?php
include_once '../inc/common.php';
$system=get_system();

if($_GET['type'])$type=$_GET['type'];
else $type=0;
if($type==1){
    $title="用户协议";
    $content=$system['tipcon1'];
}
else{
    $title='隐私条款';
    $content=$system['tipcon2'];
}
?>
<!DOCTYPE html>
<html lang=en>

<head>
    <meta charset=utf-8>
    <meta http-equiv=X-UA-Compatible content="IE=edge">
    <meta name=viewport content="width=device-width,initial-scale=1,user-scalable=no">
    <link rel=icon href='favicon.ico'>

    <title><?php echo $title;?></title>
    <meta name="description" content="<?php echo $system['description'];?>" />
    <meta name="keywords" content="<?php echo $system['keywords'];?>" />
<style>

    body{
    width: 1200px;
        margin: 0 auto;
        display:block ;
        color: #333;
        font-size: 14px;
    }
    .title{
        margin-top: 20px;
        line-height: 50px;
        text-align: center;
        font-size: 20px;
        font-weight: 700;
    }

    .content{
        text-align: left;
        line-height: 30px;
    }
    .content view{
        display: block;

    }
</style>


</head>

<body>
 <div class="title"><?php echo $title;?></div>
 <div class="content"><?php echo $content;?></div>
</body>



</html>
