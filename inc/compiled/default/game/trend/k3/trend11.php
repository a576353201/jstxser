<div class="common-zs-table" style="position: relative;">
    <table>
        <thead>
        <tr>
            <td rowspan="2" width="100px;" class="sort-img" @click="sortImg()">
                <span>期数</span>
                <span  v-bind:class="index?'sort-img-down':'sort-img-up'"></span>
            </td>
            <td rowspan="2" colspan="3" width="90px;">开奖号</td>
            <td colspan="6">三同号</td>
        </tr>
        <tr>
            <td width="100px;">111</td>
            <td width="100px;">222</td>
            <td width="100px;">333</td>
            <td width="100px;">444</td>
            <td width="100px;">555</td>
            <td width="100px;">666</td>
        </tr>
        </thead>
        <tbody class="common-tbody-total tbody-list">
        <tr class="tbody-yc" v-if="indexsort == 1">
            <td>
                {{dateTime}}<a style="color:deeppink;">{{parseInt(resetIssue)+2 < 100?'0'+parseInt(parseInt(resetIssue)+2):parseInt(parseInt(resetIssue)+2) >= 82?'00'+2:parseInt(parseInt(resetIssue)+2)}}</a>
            </td>
            <td colspan="3">-</td>
            <td style="cursor: pointer;" @click="ycsame2Fun2(1)"><p v-show=" xt1count2 == 1" class="status1-1">111</p></td>
            <td style="cursor: pointer;" @click="ycsame2Fun2(2)"><p v-show=" xt1count2 == 2" class="status1-1">222</p></td>
            <td style="cursor: pointer;" @click="ycsame2Fun2(3)"><p v-show=" xt1count2 == 3" class="status1-1">333</p></td>
            <td style="cursor: pointer;" @click="ycsame2Fun2(4)"><p v-show=" xt1count2 == 4" class="status1-1">444</p></td>
            <td style="cursor: pointer;" @click="ycsame2Fun2(5)"><p v-show=" xt1count2 == 5" class="status1-1">555</p></td>
            <td style="cursor: pointer;" @click="ycsame2Fun2(6)"><p v-show=" xt1count2 == 6" class="status1-1">666</p></td>
        </tr>
        <tr class="tbody-yc" v-if="indexsort == 1">
            <td>
                {{dateTime}}<a style="color:deeppink;">{{parseInt(resetIssue)+1 < 100?'0'+parseInt(parseInt(resetIssue)+1):parseInt(parseInt(resetIssue)+1) >= 82?'00'+1:parseInt(parseInt(resetIssue)+1)}}</a>
            </td>
            <td colspan="3">-</td>
            <td style="cursor: pointer;" @click="ycsame2Fun1(1)"><p v-show=" xt1count1 == 1" class="status1-1">111</p></td>
            <td style="cursor: pointer;" @click="ycsame2Fun1(2)"><p v-show=" xt1count1 == 2" class="status1-1">222</p></td>
            <td style="cursor: pointer;" @click="ycsame2Fun1(3)"><p v-show=" xt1count1 == 3" class="status1-1">333</p></td>
            <td style="cursor: pointer;" @click="ycsame2Fun1(4)"><p v-show=" xt1count1 == 4" class="status1-1">444</p></td>
            <td style="cursor: pointer;" @click="ycsame2Fun1(5)"><p v-show=" xt1count1 == 5" class="status1-1">555</p></td>
            <td style="cursor: pointer;" @click="ycsame2Fun1(6)"><p v-show=" xt1count1 == 6" class="status1-1">666</p></td>
        </tr>
        <tr v-if="indexTime == 1">
            <td>
                {{dateTime}}<a style="color:deeppink;">{{resetIssue}}</a>
            </td>
            <td colspan="3">
                <div class="td-opentime">
                    剩余<a class="lg-minuteb"></a><b>:</b><a class="lg-secondb"></a>
                </div>
            </td>
            <td style="cursor: pointer;" @click="ycsame2Fun(1)"><p v-show=" xt1count == 1" class="status1-1">111</p></td>
            <td style="cursor: pointer;" @click="ycsame2Fun(2)"><p v-show=" xt1count == 2" class="status1-1">222</p></td>
            <td style="cursor: pointer;" @click="ycsame2Fun(3)"><p v-show=" xt1count == 3" class="status1-1">333</p></td>
            <td style="cursor: pointer;" @click="ycsame2Fun(4)"><p v-show=" xt1count == 4" class="status1-1">444</p></td>
            <td style="cursor: pointer;" @click="ycsame2Fun(5)"><p v-show=" xt1count == 5" class="status1-1">555</p></td>
            <td style="cursor: pointer;" @click="ycsame2Fun(6)"><p v-show=" xt1count == 6" class="status1-1">666</p></td>
        </tr>
        <tr v-for="(l,k) in data">
            <td class="border-td" v-html="expectFun(l.expect)"></td>
            <td width="35px;" v-bind:class="classFun(l.num1,l.num2,l.num3)" v-text="l.num1"></td>
            <td width="35px;" v-bind:class="classFun(l.num1,l.num2,l.num3)" v-text="l.num2"></td>
            <td class="border-td" width="35px;" v-bind:class="classFun(l.num1,l.num2,l.num3)" v-text="l.num3"></td>
            <td v-bind:class="hmylfcFun(k,i)" class="line-6" v-for="(item,i) in 6" v-html="same2Html(l.same3,k,i,l.miss)"></td>
        </tr>
        <tr v-if="indexTime == 2">
            <td>
                {{dateTime}}<a style="color:deeppink;">{{resetIssue}}</a>
            </td>
            <td colspan="3">
                <div class="td-opentime">
                    剩余<a class="lg-minuteb"></a><b>:</b><a class="lg-secondb"></a>
                </div>
            </td>
            <td style="cursor: pointer;" @click="ycsame2Fun(1)"><p v-show=" xt1count == 1" class="status1-1">111</p></td>
            <td style="cursor: pointer;" @click="ycsame2Fun(2)"><p v-show=" xt1count == 2" class="status1-1">222</p></td>
            <td style="cursor: pointer;" @click="ycsame2Fun(3)"><p v-show=" xt1count == 3" class="status1-1">333</p></td>
            <td style="cursor: pointer;" @click="ycsame2Fun(4)"><p v-show=" xt1count == 4" class="status1-1">444</p></td>
            <td style="cursor: pointer;" @click="ycsame2Fun(5)"><p v-show=" xt1count == 5" class="status1-1">555</p></td>
            <td style="cursor: pointer;" @click="ycsame2Fun(6)"><p v-show=" xt1count == 6" class="status1-1">666</p></td>
        </tr>
        <tr class="tbody-yc" v-if="indexsort == 2">
            <td>
                {{dateTime}}<a style="color:deeppink;">{{parseInt(resetIssue)+1 < 100?'0'+parseInt(parseInt(resetIssue)+1):parseInt(parseInt(resetIssue)+1) >= 82?'00'+1:parseInt(parseInt(resetIssue)+1)}}</a>
            </td>
            <td colspan="3">-</td>
            <td style="cursor: pointer;" @click="ycsame2Fun1(1)"><p v-show=" xt1count1 == 1" class="status1-1">111</p></td>
            <td style="cursor: pointer;" @click="ycsame2Fun1(2)"><p v-show=" xt1count1 == 2" class="status1-1">222</p></td>
            <td style="cursor: pointer;" @click="ycsame2Fun1(3)"><p v-show=" xt1count1 == 3" class="status1-1">333</p></td>
            <td style="cursor: pointer;" @click="ycsame2Fun1(4)"><p v-show=" xt1count1 == 4" class="status1-1">444</p></td>
            <td style="cursor: pointer;" @click="ycsame2Fun1(5)"><p v-show=" xt1count1 == 5" class="status1-1">555</p></td>
            <td style="cursor: pointer;" @click="ycsame2Fun1(6)"><p v-show=" xt1count1 == 6" class="status1-1">666</p></td>
        </tr>
        <tr class="tbody-yc" v-if="indexsort == 2">
            <td>
                {{dateTime}}<a style="color:deeppink;">{{parseInt(resetIssue)+2 < 100?'0'+parseInt(parseInt(resetIssue)+2):parseInt(parseInt(resetIssue)+2) >= 82?'00'+2:parseInt(parseInt(resetIssue)+2)}}</a>
            </td>
            <td colspan="3">-</td>
            <td style="cursor: pointer;" @click="ycsame2Fun2(1)"><p v-show=" xt1count2 == 1" class="status1-1">111</p></td>
            <td style="cursor: pointer;" @click="ycsame2Fun2(2)"><p v-show=" xt1count2 == 2" class="status1-1">222</p></td>
            <td style="cursor: pointer;" @click="ycsame2Fun2(3)"><p v-show=" xt1count2 == 3" class="status1-1">333</p></td>
            <td style="cursor: pointer;" @click="ycsame2Fun2(4)"><p v-show=" xt1count2 == 4" class="status1-1">444</p></td>
            <td style="cursor: pointer;" @click="ycsame2Fun2(5)"><p v-show=" xt1count2 == 5" class="status1-1">555</p></td>
            <td style="cursor: pointer;" @click="ycsame2Fun2(6)"><p v-show=" xt1count2 == 6" class="status1-1">666</p></td>
        </tr>
        </tbody>
        <thead>
        <tr>
            <td rowspan="2" width="100px;" class="sort-img" @click="sortImg()">
                <span>期数</span>
                <span  v-bind:class="index?'sort-img-down':'sort-img-up'"></span>
            </td>
            <td rowspan="2" colspan="3" width="90px;">开奖号</td>
            <td width="100px;">111</td>
            <td width="100px;">222</td>
            <td width="100px;">333</td>
            <td width="100px;">444</td>
            <td width="100px;">555</td>
            <td width="100px;">666</td>
        </tr>
        <tr>
            <td rowspan="2" colspan="3" width="90px;">开奖号</td>
            <td colspan="6">三同号</td>
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