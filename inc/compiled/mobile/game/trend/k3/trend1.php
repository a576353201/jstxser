<div class="common-zs-table" style="position: relative;">
    <table>
        <thead>
        <tr>
            <td rowspan="2" width="100px;" class="sort-img" @click="sortImg()">
                <span>期数</span>
                <span  v-bind:class="index?'sort-img-down':'sort-img-up'"></span>
            </td>
            <td rowspan="2" colspan="3" width="90px;">开奖号</td>
            <td colspan="6">开奖号分布</td>
            <td colspan="3">形态</td>
            <td colspan="4">大数个数</td>
            <td colspan="4">单数个数</td>
            <td colspan="5">和值</td>
            <td rowspan="2">跨度</td>
        </tr>
        <tr>
            <td width="40px;">1</td>
            <td width="40px;">2</td>
            <td width="40px;">3</td>
            <td width="40px;">4</td>
            <td width="40px;">5</td>
            <td width="40px;">6</td>
            <td width="50px;">三同号</td>
            <td width="50px;">二同号</td>
            <td width="50px;">三不同</td>
            <td width="40px;">0</td>
            <td width="40px;">1</td>
            <td width="40px;">2</td>
            <td width="40px;">3</td>
            <td width="40px;">0</td>
            <td width="40px;">1</td>
            <td width="40px;">2</td>
            <td width="40px;">3</td>
            <td width="40px;">和</td>
            <td width="40px;">大</td>
            <td width="40px;">小</td>
            <td width="40px;">单</td>
            <td width="40px;">双</td>
        </tr>
        </thead>
        <tbody class="tbody-yc" v-if="indexsort == 1">
        <tr>
            <td>
                {{dateTime}}<a style="color:deeppink;">{{parseInt(resetIssue)+2 < 100?'0'+parseInt(parseInt(resetIssue)+2):parseInt(parseInt(resetIssue)+2) >= 82?'00'+2:parseInt(parseInt(resetIssue)+2)}}</a>
            </td>
            <td colspan="3">-</td>
            <td v-for="k in 6"><p style="width: 25px;height: 25px;cursor: pointer;" @click="ychmFun2(k,$event)"></p></td>
            <td style="cursor: pointer;" @click="ycxtFun2(1)"><p v-show="xt12 == 1" class="status1-3">三同号</p></td>
            <td style="cursor: pointer;" @click="ycxtFun2(2)"><p v-show="xt12 == 2" class="status1-1">二同号</p></td>
            <td style="cursor: pointer;" @click="ycxtFun2(3)"><p v-show="xt12 == 3" class="status1-2">三不号</p></td>
            <td style="cursor: pointer;" v-for="k in 4" @click="ycdFun2(k)"><p class="dscount" v-text="k-1" v-show="dcount2 == k"></p></td>
            <td style="cursor: pointer;" v-for="k in 4" @click="ycdanFun2(k)"><p class="dancount" v-text="k-1" v-show="dancount2 == k"></p></td>
            <td>-</td>
            <td style="cursor: pointer;" @click="ycdxFun2(1)"><p v-show=" dxcount2 == 1" class="big">大</p></td>
            <td style="cursor: pointer;" @click="ycdxFun2(2)"><p v-show=" dxcount2 == 2" class="small">小</p></td>
            <td style="cursor: pointer;" @click="ycdsFun2(1)"><p v-show=" dscount2 == 1" class="dan">单</p></td>
            <td style="cursor: pointer;" @click="ycdsFun2(2)"><p v-show=" dscount2 == 2" class="shuang">双</p></td>
            <td>-</td>
        </tr>
        </tbody>
        <tbody class="tbody-yc" v-if="indexsort == 1">
        <tr>
            <td>
                {{dateTime}}<a style="color:deeppink;">{{parseInt(resetIssue)+1 < 100?'0'+parseInt(parseInt(resetIssue)+1):parseInt(parseInt(resetIssue)+1) >= 82?'00'+1:parseInt(parseInt(resetIssue)+1)}}</a>
            </td>
            <td colspan="3">-</td>
            <td v-for="k in 6"><p style="width: 25px;height: 25px;cursor: pointer;" @click="ychmFun1(k,$event)"></p></td>
            <td style="cursor: pointer;" @click="ycxtFun1(1)"><p v-show="xt11 == 1" class="status1-3">三同号</p></td>
            <td style="cursor: pointer;" @click="ycxtFun1(2)"><p v-show="xt11 == 2" class="status1-1">二同号</p></td>
            <td style="cursor: pointer;" @click="ycxtFun1(3)"><p v-show="xt11 == 3" class="status1-2">三不号</p></td>
            <td style="cursor: pointer;" v-for="k in 4" @click="ycdFun1(k)"><p class="dscount" v-text="k-1" v-show="dcount1 == k"></p></td>
            <td style="cursor: pointer;" v-for="k in 4" @click="ycdanFun1(k)"><p class="dancount" v-text="k-1" v-show="dancount1 == k"></p></td>
            <td>-</td>
            <td style="cursor: pointer;" @click="ycdxFun1(1)"><p v-show=" dxcount1 == 1" class="big">大</p></td>
            <td style="cursor: pointer;" @click="ycdxFun1(2)"><p v-show=" dxcount1 == 2" class="small">小</p></td>
            <td style="cursor: pointer;" @click="ycdsFun1(1)"><p v-show=" dscount1 == 1" class="dan">单</p></td>
            <td style="cursor: pointer;" @click="ycdsFun1(2)"><p v-show=" dscount1 == 2" class="shuang">双</p></td>
            <td>-</td>
        </tr>
        </tbody>
        <tbody v-if="indexTime == 1">
        <tr>
            <td>
                {{dateTime}}<a style="color:deeppink;">{{resetIssue}}</a>
            </td>
            <td colspan="3">
                <div class="td-opentime">
                    剩余<a class="lg-minuteb"></a><b>:</b><a class="lg-secondb"></a>
                </div>
            </td>
            <td v-for="k in 6"><p style="width: 25px;height: 25px;cursor: pointer;" @click="ychmFun(k,$event)"></p></td>
            <td style="cursor: pointer;" @click="ycxtFun(1)"><p v-show="xt1 == 1" class="status1-3">三同号</p></td>
            <td style="cursor: pointer;" @click="ycxtFun(2)"><p v-show="xt1 == 2" class="status1-1">二同号</p></td>
            <td style="cursor: pointer;" @click="ycxtFun(3)"><p v-show="xt1 == 3" class="status1-2">三不号</p></td>
            <td style="cursor: pointer;" v-for="k in 4" @click="ycdFun(k)"><p class="dscount" v-text="k-1" v-show="dcount == k"></p></td>
            <td style="cursor: pointer;" v-for="k in 4" @click="ycdanFun(k)"><p class="dancount" v-text="k-1" v-show="dancount == k"></p></td>
            <td>-</td>
            <td style="cursor: pointer;" @click="ycdxFun(1)"><p v-show=" dxcount == 1" class="big">大</p></td>
            <td style="cursor: pointer;" @click="ycdxFun(2)"><p v-show=" dxcount == 2" class="small">小</p></td>
            <td style="cursor: pointer;" @click="ycdsFun(1)"><p v-show=" dscount == 1" class="dan">单</p></td>
            <td style="cursor: pointer;" @click="ycdsFun(2)"><p v-show=" dscount == 2" class="shuang">双</p></td>
            <td>-</td>
        </tr>
        </tbody>
        <tbody class="tbody-list">
        <tr v-for="(l,i) in data">
            <td class="border-td" v-html="expectFun(l.expect)"></td>
            <td width="35px;" v-bind:class="classFun(l.num1,l.num2,l.num3)" v-text="l.num1">1</td>
            <td width="35px;" v-bind:class="classFun(l.num1,l.num2,l.num3)" v-text="l.num2">2</td>
            <td class="border-td" width="35px;" v-bind:class="classFun(l.num1,l.num2,l.num3)" v-text="l.num3">3</td>
            <td class="hm-R line-6" v-bind:class="hmylfcFun(i,n)" v-for="(k,n) in 6" v-html="hmHtml(l.num1,l.num2,l.num3,k,l.miss)"></td>

            <td class="line-3" v-bind:class="hmylfcFun(i,k+6)" v-for="(item,k) in 3" v-html="xtHtml(l.status1,k,l.miss)"></td>
            <td class="line-4" v-bind:class="hmylfcFun(i,k+9)" v-for="(item,k) in 4" v-html="dCountHtml(l.big_num,k,l.miss)"></td>
            <td class="line-4" v-bind:class="hmylfcFun(i,k+13)" v-for="(item,k) in 4" v-html="danCountHtml(l.odd_num,k,l.miss)"></td>
            <td class="ylfc hz border-td" v-text="l.sum_val"></td>
            <td class="line-2" v-for="(item,k) in 2" v-bind:class="hmylfcFun(i,k+18)" v-html="dxHtml(l.sum_dx,k,l.miss)"></td>
            <td class="line-2" v-for="(item,k) in 2" v-bind:class="hmylfcFun(i,k+20)" v-html="dsHtml(l.sum_ds,k,l.miss)"></td>
            <td class="ylfc hz border-td" v-text="l.span">4</td>
        </tr>
        </tbody>
        <tbody v-if="indexTime == 2">
        <tr>
            <td>
                {{dateTime}}<a style="color:deeppink;">{{resetIssue}}</a>
            </td>
            <td colspan="3">
                <div class="td-opentime">
                    剩余<a class="lg-minuteb"></a><b>:</b><a class="lg-secondb"></a>
                </div>
            </td>
            <td v-for="k in 6"><p style="width: 25px;height: 25px;cursor: pointer;" @click="ychmFun(k,$event)"></p></td>
            <td style="cursor: pointer;" @click="ycxtFun(1)"><p v-show="xt1 == 1" class="status1-3">三同号</p></td>
            <td style="cursor: pointer;" @click="ycxtFun(2)"><p v-show="xt1 == 2" class="status1-1">二同号</p></td>
            <td style="cursor: pointer;" @click="ycxtFun(3)"><p v-show="xt1 == 3" class="status1-2">三不号</p></td>
            <td style="cursor: pointer;" v-for="k in 4" @click="ycdFun(k)"><p class="dscount" v-text="k-1" v-show="dcount == k"></p></td>
            <td style="cursor: pointer;" v-for="k in 4" @click="ycdanFun(k)"><p class="dancount" v-text="k-1" v-show="dancount == k"></p></td>
            <td>-</td>
            <td style="cursor: pointer;" @click="ycdxFun(1)"><p v-show=" dxcount == 1" class="big">大</p></td>
            <td style="cursor: pointer;" @click="ycdxFun(2)"><p v-show=" dxcount == 2" class="small">小</p></td>
            <td style="cursor: pointer;" @click="ycdsFun(1)"><p v-show=" dscount == 1" class="dan">单</p></td>
            <td style="cursor: pointer;" @click="ycdsFun(2)"><p v-show=" dscount == 2" class="shuang">双</p></td>
            <td>-</td>
        </tr>
        </tbody>
        <tbody class="tbody-yc" v-if="indexsort == 2">
        <tr>
            <td>
                {{dateTime}}<a style="color:deeppink;">{{parseInt(resetIssue)+1 < 100?'0'+parseInt(parseInt(resetIssue)+1):parseInt(parseInt(resetIssue)+1) >= 82?'00'+1:parseInt(parseInt(resetIssue)+1)}}</a>
            </td>
            <td colspan="3">-</td>
            <td v-for="k in 6"><p style="width: 25px;height: 25px;cursor: pointer;" @click="ychmFun1(k,$event)"></p></td>
            <td style="cursor: pointer;" @click="ycxtFun1(1)"><p v-show="xt11 == 1" class="status1-3">三同号</p></td>
            <td style="cursor: pointer;" @click="ycxtFun1(2)"><p v-show="xt11 == 2" class="status1-1">二同号</p></td>
            <td style="cursor: pointer;" @click="ycxtFun1(3)"><p v-show="xt11 == 3" class="status1-2">三不号</p></td>
            <td style="cursor: pointer;" v-for="k in 4" @click="ycdFun1(k)"><p class="dscount" v-text="k-1" v-show="dcount1 == k"></p></td>
            <td style="cursor: pointer;" v-for="k in 4" @click="ycdanFun1(k)"><p class="dancount" v-text="k-1" v-show="dancount1 == k"></p></td>
            <td>-</td>
            <td style="cursor: pointer;" @click="ycdxFun1(1)"><p v-show=" dxcount1 == 1" class="big">大</p></td>
            <td style="cursor: pointer;" @click="ycdxFun1(2)"><p v-show=" dxcount1 == 2" class="small">小</p></td>
            <td style="cursor: pointer;" @click="ycdsFun1(1)"><p v-show=" dscount1 == 1" class="dan">单</p></td>
            <td style="cursor: pointer;" @click="ycdsFun1(2)"><p v-show=" dscount1 == 2" class="shuang">双</p></td>
            <td>-</td>
        </tr>
        </tbody>
        <tbody class="tbody-yc" v-if="indexsort == 2">
        <tr>
            <td>
                {{dateTime}}<a style="color:deeppink;">{{parseInt(resetIssue)+2 < 100?'0'+parseInt(parseInt(resetIssue)+2):parseInt(parseInt(resetIssue)+2) >= 82?'00'+2:parseInt(parseInt(resetIssue)+2)}}</a>
            </td>
            <td colspan="3">-</td>
            <td v-for="k in 6"><p style="width: 25px;height: 25px;cursor: pointer;" @click="ychmFun2(k,$event)"></p></td>
            <td style="cursor: pointer;" @click="ycxtFun2(1)"><p v-show="xt12 == 1" class="status1-3">三同号</p></td>
            <td style="cursor: pointer;" @click="ycxtFun2(2)"><p v-show="xt12 == 2" class="status1-1">二同号</p></td>
            <td style="cursor: pointer;" @click="ycxtFun2(3)"><p v-show="xt12 == 3" class="status1-2">三不号</p></td>
            <td style="cursor: pointer;" v-for="k in 4" @click="ycdFun2(k)"><p class="dscount" v-text="k-1" v-show="dcount2 == k"></p></td>
            <td style="cursor: pointer;" v-for="k in 4" @click="ycdanFun2(k)"><p class="dancount" v-text="k-1" v-show="dancount2 == k"></p></td>
            <td>-</td>
            <td style="cursor: pointer;" @click="ycdxFun2(1)"><p v-show=" dxcount2 == 1" class="big">大</p></td>
            <td style="cursor: pointer;" @click="ycdxFun2(2)"><p v-show=" dxcount2 == 2" class="small">小</p></td>
            <td style="cursor: pointer;" @click="ycdsFun2(1)"><p v-show=" dscount2 == 1" class="dan">单</p></td>
            <td style="cursor: pointer;" @click="ycdsFun2(2)"><p v-show=" dscount2 == 2" class="shuang">双</p></td>
            <td>-</td>
        </tr>
        </tbody>
        <thead>
        <tr>
            <td rowspan="2" width="100px;" class="sort-img" @click="sortImg()">
                <span>期数</span>
                <span  v-bind:class="index?'sort-img-down':'sort-img-up'"></span>
            </td>
            <td rowspan="2" colspan="3" width="90px;">开奖号</td>
            <td width="40px;">1</td>
            <td width="40px;">2</td>
            <td width="40px;">3</td>
            <td width="40px;">4</td>
            <td width="40px;">5</td>
            <td width="40px;">6</td>
            <td width="50px;">三同号</td>
            <td width="50px;">二同号</td>
            <td width="50px;">三不同</td>
            <td width="40px;">0</td>
            <td width="40px;">1</td>
            <td width="40px;">2</td>
            <td width="40px;">3</td>
            <td width="40px;">0</td>
            <td width="40px;">1</td>
            <td width="40px;">2</td>
            <td width="40px;">3</td>
            <td width="40px;">和</td>
            <td width="40px;">大</td>
            <td width="40px;">小</td>
            <td width="40px;">单</td>
            <td width="40px;">双</td>
            <td rowspan="2">跨度</td>
        </tr>
        <tr>
            <td colspan="6">开奖号分布</td>
            <td colspan="3">形态</td>
            <td colspan="4">大数个数</td>
            <td colspan="4">单数个数</td>
            <td colspan="5">和值</td>
        </tr>
        </thead>
        <tbody id="total">
        <tr>
            <td colspan="4">出现次数</td>
            <td v-for="(l,n) in sta.times" v-text="lHtml(l,n)"></td>
        </tr>
        <tr>
            <td colspan="4">最大连出</td>
            <td v-for="(l,n) in sta.max_out" v-text="lHtml(l,n)"></td>
        </tr>
        <tr>
            <td colspan="4">最大遗漏</td>
            <td v-for="(l,n) in sta.max_miss" v-text="lHtml(l,n)"></td>
        </tr>
        <tr>
            <td colspan="4">平均遗漏</td>
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
<script>
    var pos=1;
</script>
<script type="text/javascript" src="<?php echo $HttpPath; ?>static/web/js/jsk3/jsk3-trend.js?v=c167ceaa2357dd0f98caf9a7514f1ea5"></script>