<?php

require_once "SmsSender.php";

    // 请根据实际 accesskey 和 secretkey 进行开发，以下只作为演示 sdk 使用
    $accesskey = "5e7f196defb9a33134987f23";
    $secretkey = "b9e78224ed794d1baf2e63983fa1e4a6";
    $phoneNumber = "16607977666";

    $singleSender = new SmsSingleSender($accesskey, $secretkey);

    // 普通单发
    $result = $singleSender->send(0, "86", $phoneNumber , "【Kewail科技】您注册的验证码：128128有效时间30分钟。", "", "");
    $rsp = json_decode($result);

