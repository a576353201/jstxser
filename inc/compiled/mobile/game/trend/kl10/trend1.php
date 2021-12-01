<div class="common-zs-table" style="position: relative;">
    <table>
        <thead>
        <tr>
            <td rowspan="2" width="100px;" class="sort-img" @click="sortImg()">
                <span>期数</span>
                <span  v-bind:class="index?'sort-img-down':'sort-img-up'"></span>
            </td>
            <td rowspan="2" colspan="8" width="150px;">开奖号</td>
            <td colspan="20">号码分步</td>
            <td colspan="8">总分</td>

        </tr>
        <tr>
            <td v-for="k in 20" width="30px;" v-text="k"></td>
            <td width="30px;">和值</td>
            <td width="30px;">大</td>
            <td width="30px;">和</td>
            <td width="30px;">小</td>
            <td width="30px;">单</td>
            <td width="30px;">双</td>

            <td width="30px;">尾大</td>
            <td width="30px;">尾小</td>

        </tr>
        </thead>
        <tbody class="tbody-yc" v-if="indexsort == 1">
        <tr>
            <td>
                {{dateTime}}<a style="color:deeppink;">{{parseInt(resetIssue)+2 < 100?'0'+parseInt(parseInt(resetIssue)+2):parseInt(parseInt(resetIssue)+2) >= 120?'00'+2:parseInt(parseInt(resetIssue)+2)}}</a>
            </td>
            <td colspan="8">-</td>
            <td v-for="k in 20" style="cursor: pointer;" @click="ychmFun(k,$event.target)"></td>
            <td width="30px;"></td>
            <td width="30px;"></td>
            <td width="30px;"></td>
            <td width="30px;"></td>
            <td width="30px;"></td>
            <td width="30px;"></td>

            <td width="30px;"></td>
            <td width="30px;"></td>
        </tr>
        <tr>
            <td>
                {{dateTime}}<a style="color:deeppink;">{{parseInt(resetIssue)+1 < 100?'0'+parseInt(parseInt(resetIssue)+1):parseInt(parseInt(resetIssue)+1) >= 120?'00'+1:parseInt(parseInt(resetIssue)+1)}}</a>
            </td>
            <td colspan="8">-</td>
            <td v-for="k in 20" style="cursor: pointer;" @click="ychmFun(k-1,$event.target)"></td>
            <td width="30px;"></td>
            <td width="30px;"></td>
            <td width="30px;"></td>
            <td width="30px;"></td>
            <td width="30px;"></td>
            <td width="30px;"></td>

            <td width="30px;"></td>
            <td width="30px;"></td>
        </tr>
        </tbody>
        <tbody class="tbody-list">
        <tr v-if="indexTime == 1">
            <td>
                {{dateTime}}<a style="color:deeppink;">{{resetIssue}}</a>
            </td>
            <td colspan="8">
                <div class="td-opentime">
                    剩余<a class="lg-minuteb"></a><b>:</b><a class="lg-secondb"></a>
                </div>
            </td>
            <td v-for="k in 20" style="cursor: pointer;" @click="ychmFun(k,$event.target)"></td>
            <td width="30px;"></td>
            <td width="30px;"></td>
            <td width="30px;"></td>
            <td width="30px;"></td>
            <td width="30px;"></td>
            <td width="30px;"></td>

            <td width="30px;"></td>
            <td width="30px;"></td>

        </tr>
        <tr v-for="(l,i) in data">
            <td class="border-td" v-html="expectFun(l.expect)"></td>
            <td width="25px;" v-text="l.num1"></td>
            <td width="25px;" v-text="l.num2"></td>
            <td width="25px;" v-text="l.num3"></td>
            <td width="25px;"  v-text="l.num4"></td>
            <td width="25px;"  v-text="l.num5"></td>
            <td width="25px;"  v-text="l.num6"></td>
            <td width="25px;"  v-text="l.num7"></td>

            <td class="border-td" width="25px;"  v-text="l.num8"></td>
            <td class="hm-R line-20" v-bind:class="hmylfcFun(k,n)" v-for="(k,n) in 20" v-html="hmHtml(l.numArr,n+1,l.miss)"></td>
            <td class="border-td" v-text="l.sum_val"></td>
            <td class="line-3" v-bind:class="hmylfcFun(k,i+21)" v-for="(item,k) in 3" v-html="dxHtml(l.sum_dx,k,l.miss)"></td>
            <td class="line-2" v-bind:class="hmylfcFun(k,i+24)" v-for="(item,k) in 2" v-html="dsHtml(l.sum_ds,k,l.miss)"></td>
            <td class="line-2" v-bind:class="hmylfcFun(k,i+26)" v-for="(item,k) in 2" v-html="dxtHtml(l.sum_tail_dx,k,l.miss)"></td>

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
            <td v-for="k in 20" style="cursor: pointer;" @click="ychmFun(k-1,$event.target)"></td>
            <td width="30px;"></td>
            <td width="30px;"></td>
            <td width="30px;"></td>
            <td width="30px;"></td>
            <td width="30px;"></td>
            <td width="30px;"></td>

            <td width="30px;"></td>
            <td width="30px;"></td>
        </tr>
        </tbody>

        <thead>
        <tr>
            <td rowspan="2" width="100px;" class="sort-img" @click="sortImg()">
                <span>期数</span>
                <span  v-bind:class="index?'sort-img-down':'sort-img-up'"></span>
            </td>
            <td rowspan="2" colspan="8" width="150px;">开奖号</td>
            <td colspan="20">号码分步</td>
            <td colspan="8">总分</td>

        </tr>
        <tr>
            <td v-for="k in 20" width="30px;" v-text="k"></td>
            <td width="30px;">和值</td>
            <td width="30px;">大</td>
            <td width="30px;">和</td>
            <td width="30px;">小</td>
            <td width="30px;">单</td>
            <td width="30px;">双</td>

            <td width="30px;">尾大</td>
            <td width="30px;">尾小</td>

        </tr>
        </thead>
        <tbody id="total">
        <tr>
            <td colspan="9">出现次数</td>
            <td v-for="(l,n) in sta.times" v-text="lHtml(l,n)"></td>
        </tr>
        <tr>
            <td colspan="9">最大连出</td>
            <td v-for="(l,n) in sta.max_out" v-text="lHtml(l,n)"></td>
        </tr>
        <tr>
            <td colspan="9">最大遗漏</td>
            <td v-for="(l,n) in sta.max_miss" v-text="lHtml(l,n)"></td>
        </tr>
        <tr>
            <td colspan="9">平均遗漏</td>
            <td v-for="(l,n) in sta.avg_miss" v-text="lHtml(l,n)"></td>
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

<script>


    var fields = {

        sum_val:[0],
        sum_dx: ['大','和','小'],
        sum_ds: ['单','双'],
        sum_tail_dx:['大','小']
    };
    var fields2 = [['num1','num2','num3','num5','num6','num7','num8'], [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20]];
    var pos=<?php echo $pos_type; ?>;

</script>
<script type="text/javascript" src="<?php echo $HttpPath; ?>static/web/js/gdklsf/trend1_1.js?v=c167ceaa2357dd0f98caf9a7514f1ea5"></script>




