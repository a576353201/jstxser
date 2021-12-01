<?php
include_once 'inc/common.php';
$system=get_system();
?>
    <!DOCTYPE html>
    <html lang=en>

<head>
    <meta charset=utf-8>
    <meta http-equiv=X-UA-Compatible content="IE=edge">
    <meta name=viewport content="width=device-width,initial-scale=1,user-scalable=no">
    <link rel=icon href='favicon.ico'>

    <title><?php echo $system['title'];?></title>
    <meta name="description" content="<?php echo $system['description'];?>" />
    <meta name="keywords" content="<?php echo $system['keywords'];?>" />

</head>



    <body>

<?php



if(isMobile()){
    if($_REQUEST['invite_code']){
        echo "<script>window.location='/h5/#/pages/login/index?invite_code={$_REQUEST['invite_code']}';</script>";
    }else{
        echo "<script>window.location='/h5/#/pages/index/index';</script>";
    }

}else{

    if($_SESSION['userid']>0){
        echo "<script>window.location='pc/login.php';</script>";
    } else{
        if($_REQUEST['invite_code']){
            session_start();
            $_SESSION['invite_code']=$_REQUEST['invite_code'];
            echo "<script>window.location='pc/login.php?type=reg';</script>";
        }
        else{
            echo "<script>window.location='pc/login.php';</script>";
        }
    }



}


?>
    </body>
</html>