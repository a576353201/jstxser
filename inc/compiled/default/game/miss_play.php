
<?php include_once template("header");?>
<?php include_once template("game/header");?>
<link rel="stylesheet" href="<?php echo $HttpTemplatePath; ?>51cp/static/web/css/cqssc/newmiss.css?v=c167ceaa2357dd0f98caf9a7514f1ea5" type="text/css"/>

<div class="container cst-mainbody" style="padding:0;">
    <div class="location-box">
        <ul>
            <li></li>
            <li>
                <span>当前位置:</span>
                <a href="<?php echo $HttpPath; ?>"><?php echo $system['web_title']; ?></a> > <a href="home_<?php echo $gameinfo['showkey']; ?>.html"><?php echo $gameinfo['title']; ?></a> > <a href="#"><?php echo $typename; ?></a>> <a href="#">位置模式</a>
            </li>
        </ul>
    </div>




    <!--遗漏模式选择-->
    <div class="lg-playMiss-select">
        <div>
            <a href="<?php echo $type; ?>_<?php echo $gameinfo['showkey']; ?>.html" >精选<?php echo $typename; ?></a>
            <a href="<?php echo $type; ?>_<?php echo $gameinfo['showkey']; ?>.html?action=play"  class="active">玩法模式</a>
            <a href="<?php echo $type; ?>_<?php echo $gameinfo['showkey']; ?>.html?action=pos">位置模式</a>
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
                <a>玩法:</a>
                <?php if($gameinfo['type']=='ssc' || $gameinfo['type']=='pk10'){?>
                <span data-val="1">1码</span>
                <span data-val="2">2码</span>
                <span data-val="3">3码</span>
                <span data-val="4">4码</span>
                <span data-val="5">5码</span>
                <span data-val="6">6码</span>
                <span data-val="7">7码</span>
                <span data-val="8">8码</span>
                <span data-val="9">9码</span>
                <span id="lh" data-val="10">龙虎</span>
                <span id="dx" data-val="11">大小</span>
                <span id="ds" data-val="12">单双</span>

                <span id="sum" data-val="13">和值</span>
                <?php } else if($gameinfo['type']=='k3') { ?>
                <span data-val="1">1码</span>
                <span data-val="2">2码</span>
                <span data-val="3">3码</span>
                <span data-val="4">4码</span>
                <span data-val="5">5码</span>
                <span id="dx" data-val="11">大小</span>
                <span id="ds" data-val="12">单双</span>
                <span id="sum" data-val="13">和值</span>
                <span data-val="20">形态</span>


                <?php } else if($gameinfo['type']=='11x5') { ?>
                <span data-val="1">1码</span>
                <span data-val="2">2码</span>
                <span data-val="3">3码</span>
                <span data-val="4">4码</span>
                <span data-val="5">5码</span>
                <span data-val="6">6码</span>
                <span data-val="7">7码</span>
                <span data-val="8">8码</span>
                <span data-val="9">9码</span>

                <?php } else if($gameinfo['type']=='kl10') { ?>
                <span data-val="1">1码</span>
                <span data-val="2">2码</span>
                <span data-val="3">3码</span>
                <span id="dx" data-val="11">大小</span>
                <span id="ds" data-val="12">单双</span>

                <?php } else { ?>


                <?php }?>

            </div>
            <div>
                <a>位置:</a>
                <span :class="{'active':i == posData.guindex }"  v-bind:data-val="k.key" v-for="(k,i) in posData.data" v-text="k.name" v-on:click="valTarget(k.key,i)"></span>
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
                        <a data-val="4" class="copyNum" style="display: none;">复制</a>
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
                    {key:0,name:'全部'},
                    {key:1,name:'万位'},
                    {key:2,name:'千位'},
                    {key:3,name:'百位'},
                    {key:4,name:'十位'},
                    {key:5,name:'个位'},
                ],
                '2':[
                    {key:1,name:'万位'},
                ],
                '3':[
                    {key:13,name:'总和'}
                ]
            },

        }
    <?php } else if($gameinfo['type']=='pk10') { ?>

    obj = {
        //初始化位置指标
        target:{
            '1':[
                {key:0,name:'全部'},
                {key:1,name:'冠军'},
                {key:2,name:'亚军'},
                {key:3,name:'第三名'},
                {key:4,name:'第四名'},
                {key:5,name:'第五名'},
                {key:6,name:'第六名'},
                {key:7,name:'第七名'},
                {key:8,name:'第八名'},
                {key:9,name:'第九名'},
                {key:10,name:'第十名'},

            ],
            '2':[
                {key:0,name:'全部'},
                {key:1,name:'冠军'},
                {key:2,name:'亚军'},
                {key:3,name:'第三名'},
                {key:4,name:'第四名'},
                {key:5,name:'第五名'},
            ],
            '3':[
                {key:11,name:'冠亚和'}
            ],
        },

    }
    <?php } else if($gameinfo['type']=='11x5') { ?>
    obj = {
        //初始化位置指标
        target:{
            '1':[
                {key:1,name:'第一球'},
                {key:2,name:'第二球'},
                {key:3,name:'第三球'},
                {key:4,name:'第四球'},
                {key:5,name:'第五球'},

            ],
        },

    }
    <?php } else if($gameinfo['type']=='kl10') { ?>
    obj = {
        //初始化位置指标
        target:{
            '1':[
                {key:1,name:'第一球'},
                {key:2,name:'第二球'},
                {key:3,name:'第三球'},
                {key:4,name:'第四球'},
                {key:5,name:'第五球'},
                {key:6,name:'第六球'},
                {key:7,name:'第七球'},
                {key:8,name:'第八球'},

            ],
        },

    }
    <?php } else if($gameinfo['type']=='k3') { ?>
    obj = {
        //初始化位置指标
        target:{
            '1':[
                {key:1,name:'三星'},

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


