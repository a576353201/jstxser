
<?php include_once template("header");?>
<?php include_once template("game/header");?>
<link rel="stylesheet" href="<?php echo $HttpTemplatePath; ?>51cp/static/web/css/pk10/analysize.css?v=c167ceaa2357dd0f98caf9a7514f1ea5" type="text/css"/>

<script type="text/javascript" src="<?php echo $HttpPath; ?>static/web/js/echart/echarts.common.min.js?v=11233"></script>
<script type="text/javascript" src="<?php echo $HttpPath; ?>static/web/js/jqueryUi/jquerui-min-js.js?v=c167ceaa2357dd0f98caf9a7514f1ea5"></script>



    <div class="container cst-mainbody" style="padding:0;">
        <div class="location-box">
            <ul>
                <li></li>
                <li>
                    <span>当前位置:</span>
                    <a href="<?php echo $HttpPath; ?>"><?php echo $system['web_title']; ?></a> > <a href="home_<?php echo $gameinfo['showkey']; ?>.html"><?php echo $gameinfo['title']; ?></a> > <a href="#">分析</a>             </li>
                </li>
            </ul>
        </div>

        <!--分析指标选择-->
        <div class="lg-analysize-select">
            <div class="lg-analysize-title"><?php echo $gameinfo['title']; ?>分析</div>
            <div class="lg-analysize-type">
                <div class="lg-analysize-div lg-analysize-pos">
                    <a>位置：</a>
                    <span v-bind:class="{'active':index == posArrIndex}"  v-for="(list,index) in posArr" v-bind:data-val="index+1" v-text="list" @click="posFun(index,$event)"></span>
                </div>
                <div class="lg-analysize-div lg-analysize-target">
                    <a>玩法：</a>
                    <span v-bind:class="{'active':index == targetArrIndex}"  v-for="(list,index) in targetArr" v-bind:data-val="list.key" v-text="list.name" @click="targetFun(index,$event)"></span>
                </div>
                <div class="lg-analysize-div lg-analysize-hm">
                    <a>号码：</a>
                    <span v-bind:class="{'active':index == numArrIndex}"  v-for="(list,index) in numArr" v-text="list" @click="numFun(index,$event)"></span>
                </div>
                <div class="lg-analysize-div lg-analysize-issue">
                    <a>期数：</a>
                    <span data-val="0db">今日</span>
                    <span data-val="30">30期</span>
                    <span data-val="100">100期</span>
                    <span data-val="300">300期</span>
                    <span data-val="1000">1000期</span>
                    <span data-val="3000">3000期</span>
                    <span data-val="10000">10000期</span>
                    <label class="label-a">自定义</label><input type="number" name="issue" placeholder="输入n期" onkeyup="this.value=this.value.replace(/[^\r\n0-9\,\|\ ]/g,'');" style="display: none;"><a class="font-issue" style="display: none;">期</a>
                </div>
            </div>

            <!--开始分析-->
            <div class="lg-analysize-btn">
                开始分析
            </div>
            <!--开始分析-->

            <!--分析列表-->
            <div class="lg-analysize-total">
                <span><?php echo $gameinfo['title']; ?>分析 <a class="pos-name">万位</a> <a class="target-name">1码</a> <a class="num-name">1</a> <a class="period-name">100期</a> 出号统计</span>
                <a class="lg-analysize-trend" href="trend_<?php echo $gameinfo['showkey']; ?>.html">走势图</a>
            </div>
            <div class="lg-analysize-table">
                <table>
                    <thead>
                    <tr>
                        <td>位置</td>
                        <td>号码</td>
                        <td>统计期数</td>
                        <td>出现次数</td>
                        <td>出现概率</td>
                        <td>最大连出</td>
                        <td>当前连出</td>
                        <td>理论次数</td>
                        <td>理论遗漏</td>
                        <td>当前遗漏</td>
                        <td>最大遗漏</td>
                        <td>平均遗漏</td>

                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td width="80px;" v-text="data.data.pos_name"></td>
                        <td width="100px;" style="color: red;" v-text="data.data.num"></td>
                        <td v-text="data.data.count+'期'"></td>
                        <td v-text="data.data.times"></td>
                        <td v-text="data.data.rate"></td>
                        <td v-text="data.data.max_arise"></td>
                        <td v-text="data.data.arise"></td>
                        <td v-text="data.data.t_arise"></td>
                        <td v-text="data.data.t_miss"></td>
                        <td v-text="data.data.miss"></td>
                        <td v-text="data.data.max_miss"></td>
                        <td v-text="data.data.avg_miss"></td>

                    </tr>
                    </tbody>
                    <tbody class="other-num" v-if="data.arrdata">
                    <tr v-for="list in data.arrdata">
                        <td  width="80px;"></td>
                        <td width="100px;" style="color: red;" v-text="list.num"></td>
                        <td v-text="list.count+'期'"></td>
                        <td v-text="list.times"></td>
                        <td v-text="list.rate"></td>
                        <td v-text="list.max_arise"></td>
                        <td v-text="list.arise"></td>
                        <td v-text="list.t_arise"></td>
                        <td v-text="list.t_miss"></td>
                        <td v-text="list.miss"></td>
                        <td v-text="list.max_miss"></td>
                        <td v-text="list.avg_miss"></td>

                    </tr>
                    </tbody>
                </table>
            </div>
            <!--分析列表-->
        </div>
        <!--分析指标选择-->

        <!--分析号码输赢图-->
        <div class="lg-analysize-win">
            <div class="lg-analysize-win-title common-title">
                <div><?php echo $gameinfo['title']; ?> <span class="pos-name">万位</span> <span class="target-name">1码</span> <span class="num-name">1</span> <span class="period-name">100期</span> 输赢图</div>
                <div>
                    <form class="layui-form">
                        <div class="layui-form-item">
                            <label class="layui-form-label">显示:</label>
                            <div class="layui-input-block">
                                <input type="radio" name="sex" lay-filter="win_lose"   value="0" title="只看输" >
                                <input type="radio" name="sex" lay-filter="win_lose"   value="1" title="只看赢">
                                <input type="radio" name="sex" lay-filter="win_lose"   value="2" title="全显" checked>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="lg-analysize-lz">
                <div class="lg-scroll">
                    <table>
                        <tbody>
                        <tr>
                            <td></td>
                            <td v-for="(list,index) in data" v-bind:class="winFun(list.times,index,data.length)">
                                <div v-text="countFun(list.time,index,data.length)" v-bind:class="index == data.length-1?'widclass':''"></div>
                                <div class="zhu" v-bind:class="'zhu_'+index"   @mouseover="dataVal(list.times,list.time,list.expect,$event)"></div>
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td v-for="list in data" v-bind:class="winClass(list.times)" v-text="list.desc"></td>
                        </tr>
                        </tbody>
                    </table>
                    <div class="avg_win"><div><span>平均遗漏<a>5.34</a></span></div><div></div></div>
                    <div class="avg_lose"><div><span>最大遗漏<a>5.34</a></span></div><div></div></div>
                </div>
            </div>
        </div>
        <!--分析号码输赢图-->



        <!--分析号码统计-->
        <div class="lg-analysize-count">
            <div class="lg-analysize-count-title common-title">
                <div><?php echo $gameinfo['title']; ?><span class="pos-name">万位</span> <span class="target-name">1码</span> <span class="num-name">1</span> <span class="period-name">100期</span> 之前之后统计</div>
                <div>
                    <form class="layui-form">
                        <div class="layui-form-item">
                            <label class="layui-form-label">显示:</label>
                            <div class="layui-input-block">
                                <input type="radio" name="type" lay-filter="type"  value="0" title="无图形" checked="">
                                <input type="radio" name="type" lay-filter="type"  value="1" title="柱状图">
                                <input type="radio" name="type" lay-filter="type"  value="2" title="饼状图">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="lg-analysize-count-detail type-1">
                <ul>
                    <li v-if="kindData.mynum == 6" style="width: 1130px;overflow-x: scroll;height: 162px;">
                        <p><span class="num-name">1</span>号之前号码</p>
                        <table>
                            <tbody>
                            <tr>
                                <td style="width:38px;">出号</td>
                                <td v-for="k in 46"><span v-text="k-1"></span></td>
                            </tr>
                            <tr>
                                <td>次数</td>
                                <td v-for="k in 46" v-text="before.arise[k-1]"></td>
                            </tr>
                            </tbody>
                        </table>
                    </li>
                    <li v-else>
                        <p><span class="num-name">1</span>号之前号码</p>
                        <table>
                            <tbody>
                            <tr>
                                <td>出号</td>
                                <?php for($i=$min;$i<=$max;$i++){?>
                                <td><span><?php echo $i; ?></span></td>
                                <?php } ?>
                            </tr>
                            <tr>
                                <td>次数</td>
                                <?php for($i=$min;$i<=$max;$i++){?>
                                <td v-text="before.arise['<?php echo $i; ?>']"></td>
                                <?php } ?>

                            </tr>
                            </tbody>
                        </table>
                    </li>
                    <li>
                        <p><span class="num-name">1</span>号之前大小</p>
                        <table>
                            <tbody>
                            <tr>
                                <td>出号</td>
                                <td><span class="lg-big">大</span></td>
                                <td><span class="lg-small">小</span></td>
                            </tr>
                            <tr>
                                <td>次数</td>
                                <td v-text="before.arise['大']"></td>
                                <td v-text="before.arise['小']"></td>
                            </tr>
                            </tbody>
                        </table>
                    </li>
                    <li>
                        <p><span class="num-name">1</span>号之前单双</p>
                        <table>
                            <tbody>
                            <tr>
                                <td>出号</td>
                                <td><span class="lg-odd">单</span></td>
                                <td><span class="lg-even">双</span></td>
                            </tr>
                            <tr>
                                <td>次数</td>
                                <td v-text="before.arise['单']"></td>
                                <td v-text="before.arise['双']"></td>
                            </tr>
                            </tbody>
                        </table>
                    </li>
                    <li v-if="kindData.mynum != 6">
                        <p><span class="num-name">1</span>号之前除3余数</p>
                        <table>
                            <tbody>
                            <tr>
                                <td>除3余数</td>
                                <td><span class="lg-ys">3余0</span></td>
                                <td><span class="lg-ys">3余1</span></td>
                                <td><span class="lg-ys">3余2</span></td>
                            </tr>
                            <tr>
                                <td>次数</td>
                                <td v-text="before.arise['除3余0']"></td>
                                <td v-text="before.arise['除3余1']"></td>
                                <td v-text="before.arise['除3余2']"></td>
                            </tr>
                            </tbody>
                        </table>
                    </li>
                </ul>
                <div class="lg-analysize-count-zhiqian">
                    <p><span class="num-name">1</span>号之前出过的号码</p>
                    <table>
                        <tbody>
                        <tr>
                            <td>出号</td>
                            <td v-for="v in before.list" v-bind:class="befClass(v.num)"><span v-text="v.num"></span></td>
                        </tr>
                        <tr>
                            <td>期数</td>
                            <td v-for="v in before.list"  v-bind:class="befClass(v.num)" v-text="(v.expect+'').substr(-3)"></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="line"></div>
                <ul>
                    <li v-if="kindData.mynum == 6" style="width: 1130px;overflow-x: scroll;height: 162px;">
                        <p><span class="num-name">1</span>号之后号码</p>
                        <table>
                            <tbody>
                            <tr>
                                <td>出号</td>
                                <td v-for="k in 46"><span v-text="k-1"></span></td>
                            </tr>
                            <tr>
                                <td>次数</td>
                                <td v-for="k in 46" v-text="after.arise[k-1]"></td>
                            </tr>
                            </tbody>
                        </table>
                    </li>
                    <li v-else>
                        <p><span class="num-name">1</span>号之后号码</p>
                        <table>
                            <tbody>
                            <tr>
                                <td>出号</td>
                                <?php for($i=$min;$i<=$max;$i++){?>
                                <td><span><?php echo $i; ?></span></td>
                                <?php } ?>
                            </tr>
                            <tr>
                                <td>次数</td>
                                <?php for($i=$min;$i<=$max;$i++){?>
                                <td v-text="after.arise['<?php echo $i; ?>']"></td>
                                <?php } ?>
                            </tr>
                            </tbody>
                        </table>
                    </li>
                    <li>
                        <p><span class="num-name">1</span>号之后大小</p>
                        <table>
                            <tbody>
                            <tr>
                                <td>出号</td>
                                <td><span class="lg-big">大</span></td>
                                <td><span class="lg-small">小</span></td>
                            </tr>
                            <tr>
                                <td>次数</td>
                                <td v-text="after.arise['大']"></td>
                                <td v-text="after.arise['小']"></td>
                            </tr>
                            </tbody>
                        </table>
                    </li>
                    <li>
                        <p><span class="num-name">1</span>号之前单双</p>
                        <table>
                            <tbody>
                            <tr>
                                <td>出号</td>
                                <td><span class="lg-odd">单</span></td>
                                <td><span class="lg-even">双</span></td>
                            </tr>
                            <tr>
                                <td>次数</td>
                                <td v-text="after.arise['单']"></td>
                                <td v-text="after.arise['双']"></td>
                            </tr>
                            </tbody>
                        </table>
                    </li>
                    <li v-if="kindData.mynum != 6" >
                        <p><span class="num-name">1</span>号之后除3余数</p>
                        <table>
                            <tbody>
                            <tr>
                                <td>除3余数</td>
                                <td><span class="lg-ys">3余0</span></td>
                                <td><span class="lg-ys">3余1</span></td>
                                <td><span class="lg-ys">3余2</span></td>
                            </tr>
                            <tr>
                                <td>次数</td>
                                <td v-text="after.arise['除3余0']"></td>
                                <td v-text="after.arise['除3余1']"></td>
                                <td v-text="after.arise['除3余2']"></td>
                            </tr>
                            </tbody>
                        </table>
                    </li>
                </ul>
                <div class="lg-analysize-count-zhiqian">
                    <p><span class="num-name">1</span>号之后出过的号码</p>
                    <table>
                        <tbody>
                        <tr>
                            <td>出号</td>
                            <td v-for="v in after.list" v-bind:class="befClass(v.num)"><span v-text="v.num"></span></td>
                        </tr>
                        <tr>
                            <td>期数</td>
                            <td v-for="v in after.list"  v-bind:class="befClass(v.num)" v-text="(v.expect+'').substr(-3)"></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="lg-analysize-count-detail type-2" style="display: none;">
                <table>
                    <tbody v-if="kindData.mynum == 6">
                    <tr>
                        <td  colspan="2">
                            <div style="width: 1130px;overflow-x: scroll;min-height: 162px;">
                                <p><span class="num-name">1</span>号之前号码</p>
                                <table>
                                    <tbody>
                                    <tr>
                                        <td>次数</td>
                                        <td v-for="k in 46">
                                            <div v-text="before.arise[k-1]"></div>
                                            <div data-val="2" class="common-height"></div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>出号</td>
                                        <td v-for="k in 46"><span v-text="k-1"></span></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div>
                                <p><span class="num-name">1</span>号之前大小</p>
                                <table>
                                    <tbody>
                                    <tr>
                                        <td>次数</td>
                                        <td>
                                            <div v-text="before.arise['大']"></div>
                                            <div data-val="49" class="lg-big common-dx"></div>
                                        </td>
                                        <td>
                                            <div v-text="before.arise['小']"></div>
                                            <div data-val="51" class="lg-small common-dx"></div>
                                        </td>
                                        <td><a></a></td>
                                        <td><a></a></td>
                                        <td><a></a></td>
                                        <td><a></a></td>
                                        <td><a></a></td>
                                        <td><a></a></td>
                                        <td><a></a></td>
                                        <td><a></a></td>
                                    </tr>
                                    <tr>
                                        <td>出号</td>
                                        <td><span class="lg-big">大</span></td>
                                        <td><span class="lg-small">小</span></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </td>
                        <td>
                            <div>
                                <p><span class="num-name">1</span>号之前单双</p>
                                <table>
                                    <tbody>
                                    <tr>
                                        <td>次数</td>
                                        <td>
                                            <div v-text="before.arise['单']"></div>
                                            <div data-val="16" class="common-ds lg-odd"></div>
                                        </td>
                                        <td>
                                            <div v-text="before.arise['双']"></div>
                                            <div data-val="84" class="common-ds lg-even"></div>
                                        </td>
                                        <td><a></a></td>
                                        <td><a></a></td>
                                        <td><a></a></td>
                                        <td><a></a></td>
                                        <td><a></a></td>
                                        <td><a></a></td>
                                        <td><a></a></td>
                                        <td><a></a></td>
                                    </tr>
                                    <tr>
                                        <td>出号</td>
                                        <td><span class="lg-odd">单</span></td>
                                        <td><span class="lg-even">双</span></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                    <tbody v-else>
                    <tr>
                        <td>
                            <div>
                                <p><span class="num-name">1</span>号之前号码</p>
                                <table>
                                    <tbody>
                                    <tr>
                                        <td>次数</td>
                                        <td>
                                            <div v-text="before.arise['0']"></div>
                                            <div data-val="12" class="common-height"></div>
                                        </td>
                                        <td>
                                            <div v-text="before.arise['1']"></div>
                                            <div data-val="13" class="common-height"></div>
                                        </td>
                                        <td>
                                            <div v-text="before.arise['2']"></div>
                                            <div data-val="5" class="common-height"></div>
                                        </td>
                                        <td>
                                            <div v-text="before.arise['3']"></div>
                                            <div data-val="2" class="common-height"></div>
                                        </td>
                                        <td>
                                            <div v-text="before.arise['4']"></div>
                                            <div data-val="6" class="common-height"></div>
                                        </td>
                                        <td>
                                            <div v-text="before.arise['5']"></div>
                                            <div data-val="22" class="common-height"></div>
                                        </td>
                                        <td>
                                            <div v-text="before.arise['6']"></div>
                                            <div data-val="11" class="common-height"></div>
                                        </td>
                                        <td>
                                            <div v-text="before.arise['7']"></div>
                                            <div data-val="2" class="common-height"></div>
                                        </td>
                                        <td>
                                            <div v-text="before.arise['8']"></div>
                                            <div data-val="1" class="common-height"></div>
                                        </td>
                                        <td>
                                            <div v-text="before.arise['9']"></div>
                                            <div data-val="8" class="common-height"></div>
                                        </td>

                                    </tr>
                                    <tr>
                                        <td>出号</td>
                                        <?php for($i=$min;$i<=$max;$i++){?>
                                        <td><span><?php echo $i; ?></span></td>
                                        <?php } ?>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </td>
                        <td>
                            <div>
                                <p><span class="num-name">1</span>号之前大小</p>
                                <table>
                                    <tbody>
                                    <tr>
                                        <td>次数</td>
                                        <td>
                                            <div v-text="before.arise['大']"></div>
                                            <div data-val="49" class="lg-big common-dx"></div>
                                        </td>
                                        <td>
                                            <div v-text="before.arise['小']"></div>
                                            <div data-val="51" class="lg-small common-dx"></div>
                                        </td>
                                        <td><a></a></td>
                                        <td><a></a></td>
                                        <td><a></a></td>
                                        <td><a></a></td>
                                        <td><a></a></td>
                                        <td><a></a></td>
                                        <td><a></a></td>
                                        <td><a></a></td>
                                    </tr>
                                    <tr>
                                        <td>出号</td>
                                        <td><span class="lg-big">大</span></td>
                                        <td><span class="lg-small">小</span></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div>
                                <p><span class="num-name">1</span>号之前单双</p>
                                <table>
                                    <tbody>
                                    <tr>
                                        <td>次数</td>
                                        <td>
                                            <div v-text="before.arise['单']"></div>
                                            <div data-val="16" class="common-ds lg-odd"></div>
                                        </td>
                                        <td>
                                            <div v-text="before.arise['双']"></div>
                                            <div data-val="84" class="common-ds lg-even"></div>
                                        </td>
                                        <td><a></a></td>
                                        <td><a></a></td>
                                        <td><a></a></td>
                                        <td><a></a></td>
                                        <td><a></a></td>
                                        <td><a></a></td>
                                        <td><a></a></td>
                                        <td><a></a></td>
                                    </tr>
                                    <tr>
                                        <td>出号</td>
                                        <td><span class="lg-odd">单</span></td>
                                        <td><span class="lg-even">双</span></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </td>
                        <td>
                            <div>
                                <p><span class="num-name">1</span>号之前除3余数</p>
                                <table>
                                    <tbody>
                                    <tr>
                                        <td>次数</td>
                                        <td>
                                            <div v-text="before.arise['除3余0']"></div>
                                            <div data-val="25" class="common-ys"></div>
                                        </td>
                                        <td>
                                            <div v-text="before.arise['除3余1']"></div>
                                            <div data-val="10" class="common-ys"></div>
                                        </td>
                                        <td>
                                            <div v-text="before.arise['除3余2']"></div>
                                            <div data-val="65" class="common-ys"></div>
                                        </td>
                                        <td><a></a></td>
                                        <td><a></a></td>
                                        <td><a></a></td>
                                        <td><a></a></td>
                                        <td><a></a></td>
                                        <td><a></a></td>
                                        <td><a></a></td>
                                    </tr>
                                    <tr>
                                        <td>出号</td>
                                        <td><span class="lg-ys lg-ys-zhu">3余0</span></td>
                                        <td><span class="lg-ys lg-ys-zhu">3余1</span></td>
                                        <td><span class="lg-ys lg-ys-zhu">3余2</span></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <div class="type-2-total">
                    <p><span class="num-name">1</span>号之前出过的号码</p>
                    <table>
                        <tbody>
                        <tr>
                            <td>出号</td>
                            <td v-for="v in before.list" v-bind:class="befClass(v.num)"><span v-text="v.num"></span></td>
                        </tr>
                        <tr>
                            <td>期数</td>
                            <td v-for="v in before.list"  v-bind:class="befClass(v.num)" v-text="(v.expect+'').substr(-3)"></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="line"></div>
                <table>
                    <tbody v-if="kindData.mynum == 6">
                    <tr>
                        <td colspan="2">
                            <div style="width: 1130px;overflow-x: scroll;min-height: 162px;">
                                <p><span class="num-name">1</span>号之后号码</p>
                                <table>
                                    <tbody>
                                    <tr>
                                        <td>次数</td>
                                        <td v-for="k in 46">
                                            <div v-text="after.arise[k-1]"></div>
                                            <div data-val="2" class="common-height-aft"></div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>出号</td>
                                        <td v-for="k in 46"><span v-text="k-1"></span></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div>
                                <p><span class="num-name">1</span>号之后大小</p>
                                <table>
                                    <tbody>
                                    <tr>
                                        <td>次数</td>
                                        <td>
                                            <div v-text="after.arise['大']"></div>
                                            <div data-val="49" class="lg-big common-dx-aft"></div>
                                        </td>
                                        <td>
                                            <div v-text="after.arise['小']"></div>
                                            <div data-val="51" class="lg-small common-dx-aft"></div>
                                        </td>
                                        <td><a></a></td>
                                        <td><a></a></td>
                                        <td><a></a></td>
                                        <td><a></a></td>
                                        <td><a></a></td>
                                        <td><a></a></td>
                                        <td><a></a></td>
                                        <td><a></a></td>
                                    </tr>
                                    <tr>
                                        <td>出号</td>
                                        <td><span class="lg-big">大</span></td>
                                        <td><span class="lg-small">小</span></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </td>
                        <td>
                            <div>
                                <p><span class="num-name">1</span>号之后单双</p>
                                <table>
                                    <tbody>
                                    <tr>
                                        <td>次数</td>
                                        <td>
                                            <div v-text="after.arise['单']"></div>
                                            <div data-val="16" class="common-ds-aft lg-odd"></div>
                                        </td>
                                        <td>
                                            <div v-text="after.arise['双']"></div>
                                            <div data-val="84" class="common-ds-aft lg-even"></div>
                                        </td>
                                        <td><a></a></td>
                                        <td><a></a></td>
                                        <td><a></a></td>
                                        <td><a></a></td>
                                        <td><a></a></td>
                                        <td><a></a></td>
                                        <td><a></a></td>
                                        <td><a></a></td>
                                    </tr>
                                    <tr>
                                        <td>出号</td>
                                        <td><span class="lg-odd">单</span></td>
                                        <td><span class="lg-even">双</span></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                    <tbody v-else>
                    <tr>
                        <td>
                            <div>
                                <p><span class="num-name">1</span>号之后号码</p>
                                <table>
                                    <tbody>
                                    <tr>
                                        <td>次数</td>

                                        <td>
                                            <div v-text="after.arise['0']"></div>
                                            <div data-val="10" class="common-height-aft"></div>
                                        </td>
                                        <td>
                                            <div v-text="after.arise['1']"></div>
                                            <div data-val="13" class="common-height-aft"></div>
                                        </td>
                                        <td>
                                            <div v-text="after.arise['2']"></div>
                                            <div data-val="5" class="common-height-aft"></div>
                                        </td>
                                        <td>
                                            <div v-text="after.arise['3']"></div>
                                            <div data-val="2" class="common-height-aft"></div>
                                        </td>
                                        <td>
                                            <div v-text="after.arise['4']"></div>
                                            <div data-val="6" class="common-height-aft"></div>
                                        </td>
                                        <td>
                                            <div v-text="after.arise['5']"></div>
                                            <div data-val="22" class="common-height-aft"></div>
                                        </td>
                                        <td>
                                            <div v-text="after.arise['6']"></div>
                                            <div data-val="11" class="common-height-aft"></div>
                                        </td>
                                        <td>
                                            <div v-text="after.arise['7']"></div>
                                            <div data-val="2" class="common-height-aft"></div>
                                        </td>
                                        <td>
                                            <div v-text="after.arise['8']"></div>
                                            <div data-val="1" class="common-height-aft"></div>
                                        </td>
                                        <td>
                                            <div v-text="after.arise['9']"></div>
                                            <div data-val="8" class="common-height-aft"></div>
                                        </td>

                                    </tr>
                                    <tr>
                                        <td>出号</td>
                                        <?php for($i=$min;$i<=$max;$i++){?>
                                        <td><span><?php echo $i; ?></span></td>
                                        <?php } ?>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </td>
                        <td>
                            <div>
                                <p><span class="num-name">1</span>号之后大小</p>
                                <table>
                                    <tbody>
                                    <tr>
                                        <td>次数</td>
                                        <td>
                                            <div v-text="after.arise['大']"></div>
                                            <div data-val="49" class="lg-big common-dx-aft"></div>
                                        </td>
                                        <td>
                                            <div v-text="after.arise['小']"></div>
                                            <div data-val="51" class="lg-small common-dx-aft"></div>
                                        </td>
                                        <td><a></a></td>
                                        <td><a></a></td>
                                        <td><a></a></td>
                                        <td><a></a></td>
                                        <td><a></a></td>
                                        <td><a></a></td>
                                        <td><a></a></td>
                                        <td><a></a></td>
                                    </tr>
                                    <tr>
                                        <td>出号</td>
                                        <td><span class="lg-big">大</span></td>
                                        <td><span class="lg-small">小</span></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div>
                                <p><span class="num-name">1</span>号之后单双</p>
                                <table>
                                    <tbody>
                                    <tr>
                                        <td>次数</td>
                                        <td>
                                            <div v-text="after.arise['单']"></div>
                                            <div data-val="16" class="common-ds-aft lg-odd"></div>
                                        </td>
                                        <td>
                                            <div v-text="after.arise['双']"></div>
                                            <div data-val="84" class="common-ds-aft lg-even"></div>
                                            <div data-val="84" class="common-ds-aft lg-even"></div>
                                        </td>
                                        <td><a></a></td>
                                        <td><a></a></td>
                                        <td><a></a></td>
                                        <td><a></a></td>
                                        <td><a></a></td>
                                        <td><a></a></td>
                                        <td><a></a></td>
                                        <td><a></a></td>
                                    </tr>
                                    <tr>
                                        <td>出号</td>
                                        <td><span class="lg-odd">单</span></td>
                                        <td><span class="lg-even">双</span></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </td>
                        <td>
                            <div>
                                <p><span class="num-name">1</span>号之后除3余数</p>
                                <table>
                                    <tbody>
                                    <tr>
                                        <td>次数</td>
                                        <td>
                                            <div v-text="after.arise['除3余0']"></div>
                                            <div data-val="25" class="common-ys-aft"></div>
                                        </td>
                                        <td>
                                            <div v-text="after.arise['除3余1']"></div>
                                            <div data-val="10" class="common-ys-aft"></div>
                                        </td>
                                        <td>
                                            <div v-text="after.arise['除3余2']"></div>
                                            <div data-val="65" class="common-ys-aft"></div>
                                        </td>
                                        <td><a></a></td>
                                        <td><a></a></td>
                                        <td><a></a></td>
                                        <td><a></a></td>
                                        <td><a></a></td>
                                        <td><a></a></td>
                                        <td><a></a></td>
                                    </tr>
                                    <tr>
                                        <td>出号</td>
                                        <td><span class="lg-ys lg-ys-zhu">3余0</span></td>
                                        <td><span class="lg-ys lg-ys-zhu">3余1</span></td>
                                        <td><span class="lg-ys lg-ys-zhu">3余2</span></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <div class="type-2-total">
                    <p><span class="num-name">1</span>号之后出过的号码</p>
                    <table>
                        <tbody>
                        <tr>
                            <td>出号</td>
                            <td v-for="v in after.list" v-bind:class="aftClass(v.num)"><span v-text="v.num"></span></td>
                        </tr>
                        <tr>
                            <td>期数</td>
                            <td v-for="v in after.list"  v-bind:class="aftClass(v.num)" v-text="(v.expect+'').substr(-3)"></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div v-show="kindData.mynum == 6" class="type-3" style="display: none">
                <ul>
                    <li style="width: 1130px;overflow-x: scroll;min-height: 162px;">
                        <p><span class="num-name">1号</span>之前号码</p>
                        <div id="before_hma" style="width:400px;height:400px;margin: -100px auto 0 auto;"></div>
                        <table>
                            <tbody>
                            <tr>
                                <td>出号</td>
                                <td v-for="k in 46"><span v-text="k-1"></span></td>
                            </tr>
                            <tr>
                                <td>次数</td>
                                <td v-for="k in 46" v-text="before.arise[k-1]"></td>
                            </tr>
                            </tbody>
                        </table>
                    </li>
                    <li>
                        <p><span class="num-name">1号</span>之前大小</p>
                        <div id="before_dxa" style="width:400px;height:400px;margin: -100px auto 0 auto;"></div>
                        <table>
                            <tbody>
                            <tr>
                                <td>出号</td>
                                <td><span class="lg-big">大</span></td>
                                <td><span class="lg-small">小</span></td>
                            </tr>
                            <tr>
                                <td>次数</td>
                                <td v-text="before.arise['大']"></td>
                                <td v-text="before.arise['小']"></td>
                            </tr>
                            </tbody>
                        </table>
                    </li>
                    <li style="margin-right: 0;margin-left: 10px;">
                        <p><span class="num-name">1号</span>之前单双</p>
                        <div id="before_dsa" style="width:400px;height:400px;margin: -100px auto 0 auto;"></div>
                        <table>
                            <tbody>
                            <tr>
                                <td>出号</td>
                                <td><span class="lg-odd">单</span></td>
                                <td><span class="lg-even">双</span></td>
                            </tr>
                            <tr>
                                <td>次数</td>
                                <td v-text="before.arise['单']"></td>
                                <td v-text="before.arise['双']"></td>
                            </tr>
                            </tbody>
                        </table>
                    </li>
                </ul>
                <div class="lg-analysize-count-zhiqian">
                    <p><span class="num-name">1</span>号之前出过的号码</p>
                    <table>
                        <tbody>
                        <tr>
                            <td>出号</td>
                            <td v-for="v in before.list" v-bind:class="befClass(v.num)"><span v-text="v.num"></span></td>
                        </tr>
                        <tr>
                            <td>期数</td>
                            <td v-for="v in before.list"  v-bind:class="befClass(v.num)" v-text="(v.expect+'').substr(-3)"></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="line"></div>
                <ul>
                    <li style="width: 1130px;overflow-x: scroll;min-height: 162px;">
                        <p><span class="num-name">1号</span>之后号码</p>
                        <div id="aft_hma" style="width:400px;height:400px;margin: -100px auto 0 auto;"></div>
                        <table>
                            <tbody>
                            <tr>
                                <td>出号</td>
                                <td v-for="k in 46"><span v-text="k-1"></span></td>
                            </tr>
                            <tr>
                                <td>次数</td>
                                <td v-for="k in 46" v-text="after.arise[k-1]"></td>
                            </tr>
                            </tbody>
                        </table>
                    </li>
                    <li>
                        <p><span class="num-name">1号</span>之后大小</p>
                        <div id="aft_dxa" style="width:400px;height:400px;margin: -100px auto 0 auto;"></div>
                        <table>
                            <tbody>
                            <tr>
                                <td>出号</td>
                                <td><span class="lg-big">大</span></td>
                                <td><span class="lg-small">小</span></td>
                            </tr>
                            <tr>
                                <td>次数</td>
                                <td v-text="after.arise['大']"></td>
                                <td v-text="after.arise['小']"></td>
                            </tr>
                            </tbody>
                        </table>
                    </li>
                    <li style="margin-right: 0;margin-left: 10px;">
                        <p><span class="num-name">1号</span>之后单双</p>
                        <div id="aft_dsa" style="width:400px;height:400px;margin: -100px auto 0 auto;"></div>
                        <table>
                            <tbody>
                            <tr>
                                <td>出号</td>
                                <td><span class="lg-odd">单</span></td>
                                <td><span class="lg-even">双</span></td>
                            </tr>
                            <tr>
                                <td>次数</td>
                                <td v-text="after.arise['单']"></td>
                                <td v-text="after.arise['双']"></td>
                            </tr>
                            </tbody>
                        </table>
                    </li>
                </ul>
                <div class="lg-analysize-count-zhiqian">
                    <p><span class="num-name">1</span>号之后出过的号码</p>
                    <table>
                        <tbody>
                        <tr>
                            <td>出号</td>
                            <td v-for="v in after.list"  v-bind:class="aftClass(v.num)"><span v-text="v.num"></span></td>
                        </tr>
                        <tr>
                            <td>期数</td>
                            <td v-for="v in after.list"   v-bind:class="aftClass(v.num)" v-text="(v.expect+'').substr(-3)"></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div v-show="kindData.mynum != 6 && kindData.typeNum == 2" class="type-3" style="display: none">
                <ul>
                    <li>
                        <p><span class="num-name">1号</span>之前号码</p>
                        <div id="before_hm" style="width:400px;height:400px;margin: -100px auto 0 auto;"></div>
                        <table>
                            <tbody>
                            <tr>
                                <td>出号</td>
                                <?php for($i=$min;$i<=$max;$i++){?>
                                <td><span><?php echo $i; ?></span></td>
                                <?php } ?>

                            </tr>
                            <tr>
                                <td>次数</td>
                                <?php for($i=$min;$i<=$max;$i++){?>
                                <td v-text="before.arise['<?php echo $i; ?>']"></td>
                                <?php } ?>
                            </tr>
                            </tbody>
                        </table>
                    </li>
                    <li>
                        <p><span class="num-name">1号</span>之前大小</p>
                        <div id="before_dx" style="width:400px;height:400px;margin: -100px auto 0 auto;"></div>
                        <table>
                            <tbody>
                            <tr>
                                <td>出号</td>
                                <td><span class="lg-big">大</span></td>
                                <td><span class="lg-small">小</span></td>
                            </tr>
                            <tr>
                                <td>次数</td>
                                <td v-text="before.arise['大']"></td>
                                <td v-text="before.arise['小']"></td>
                            </tr>
                            </tbody>
                        </table>
                    </li>
                    <li>
                        <p><span class="num-name">1号</span>之前单双</p>
                        <div id="before_ds" style="width:400px;height:400px;margin: -100px auto 0 auto;"></div>
                        <table>
                            <tbody>
                            <tr>
                                <td>出号</td>
                                <td><span class="lg-odd">单</span></td>
                                <td><span class="lg-even">双</span></td>
                            </tr>
                            <tr>
                                <td>次数</td>
                                <td v-text="before.arise['单']"></td>
                                <td v-text="before.arise['双']"></td>
                            </tr>
                            </tbody>
                        </table>
                    </li>
                    <li>
                        <p><span class="num-name">1号</span>之前除3余数</p>
                        <div id="before_ys" style="width:400px;height:400px;margin: -100px auto 0 auto;"></div>
                        <table>
                            <tbody>
                            <tr>
                                <td>出号</td>
                                <td><span class="lg-ys">3余0</span></td>
                                <td><span class="lg-ys">3余1</span></td>
                                <td><span class="lg-ys">3余2</span></td>
                            </tr>
                            <tr>
                                <td>次数</td>
                                <td v-text="before.arise['除3余0']"></td>
                                <td v-text="before.arise['除3余1']"></td>
                                <td v-text="before.arise['除3余2']"></td>
                            </tr>
                            </tbody>
                        </table>
                    </li>
                </ul>
                <div class="lg-analysize-count-zhiqian">
                    <p><span class="num-name">1</span>号之前出过的号码</p>
                    <table>
                        <tbody>
                        <tr>
                            <td>出号</td>
                            <td v-for="v in before.list" v-bind:class="befClass(v.num)"><span v-text="v.num"></span></td>
                        </tr>
                        <tr>
                            <td>期数</td>
                            <td v-for="v in before.list"  v-bind:class="befClass(v.num)" v-text="(v.expect+'').substr(-3)"></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="line"></div>
                <ul>
                    <li>
                        <p><span class="num-name">1号</span>之后号码</p>
                        <div id="aft_hm" style="width:400px;height:400px;margin: -100px auto 0 auto;"></div>
                        <table>
                            <tbody>
                            <tr>
                                <td>出号</td>
                                <?php for($i=$min;$i<=$max;$i++){?>
                                <td><span><?php echo $i; ?></span></td>
                                <?php } ?>
                            </tr>
                            <tr>
                                <td>次数</td>

                                <?php for($i=$min;$i<=$max;$i++){?>
                                <td v-text="after.arise['<?php echo $i; ?>']"></td>
                                <?php } ?>
                            </tr>
                            </tbody>
                        </table>
                    </li>
                    <li>
                        <p><span class="num-name">1号</span>之后大小</p>
                        <div id="aft_dx" style="width:400px;height:400px;margin: -100px auto 0 auto;"></div>
                        <table>
                            <tbody>
                            <tr>
                                <td>出号</td>
                                <td><span class="lg-big">大</span></td>
                                <td><span class="lg-small">小</span></td>
                            </tr>
                            <tr>
                                <td>次数</td>
                                <td v-text="after.arise['大']"></td>
                                <td v-text="after.arise['小']"></td>
                            </tr>
                            </tbody>
                        </table>
                    </li>
                    <li>
                        <p><span class="num-name">1号</span>之后单双</p>
                        <div id="aft_ds" style="width:400px;height:400px;margin: -100px auto 0 auto;"></div>
                        <table>
                            <tbody>
                            <tr>
                                <td>出号</td>
                                <td><span class="lg-odd">单</span></td>
                                <td><span class="lg-even">双</span></td>
                            </tr>
                            <tr>
                                <td>次数</td>
                                <td v-text="after.arise['单']"></td>
                                <td v-text="after.arise['双']"></td>
                            </tr>
                            </tbody>
                        </table>
                    </li>
                    <li>
                        <p><span class="num-name">1号</span>之后除3余数</p>
                        <div id="aft_ys" style="width:400px;height:400px;margin: -100px auto 0 auto;"></div>
                        <table>
                            <tbody>
                            <tr>
                                <td>出号</td>
                                <td><span class="lg-ys">3余0</span></td>
                                <td><span class="lg-ys">3余1</span></td>
                                <td><span class="lg-ys">3余2</span></td>
                            </tr>
                            <tr>
                                <td>次数</td>
                                <td v-text="after.arise['除3余0']"></td>
                                <td v-text="after.arise['除3余1']"></td>
                                <td v-text="after.arise['除3余2']"></td>
                            </tr>
                            </tbody>
                        </table>
                    </li>
                </ul>
                <div class="lg-analysize-count-zhiqian">
                    <p><span class="num-name">1</span>号之后出过的号码</p>
                    <table>
                        <tbody>
                        <tr>
                            <td>出号</td>
                            <td v-for="v in after.list"  v-bind:class="aftClass(v.num)"><span v-text="v.num"></span></td>
                        </tr>
                        <tr>
                            <td>期数</td>
                            <td v-for="v in after.list"   v-bind:class="aftClass(v.num)" v-text="(v.expect+'').substr(-3)"></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!--分析号码统计-->
    </div>


</div>
<script>
    var gametype='<?php echo $gameinfo['type']; ?>';

</script>
<script type="text/javascript" src="<?php echo $HttpPath; ?>static/web/js/cqssc/analyze.js?v=c167ceaa2357dd0f98caf9a7514f1ea5"></script>
<script type="text/javascript" src="<?php echo $HttpPath; ?>static/web/js/pk10/analyze-echart.js?v=c167ceaa2357dd0f98caf9a7514f1ea5"></script>


<?php include_once template("footer");?>
</body>
</html>


