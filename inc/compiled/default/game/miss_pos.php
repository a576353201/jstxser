
<?php include_once template("header");?>
<?php include_once template("game/header");?>
<link rel="stylesheet" href="<?php echo $HttpTemplatePath; ?>51cp/static/web/css/cqssc/newmiss.css?v=c167ceaa2357dd0f98caf9a7514f1ea5" type="text/css"/>

    <div class="container cst-mainbody" style="padding:0;">
        <div class="location-box">
            <ul>
                <li></li>
                <li>
                    <span>当前位置:</span>
                    <a href="<?php echo $HttpPath; ?>"><?php echo $system['web_title']; ?></a> > <a href="home_<?php echo $gameinfo['showkey']; ?>.html"><?php echo $gameinfo['title']; ?></a> > <a href="#"><?php echo $typename; ?></a> > <a href="#">位置模式</a>
                </li>
            </ul>
        </div>




        <!--遗漏模式选择-->
        <div class="lg-playMiss-select">
            <div>
                <a href="<?php echo $type; ?>_<?php echo $gameinfo['showkey']; ?>.html" >精选<?php echo $typename; ?></a>
                <a href="<?php echo $type; ?>_<?php echo $gameinfo['showkey']; ?>.html?action=play"  >玩法模式</a>
                <a href="<?php echo $type; ?>_<?php echo $gameinfo['showkey']; ?>.html?action=pos" class="active">位置模式</a>
            </div>
            <div>
                <!--<a>旧版遗漏>></a>-->
            </div>
        </div>
        <!--遗漏模式选择-->

        <!--遗漏选择指标-->
        <div class="lg-playMiss-kind">
            <div class="lg-playMiss-kind-left">
                <div class="lg-play-way">
                    <a>位置:</a>
                    <?php if($gameinfo['type']=='ssc'){?>
                    <span data-val="1">万位</span>
                    <span data-val="2">千位</span>
                    <span data-val="3">百位</span>
                    <span data-val="4">十位</span>
                    <span data-val="5">个位</span>
                    <span data-val="6">前二</span>
                    <span data-val="7">后二</span>
                    <span data-val="8">前三</span>
                    <span data-val="9">中三</span>
                    <span data-val="10">后三</span>
                    <span data-val="11">前四</span>
                    <span data-val="12">后四</span>
                    <span data-val="13">五星</span>

                    <?php } else if($gameinfo['type']=='pk10') { ?>
                    <span data-val="1">冠军</span>
                    <span data-val="2">亚军</span>
                    <span data-val="3">三名</span>
                    <span data-val="4">四名</span>
                    <span data-val="5">五名</span>
                    <span data-val="6">六名</span>
                    <span data-val="7">七名</span>
                    <span data-val="8">八名</span>
                    <span data-val="9">九名</span>
                    <span data-val="10">十名</span>
                    <span data-val="11">冠亚和</span>
                    <?php } else if($gameinfo['type']=='11x5') { ?>
                    <span data-val="1">第一球</span>
                    <span data-val="2">第二球</span>
                    <span data-val="3">第三球</span>
                    <span data-val="4">第四球</span>
                    <span data-val="5">第五球</span>

                    <?php } else if($gameinfo['type']=='kl10') { ?>
                    <span data-val="1">第一球</span>
                    <span data-val="2">第二球</span>
                    <span data-val="3">第三球</span>
                    <span data-val="4">第四球</span>
                    <span data-val="5">第五球</span>
                    <span data-val="6">第六球</span>
                    <span data-val="7">第七球</span>
                    <span data-val="8">第八球</span>

                    <?php } else if($gameinfo['type']=='k3') { ?>
                    <span data-val="1">三星</span>


                    <?php } else { ?>



                    <?php }?>
                </div>
                <div>
                    <a>玩法:</a>
                    <span :class="{'active':i == posData.guindex }"  v-bind:data-val="k.key" v-for="(k,i) in posData.data" v-text="k.name" v-on:click="valTarget(k.key,i)"></span>
                </div>
                <div class="lg-play-status lg-play-xt" style="display: none;">
                    <a>形态:</a>
                    <form class="layui-form">
                        <div class="layui-form-item">
                            <div class="layui-input-block">
                                <input type="radio" name="status" lay-filter="status"   value="1" title="直选" checked>
                                <input type="radio" name="status" lay-filter="status"   value="2" title="组选">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="lg-play-status lg-play-zx" style="display: none;">
                    <a>形态:</a>
                    <form class="layui-form">
                        <div class="layui-form-item">
                            <div class="layui-input-block">
                                <input type="radio" name="xt" lay-filter="xt"   value="1" title="组三" checked>
                                <input type="radio" name="xt" lay-filter="xt"   value="2" title="组六">
                                <input type="radio" name="xt" lay-filter="xt"   value="0" title="全部">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="lg-play-issue">
                    <a>期数:</a>
                    <span data-val="0db">今日</span>
                    <span data-val="100">100期</span>
                    <span data-val="300">300期</span>
                    <span data-val="1000">1000期</span>
                    <input type="number" class="issue-a" placeholder="请输入n期" onkeyup="this.value=this.value.replace(/[^\r\n0-9\,\|\ ]/g,'');"><label>确定</label>
                </div>

            </div>
            <div class="lg-playMiss-kind-right">
                <!--<span>全清</span>-->

            </div>
        </div>
        <!--遗漏选择指标-->

        <!--遗漏列表-->
        <div class="lg-playMiss-table">
            <div class="title"><?php echo $gameinfo['title']; ?> <span class="lg-target">1码</span> <?php echo $typename; ?>-<span class="lg-issue">100</span>期</div>
            <div class="lg-playMiss-table-title">
                <div>
                    <span>每页条数:</span>
                    <input class="radioItem" type="radio" name="page" value="10" checked="checked">10条
                    <input class="radioItem" type="radio" name="page" value="20">20条
                    <input class="radioItem" type="radio" name="page" value="50">50条
                    <input class="radioItem" type="radio" name="page" value="100">100条
                    <input class="radioItem" type="radio" name="page" value="200">200条
                    <input class="radioItem" type="radio" name="page" value="500">500条
                </div>

                <div><input type="text" class="searchHm" placeholder="输入查询号码"><label class="lg-search" style="margin-right:40px;">查询</label></div>
            </div>
            <div class="lg-playMiss-table-list">
                <table>
                    <thead>
                    <tr>
                        <td width="95px;">玩法</td>
                        <td width="85px;">位置</td>
                        <td class="yl-setsort" data-val = "num">号码</td>
                        <td width="85px;" class="yl-setsort lg-commontd-bg" data-val = "times">出现次数</td>
                        <td width="85px;" class="yl-setsort lg-commontd-bg" data-val = "max_arise">最大连出</td>
                        <td width="85px;" class="yl-setsort lg-commontd-bg" data-val = "arise">当前连出</td>
                        <td width="85px;">理论次数</td>
                        <td width="85px;">理论遗漏</td>
                        <td id="miss-a" width="85px;" class="yl-setsort lg-commontd-bg" data-val = "miss">当前遗漏</td>
                        <td width="85px;" class="yl-setsort lg-commontd-bg" data-val = "max_miss">最大遗漏</td>
                        <td width="85px;" class="yl-setsort lg-commontd-bg" data-val = "avg_miss">平均遗漏</td>

                        <td width="85px;">分析</td>
                    </tr>
                    </thead>
                    <tbody id="listData">
                    <tr v-for="list in data">
                        <td v-text="list.target_name"></td>
                        <td v-text="list.pos_name"></td>
                        <td class="missHm" data-val="num">
                            <b>{{list.num}}</b>
                            <a class="copyNum"  v-bind:data-val="list.num">复制</a>
                        </td>
                        <td data-val="times" v-text="list.times"></td>
                        <td data-val="max_arise" v-text="list.max_arise"></td>
                        <td data-val="arise" v-text="list.arise"></td>
                        <td v-text="list.t_arise"></td>
                        <td v-text="list.t_miss"></td>
                        <td data-val="miss" v-text="list.miss"></td>
                        <td data-val="max_miss" v-text="list.max_miss"></td>
                        <td data-val="avg_miss" v-text="list.avg_miss"></td>

                        <td><span @click="analyzeFun(list.pos,posData.param.target,list.num,posData.param.period)">分析</span></td>
                    </tr>
                    </tbody>
                </table>
                <div id="page"></div>
            </div>
        </div>
        <!--遗漏列表-->




    </div>
<script>

    var type='<?php echo $type; ?>';
    var typename='<?php echo $typename; ?>';
    var gametype='<?php echo $gameinfo['type']; ?>';
    var action='<?php echo $_GET['action']; ?>';
    var obj = obj || {};
    <?php if($gameinfo['type']=='ssc'){?>
    obj = {
        //初始化位置指标
        target:{
            '1':[
                {key:1,name:'1码'},
                {key:2,name:'2码'},
                {key:3,name:'3码'},
                {key:4,name:'4码'},
                {key:5,name:'5码'},
                {key:6,name:'6码'},
                {key:7,name:'7码'},
                {key:8,name:'8码'},
                {key:9,name:'9码'},
                {key:11,name:'大小'},
                {key:12,name:'单双'},
                {key:10,name:'龙虎'},
            ],
            '2':[
                {key:21,name:'直选单式'},
                {key:22,name:'组选单式'},
                {key:23,name:'组选复式3码'},
                {key:24,name:'组选复式4码'},
                {key:25,name:'组选复式5码'},
                {key:26,name:'组选复式6码'},
                {key:27,name:'组选复式7码'},
                {key:28,name:'组选复式8码'},
                {key:11,name:'大小'},
                {key:12,name:'单双'},
                {key:15,name:'012路'},
                {key:16,name:'跨度'},
                {key:13,name:'和值'},
                {key:14,name:'和尾'},
            ],
            '3':[
                {key:21,name:'直选单式'},
                {key:22,name:'组选单式'},
                {key:23,name:'组选复式3码'},
                {key:24,name:'组选复式4码'},
                {key:25,name:'组选复式5码'},
                {key:26,name:'组选复式6码'},
                {key:27,name:'组选复式7码'},
                {key:28,name:'组选复式8码'},
                {key:11,name:'大小'},
                {key:12,name:'单双'},
                {key:15,name:'012路'},
                {key:16,name:'跨度'},
                {key:13,name:'和值'},
                {key:14,name:'和尾'},
                {key:17,name:'不定胆'},
                {key:18,name:'三星两码'},
                {key:19,name:'连号'},
                {key:20,name:'形态'},
            ],
            '4':[
                {key:21,name:'直选单式'},
                {key:11,name:'大小'},
                {key:12,name:'单双'},
                {key:15,name:'012路'},
                {key:16,name:'跨度'},
                {key:13,name:'和值'},
                {key:14,name:'和尾'},
            ],
            '5':[
                {key:17,name:'不定胆'},
                {key:11,name:'大小'},
                {key:12,name:'单双'},
                {key:15,name:'012路'},
                {key:16,name:'跨度'},
                {key:13,name:'和值'},
                {key:14,name:'和尾'},
            ],
            '6':[
                {key:1,name:'1码'},
                {key:2,name:'2码'},
                {key:3,name:'3码'},
                {key:4,name:'4码'},
                {key:5,name:'5码'},
                {key:6,name:'6码'},
                {key:7,name:'7码'},
                {key:8,name:'8码'},
                {key:9,name:'9码'},
                {key:11,name:'大小'},
                {key:12,name:'单双'},
            ],
        },

    }

        <?php } else if($gameinfo['type']=='pk10') { ?>

    obj = {
        //初始化位置指标
        target:{
            '1':[
                {key:1,name:'1码'},
                {key:2,name:'2码'},
                {key:3,name:'3码'},
                {key:4,name:'4码'},
                {key:5,name:'5码'},
                {key:6,name:'6码'},
                {key:7,name:'7码'},
                {key:8,name:'8码'},
                {key:9,name:'9码'},
                {key:11,name:'大小'},
                {key:12,name:'单双'},
                {key:10,name:'龙虎'},
            ],
            '2':[
                {key:1,name:'1码'},
                {key:2,name:'2码'},
                {key:3,name:'3码'},
                {key:4,name:'4码'},
                {key:5,name:'5码'},
                {key:6,name:'6码'},
                {key:7,name:'7码'},
                {key:8,name:'8码'},
                {key:9,name:'9码'},
                {key:11,name:'大小'},
                {key:12,name:'单双'},
            ],
            '3':[
                {key:13,name:'和值'}
            ],
        },

    }
        <?php } else if($gameinfo['type']=='11x5') { ?>
    obj = {
        //初始化位置指标
        target:{
            '1':[
                {key:1,name:'1码'},
                {key:2,name:'2码'},
                {key:3,name:'3码'},
                {key:4,name:'4码'},
                {key:5,name:'5码'},
                {key:6,name:'6码'},
                {key:7,name:'7码'},
                {key:8,name:'8码'},
                {key:9,name:'9码'}
            ],
        },

    }
        <?php } else if($gameinfo['type']=='kl10') { ?>
    obj = {
        //初始化位置指标
        target:{
            '1':[
                {key:1,name:'1码'},
                {key:2,name:'2码'},
                {key:3,name:'3码'},
                {key:11,name:'大小'},
                {key:12,name:'单双'},

            ],
        },

    }
    <?php } else if($gameinfo['type']=='k3') { ?>
    obj = {
        //初始化位置指标
        target:{
            '1':[
                {key:1,name:'1码'},
                {key:2,name:'2码'},
                {key:3,name:'3码'},
                {key:4,name:'4码'},
                {key:5,name:'5码'},
                {key:11,name:'大小'},
                {key:12,name:'单双'},
                {key:13,name:'和值'},
                {key:20,name:'形态'},
            ],
        },

    }

    <?php } else { ?>



    <?php }?>


</script>

<script type="text/javascript" src="<?php echo $HttpPath; ?>static/web/js/cqssc/cqssc-newmisspos.js?v=c167ceaa2357dd0f98caf9a7514f1ea5"></script>
<?php include_once template("footer");?>
</body>
</html>


