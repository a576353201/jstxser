<div class="common-zs-table" style="position: relative;"  v-cloak>
    <table>
        <thead>
        <tr>
            <td rowspan="2" width="100px;" class="sort-img" @click="sortImg()">
                <span>期数</span>
                <span  v-bind:class="index?'sort-img-down':'sort-img-up'"></span>
            </td>
            <td rowspan="2">开奖号</td>
            <td colspan="10"><?php echo $pos_arr[$pos_num]; ?></td>
            <td rowspan="2">大双<a style="display: block;color: #999">6,8,10</a></td>
            <td rowspan="2">大单<a style="display: block;color: #999">7,9</a></td>
            <td rowspan="2">小双<a style="display: block;color: #999">2,4</a></td>
            <td rowspan="2">小单<a style="display: block;color: #999">1,3,5</a></td>
        </tr>
        <tr>
            <td v-for="(k,i) in 10" width="30px;" v-text="k" v-bind:id="i == 0?'num':''"></td>
        </tr>
        </thead>
        <tbody class="tbody-list common-tbody-total">
        <tr class="tbody-yc" v-if="indexsort == 1">
            <td>
                {{dateTimeXyft}}<a style="color:deeppink;">{{parseInt(resetIssue)+2 < 100?'0'+parseInt(parseInt(resetIssue)+2):parseInt(parseInt(resetIssue)+2) >= 180?'00'+2:parseInt(parseInt(resetIssue)+2)}}</a>
            </td>
            <td>-</td>
            <td style="cursor: pointer;" v-for="num in 10" v-on:click="tdTabNum1($event.target,num)"><p class="b0" style="position: relative;z-index: 999;width: 25px;height: 25px;display: block;margin: 0 auto;border-radius:50%;"></p></td>
            <td style="cursor: pointer;" @click="dxFun2(1)"><p class="big" v-show="dxcount2 == 1">大双</p></td>
            <td style="cursor: pointer;" @click="dxFun2(2)"><p class="small" v-show="dxcount2 == 2">大单</p></td>
            <td style="cursor: pointer;" @click="dsFun2(1)"><p class="dan" v-show="dscount2 == 1">小双</p></td>
            <td style="cursor: pointer;" @click="dsFun2(2)"><p class="shuang" v-show="dscount2 == 2">小单</p></td>
        </tr>
        <tr class="tbody-yc" v-if="indexsort == 1">
            <td>
                {{dateTimeXyft}}<a style="color:deeppink;">{{parseInt(resetIssue)+1 < 100?'0'+parseInt(parseInt(resetIssue)+1):parseInt(parseInt(resetIssue)+1) >= 180?'00'+1:parseInt(parseInt(resetIssue)+1)}}</a>
            </td>
            <td>-</td>
            <td style="cursor: pointer;" v-for="num in 10" v-on:click="tdTabNum1($event.target,num)"><p class="b0" style="position: relative;z-index: 999;width: 25px;height: 25px;display: block;margin: 0 auto;border-radius:50%;"></p></td>
            <td style="cursor: pointer;" @click="dxFun1(1)"><p class="big" v-show="dxcount1 == 1">大双</p></td>
            <td style="cursor: pointer;" @click="dxFun1(2)"><p class="small" v-show="dxcount1 == 2">大单</p></td>
            <td style="cursor: pointer;" @click="dsFun1(1)"><p class="dan" v-show="dscount1 == 1">小双</p></td>
            <td style="cursor: pointer;" @click="dsFun1(2)"><p class="shuang" v-show="dscount1 == 2">小单</p></td>
        </tr>
        <tr v-if="indexTime == 1">
            <td>
                {{dateTimeXyft}}<a style="color:deeppink;">{{resetIssue}}</a>
            </td>
            <td>
                <div class="td-opentime">
                    剩余<a class="lg-minuteb"></a><b>:</b><a class="lg-secondb"></a>
                </div>
            </td>
            <td style="cursor: pointer;" v-for="num in 10" v-on:click="tdTabNum1($event.target,num)"><p class="b0" style="position: relative;z-index: 999;width: 25px;height: 25px;display: block;margin: 0 auto;border-radius:50%;"></p></td>
            <td style="cursor: pointer;" @click="dxFun(1)"><p class="big" v-show="dxcount == 1">大双</p></td>
            <td style="cursor: pointer;" @click="dxFun(2)"><p class="small" v-show="dxcount == 2">大单</p></td>
            <td style="cursor: pointer;" @click="dsFun(1)"><p class="dan" v-show="dscount == 1">小双</p></td>
            <td style="cursor: pointer;" @click="dsFun(2)"><p class="shuang" v-show="dscount == 2">小单</p></td>
        </tr>
        <tr v-for="(l,i) in data">
            <td class="border-td" v-html="expectxyftFun(l.expect)"></td>
            <td class="border-td border-R" v-html="numberFun(l.num1,l.num2,l.num3,l.num4,l.num5,l.num6,l.num7,l.num8,l.num9,l.num10,<?php echo $pos_num; ?>)"></td>
            <td width="30px" class="line-10 b0" v-bind:class="hmylfcFun(i,k)" v-for="(item,k) in 10"  v-html="num1Html(l.num<?php echo $pos_num; ?>,k,l.miss)"></td>
            <td class="line-4" v-bind:class="hmylfcFun(i,k+10)" v-for="(item,k) in 4" v-html="dxdsHtml(l.dxds_<?php echo $pos_num; ?>,k,l.miss)"></td>
        </tr>
        <tr v-if="indexTime == 2">
            <td>
                {{dateTimeXyft}}<a style="color:deeppink;">{{resetIssue}}</a>
            </td>
            <td>
                <div class="td-opentime">
                    剩余<a class="lg-minuteb"></a><b>:</b><a class="lg-secondb"></a>
                </div>
            </td>
            <td style="cursor: pointer;" v-for="num in 10" v-on:click="tdTabNum1($event.target,num)"><p class="b0" style="position: relative;z-index: 999;width: 25px;height: 25px;display: block;margin: 0 auto;border-radius:50%;"></p></td>
            <td style="cursor: pointer;" @click="dxFun(1)"><p class="big" v-show="dxcount == 1">大双</p></td>
            <td style="cursor: pointer;" @click="dxFun(2)"><p class="small" v-show="dxcount == 2">大单</p></td>
            <td style="cursor: pointer;" @click="dsFun(1)"><p class="dan" v-show="dscount == 1">小双</p></td>
            <td style="cursor: pointer;" @click="dsFun(2)"><p class="shuang" v-show="dscount == 2">小单</p></td>
        </tr>
        <tr class="tbody-yc" v-if="indexsort == 2">
            <td>
                {{dateTimeXyft}}<a style="color:deeppink;">{{parseInt(resetIssue)+1 < 100?'0'+parseInt(parseInt(resetIssue)+1):parseInt(parseInt(resetIssue)+1) >= 180?'00'+1:parseInt(parseInt(resetIssue)+1)}}</a>
            </td>
            <td>-</td>
            <td style="cursor: pointer;" v-for="num in 10" v-on:click="tdTabNum1($event.target,num)"><p class="b0" style="position: relative;z-index: 999;width: 25px;height: 25px;display: block;margin: 0 auto;border-radius:50%;"></p></td>
            <td style="cursor: pointer;" @click="dxFun1(1)"><p class="big" v-show="dxcount1 == 1">大双</p></td>
            <td style="cursor: pointer;" @click="dxFun1(2)"><p class="small" v-show="dxcount1 == 2">大单</p></td>
            <td style="cursor: pointer;" @click="dsFun1(1)"><p class="dan" v-show="dscount1 == 1">小双</p></td>
            <td style="cursor: pointer;" @click="dsFun1(2)"><p class="shuang" v-show="dscount1 == 2">小单</p></td>
        </tr>
        <tr class="tbody-yc" v-if="indexsort == 2">
            <td>
                {{dateTimeXyft}}<a style="color:deeppink;">{{parseInt(resetIssue)+2 < 100?'0'+parseInt(parseInt(resetIssue)+2):parseInt(parseInt(resetIssue)+2) >= 180?'00'+2:parseInt(parseInt(resetIssue)+2)}}</a>
            </td>
            <td>-</td>
            <td style="cursor: pointer;" v-for="num in 10" v-on:click="tdTabNum1($event.target,num)"><p class="b0" style="position: relative;z-index: 999;width: 25px;height: 25px;display: block;margin: 0 auto;border-radius:50%;"></p></td>
            <td style="cursor: pointer;" @click="dxFun2(1)"><p class="big" v-show="dxcount2 == 1">大双</p></td>
            <td style="cursor: pointer;" @click="dxFun2(2)"><p class="small" v-show="dxcount2 == 2">大单</p></td>
            <td style="cursor: pointer;" @click="dsFun2(1)"><p class="dan" v-show="dscount2 == 1">小双</p></td>
            <td style="cursor: pointer;" @click="dsFun2(2)"><p class="shuang" v-show="dscount2 == 2">小单</p></td>
        </tr>
        </tbody>
        <thead>
        <tr>
            <td rowspan="2" width="100px;" class="sort-img" @click="sortImg()">
                <span>期数</span>
                <span  v-bind:class="index?'sort-img-down':'sort-img-up'"></span>
            </td>
            <td rowspan="2">开奖号</td>
            <td v-for="k in 10" width="30px;" v-text="k"></td>
            <td rowspan="2">大双<a style="display: block;color: #999">6,8,10</a></td>
            <td rowspan="2">大单<a style="display: block;color: #999">7,9</a></td>
            <td rowspan="2">小双<a style="display: block;color: #999">2,4</a></td>
            <td rowspan="2">小单<a style="display: block;color: #999">1,3,5</a></td>
        </tr>
        <tr>
            <td colspan="10" width="30px;"><?php echo $pos_arr[$pos_num]; ?></td>
        </tr>
        </thead>
        <tbody id="total">
        <tr>
            <td colspan="2">出现次数</td>
            <td width="30px;" v-for="(l,n) in sta.times" v-text="lHtml(l,n)"></td>
        </tr>
        <tr>
            <td colspan="2">最大连出</td>
            <td width="30px;" v-for="(l,n) in sta.max_out" v-text="lHtml(l,n)"></td>
        </tr>
        <tr>
            <td colspan="2">最大遗漏</td>
            <td width="30px;" v-for="(l,n) in sta.max_miss" v-text="lHtml(l,n)"></td>
        </tr>
        <tr>
            <td colspan="2">平均遗漏</td>
            <td width="30px;" v-for="(l,n) in sta.avg_miss" v-text="lHtml(l,n)"></td>
        </tr>
        </tbody>
    </table>
    <table class="table-date" style="position: absolute;right:-91px;top:0;display: none;">
        <thead>
        <tr>
            <td width="90px;" style="height: 62px;">年月日</td>
        </tr>
        </thead>
        <tbody v-for="k in 2" class="tbody-yc" v-if="indexsort == 1">
        <tr>
            <td style="height: 31px;" v-text="ycDate"></td>
        </tr>
        </tbody>
        <tbody>
        <tr v-if="indexTime == 1">
            <td style="height: 31px;" v-text="ycDate"></td>
        </tr>
        <tr v-for="l in data">
            <td  style="width: 90px;" v-text="dateFun(l.opentime)"></td>
        </tr>
        <tr v-if="indexTime == 2"><td style="height: 31px;" v-text="ycDate"></td></tr>
        </tbody>
        <tbody v-for="k in 2" class="tbody-yc" v-if="indexsort == 2">
        <tr>
            <td style="height: 31px;" v-text="ycDate"></td>
        </tr>
        </tbody>
        <thead>
        <tr>
            <td width="90px;" style="height: 62px;">年月日</td>
        </tr>
        </thead>
    </table>
    <table class="table-hour" style="position: absolute;right:-151px;top:0;display: none;">
        <thead>
        <tr>
            <td width="60px;" style="height: 62px;">时分</td>
        </tr>
        </thead>
        <tbody class="tbody-yc" v-if="indexsort == 1">
        <tr>
            <td style="height: 31px;"  v-text="ycTime2"></td>
        </tr>
        </tbody>
        <tbody class="tbody-yc" v-if="indexsort == 1">
        <tr>
            <td style="height: 31px;"  v-text="ycTime1"></td>
        </tr>
        </tbody>
        <tbody>
        <tr v-if="indexTime == 1">
            <td style="height: 31px;"  v-text="ycTime"></td>
        </tr>
        <tr v-for="l in data">
            <td style="width: 60px;" v-text="timeFun(l.opentime)"></td>
        </tr>
        <tr v-if="indexTime == 2"><td style="height: 31px;" v-text="ycTime"></td></tr>
        </tbody>
        <tbody  class="tbody-yc" v-if="indexsort == 2">
        <tr><td style="height: 31px;"  v-text="ycTime1"></td>
        </tr>
        </tbody>
        <tbody  class="tbody-yc" v-if="indexsort == 2">
        <tr><td style="height: 31px;"  v-text="ycTime2"></td>
        </tr>
        </tbody>
        <thead>
        <tr>
            <td width="60px;" style="height: 62px;">时分</td>
        </tr>
        </thead>
    </table>
</div>

<div class="line">
    <svg version='1.1' xmlns='//www.w3.org/2000/svg' id="mysvgb0"></svg>
</div>
<script>
    var openInfo=myinfoData;
    var list='<?php echo $list; ?>';
    list = JSON.parse(list);
   for(var ii in list[0]){
     //  console.log(ii,list[0][ii]);
   }
    var fields = {
        num4: [1,2,3,4,5,6,7,8,9,10],
        dxds_4:['大双','大单','小双','小单'],
    };

    var from = 2;

</script>
<script type="text/javascript" src="<?php echo $HttpTemplatePath; ?>51cp/static/web/js/pk10/pk10-trend5_1.js?v=c167ceaa2357dd0f98caf9a7514f1ea5"></script
