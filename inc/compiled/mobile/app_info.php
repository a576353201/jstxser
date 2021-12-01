<?php include_once template("header");?>

<link rel="stylesheet" href="<?php echo $HttpTemplatePath; ?>51cp/static/web/css/downloadApp/app.css" type="text/css"/>

<style>
    .return-download {width:100px;height:30px;line-height: 30px;background-color:#efefef;display: inline-block;float: right;text-align: center;border:1px solid #dddddd;border-radius:3px;}
    .lottery-info {max-width:640px;background-color: #ffffff;margin-left:-15px;padding:20px 10px;}
    .lottery-table span{display:block;}
    .lottery-table tbody tr td:last-child {text-align:left;padding-left: 25px;}
    .lottery-table tbody tr td:last-child span:first-child {font-size: 18px;font-weight: 700;color: #000000;}
    .lottery-table tbody tr td:last-child span:nth-child(2) {color: #999999;margin: 5px 0;}
    .lottery-table tbody tr td:last-child span:nth-child(2) a{color: #999999;text-decoration: none;}
    .lottery-table tbody tr td:last-child span:nth-child(3) a{color: #999999;margin-right: 20px;text-decoration: none;}
    .lottery-pic {width: 80px;height: 80px;}
    .lottery-info-div {padding:10px 15px;overflow: hidden;}
    .lottery-info-div table.lottery-ewm {float: right;margin-top: -10px;}
    .lottery-info-div table.lottery-table {float: left;}
    .ewm-pic {width: 90px;height: 90px;}
    .ios-pic {width: 90px;color: #ffffff;border-radius:10px;font-size: 13px;margin:5px auto 0 auto !important;background:#e86d42 url(https://file52cp.oss-cn-hangzhou.aliyuncs.com/static/web/images/appImage/apple2.png) no-repeat;background-size:15%;padding-left: 20px;background-position:11px 0;}
    .android-pic {width: 90px;color: #ffffff;border-radius:10px;font-size: 13px;margin:5px auto 0 auto !important;background:#42a8e8 url(https://file52cp.oss-cn-hangzhou.aliyuncs.com/static/web/images/appImage/and2.png) no-repeat;background-size:15%;padding-left: 20px;background-position:11px 0;}
    .lottery-intro {padding:15px 10px;border-top:1px solid #EEEEEE;margin-top: 10px;}
    .lottery-intro p {font-size: 13px;color: #000000;}
</style>

<div class="cst-content" style="background-color:rgba(255,255,255,0);">
    <div class="container index-body" style="padding-top: 15px; padding-bottom: 15px;">
        <div class="index-app-box">
            <div class="index-app-box1" style=" background-color: #ffffff;max-width:640px;padding: 10px;border-bottom:1px solid #EEEEEE;">
                <span><img src="<?php echo $HttpTemplatePath; ?>51cp/static/web/images/appImage/app-font_03.png"></span>
                <b style=" float: left; line-height: 30px;font-size:16px;margin-left:30px;">推荐使用<font style="color:red;font-size: 18px;margin:0 3px;">支付宝扫码</font>或者<font style="color:red;font-size: 18px;margin:0 3px;">手机浏览器</font>扫码下载</b>
                <b style="color:deeppink;float: left;margin-top: 5px;margin-left:10px;">注意：【切勿使用微信扫描下载】</b>
                <a class="return-download" href="index.php">返回下载页</a>
            </div>
            <div class="lottery-info">
                <div>
                    <div class="lottery-info-div">
                        <table class="lottery-table">
                            <tbody>
                            <tr>
                                <td><img class="lottery-pic" src="<?php echo $HttpPath; ?><?php echo $app['logo']; ?>"></td>
                                <td>
                                    <span><?php echo $app['title']; ?></span>
                                    <span><a><?php echo $app['downnum']; ?>万下载</a>&nbsp;|&nbsp;<a><?php echo $app['size']; ?>MB</a></span>
                                    <span><a>版本:<?php echo $app['version']; ?></a><a>更新:<?php echo $app['updatetime']; ?></a></span>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <table class="lottery-ewm">
                            <tbody>
                            <tr>
                                <?php if($app['ios']){?>
                                <td style="width: 100px;text-align: center">
                                    <a href="#">
                                        <div id="code-ios" class="ewm-code" >
                                            <img src="<?php echo $HttpPath; ?><?php echo $app['ios']; ?>" style="width: 80px">

                                        </div>
                                        <p class="ios-pic">IOS下载</p>
                                    </a>
                                </td>
                                <?php }?>


                                <?php if($app['android']){?>
                                <td style="width: 100px;text-align: center">
                                    <a href="#">
                                        <div id="code-android" class="ewm-code" >
                                            <img src="<?php echo $HttpPath; ?><?php echo $app['android']; ?>" style="width: 80px">

                                        </div>
                                        <p class="android-pic">安卓下载</p>
                                    </a>
                                </td>
                                <?php }?>

                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="lottery-intro">
                        <p><?php echo $app['content']; ?></p>
                    </div>
                    <div>
                        <div class="index-app-box3 index-box-content-pk10">
                            <div class="customer">
                                <div class="Pro_con cus_com" style="background-color:pink;">
                                    <div class="slideGroup">
                                        <div class="parBd">
                                            <div class="cus_Con">
                                                <a href="javascript:void(0)" class="cusb cus_pre"></a>
                                                <div class="tempWrap" style="overflow:hidden; position:relative; width:1036px">
                                                    <ul style="position: relative; overflow: hidden; ">
                                               <?php if(is_array($images)){foreach($images AS $index=>$value) { ?>
                                                        <?php if($value){?>
                                                <li class="Pro_list cus_list clone" style="float: left; width: 229px;">

                                                    <div class="pic">
                                                        <a href="" target="_self"><img src="<?php echo $HttpPath; ?><?php echo $value; ?>"></a>
                                                    </div>


                                                </li>
                                                        <?php }?>
                                              <?php }}?>
                                                   </ul></div>
                                                <a href="javascript:void(0)" class="cusb cus_next"></a>
                                            </div>
                                        </div>
                                        <span class="common-sj">
                                            <img src="//file52cp.oss-cn-hangzhou.aliyuncs.com/static/web/images/appImage/sj_03.png">
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<script type="text/javascript" src="<?php echo $HttpPath; ?>static/web/js/downloadApp/jquery.SuperSlide.2.1.1.js"></script>
<script type="text/javascript" src="<?php echo $HttpPath; ?>static/web/js/downloadApp/indexa.js"></script>


<?php include_once template("footer");?>
