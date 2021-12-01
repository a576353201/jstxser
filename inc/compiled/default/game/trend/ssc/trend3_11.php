<div class="common-zs-table" style="position: relative;">
    <table>
        <thead>
        <tr>
            <td rowspan="2" width="100px;" class="sort-img" @click="sortImg()">
                <span>期数</span>
                <span  v-bind:class="index?'sort-img-down':'sort-img-up'"></span>
            </td>
            <td colspan="5" rowspan="2">开奖号</td>
            <td rowspan="2" width="80px;">重号号码</td>
            <td colspan="6">重号个数</td>
            <td colspan="2">大小</td>
            <td colspan="2">单双</td>
            <td colspan="3">012</td>
            <td colspan="3">升平降</td>
        </tr>
        <tr>
            <td v-for="k in 6" width="30px;" v-text="k-1" v-bind:id="k == 1?'num':''"></td>
            <td width="30px;">大</td>
            <td width="30px;">小</td>
            <td width="30px;">单</td>
            <td width="30px;">双</td>
            <td width="30px;">0</td>
            <td width="30px;">1</td>
            <td width="30px;">2</td>
            <td width="30px;">升</td>
            <td width="30px;">平</td>
            <td width="30px;">降</td>
        </tr>
        </thead>
        <tbody class="tbody-list common-tbody-total">
        <tr class="tbody-yc" v-if="indexsort == 1">
            <td>
                {{dateTime}}<a style="color:deeppink;">{{parseInt(resetIssue)+2 < 100?'0'+parseInt(parseInt(resetIssue)+2):parseInt(parseInt(resetIssue)+2) >= 120?'00'+2:parseInt(parseInt(resetIssue)+2)}}</a>
            </td>
            <td colspan="5">-</td>
            <td>-</td>
            <td style="cursor: pointer;" v-for="num in 6" v-on:click="tdTabNum1($event.target,num-1)"><p class="b0" style="position: relative;z-index: 999;width: 25px;height: 25px;display: block;margin: 0 auto;border-radius:50%;"></p></td>
            <td style="cursor: pointer;" @click="dxFun2(1)"><p class="big" v-show="dxcount2 == 1">大</p></td>
            <td style="cursor: pointer;" @click="dxFun2(2)"><p class="small" v-show="dxcount2 == 2">小</p></td>
            <td style="cursor: pointer;" @click="dsFun2(1)"><p class="dan" v-show="dscount2 == 1">单</p></td>
            <td style="cursor: pointer;" @click="dsFun2(2)"><p class="shuang" v-show="dscount2 == 2">双</p></td>
            <td style="cursor: pointer;" @click="luFun2(1)"><p class="big" v-show="lucount2 == 1">0</p></td>
            <td style="cursor: pointer;" @click="luFun2(2)"><p class="small" v-show="lucount2 == 2">1</p></td>
            <td style="cursor: pointer;" @click="luFun2(3)"><p class="dan" v-show="lucount2 == 3">2</p></td>
            <td style="cursor: pointer;" @click="spjFun2(1)"><p class="zhi" v-show="spjcount2 == 1">升</p></td>
            <td style="cursor: pointer;" @click="spjFun2(2)"><p class="he" v-show="spjcount2 == 2">平</p></td>
            <td style="cursor: pointer;" @click="spjFun2(3)"><p class="shuang" v-show="spjcount2 == 3">降</p></td>
        </tr>
        <tr class="tbody-yc" v-if="indexsort == 1">
            <td>
                {{dateTime}}<a style="color:deeppink;">{{parseInt(resetIssue)+1 < 100?'0'+parseInt(parseInt(resetIssue)+1):parseInt(parseInt(resetIssue)+1) >= 120?'00'+1:parseInt(parseInt(resetIssue)+1)}}</a>
            </td>
            <td colspan="5">-</td>
            <td>-</td>
            <td style="cursor: pointer;" v-for="num in 6" v-on:click="tdTabNum1($event.target,num-1)"><p class="b0" style="position: relative;z-index: 999;width: 25px;height: 25px;display: block;margin: 0 auto;border-radius:50%;"></p></td>
            <td style="cursor: pointer;" @click="dxFun1(1)"><p class="big" v-show="dxcount1 == 1">大</p></td>
            <td style="cursor: pointer;" @click="dxFun1(2)"><p class="small" v-show="dxcount1 == 2">小</p></td>
            <td style="cursor: pointer;" @click="dsFun1(1)"><p class="dan" v-show="dscount1 == 1">单</p></td>
            <td style="cursor: pointer;" @click="dsFun1(2)"><p class="shuang" v-show="dscount1 == 2">双</p></td>
            <td style="cursor: pointer;" @click="luFun1(1)"><p class="big" v-show="lucount1 == 1">0</p></td>
            <td style="cursor: pointer;" @click="luFun1(2)"><p class="small" v-show="lucount1 == 2">1</p></td>
            <td style="cursor: pointer;" @click="luFun1(3)"><p class="dan" v-show="lucount1 == 3">2</p></td>
            <td style="cursor: pointer;" @click="spjFun1(1)"><p class="zhi" v-show="spjcount1 == 1">升</p></td>
            <td style="cursor: pointer;" @click="spjFun1(2)"><p class="he" v-show="spjcount1 == 2">平</p></td>
            <td style="cursor: pointer;" @click="spjFun1(3)"><p class="shuang" v-show="spjcount1 == 3">降</p></td>
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
            <td>-</td>
            <td style="cursor: pointer;" v-for="num in 6" v-on:click="tdTabNum1($event.target,num-1)"><p class="b0" style="position: relative;z-index: 999;width: 25px;height: 25px;display: block;margin: 0 auto;border-radius:50%;"></p></td>
            <td style="cursor: pointer;" @click="dxFun(1)"><p class="big" v-show="dxcount == 1">大</p></td>
            <td style="cursor: pointer;" @click="dxFun(2)"><p class="small" v-show="dxcount == 2">小</p></td>
            <td style="cursor: pointer;" @click="dsFun(1)"><p class="dan" v-show="dscount == 1">单</p></td>
            <td style="cursor: pointer;" @click="dsFun(2)"><p class="shuang" v-show="dscount == 2">双</p></td>
            <td style="cursor: pointer;" @click="luFun(1)"><p class="big" v-show="lucount == 1">0</p></td>
            <td style="cursor: pointer;" @click="luFun(2)"><p class="small" v-show="lucount == 2">1</p></td>
            <td style="cursor: pointer;" @click="luFun(3)"><p class="dan" v-show="lucount == 3">2</p></td>
            <td style="cursor: pointer;" @click="spjFun(1)"><p class="zhi" v-show="spjcount == 1">升</p></td>
            <td style="cursor: pointer;" @click="spjFun(2)"><p class="he" v-show="spjcount == 2">平</p></td>
            <td style="cursor: pointer;" @click="spjFun(3)"><p class="shuang" v-show="spjcount == 3">降</p></td>
        </tr>
        <tr v-for="(l,i) in data">
            <td class="border-td" v-html="expectFun(l.expect)"></td>
            <td width="25px;" v-text="l.num1" <?php if($pos_type==3 || $pos_type==5 || $pos_type==8){?>style="color: red;"<?php }?>></td>
            <td width="25px;" v-text="l.num2" <?php if($pos_type==3 || $pos_type==5 || $pos_type==6 || $pos_type==8 || $pos_type==9){?>style="color: red;"<?php }?> ></td>
            <td width="25px;" v-text="l.num3" <?php if($pos_type==5 || $pos_type==6 || $pos_type==7 || $pos_type==8 || $pos_type==9){?>style="color: red;"<?php }?> ></td>
            <td width="25px;"  v-text="l.num4" <?php if($pos_type==4 || $pos_type==6 || $pos_type==7 || $pos_type==8 || $pos_type==9){?>style="color: red;"<?php }?> ></td>
            <td class="border-td" width="25px;"  v-text="l.num5"  <?php if($pos_type==4 || $pos_type==7 || $pos_type==9){?>style="color: red;"<?php }?> ></td>
            <td class="border-td" v-text="l.repeat"></td>
            <td width="30px" class="line-6 b0" v-bind:class="hmylfcFun(i,k+1)" v-for="(item,k) in 6"  v-html="num1Html(l.repeat_num,k,l.miss)"></td>
            <td class="line-2" v-bind:class="hmylfcFun(i,k+7)" v-for="(item,k) in 2" v-html="dxHtml(l.repeat_dx,k,l.miss)"></td>
            <td class="line-2" v-bind:class="hmylfcFun(i,k+9)" v-for="(item,k) in 2" v-html="dsHtml(l.repeat_ds,k,l.miss)"></td>
            <td class="line-3" v-bind:class="hmylfcFun(i,k+11)" v-for="(item,k) in 3" v-html="luHtml(l.repeat_012,k,l.miss)"></td>
            <td class="line-3" v-bind:class="hmylfcFun(i,k+14)" v-for="(item,k) in 3" v-html="spjHtml(l.repeat_spj,k,l.miss)"></td>
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
            <td>-</td>
            <td style="cursor: pointer;" v-for="num in 6" v-on:click="tdTabNum1($event.target,num-1)"><p class="b0" style="position: relative;z-index: 999;width: 25px;height: 25px;display: block;margin: 0 auto;border-radius:50%;"></p></td>
            <td style="cursor: pointer;" @click="dxFun(1)"><p class="big" v-show="dxcount == 1">大</p></td>
            <td style="cursor: pointer;" @click="dxFun(2)"><p class="small" v-show="dxcount == 2">小</p></td>
            <td style="cursor: pointer;" @click="dsFun(1)"><p class="dan" v-show="dscount == 1">单</p></td>
            <td style="cursor: pointer;" @click="dsFun(2)"><p class="shuang" v-show="dscount == 2">双</p></td>
            <td style="cursor: pointer;" @click="luFun(1)"><p class="big" v-show="lucount == 1">0</p></td>
            <td style="cursor: pointer;" @click="luFun(2)"><p class="small" v-show="lucount == 2">1</p></td>
            <td style="cursor: pointer;" @click="luFun(3)"><p class="dan" v-show="lucount == 3">2</p></td>
            <td style="cursor: pointer;" @click="spjFun(1)"><p class="zhi" v-show="spjcount == 1">升</p></td>
            <td style="cursor: pointer;" @click="spjFun(2)"><p class="he" v-show="spjcount == 2">平</p></td>
            <td style="cursor: pointer;" @click="spjFun(3)"><p class="shuang" v-show="spjcount == 3">降</p></td>
        </tr>
        <tr class="tbody-yc" v-if="indexsort == 2">
            <td>
                {{dateTime}}<a style="color:deeppink;">{{parseInt(resetIssue)+1 < 100?'0'+parseInt(parseInt(resetIssue)+1):parseInt(parseInt(resetIssue)+1) >= 120?'00'+1:parseInt(parseInt(resetIssue)+1)}}</a>
            </td>
            <td colspan="5">-</td>
            <td>-</td>
            <td style="cursor: pointer;" v-for="num in 6" v-on:click="tdTabNum1($event.target,num-1)"><p class="b0" style="position: relative;z-index: 999;width: 25px;height: 25px;display: block;margin: 0 auto;border-radius:50%;"></p></td>
            <td style="cursor: pointer;" @click="dxFun1(1)"><p class="big" v-show="dxcount1 == 1">大</p></td>
            <td style="cursor: pointer;" @click="dxFun1(2)"><p class="small" v-show="dxcount1 == 2">小</p></td>
            <td style="cursor: pointer;" @click="dsFun1(1)"><p class="dan" v-show="dscount1 == 1">单</p></td>
            <td style="cursor: pointer;" @click="dsFun1(2)"><p class="shuang" v-show="dscount1 == 2">双</p></td>
            <td style="cursor: pointer;" @click="luFun1(1)"><p class="big" v-show="lucount1 == 1">0</p></td>
            <td style="cursor: pointer;" @click="luFun1(2)"><p class="small" v-show="lucount1 == 2">1</p></td>
            <td style="cursor: pointer;" @click="luFun1(3)"><p class="dan" v-show="lucount1 == 3">2</p></td>
            <td style="cursor: pointer;" @click="spjFun1(1)"><p class="zhi" v-show="spjcount1 == 1">升</p></td>
            <td style="cursor: pointer;" @click="spjFun1(2)"><p class="he" v-show="spjcount1 == 2">平</p></td>
            <td style="cursor: pointer;" @click="spjFun1(3)"><p class="shuang" v-show="spjcount1 == 3">降</p></td>
        </tr>
        <tr class="tbody-yc" v-if="indexsort == 2">
            <td>
                {{dateTime}}<a style="color:deeppink;">{{parseInt(resetIssue)+2 < 100?'0'+parseInt(parseInt(resetIssue)+2):parseInt(parseInt(resetIssue)+2) >= 120?'00'+2:parseInt(parseInt(resetIssue)+2)}}</a>
            </td>
            <td colspan="5">-</td>
            <td>-</td>
            <td style="cursor: pointer;" v-for="num in 6" v-on:click="tdTabNum1($event.target,num-1)"><p class="b0" style="position: relative;z-index: 999;width: 25px;height: 25px;display: block;margin: 0 auto;border-radius:50%;"></p></td>
            <td style="cursor: pointer;" @click="dxFun2(1)"><p class="big" v-show="dxcount2 == 1">大</p></td>
            <td style="cursor: pointer;" @click="dxFun2(2)"><p class="small" v-show="dxcount2 == 2">小</p></td>
            <td style="cursor: pointer;" @click="dsFun2(1)"><p class="dan" v-show="dscount2 == 1">单</p></td>
            <td style="cursor: pointer;" @click="dsFun2(2)"><p class="shuang" v-show="dscount2 == 2">双</p></td>
            <td style="cursor: pointer;" @click="luFun2(1)"><p class="big" v-show="lucount2 == 1">0</p></td>
            <td style="cursor: pointer;" @click="luFun2(2)"><p class="small" v-show="lucount2 == 2">1</p></td>
            <td style="cursor: pointer;" @click="luFun2(3)"><p class="dan" v-show="lucount2 == 3">2</p></td>
            <td style="cursor: pointer;" @click="spjFun2(1)"><p class="zhi" v-show="spjcount2 == 1">升</p></td>
            <td style="cursor: pointer;" @click="spjFun2(2)"><p class="he" v-show="spjcount2 == 2">平</p></td>
            <td style="cursor: pointer;" @click="spjFun2(3)"><p class="shuang" v-show="spjcount2 == 3">降</p></td>
        </tr>
        </tbody>
        <thead>
        <tr>
            <td rowspan="2" width="100px;" class="sort-img" @click="sortImg()">
                <span>期数</span>
                <span  v-bind:class="index?'sort-img-down':'sort-img-up'"></span>
            </td>
            <td colspan="5" rowspan="2" width="30px;">开奖号</td>
            <td rowspan="2" width="80px;">重号号码</td>
            <td v-for="k in 6" width="30px;" v-text="k-1"></td>
            <td width="30px;">大</td>
            <td width="30px;">小</td>
            <td width="30px;">单</td>
            <td width="30px;">双</td>
            <td width="30px;">0</td>
            <td width="30px;">1</td>
            <td width="30px;">2</td>
            <td width="30px;">升</td>
            <td width="30px;">平</td>
            <td width="30px;">降</td>
        </tr>
        <tr>
            <td colspan="6" width="30px;">重号个数</td>
            <td colspan="2">大小</td>
            <td colspan="2">单双</td>
            <td colspan="3">012</td>
            <td colspan="3">升平降</td>
        </tr>
        </thead>
        <tbody id="total">
        <tr>
            <td colspan="6">出现次数</td>
            <td width="30px;" v-for="(l,n) in sta.times" v-text="lHtml(l,n)"></td>
        </tr>
        <tr>
            <td colspan="6">最大连出</td>
            <td width="30px;" v-for="(l,n) in sta.max_out" v-text="lHtml(l,n)"></td>
        </tr>
        <tr>
            <td colspan="6">最大遗漏</td>
            <td width="30px;" v-for="(l,n) in sta.max_miss" v-text="lHtml(l,n)"></td>
        </tr>
        <tr>
            <td colspan="6">平均遗漏</td>
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


    var fields = {
        repeat:[0],
        repeat_num: [0,1,2,3,4,5],
        repeat_dx:['大','小'],
        repeat_ds:['单','双'],
        repeat_012:[0,1,2],
        repeat_spj:['升','平','降']
    };

    var pos = <?php echo $pos_type; ?>;

</script>
<script type="text/javascript" src="<?php echo $HttpTemplatePath; ?>51cp/static/web/js/cqssc/cqssc-trend1_10.js?v=c167ceaa2357dd0f98caf9a7514f1ea5"></script>