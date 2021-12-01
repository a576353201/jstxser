<?php include_once template("header");?>
<?php include_once template("game/header");?>
<link rel="stylesheet" href="<?php echo $HttpTemplatePath; ?>51cp/static/web/h5/css/kaijiang.css?v=c167ceaa2357dd0f98caf9a7514f1ea5" type="text/css"/>
    <div class="container cst-mainbody" >

        <div class="lg-history">


            <div class="kaijiang-panel-title">
                <ul class="fh">
                    <li class="fh-f1 fh">
                        <h3>开奖历史</h3>

                          <?php if($gameinfo['showkey']=='F1'){?>
                        <span id="time1_bj" onclick="change_time('oz');" style="cursor: pointer" title="当前为北京时间，点击切换到欧洲时间">切换到欧洲时间</span>
                        <span id="time1_oz" onclick="change_time('bj');" style="cursor: pointer;display: none;" title="当前为欧洲时间，点击切换到北京时间">切换到北京时间</span>
                        <?php }?>
                    </li>
                    <li>
                        <input id="select-input" name="date" type="date" value="<?php echo $date;?>">
                    </li>
                </ul>
            </div>

            <div class="lg-history-table">
                <?php if($gameinfo['type']!='kl8' &&  $gameinfo['type']!='pcdd'){?>
                <div class="lg-history-tab show-pk10">
                    <span data-val="1" class="active">号码</span>
                    <span data-val="2">大小</span>
                    <span data-val="3">单双</span>
                    <span data-val="4">对子</span>
                    <span data-val="5">综合</span>
                </div>
                <?php }?>
                <?php include_once template("$tpl_name");?>
            </div>
        </div>
    </div>

<?php include_once template("footer");?>

<script>



    $(function () {






        $("#select-input").change(function (){
            window.location = '?date='+$(this).val();
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


