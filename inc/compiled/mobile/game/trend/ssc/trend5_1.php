<div class="common-zs-table" style="position: relative;">
    <table>
        <thead>
        <tr>
            <td rowspan="2" width="100px;" class="sort-img" @click="sortImg()">
                <span>期数</span>
                <span  v-bind:class="index?'sort-img-down':'sort-img-up'"></span>
            </td>
            <td rowspan="2" colspan="5" width="90px;">开奖号</td>
            <td colspan="10">组选</td>
            <td colspan="4">大小比</td>
            <td colspan="4">单双比</td>
            <td colspan="4">质合比</td>
            <td rowspan="2">012路比</td>
            <td rowspan="2">形态</td>
            <td rowspan="2">和值</td>
            <td rowspan="2">跨度</td>
        </tr>
        <tr>
            <td v-for="k in 10" width="30px;" v-text="k-1"></td>
            <td width="30px;">3:0</td>
            <td width="30px;">2:1</td>
            <td width="30px;">1:2</td>
            <td width="30px;">0:3</td>

            <td width="30px;">3:0</td>
            <td width="30px;">2:1</td>
            <td width="30px;">1:2</td>
            <td width="30px;">0:3</td>

            <td width="30px;">3:0</td>
            <td width="30px;">2:1</td>
            <td width="30px;">1:2</td>
            <td width="30px;">0:3</td>
        </tr>
        </thead>
        <tbody class="tbody-yc" v-if="indexsort == 1">
        <tr>
            <td>
                {{dateTime}}<a style="color:deeppink;">{{parseInt(resetIssue)+2 < 100?'0'+parseInt(parseInt(resetIssue)+2):parseInt(parseInt(resetIssue)+2) >= 120?'00'+2:parseInt(parseInt(resetIssue)+2)}}</a>
            </td>
            <td colspan="5">-</td>
            <td v-for="k in 10" style="cursor: pointer;" @click="ychmFun(k-1,$event.target)"></td>
            <td style="cursor: pointer;" @click="ycxtFun2(1)"><p v-show="xt12 == 1" class="dancount">3:0</p></td>
            <td style="cursor: pointer;" @click="ycxtFun2(2)"><p v-show="xt12 == 2" class="dancount">2:1</p></td>
            <td style="cursor: pointer;" @click="ycxtFun2(3)"><p v-show="xt12 == 3" class="dancount">1:2</p></td>
            <td style="cursor: pointer;" @click="ycxtFun2(4)"><p v-show="xt12 == 4" class="dancount">0:3</p></td>
            <td style="cursor: pointer;" @click="ycdFun2(1)"><p v-show="dcount2 == 1" class="dan">3:0</p></td>
            <td style="cursor: pointer;" @click="ycdFun2(2)"><p v-show="dcount2 == 2" class="dan">2:1</p></td>
            <td style="cursor: pointer;" @click="ycdFun2(3)"><p v-show="dcount2 == 3" class="dan">1:2</p></td>
            <td style="cursor: pointer;" @click="ycdFun2(4)"><p v-show="dcount2 == 4" class="dan">0:3</p></td>
            <td style="cursor: pointer;" @click="ycdanFun2(1)"><p v-show="dancount2 == 1" class="status1-3">3:0</p></td>
            <td style="cursor: pointer;" @click="ycdanFun2(2)"><p v-show="dancount2 == 2" class="status1-3">2:1</p></td>
            <td style="cursor: pointer;" @click="ycdanFun2(3)"><p v-show="dancount2 == 3" class="status1-3">1:2</p></td>
            <td style="cursor: pointer;" @click="ycdanFun2(4)"><p v-show="dancount2 == 4" class="status1-3">0:3</p></td>
            <td>-</td>
            <td>-</td>
            <td>-</td>
            <td>-</td>
        </tr>
        </tbody>
        <tbody class="tbody-yc" v-if="indexsort == 1">
        <tr>
            <td>
                {{dateTime}}<a style="color:deeppink;">{{parseInt(resetIssue)+1 < 100?'0'+parseInt(parseInt(resetIssue)+1):parseInt(parseInt(resetIssue)+1) >= 120?'00'+1:parseInt(parseInt(resetIssue)+1)}}</a>
            </td>
            <td colspan="5">-</td>
            <td v-for="k in 10" style="cursor: pointer;" @click="ychmFun(k-1,$event.target)"></td>
            <td style="cursor: pointer;" @click="ycxtFun1(1)"><p v-show="xt11 == 1" class="dancount">3:0</p></td>
            <td style="cursor: pointer;" @click="ycxtFun1(2)"><p v-show="xt11 == 2" class="dancount">2:1</p></td>
            <td style="cursor: pointer;" @click="ycxtFun1(3)"><p v-show="xt11 == 3" class="dancount">1:2</p></td>
            <td style="cursor: pointer;" @click="ycxtFun1(4)"><p v-show="xt11 == 4" class="dancount">0:3</p></td>
            <td style="cursor: pointer;" @click="ycdFun1(1)"><p v-show="dcount1 == 1" class="dan">3:0</p></td>
            <td style="cursor: pointer;" @click="ycdFun1(2)"><p v-show="dcount1 == 2" class="dan">2:1</p></td>
            <td style="cursor: pointer;" @click="ycdFun1(3)"><p v-show="dcount1 == 3" class="dan">1:2</p></td>
            <td style="cursor: pointer;" @click="ycdFun1(4)"><p v-show="dcount1 == 4" class="dan">0:3</p></td>
            <td style="cursor: pointer;" @click="ycdanFun1(1)"><p v-show="dancount1 == 1" class="status1-3">3:0</p></td>
            <td style="cursor: pointer;" @click="ycdanFun1(2)"><p v-show="dancount1 == 2" class="status1-3">2:1</p></td>
            <td style="cursor: pointer;" @click="ycdanFun1(3)"><p v-show="dancount1 == 3" class="status1-3">1:2</p></td>
            <td style="cursor: pointer;" @click="ycdanFun1(4)"><p v-show="dancount1 == 4" class="status1-3">0:3</p></td>
            <td>-</td>
            <td>-</td>
            <td>-</td>
            <td>-</td>
        </tr>
        </tbody>
        <tbody  v-if="indexTime == 1">
        <tr>
            <td>
                {{dateTime}}<a style="color:deeppink;">{{resetIssue}}</a>
            </td>
            <td colspan="5">
                <div class="td-opentime">
                    剩余<a class="lg-minuteb"></a><b>:</b><a class="lg-secondb"></a>
                </div>
            </td>
            <td v-for="k in 10" style="cursor: pointer;" @click="ychmFun(k-1,$event.target)"></td>
            <td style="cursor: pointer;" @click="ycxtFun(1)"><p v-show="xt1 == 1" class="dancount">3:0</p></td>
            <td style="cursor: pointer;" @click="ycxtFun(2)"><p v-show="xt1 == 2" class="dancount">2:1</p></td>
            <td style="cursor: pointer;" @click="ycxtFun(3)"><p v-show="xt1 == 3" class="dancount">1:2</p></td>
            <td style="cursor: pointer;" @click="ycxtFun(4)"><p v-show="xt1 == 4" class="dancount">0:3</p></td>
            <td style="cursor: pointer;" @click="ycdFun(1)"><p v-show="dcount == 1" class="dan">3:0</p></td>
            <td style="cursor: pointer;" @click="ycdFun(2)"><p v-show="dcount == 2" class="dan">2:1</p></td>
            <td style="cursor: pointer;" @click="ycdFun(3)"><p v-show="dcount == 3" class="dan">1:2</p></td>
            <td style="cursor: pointer;" @click="ycdFun(4)"><p v-show="dcount == 4" class="dan">0:3</p></td>
            <td style="cursor: pointer;" @click="ycdanFun(1)"><p v-show="dancount == 1" class="status1-3">3:0</p></td>
            <td style="cursor: pointer;" @click="ycdanFun(2)"><p v-show="dancount == 2" class="status1-3">2:1</p></td>
            <td style="cursor: pointer;" @click="ycdanFun(3)"><p v-show="dancount == 3" class="status1-3">1:2</p></td>
            <td style="cursor: pointer;" @click="ycdanFun(4)"><p v-show="dancount == 4" class="status1-3">0:3</p></td>
            <td>-</td>
            <td>-</td>
            <td>-</td>
            <td>-</td>
        </tr>
        </tbody>
        <tbody class="tbody-list">
        <tr v-for="(l,i) in data">
            <td class="border-td" v-html="expectFun(l.expect)"></td>
            <td width="25px;" v-text="l.num1" <?php if($pos_type==3 || $pos_type==5 || $pos_type==8){?>style="color: red;"<?php }?>></td>
            <td width="25px;" v-text="l.num2" <?php if($pos_type==3 || $pos_type==5 || $pos_type==6 || $pos_type==8 || $pos_type==9){?>style="color: red;"<?php }?> ></td>
            <td width="25px;" v-text="l.num3" <?php if($pos_type==5 || $pos_type==6 || $pos_type==7 || $pos_type==8 || $pos_type==9){?>style="color: red;"<?php }?> ></td>
            <td width="25px;"  v-text="l.num4" <?php if($pos_type==4 || $pos_type==6 || $pos_type==7 || $pos_type==8 || $pos_type==9){?>style="color: red;"<?php }?> ></td>
            <td class="border-td" width="25px;"  v-text="l.num5"  <?php if($pos_type==4 || $pos_type==7 || $pos_type==9){?>style="color: red;"<?php }?> ></td>
            <?php if($pos_type==5){?>
            <td class="hm-R line-10" v-bind:class="hmylfcFun(i,n)" v-for="(k,n) in 10" v-html="hmHtml(l.numArrq3,n,l.miss)"></td>
            <?php } else if($pos_type==6) { ?>
            <td class="hm-R line-10" v-bind:class="hmylfcFun(i,n)" v-for="(k,n) in 10" v-html="hmHtml(l.numArrz3,n,l.miss)"></td>
            <?php } else { ?>
            <td class="hm-R line-10" v-bind:class="hmylfcFun(i,n)" v-for="(k,n) in 10" v-html="hmHtml(l.numArrh3,n,l.miss)"></td>
            <?php }?>

            <td class="line-4" v-bind:class="hmylfcFun(i,k+10)" v-for="(item,k) in 4" v-html="dxbFun(l.dx_p,k,l.miss)"></td>
            <td class="line-4" v-bind:class="hmylfcFun(i,k+14)" v-for="(item,k) in 4" v-html="dsbFun(l.ds_p,k,l.miss)"></td>
            <td class="line-4" v-bind:class="hmylfcFun(i,k+18)" v-for="(item,k) in 4" v-html="zhFun(l.zh_p,k,l.miss)"></td>
            <td class="border-td" v-text="l['012_p']"></td>
            <td class="border-td" v-text="l.status"></td>
            <td class="border-td" v-text="l.sum_val"></td>
            <td class="border-td" v-text="l.span"></td>
        </tr>
        </tbody>
        <tbody  v-if="indexTime == 2">
        <tr>
            <td>
                {{dateTime}}<a style="color:deeppink;">{{resetIssue}}</a>
            </td>
            <td colspan="5">
                <div class="td-opentime">
                    剩余<a class="lg-minuteb"></a><b>:</b><a class="lg-secondb"></a>
                </div>
            </td>
            <td v-for="k in 10" style="cursor: pointer;" @click="ychmFun(k-1,$event.target)"></td>
            <td style="cursor: pointer;" @click="ycxtFun(1)"><p v-show="xt1 == 1" class="dancount">3:0</p></td>
            <td style="cursor: pointer;" @click="ycxtFun(2)"><p v-show="xt1 == 2" class="dancount">2:1</p></td>
            <td style="cursor: pointer;" @click="ycxtFun(3)"><p v-show="xt1 == 3" class="dancount">1:2</p></td>
            <td style="cursor: pointer;" @click="ycxtFun(4)"><p v-show="xt1 == 4" class="dancount">0:3</p></td>
            <td style="cursor: pointer;" @click="ycdFun(1)"><p v-show="dcount == 1" class="dan">3:0</p></td>
            <td style="cursor: pointer;" @click="ycdFun(2)"><p v-show="dcount == 2" class="dan">2:1</p></td>
            <td style="cursor: pointer;" @click="ycdFun(3)"><p v-show="dcount == 3" class="dan">1:2</p></td>
            <td style="cursor: pointer;" @click="ycdFun(4)"><p v-show="dcount == 4" class="dan">0:3</p></td>
            <td style="cursor: pointer;" @click="ycdanFun(1)"><p v-show="dancount == 1" class="status1-3">3:0</p></td>
            <td style="cursor: pointer;" @click="ycdanFun(2)"><p v-show="dancount == 2" class="status1-3">2:1</p></td>
            <td style="cursor: pointer;" @click="ycdanFun(3)"><p v-show="dancount == 3" class="status1-3">1:2</p></td>
            <td style="cursor: pointer;" @click="ycdanFun(4)"><p v-show="dancount == 4" class="status1-3">0:3</p></td>
            <td>-</td>
            <td>-</td>
            <td>-</td>
            <td>-</td>
        </tr>
        </tbody>
        <tbody class="tbody-yc" v-if="indexsort == 2">
        <tr>
            <td>
                {{dateTime}}<a style="color:deeppink;">{{parseInt(resetIssue)+1 < 100?'0'+parseInt(parseInt(resetIssue)+1):parseInt(parseInt(resetIssue)+1) >= 120?'00'+1:parseInt(parseInt(resetIssue)+1)}}</a>
            </td>
            <td colspan="5">-</td>
            <td v-for="k in 10" style="cursor: pointer;" @click="ychmFun(k-1,$event.target)"></td>
            <td style="cursor: pointer;" @click="ycxtFun1(1)"><p v-show="xt11 == 1" class="dancount">3:0</p></td>
            <td style="cursor: pointer;" @click="ycxtFun1(2)"><p v-show="xt11 == 2" class="dancount">2:1</p></td>
            <td style="cursor: pointer;" @click="ycxtFun1(3)"><p v-show="xt11 == 3" class="dancount">1:2</p></td>
            <td style="cursor: pointer;" @click="ycxtFun1(4)"><p v-show="xt11 == 4" class="dancount">0:3</p></td>
            <td style="cursor: pointer;" @click="ycdFun1(1)"><p v-show="dcount1 == 1" class="dan">3:0</p></td>
            <td style="cursor: pointer;" @click="ycdFun1(2)"><p v-show="dcount1 == 2" class="dan">2:1</p></td>
            <td style="cursor: pointer;" @click="ycdFun1(3)"><p v-show="dcount1 == 3" class="dan">1:2</p></td>
            <td style="cursor: pointer;" @click="ycdFun1(4)"><p v-show="dcount1 == 4" class="dan">0:3</p></td>
            <td style="cursor: pointer;" @click="ycdanFun1(1)"><p v-show="dancount1 == 1" class="status1-3">3:0</p></td>
            <td style="cursor: pointer;" @click="ycdanFun1(2)"><p v-show="dancount1 == 2" class="status1-3">2:1</p></td>
            <td style="cursor: pointer;" @click="ycdanFun1(3)"><p v-show="dancount1 == 3" class="status1-3">1:2</p></td>
            <td style="cursor: pointer;" @click="ycdanFun1(4)"><p v-show="dancount1 == 4" class="status1-3">0:3</p></td>
            <td>-</td>
            <td>-</td>
            <td>-</td>
            <td>-</td>
        </tr>
        </tbody>
        <tbody class="tbody-yc" v-if="indexsort == 2">
        <tr>
            <td>
                {{dateTime}}<a style="color:deeppink;">{{parseInt(resetIssue)+2 < 100?'0'+parseInt(parseInt(resetIssue)+2):parseInt(parseInt(resetIssue)+2) >= 120?'00'+2:parseInt(parseInt(resetIssue)+2)}}</a>
            </td>
            <td colspan="5">-</td>
            <td v-for="k in 10" style="cursor: pointer;" @click="ychmFun(k-1,$event.target)"></td>
            <td style="cursor: pointer;" @click="ycxtFun2(1)"><p v-show="xt12 == 1" class="dancount">3:0</p></td>
            <td style="cursor: pointer;" @click="ycxtFun2(2)"><p v-show="xt12 == 2" class="dancount">2:1</p></td>
            <td style="cursor: pointer;" @click="ycxtFun2(3)"><p v-show="xt12 == 3" class="dancount">1:2</p></td>
            <td style="cursor: pointer;" @click="ycxtFun2(4)"><p v-show="xt12 == 4" class="dancount">0:3</p></td>
            <td style="cursor: pointer;" @click="ycdFun2(1)"><p v-show="dcount2 == 1" class="dan">3:0</p></td>
            <td style="cursor: pointer;" @click="ycdFun2(2)"><p v-show="dcount2 == 2" class="dan">2:1</p></td>
            <td style="cursor: pointer;" @click="ycdFun2(3)"><p v-show="dcount2 == 3" class="dan">1:2</p></td>
            <td style="cursor: pointer;" @click="ycdFun2(4)"><p v-show="dcount2 == 4" class="dan">0:3</p></td>
            <td style="cursor: pointer;" @click="ycdanFun2(1)"><p v-show="dancount2 == 1" class="status1-3">3:0</p></td>
            <td style="cursor: pointer;" @click="ycdanFun2(2)"><p v-show="dancount2 == 2" class="status1-3">2:1</p></td>
            <td style="cursor: pointer;" @click="ycdanFun2(3)"><p v-show="dancount2 == 3" class="status1-3">1:2</p></td>
            <td style="cursor: pointer;" @click="ycdanFun2(4)"><p v-show="dancount2 == 4" class="status1-3">0:3</p></td>
            <td>-</td>
            <td>-</td>
            <td>-</td>
            <td>-</td>
        </tr>
        </tbody>
        <thead>
        <tr>
            <td rowspan="2" width="100px;" class="sort-img" @click="sortImg()">
                <span>期数</span>
                <span  v-bind:class="index?'sort-img-down':'sort-img-up'"></span>
            </td>
            <td rowspan="2" colspan="5" width="90px;">开奖号</td>
            <td v-for="k in 10" width="30px;" v-text="k-1"></td>
            <td width="30px;">3:0</td>
            <td width="30px;">2:1</td>
            <td width="30px;">1:2</td>
            <td width="30px;">0:3</td>

            <td width="30px;">3:0</td>
            <td width="30px;">2:1</td>
            <td width="30px;">1:2</td>
            <td width="30px;">0:3</td>

            <td width="30px;">3:0</td>
            <td width="30px;">2:1</td>
            <td width="30px;">1:2</td>
            <td width="30px;">0:3</td>

            <td rowspan="2">012路比</td>
            <td rowspan="2">形态</td>
            <td rowspan="2">和值</td>
            <td rowspan="2">跨度</td>
        </tr>
        <tr>
            <td colspan="10">组选</td>
            <td colspan="4">大小比</td>
            <td colspan="4">单双比</td>
            <td colspan="4">质合比</td>
        </tr>
        </thead>
        <tbody id="total">
        <tr>
            <td colspan="6">出现次数</td>
            <td v-for="(l,n) in sta.times" v-text="lHtml(l,n)"></td>
        </tr>
        <tr>
            <td colspan="6">最大连出</td>
            <td v-for="(l,n) in sta.max_out" v-text="lHtml(l,n)"></td>
        </tr>
        <tr>
            <td colspan="6">最大遗漏</td>
            <td v-for="(l,n) in sta.max_miss" v-text="lHtml(l,n)"></td>
        </tr>
        <tr>
            <td colspan="6">平均遗漏</td>
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
        dx_p:['3:0','2:1','1:2','0:3'],
        ds_p:['3:0','2:1','1:2','0:3'],
        zh_p:['3:0','2:1','1:2','0:3'],
        '012_p':[0],
        status:['对子'],
        sum_val:[0],
        span:[0]

    };

    var fields2 = [[<?php echo $filed2; ?>],[0,1,2,3,4,5,6,7,8,9]];

    var pos = <?php echo $pos_type; ?>;

</script>
<script type="text/javascript" src="<?php echo $HttpPath; ?>static/web/js/cqssc/cqssc-trend5_<?php echo $pos_num; ?>.js?v=c167ceaa2357dd0f98caf9a7514f1ea5"></script>
