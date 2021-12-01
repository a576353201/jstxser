<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; minimum-scale=1.0; user-scalable=false;"  />
    <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE9,chrome=1">

    <meta name="format-detection" content="telephone=no" />
    <meta name="apple-mobile-web-app-capable" content="yes" />

    <title><?php echo $web_title; ?><?php if($web_title!=$system['title']){?>-<?php echo $system['title']; ?><?php }?></title>
    <meta name="keywords" content="<?php echo $system['title']; ?>">
    <meta name="description" content="<?php echo $system['description']; ?>">
    <link rel = "Shortcut Icon"  href="/favicon.png" />

    <link rel="stylesheet" href="<?php echo $HttpTemplatePath; ?>static/css/common.css?v=<?php echo $cachekey; ?>" type="text/css" media="screen" />
    <script type="text/javascript" src="/static/js/jquery-1.9.1.js"></script>
    <script type="text/javascript" src="/static/layui/layui.all.js" ></script>

    <link rel="stylesheet" href="/static/fontello.css" />
</head>

<body  >
