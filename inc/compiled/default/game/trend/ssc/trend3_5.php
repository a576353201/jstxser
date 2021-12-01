<div class="common-zs-table" style="position: relative;">
    <table>
        <thead>
        <tr>
            <td rowspan="2" width="100px;" class="sort-img" @click="sortImg()">
                <span>期数</span>
                <span  v-bind:class="index?'sort-img-down':'sort-img-up'"></span>
            </td>
            <td colspan="5" rowspan="2">开奖号</td>
            <?php if($pos_type==3){?>
            <td colspan="2">万位</td>
            <td colspan="2">千位</td>
            <?php } else { ?>
            <td colspan="2">十位</td>
            <td colspan="2">个位</td>
            <?php }?>

            <td colspan="4">大小单选</td>
            <td colspan="3">大小比</td>
        </tr>
        <tr>
            <td width="30px;">大</td>
            <td width="30px;">小</td>
            <td width="30px;">大</td>
            <td width="30px;">小</td>
            <td width="30px;">大大</td>
            <td width="30px;">大小</td>
            <td width="30px;">小大</td>
            <td width="30px;">小小</td>
            <td width="35px;">2:0</td>
            <td width="35px;">1:1</td>
            <td width="35px;">0:2</td>
        </tr>
        </thead>
        <tbody class="tbody-list common-tbody-total">
        <tr class="tbody-yc" v-if="indexsort == 1">
            <td>
                {{dateTime}}<a style="color:deeppink;">{{parseInt(resetIssue)+2 < 100?'0'+parseInt(parseInt(resetIssue)+2):parseInt(parseInt(resetIssue)+2) >= 120?'00'+2:parseInt(parseInt(resetIssue)+2)}}</a>
            </td>
            <td colspan="5">-</td>
            <td style="cursor: pointer;" @click="dx1Fun2(1)"><p class="big" v-show="dx1count2 == 1">大</p></td>
            <td style="cursor: pointer;" @click="dx1Fun2(2)"><p class="small" v-show="dx1count2 == 2">小</p></td>
            <td style="cursor: pointer;" @click="dx2Fun2(1)"><p class="big" v-show="dx2count2 == 1">大</p></td>
            <td style="cursor: pointer;" @click="dx2Fun2(2)"><p class="small" v-show="dx2count2 == 2">小</p></td>
            <td style="cursor: pointer;" @click="dx3Fun2(1)"><p class="dan" v-show="dx3count2 == 1">大大</p></td>
            <td style="cursor: pointer;" @click="dx3Fun2(2)"><p class="dan" v-show="dx3count2 == 2">大小</p></td>
            <td style="cursor: pointer;" @click="dx3Fun2(3)"><p class="dan" v-show="dx3count2 == 3">小大</p></td>
            <td style="cursor: pointer;" @click="dx3Fun2(4)"><p class="dan" v-show="dx3count2 == 4">小小</p></td>
            <td style="cursor: pointer;" @click="dxbFun2(1)"><p class="dancount" v-show="dancount2 == 1">2:0</p></td>
            <td style="cursor: pointer;" @click="dxbFun2(2)"><p class="dancount" v-show="dancount2 == 2">1:1</p></td>
            <td style="cursor: pointer;" @click="dxbFun2(3)"><p class="dancount" v-show="dancount2 == 3">0:2</p></td>
        </tr>
        <tr class="tbody-yc" v-if="indexsort == 1">
            <td>
                {{dateTime}}<a style="color:deeppink;">{{parseInt(resetIssue)+1 < 100?'0'+parseInt(parseInt(resetIssue)+1):parseInt(parseInt(resetIssue)+1) >= 120?'00'+1:parseInt(parseInt(resetIssue)+1)}}</a>
            </td>
            <td colspan="5">-</td>
            <td style="cursor: pointer;" @click="dx1Fun1(1)"><p class="big" v-show="dx1count1 == 1">大</p></td>
            <td style="cursor: pointer;" @click="dx1Fun1(2)"><p class="small" v-show="dx1count1 == 2">小</p></td>
            <td style="cursor: pointer;" @click="dx2Fun1(1)"><p class="big" v-show="dx2count1 == 1">大</p></td>
            <td style="cursor: pointer;" @click="dx2Fun1(2)"><p class="small" v-show="dx2count1 == 2">小</p></td>
            <td style="cursor: pointer;" @click="dx3Fun1(1)"><p class="dan" v-show="dx3count1 == 1">大大</p></td>
            <td style="cursor: pointer;" @click="dx3Fun1(2)"><p class="dan" v-show="dx3count1 == 2">大小</p></td>
            <td style="cursor: pointer;" @click="dx3Fun1(3)"><p class="dan" v-show="dx3count1 == 3">小大</p></td>
            <td style="cursor: pointer;" @click="dx3Fun1(4)"><p class="dan" v-show="dx3count1 == 4">小小</p></td>
            <td style="cursor: pointer;" @click="dxbFun1(1)"><p class="dancount" v-show="dancount1 == 1">2:0</p></td>
            <td style="cursor: pointer;" @click="dxbFun1(2)"><p class="dancount" v-show="dancount1 == 2">1:1</p></td>
            <td style="cursor: pointer;" @click="dxbFun1(3)"><p class="dancount" v-show="dancount1 == 3">0:2</p></td>
        </tr>
        <tr class="tbody-yc" v-if="indexTime == 1">
            <td>
                {{dateTime}}<a style="color:deeppink;">{{resetIssue}}</a>
            </td>
            <td colspan="5">
                <div class="td-opentime">
                    剩余<a class="lg-minuteb"></a><b>:</b><a class="lg-secondb"></a>
                </div>
            </td>
            <td style="cursor: pointer;" @click="dx1Fun(1)"><p class="big" v-show="dx1count == 1">大</p></td>
            <td style="cursor: pointer;" @click="dx1Fun(2)"><p class="small" v-show="dx1count == 2">小</p></td>
            <td style="cursor: pointer;" @click="dx2Fun(1)"><p class="big" v-show="dx2count == 1">大</p></td>
            <td style="cursor: pointer;" @click="dx2Fun(2)"><p class="small" v-show="dx2count == 2">小</p></td>
            <td style="cursor: pointer;" @click="dx3Fun(1)"><p class="dan" v-show="dx3count == 1">大大</p></td>
            <td style="cursor: pointer;" @click="dx3Fun(2)"><p class="dan" v-show="dx3count == 2">大小</p></td>
            <td style="cursor: pointer;" @click="dx3Fun(3)"><p class="dan" v-show="dx3count == 3">小大</p></td>
            <td style="cursor: pointer;" @click="dx3Fun(4)"><p class="dan" v-show="dx3count == 4">小小</p></td>
            <td style="cursor: pointer;" @click="dxbFun(1)"><p class="dancount" v-show="dancount == 1">2:0</p></td>
            <td style="cursor: pointer;" @click="dxbFun(2)"><p class="dancount" v-show="dancount == 2">1:1</p></td>
            <td style="cursor: pointer;" @click="dxbFun(3)"><p class="dancount" v-show="dancount == 3">0:2</p></td>
        </tr>
        <tr v-for="(l,i) in data">
            <td class="border-td" v-html="expectFun(l.expect)"></td>
            <td width="25px;" v-text="l.num1" <?php if($pos_type==3 || $pos_type==5 || $pos_type==8){?>style="color: red;"<?php }?>></td>
            <td width="25px;" v-text="l.num2" <?php if($pos_type==3 || $pos_type==5 || $pos_type==6 || $pos_type==8 || $pos_type==9){?>style="color: red;"<?php }?> ></td>
            <td width="25px;" v-text="l.num3" <?php if($pos_type==5 || $pos_type==6 || $pos_type==7 || $pos_type==8 || $pos_type==9){?>style="color: red;"<?php }?> ></td>
            <td width="25px;"  v-text="l.num4" <?php if($pos_type==4 || $pos_type==6 || $pos_type==7 || $pos_type==8 || $pos_type==9){?>style="color: red;"<?php }?> ></td>
            <td class="border-td" width="25px;"  v-text="l.num5"  <?php if($pos_type==4 || $pos_type==7 || $pos_type==9){?>style="color: red;"<?php }?> ></td>

            <td class="line-2" v-bind:class="hmylfcFun(i,k)" v-for="(item,k) in 2" v-html="dx1Html(l.num1dx,k,l.miss)"></td>
            <td class="line-2" v-bind:class="hmylfcFun(i,k+2)" v-for="(item,k) in 2" v-html="dx2Html(l.num2dx,k,l.miss)"></td>



            <td class="line-4" v-bind:class="hmylfcFun(i,k+4)" v-for="(item,k) in 4" v-html="dxdxHtml(l.dx,k,l.miss)"></td>
            <td class="line-3" v-bind:class="hmylfcFun(i,k+8)" v-for="(item,k) in 3" v-html="dxbHtml(l.dx_p,k,l.miss)"></td>
        </tr>
        <tr class="tbody-yc" v-if="indexTime == 2">
            <td>
                {{dateTime}}<a style="color:deeppink;">{{resetIssue}}</a>
            </td>
            <td colspan="5">
                <div class="td-opentime">
                    剩余<a class="lg-minuteb"></a><b>:</b><a class="lg-secondb"></a>
                </div>
            </td>
            <td style="cursor: pointer;" @click="dx1Fun(1)"><p class="big" v-show="dx1count == 1">大</p></td>
            <td style="cursor: pointer;" @click="dx1Fun(2)"><p class="small" v-show="dx1count == 2">小</p></td>
            <td style="cursor: pointer;" @click="dx2Fun(1)"><p class="big" v-show="dx2count == 1">大</p></td>
            <td style="cursor: pointer;" @click="dx2Fun(2)"><p class="small" v-show="dx2count == 2">小</p></td>
            <td style="cursor: pointer;" @click="dx3Fun(1)"><p class="dan" v-show="dx3count == 1">大大</p></td>
            <td style="cursor: pointer;" @click="dx3Fun(2)"><p class="dan" v-show="dx3count == 2">大小</p></td>
            <td style="cursor: pointer;" @click="dx3Fun(3)"><p class="dan" v-show="dx3count == 3">小大</p></td>
            <td style="cursor: pointer;" @click="dx3Fun(4)"><p class="dan" v-show="dx3count == 4">小小</p></td>
            <td style="cursor: pointer;" @click="dxbFun(1)"><p class="dancount" v-show="dancount == 1">2:0</p></td>
            <td style="cursor: pointer;" @click="dxbFun(2)"><p class="dancount" v-show="dancount == 2">1:1</p></td>
            <td style="cursor: pointer;" @click="dxbFun(3)"><p class="dancount" v-show="dancount == 3">0:2</p></td>
        </tr>
        <tr class="tbody-yc" v-if="indexsort == 2">
            <td>
                {{dateTime}}<a style="color:deeppink;">{{parseInt(resetIssue)+1 < 100?'0'+parseInt(parseInt(resetIssue)+1):parseInt(parseInt(resetIssue)+1) >= 120?'00'+1:parseInt(parseInt(resetIssue)+1)}}</a>
            </td>
            <td colspan="5">-</td>
            <td style="cursor: pointer;" @click="dx1Fun1(1)"><p class="big" v-show="dx1count1 == 1">大</p></td>
            <td style="cursor: pointer;" @click="dx1Fun1(2)"><p class="small" v-show="dx1count1 == 2">小</p></td>
            <td style="cursor: pointer;" @click="dx2Fun1(1)"><p class="big" v-show="dx2count1 == 1">大</p></td>
            <td style="cursor: pointer;" @click="dx2Fun1(2)"><p class="small" v-show="dx2count1 == 2">小</p></td>
            <td style="cursor: pointer;" @click="dx3Fun1(1)"><p class="dan" v-show="dx3count1 == 1">大大</p></td>
            <td style="cursor: pointer;" @click="dx3Fun1(2)"><p class="dan" v-show="dx3count1 == 2">大小</p></td>
            <td style="cursor: pointer;" @click="dx3Fun1(3)"><p class="dan" v-show="dx3count1 == 3">小大</p></td>
            <td style="cursor: pointer;" @click="dx3Fun1(4)"><p class="dan" v-show="dx3count1 == 4">小小</p></td>
            <td style="cursor: pointer;" @click="dxbFun1(1)"><p class="dancount" v-show="dancount1 == 1">2:0</p></td>
            <td style="cursor: pointer;" @click="dxbFun1(2)"><p class="dancount" v-show="dancount1 == 2">1:1</p></td>
            <td style="cursor: pointer;" @click="dxbFun1(3)"><p class="dancount" v-show="dancount1 == 3">0:2</p></td>
        </tr>
        <tr class="tbody-yc" v-if="indexsort == 2">
            <td>
                {{dateTime}}<a style="color:deeppink;">{{parseInt(resetIssue)+2 < 100?'0'+parseInt(parseInt(resetIssue)+2):parseInt(parseInt(resetIssue)+2) >= 120?'00'+2:parseInt(parseInt(resetIssue)+2)}}</a>
            </td>
            <td colspan="5">-</td>
            <td style="cursor: pointer;" @click="dx1Fun2(1)"><p class="big" v-show="dx1count2 == 1">大</p></td>
            <td style="cursor: pointer;" @click="dx1Fun2(2)"><p class="small" v-show="dx1count2 == 2">小</p></td>
            <td style="cursor: pointer;" @click="dx2Fun2(1)"><p class="big" v-show="dx2count2 == 1">大</p></td>
            <td style="cursor: pointer;" @click="dx2Fun2(2)"><p class="small" v-show="dx2count2 == 2">小</p></td>
            <td style="cursor: pointer;" @click="dx3Fun2(1)"><p class="dan" v-show="dx3count2 == 1">大大</p></td>
            <td style="cursor: pointer;" @click="dx3Fun2(2)"><p class="dan" v-show="dx3count2 == 2">大小</p></td>
            <td style="cursor: pointer;" @click="dx3Fun2(3)"><p class="dan" v-show="dx3count2 == 3">小大</p></td>
            <td style="cursor: pointer;" @click="dx3Fun2(4)"><p class="dan" v-show="dx3count2 == 4">小小</p></td>
            <td style="cursor: pointer;" @click="dxbFun2(1)"><p class="dancount" v-show="dancount2 == 1">2:0</p></td>
            <td style="cursor: pointer;" @click="dxbFun2(2)"><p class="dancount" v-show="dancount2 == 2">1:1</p></td>
            <td style="cursor: pointer;" @click="dxbFun2(3)"><p class="dancount" v-show="dancount2 == 3">0:2</p></td>
        </tr>
        </tbody>
        <thead>
        <tr>
            <td rowspan="2" width="100px;" class="sort-img" @click="sortImg()">
                <span>期数</span>
                <span  v-bind:class="index?'sort-img-down':'sort-img-up'"></span>
            </td>
            <td colspan="5" rowspan="2" width="30px;">开奖号</td>
            <td width="30px;">大</td>
            <td width="30px;">小</td>
            <td width="30px;">大</td>
            <td width="30px;">小</td>
            <td width="30px;">大大</td>
            <td width="30px;">大小</td>
            <td width="30px;">小大</td>
            <td width="30px;">小小</td>
            <td width="35px;">2:0</td>
            <td width="35px;">1:1</td>
            <td width="35px;">0:2</td>
        </tr>
        <tr>
            <?php if($pos_type==3){?>
            <td colspan="2">万位</td>
            <td colspan="2">千位</td>
            <?php } else { ?>
            <td colspan="2">十位</td>
            <td colspan="2">个位</td>
            <?php }?>
            <td colspan="4">大小单选</td>
            <td colspan="3">大小比</td>
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
        num1dx:['大','小'],
        num2dx:['大','小'],
        dx:['大大','大小','小大','小小'],
        dx_p:['2:0','1:1','0:2']
    };

    var obj = {
        arr:fields.num1dx,
        arrdx:fields.dx,
        arrb:fields.dx_p
    }

    var pos=<?php echo $pos_type; ?>;

</script>
<script type="text/javascript" src="<?php echo $HttpTemplatePath; ?>51cp/static/web/js/cqssc/cqssc-trend3_<?php echo $pos_num; ?>.js?v=c167ceaa2357dd0f98caf9a7514f1ea5"></script>