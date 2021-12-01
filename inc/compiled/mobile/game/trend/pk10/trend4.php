<style>
    .common-zs-table table tr td {
        width: 30px;
        height: 30px;
    }
</style>
<div class="common-zs-table" style="position: relative;"  v-cloak>
    <table>
        <thead>
        <tr>
            <td rowspan="2" width="100px;" class="sort-img" @click="sortImg()">
                <span>期数</span>
                <span  v-bind:class="index?'sort-img-down':'sort-img-up'"></span>
            </td>
            <td rowspan="2">开奖号</td>
            <td colspan="4"><?php echo $pos_arr[$pos_num]; ?>龙虎</td>
        </tr>
        <tr>
            <td><?php echo $pos_arr[$pos_num]; ?></td>
            <td><?php echo $pos_arr[11-$pos_num]; ?></td>
            <td>龙</td>
            <td>虎</td>
        </tr>
        </thead>
        <tbody class="tbody-list common-tbody-total">
        <tr class="tbody-yc" v-if="indexsort == 1">
            <td>
                {{dateTimeXyft}}<a style="color:deeppink;">{{parseInt(resetIssue)+2 < 100?'0'+parseInt(parseInt(resetIssue)+2):parseInt(parseInt(resetIssue)+2) >= 180?'00'+2:parseInt(parseInt(resetIssue)+2)}}</a>
            </td>
            <td>-</td>
            <td>-</td>
            <td>-</td>
            <td style="cursor: pointer;" @click="dsFun2(1)"><p class="dan" v-show="dscount2 == 1">龙</p></td>
            <td style="cursor: pointer;" @click="dsFun2(2)"><p class="shuang" v-show="dscount2 == 2">虎</p></td>
        </tr>
        <tr class="tbody-yc" v-if="indexsort == 1">
            <td>
                {{dateTimeXyft}}<a style="color:deeppink;">{{parseInt(resetIssue)+1 < 100?'0'+parseInt(parseInt(resetIssue)+1):parseInt(parseInt(resetIssue)+1) >= 180?'00'+1:parseInt(parseInt(resetIssue)+1)}}</a>
            </td>
            <td>-</td>
            <td>-</td>
            <td>-</td>
            <td style="cursor: pointer;" @click="dsFun1(1)"><p class="dan" v-show="dscount1 == 1">龙</p></td>
            <td style="cursor: pointer;" @click="dsFun1(2)"><p class="shuang" v-show="dscount1 == 2">虎</p></td>
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
            <td>-</td>
            <td>-</td>
            <td style="cursor: pointer;" @click="dsFun(1)"><p class="dan" v-show="dscount == 1">龙</p></td>
            <td style="cursor: pointer;" @click="dsFun(2)"><p class="shuang" v-show="dscount == 2">虎</p></td>
        </tr>
        <tr v-for="(l,i) in data">
            <td class="border-td" v-html="expectxyftFun(l.expect)"></td>
            <td class="border-td border-R" v-html="numberFun(l.num,<?php echo $pos_num; ?>)"></td>
            <td class="border-R" v-text="l.num[<?php echo $pos_num-1; ?>]" style="color: red;"></td>
            <td class="border-R" v-text="l.num[<?php echo 10-$pos_num;?>]" style="color: red;"></td>
            <td class="line-2" v-bind:class="hmylfcFun(i,k+2)" v-for="(item,k) in 2" v-html="lhHtml(l.lh_<?php echo $pos_num; ?>,k,l.miss)"></td>
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
            <td>-</td>
            <td>-</td>
            <td style="cursor: pointer;" @click="dsFun(1)"><p class="dan" v-show="dscount == 1">龙</p></td>
            <td style="cursor: pointer;" @click="dsFun(2)"><p class="shuang" v-show="dscount == 2">虎</p></td>
        </tr>
        <tr class="tbody-yc" v-if="indexsort == 2">
            <td>
                {{dateTimeXyft}}<a style="color:deeppink;">{{parseInt(resetIssue)+1 < 100?'0'+parseInt(parseInt(resetIssue)+1):parseInt(parseInt(resetIssue)+1) >= 180?'00'+1:parseInt(parseInt(resetIssue)+1)}}</a>
            </td>
            <td>-</td>
            <td>-</td>
            <td>-</td>
            <td style="cursor: pointer;" @click="dsFun1(1)"><p class="dan" v-show="dscount1 == 1">龙</p></td>
            <td style="cursor: pointer;" @click="dsFun1(2)"><p class="shuang" v-show="dscount1 == 2">虎</p></td>
        </tr>
        <tr class="tbody-yc" v-if="indexsort == 2">
            <td>
                {{dateTimeXyft}}<a style="color:deeppink;">{{parseInt(resetIssue)+2 < 100?'0'+parseInt(parseInt(resetIssue)+2):parseInt(parseInt(resetIssue)+2) >= 180?'00'+2:parseInt(parseInt(resetIssue)+2)}}</a>
            </td>
            <td>-</td>
            <td>-</td>
            <td>-</td>
            <td style="cursor: pointer;" @click="dsFun2(1)"><p class="dan" v-show="dscount2 == 1">龙</p></td>
            <td style="cursor: pointer;" @click="dsFun2(2)"><p class="shuang" v-show="dscount2 == 2">虎</p></td>
        </tr>
        </tbody>
        <thead>
        <tr>
            <td rowspan="2" width="100px;" class="sort-img" @click="sortImg()">
                <span>期数</span>
                <span  v-bind:class="index?'sort-img-down':'sort-img-up'"></span>
            </td>
            <td rowspan="2">开奖号</td>
            <td><?php echo $pos_arr[$pos_num]; ?></td>
            <td><?php echo $pos_arr[11-$pos_num]; ?></td>
            <td>龙</td>
            <td>虎</td>
        </tr>
        <tr>
            <td colspan="4"><?php echo $pos_arr[$pos_num]; ?>龙虎</td>
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


    var fields = {
        lh_1:[0],
        lh_2:[0],
        lh_3:['龙','虎'],
    };

    var from = 2;
</script>
<script type="text/javascript" src="<?php echo $HttpPath; ?>static/web/js/pk10/pk10-trend4_1.js?v=c167ceaa2357dd0f98caf9a7514f1ea5"></script>