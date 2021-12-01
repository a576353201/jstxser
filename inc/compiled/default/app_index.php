<?php include_once template("header");?>


<link rel="stylesheet" href="<?php echo $HttpTemplatePath; ?>51cp/static/web/css/downloadApp/app.css" type="text/css"/>
<style>
    body{
        background-color: #e9e9e9;
    }


    .public-top-box>ul>li:first-child p {float: left;margin-right: 10px !important;}
    .public-top-box>ul>li:last-child p {float: right;margin-left: 10px !important;}
    .logo-pic img{width:80px;height: 80px;}
    .top-title {margin-left:-15px;padding:10px 0 0 0;width: 1170px;margin-top: 10px;background-color: #ffffff;}
    .common-title {width:1170px;padding:0 0 10px 10px;font-size:16px;font-weight:700;color: #000000;}
    .top-title ul {overflow: hidden;}
    .top-title ul li {float: left;width:calc(25% - 10px);padding:15px 10px;border:1px solid #dddddd;margin: 10px 5px;}
    .top-title ul li table {margin: 0 auto;}
    .top-title ul li table tbody tr td:last-child {text-align: left;padding-left:25px;}
    .top-title ul li table tbody tr td:last-child span{display: block;}
    .logo-font a:first-child{color: #000000;font-size: 15px;font-weight: 700;}
    .logo-font span:nth-child(2) {margin: 3px 0 8px 0;}
    .logo-font span:nth-child(2),.logo-font span:nth-child(2) a{color: #999999;font-size: 13px;text-decoration: none;}
    .logo-font a:nth-child(3) {padding:2px 15px;border:1px solid #dddddd;border-radius:3px;text-decoration: none;cursor: pointer;}
    .ewm-pic{width:80px;height: 80px;}
    .table-ewm {background-color: #e9e9e9;width: 265px;margin-top: 15px !important;}
    .table-ewm tr td{padding-left: 0 !important;width: 120px;padding: 10px 0;height: 135px;}
    .table-ewm tr td:last-child {text-align: center !important;border-left:1px solid #ffffff;}
    .ios-pic {width: 80px;margin:5px auto 0 auto !important;background:url(https://file52cp.oss-cn-hangzhou.aliyuncs.com/static/web/images/appImage/apple1.png) no-repeat;background-size:18%;padding-left: 22px;background-position:6px 0;}
    .android-pic {width: 80px;margin:5px auto 0 auto !important;background:url(https://file52cp.oss-cn-hangzhou.aliyuncs.com/static/web/images/appImage/and1.png) no-repeat;background-size:18%;padding-left: 20px;background-position:3px 0;}
    .ys {background-color: #e9e9e9;position: absolute;width: 8px;height:47px;top: -10px;left:284px;}
    .zh-app {position: absolute;left: 10px;top: 0;color:#ff0000;font-size: 18px;}
    .ewm-code {width: 80px;margin: 0 auto;}
    .ewm-code img{width: 80px;}
</style>

<div class="cst-content" style="background-color:rgba(255,255,255,0);">
    <div class="container index-body" style="padding-top: 15px; padding-bottom: 15px;">
        <div class="index-app-box">

            <div class="index-app-box1" style=" background-color: #ffffff;margin-left: -15px;width: 1170px;padding: 10px;">
                <span><img src="<?php echo $HttpTemplatePath; ?>51cp/static/web/images/appImage/app-font_03.png"></span>
                <span>下载中心</span>
                <b style="color:deeppink;float: right;margin-top: 5px;margin-left:10px;">注意：【切勿使用微信扫描下载】</b>
                <b style=" float: right; line-height: 30px;font-size:16px;">推荐使用<font style="color:red;font-size: 18px;margin:0 3px;">支付宝扫码</font>或者<font style="color:red;font-size: 18px;margin:0 3px;">手机浏览器</font>扫码以下二维码</b>
                <!--<span data-toggle="modal" data-target="#myModal" ><img src="/Public/Home/images/applegif.gif"> </span>-->
            </div>

            <div class="top-title">

                <div>
                    <ul>
                        <?php if(is_array($list)){foreach($list AS $index=>$value) { ?>

                        <li>
                            <table>
                                <tbody>
                                <tr>
                                    <td class="logo-pic">
                                        <a href="info?id=<?php echo $value['id']; ?>">
                                            <img src="<?php echo $HttpPath; ?><?php echo $value['logo']; ?>"></a>
                                    </td>
                                    <td class="logo-font">
                                        <a href="info?id=<?php echo $value['id']; ?>"><?php echo $value['title']; ?></a>
                                        <span><a><?php echo $value['downnum']; ?>万下载</a>&nbsp;|&nbsp;<a><?php echo $value['size']; ?>MB</a></span>
                                        <a href="info?id=<?php echo $value['id']; ?>">详情</a>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                            <table class="table-ewm">
                                <tbody>
                                <tr>
                                    <?php if($value['android']){?>
                                    <td>
                                        <a href="info?id=<?php echo $value['id']; ?>">
                                            <div class="ewm-code" >
                                   <img src="<?php echo $HttpPath; ?><?php echo $value['android']; ?>" style="display: block;"></div>
                                            <p class="android-pic">安卓下载</p>
                                        </a>
                                    </td>
                                    <?php }?>

                                    <?php if($value['ios']){?>
                                    <td>
                                        <a href="info?id=<?php echo $value['id']; ?>">
                                            <div  class="ewm-code" >
                                                <img src="<?php echo $HttpPath; ?><?php echo $value['ios']; ?>" style="display: block;"></div>
                                            <p class="android-pic">IOS下载</p>
                                        </a>
                                    </td>
                                    <?php }?>
                                </tr>
                                </tbody>
                            </table>
                        </li>

                        <?php }}?>

                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>


<?php include_once template("footer");?>
