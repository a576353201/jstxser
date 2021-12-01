<style>
    .common-zs-table table tr td {min-width: 50px;height: 30px;}
</style>
            <div class="common-zs-table" style="position: relative;">
                <table>
                    <thead>
                    <tr>
                        <td rowspan="2"  class="sort-img" @click="sortImg()">
                            <span>期数</span>
                            <span  v-bind:class="index?'sort-img-down':'sort-img-up'"></span>
                        </td>
                        <td rowspan="2" >开奖号</td>
                        <td colspan="10"><?php echo $pos_num; ?>号</td>
                        <td colspan="2">前后</td>
                        <td colspan="2">单双</td>
                        <td colspan="3">升平降</td>
                    </tr>
                    <tr>
                        <td v-for="(k,i) in 10"  v-text="numArr[k-1]" v-bind:id="i == 0?'num':''"></td>
                        <td >前</td>
                        <td >后</td>
                        <td >单</td>
                        <td >双</td>
                        <td >升</td>
                        <td >平</td>
                        <td >降</td>
                    </tr>
                    </thead>
                    <tbody class="tbody-list common-tbody-total">
                    <tr class="tbody-yc" v-if="indexsort == 1">
                        <td>
                            {{dateTime}}<a style="color:deeppink;">{{parseInt(resetIssue)+2 < 100?'0'+parseInt(parseInt(resetIssue)+2):parseInt(parseInt(resetIssue)+2)}}</a>
                        </td>
                        <td>-</td>
                        <td style="cursor: pointer;" v-for="num in 10" v-on:click="tdTabNum1($event.target,num)"><p class="b0" style="position: relative;z-index: 999;width: 25px;height: 25px;display: block;margin: 0 auto;border-radius:50%;"></p></td>
                        <td style="cursor: pointer;" @click="dxFun2(1)"><p class="big" v-show="dxcount2 == 1">前</p></td>
                        <td style="cursor: pointer;" @click="dxFun2(2)"><p class="small" v-show="dxcount2 == 2">后</p></td>
                        <td style="cursor: pointer;" @click="dsFun2(1)"><p class="dan" v-show="dscount2 == 1">单</p></td>
                        <td style="cursor: pointer;" @click="dsFun2(2)"><p class="shuang" v-show="dscount2 == 2">双</p></td>
                        <td style="cursor: pointer;" @click="spjFun2(1)"><p class="zhi" v-show="spjcount2 == 1">升</p></td>
                        <td style="cursor: pointer;" @click="spjFun2(2)"><p class="he" v-show="spjcount2 == 2">平</p></td>
                        <td style="cursor: pointer;" @click="spjFun2(3)"><p class="shuang" v-show="spjcount2 == 3">降</p></td>
                    </tr>
                    <tr class="tbody-yc" v-if="indexsort == 1">
                        <td>
                            {{dateTime}}<a style="color:deeppink;">{{parseInt(resetIssue)+1 < 100?'0'+parseInt(parseInt(resetIssue)+1):parseInt(parseInt(resetIssue)+1)}}</a>
                        </td>
                        <td>-</td>
                        <td style="cursor: pointer;" v-for="num in 10" v-on:click="tdTabNum1($event.target,num)"><p class="b0" style="position: relative;z-index: 999;width: 25px;height: 25px;display: block;margin: 0 auto;border-radius:50%;"></p></td>
                        <td style="cursor: pointer;" @click="dxFun1(1)"><p class="big" v-show="dxcount1 == 1">前</p></td>
                        <td style="cursor: pointer;" @click="dxFun1(2)"><p class="small" v-show="dxcount1 == 2">后</p></td>
                        <td style="cursor: pointer;" @click="dsFun1(1)"><p class="dan" v-show="dscount1 == 1">单</p></td>
                        <td style="cursor: pointer;" @click="dsFun1(2)"><p class="shuang" v-show="dscount1 == 2">双</p></td>
                        <td style="cursor: pointer;" @click="spjFun1(1)"><p class="zhi" v-show="spjcount1 == 1">升</p></td>
                        <td style="cursor: pointer;" @click="spjFun1(2)"><p class="he" v-show="spjcount1 == 2">平</p></td>
                        <td style="cursor: pointer;" @click="spjFun1(3)"><p class="shuang" v-show="spjcount1 == 3">降</p></td>
                    </tr>
                    <tr v-if="indexTime == 1">
                        <td>
                            {{dateTime}}<a style="color:deeppink;">{{resetIssue}}</a>
                        </td>
                        <td>
                            <div class="td-opentime">
                                剩余<a class="lg-minuteb"></a><b>:</b><a class="lg-secondb"></a>
                            </div>
                        </td>
                        <td style="cursor: pointer;" v-for="num in 10" v-on:click="tdTabNum1($event.target,num)"><p class="b0" style="position: relative;z-index: 999;width: 25px;height: 25px;display: block;margin: 0 auto;border-radius:50%;"></p></td>
                        <td style="cursor: pointer;" @click="dxFun(1)"><p class="big" v-show="dxcount == 1">前</p></td>
                        <td style="cursor: pointer;" @click="dxFun(2)"><p class="small" v-show="dxcount == 2">后</p></td>
                        <td style="cursor: pointer;" @click="dsFun(1)"><p class="dan" v-show="dscount == 1">单</p></td>
                        <td style="cursor: pointer;" @click="dsFun(2)"><p class="shuang" v-show="dscount == 2">双</p></td>
                        <td style="cursor: pointer;" @click="spjFun(1)"><p class="zhi" v-show="spjcount == 1">升</p></td>
                        <td style="cursor: pointer;" @click="spjFun(2)"><p class="he" v-show="spjcount == 2">平</p></td>
                        <td style="cursor: pointer;" @click="spjFun(3)"><p class="shuang" v-show="spjcount == 3">降</p></td>
                    </tr>
                    <tr v-for="(l,i) in data">
                        <td class="border-td" v-html="expectFun(l.expect)"></td>
                        <td class="border-td border-R" v-html="numberFun(l.num,<?php echo $pos_num; ?>)"></td>
                        <td width="30px" class="line-10 b0" v-bind:class="hmylfcFun(i,k)" v-for="(item,k) in 10"  v-html="num1Html(l.car<?php echo $pos_num; ?>,k,l.miss)"></td>
                        <td class="line-2" v-bind:class="hmylfcFun(i,k+10)" v-for="(item,k) in 2" v-html="qhHtml(l.qh_<?php echo $pos_num; ?>,k,l.miss)"></td>
                        <td class="line-2" v-bind:class="hmylfcFun(i,k+12)" v-for="(item,k) in 2" v-html="dsHtml(l.ds_<?php echo $pos_num; ?>,k,l.miss)"></td>
                        <td class="line-3" v-bind:class="hmylfcFun(i,k+14)" v-for="(item,k) in 3" v-html="spjHtml(l.spj_<?php echo $pos_num; ?>,k,l.miss)"></td>

                    </tr>
                    <tr v-if="indexTime == 2">
                        <td>
                            {{dateTime}}<a style="color:deeppink;">{{resetIssue}}</a>
                        </td>
                        <td>
                            <div class="td-opentime">
                                剩余<a class="lg-minuteb"></a><b>:</b><a class="lg-secondb"></a>
                            </div>
                        </td>
                        <td style="cursor: pointer;" v-for="num in 10" v-on:click="tdTabNum1($event.target,num)"><p class="b0" style="position: relative;z-index: 999;width: 25px;height: 25px;display: block;margin: 0 auto;border-radius:50%;"></p></td>
                        <td style="cursor: pointer;" @click="dxFun(1)"><p class="big" v-show="dxcount == 1">前</p></td>
                        <td style="cursor: pointer;" @click="dxFun(2)"><p class="small" v-show="dxcount == 2">后</p></td>
                        <td style="cursor: pointer;" @click="dsFun(1)"><p class="dan" v-show="dscount == 1">单</p></td>
                        <td style="cursor: pointer;" @click="dsFun(2)"><p class="shuang" v-show="dscount == 2">双</p></td>
                        <td style="cursor: pointer;" @click="spjFun(1)"><p class="zhi" v-show="spjcount == 1">升</p></td>
                        <td style="cursor: pointer;" @click="spjFun(2)"><p class="he" v-show="spjcount == 2">平</p></td>
                        <td style="cursor: pointer;" @click="spjFun(3)"><p class="shuang" v-show="spjcount == 3">降</p></td>
                    </tr>
                    <tr class="tbody-yc" v-if="indexsort == 2">
                        <td>
                            {{dateTime}}<a style="color:deeppink;">{{parseInt(resetIssue)+1 < 100?'0'+parseInt(parseInt(resetIssue)+1):parseInt(parseInt(resetIssue)+1)}}</a>
                        </td>
                        <td>-</td>
                        <td style="cursor: pointer;" v-for="num in 10" v-on:click="tdTabNum1($event.target,num)"><p class="b0" style="position: relative;z-index: 999;width: 25px;height: 25px;display: block;margin: 0 auto;border-radius:50%;"></p></td>
                        <td style="cursor: pointer;" @click="dxFun1(1)"><p class="big" v-show="dxcount1 == 1">前</p></td>
                        <td style="cursor: pointer;" @click="dxFun1(2)"><p class="small" v-show="dxcount1 == 2">后</p></td>
                        <td style="cursor: pointer;" @click="dsFun1(1)"><p class="dan" v-show="dscount1 == 1">单</p></td>
                        <td style="cursor: pointer;" @click="dsFun1(2)"><p class="shuang" v-show="dscount1 == 2">双</p></td>
                        <td style="cursor: pointer;" @click="spjFun1(1)"><p class="zhi" v-show="spjcount1 == 1">升</p></td>
                        <td style="cursor: pointer;" @click="spjFun1(2)"><p class="he" v-show="spjcount1 == 2">平</p></td>
                        <td style="cursor: pointer;" @click="spjFun1(3)"><p class="shuang" v-show="spjcount1 == 3">降</p></td>
                    </tr>
                    <tr class="tbody-yc" v-if="indexsort == 2">
                        <td>
                            {{dateTime}}<a style="color:deeppink;">{{parseInt(resetIssue)+2 < 100?'0'+parseInt(parseInt(resetIssue)+2):parseInt(parseInt(resetIssue)+2)}}</a>
                        </td>
                        <td>-</td>
                        <td style="cursor: pointer;" v-for="num in 10" v-on:click="tdTabNum1($event.target,num)"><p class="b0" style="position: relative;z-index: 999;width: 25px;height: 25px;display: block;margin: 0 auto;border-radius:50%;"></p></td>
                        <td style="cursor: pointer;" @click="dxFun2(1)"><p class="big" v-show="dxcount2 == 1">前</p></td>
                        <td style="cursor: pointer;" @click="dxFun2(2)"><p class="small" v-show="dxcount2 == 2">后</p></td>
                        <td style="cursor: pointer;" @click="dsFun2(1)"><p class="dan" v-show="dscount2 == 1">单</p></td>
                        <td style="cursor: pointer;" @click="dsFun2(2)"><p class="shuang" v-show="dscount2 == 2">双</p></td>
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
                        <td rowspan="2">开奖号</td>
                        <td v-for="k in 10"  v-text="numArr[k-1]"></td>
                        <td >前</td>
                        <td >后</td>
                        <td >单</td>
                        <td >双</td>
                        <td >升</td>
                        <td >平</td>
                        <td >降</td>
                    </tr>
                    <tr>
                        <td colspan="10" ><?php echo $pos_num; ?>号</td>
                        <td colspan="2">前后</td>
                        <td colspan="2">单双</td>
                        <td colspan="3">升平降</td>
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
        console.log(ii,list[0][ii]);
    }


    var fields = {
        car1: ['冠','亚','三','四','五','六','七','八','九','十'],
        qh_1:['前','后'],
        ds_1:['单','双'],
        spj_1:['升','平','降']
    };

    var pos = 2;
    var from = 1;
</script>
<script type="text/javascript" src="<?php echo $HttpPath; ?>static/web/js/pk10/pk10-trend2_1.js?v=c167ceaa2357dd0f98caf9a7514f1ea5"></script>
