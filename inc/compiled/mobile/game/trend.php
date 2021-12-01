

<?php include_once template("header");?>
<?php include_once template("game/header");?>


<link rel="stylesheet" href="<?php echo $HttpTemplatePath; ?>51cp/static/web/css/jsk3/basicTrend.css?v=c167ceaa2357dd0f98caf9a7514f1ea5" type="text/css"/>
<link rel="stylesheet" href="<?php echo $HttpTemplatePath; ?>51cp/static/web/h5/css/trend_ssc.css?v=c167ceaa2357dd0f98caf9a7514f1ea5" type="text/css"/>
    <div class="container cst-mainbody" style="padding:0;">

        <?php include_once template("$tpl_name");?>
  </div>
<article class="trend-panel-seting fh fh-ver" style="transform: translate3d(0px, 0px, 0px); transition: 300ms ease;">
    <div class="trend-panel-seting-header">
        <ul class="fh">
            <li class="fh-f1"><?php echo $gameinfo['title']; ?><?php echo $pos_wei[$pos_type]; ?><?php echo $pos_arr[$pos_type][$pos_num]; ?></li>
            <li id="trend-seting-close">关闭<i class="iconfont icon-2"></i></li>
        </ul>
    </div>
    <div class="fh-f1" style="overflow-y: auto;">
        <div class="trend-panel-seting-item1">
            <ul>
                <li>期数</li>
            </ul>
            <ul id="extend_1" class="fh fh-ac fh-wp  common-zs-all-kind-top-issue" data-type="period">



                <span data-val="0db" data-type="period">今日</span>
                <span data-val="1db" data-type="period">昨日</span>
                <span data-val="2db" data-type="period">前日</span>
                <span data-val="10" data-type="period">10期</span>
                <span data-val="30" data-type="period" class="active">30期</span>
                <span data-val="100" data-type="period">100期</span>
                <span data-val="300" data-type="period">300期</span>
                <span data-val="1000" data-type="period">1000期</span>
            </ul>

            <ul class="common-zs-all-kind-top-other">
                <span data-val="0" class="active">连期</span>
                <span data-val="2">后二同期</span>
                <span data-val="3">后一同期</span>
                <span data-val="4">同时分</span>
                <span data-val="5">单期</span>
                <span data-val="6">双期</span>
            </ul>


        </div>
        <div class="common-zs-all-kind-bottom">
            <div class="left-form">
                <form class="layui-form">
                    <div class="layui-form-item left-form">
                        <ul>
                            <li style="padding-left: 10px;font-weight: 600;color:#222;">显示</li>
                        </ul>
                        <div class="layui-input-block">
                            <input type="checkbox" name="demo-check" lay-skin="primary" lay-filter="yl" title="遗漏" value="遗漏" checked=""><div class="layui-unselect layui-form-checkbox layui-form-checked" lay-skin="primary"><span>遗漏</span><i class="layui-icon"></i></div>
                            <input type="checkbox" name="demo-check" lay-skin="primary" lay-filter="ylfc" title="遗漏分层"><div class="layui-unselect layui-form-checkbox" lay-skin="primary"><span>遗漏分层</span><i class="layui-icon"></i></div>
                            <input type="checkbox" name="demo-check" lay-skin="primary" lay-filter="fhx" title="分行线"><div class="layui-unselect layui-form-checkbox" lay-skin="primary"><span>分行线</span><i class="layui-icon"></i></div>
                            <input type="checkbox" name="demo-check" lay-skin="primary" lay-filter="flx" title="分列线" checked=""><div class="layui-unselect layui-form-checkbox" lay-skin="primary"><span>分列线</span><i class="layui-icon"></i></div>
                            <input type="checkbox" name="demo-check" lay-skin="primary" lay-filter="ych" title="预测行"><div class="layui-unselect layui-form-checkbox" lay-skin="primary"><span>预测行</span><i class="layui-icon"></i></div>
                            <input type="checkbox" name="demo-check" lay-skin="primary" lay-filter="date" title="年月日">
                            <input type="checkbox" name="demo-check" lay-skin="primary" lay-filter="hour" title="时分">
                            <input type="checkbox" name="demo-check" lay-skin="primary" lay-filter="total" title="统计" checked=""><div class="layui-unselect layui-form-checkbox layui-form-checked" lay-skin="primary"><span>统计</span><i class="layui-icon"></i></div>
                        </div>
                    </div>
                </form>
            </div>

            <form class="layui-form">
                <div class="layui-form-item">
                    <label class="layui-form-label"  style="text-align: left;" >球形:</label>
                    <div class="layui-input-block" style="margin-left: 0px;">
                        <input type="radio" name="kind" value="0" lay-filter="kind" title="圆" checked>
                        <input type="radio" name="kind" value="1" lay-filter="kind" title="方">
                    </div>
                </div>
            </form>

            <form class="layui-form">
                <div class="layui-form-item">
                    <label class="layui-form-label" style="text-align: left;">颜色:</label>
                    <div class="layui-input-block" style="margin-left: 0px;">
                        <input type="radio" name="kind" value="0" lay-filter="color" title="彩色" checked>
                        <!--<input type="radio" name="kind" value="1" lay-filter="color" title="全红">-->
                        <input type="radio" name="kind" value="2" lay-filter="color" title="全白">
                    </div>
                </div>
            </form>


        </div>

    </div>
    <div class="trend-panel-seting-item3">
        <ul class="fh">
            <li class="fh-f1"></li>
            <li id="seting_btn_res">重置</li>
            <li id="seting_btn_ok">确定</li>
        </ul>
    </div>
</article>


<script>



    $(function () {


        $("body").delegate(".trend-isedit td", "click", function () {
            var i = $(this).data("index");
            if ($(this).hasClass("trend-select-num")) {
                var val = $(this).data("val");
                var zArr = baseTrendVm.data[i];
                var aIndex = zArr.zuxuan.indexOf(-1);
                if ($(this).children("p").length) {
                    var bIndex = zArr.zuxuan.indexOf(val);
                    zArr.zuxuan[bIndex] = -1;
                } else {
                    if (zArr.zuxuan.indexOf(-1) == -1) {
                        layer.msg('最多选5个号码!');
                    }
                    zArr.zuxuan[aIndex] = val;
                }
                baseTrendVm.$set(baseTrendVm.data, i, zArr);
                window.setTimeout(function () {
                    getPos();
                }, 30);
            }
        });
        //点击设置按钮
        $("#seting_btn").click(function () {
            var width = document.body.clientWidth;
            $("article").css({"transform": "translate3d(-" + width + "px, 0px, 0px)", "transition": "300ms ease"});
            $(document.body).toggleClass("html-body-overflow");
        });

        //关闭设置界面
        $("#trend-seting-close").click(function () {
            $("article").css({"transform": "translate3d(0px, 0px, 0px)", "transition": "300ms ease"});
            $(document.body).toggleClass("html-body-overflow");
        });

        //设置选项
        $("#extend_1").delegate("li", "click", function () {
            //选择期数
            var val = $(this).data("val");
            tempArr.param.period = val;
            baseData.param.period = val;
            $(this).addClass("active").siblings("li").removeClass("active");
            $("#trend-seting-close").click();
            goUrl();
        });
        $("#extend_2").delegate("li", "click", function () {
            //选择期数段
            var val = $(this).data("val");
            baseData.param.filter = val;
            $(this).addClass("active").siblings("li").removeClass("active");
            $("#trend-seting-close").click();
            baseData.set.daoxu = true;
            tempArr.set.daoxu = true;
            goUrl();
        });
        $("#extend_3").delegate("li", "click", function () {
            //选择显示杂项
            var parent = $(this).closest("ul");
            var arr = [];
            $(this).toggleClass("active");
            parent.children("li").each(function () {
                if ($(this).hasClass("active")) {
                    arr.push($(this).data("val"));
                }
            });
            tempArr.set.show = arr;
        });
        $("#extend_4").delegate("p", "click", function () {
            //选择号码球形状
            var val = $(this).data("val");
            tempArr.set.shape = val;
            $(this).addClass("active").siblings("p").removeClass("active");
        });
        $("#extend_5").delegate("p", "click", function () {
            //选择号码球颜色
            var val = $(this).data("val");
            tempArr.set.color = val;
            $(this).addClass("active").siblings("p").removeClass("active");
        });
        //设置点击重置就刷新页面
        $("#seting_btn_res").click(function () {
            window.location.reload();
        });
        //设置里点击确定
        $("#seting_btn_ok").click(function () {
            var newArr = JSON.stringify(tempArr);
            var data = JSON.parse(newArr);
            baseData.param = data.param;
            baseData.set = data.set;
            $("#trend-seting-close").click();
        });
    });

</script>

<?php include_once template("footer");?>

</body>
</html>
