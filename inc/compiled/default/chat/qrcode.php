

<?php include_once template("header");?>

<link rel="stylesheet" href="<?php echo $HttpTemplatePath; ?>static/css/group.css" type="text/css" media="screen" />
<style>
    .info{
        width: 100%;
        display: table;
        table-layout: fixed;
        height: 50px;
        line-height: 50px;
        text-align: left;
    }
    .info > li{
        display: table-cell;
        vertical-align: middle;
        overflow: hidden;
        text-overflow:ellipsis;
        white-space: nowrap;
    }
    .info > li:first-child{
        width: 60px;

    }
    .info > li:first-child img{
        width: 50px;
        height: 50px;
        vertical-align: middle;
        border-radius: 5px;
    }
    .info > li:nth-child(2){
        line-height: 25px;
    }
</style>


<div style="text-align: center;height: 320px;width: 260px;margin: 0px auto;padding-top:10px;">
    <div class="info">
        <li>
            <img src="<?php echo $group['avatar']; ?>"/>

        </li>

        <li>
            <?php echo $group['name']; ?><br>
            ID：<?php echo $group['id']; ?>

        </li>
    </div>

    <div style="display: block;margin: 15px auto;width: 180px;height: 150px;padding: 15px 0px;background-image: url('/static/images/qrbg.png');background-size: 100% 100%">

        <img src="<?php echo $path; ?>" width="150px;" style="vertical-align: middle">

    </div>
    <div class="nodata">用浏览器扫描二维码</div>


</div>

