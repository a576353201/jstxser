<?php include_once template("header");?>
<?php include_once template("game/header");?>

    <div class="container cst-mainbody" style="background-color: #ffffff;">
        <div class="location-box"  style="width: 1170px;background-color: #e9e9e9;margin:0 0 10px -15px;">
            <ul>
                <li></li>
                <li>
                    <span>当前位置:</span>
                    <a href="<?php echo $HttpPath; ?>"><?php echo $system['web_title']; ?></a> > <a href="home_<?php echo $gameinfo['showkey']; ?>.html"><?php echo $gameinfo['title']; ?></a> > <a href="#">历史开奖</a>
                </li>
            </ul>
        </div>
        <div class="lg-history">
            <div class="lg-history-div">
                <div class="lg-history-title" style="overflow: hidden;">
                    <div style="float:left;"><?php echo $gameinfo['title']; ?>历史开奖</div>
                    <div style="float:left;margin-left: 100px;" class="select-period">
                        <a>选择期数:</a>
                        <?php if(is_array($shownum_arr)){foreach($shownum_arr AS $key=>$value) { ?>
                        <span onclick="location.href='home_<?php echo $gamekey; ?>.html?shownum=<?php echo $value; ?>'" <?php if($value==$shownum){?>class='active'<?php }?> >近<?php echo $value; ?>期</span>
                        <?php }}?>

                    </div>
                </div>
                <div class="lg-history-date">
                    <div class="lg-home-history-check">
                        <div class="lg-home-check">查询</div>
                        <div class="layui-form">
                            <div class="layui-form-item" style="margin-bottom:0;">
                                <div class="layui-inline" style="margin-bottom:0;margin-right:0;">
                                    <div class="layui-input-inline">

                                        <input type='text' class='layui-input' id='date' name='date' value="<?php echo $date;?>"  required   onclick="WdatePicker({dateFmt:'yyyy-MM-dd',alwaysUseStartDate:false})">

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="dataDownload">
<form action="excel.php" method="get" target="_blank">
<input type="hidden" name="title" value="<?php echo $gameinfo['title']; ?><?php echo $date; ?>开奖记录">
    <input type="hidden" name="date" value="<?php echo $date; ?>">
    <input type="hidden" name="gamekey" value="<?php echo $_GET['gamekey']; ?>">
    <button class="dchm" onclick="export_data();" style="padding:8px 10px;background-color:#ffffff;height:38px;">数据下载</button>
</form>


                </div>
            </div>
            <div class="lg-history-table">
                <?php include_once template("$tpl_name");?>
            </div>
        </div>
    </div>

<?php include_once template("footer");?>

<script>



    $(function () {





        //点击查询
        $(".lg-home-check").click(function () {

            var url='?date='+document.getElementById('date').value;
           location.href=url;
        });







        //点击显示大小 单双 对子等
        $("body").delegate('.show-pk10 span','click',function () {
            $(this).addClass('active').siblings().removeClass('active');
            var val = $(this).data('val');

            //大小
            if(val == 2){
                $(".kjh-num-zh").hide();
                $(".kjh-num").show();
                newHm();
                $(".kjh-num p span").removeClass('defalut');
                $(".kjh-num p span").removeClass('def_big');
                $(".kjh-num p span").removeClass('def_small');
                $(".kjh-num p span").removeClass('def_shuang');
                $(".kjh-num p span").removeClass('def_dan');
                $(".kjh-num").each(function (index,item) {
                    $(this).children().each(function (k,i) {
                        if($(this).text() > 5){
                            $(this).children().text('大');
                            $(this).children().addClass('def_big');
                        }else{
                            $(this).children().text('小');
                            $(this).children().addClass('def_small');
                        }

                    })
                })
            }

            //单双
            if(val == 3){
                $(".kjh-num-zh").hide();
                $(".kjh-num").show();
                newHm();
                $(".kjh-num p span").removeClass('defalut');
                $(".kjh-num p span").removeClass('def_big');
                $(".kjh-num p span").removeClass('def_small');
                $(".kjh-num p span").removeClass('def_shuang');
                $(".kjh-num p span").removeClass('def_dan');
                $(".kjh-num").each(function (index,item) {
                    $(this).children().each(function (k,i) {
                        if(parseInt($(this).text()) % 2 == 0){
                            $(this).children().text('双');
                            $(this).children().addClass('def_shuang');
                        }else{
                            $(this).children().text('单');
                            $(this).children().addClass('def_dan');
                        }

                    })
                })
            }

            //号码
            if(val == 1){
                $(".kjh-num-zh").hide();
                $(".kjh-num").show();
                newHm()
                $(".kjh-num p span").removeClass('defalut');
                $(".kjh-num p span").removeClass('def_big');
                $(".kjh-num p span").removeClass('def_small');
                $(".kjh-num p span").removeClass('def_shuang');
                $(".kjh-num p span").removeClass('def_dan');
            }

            //对子
            if(val == 4){
                $(".kjh-num-zh").hide();
                $(".kjh-num").show();
                newHm();
                var  kj = $(".kjh-num");
                $(".kjh-num p span").addClass('defalut');
                $(".kjh-num p span").removeClass('def_big');
                $(".kjh-num p span").removeClass('def_small');
                $(".kjh-num p span").removeClass('def_shuang');
                $(".kjh-num p span").removeClass('def_dan');
                $(".kjh-num").each(function (index,item) {
                    for(var i = 0;i<10;i++) {
                        var kj1 = kj.eq(index).children(),
                            kj2 = kj.eq(index+1).children();
                        if (parseInt(kj1.eq(i).text()) == parseInt(kj2.eq(i).text())) {
                            kj1.eq(i).children().removeClass('defalut');
                            kj2.eq(i).children().removeClass('defalut');
                        }
                    }
                })
            }
            if(val == 5){
                $(".kjh-num-zh").show();
                $(".kjh-num").hide();
                $(".kjh-num-zh p span").removeClass('defalut');
            }
        })

        //点击冠亚 等
        $("body").delegate('.td-1','click',function(){
            var val = $(".show-pk10 span.active").data('val');
            if(val == 5) {
                $(".kjh-num-zh p span").addClass('defalut');
                $(".kjh-num-zh").each(function (index, item) {
                    $(this).children().eq(0).children().removeClass('defalut');
                })
            }else{
                $(".kjh-num p span").addClass('defalut');
                $(".kjh-num").each(function (index, item) {
                    $(this).children().eq(0).children().removeClass('defalut');
                })
            }
        })

        $("body").delegate('.td-2','click',function(){
            var val = $(".show-pk10 span.active").data('val');
            if(val == 5) {
                $(".kjh-num-zh p span").addClass('defalut');
                $(".kjh-num-zh").each(function (index, item) {
                    $(this).children().eq(1).children().removeClass('defalut');
                })
            }else {
                $(".kjh-num p span").addClass('defalut');
                $(".kjh-num").each(function (index, item) {
                    $(this).children().eq(1).children().removeClass('defalut');
                })
            }
        })

        $("body").delegate('.td-3','click',function(){
            var val = $(".show-pk10 span.active").data('val');
            if(val == 5) {
                $(".kjh-num-zh p span").addClass('defalut');
                $(".kjh-num-zh").each(function (index, item) {
                    $(this).children().eq(2).children().removeClass('defalut');
                })
            }else {
                $(".kjh-num p span").addClass('defalut');
                $(".kjh-num").each(function (index, item) {
                    $(this).children().eq(2).children().removeClass('defalut');
                })
            }
        })

        $("body").delegate('.td-4','click',function(){
            var val = $(".show-pk10 span.active").data('val');
            if(val == 5) {
                $(".kjh-num-zh p span").addClass('defalut');
                $(".kjh-num-zh").each(function (index, item) {
                    $(this).children().eq(3).children().removeClass('defalut');
                })
            }else {
                $(".kjh-num p span").addClass('defalut');
                $(".kjh-num").each(function (index, item) {
                    $(this).children().eq(3).children().removeClass('defalut');
                })
            }
        })

        $("body").delegate('.td-5','click',function(){
            var val = $(".show-pk10 span.active").data('val');
            if(val == 5) {
                $(".kjh-num-zh p span").addClass('defalut');
                $(".kjh-num-zh").each(function (index, item) {
                    $(this).children().eq(4).children().removeClass('defalut');
                })
            }else {
                $(".kjh-num p span").addClass('defalut');
                $(".kjh-num").each(function (index, item) {
                    $(this).children().eq(4).children().removeClass('defalut');
                })
            }
        })

        $("body").delegate('.td-6','click',function(){
            var val = $(".show-pk10 span.active").data('val');
            if(val == 5) {
                $(".kjh-num-zh p span").addClass('defalut');
                $(".kjh-num-zh").each(function (index, item) {
                    $(this).children().eq(5).children().removeClass('defalut');
                })
            }else {
                $(".kjh-num p span").addClass('defalut');
                $(".kjh-num").each(function (index, item) {
                    $(this).children().eq(5).children().removeClass('defalut');
                })
            }
        })

        $("body").delegate('.td-7','click',function(){
            var val = $(".show-pk10 span.active").data('val');
            if(val == 5) {
                $(".kjh-num-zh p span").addClass('defalut');
                $(".kjh-num-zh").each(function (index, item) {
                    $(this).children().eq(6).children().removeClass('defalut');
                })
            }else {
                $(".kjh-num p span").addClass('defalut');
                $(".kjh-num").each(function (index, item) {
                    $(this).children().eq(6).children().removeClass('defalut');
                })
            }
        })

        $("body").delegate('.td-8','click',function(){
            var val = $(".show-pk10 span.active").data('val');
            if(val == 5) {
                $(".kjh-num-zh p span").addClass('defalut');
                $(".kjh-num-zh").each(function (index, item) {
                    $(this).children().eq(7).children().removeClass('defalut');
                })
            }else {
                $(".kjh-num p span").addClass('defalut');
                $(".kjh-num").each(function (index, item) {
                    $(this).children().eq(7).children().removeClass('defalut');
                })
            }
        })

        $("body").delegate('.td-9','click',function(){
            var val = $(".show-pk10 span.active").data('val');
            if(val == 5) {
                $(".kjh-num-zh p span").addClass('defalut');
                $(".kjh-num-zh").each(function (index, item) {
                    $(this).children().eq(8).children().removeClass('defalut');
                })
            }else {
                $(".kjh-num p span").addClass('defalut');
                $(".kjh-num").each(function (index, item) {
                    $(this).children().eq(8).children().removeClass('defalut');
                })
            }
        })

        $("body").delegate('.td-10','click',function(){
            var val = $(".show-pk10 span.active").data('val');
            if(val == 5) {
                $(".kjh-num-zh p span").addClass('defalut');
                $(".kjh-num-zh").each(function (index, item) {
                    $(this).children().eq(9).children().removeClass('defalut');
                })
            }else {
                $(".kjh-num p span").addClass('defalut');
                $(".kjh-num").each(function (index, item) {
                    $(this).children().eq(9).children().removeClass('defalut');
                })
            }
        })


        //点击号码出现显示点击的号码
        $("body").delegate('.kjh-num span','click',function(){
            var num = $(this).text();
            $(".kjh-num span").each(function () {
                $(this).addClass('defalut');
                var a = $(this).text();
                if(a == num){
                    $(this).removeClass('defalut');
                }
            })
        })



        //点击一列高亮

        $("body").delegate('.lg-history-table table thead tr td,.lg-history-table table tbody tr td','click',function(){
            var val = $(this).data('val');
            $(".lg-history-table table tbody tr td").each(function (index, item) {
                var id = $(this).data('val');
                if (parseInt(val) == parseInt(id)) {
                    if($(this).hasClass('pink')){
                        $(this).removeClass('pink');
                    }else{
                        $(this).addClass('pink');
                    }

                }
            })
        })
    });

    //重置到号码
    function  newHm() {
        $(".kjh-num").each(function (index,item) {
            $(this).children().each(function (k,i) {
                var a = $(this).children().attr('class').split("k")[0].split("-")[1];
                $(this).children().text(a);
            })
        })
    }

    function pjax(url) {
        //初始化加载框
        indexLay = layer.load(0, {offset: 'auto'});
        $.pjax({
            'url': url,
            'container': '.lg-history-table',
            'fragment':'.lg-history-table',
            'dataType':null,
            'replace':true,
            'timeout':5000,
            'scrollTo':document.documentElement.scrollTop
        });
        $(document).on('pjax:complete', function() {
            layer.close(indexLay);
        });
    }
    var bshtml = '';
    bshtml += '<div><font>波色</font></div>';
    bshtml += '<div>绿波号码:1,4,7,10,16,19,22,25</div>';
    bshtml += '<div>蓝波号码:2,5,8,11,17,20,23,26</div>';
    bshtml += '<div>红波号码:3,6,9,12,15,18,21,24</div>';
    bshtml += '<div>灰波号码:0,13,14,27</div>';

    $("body .bswh").hover(function () {
        layer.tips(bshtml, '.bswh', {
            tips: [1, '#999'],
            time: 0,
        });
    }, function () {
        layer.closeAll('tips');
    })


    var jzhtml = '';
    jzhtml += '<div><font>极值</font></div>';
    jzhtml += '<div>号码总和在范围0-5为极小,在范围22-27为极大,否则空无极值</div>';
    $("body .jzwh").hover(function () {
        layer.tips(jzhtml, '.jzwh', {
            tips: [1, '#999'],
            time: 0,
        });
    }, function () {
        layer.closeAll('tips');
    })

    var zbhtml = '';
    zbhtml += '<div><font>中边</font></div>';
    zbhtml += '<div>开奖号在10-17为中,否则为边</div>';
    $("body .zbwh").hover(function () {
        layer.tips(zbhtml, '.zbwh', {
            tips: [1, '#999'],
            time: 0,
        });
    }, function () {
        layer.closeAll('tips');
    })

</script>
</body>
</html>


