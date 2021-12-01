<div class="common-zs-table" style="position: relative;">
    <table>
        <thead>
        <tr>
            <td rowspan="2" width="100px;" class="sort-img" @click="sortImg()">
                <span>期数</span>
                <span  v-bind:class="index?'sort-img-down':'sort-img-up'"></span>
            </td>
            <td colspan="5" rowspan="2">开奖号</td>
            <td colspan="4">区段</td>
            <td colspan="3">升平降</td>
        </tr>
        <tr>
            <?php if($pos_type<3){?>
            <td width="60px;">
                <span>A</span>
                <span style="display: block;color: #999999;line-height: 10px;">00000-24999</span>
            </td>
            <td width="60px;">
                <span>B</span>
                <span style="display: block;color: #999999;line-height: 10px;">25000-49999</span>
            </td>
            <td width="60px;">
                <span>C</span>
                <span style="display: block;color: #999999;line-height: 10px;">50000-74999</span>
            </td>
            <td width="60px;">
                <span>D</span>
                <span style="display: block;color: #999999;line-height: 10px;">75000-99999</span>
            </td>
            <?php } else if($pos_type<=5) { ?>


            <td width="60px;">
                <span>A</span>
                <span style="display: block;color: #999999;line-height: 10px;">00-24</span>
            </td>
            <td width="60px;">
                <span>B</span>
                <span style="display: block;color: #999999;line-height: 10px;">25-49</span>
            </td>
            <td width="60px;">
                <span>C</span>
                <span style="display: block;color: #999999;line-height: 10px;">50-74</span>
            </td>
            <td width="60px;">
                <span>D</span>
                <span style="display: block;color: #999999;line-height: 10px;">75-99</span>
            </td>

            <?php } else if($pos_type<=7) { ?>
            <td width="60px;">
                <span>A</span>
                <span style="display: block;color: #999999;line-height: 10px;">000-249</span>
            </td>
            <td width="60px;">
                <span>B</span>
                <span style="display: block;color: #999999;line-height: 10px;">250-499</span>
            </td>
            <td width="60px;">
                <span>C</span>
                <span style="display: block;color: #999999;line-height: 10px;">500-749</span>
            </td>
            <td width="60px;">
                <span>D</span>
                <span style="display: block;color: #999999;line-height: 10px;">750-999</span>
            </td>
            <?php } else { ?>
            <td width="60px;">
                <span>A</span>
                <span style="display: block;color: #999999;line-height: 10px;">0000-2499</span>
            </td>
            <td width="60px;">
                <span>B</span>
                <span style="display: block;color: #999999;line-height: 10px;">2500-4999</span>
            </td>
            <td width="60px;">
                <span>C</span>
                <span style="display: block;color: #999999;line-height: 10px;">5000-7499</span>
            </td>
            <td width="60px;">
                <span>D</span>
                <span style="display: block;color: #999999;line-height: 10px;">7500-9999</span>
            </td>
            <?php }?>
            <td width="60px;">升</td>
            <td width="60px;">平</td>
            <td width="60px;">降</td>
        </tr>
        </thead>
        <tbody class="tbody-list common-tbody-total">
        <tr class="tbody-yc" v-if="indexsort == 1">
            <td>
                {{dateTime}}<a style="color:deeppink;">{{parseInt(resetIssue)+2 < 100?'0'+parseInt(parseInt(resetIssue)+2):parseInt(parseInt(resetIssue)+2) >= 120?'00'+2:parseInt(parseInt(resetIssue)+2)}}</a>
            </td>
            <td colspan="5">-</td>
            <td style="cursor: pointer;" @click="dx1Fun2(1)"><p class="status1-1" v-show="dx1count2 == 1">A</p></td>
            <td style="cursor: pointer;" @click="dx1Fun2(2)"><p class="status1-1" v-show="dx1count2 == 2">B</p></td>
            <td style="cursor: pointer;" @click="dx1Fun2(3)"><p class="status1-1" v-show="dx1count2 == 3">C</p></td>
            <td style="cursor: pointer;" @click="dx1Fun2(4)"><p class="status1-1" v-show="dx1count2 == 4">D</p></td>
            <td style="cursor: pointer;" @click="dx2Fun2(1)"><p class="big" v-show="dx2count2 == 1">升</p></td>
            <td style="cursor: pointer;" @click="dx2Fun2(2)"><p class="shuang" v-show="dx2count2 == 2">平</p></td>
            <td style="cursor: pointer;" @click="dx2Fun2(3)"><p class="dan" v-show="dx2count2 == 3">降</p></td>
        </tr>
        <tr class="tbody-yc" v-if="indexsort == 1">
            <td>
                {{dateTime}}<a style="color:deeppink;">{{parseInt(resetIssue)+1 < 100?'0'+parseInt(parseInt(resetIssue)+1):parseInt(parseInt(resetIssue)+1) >= 120?'00'+1:parseInt(parseInt(resetIssue)+1)}}</a>
            </td>
            <td colspan="5">-</td>
            <td style="cursor: pointer;" @click="dx1Fun1(1)"><p class="status1-1" v-show="dx1count1 == 1">A</p></td>
            <td style="cursor: pointer;" @click="dx1Fun1(2)"><p class="status1-1" v-show="dx1count1 == 2">B</p></td>
            <td style="cursor: pointer;" @click="dx1Fun1(3)"><p class="status1-1" v-show="dx1count1 == 3">C</p></td>
            <td style="cursor: pointer;" @click="dx1Fun1(4)"><p class="status1-1" v-show="dx1count1 == 4">D</p></td>
            <td style="cursor: pointer;" @click="dx2Fun1(1)"><p class="big" v-show="dx2count1 == 1">升</p></td>
            <td style="cursor: pointer;" @click="dx2Fun1(2)"><p class="shuang" v-show="dx2count1 == 2">平</p></td>
            <td style="cursor: pointer;" @click="dx2Fun1(3)"><p class="dan" v-show="dx2count1 == 3">降</p></td>
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
            <td style="cursor: pointer;" @click="dx1Fun(1)"><p class="status1-1" v-show="dx1count == 1">A</p></td>
            <td style="cursor: pointer;" @click="dx1Fun(2)"><p class="status1-1" v-show="dx1count == 2">B</p></td>
            <td style="cursor: pointer;" @click="dx1Fun(3)"><p class="status1-1" v-show="dx1count == 3">C</p></td>
            <td style="cursor: pointer;" @click="dx1Fun(4)"><p class="status1-1" v-show="dx1count == 4">D</p></td>
            <td style="cursor: pointer;" @click="dx2Fun(1)"><p class="big" v-show="dx2count == 1">升</p></td>
            <td style="cursor: pointer;" @click="dx2Fun(2)"><p class="shuang" v-show="dx2count == 2">平</p></td>
            <td style="cursor: pointer;" @click="dx2Fun(3)"><p class="dan" v-show="dx2count == 3">降</p></td>
        </tr>
        <tr v-for="(l,i) in data">
            <td class="border-td" v-html="expectFun(l.expect)"></td>
            <td width="25px;" v-text="l.num1" <?php if($pos_type==3 || $pos_type==5 || $pos_type==8){?>style="color: red;"<?php }?>></td>
            <td width="25px;" v-text="l.num2" <?php if($pos_type==3 || $pos_type==5 || $pos_type==6 || $pos_type==8 || $pos_type==9){?>style="color: red;"<?php }?> ></td>
            <td width="25px;" v-text="l.num3" <?php if($pos_type==5 || $pos_type==6 || $pos_type==7 || $pos_type==8 || $pos_type==9){?>style="color: red;"<?php }?> ></td>
            <td width="25px;"  v-text="l.num4" <?php if($pos_type==4 || $pos_type==6 || $pos_type==7 || $pos_type==8 || $pos_type==9){?>style="color: red;"<?php }?> ></td>
            <td class="border-td" width="25px;"  v-text="l.num5"  <?php if($pos_type==4 || $pos_type==7 || $pos_type==9){?>style="color: red;"<?php }?> ></td>
            <td class="line-4" v-bind:class="hmylfcFun(i,k)" v-for="(item,k) in 4" v-html="dx1Html(l.area,k,l.miss)"></td>
            <td class="line-3" v-bind:class="hmylfcFun(i,k+4)" v-for="(item,k) in 3" v-html="dx2Html(l.area_spj,k,l.miss)"></td>
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
            <td style="cursor: pointer;" @click="dx1Fun(1)"><p class="status1-1" v-show="dx1count == 1">A</p></td>
            <td style="cursor: pointer;" @click="dx1Fun(2)"><p class="status1-1" v-show="dx1count == 2">B</p></td>
            <td style="cursor: pointer;" @click="dx1Fun(3)"><p class="status1-1" v-show="dx1count == 3">C</p></td>
            <td style="cursor: pointer;" @click="dx1Fun(4)"><p class="status1-1" v-show="dx1count == 4">D</p></td>
            <td style="cursor: pointer;" @click="dx2Fun(1)"><p class="big" v-show="dx2count == 1">升</p></td>
            <td style="cursor: pointer;" @click="dx2Fun(2)"><p class="shuang" v-show="dx2count == 2">平</p></td>
            <td style="cursor: pointer;" @click="dx2Fun(3)"><p class="dan" v-show="dx2count == 3">降</p></td>
        </tr>
        <tr class="tbody-yc" v-if="indexsort == 2">
            <td>
                {{dateTime}}<a style="color:deeppink;">{{parseInt(resetIssue)+1 < 100?'0'+parseInt(parseInt(resetIssue)+1):parseInt(parseInt(resetIssue)+1) >= 120?'00'+1:parseInt(parseInt(resetIssue)+1)}}</a>
            </td>
            <td colspan="5">-</td>
            <td style="cursor: pointer;" @click="dx1Fun1(1)"><p class="status1-1" v-show="dx1count1 == 1">A</p></td>
            <td style="cursor: pointer;" @click="dx1Fun1(2)"><p class="status1-1" v-show="dx1count1 == 2">B</p></td>
            <td style="cursor: pointer;" @click="dx1Fun1(3)"><p class="status1-1" v-show="dx1count1 == 3">C</p></td>
            <td style="cursor: pointer;" @click="dx1Fun1(4)"><p class="status1-1" v-show="dx1count1 == 4">D</p></td>
            <td style="cursor: pointer;" @click="dx2Fun1(1)"><p class="big" v-show="dx2count1 == 1">升</p></td>
            <td style="cursor: pointer;" @click="dx2Fun1(2)"><p class="shuang" v-show="dx2count1 == 2">平</p></td>
            <td style="cursor: pointer;" @click="dx2Fun1(3)"><p class="dan" v-show="dx2count1 == 3">降</p></td>
        </tr>
        <tr class="tbody-yc" v-if="indexsort == 2">
            <td>
                {{dateTime}}<a style="color:deeppink;">{{parseInt(resetIssue)+2 < 100?'0'+parseInt(parseInt(resetIssue)+2):parseInt(parseInt(resetIssue)+2) >= 120?'00'+2:parseInt(parseInt(resetIssue)+2)}}</a>
            </td>
            <td colspan="5">-</td>
            <td style="cursor: pointer;" @click="dx1Fun2(1)"><p class="status1-1" v-show="dx1count2 == 1">A</p></td>
            <td style="cursor: pointer;" @click="dx1Fun2(2)"><p class="status1-1" v-show="dx1count2 == 2">B</p></td>
            <td style="cursor: pointer;" @click="dx1Fun2(3)"><p class="status1-1" v-show="dx1count2 == 3">C</p></td>
            <td style="cursor: pointer;" @click="dx1Fun2(4)"><p class="status1-1" v-show="dx1count2 == 4">D</p></td>
            <td style="cursor: pointer;" @click="dx2Fun2(1)"><p class="big" v-show="dx2count2 == 1">升</p></td>
            <td style="cursor: pointer;" @click="dx2Fun2(2)"><p class="shuang" v-show="dx2count2 == 2">平</p></td>
            <td style="cursor: pointer;" @click="dx2Fun2(3)"><p class="dan" v-show="dx2count2 == 3">降</p></td>
        </tr>
        </tbody>
        <thead>
        <tr>
            <td rowspan="2" width="100px;" class="sort-img" @click="sortImg()">
                <span>期数</span>
                <span  v-bind:class="index?'sort-img-down':'sort-img-up'"></span>
            </td>
            <td colspan="5" rowspan="2" width="30px;">开奖号</td>
            <?php if($pos_type<3){?>
            <td width="60px;">
                <span>A</span>
                <span style="display: block;color: #999999;line-height: 10px;">00000-24999</span>
            </td>
            <td width="60px;">
                <span>B</span>
                <span style="display: block;color: #999999;line-height: 10px;">25000-49999</span>
            </td>
            <td width="60px;">
                <span>C</span>
                <span style="display: block;color: #999999;line-height: 10px;">50000-74999</span>
            </td>
            <td width="60px;">
                <span>D</span>
                <span style="display: block;color: #999999;line-height: 10px;">75000-99999</span>
            </td>
            <?php } else if($pos_type<=5) { ?>


            <td width="60px;">
                <span>A</span>
                <span style="display: block;color: #999999;line-height: 10px;">00-24</span>
            </td>
            <td width="60px;">
                <span>B</span>
                <span style="display: block;color: #999999;line-height: 10px;">25-49</span>
            </td>
            <td width="60px;">
                <span>C</span>
                <span style="display: block;color: #999999;line-height: 10px;">50-74</span>
            </td>
            <td width="60px;">
                <span>D</span>
                <span style="display: block;color: #999999;line-height: 10px;">75-99</span>
            </td>

            <?php } else if($pos_type<=7) { ?>
            <td width="60px;">
                <span>A</span>
                <span style="display: block;color: #999999;line-height: 10px;">000-249</span>
            </td>
            <td width="60px;">
                <span>B</span>
                <span style="display: block;color: #999999;line-height: 10px;">250-499</span>
            </td>
            <td width="60px;">
                <span>C</span>
                <span style="display: block;color: #999999;line-height: 10px;">500-749</span>
            </td>
            <td width="60px;">
                <span>D</span>
                <span style="display: block;color: #999999;line-height: 10px;">750-999</span>
            </td>
            <?php } else { ?>
            <td width="60px;">
                <span>A</span>
                <span style="display: block;color: #999999;line-height: 10px;">0000-2499</span>
            </td>
            <td width="60px;">
                <span>B</span>
                <span style="display: block;color: #999999;line-height: 10px;">2500-4999</span>
            </td>
            <td width="60px;">
                <span>C</span>
                <span style="display: block;color: #999999;line-height: 10px;">5000-7499</span>
            </td>
            <td width="60px;">
                <span>D</span>
                <span style="display: block;color: #999999;line-height: 10px;">7500-9999</span>
            </td>
            <?php }?>
            <td width="60px;">升</td>
            <td width="60px;">平</td>
            <td width="60px;">降</td>
        </tr>
        <tr>
            <td colspan="4">区段</td>
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
            <td width="90px;" style="height: 72px;">年月日</td>
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
            <td width="90px;" style="height: 72px;">年月日</td>
        </tr>
        </thead>
    </table>
    <table class="table-hour" style="position: absolute;right:-151px;top:0;display: none;">
        <thead>
        <tr>
            <td width="60px;" style="height: 72px;">时分</td>
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
            <td width="60px;" style="height: 72px;">时分</td>
        </tr>
        </thead>
    </table>
</div>



<script>
    var pos = <?php echo $pos_type; ?>;


</script>
<script type="text/javascript" src="<?php echo $HttpTemplatePath; ?>51cp/static/web/js/cqssc/cqssc-trend1_13.js?v=c167ceaa2357dd0f98caf9a7514f1ea5"></script>