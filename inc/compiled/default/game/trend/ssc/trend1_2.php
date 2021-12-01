<div class="common-zs-table" style="position: relative;">
    <table style="width: 1300px;">
        <thead>
        <tr>
            <td rowspan="2" width="100px;" class="sort-img" @click="sortImg()">
                <span>期数</span>
                <span  v-bind:class="index?'sort-img-down':'sort-img-up'"></span>
            </td>
            <td colspan="10" width="30px;">第1球</td>
            <td colspan="10" width="30px;">第2球</td>
            <td colspan="10" width="30px;">第3球</td>
            <td colspan="10" width="30px;">第4球</td>
            <td colspan="10" width="30px;">第5球</td>
            <td rowspan="2" width="30px;">和值</td>
            <td rowspan="2" width="30px;">跨度</td>
            <td rowspan="2" width="30px;">区段</td>
        </tr>
        <tr>
            <td v-for="k in 10" width="30px;" v-text="k-1" v-bind:id="k == 1?'num':''"></td>
            <td v-for="k in 10" width="30px;" v-text="k-1" v-bind:id="k == 1?'num2':''"></td>
            <td v-for="k in 10" width="30px;" v-text="k-1" v-bind:id="k == 1?'num3':''"></td>
            <td v-for="k in 10" width="30px;" v-text="k-1" v-bind:id="k == 1?'num4':''"></td>
            <td v-for="k in 10" width="30px;" v-text="k-1" v-bind:id="k == 1?'num5':''"></td>
        </tr>
        </thead>
        <tbody class="tbody-list common-tbody-total">
        <tr class="tbody-yc" v-if="indexsort == 1">
            <td>
                {{dateTime}}<a style="color:deeppink;">{{parseInt(resetIssue)+2 < 100?'0'+parseInt(parseInt(resetIssue)+2):parseInt(parseInt(resetIssue)+2) >= 120?'00'+2:parseInt(parseInt(resetIssue)+2)}}</a>
            </td>
            <td style="cursor: pointer;" v-for="num in 10" v-on:click="tdTabNum1($event.target,num-1)"><p class="b0" style="position: relative;z-index: 999;width: 20px;height: 20px;display: block;margin: 0 auto;border-radius:50%;"></p></td>
            <td style="cursor: pointer;" v-for="num in 10" v-on:click="tdTabNum2($event.target,num-1)"><p class="b1" style="position: relative;z-index: 999;width: 20px;height: 20px;display: block;margin: 0 auto;border-radius:50%;"></p></td>
            <td style="cursor: pointer;" v-for="num in 10" v-on:click="tdTabNum3($event.target,num-1)"><p class="b2" style="position: relative;z-index: 999;width: 20px;height: 20px;display: block;margin: 0 auto;border-radius:50%;"></p></td>
            <td style="cursor: pointer;" v-for="num in 10" v-on:click="tdTabNum4($event.target,num-1)"><p class="b3" style="position: relative;z-index: 999;width: 20px;height: 20px;display: block;margin: 0 auto;border-radius:50%;"></p></td>
            <td style="cursor: pointer;" v-for="num in 10" v-on:click="tdTabNum5($event.target,num-1)"><p class="b4" style="position: relative;z-index: 999;width: 20px;height: 20px;display: block;margin: 0 auto;border-radius:50%;"></p></td>
            <td>-</td>
            <td>-</td>
            <td>-</td>
        </tr>
        <tr class="tbody-yc" v-if="indexsort == 1">
            <td>
                {{dateTime}}<a style="color:deeppink;">{{parseInt(resetIssue)+1 < 100?'0'+parseInt(parseInt(resetIssue)+1):parseInt(parseInt(resetIssue)+1) >= 120?'00'+1:parseInt(parseInt(resetIssue)+1)}}</a>
            </td>
            <td style="cursor: pointer;" v-for="num in 10" v-on:click="tdTabNum1($event.target,num-1)"><p class="b0" style="position: relative;z-index: 999;width: 20px;height: 20px;display: block;margin: 0 auto;border-radius:50%;"></p></td>
            <td style="cursor: pointer;" v-for="num in 10" v-on:click="tdTabNum2($event.target,num-1)"><p class="b1" style="position: relative;z-index: 999;width: 20px;height: 20px;display: block;margin: 0 auto;border-radius:50%;"></p></td>
            <td style="cursor: pointer;" v-for="num in 10" v-on:click="tdTabNum3($event.target,num-1)"><p class="b2" style="position: relative;z-index: 999;width: 20px;height: 20px;display: block;margin: 0 auto;border-radius:50%;"></p></td>
            <td style="cursor: pointer;" v-for="num in 10" v-on:click="tdTabNum4($event.target,num-1)"><p class="b3" style="position: relative;z-index: 999;width: 20px;height: 20px;display: block;margin: 0 auto;border-radius:50%;"></p></td>
            <td style="cursor: pointer;" v-for="num in 10" v-on:click="tdTabNum5($event.target,num-1)"><p class="b4" style="position: relative;z-index: 999;width: 20px;height: 20px;display: block;margin: 0 auto;border-radius:50%;"></p></td>
            <td>-</td>
            <td>-</td>
            <td>-</td>
        </tr>
        <tr v-if="indexTime == 1">
            <td>
                {{dateTime}}<a style="color:deeppink;">{{resetIssue}}</a>
            </td>
            <td style="cursor: pointer;" v-for="num in 10" v-on:click="tdTabNum1($event.target,num-1)"><p class="b0" style="position: relative;z-index: 999;width: 20px;height: 20px;display: block;margin: 0 auto;border-radius:50%;"></p></td>
            <td style="cursor: pointer;" v-for="num in 10" v-on:click="tdTabNum2($event.target,num-1)"><p class="b1" style="position: relative;z-index: 999;width: 20px;height: 20px;display: block;margin: 0 auto;border-radius:50%;"></p></td>
            <td style="cursor: pointer;" v-for="num in 10" v-on:click="tdTabNum3($event.target,num-1)"><p class="b2" style="position: relative;z-index: 999;width: 20px;height: 20px;display: block;margin: 0 auto;border-radius:50%;"></p></td>
            <td style="cursor: pointer;" v-for="num in 10" v-on:click="tdTabNum4($event.target,num-1)"><p class="b3" style="position: relative;z-index: 999;width: 20px;height: 20px;display: block;margin: 0 auto;border-radius:50%;"></p></td>
            <td style="cursor: pointer;" v-for="num in 10" v-on:click="tdTabNum5($event.target,num-1)"><p class="b4" style="position: relative;z-index: 999;width: 20px;height: 20px;display: block;margin: 0 auto;border-radius:50%;"></p></td>
            <td>-</td>
            <td>-</td>
            <td>-</td>
        </tr>
        <tr v-for="(l,i) in data">
            <td class="border-td" v-html="expectFun(l.expect)"></td>
            <td width="30px" class="line-10 b0" v-bind:class="hmylfcFun(i,k)" v-for="(item,k) in 10" v-html="num1Html(l.num1,k,l.miss)"></td>
            <td width="30px" class="line-10 b1" v-bind:class="hmylfcFun(i,k+10)" v-for="(item,k) in 10" v-html="num2Html(l.num2,k,l.miss)"></td>
            <td width="30px" class="line-10 b2" v-bind:class="hmylfcFun(i,k+20)" v-for="(item,k) in 10" v-html="num3Html(l.num3,k,l.miss)"></td>
            <td width="30px" class="line-10 b3" v-bind:class="hmylfcFun(i,k+30)" v-for="(item,k) in 10" v-html="num4Html(l.num4,k,l.miss)"></td>
            <td width="30px" class="line-10 b4" v-bind:class="hmylfcFun(i,k+40)" v-for="(item,k) in 10" v-html="num5Html(l.num5,k,l.miss)"></td>
            <td style="padding:0 8px;" class="border-td" v-text="l.sum_val"></td>
            <td style="padding:0 10px;" class="border-td" v-text="l.span"></td>
            <td style="padding:0 8px;" class="border-td" v-text="l.area"></td>
        </tr>
        <tr v-if="indexTime == 2">
            <td>
                {{dateTime}}<a style="color:deeppink;">{{resetIssue}}</a>
            </td>
            <td style="cursor: pointer;" v-for="num in 10" v-on:click="tdTabNum1($event.target,num-1)"><p class="b0" style="position: relative;z-index: 999;width: 20px;height: 20px;display: block;margin: 0 auto;border-radius:50%;"></p></td>
            <td style="cursor: pointer;" v-for="num in 10" v-on:click="tdTabNum2($event.target,num-1)"><p class="b1" style="position: relative;z-index: 999;width: 20px;height: 20px;display: block;margin: 0 auto;border-radius:50%;"></p></td>
            <td style="cursor: pointer;" v-for="num in 10" v-on:click="tdTabNum3($event.target,num-1)"><p class="b2" style="position: relative;z-index: 999;width: 20px;height: 20px;display: block;margin: 0 auto;border-radius:50%;"></p></td>
            <td style="cursor: pointer;" v-for="num in 10" v-on:click="tdTabNum4($event.target,num-1)"><p class="b3" style="position: relative;z-index: 999;width: 20px;height: 20px;display: block;margin: 0 auto;border-radius:50%;"></p></td>
            <td style="cursor: pointer;" v-for="num in 10" v-on:click="tdTabNum5($event.target,num-1)"><p class="b4" style="position: relative;z-index: 999;width: 20px;height: 20px;display: block;margin: 0 auto;border-radius:50%;"></p></td>
            <td>-</td>
            <td>-</td>
            <td>-</td>
        </tr>
        <tr class="tbody-yc" v-if="indexsort == 2">
            <td>
                {{dateTime}}<a style="color:deeppink;">{{parseInt(resetIssue)+1 < 100?'0'+parseInt(parseInt(resetIssue)+1):parseInt(parseInt(resetIssue)+1) >= 120?'00'+1:parseInt(parseInt(resetIssue)+1)}}</a>
            </td>
            <td style="cursor: pointer;" v-for="num in 10" v-on:click="tdTabNum1($event.target,num-1)"><p class="b0" style="position: relative;z-index: 999;width: 20px;height: 20px;display: block;margin: 0 auto;border-radius:50%;"></p></td>
            <td style="cursor: pointer;" v-for="num in 10" v-on:click="tdTabNum2($event.target,num-1)"><p class="b1" style="position: relative;z-index: 999;width: 20px;height: 20px;display: block;margin: 0 auto;border-radius:50%;"></p></td>
            <td style="cursor: pointer;" v-for="num in 10" v-on:click="tdTabNum3($event.target,num-1)"><p class="b2" style="position: relative;z-index: 999;width: 20px;height: 20px;display: block;margin: 0 auto;border-radius:50%;"></p></td>
            <td style="cursor: pointer;" v-for="num in 10" v-on:click="tdTabNum4($event.target,num-1)"><p class="b3" style="position: relative;z-index: 999;width: 20px;height: 20px;display: block;margin: 0 auto;border-radius:50%;"></p></td>
            <td style="cursor: pointer;" v-for="num in 10" v-on:click="tdTabNum5($event.target,num-1)"><p class="b4" style="position: relative;z-index: 999;width: 20px;height: 20px;display: block;margin: 0 auto;border-radius:50%;"></p></td>
            <td>-</td>
            <td>-</td>
            <td>-</td>
        </tr>
        <tr class="tbody-yc" v-if="indexsort == 2">
            <td>
                {{dateTime}}<a style="color:deeppink;">{{parseInt(resetIssue)+2 < 100?'0'+parseInt(parseInt(resetIssue)+2):parseInt(parseInt(resetIssue)+2) >= 120?'00'+2:parseInt(parseInt(resetIssue)+2)}}</a>
            </td>
            <td style="cursor: pointer;" v-for="num in 10" v-on:click="tdTabNum1($event.target,num-1)"><p class="b0" style="position: relative;z-index: 999;width: 20px;height: 20px;display: block;margin: 0 auto;border-radius:50%;"></p></td>
            <td style="cursor: pointer;" v-for="num in 10" v-on:click="tdTabNum2($event.target,num-1)"><p class="b1" style="position: relative;z-index: 999;width: 20px;height: 20px;display: block;margin: 0 auto;border-radius:50%;"></p></td>
            <td style="cursor: pointer;" v-for="num in 10" v-on:click="tdTabNum3($event.target,num-1)"><p class="b2" style="position: relative;z-index: 999;width: 20px;height: 20px;display: block;margin: 0 auto;border-radius:50%;"></p></td>
            <td style="cursor: pointer;" v-for="num in 10" v-on:click="tdTabNum4($event.target,num-1)"><p class="b3" style="position: relative;z-index: 999;width: 20px;height: 20px;display: block;margin: 0 auto;border-radius:50%;"></p></td>
            <td style="cursor: pointer;" v-for="num in 10" v-on:click="tdTabNum5($event.target,num-1)"><p class="b4" style="position: relative;z-index: 999;width: 20px;height: 20px;display: block;margin: 0 auto;border-radius:50%;"></p></td>
            <td>-</td>
            <td>-</td>
            <td>-</td>
        </tr>
        </tbody>
        <thead>
        <tr>
            <td rowspan="2" width="100px;" class="sort-img" @click="sortImg()">
                <span>期数</span>
                <span  v-bind:class="index?'sort-img-down':'sort-img-up'"></span>
            </td>
            <td colspan="10">第1球</td>
            <td colspan="10">第2球</td>
            <td colspan="10">第3球</td>
            <td colspan="10">第4球</td>
            <td colspan="10">第5球</td>
            <td rowspan="2">和值</td>
            <td rowspan="2">跨度</td>
            <td rowspan="2">区段</td>
        </tr>
        <tr>
            <td v-for="k in 10" width="30px;" v-text="k-1"></td>
            <td v-for="k in 10" width="30px;" v-text="k-1"></td>
            <td v-for="k in 10" width="30px;" v-text="k-1"></td>
            <td v-for="k in 10" width="30px;" v-text="k-1"></td>
            <td v-for="k in 10" width="30px;" v-text="k-1"></td>
        </tr>
        </thead>
        <tbody id="total">
        <tr>
            <td>出现次数</td>
            <td width="30px;" v-for="(l,n) in sta.times" v-text="lHtml(l,n)"></td>
        </tr>
        <tr>
            <td>最大连出</td>
            <td width="30px;" v-for="(l,n) in sta.max_out" v-text="lHtml(l,n)"></td>
        </tr>
        <tr>
            <td>最大遗漏</td>
            <td width="30px;" v-for="(l,n) in sta.max_miss" v-text="lHtml(l,n)"></td>
        </tr>
        <tr>
            <td>平均遗漏</td>
            <td width="30px;" v-for="(l,n) in sta.avg_miss" v-text="lHtml(l,n)"></td>
        </tr>
        </tbody>
    </table>
    <table class="table-date" style="position: absolute;right:-210px;top:0;display: none;width: 80px;">
        <thead>
        <tr>
            <td width="80px;" style="height: 62px;">年月日</td>
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
    <table class="table-hour" style="position: absolute;right:-245px;top:0;display: none;width: 60px;">
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
    <svg version='1.1' xmlns='//www.w3.org/2000/svg' id="mysvgb1"></svg>
    <svg version='1.1' xmlns='//www.w3.org/2000/svg' id="mysvgb2"></svg>
    <svg version='1.1' xmlns='//www.w3.org/2000/svg' id="mysvgb3"></svg>
    <svg version='1.1' xmlns='//www.w3.org/2000/svg' id="mysvgb4"></svg>
</div>

<script>

    var fields = {
        num1: [0,1,2,3,4,5,6,7,8,9],
        num2: [0,1,2,3,4,5,6,7,8,9],
        num3: [0,1,2,3,4,5,6,7,8,9],
        num4: [0,1,2,3,4,5,6,7,8,9],
        num5: [0,1,2,3,4,5,6,7,8,9],
        sum_val:[0],
        span:[0],
        area:[0]
    };

    var pos = 1;

</script>
<script type="text/javascript" src="<?php echo $HttpPath; ?>static/web/js/cqssc/cqssc-trend<?php echo $pos_type; ?>_<?php echo $pos_num; ?>.js?v=c167ceaa2357dd0f98caf9a7514f1ea5"></script>

