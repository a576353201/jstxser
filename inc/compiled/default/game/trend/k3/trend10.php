<div class="common-zs-table" style="position: relative;">
    <table>
        <thead>
        <tr>
            <td rowspan="2" width="100px;" class="sort-img" @click="sortImg()">
                <span>期数</span>
                <span  v-bind:class="index?'sort-img-down':'sort-img-up'"></span>
            </td>
            <td rowspan="2" colspan="3" width="90px;">开奖号</td>
            <td colspan="20">三不同号</td>
        </tr>
        <tr>
            <td width="70px;">123</td>
            <td width="70px;">124</td>
            <td width="70px;">125</td>
            <td width="70px;">126</td>
            <td width="70px;">134</td>
            <td width="70px;">135</td>
            <td width="70px;">136</td>
            <td width="70px;">145</td>
            <td width="70px;">146</td>
            <td width="70px;">156</td>
            <td width="70px;">234</td>
            <td width="70px;">235</td>
            <td width="70px;">236</td>
            <td width="70px;">245</td>
            <td width="70px;">246</td>
            <td width="70px;">256</td>
            <td width="70px;">345</td>
            <td width="70px;">346</td>
            <td width="70px;">356</td>
            <td width="70px;">456</td>
        </tr>
        </thead>
        <tbody class="common-tbody-total tbody-list">
        <tr class="tbody-yc" v-if="indexsort == 1">
            <td>
                {{dateTime}}<a style="color:deeppink;">{{parseInt(resetIssue)+2 < 100?'0'+parseInt(parseInt(resetIssue)+2):parseInt(parseInt(resetIssue)+2) >= 82?'00'+2:parseInt(parseInt(resetIssue)+2)}}</a>
            </td>
            <td colspan="3">-</td>
            <td style="cursor: pointer;" v-for="i in 20" @click="ycsame2Fun2(i)"><p v-show=" xt1count2 == i" class="status1-2">{{nosame[i-1]}}</p></td>
        </tr>
        <tr class="tbody-yc" v-if="indexsort == 1">
            <td>
                {{dateTime}}<a style="color:deeppink;">{{parseInt(resetIssue)+1 < 100?'0'+parseInt(parseInt(resetIssue)+1):parseInt(parseInt(resetIssue)+1) >= 82?'00'+1:parseInt(parseInt(resetIssue)+1)}}</a>
            </td>
            <td colspan="3">-</td>
            <td style="cursor: pointer;" v-for="i in 20" @click="ycsame2Fun1(i)"><p v-show=" xt1count1 == i" class="status1-2">{{nosame[i-1]}}</p></td>
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
            <td style="cursor: pointer;" v-for="i in 20" @click="ycsame2Fun(i)"><p v-show=" xt1count == i" class="status1-2">{{nosame[i-1]}}</p></td>
        </tr>
        <tr v-for="(l,k) in data">
            <td class="border-td" v-html="expectFun(l.expect)"></td>
            <td width="35px;" v-bind:class="classFun(l.num1,l.num2,l.num3)" v-text="l.num1"></td>
            <td width="35px;" v-bind:class="classFun(l.num1,l.num2,l.num3)" v-text="l.num2"></td>
            <td class="border-td" width="35px;" v-bind:class="classFun(l.num1,l.num2,l.num3)" v-text="l.num3"></td>
            <td class="line-20" v-bind:class="hmylfcFun(k,i)" v-for="(item,i) in 20" v-html="nosame3Html(l.different3,k,i,l.miss)"></td>
        </tr>
        <tr  v-if="indexTime == 2">
            <td>
                {{dateTime}}<a style="color:deeppink;">{{resetIssue}}</a>
            </td>
            <td colspan="3">
                <div class="td-opentime">
                    剩余<a class="lg-minuteb"></a><b>:</b><a class="lg-secondb"></a>
                </div>
            </td>
            <td style="cursor: pointer;" v-for="i in 20" @click="ycsame2Fun(i)"><p v-show=" xt1count == i" class="status1-2">{{nosame[i-1]}}</p></td>
        </tr>
        <tr class="tbody-yc" v-if="indexsort == 2">
            <td>
                {{dateTime}}<a style="color:deeppink;">{{parseInt(resetIssue)+1 < 100?'0'+parseInt(parseInt(resetIssue)+1):parseInt(parseInt(resetIssue)+1) >= 82?'00'+1:parseInt(parseInt(resetIssue)+1)}}</a>
            </td>
            <td colspan="3">-</td>
            <td style="cursor: pointer;" v-for="i in 20" @click="ycsame2Fun1(i)"><p v-show=" xt1count1 == i" class="status1-2">{{nosame[i-1]}}</p></td>
        </tr>
        <tr class="tbody-yc" v-if="indexsort == 2">
            <td>
                {{dateTime}}<a style="color:deeppink;">{{parseInt(resetIssue)+2 < 100?'0'+parseInt(parseInt(resetIssue)+2):parseInt(parseInt(resetIssue)+2) >= 82?'00'+2:parseInt(parseInt(resetIssue)+2)}}</a>
            </td>
            <td colspan="3">-</td>
            <td style="cursor: pointer;" v-for="i in 20" @click="ycsame2Fun2(i)"><p v-show=" xt1count2 == i" class="status1-2">{{nosame[i-1]}}</p></td>
        </tr>
        </tbody>
        <thead>
        <tr>
            <td rowspan="2" width="100px;" class="sort-img" @click="sortImg()">
                <span>期数</span>
                <span  v-bind:class="index?'sort-img-down':'sort-img-up'"></span>
            </td>
            <td rowspan="2" colspan="3" width="90px;">开奖号</td>
            <td width="70px;">123</td>
            <td width="70px;">124</td>
            <td width="70px;">125</td>
            <td width="70px;">126</td>
            <td width="70px;">134</td>
            <td width="70px;">135</td>
            <td width="70px;">136</td>
            <td width="70px;">145</td>
            <td width="70px;">146</td>
            <td width="70px;">156</td>
            <td width="70px;">234</td>
            <td width="70px;">235</td>
            <td width="70px;">236</td>
            <td width="70px;">245</td>
            <td width="70px;">246</td>
            <td width="70px;">256</td>
            <td width="70px;">345</td>
            <td width="70px;">346</td>
            <td width="70px;">356</td>
            <td width="70px;">456</td>
        </tr>
        <tr>
            <td colspan="20">三不同号</td>
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