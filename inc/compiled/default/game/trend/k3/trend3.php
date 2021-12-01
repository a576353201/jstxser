<div class="common-zs-table" style="position: relative;">
    <table>
        <thead>
        <tr>
            <td rowspan="2" width="100px;" class="sort-img" @click="sortImg()">
                <span>期数</span>
                <span  v-bind:class="index?'sort-img-down':'sort-img-up'"></span>
            </td>
            <td rowspan="2" colspan="3" width="90px;">开奖号</td>
            <td colspan="3">形态一</td>
            <td colspan="6">形态二</td>
        </tr>
        <tr>
            <td width="80px;">三同号</td>
            <td width="80px;">二同号</td>
            <td width="80px;">三不同</td>
            <td width="80px;">豹子</td>
            <td width="80px;">对子</td>
            <td width="80px;">顺子</td>
            <td width="80px;">半顺</td>
            <td width="80px;">杂六</td>
        </tr>
        </thead>
        <tbody class="common-tbody-total tbody-list">
        <tr class="tbody-yc" v-if="indexsort == 1">
            <td>
                {{dateTime}}<a style="color:deeppink;">{{parseInt(resetIssue)+2 < 100?'0'+parseInt(parseInt(resetIssue)+2):parseInt(parseInt(resetIssue)+2) >= 82?'00'+2:parseInt(parseInt(resetIssue)+2)}}</a>
            </td>
            <td colspan="3">-</td>
            <td style="cursor: pointer;" @click="ycxt1Fun2(1)"><p v-show=" xt1count2 == 1" class="status1-3">三同号</p></td>
            <td style="cursor: pointer;" @click="ycxt1Fun2(2)"><p v-show=" xt1count2 == 2" class="status1-2">二同号</p></td>
            <td style="cursor: pointer;" @click="ycxt1Fun2(3)"><p v-show=" xt1count2 == 3" class="status1-1">三不同</p></td>
            <td style="cursor: pointer;" @click="ycxt2Fun2(1)"><p v-show=" xt2count2 == 1" class="status1-3">三同号</p></td>
            <td style="cursor: pointer;" @click="ycxt2Fun2(2)"><p v-show=" xt2count2 == 2" class="status1-2">二同号</p></td>
            <td style="cursor: pointer;" @click="ycxt2Fun2(3)"><p v-show=" xt2count2 == 3" class="dscount">三不同</p></td>
            <td style="cursor: pointer;" @click="ycxt2Fun2(4)"><p v-show=" xt2count2 == 4" class="big">三同号</p></td>
            <td style="cursor: pointer;" @click="ycxt2Fun2(5)"><p v-show=" xt2count2 == 5" class="dan">二同号</p></td>
        </tr>
        <tr class="tbody-yc" v-if="indexsort == 1">
            <td>
                {{dateTime}}<a style="color:deeppink;">{{parseInt(resetIssue)+1 < 100?'0'+parseInt(parseInt(resetIssue)+1):parseInt(parseInt(resetIssue)+1) >= 82?'00'+1:parseInt(parseInt(resetIssue)+1)}}</a>
            </td>
            <td colspan="3">-</td>
            <td style="cursor: pointer;" @click="ycxt1Fun1(1)"><p v-show=" xt1count1 == 1" class="status1-3">三同号</p></td>
            <td style="cursor: pointer;" @click="ycxt1Fun1(2)"><p v-show=" xt1count1 == 2" class="status1-2">二同号</p></td>
            <td style="cursor: pointer;" @click="ycxt1Fun1(3)"><p v-show=" xt1count1 == 3" class="status1-1">三不同</p></td>
            <td style="cursor: pointer;" @click="ycxt2Fun1(1)"><p v-show=" xt2count1 == 1" class="status1-3">三同号</p></td>
            <td style="cursor: pointer;" @click="ycxt2Fun1(2)"><p v-show=" xt2count1 == 2" class="status1-2">二同号</p></td>
            <td style="cursor: pointer;" @click="ycxt2Fun1(3)"><p v-show=" xt2count1 == 3" class="dscount">三不同</p></td>
            <td style="cursor: pointer;" @click="ycxt2Fun1(4)"><p v-show=" xt2count1 == 4" class="big">三同号</p></td>
            <td style="cursor: pointer;" @click="ycxt2Fun1(5)"><p v-show=" xt2count1 == 5" class="dan">二同号</p></td>
        </tr>
        <tr  v-if="indexTime == 1">
            <td>
                {{dateTime}}<a style="color:deeppink;">{{resetIssue}}</a>
            </td>
            <td colspan="3">
                <div class="td-opentime">
                    剩余<a class="lg-minuteb"></a><b>:</b><a class="lg-secondb"></a>
                </div>
            </td>
            <td style="cursor: pointer;" @click="ycxt1Fun(1)"><p v-show=" xt1count == 1" class="status1-3">三同号</p></td>
            <td style="cursor: pointer;" @click="ycxt1Fun(2)"><p v-show=" xt1count == 2" class="status1-2">二同号</p></td>
            <td style="cursor: pointer;" @click="ycxt1Fun(3)"><p v-show=" xt1count == 3" class="status1-1">三不同</p></td>
            <td style="cursor: pointer;" @click="ycxt2Fun(1)"><p v-show=" xt2count == 1" class="status1-3">三同号</p></td>
            <td style="cursor: pointer;" @click="ycxt2Fun(2)"><p v-show=" xt2count == 2" class="status1-2">二同号</p></td>
            <td style="cursor: pointer;" @click="ycxt2Fun(3)"><p v-show=" xt2count == 3" class="dscount">三不同</p></td>
            <td style="cursor: pointer;" @click="ycxt2Fun(4)"><p v-show=" xt2count == 4" class="big">三同号</p></td>
            <td style="cursor: pointer;" @click="ycxt2Fun(5)"><p v-show=" xt2count == 5" class="dan">二同号</p></td>
        </tr>
        <tr v-for="(l,k) in data">
            <td class="border-td" v-html="expectFun(l.expect)"></td>
            <td width="35px;" v-bind:class="classFun(l.num1,l.num2,l.num3)" v-text="l.num1"></td>
            <td width="35px;" v-bind:class="classFun(l.num1,l.num2,l.num3)" v-text="l.num2"></td>
            <td class="border-td" width="35px;" v-bind:class="classFun(l.num1,l.num2,l.num3)" v-text="l.num3"></td>
            <td v-bind:class="hmylfcFun(k,i)" class="line-3" v-for="(item,i) in 3" v-html="xt1Html(l.status1,k,i,l.miss)"></td>
            <td v-bind:class="hmylfcFun(k,i+3)" class="line-5" v-for="(item,i) in 5" v-html="xt2Html(l.status2,k,i,l.miss)"></td>
        </tr>
        <tr  v-if="indexTime == 2">
            <td>
                {{dateTime}}<a style="color:deeppink;">{{parseInt(resetIssue)+1 < 100?'0'+parseInt(parseInt(resetIssue)+1):parseInt(parseInt(resetIssue)+1) >= 82?'00'+1:parseInt(parseInt(resetIssue)+1)}}</a>
            </td>
            <td colspan="3">
                <div class="td-opentime">
                    剩余<a class="lg-minuteb"></a><b>:</b><a class="lg-secondb"></a>
                </div>
            </td>
            <td style="cursor: pointer;" @click="ycxt1Fun(1)"><p v-show=" xt1count == 1" class="status1-3">三同号</p></td>
            <td style="cursor: pointer;" @click="ycxt1Fun(2)"><p v-show=" xt1count == 2" class="status1-2">二同号</p></td>
            <td style="cursor: pointer;" @click="ycxt1Fun(3)"><p v-show=" xt1count == 3" class="status1-1">三不同</p></td>
            <td style="cursor: pointer;" @click="ycxt2Fun(1)"><p v-show=" xt2count == 1" class="status1-3">三同号</p></td>
            <td style="cursor: pointer;" @click="ycxt2Fun(2)"><p v-show=" xt2count == 2" class="status1-2">二同号</p></td>
            <td style="cursor: pointer;" @click="ycxt2Fun(3)"><p v-show=" xt2count == 3" class="dscount">三不同</p></td>
            <td style="cursor: pointer;" @click="ycxt2Fun(4)"><p v-show=" xt2count == 4" class="big">三同号</p></td>
            <td style="cursor: pointer;" @click="ycxt2Fun(5)"><p v-show=" xt2count == 5" class="dan">二同号</p></td>
        </tr>
        <tr class="tbody-yc" v-if="indexsort == 2">
            <td>
                {{dateTime}}<a style="color:deeppink;">{{resetIssue}}</a>
            </td>
            <td colspan="3">-</td>
            <td style="cursor: pointer;" @click="ycxt1Fun1(1)"><p v-show=" xt1count1 == 1" class="status1-3">三同号</p></td>
            <td style="cursor: pointer;" @click="ycxt1Fun1(2)"><p v-show=" xt1count1 == 2" class="status1-2">二同号</p></td>
            <td style="cursor: pointer;" @click="ycxt1Fun1(3)"><p v-show=" xt1count1 == 3" class="status1-1">三不同</p></td>
            <td style="cursor: pointer;" @click="ycxt2Fun1(1)"><p v-show=" xt2count1 == 1" class="status1-3">三同号</p></td>
            <td style="cursor: pointer;" @click="ycxt2Fun1(2)"><p v-show=" xt2count1 == 2" class="status1-2">二同号</p></td>
            <td style="cursor: pointer;" @click="ycxt2Fun1(3)"><p v-show=" xt2count1 == 3" class="dscount">三不同</p></td>
            <td style="cursor: pointer;" @click="ycxt2Fun1(4)"><p v-show=" xt2count1 == 4" class="big">三同号</p></td>
            <td style="cursor: pointer;" @click="ycxt2Fun1(5)"><p v-show=" xt2count1 == 5" class="dan">二同号</p></td>
        </tr>
        <tr class="tbody-yc" v-if="indexsort == 2">
            <td>
                {{dateTime}}<a style="color:deeppink;">{{parseInt(resetIssue)+2 < 100?'0'+parseInt(parseInt(resetIssue)+2):parseInt(parseInt(resetIssue)+2) >= 82?'00'+2:parseInt(parseInt(resetIssue)+2)}}</a>
            </td>
            <td colspan="3">-</td>
            <td style="cursor: pointer;" @click="ycxt1Fun2(1)"><p v-show=" xt1count2 == 1" class="status1-3">三同号</p></td>
            <td style="cursor: pointer;" @click="ycxt1Fun2(2)"><p v-show=" xt1count2 == 2" class="status1-2">二同号</p></td>
            <td style="cursor: pointer;" @click="ycxt1Fun2(3)"><p v-show=" xt1count2 == 3" class="status1-1">三不同</p></td>
            <td style="cursor: pointer;" @click="ycxt2Fun2(1)"><p v-show=" xt2count2 == 1" class="status1-3">三同号</p></td>
            <td style="cursor: pointer;" @click="ycxt2Fun2(2)"><p v-show=" xt2count2 == 2" class="status1-2">二同号</p></td>
            <td style="cursor: pointer;" @click="ycxt2Fun2(3)"><p v-show=" xt2count2 == 3" class="dscount">三不同</p></td>
            <td style="cursor: pointer;" @click="ycxt2Fun2(4)"><p v-show=" xt2count2 == 4" class="big">三同号</p></td>
            <td style="cursor: pointer;" @click="ycxt2Fun2(5)"><p v-show=" xt2count2 == 5" class="dan">二同号</p></td>
        </tr>
        </tbody>
        <thead>
        <tr>
            <td rowspan="2" width="100px;" class="sort-img" @click="sortImg()">
                <span>期数</span>
                <span  v-bind:class="index?'sort-img-down':'sort-img-up'"></span>
            </td>
            <td rowspan="2" colspan="3" width="90px;">开奖号</td>
            <td width="80px;">三同号</td>
            <td width="80px;">二同号</td>
            <td width="80px;">三不同</td>
            <td width="80px;">豹子</td>
            <td width="80px;">对子</td>
            <td width="80px;">顺子</td>
            <td width="80px;">半顺</td>
            <td width="80px;">杂六</td>
        </tr>
        <tr>
            <td rowspan="2" colspan="3" width="90px;">开奖号</td>
            <td colspan="3">形态一</td>
            <td colspan="6">形态二</td>
        </tr>
        </thead>
        <tbody id="total">
        <tr>
            <td colspan="4">出现次数</td>
            <td v-for="l in sta.times" v-text="l"></td>
        </tr>
        <tr>
            <td colspan="4">最大连出</td>
            <td v-for="l in sta.max_out" v-text="l"></td>
        </tr>
        <tr>
            <td colspan="4">最大遗漏</td>
            <td v-for="l in sta.max_miss" v-text="l"></td>
        </tr>
        <tr>
            <td colspan="4">平均遗漏</td>
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

</script>

<script type="text/javascript" src="<?php echo $HttpTemplatePath; ?>51cp/static/web/js/jsk3/jsk3-trend<?php echo $pos_type; ?>.js?v=c167ceaa2357dd0f98caf9a7514f1ea5"></script>