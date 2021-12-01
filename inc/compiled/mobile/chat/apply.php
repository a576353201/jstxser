

<?php include_once template("header");?>
<link rel="stylesheet" href="<?php echo $HttpTemplatePath; ?>static/css/group.css?v=<?php echo time(); ?>" type="text/css" media="screen" />
<script src="/static/js/group.js?v=<?php echo time(); ?>"></script>


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
    textarea{
      display: inline-block;
        height: 100px;
        padding: 5px 10px;
        width: calc(100% - 22px);
        border-radius: 5px;
        border: 1px solid #ddd;
    }
</style>


<ul class="layer_nav" style="height: 40px;line-height: 40px;">
    <li class="active">申请加入</li>

</ul>
<div style="text-align: center;height: 230px;width: 260px;margin: 0px auto;padding-top:10px;">
    <div class="info">
        <li>
            <img src="<?php echo $group['avatar']; ?>"/>

        </li>

        <li>
            <?php echo $group['name']; ?><br>
            ID：<?php echo $group['id']; ?>

        </li>
    </div>

    <div style="display: block;margin: 15px auto;width: 100%;">

        <textarea id="content" placeholder="我是..."></textarea>

    </div>



</div>



<div class="layer_btns cancel" onclick="closethis();"><i class="icon-cancel"></i>关闭</div>
<div class="layer_btns ok" onclick="apply();"><i class="icon-ok"></i>确认</div>
<script>

    window.onload=function () {

        var index = parent.layer.getFrameIndex(window.name);
        parent.layer.iframeAuto(index);
        document.querySelector('#content').focus();
    }
    function closethis() {
        var index = parent.layer.getFrameIndex(window.name);
        parent.layer.close(index);
    }
    var userid=parseInt('<?php echo $_SESSION['userid']; ?>');

    function  apply() {
        var data={type:'Apply_Group',userid:userid,group_id:'<?php echo $group['id']; ?>',content:$('#content').val()};
        parent.send_data(JSON.stringify(data));
        var index = parent.layer.getFrameIndex(window.name);
        parent.layer.close(index);
        parent.layer_loading=layer.load(1, {
            shade: [0.1,'#fff']
        });
        parent.layer_name= parent.layer.getFrameIndex(window.name);;
    }




</script>


