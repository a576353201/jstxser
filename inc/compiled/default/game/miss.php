
<?php include_once template("header");?>
<?php include_once template("game/header");?>
<link rel="stylesheet" href="<?php echo $HttpTemplatePath; ?>51cp/static/web/css/cqssc/newmiss-pick.css?v=c167ceaa2357dd0f98caf9a7514f1ea5" type="text/css"/>

    <div class="container cst-mainbody" style="padding:0;">
        <div class="location-box">
            <ul>
                <li></li>
                <li>
                    <span>当前位置:</span>
                    <a href="<?php echo $HttpPath; ?>"><?php echo $system['web_title']; ?></a> > <a href="home_<?php echo $gameinfo['showkey']; ?>.html"><?php echo $gameinfo['title']; ?></a> > <a href="#"><?php echo $typename; ?></a>   > <a href="#">精选<?php echo $typename; ?></a>               </li>
            </ul>
        </div>




        <!--<?php echo $typename; ?>模式选择-->
        <div class="lg-playMiss-select">
            <div class="lg-playMiss-select-div">
                <a href="<?php echo $type; ?>_<?php echo $gameinfo['showkey']; ?>.html" class="active">精选<?php echo $typename; ?></a>
                <a href="<?php echo $type; ?>_<?php echo $gameinfo['showkey']; ?>.html?action=play">玩法模式</a>
                <a href="<?php echo $type; ?>_<?php echo $gameinfo['showkey']; ?>.html?action=pos">位置模式</a>
            </div>
            <div>
                <!--<a>旧版<?php echo $typename; ?>>></a>-->
            </div>
        </div>
        <!--<?php echo $typename; ?>模式选择-->

        <div class="lg-playMiss-main">
            <!--精选<?php echo $typename; ?>-->
            <div class="lg-playMiss-jx">
                <div class="lg-playMiss-jx-tab">
                    <span v-for="(l,index) in posAll" v-text="l.key" v-bind:class="{'active':index == posIndex}" v-bind:data-val="index" @click="posActive(index,l.value,$event)"></span>
                </div>
            </div>
            <!--精选<?php echo $typename; ?>按玩法-->

            <!--精选表格-->
            <div class="lg-playMiss-jx-table">
                <ul>
                    <?php if($gametype!='11x5'){?>
                    <li v-show="listData.arrIndex[0]">
                        <div class="table-title">
                            <span>双面<?php echo $typename; ?></span>
                            <a @click="more('大')">更多>></a>
                        </div>
                        <div class="table-type type-1">
                            <div class="table-type-pos">
                                <dl>位置</dl>
                                <dd>全部</dd>
                                <b></b>
                                <div class="table-type-span">
                                    <span data-val="0">全部</span>
                                    <span data-val="1">万位</span>
                                    <span data-val="2">千位</span>
                                    <span data-val="3">百位</span>
                                    <span data-val="4">十位</span>
                                    <span data-val="5">个位</span>
                                </div>
                            </div>
                            <div class="table-type-hm">
                                <dl>号码</dl>
                                <dd>全部</dd>
                                <b></b>
                                <div class="table-type-input">
                                    <span class="active" style="margin:0;">全部</span>
                                    <p>输入大小 单双 龙虎</p>
                                    <input type="text" name="textname" placeholder="请输入大">
                                    <p class="gs">格式:大</p>
                                    <p><span class="sure">确认</span></p>
                                </div>
                            </div>
                            <div class="table-type-miss">
                                <dl><?php echo $typename; ?></dl>
                                <dd>全部</dd>
                                <b></b>
                                <div class="table-type-dy">
                                    <span class="active" style="margin:0;">全部</span>
                                    <label>大于</label><input type="text" name="times"><label class="sure">确认</label>
                                    <p class="gs">格式:1~50</p>
                                </div>
                            </div>
                        </div>
                        <table>
                            <tbody>
                            <tr v-for="k in list1">
                                <td width="70px;" v-text="k.pos_name"></td>
                                <td class="td-a">
                                    {{k.num}}
                                    <a @click="copyNum(k.num,$event)" class="copyHm">复制</a>

                                </td>
                                <td v-text="k.miss" width="70px;" class="green">33</td>
                            </tr>
                            </tbody>
                        </table>
                    </li>
                    <?php }?>
                    <?php for($i=1;$i<=count($target_arr);$i++){  ?><li v-show="listData.arrIndex[<?php echo $i; ?>]">
                        <div class="table-title">
                            <span><?php echo $i; ?>码<?php echo $typename; ?></span>
                            <a @click="more(<?php echo $i; ?>)">更多>></a>
                        </div>
                        <div class="table-type type-<?php echo $i+1;?>">
                            <div class="table-type-pos">
                                <dl>位置</dl>
                                <dd>全部</dd>
                                <b></b>
                                <div class="table-type-span">
                                    <span data-val="0">全部</span>
                                    <?php foreach($pos_arr as $key =>$value){?>
                                    <span data-val="<?php echo $key+1;?>"><?php echo $value; ?></span>
                                    <?php } ?>

                                </div>
                            </div>
                            <div class="table-type-hm">
                                <dl>号码</dl>
                                <dd>全部</dd>
                                <b></b>
                                <div class="table-type-input">
                                    <span class="active" style="margin:0;">全部</span>
                                    <p>输入<?php echo $i;?>码</p>
                                    <input type="text" name="textname" placeholder="">

                                    <p><span class="sure">确认</span></p>
                                </div>
                            </div>
                            <div class="table-type-miss">
                                <dl><?php echo $typename; ?></dl>
                                <dd>全部</dd>
                                <b></b>
                                <div class="table-type-dy">
                                    <span class="active" style="margin:0;">全部</span>
                                    <label>大于</label><input type="text" name="times"><label class="sure">确认</label>
                                    <p class="gs">格式:1~50</p>
                                </div>
                            </div>
                        </div>
                        <table>
                            <tbody>
                            <tr v-for="k in list<?php echo $i+1;?>">
                                <td width="70px;" v-text="k.pos_name"></td>
                                <td class="td-a">
                                    {{k.num}}
                                    <a @click="copyNum(k.num,$event)" class="copyHm">复制</a>

                                </td>
                                <td v-text="k.miss" width="70px;" class="green">33</td>
                            </tr>
                            </tbody>
                        </table>
                    </li><?php } ?>




                    <?php if($gametype=='pk10'){?>
                    <li v-show="listData.arrIndex[11]" class="margin0">
                        <div class="table-title">
                            <span>冠亚和值</span>
                            <a @click="more('二星和值')">更多>></a>
                        </div>
                        <div class="table-type type-12">
                            <div class="table-type-pos">
                                <dl>位置</dl>
                                <dd>全部</dd>
                                <b></b>

                            </div>
                            <div class="table-type-hm">
                                <dl>号码</dl>
                                <dd>全部</dd>
                                <b></b>
                                <div class="table-type-input">
                                    <span class="active" style="margin:0;">全部</span>
                                    <p>输入号码</p>
                                    <input type="text" name="textname" placeholder="">
                                    <p><span class="sure">确认</span></p>
                                </div>
                            </div>
                            <div class="table-type-miss">
                                <dl><?php echo $typename; ?></dl>
                                <dd>全部</dd>
                                <b></b>
                                <div class="table-type-dy">
                                    <span class="active" style="margin:0;">全部</span>
                                    <label>大于</label><input type="text" name="times"><label class="sure">确认</label>
                                    <p class="gs">格式:1~50</p>
                                </div>
                            </div>
                        </div>
                        <table>
                            <tbody>
                            <tr v-for="k in list12">
                                <td width="70px;" v-text="k.pos_name"></td>
                                <td class="td-a">
                                    {{k.num}}
                                    <a @click="copyNum(k.num,$event)" class="copyHm">复制</a>

                                    <!--<a @click="analyzeFun(k.pos,11,k.num)">分析</a>-->
                                </td>
                                <td v-text="k.miss" width="70px;" class="green"></td>
                            </tr>
                            </tbody>
                        </table>
                    </li>

                    <?php }?>






                    <?php if($gametype=='ssc'){?>
                    <li v-show="listData.arrIndex[10]">
                        <div class="table-title">
                            <span>二星直选单式</span>
                            <a @click="more('二星直选单式')">更多>></a>
                        </div>
                        <div class="table-type type-11">
                            <div class="table-type-pos">
                                <dl>位置</dl>
                                <dd>全部</dd>
                                <b></b>
                                <div class="table-type-span">
                                    <span data-val="6">前二</span>
                                    <span data-val="7">后二</span>
                                </div>
                            </div>
                            <div class="table-type-hm">
                                <dl>号码</dl>
                                <dd>全部</dd>
                                <b></b>
                                <div class="table-type-input">
                                    <span class="active" style="margin:0;">全部</span>
                                    <p>输入号码</p>
                                    <input type="text" name="textname" placeholder="">
                                    <p><span class="sure">确认</span></p>
                                </div>
                            </div>
                            <div class="table-type-miss">
                                <dl><?php echo $typename; ?></dl>
                                <dd>全部</dd>
                                <b></b>
                                <div class="table-type-dy">
                                    <span class="active" style="margin:0;">全部</span>
                                    <label>大于</label><input type="text" name="times"><label class="sure">确认</label>
                                    <p class="gs">格式:1~50</p>
                                </div>
                            </div>
                        </div>
                        <table>
                            <tbody>
                            <tr v-for="k in list11">
                                <td width="70px;" v-text="k.pos_name"></td>
                                <td class="td-a">
                                    {{k.num}}
                                    <a @click="copyNum(k.num,$event)" class="copyHm">复制</a>
                                    <!--<a @click="analyzeFun(k.pos,10,k.num)">分析</a>-->
                                </td>
                                <td v-text="k.miss" width="70px;" class="green"></td>
                            </tr>
                            </tbody>
                        </table>
                    </li>
                    <li v-show="listData.arrIndex[11]" class="margin0">
                        <div class="table-title">
                            <span>二星和值</span>
                            <a @click="more('二星和值')">更多>></a>
                        </div>
                        <div class="table-type type-12">
                            <div class="table-type-pos">
                                <dl>位置</dl>
                                <dd>全部</dd>
                                <b></b>
                                <div class="table-type-span">
                                    <span data-val="6">前二</span>
                                    <span data-val="7">后二</span>
                                </div>
                            </div>
                            <div class="table-type-hm">
                                <dl>号码</dl>
                                <dd>全部</dd>
                                <b></b>
                                <div class="table-type-input">
                                    <span class="active" style="margin:0;">全部</span>
                                    <p>输入号码</p>
                                    <input type="text" name="textname" placeholder="">
                                    <p><span class="sure">确认</span></p>
                                </div>
                            </div>
                            <div class="table-type-miss">
                                <dl><?php echo $typename; ?></dl>
                                <dd>全部</dd>
                                <b></b>
                                <div class="table-type-dy">
                                    <span class="active" style="margin:0;">全部</span>
                                    <label>大于</label><input type="text" name="times"><label class="sure">确认</label>
                                    <p class="gs">格式:1~50</p>
                                </div>
                            </div>
                        </div>
                        <table>
                            <tbody>
                            <tr v-for="k in list12">
                                <td width="70px;" v-text="k.pos_name"></td>
                                <td class="td-a">
                                    {{k.num}}
                                    <a @click="copyNum(k.num,$event)" class="copyHm">复制</a>
                                    <!--<a @click="analyzeFun(k.pos,11,k.num)">分析</a>-->
                                </td>
                                <td v-text="k.miss" width="70px;" class="green"></td>
                            </tr>
                            </tbody>
                        </table>
                    </li>
                    <li v-show="listData.arrIndex[12]">
                        <div class="table-title">
                            <span>三星直选单式</span>
                            <a @click="more('三星直选单式')">更多>></a>
                        </div>
                        <div class="table-type type-13">
                            <div class="table-type-pos">
                                <dl>位置</dl>
                                <dd>全部</dd>
                                <b></b>
                                <div class="table-type-span">
                                    <span data-val="8">前三</span>
                                    <span data-val="9">中三</span>
                                    <span data-val="10">后三</span>
                                </div>
                            </div>
                            <div class="table-type-hm">
                                <dl>号码</dl>
                                <dd>全部</dd>
                                <b></b>
                                <div class="table-type-input">
                                    <span class="active" style="margin:0;">全部</span>
                                    <p>输入号码</p>
                                    <input type="text" name="textname" placeholder="">
                                    <p><span class="sure">确认</span></p>
                                </div>
                            </div>
                            <div class="table-type-miss">
                                <dl><?php echo $typename; ?></dl>
                                <dd>全部</dd>
                                <b></b>
                                <div class="table-type-dy">
                                    <span class="active" style="margin:0;">全部</span>
                                    <label>大于</label><input type="text" name="times"><label class="sure">确认</label>
                                    <p class="gs">格式:1~50</p>
                                </div>
                            </div>
                        </div>
                        <table>
                            <tbody>
                            <tr v-for="k in list13">
                                <td width="70px;" v-text="k.pos_name"></td>
                                <td class="td-a">
                                    {{k.num}}
                                    <a @click="copyNum(k.num,$event)" class="copyHm">复制</a>
                                    <!--<a @click="analyzeFun(k.pos,12,k.num)">分析</a>-->
                                </td>
                                <td v-text="k.miss" width="70px;" class="green"></td>
                            </tr>
                            </tbody>
                        </table>
                    </li>
                    <li v-show="listData.arrIndex[13]">
                        <div class="table-title">
                            <span>三星不定胆</span>
                            <a @click="more('三星不定胆')">更多>></a>
                        </div>
                        <div class="table-type type-14">
                            <div class="table-type-pos">
                                <dl>位置</dl>
                                <dd>全部</dd>
                                <b></b>
                                <div class="table-type-span">
                                    <span data-val="8">前三</span>
                                    <span data-val="9">中三</span>
                                    <span data-val="10">后三</span>
                                </div>
                            </div>
                            <div class="table-type-hm">
                                <dl>号码</dl>
                                <dd>全部</dd>
                                <b></b>
                                <div class="table-type-input">
                                    <span class="active" style="margin:0;">全部</span>
                                    <p>输入号码</p>
                                    <input type="text" name="textname" placeholder="">
                                    <p><span class="sure">确认</span></p>
                                </div>
                            </div>
                            <div class="table-type-miss">
                                <dl><?php echo $typename; ?></dl>
                                <dd>全部</dd>
                                <b></b>
                                <div class="table-type-dy">
                                    <span class="active" style="margin:0;">全部</span>
                                    <label>大于</label><input type="text" name="times"><label class="sure">确认</label>
                                    <p class="gs">格式:1~50</p>
                                </div>
                            </div>
                        </div>
                        <table>
                            <tbody>
                            <tr v-for="k in list14">
                                <td width="70px;" v-text="k.pos_name"></td>
                                <td class="td-a">
                                    {{k.num}}
                                    <a @click="copyNum(k.num,$event)" class="copyHm">复制</a>
                                    <!--<a @click="analyzeFun(k.pos,13,k.num)">分析</a>-->
                                </td>
                                <td v-text="k.miss" width="70px;" class="green"></td>
                            </tr>
                            </tbody>
                        </table>
                    </li>
                    <li v-show="listData.arrIndex[14]">
                        <div class="table-title">
                            <span>三星和值</span>
                            <a @click="more('三星和值')">更多>></a>
                        </div>
                        <div class="table-type type-15">
                            <div class="table-type-pos">
                                <dl>位置</dl>
                                <dd>全部</dd>
                                <b></b>
                                <div class="table-type-span">
                                    <span data-val="8">前三</span>
                                    <span data-val="9">中三</span>
                                    <span data-val="10">后三</span>
                                </div>
                            </div>
                            <div class="table-type-hm">
                                <dl>号码</dl>
                                <dd>全部</dd>
                                <b></b>
                                <div class="table-type-input">
                                    <span class="active" style="margin:0;">全部</span>
                                    <p>输入号码</p>
                                    <input type="text" name="textname" placeholder="">
                                    <p><span class="sure">确认</span></p>
                                </div>
                            </div>
                            <div class="table-type-miss">
                                <dl><?php echo $typename; ?></dl>
                                <dd>全部</dd>
                                <b></b>
                                <div class="table-type-dy">
                                    <span class="active" style="margin:0;">全部</span>
                                    <label>大于</label><input type="text" name="times"><label class="sure">确认</label>
                                    <p class="gs">格式:1~50</p>
                                </div>
                            </div>
                        </div>
                        <table>
                            <tbody>
                            <tr v-for="k in list15">
                                <td width="70px;" v-text="k.pos_name"></td>
                                <td class="td-a">
                                    {{k.num}}
                                    <a @click="copyNum(k.num,$event)" class="copyHm">复制</a>
                                    <!--<a @click="analyzeFun(k.pos,14,k.num)">分析</a>-->
                                </td>
                                <td v-text="k.miss" width="70px;" class="green"></td>
                            </tr>
                            </tbody>
                        </table>
                    </li>
                    <li v-show="listData.arrIndex[15]" class="margin0">
                        <div class="table-title">
                            <span>四星不定胆</span>
                            <a @click="more('四星不定胆')">更多>></a>
                        </div>
                        <div class="table-type type-16">
                            <div class="table-type-pos">
                                <dl>位置</dl>
                                <dd>全部</dd>
                                <b></b>
                                <div class="table-type-span">
                                    <span data-val="11">前四</span>
                                    <span data-val="12">后四</span>
                                </div>
                            </div>
                            <div class="table-type-hm">
                                <dl>号码</dl>
                                <dd>全部</dd>
                                <b></b>
                                <div class="table-type-input">
                                    <span class="active" style="margin:0;">全部</span>
                                    <p>输入号码</p>
                                    <input type="text" name="textname" placeholder="">
                                    <p><span class="sure">确认</span></p>
                                </div>
                            </div>
                            <div class="table-type-miss">
                                <dl><?php echo $typename; ?></dl>
                                <dd>全部</dd>
                                <b></b>
                                <div class="table-type-dy">
                                    <span class="active" style="margin:0;">全部</span>
                                    <label>大于</label><input type="text" name="times"><label class="sure">确认</label>
                                    <p class="gs">格式:1~50</p>
                                </div>
                            </div>
                        </div>
                        <table>
                            <tbody>
                            <tr v-for="k in list16">
                                <td width="70px;" v-text="k.pos_name"></td>
                                <td class="td-a">
                                    {{k.num}}
                                    <a @click="copyNum(k.num,$event)" class="copyHm">复制</a>
                                    <!--<a @click="analyzeFun(k.pos,15,k.num)">分析</a>-->
                                </td>
                                <td v-text="k.miss" width="70px;" class="green"></td>
                            </tr>
                            </tbody>
                        </table>
                    </li>
                    <li v-show="listData.arrIndex[16]">
                        <div class="table-title">
                            <span>四星和值</span>
                            <a @click="more('四星和值')">更多>></a>
                        </div>
                        <div class="table-type type-17">
                            <div class="table-type-pos">
                                <dl>位置</dl>
                                <dd>全部</dd>
                                <b></b>
                                <div class="table-type-span">
                                    <span data-val="11">前四</span>
                                    <span data-val="12">后四</span>
                                </div>
                            </div>
                            <div class="table-type-hm">
                                <dl>号码</dl>
                                <dd>全部</dd>
                                <b></b>
                                <div class="table-type-input">
                                    <span class="active" style="margin:0;">全部</span>
                                    <p>输入号码</p>
                                    <input type="text" name="textname" placeholder="">
                                    <p><span class="sure">确认</span></p>
                                </div>
                            </div>
                            <div class="table-type-miss">
                                <dl><?php echo $typename; ?></dl>
                                <dd>全部</dd>
                                <b></b>
                                <div class="table-type-dy">
                                    <span class="active" style="margin:0;">全部</span>
                                    <label>大于</label><input type="text" name="times"><label class="sure">确认</label>
                                    <p class="gs">格式:1~50</p>
                                </div>
                            </div>
                        </div>
                        <table>
                            <tbody>
                            <tr v-for="k in list17">
                                <td width="70px;" v-text="k.pos_name"></td>
                                <td class="td-a">
                                    {{k.num}}
                                    <a @click="copyNum(k.num,$event)" class="copyHm">复制</a>
                                    <!--<a @click="analyzeFun(k.pos,16,k.num)">分析</a>-->
                                </td>
                                <td v-text="k.miss" width="70px;" class="green"></td>
                            </tr>
                            </tbody>
                        </table>
                    </li>
                    <li v-show="listData.arrIndex[17]">
                        <div class="table-title">
                            <span>五星不定胆</span>
                            <a  @click="more('五星不定胆')">更多>></a>
                        </div>
                        <div class="table-type type-18">
                            <div class="table-type-pos">
                                <dl>位置</dl>
                                <dd>全部</dd>
                                <b></b>
                                <div class="table-type-span">
                                    <span data-val="13">五星</span>
                                </div>
                            </div>
                            <div class="table-type-hm">
                                <dl>号码</dl>
                                <dd>全部</dd>
                                <b></b>
                                <div class="table-type-input">
                                    <span class="active" style="margin:0;">全部</span>
                                    <p>输入号码</p>
                                    <input type="text" name="textname" placeholder="">
                                    <p><span class="sure">确认</span></p>
                                </div>
                            </div>
                            <div class="table-type-miss">
                                <dl><?php echo $typename; ?></dl>
                                <dd>全部</dd>
                                <b></b>
                                <div class="table-type-dy">
                                    <span class="active" style="margin:0;">全部</span>
                                    <label>大于</label><input type="text" name="times"><label class="sure">确认</label>
                                    <p class="gs">格式:1~50</p>
                                </div>
                            </div>
                        </div>
                        <table>
                            <tbody>
                            <tr v-for="k in list18">
                                <td width="70px;" v-text="k.pos_name"></td>
                                <td class="td-a">
                                    {{k.num}}
                                    <a @click="copyNum(k.num,$event)" class="copyHm">复制</a>
                                    <!--<a @click="analyzeFun(k.pos,17,k.num)">分析</a>-->
                                </td>
                                <td v-text="k.miss" width="70px;" class="green"></td>
                            </tr>
                            </tbody>
                        </table>
                    </li>
                    <li v-show="listData.arrIndex[18]">
                        <div class="table-title">
                            <span>五星和值</span>
                            <a @click="more('五星和值')">更多>></a>
                        </div>
                        <div class="table-type type-19">
                            <div class="table-type-pos">
                                <dl>位置</dl>
                                <dd>全部</dd>
                                <b></b>
                                <div class="table-type-span">
                                    <span data-val="13">五星</span>
                                </div>
                            </div>
                            <div class="table-type-hm">
                                <dl>号码</dl>
                                <dd>全部</dd>
                                <b></b>
                                <div class="table-type-input">
                                    <span class="active" style="margin:0;">全部</span>
                                    <p>输入号码</p>
                                    <input type="text" name="textname" placeholder="">
                                    <p><span class="sure">确认</span></p>
                                </div>
                            </div>
                            <div class="table-type-miss">
                                <dl><?php echo $typename; ?></dl>
                                <dd>全部</dd>
                                <b></b>
                                <div class="table-type-dy">
                                    <span class="active" style="margin:0;">全部</span>
                                    <label>大于</label><input type="text" name="times"><label class="sure">确认</label>
                                    <p class="gs">格式:1~50</p>
                                </div>
                            </div>
                        </div>
                        <table>
                            <tbody>
                            <tr v-for="k in list19">
                                <td width="70px;" v-text="k.pos_name"></td>
                                <td class="td-a">
                                    {{k.num}}
                                    <a @click="copyNum(k.num,$event)" class="copyHm">复制</a>
                                    <!--<a @click="analyzeFun(k.pos,18,k.num)">分析</a>-->
                                </td>
                                <td v-text="k.miss" width="70px;" class="green"></td>
                            </tr>
                            </tbody>
                        </table>
                    </li>
                    <?php }?>
                </ul>
            </div>
            <!--精选表格-->

        </div>

    </div>
<script>

var type='<?php echo $type; ?>';
var typename='<?php echo $typename; ?>';
var gametype='<?php echo $gameinfo['type']; ?>';
</script>

<script type="text/javascript" src="<?php echo $HttpPath; ?>static/web/js/cqssc/cqssc-pick.js?v=c167ceaa2357dd0f98caf9a7514f1ea5"></script>
<?php include_once template("footer");?>


</body>
</html>


