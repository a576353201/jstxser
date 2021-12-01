<div class="common-zs-table" style="position: relative;">
    <table>
        <thead>
        <tr>
            <td rowspan="2" width="100px;" class="sort-img" @click="sortImg()">
                <span>期数</span>
                <span  v-bind:class="index?'sort-img-down':'sort-img-up'"></span>
            </td>
            <td colspan="8" rowspan="2">开奖号</td>
            <td colspan="2">第一位</td>
            <td colspan="2">第二位</td>
            <td colspan="2">第三位</td>
            <td colspan="2">第四位</td>
            <td colspan="2">第五位</td>
            <td colspan="2">第六位</td>
            <td colspan="2">第七位</td>
            <td colspan="2">第八位</td>
            <td colspan="9">单双比</td>
        </tr>
        <tr>
            <td width="30px;">单</td>
            <td width="30px;">双</td>
            <td width="30px;">单</td>
            <td width="30px;">双</td>
            <td width="30px;">单</td>
            <td width="30px;">双</td>
            <td width="30px;">单</td>
            <td width="30px;">双</td>
            <td width="30px;">单</td>
            <td width="30px;">双</td>
            <td width="30px;">单</td>
            <td width="30px;">双</td>
            <td width="30px;">单</td>
            <td width="30px;">双</td>
            <td width="30px;">单</td>
            <td width="30px;">双</td>

            <td width="35px;">0:8</td>
            <td width="35px;">1:7</td>
            <td width="35px;">2:6</td>
            <td width="35px;">3:5</td>
            <td width="35px;">4:4</td>
            <td width="35px;">5:3</td>
            <td width="35px;">6:2</td>
            <td width="35px;">7:1</td>
            <td width="35px;">8:0</td>
        </tr>
        </thead>
        <tbody class="tbody-list common-tbody-total">
        <tr class="tbody-yc" v-if="indexsort == 1">
            <td>
                {{dateTime}}<a style="color:deeppink;">{{parseInt(resetIssue)+2 < 100?'0'+parseInt(parseInt(resetIssue)+2):parseInt(parseInt(resetIssue)+2) >= 120?'00'+2:parseInt(parseInt(resetIssue)+2)}}</a>
            </td>
            <td colspan="8">-</td>
            <td width="30px;"></td>
            <td width="30px;"></td>
            <td width="30px;"></td>
            <td width="30px;"></td>
            <td width="30px;"></td>
            <td width="30px;"></td>
            <td width="30px;"></td>
            <td width="30px;"></td>
            <td width="30px;"></td>
            <td width="30px;"></td>
            <td width="30px;"></td>
            <td width="30px;"></td>
            <td width="30px;"></td>
            <td width="30px;"></td>
            <td width="30px;"></td>
            <td width="30px;"></td>

            <td width="35px;"></td>
            <td width="35px;"></td>
            <td width="35px;"></td>
            <td width="35px;"></td>
            <td width="35px;"></td>
            <td width="35px;"></td>
            <td width="35px;"></td>
            <td width="35px;"></td>
            <td width="35px;"></td>
        </tr>
        <tr class="tbody-yc" v-if="indexsort == 1">
            <td>
                {{dateTime}}<a style="color:deeppink;">{{parseInt(resetIssue)+1 < 100?'0'+parseInt(parseInt(resetIssue)+1):parseInt(parseInt(resetIssue)+1) >= 120?'00'+1:parseInt(parseInt(resetIssue)+1)}}</a>
            </td>
            <td colspan="8">-</td>
            <td width="30px;"></td>
            <td width="30px;"></td>
            <td width="30px;"></td>
            <td width="30px;"></td>
            <td width="30px;"></td>
            <td width="30px;"></td>
            <td width="30px;"></td>
            <td width="30px;"></td>
            <td width="30px;"></td>
            <td width="30px;"></td>
            <td width="30px;"></td>
            <td width="30px;"></td>
            <td width="30px;"></td>
            <td width="30px;"></td>
            <td width="30px;"></td>
            <td width="30px;"></td>

            <td width="35px;"></td>
            <td width="35px;"></td>
            <td width="35px;"></td>
            <td width="35px;"></td>
            <td width="35px;"></td>
            <td width="35px;"></td>
            <td width="35px;"></td>
            <td width="35px;"></td>
            <td width="35px;"></td>
        </tr>
        <tr  v-if="indexTime == 1">
            <td>
                {{dateTime}}<a style="color:deeppink;">{{resetIssue}}</a>
            </td>
            <td colspan="8">
                <div class="td-opentime">
                    剩余<a class="lg-minuteb"></a><b>:</b><a class="lg-secondb"></a>
                </div>
            </td>
            <td width="30px;"></td>
            <td width="30px;"></td>
            <td width="30px;"></td>
            <td width="30px;"></td>
            <td width="30px;"></td>
            <td width="30px;"></td>
            <td width="30px;"></td>
            <td width="30px;"></td>
            <td width="30px;"></td>
            <td width="30px;"></td>
            <td width="30px;"></td>
            <td width="30px;"></td>
            <td width="30px;"></td>
            <td width="30px;"></td>
            <td width="30px;"></td>
            <td width="30px;"></td>

            <td width="35px;"></td>
            <td width="35px;"></td>
            <td width="35px;"></td>
            <td width="35px;"></td>
            <td width="35px;"></td>
            <td width="35px;"></td>
            <td width="35px;"></td>
            <td width="35px;"></td>
            <td width="35px;"></td>
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
            <td class="line-2" v-bind:class="hmylfcFun(i,k)" v-for="(item,k) in 2" v-html="dx1Html(l.num1ds,k,l.miss)"></td>
            <td class="line-2" v-bind:class="hmylfcFun(i,k+2)" v-for="(item,k) in 2" v-html="dx2Html(l.num2ds,k,l.miss)"></td>
            <td class="line-2" v-bind:class="hmylfcFun(i,k+4)" v-for="(item,k) in 2" v-html="dx3Html(l.num3ds,k,l.miss)"></td>
            <td class="line-2" v-bind:class="hmylfcFun(i,k+6)" v-for="(item,k) in 2" v-html="dx4Html(l.num4ds,k,l.miss)"></td>
            <td class="line-2" v-bind:class="hmylfcFun(i,k+8)" v-for="(item,k) in 2" v-html="dx5Html(l.num5ds,k,l.miss)"></td>
            <td class="line-2" v-bind:class="hmylfcFun(i,k+10)" v-for="(item,k) in 2" v-html="dx6Html(l.num6ds,k,l.miss)"></td>
            <td class="line-2" v-bind:class="hmylfcFun(i,k+12)" v-for="(item,k) in 2" v-html="dx7Html(l.num7ds,k,l.miss)"></td>
            <td class="line-2" v-bind:class="hmylfcFun(i,k+14)" v-for="(item,k) in 2" v-html="dx8Html(l.num8ds,k,l.miss)"></td>



            <td class="line-9" v-bind:class="hmylfcFun(i,k+16)" v-for="(item,k) in 9" v-html="dxbHtml(l.ds_num,k,l.miss)"></td>
        </tr>
        <tr  v-if="indexTime == 2">
            <td>
                {{dateTime}}<a style="color:deeppink;">{{resetIssue}}</a>
            </td>
            <td colspan="8">
                <div class="td-opentime">
                    剩余<a class="lg-minuteb"></a><b>:</b><a class="lg-secondb"></a>
                </div>
            </td>
            <td width="30px;"></td>
            <td width="30px;"></td>
            <td width="30px;"></td>
            <td width="30px;"></td>
            <td width="30px;"></td>
            <td width="30px;"></td>
            <td width="30px;"></td>
            <td width="30px;"></td>
            <td width="30px;"></td>
            <td width="30px;"></td>
            <td width="30px;"></td>
            <td width="30px;"></td>
            <td width="30px;"></td>
            <td width="30px;"></td>
            <td width="30px;"></td>
            <td width="30px;"></td>

            <td width="35px;"></td>
            <td width="35px;"></td>
            <td width="35px;"></td>
            <td width="35px;"></td>
            <td width="35px;"></td>
            <td width="35px;"></td>
            <td width="35px;"></td>
            <td width="35px;"></td>
            <td width="35px;"></td>
        </tr>
        <tr class="tbody-yc" v-if="indexsort == 2">
            <td>
                {{dateTime}}<a style="color:deeppink;">{{parseInt(resetIssue)+1 < 100?'0'+parseInt(parseInt(resetIssue)+1):parseInt(parseInt(resetIssue)+1) >= 120?'00'+1:parseInt(parseInt(resetIssue)+1)}}</a>
            </td>
            <td colspan="8">-</td>
            <td width="30px;"></td>
            <td width="30px;"></td>
            <td width="30px;"></td>
            <td width="30px;"></td>
            <td width="30px;"></td>
            <td width="30px;"></td>
            <td width="30px;"></td>
            <td width="30px;"></td>
            <td width="30px;"></td>
            <td width="30px;"></td>
            <td width="30px;"></td>
            <td width="30px;"></td>
            <td width="30px;"></td>
            <td width="30px;"></td>
            <td width="30px;"></td>
            <td width="30px;"></td>

            <td width="35px;"></td>
            <td width="35px;"></td>
            <td width="35px;"></td>
            <td width="35px;"></td>
            <td width="35px;"></td>
            <td width="35px;"></td>
            <td width="35px;"></td>
            <td width="35px;"></td>
            <td width="35px;"></td>
        </tr>
        <tr class="tbody-yc" v-if="indexsort == 2">
            <td>
                {{dateTime}}<a style="color:deeppink;">{{parseInt(resetIssue)+2 < 100?'0'+parseInt(parseInt(resetIssue)+2):parseInt(parseInt(resetIssue)+2) >= 120?'00'+2:parseInt(parseInt(resetIssue)+2)}}</a>
            </td>
            <td colspan="8">-</td>
            <td width="30px;"></td>
            <td width="30px;"></td>
            <td width="30px;"></td>
            <td width="30px;"></td>
            <td width="30px;"></td>
            <td width="30px;"></td>
            <td width="30px;"></td>
            <td width="30px;"></td>
            <td width="30px;"></td>
            <td width="30px;"></td>
            <td width="30px;"></td>
            <td width="30px;"></td>
            <td width="30px;"></td>
            <td width="30px;"></td>
            <td width="30px;"></td>
            <td width="30px;"></td>

            <td width="35px;"></td>
            <td width="35px;"></td>
            <td width="35px;"></td>
            <td width="35px;"></td>
            <td width="35px;"></td>
            <td width="35px;"></td>
            <td width="35px;"></td>
            <td width="35px;"></td>
            <td width="35px;"></td>
        </tr>
        </tbody>
        <thead>
        <tr>
            <td rowspan="2" width="100px;" class="sort-img" @click="sortImg()">
                <span>期数</span>
                <span  v-bind:class="index?'sort-img-down':'sort-img-up'"></span>
            </td>
            <td colspan="8" rowspan="2">开奖号</td>
            <td colspan="2">第一位</td>
            <td colspan="2">第二位</td>
            <td colspan="2">第三位</td>
            <td colspan="2">第四位</td>
            <td colspan="2">第五位</td>
            <td colspan="2">第六位</td>
            <td colspan="2">第七位</td>
            <td colspan="2">第八位</td>
            <td colspan="9">单双比</td>
        </tr>
        <tr>
            <td width="30px;">单</td>
            <td width="30px;">双</td>
            <td width="30px;">单</td>
            <td width="30px;">双</td>
            <td width="30px;">单</td>
            <td width="30px;">双</td>
            <td width="30px;">单</td>
            <td width="30px;">双</td>
            <td width="30px;">单</td>
            <td width="30px;">双</td>
            <td width="30px;">单</td>
            <td width="30px;">双</td>
            <td width="30px;">单</td>
            <td width="30px;">双</td>
            <td width="30px;">单</td>
            <td width="30px;">双</td>

            <td width="35px;">0:8</td>
            <td width="35px;">1:7</td>
            <td width="35px;">2:6</td>
            <td width="35px;">3:5</td>
            <td width="35px;">4:4</td>
            <td width="35px;">5:3</td>
            <td width="35px;">6:2</td>
            <td width="35px;">7:1</td>
            <td width="35px;">8:0</td>
        </tr>
        </thead>
        <tbody id="total">
        <tr>
            <td colspan="9">出现次数</td>
            <td width="30px;" v-for="(l,n) in sta.times" v-text="lHtml(l,n)"></td>
        </tr>
        <tr>
            <td colspan="9">最单连出</td>
            <td width="30px;" v-for="(l,n) in sta.max_out" v-text="lHtml(l,n)"></td>
        </tr>
        <tr>
            <td colspan="9">最单遗漏</td>
            <td width="30px;" v-for="(l,n) in sta.max_miss" v-text="lHtml(l,n)"></td>
        </tr>
        <tr>
            <td colspan="9">平均遗漏</td>
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

<script>


    var fields = {
        num1ds:['单','双'],
        num2ds:['单','双'],
        num3ds:['单','双'],
        num4ds:['单','双'],
        num5ds:['单','双'],
        num6ds:['单','双'],
        num7ds:['单','双'],
        num8ds:['单','双'],
        ds_num:['0:8','1:7','2:6','3:5','4:4','5:3','6:2','7:1','8:0']

    };
    var obj = {
        arr:fields.num1ds,
        arrb:fields.ds_num
    }
</script>
<script type="text/javascript" src="<?php echo $HttpTemplatePath; ?>51cp/static/web/js/gdklsf/trend1_4.js?v=c167ceaa2357dd0f98caf9a7514f1ea5"></script>