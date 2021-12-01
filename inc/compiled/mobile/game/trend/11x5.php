<script type="text/javascript" src="<?php echo $HttpPath; ?>static/web/js/jsk3/jsk3-trend-open.js?v=c167ceaa2357dd0f98caf9a7514f1ea5"></script>
<script type="text/javascript" src="<?php echo $HttpPath; ?>static/web/js/jsk3/trend-public.js?v=c167ceaa2357dd0f98caf9a7514f1ea5"></script>


<div style="background-color: #ffffff;">


    <div class="trend-panel-box1">
        <ul class="fh">
            <?php if(is_array($pos_arr)){foreach($pos_arr AS $key2=>$value2) { ?>
            <li onclick="location.href='?pos_type=<?php echo $key2; ?>';" class="fh-f9  <?php if($pos_type==$key2){?>active<?php }?>"><?php echo $value2; ?></li>


            <?php }}?>

        </ul>

    </div>
</div>
<div class="trend-panel-box3">
    <ul class="fh">
        <li class="fh-f1"><?php echo $gameinfo['title']; ?><?php echo $pos_arr[$pos_type]; ?>走势图</li>
        <li id="seting_btn"><i class="iconfont icon-shaixuan"></i>设置</li>
    </ul>
</div>


</div>

<script>

    var openInfo=myinfoData;

    var list='<?php echo $list; ?>';


    list = JSON.parse(list);
    for(var ii in list[1]){
       // console.log(ii,list[0][ii]);
    }

</script>
<div class="common-zs-table" style="position: relative;">
    <table>
        <thead>
        <tr>
            <td rowspan="2" width="100px;" class="sort-img" @click="sortImg()">
                <span>期数</span>
                <span  v-bind:class="index?'sort-img-down':'sort-img-up'"></span>
            </td>
            <td rowspan="2" colspan="5" width="90px;">开奖号</td>
            <td colspan="11"><?php echo $pos_arr[$pos_type]; ?></td>
            <td colspan="2">大小</td>
            <td colspan="2">单双</td>
            <td colspan="2">质合</td>
            <td colspan="3">012路</td>
            <td colspan="3">升平降</td>
        </tr>
        <tr>
            <td width="30px;" v-for="k in 11" v-text="k" v-bind:id="k == 1?'num':''" ></td>
            <td width="40px;">大</td>
            <td width="40px;">小</td>
            <td width="40px;">单</td>
            <td width="40px;">双</td>
            <td width="40px;">质</td>
            <td width="40px;">合</td>
            <td width="40px;">0</td>
            <td width="40px;">1</td>
            <td width="40px;">2</td>
            <td width="40px;">升</td>
            <td width="40px;">平</td>
            <td width="40px;">降</td>
        </tr>
        </thead>
        <tbody class="common-tbody-total tbody-list">
        <tr class="tbody-yc" v-if="indexsort == 1">
            <td>
                {{dateTime}}<a style="color:deeppink;">{{parseInt(resetIssue)+2 < 100?'0'+parseInt(parseInt(resetIssue)+2):parseInt(parseInt(resetIssue)+2) >= 82?'00'+2:parseInt(parseInt(resetIssue)+2)}}</a>
            </td>
            <td colspan="5">-</td>
            <td style="cursor: pointer;" v-for="num in 11" v-on:click="tdTabNum1($event.target,num)"><p class="b0" style="position: relative;z-index: 999;width: 25px;height: 25px;display: block;margin: 0 auto;border-radius:50%;"></p></td>
            <td style="cursor: pointer;" @click="ycdxFun2(1)"><p v-show=" dxcount2 == 1" class="big">大</p></td>
            <td style="cursor: pointer;" @click="ycdxFun2(2)"><p v-show=" dxcount2 == 2" class="small">小</p></td>
            <td style="cursor: pointer;" @click="ycdsFun2(1)"><p v-show=" dscount2 == 1" class="dan">单</p></td>
            <td style="cursor: pointer;" @click="ycdsFun2(2)"><p v-show=" dscount2 == 2" class="shuang">双</p></td>
            <td v-for="k in 2" style="cursor: pointer;" @click="yczhFun2(k)"><p v-show=" zhcount == k" v-bind:class="zhcount2 == k?'zhi':'he'" v-text="zhcountArr[k-1]"></p></td>
            <td style="cursor: pointer;" @click="ycluFun2(0)"><p v-show=" lucount2 == 0" class="big">0</p></td>
            <td style="cursor: pointer;" @click="ycluFun2(1)"><p v-show=" lucount2 == 1" class="small">1</p></td>
            <td style="cursor: pointer;" @click="ycluFun2(2)"><p v-show=" lucount2 == 2" class="dan">2</p></td>
            <td style="cursor: pointer;" @click="ycspjFun2(1)"><p v-show=" spjcount2 == 1" class="zhi">升</p></td>
            <td style="cursor: pointer;" @click="ycspjFun2(2)"><p v-show=" spjcount2 == 2" class="he">平</p></td>
            <td style="cursor: pointer;" @click="ycspjFun2(3)"><p v-show=" spjcount2 == 3" class="shuang">降</p></td>
        </tr>
        <tr class="tbody-yc" v-if="indexsort == 1">
            <td>
                {{dateTime}}<a style="color:deeppink;">{{parseInt(resetIssue)+1 < 100?'0'+parseInt(parseInt(resetIssue)+1):parseInt(parseInt(resetIssue)+1) >= 82?'00'+1:parseInt(parseInt(resetIssue)+1)}}</a>
            </td>
            <td colspan="5">-</td>
            <td style="cursor: pointer;" v-for="num in 11" v-on:click="tdTabNum1($event.target,num)"><p class="b0" style="position: relative;z-index: 999;width: 25px;height: 25px;display: block;margin: 0 auto;border-radius:50%;"></p></td>
            <td style="cursor: pointer;" @click="ycdxFun1(1)"><p v-show=" dxcount1 == 1" class="big">大</p></td>
            <td style="cursor: pointer;" @click="ycdxFun1(2)"><p v-show=" dxcount1 == 2" class="small">小</p></td>
            <td style="cursor: pointer;" @click="ycdsFun1(1)"><p v-show=" dscount1 == 1" class="dan">单</p></td>
            <td style="cursor: pointer;" @click="ycdsFun1(2)"><p v-show=" dscount1 == 2" class="shuang">双</p></td>
            <td v-for="k in 2" style="cursor: pointer;" @click="yczhFun1(k)"><p v-show=" zhcount1 == k" v-bind:class="zhcount1 == k?'zhi':'he'" v-text="zhcountArr[k-1]"></p></td>
            <td style="cursor: pointer;" @click="ycluFun1(0)"><p v-show=" lucount1 == 0" class="big">0</p></td>
            <td style="cursor: pointer;" @click="ycluFun1(1)"><p v-show=" lucount1 == 1" class="small">1</p></td>
            <td style="cursor: pointer;" @click="ycluFun1(2)"><p v-show=" lucount1 == 2" class="dan">2</p></td>
            <td style="cursor: pointer;" @click="ycspjFun1(1)"><p v-show=" spjcount1 == 1" class="zhi">升</p></td>
            <td style="cursor: pointer;" @click="ycspjFun1(2)"><p v-show=" spjcount1 == 2" class="he">平</p></td>
            <td style="cursor: pointer;" @click="ycspjFun1(3)"><p v-show=" spjcount1 == 3" class="shuang">降</p></td>
        </tr>
        <tr v-if="indexTime == 1">
            <td>
                {{dateTime}}<a style="color:deeppink;">{{resetIssue}}</a>
            </td>
            <td colspan="5">
                <div class="td-opentime">
                    剩余<a class="lg-minuteb"></a><b>:</b><a class="lg-secondb"></a>
                </div>
            </td>
            <td style="cursor: pointer;" v-for="num in 11" v-on:click="tdTabNum1($event.target,num)"><p class="b0" style="position: relative;z-index: 999;width: 25px;height: 25px;display: block;margin: 0 auto;border-radius:50%;"></p></td>
            <td style="cursor: pointer;" @click="ycdxFun(1)"><p v-show=" dxcount == 1" class="big">大</p></td>
            <td style="cursor: pointer;" @click="ycdxFun(2)"><p v-show=" dxcount == 2" class="small">小</p></td>
            <td style="cursor: pointer;" @click="ycdsFun(1)"><p v-show=" dscount == 1" class="dan">单</p></td>
            <td style="cursor: pointer;" @click="ycdsFun(2)"><p v-show=" dscount == 2" class="shuang">双</p></td>
            <td v-for="k in 2" style="cursor: pointer;" @click="yczhFun(k)"><p v-show=" zhcount == k" v-bind:class="zhcount == k?'zhi':'he'" v-text="zhcountArr[k-1]"></p></td>
            <td style="cursor: pointer;" @click="ycluFun(0)"><p v-show=" lucount == 0" class="big">0</p></td>
            <td style="cursor: pointer;" @click="ycluFun(1)"><p v-show=" lucount == 1" class="small">1</p></td>
            <td style="cursor: pointer;" @click="ycluFun(2)"><p v-show=" lucount == 2" class="dan">2</p></td>
            <td style="cursor: pointer;" @click="ycspjFun(1)"><p v-show=" spjcount == 1" class="zhi">升</p></td>
            <td style="cursor: pointer;" @click="ycspjFun(2)"><p v-show=" spjcount == 2" class="he">平</p></td>
            <td style="cursor: pointer;" @click="ycspjFun(3)"><p v-show=" spjcount == 3" class="shuang">降</p></td>
        </tr>
        <tr v-for="(l,k) in data">
            <td class="border-td" v-html="expectFun(l.expect)"></td>
            <td width="25px;" v-text="l.num1" <?php if($pos_num==1){?>style="color: red;"<?php }?>></td>
            <td width="25px;" v-text="l.num2" <?php if($pos_num==2){?>style="color: red;"<?php }?>></td>
            <td width="25px;" v-text="l.num3" <?php if($pos_num==3){?>style="color: red;"<?php }?>></td>
            <td width="25px;"  v-text="l.num4" <?php if($pos_num==4){?>style="color: red;"<?php }?>></td>
            <td class="border-td" width="25px;"  v-text="l.num5" <?php if($pos_num==5){?>style="color: red;"<?php }?>></td>
            <td v-bind:class="hmylfcFun(k,i)" class="line-11 b0" v-for="(item,i) in 11" v-html="num1Html(item,l.num<?php echo $pos_num; ?>,k,i,l.miss)"></td>
            <td class="line-2" v-bind:class="hmylfcFun(k,i+11)" v-for="(item,i) in 2" v-html="dxHtml(l.dx_<?php echo $pos_num; ?>,k,i,l.miss)"></td>
            <td class="line-2" v-bind:class="hmylfcFun(k,i+13)" v-for="(item,i) in 2" v-html="dsHtml(l.ds_<?php echo $pos_num; ?>,k,i,l.miss)"></td>
            <td class="line-2" v-bind:class="hmylfcFun(k,i+15)" v-for="(item,i) in 2" v-html="zhHtml(l.zh_<?php echo $pos_num; ?>,k,i,l.miss)"></td>
            <td class="line-3" v-bind:class="hmylfcFun(k,i+18)" v-for="(item,i) in 3" v-html="luHtml(l['012_<?php echo $pos_num; ?>'],k,i,l.miss)"></td>
            <td class="line-3"v-bind:class="hmylfcFun(k,i+21)" v-for="(item,i) in 3" v-html="spHtml(l.spj_<?php echo $pos_num; ?>,k,i,l.miss)"></td>
        </tr>
        <tr v-if="indexTime == 2">
            <td>
                {{dateTime}}<a style="color:deeppink;">{{resetIssue}}</a>
            </td>
            <td colspan="5">
                <div class="td-opentime">
                    剩余<a class="lg-minuteb"></a><b>:</b><a class="lg-secondb"></a>
                </div>
            </td>
            <td style="cursor: pointer;" v-for="num in 11" v-on:click="tdTabNum1($event.target,num)"><p class="b0" style="position: relative;z-index: 999;width: 25px;height: 25px;display: block;margin: 0 auto;border-radius:50%;"></p></td>
            <td style="cursor: pointer;" @click="ycdxFun(1)"><p v-show=" dxcount == 1" class="big">大</p></td>
            <td style="cursor: pointer;" @click="ycdxFun(2)"><p v-show=" dxcount == 2" class="small">小</p></td>
            <td style="cursor: pointer;" @click="ycdsFun(1)"><p v-show=" dscount == 1" class="dan">单</p></td>
            <td style="cursor: pointer;" @click="ycdsFun(2)"><p v-show=" dscount == 2" class="shuang">双</p></td>
            <td v-for="k in 2" style="cursor: pointer;" @click="yczhFun(k)"><p v-show=" zhcount == k" v-bind:class="zhcount == k?'zhi':'he'" v-text="zhcountArr[k-1]"></p></td>
            <td style="cursor: pointer;" @click="ycluFun(0)"><p v-show=" lucount == 0" class="big">0</p></td>
            <td style="cursor: pointer;" @click="ycluFun(1)"><p v-show=" lucount == 1" class="small">1</p></td>
            <td style="cursor: pointer;" @click="ycluFun(2)"><p v-show=" lucount == 2" class="dan">2</p></td>
            <td style="cursor: pointer;" @click="ycspjFun(1)"><p v-show=" spjcount == 1" class="zhi">升</p></td>
            <td style="cursor: pointer;" @click="ycspjFun(2)"><p v-show=" spjcount == 2" class="he">平</p></td>
            <td style="cursor: pointer;" @click="ycspjFun(3)"><p v-show=" spjcount == 3" class="shuang">降</p></td>
        </tr>
        <tr class="tbody-yc" v-if="indexsort == 2">
            <td>
                {{dateTime}}<a style="color:deeppink;">{{parseInt(resetIssue)+1 < 100?'0'+parseInt(parseInt(resetIssue)+1):parseInt(parseInt(resetIssue)+1) >= 82?'00'+1:parseInt(parseInt(resetIssue)+1)}}</a>
            </td>
            <td colspan="5">-</td>
            <td style="cursor: pointer;" v-for="num in 11" v-on:click="tdTabNum1($event.target,num)"><p class="b0" style="position: relative;z-index: 999;width: 25px;height: 25px;display: block;margin: 0 auto;border-radius:50%;"></p></td>
            <td style="cursor: pointer;" @click="ycdxFun1(1)"><p v-show=" dxcount1 == 1" class="big">大</p></td>
            <td style="cursor: pointer;" @click="ycdxFun1(2)"><p v-show=" dxcount1 == 2" class="small">小</p></td>
            <td style="cursor: pointer;" @click="ycdsFun1(1)"><p v-show=" dscount1 == 1" class="dan">单</p></td>
            <td style="cursor: pointer;" @click="ycdsFun1(2)"><p v-show=" dscount1 == 2" class="shuang">双</p></td>
            <td v-for="k in 2" style="cursor: pointer;" @click="yczhFun1(k)"><p v-show=" zhcount1 == k" v-bind:class="zhcount1 == k?'zhi':'he'" v-text="zhcountArr[k-1]"></p></td>
            <td style="cursor: pointer;" @click="ycluFun1(0)"><p v-show=" lucount1 == 0" class="big">0</p></td>
            <td style="cursor: pointer;" @click="ycluFun1(1)"><p v-show=" lucount1 == 1" class="small">1</p></td>
            <td style="cursor: pointer;" @click="ycluFun1(2)"><p v-show=" lucount1 == 2" class="dan">2</p></td>
            <td style="cursor: pointer;" @click="ycspjFun1(1)"><p v-show=" spjcount1 == 1" class="zhi">升</p></td>
            <td style="cursor: pointer;" @click="ycspjFun1(2)"><p v-show=" spjcount1 == 2" class="he">平</p></td>
            <td style="cursor: pointer;" @click="ycspjFun1(3)"><p v-show=" spjcount1 == 3" class="shuang">降</p></td>
        </tr>
        <tr class="tbody-yc" v-if="indexsort == 2">
            <td>
                {{dateTime}}<a style="color:deeppink;">{{parseInt(resetIssue)+2 < 100?'0'+parseInt(parseInt(resetIssue)+2):parseInt(parseInt(resetIssue)+2) >= 82?'00'+2:parseInt(parseInt(resetIssue)+2)}}</a>
            </td>
            <td colspan="5">-</td>
            <td style="cursor: pointer;" v-for="num in 11" v-on:click="tdTabNum1($event.target,num)"><p class="b0" style="position: relative;z-index: 999;width: 25px;height: 25px;display: block;margin: 0 auto;border-radius:50%;"></p></td>
            <td style="cursor: pointer;" @click="ycdxFun2(1)"><p v-show=" dxcount2 == 1" class="big">大</p></td>
            <td style="cursor: pointer;" @click="ycdxFun2(2)"><p v-show=" dxcount2 == 2" class="small">小</p></td>
            <td style="cursor: pointer;" @click="ycdsFun2(1)"><p v-show=" dscount2 == 1" class="dan">单</p></td>
            <td style="cursor: pointer;" @click="ycdsFun2(2)"><p v-show=" dscount2 == 2" class="shuang">双</p></td>
            <td v-for="k in 2" style="cursor: pointer;" @click="yczhFun2(k)"><p v-show=" zhcount == k" v-bind:class="zhcount2 == k?'zhi':'he'" v-text="zhcountArr[k-1]"></p></td>
            <td style="cursor: pointer;" @click="ycluFun2(0)"><p v-show=" lucount2 == 0" class="big">0</p></td>
            <td style="cursor: pointer;" @click="ycluFun2(1)"><p v-show=" lucount2 == 1" class="small">1</p></td>
            <td style="cursor: pointer;" @click="ycluFun2(2)"><p v-show=" lucount2 == 2" class="dan">2</p></td>
            <td style="cursor: pointer;" @click="ycspjFun2(1)"><p v-show=" spjcount2 == 1" class="zhi">升</p></td>
            <td style="cursor: pointer;" @click="ycspjFun2(2)"><p v-show=" spjcount2 == 2" class="he">平</p></td>
            <td style="cursor: pointer;" @click="ycspjFun2(3)"><p v-show=" spjcount2 == 3" class="shuang">降</p></td>
        </tr>
        </tbody>
        <thead>
        <tr>
            <td rowspan="2" width="100px;" class="sort-img" @click="sortImg()">
                <span>期数</span>
                <span  v-bind:class="index?'sort-img-down':'sort-img-up'"></span>
            </td>
            <td rowspan="2" colspan="5" width="90px;">开奖号</td>
            <td width="30px;" v-for="k in 11" v-text="k"></td>
            <td width="40px;">大</td>
            <td width="40px;">小</td>
            <td width="40px;">单</td>
            <td width="40px;">双</td>
            <td width="40px;">质</td>
            <td width="40px;">合</td>
            <td width="40px;">0</td>
            <td width="40px;">1</td>
            <td width="40px;">2</td>
            <td width="40px;">升</td>
            <td width="40px;">平</td>
            <td width="40px;">降</td>
        </tr>
        <tr>
            <td colspan="11"><?php echo $pos_arr[$pos_type]; ?></td>
            <td colspan="2">大小</td>
            <td colspan="2">单双</td>
            <td colspan="2">质合</td>
            <td colspan="3">012路</td>
            <td colspan="3">升平降</td>
        </tr>
        </thead>
        <tbody id="total">
        <tr>
            <td colspan="6">出现次数</td>
            <td v-for="l in sta.times" v-text="l"></td>
        </tr>
        <tr>
            <td colspan="6">最大连出</td>
            <td v-for="l in sta.max_out" v-text="l"></td>
        </tr>
        <tr>
            <td colspan="6">最大遗漏</td>
            <td v-for="l in sta.max_miss" v-text="l"></td>
        </tr>
        <tr>
            <td colspan="6">平均遗漏</td>
            <td v-for="l in sta.avg_miss" v-text="l"></td>
        </tr>
        </tbody>
    </table>
    <table class="table-date" style="position: absolute;right:-91px;top:0;display: none;">
        <thead>
        <tr>
            <td width="90px;" style="height: 62px;">年月日</td>
        </tr>
        </thead>
        <tbody class="tbody-yc" v-if="indexsort == 1">
        <tr>
            <td style="height: 31px;"></td>
        </tr>
        </tbody>
        <tbody>
        <tr v-for="l in data">
            <td  v-text="dateFun(l.opentime)"></td>
        </tr>
        </tbody>
        <tbody class="tbody-yc" v-if="indexsort == 2">
        <tr><td style="height: 31px;"></td>
        </tr>
        </tbody>
        <thead>
        <tr>
            <td width="90px;" style="height: 62px;">年月日</td>
        </tr>
        </thead>
    </table>
</div>
<div class="line">
    <svg version='1.1' xmlns='//www.w3.org/2000/svg' id="mysvgb0"></svg>
</div>
<script>
    var fields = {
        num<?php echo $pos_num; ?>: [1,2,3,4,5,6,7,8,9,10,11],
        dx_<?php echo $pos_num; ?>:['大','小'],
        ds_<?php echo $pos_num; ?>:['单','双'],
        zh_<?php echo $pos_num; ?>:['质','合'],
        '012_<?php echo $pos_num; ?>':[0,1,2],
        spj_<?php echo $pos_num; ?>:['升','平','降']
    };

    var pos=1;
</script>
<script type="text/javascript" src="<?php echo $HttpPath; ?>static/web/js/gd11x5/trend-common.js?v=c167ceaa2357dd0f98caf9a7514f1ea5"></script>