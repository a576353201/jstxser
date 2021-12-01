<div class="common-zs-table" style="position: relative;">
    <table>
        <thead>
        <tr>
            <td rowspan="2" width="100px;" class="sort-img" @click="sortImg()">
                <span>期数</span>
                <span  v-bind:class="index?'sort-img-down':'sort-img-up'"></span>
            </td>
            <td colspan="5" rowspan="2">开奖号</td>
            <?php if($pos_type==8){?>
            <td colspan="2">万位</td>
            <td colspan="2">千位</td>
            <td colspan="2">百位</td>
            <td colspan="2">十位</td>
            <?php } else { ?>
            <td colspan="2">千位</td>
            <td colspan="2">百位</td>
            <td colspan="2">十位</td>
            <td colspan="2">个位</td>
            <?php }?>

            <td rowspan="2">单双单选</td>
            <td colspan="5">单双比</td>
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
            <td width="35px;">4:0</td>
            <td width="35px;">3:1</td>
            <td width="35px;">2:2</td>
            <td width="35px;">1:3</td>
            <td width="35px;">0:4</td>
        </tr>
        </thead>
        <tbody class="tbody-list common-tbody-total">
        <tr class="tbody-yc" v-if="indexsort == 1">
            <td>
                {{dateTime}}<a style="color:deeppink;">{{parseInt(resetIssue)+2 < 100?'0'+parseInt(parseInt(resetIssue)+2):parseInt(parseInt(resetIssue)+2) >= 120?'00'+2:parseInt(parseInt(resetIssue)+2)}}</a>
            </td>
            <td colspan="5">-</td>
            <td style="cursor: pointer;" @click="dx1Fun2(1)"><p class="big" v-show="dx1count2 == 1">单</p></td>
            <td style="cursor: pointer;" @click="dx1Fun2(2)"><p class="small" v-show="dx1count2 == 2">双</p></td>
            <td style="cursor: pointer;" @click="dx2Fun2(1)"><p class="big" v-show="dx2count2 == 1">单</p></td>
            <td style="cursor: pointer;" @click="dx2Fun2(2)"><p class="small" v-show="dx2count2 == 2">双</p></td>
            <td style="cursor: pointer;" @click="dx3Fun2(1)"><p class="big" v-show="dx3count2 == 1">单</p></td>
            <td style="cursor: pointer;" @click="dx3Fun2(2)"><p class="small" v-show="dx3count2 == 2">双</p></td>
            <td style="cursor: pointer;" @click="dx4Fun2(1)"><p class="big" v-show="dx4count2 == 1">单</p></td>
            <td style="cursor: pointer;" @click="dx4Fun2(2)"><p class="small" v-show="dx4count2 == 2">双</p></td>
            <td>-</td>
            <td style="cursor: pointer;" v-for="k in 5" @click="dx6Fun2(k)"><p class="dancount" v-show="dx6count2 == k" v-text="dxbArr[k-1]"></p></td>
        </tr>
        <tr class="tbody-yc" v-if="indexsort == 1">
            <td>
                {{dateTime}}<a style="color:deeppink;">{{parseInt(resetIssue)+1 < 100?'0'+parseInt(parseInt(resetIssue)+1):parseInt(parseInt(resetIssue)+1) >= 120?'00'+1:parseInt(parseInt(resetIssue)+1)}}</a>
            </td>
            <td colspan="5">-</td>
            <td style="cursor: pointer;" @click="dx1Fun1(1)"><p class="big" v-show="dx1count1 == 1">单</p></td>
            <td style="cursor: pointer;" @click="dx1Fun1(2)"><p class="small" v-show="dx1count1 == 2">双</p></td>
            <td style="cursor: pointer;" @click="dx2Fun1(1)"><p class="big" v-show="dx2count1 == 1">单</p></td>
            <td style="cursor: pointer;" @click="dx2Fun1(2)"><p class="small" v-show="dx2count1 == 2">双</p></td>
            <td style="cursor: pointer;" @click="dx3Fun1(1)"><p class="big" v-show="dx3count1 == 1">单</p></td>
            <td style="cursor: pointer;" @click="dx3Fun1(2)"><p class="small" v-show="dx3count1 == 2">双</p></td>
            <td style="cursor: pointer;" @click="dx4Fun1(1)"><p class="big" v-show="dx4count1 == 1">单</p></td>
            <td style="cursor: pointer;" @click="dx4Fun1(2)"><p class="small" v-show="dx4count1 == 2">双</p></td>
            <td>-</td>
            <td style="cursor: pointer;" v-for="k in 5" @click="dx6Fun1(k)"><p class="dancount" v-show="dx6count1 == k" v-text="dxbArr[k-1]"></p></td>
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
            <td style="cursor: pointer;" @click="dx1Fun(1)"><p class="big" v-show="dx1count == 1">单</p></td>
            <td style="cursor: pointer;" @click="dx1Fun(2)"><p class="small" v-show="dx1count == 2">双</p></td>
            <td style="cursor: pointer;" @click="dx2Fun(1)"><p class="big" v-show="dx2count == 1">单</p></td>
            <td style="cursor: pointer;" @click="dx2Fun(2)"><p class="small" v-show="dx2count == 2">双</p></td>
            <td style="cursor: pointer;" @click="dx3Fun(1)"><p class="big" v-show="dx3count == 1">单</p></td>
            <td style="cursor: pointer;" @click="dx3Fun(2)"><p class="small" v-show="dx3count == 2">双</p></td>
            <td style="cursor: pointer;" @click="dx4Fun(1)"><p class="big" v-show="dx4count == 1">单</p></td>
            <td style="cursor: pointer;" @click="dx4Fun(2)"><p class="small" v-show="dx4count == 2">双</p></td>
            <td>-</td>
            <td style="cursor: pointer;" v-for="k in 5" @click="dx6Fun(k)"><p class="dancount" v-show="dx6count == k" v-text="dxbArr[k-1]"></p></td>
        </tr>
        <tr v-for="(l,i) in data">
            <td class="border-td" v-html="expectFun(l.expect)"></td>
            <td width="25px;" v-text="l.num1" <?php if($pos_type==3 || $pos_type==5 || $pos_type==8){?>style="color: red;"<?php }?>></td>
            <td width="25px;" v-text="l.num2" <?php if($pos_type==3 || $pos_type==5 || $pos_type==6 || $pos_type==8 || $pos_type==9){?>style="color: red;"<?php }?> ></td>
            <td width="25px;" v-text="l.num3" <?php if($pos_type==5 || $pos_type==6 || $pos_type==7 || $pos_type==8 || $pos_type==9){?>style="color: red;"<?php }?> ></td>
            <td width="25px;"  v-text="l.num4" <?php if($pos_type==4 || $pos_type==6 || $pos_type==7 || $pos_type==8 || $pos_type==9){?>style="color: red;"<?php }?> ></td>
            <td class="border-td" width="25px;"  v-text="l.num5"  <?php if($pos_type==4 || $pos_type==7 || $pos_type==9){?>style="color: red;"<?php }?> ></td>

            <td class="line-2" v-bind:class="hmylfcFun(i,k)" v-for="(item,k) in 2" v-html="dx1Html(l.num1ds,k,l.miss)"></td>
            <td class="line-2" v-bind:class="hmylfcFun(i,k+2)" v-for="(item,k) in 2" v-html="dx2Html(l.num2ds,k,l.miss)"></td>
            <td class="line-2" v-bind:class="hmylfcFun(i,k+4)" v-for="(item,k) in 2" v-html="dx3Html(l.num3ds,k,l.miss)"></td>
            <td class="line-2" v-bind:class="hmylfcFun(i,k+6)" v-for="(item,k) in 2" v-html="dx4Html(l.num4ds,k,l.miss)"></td>
            <td class="border-td" v-html="fontColorFun(l.ds)"></td>
            <td class="line-4" v-bind:class="hmylfcFun(i,k+9)" v-for="(item,k) in 5" v-html="dxbHtml(l.ds_p,k,l.miss)"></td>
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
            <td style="cursor: pointer;" @click="dx1Fun(1)"><p class="big" v-show="dx1count == 1">单</p></td>
            <td style="cursor: pointer;" @click="dx1Fun(2)"><p class="small" v-show="dx1count == 2">双</p></td>
            <td style="cursor: pointer;" @click="dx2Fun(1)"><p class="big" v-show="dx2count == 1">单</p></td>
            <td style="cursor: pointer;" @click="dx2Fun(2)"><p class="small" v-show="dx2count == 2">双</p></td>
            <td style="cursor: pointer;" @click="dx3Fun(1)"><p class="big" v-show="dx3count == 1">单</p></td>
            <td style="cursor: pointer;" @click="dx3Fun(2)"><p class="small" v-show="dx3count == 2">双</p></td>
            <td style="cursor: pointer;" @click="dx4Fun(1)"><p class="big" v-show="dx4count == 1">单</p></td>
            <td style="cursor: pointer;" @click="dx4Fun(2)"><p class="small" v-show="dx4count == 2">双</p></td>
            <td>-</td>
            <td style="cursor: pointer;" v-for="k in 5" @click="dx6Fun(k)"><p class="dancount" v-show="dx6count == k" v-text="dxbArr[k-1]"></p></td>
        </tr>
        <tr class="tbody-yc" v-if="indexsort == 2">
            <td>
                {{dateTime}}<a style="color:deeppink;">{{parseInt(resetIssue)+1 < 100?'0'+parseInt(parseInt(resetIssue)+1):parseInt(parseInt(resetIssue)+1) >= 120?'00'+1:parseInt(parseInt(resetIssue)+1)}}</a>
            </td>
            <td colspan="5">-</td>
            <td style="cursor: pointer;" @click="dx1Fun1(1)"><p class="big" v-show="dx1count1 == 1">单</p></td>
            <td style="cursor: pointer;" @click="dx1Fun1(2)"><p class="small" v-show="dx1count1 == 2">双</p></td>
            <td style="cursor: pointer;" @click="dx2Fun1(1)"><p class="big" v-show="dx2count1 == 1">单</p></td>
            <td style="cursor: pointer;" @click="dx2Fun1(2)"><p class="small" v-show="dx2count1 == 2">双</p></td>
            <td style="cursor: pointer;" @click="dx3Fun1(1)"><p class="big" v-show="dx3count1 == 1">单</p></td>
            <td style="cursor: pointer;" @click="dx3Fun1(2)"><p class="small" v-show="dx3count1 == 2">双</p></td>
            <td style="cursor: pointer;" @click="dx4Fun1(1)"><p class="big" v-show="dx4count1 == 1">单</p></td>
            <td style="cursor: pointer;" @click="dx4Fun1(2)"><p class="small" v-show="dx4count1 == 2">双</p></td>
            <td>-</td>
            <td style="cursor: pointer;" v-for="k in 5" @click="dx6Fun1(k)"><p class="dancount" v-show="dx6count1 == k" v-text="dxbArr[k-1]"></p></td>
        </tr>
        <tr class="tbody-yc" v-if="indexsort == 2">
            <td>
                {{dateTime}}<a style="color:deeppink;">{{parseInt(resetIssue)+2 < 100?'0'+parseInt(parseInt(resetIssue)+2):parseInt(parseInt(resetIssue)+2) >= 120?'00'+2:parseInt(parseInt(resetIssue)+2)}}</a>
            </td>
            <td colspan="5">-</td>
            <td style="cursor: pointer;" @click="dx1Fun2(1)"><p class="big" v-show="dx1count2 == 1">单</p></td>
            <td style="cursor: pointer;" @click="dx1Fun2(2)"><p class="small" v-show="dx1count2 == 2">双</p></td>
            <td style="cursor: pointer;" @click="dx2Fun2(1)"><p class="big" v-show="dx2count2 == 1">单</p></td>
            <td style="cursor: pointer;" @click="dx2Fun2(2)"><p class="small" v-show="dx2count2 == 2">双</p></td>
            <td style="cursor: pointer;" @click="dx3Fun2(1)"><p class="big" v-show="dx3count2 == 1">单</p></td>
            <td style="cursor: pointer;" @click="dx3Fun2(2)"><p class="small" v-show="dx3count2 == 2">双</p></td>
            <td style="cursor: pointer;" @click="dx4Fun2(1)"><p class="big" v-show="dx4count2 == 1">单</p></td>
            <td style="cursor: pointer;" @click="dx4Fun2(2)"><p class="small" v-show="dx4count2 == 2">双</p></td>
            <td>-</td>
            <td style="cursor: pointer;" v-for="k in 5" @click="dx6Fun2(k)"><p class="dancount" v-show="dx6count2 == k" v-text="dxbArr[k-1]"></p></td>
        </tr>
        </tbody>
        <thead>
        <tr>
            <td rowspan="2" width="100px;" class="sort-img" @click="sortImg()">
                <span>期数</span>
                <span  v-bind:class="index?'sort-img-down':'sort-img-up'"></span>
            </td>
            <td colspan="5" rowspan="2" width="30px;">开奖号</td>
            <td width="30px;">单</td>
            <td width="30px;">双</td>
            <td width="30px;">单</td>
            <td width="30px;">双</td>
            <td width="30px;">单</td>
            <td width="30px;">双</td>
            <td width="30px;">单</td>
            <td width="30px;">双</td>
            <td rowspan="2">单双单选</td>
            <td width="35px;">4:0</td>
            <td width="35px;">3:1</td>
            <td width="35px;">2:2</td>
            <td width="35px;">1:3</td>
            <td width="35px;">0:4</td>
        </tr>
        <tr>
            <?php if($pos_type==8){?>
            <td colspan="2">万位</td>
            <td colspan="2">千位</td>
            <td colspan="2">百位</td>
            <td colspan="2">十位</td>
            <?php } else { ?>
            <td colspan="2">千位</td>
            <td colspan="2">百位</td>
            <td colspan="2">十位</td>
            <td colspan="2">个位</td>
            <?php }?>

            <td colspan="5">单双比</td>
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

<script>

    var fields = {
        num1ds:['单','双'],
        num2ds:['单','双'],
        num3ds:['单','双'],
        num4ds:['单','双'],
        ds:[0],
        ds_p:['4:0','3:1','2:2','1:3','0:4']
    };


    var obj = {
        arr:['单','双'],
        arrdx:fields.ds,
        arrdxb:fields.ds_p
    }


    var pos=<?php echo $pos_type; ?>;

</script>
<script type="text/javascript" src="<?php echo $HttpTemplatePath; ?>51cp/static/web/js/cqssc/cqssc-trend8_5.js?v=c167ceaa2357dd0f98caf9a7514f1ea5"></script>