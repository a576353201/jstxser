
<?php include_once template("header");?>
<?php include_once template("game/header");?>

<link rel="stylesheet" href="<?php echo $HttpTemplatePath; ?>51cp/static/web/css/pk10/hot-history.css?v=b62882d32e1d25a47dad7ec52996d6d1" type="text/css"/>

<script type="text/javascript" src="<?php echo $HttpTemplatePath; ?>51cp/static/web/js/echart/echarts.common.min.js?v=11233"></script>
<script type="text/javascript" src="<?php echo $HttpTemplatePath; ?>51cp/static/web/js/jqueryUi/jquerui-min-js.js?v=c167ceaa2357dd0f98caf9a7514f1ea5"></script>



<div class="container cst-mainbody" style="padding:0;">
    <div class="location-box">
        <ul>
            <li></li>
            <li>
                <span>当前位置:</span>
                <a href="<?php echo $HttpPath; ?>"><?php echo $system['web_title']; ?></a> > <a href="home_<?php echo $gameinfo['showkey']; ?>.html"><?php echo $gameinfo['title']; ?></a> > <a href="hot_<?php echo $gameinfo['showkey']; ?>.html">冷热</a>   >
                <a href="#"><?php echo $nav_list[$action]['title']; ?></a>
            </li>

        </ul>
    </div>

    <!--号码冷热-->
    <div class="lg-hot-main">
        <div class="lg-hot-type">
            <?php
                foreach($nav_list as $key=>$value){
            ?>
            <a href="<?php echo $value['url']; ?>" <?php if($key==$action) echo 'class="active"';?> ><?php echo $value['title']; ?></a>

            <?php } ?>

        </div>
    </div>

    <!--选择号码-->
    <div class="lg-hot-history-tab">

        <?php
                        foreach($pos_arr as $key=>$value){
        ?>
        <span data-val="<?php echo $key+1;?>"><?php echo $value;?></span>
        <?php } ?>
    </div>
    <!--选择号码-->

    <!--选择日期-->
    <div class="lg-history-title">
        <div class="lg-history-title-left"><span>万位</span>号码历史</div>
        <div class="lg-history-title-issue">
            <form class="layui-form">
                <div class="layui-form-item">
                    <div class="layui-input-block">
                        <input type="radio" name="sort" lay-filter="issue"   value="5" title="5日">
                        <input type="radio" name="sort" lay-filter="issue"   value="10" title="10日" checked>
                        <input type="radio" name="sort" lay-filter="issue"   value="20" title="20日">
                        <input type="radio" name="sort" lay-filter="issue"   value="30" title="30日">
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!--选择日期-->

    <!--列表数据-->
    <div class="lg-history-list">
        <div>
            <table class="num-list">
                <tbody>
                <tr>
                    <td class="lg-commontd-bgup" @click="sortFun('num',$event)">号码</td>
                </tr>
                <tr v-for="item in list">
                    <td><span v-bind:class="numFun(item.num)" v-text="item.num"></span></td>
                </tr>
                <tr><td class="td-bg">总次数</td></tr>
                <tr><td class="td-bg">次数均值</td></tr>
                <tr><td class="td-bg">冷热差</td></tr>
                </tbody>
            </table>
        </div>
        <div>
            <table class="table-list">
                <thead>
                <tr>
                    <td class="lg-commontd-bg" @click="sortFun(k,$event)" v-if="k != 'sum' && k != 'num'" v-for="(v,k) in list[0]">{{k}}<span style="color: #ff0000;font-size: 12px;" v-if="date(k)">今日</span></td>
                    <td class="lg-commontd-bg" @click="sortFun('sum',$event)">总数</td>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(item,index) in list">
                    <td v-if="k != 'num' && k != 'sum'" v-for="(v,k) in item" v-text="v" class="td" v-bind:class="classFun(v,k)"></td>
                    <td v-text="item['sum']"></td>
                </tr>
                <tr>
                    <td class="td-bg" v-for="item in sta['sum']" v-text="item"></td>
                </tr>
                <tr>
                    <td class="td-bg" v-for="item in sta['avg']" v-text="item"></td>
                </tr>
                <tr>
                    <td class="td-bg" v-for="item in sta['diff']" v-text="item"></td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
    <!--列表数据-->


    </div>
    <!--号码冷热-->

</div>

<script>
    var param = {day:10,pos:1,target:<?php echo $nav_list[$action]['target']; ?>,period:100,sort:'num',desc:'1',type:'history'};
    var wei_sum=<?php echo $wei_sum;?>

</script>
<script type="text/javascript" src="<?php echo $HttpTemplatePath; ?>51cp/static/web/js/cqssc/hot-history.js?v=c167ceaa2357dd0f98caf9a7514f1ea5"></script>



<?php include_once template("footer");?>
</body>
</html>


