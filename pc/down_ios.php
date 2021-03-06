<?php
include_once '../inc/common.php';
$system=get_system();
?>
<!DOCTYPE html>
<html lang=en>

<head>
    <meta charset=utf-8>
    <meta http-equiv=X-UA-Compatible content="IE=edge">
    <link rel=icon href='favicon.ico'>
    <meta name="viewport" content="width=device-width,initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no,minimal-ui">
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent" />
    <meta content="telephone=no" name="format-detection" />
    <title><?php echo $system['title'];?></title>
    <meta name="description" content="<?php echo $system['description'];?>" />
    <meta name="keywords" content="<?php echo $system['keywords'];?>" />
 <style>

     body{
         background-color: #2953ff;

        background-size: 100% 100%;
         padding: 10px 0px;
         text-align: center;
        width: 100%;
         max-width: 750px;
         margin: 0 auto;
  font-size: 14px;
     }

     div ,p,span,ul,li{
         padding: 0px 0px;
         margin: 0px 0px;
     }
     .title{
         height:40px;
         line-height:50px;
         color:#fff;
         font-size: 30px;
         font-weight: 700;
     }
     .item{
         text-align: center;
         background: #fff;
         border: 1px solid #979797;
         border-radius: 15px;

         padding: 10px 20px;
        line-height: 30px;
         color:#333;
         width: calc(100% - 70px);
         margin: 15px auto;
     }
     .item .step{
         height: 30px;
         line-height:30px;
         color:#2953ff;
         font-size: 14px;

     }
     .item .btn{
         display: inline-block;
         width:100%;
         height: 40px;
         line-height: 40px;
         background: #0066ed;
         border-radius: 5px;
         font-size: 16px;
         color: #fff;
         text-align: center;
         margin: 0px 0 10px;
         text-decoration: none;
     }
     .item img{
         width: 100%;
         margin: 10px 0px;
     }

 </style>

</head>

<body>
<div class="title">IOS????????????</div>

<div class="item">
    <div class="step">?????????</div>
  <p>??????TestFlight</p>
    <a href="<?php echo $system['down_tf']?>" class="btn" target="_blank">????????????TestFlight</a>
    <p>????????????????????????App Store?????????????????????</p>
    <img src="style/images/down/step1.png">
</div>

<div class="item">
    <div class="step">?????????</div>
    <p>???TestFlight?????????itel</p>
    <a href="<?php echo $system['down_tf']?>" class="btn" target="_blank">??????itel??????</a>
    <p>????????????????????????????????????</p>
    <img src="style/images/down/step2.png">
</div>

<div class="item">
    <div class="step">?????????</div>
    <p>??????????????????</p>
    <img src="style/images/down/step3.png">
    <p>?????????????????????App????????????</p>

</div>
<p style="color: #fff;padding: 10px 20px;">?????????????????????????????????????????? testflight ???????????????????????????????????????</p>

</body>
</html>