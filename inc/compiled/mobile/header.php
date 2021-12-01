<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/html" xmlns="http://www.w3.org/1999/html">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no,minimal-ui">
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent" />
    <meta content="telephone=no" name="format-detection" />

    <title><?php echo $system['title']; ?></title>
    <meta name="description" content="<?php echo $system['description']; ?>" />
    <meta name="keywords" content="<?php echo $system['keywords']; ?>" />
    <link rel="stylesheet" href="<?php echo $HttpTemplatePath; ?>static/css/common.css?v=<?php echo $cachekey; ?>" type="text/css" media="screen" />
    <link rel="stylesheet" type="text/css" href="/static/fontello.css" />
    <script src="/static/js/jquery-1.9.1.js" type="text/javascript" ></script>
    <script src="/static/layui/layui.all.js"></script>
    <script src="/mobile/static/main.js?v=<?php echo $cachekey; ?>" type="text/javascript" ></script>
<script>
    var islock=parseInt(<?php echo $islock; ?>);
    var locktime=parseInt(<?php echo $locktime; ?>);
    var ismobile=1;
</script>
</head>
<body>