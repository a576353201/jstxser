<div class="common-zs-table" style="position: relative;">
    <table>
        <thead>
        <tr>
            <td rowspan="2" width="100px;" class="sort-img" @click="sortImg()">
                <span>期数</span>
                <span  v-bind:class="index?'sort-img-down':'sort-img-up'"></span>
            </td>
            <td colspan="5" rowspan="2">开奖号</td>
            <td colspan="2">万位</td>
            <td colspan="2">千位</td>
            <td colspan="2">百位</td>
            <td colspan="2">十位</td>
            <td colspan="2">个位</td>
            <td rowspan="2" width="70px;">大小单选</td>
            <td colspan="6">大小比</td>
        </tr>
        <tr>
            <td width="30px;">大</td>
            <td width="30px;">小</td>
            <td width="30px;">大</td>
            <td width="30px;">小</td>
            <td width="30px;">大</td>
            <td width="30px;">小</td>
            <td width="30px;">大</td>
            <td width="30px;">小</td>
            <td width="30px;">大</td>
            <td width="30px;">小</td>
            <td width="35px;">5:0</td>
            <td width="35px;">4:1</td>
            <td width="35px;">3:2</td>
            <td width="35px;">2:3</td>
            <td width="35px;">1:4</td>
            <td width="35px;">0:5</td>
        </tr>
        </thead>
        <tbody class="tbody-list common-tbody-total">
        <tr class="tbody-yc" v-if="indexsort == 1">
            <td>
                {{dateTime}}<a style="color:deeppink;">{{parseInt(resetIssue)+2 < 100?'0'+parseInt(parseInt(resetIssue)+2):parseInt(parseInt(resetIssue)+2) >= 120?'00'+2:parseInt(parseInt(resetIssue)+2)}}</a>
            </td>
            <td colspan="5">-</td>
            <td style="cursor: pointer;" @click="dx1Fun(1)"><p class="big" v-show="dx1count == 1">大</p></td>
            <td style="cursor: pointer;" @click="dx1Fun2(2)"><p class="small" v-show="dx1count2 == 2">小</p></td>
            <td style="cursor: pointer;" @click="dx2Fun2(1)"><p class="big" v-show="dx2count2 == 1">大</p></td>
            <td style="cursor: pointer;" @click="dx2Fun2(2)"><p class="small" v-show="dx2count2 == 2">小</p></td>
            <td style="cursor: pointer;" @click="dx3Fun2(1)"><p class="big" v-show="dx3count2 == 1">大</p></td>
            <td style="cursor: pointer;" @click="dx3Fun2(2)"><p class="small" v-show="dx3count2 == 2">小</p></td>
            <td style="cursor: pointer;" @click="dx4Fun2(1)"><p class="big" v-show="dx4count2 == 1">大</p></td>
            <td style="cursor: pointer;" @click="dx4Fun2(2)"><p class="small" v-show="dx4count2 == 2">小</p></td>
            <td style="cursor: pointer;" @click="dx5Fun2(1)"><p class="big" v-show="dx5count2 == 1">大</p></td>
            <td style="cursor: pointer;" @click="dx5Fun2(2)"><p class="small" v-show="dx5count2 == 2">小</p></td>
            <td style="cursor: pointer;">-</td>
            <td style="cursor: pointer;" @click="dxbFun2(1)"><p class="dancount" v-show="dancount2 == 1">5:0</p></td>
            <td style="cursor: pointer;" @click="dxbFun2(2)"><p class="dancount" v-show="dancount2 == 2">4:1</p></td>
            <td style="cursor: pointer;" @click="dxbFun2(3)"><p class="dancount" v-show="dancount2 == 3">3:2</p></td>
            <td style="cursor: pointer;" @click="dxbFun2(4)"><p class="dancount" v-show="dancount2 == 4">2:3</p></td>
            <td style="cursor: pointer;" @click="dxbFun2(5)"><p class="dancount" v-show="dancount2 == 5">1:4</p></td>
            <td style="cursor: pointer;" @click="dxbFun2(6)"><p class="dancount" v-show="dancount2 == 6">0:5</p></td>
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
            <td style="cursor: pointer;" @click="dx3Fun1(1)"><p class="big" v-show="dx3count1 == 1">大</p></td>
            <td style="cursor: pointer;" @click="dx3Fun1(2)"><p class="small" v-show="dx3count1 == 2">小</p></td>
            <td style="cursor: pointer;" @click="dx4Fun1(1)"><p class="big" v-show="dx4count1 == 1">大</p></td>
            <td style="cursor: pointer;" @click="dx4Fun1(2)"><p class="small" v-show="dx4count1 == 2">小</p></td>
            <td style="cursor: pointer;" @click="dx5Fun1(1)"><p class="big" v-show="dx5count1 == 1">大</p></td>
            <td style="cursor: pointer;" @click="dx5Fun1(2)"><p class="small" v-show="dx5count1 == 2">小</p></td>
            <td style="cursor: pointer;">-</td>
            <td style="cursor: pointer;" @click="dxbFun1(1)"><p class="dancount" v-show="dancount1 == 1">5:0</p></td>
            <td style="cursor: pointer;" @click="dxbFun1(2)"><p class="dancount" v-show="dancount1 == 2">4:1</p></td>
            <td style="cursor: pointer;" @click="dxbFun1(3)"><p class="dancount" v-show="dancount1 == 3">3:2</p></td>
            <td style="cursor: pointer;" @click="dxbFun1(4)"><p class="dancount" v-show="dancount1 == 4">2:3</p></td>
            <td style="cursor: pointer;" @click="dxbFun1(5)"><p class="dancount" v-show="dancount1 == 5">1:4</p></td>
            <td style="cursor: pointer;" @click="dxbFun1(6)"><p class="dancount" v-show="dancount1 == 6">0:5</p></td>
        </tr>
        <tr  v-if="indexTime == 1">
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
            <td style="cursor: pointer;" @click="dx3Fun(1)"><p class="big" v-show="dx3count == 1">大</p></td>
            <td style="cursor: pointer;" @click="dx3Fun(2)"><p class="small" v-show="dx3count == 2">小</p></td>
            <td style="cursor: pointer;" @click="dx4Fun(1)"><p class="big" v-show="dx4count == 1">大</p></td>
            <td style="cursor: pointer;" @click="dx4Fun(2)"><p class="small" v-show="dx4count == 2">小</p></td>
            <td style="cursor: pointer;" @click="dx5Fun(1)"><p class="big" v-show="dx5count == 1">大</p></td>
            <td style="cursor: pointer;" @click="dx5Fun(2)"><p class="small" v-show="dx5count == 2">小</p></td>
            <td style="cursor: pointer;">-</td>
            <td style="cursor: pointer;" @click="dxbFun(1)"><p class="dancount" v-show="dancount == 1">5:0</p></td>
            <td style="cursor: pointer;" @click="dxbFun(2)"><p class="dancount" v-show="dancount == 2">4:1</p></td>
            <td style="cursor: pointer;" @click="dxbFun(3)"><p class="dancount" v-show="dancount == 3">3:2</p></td>
            <td style="cursor: pointer;" @click="dxbFun(4)"><p class="dancount" v-show="dancount == 4">2:3</p></td>
            <td style="cursor: pointer;" @click="dxbFun(5)"><p class="dancount" v-show="dancount == 5">1:4</p></td>
            <td style="cursor: pointer;" @click="dxbFun(6)"><p class="dancount" v-show="dancount == 6">0:5</p></td>
        </tr>
        <tr v-for="(l,i) in data">
            <td class="border-td" v-html="expectFun(l.expect)"></td>
            <td width="25px;" v-text="l.num1"></td>
            <td width="25px;" v-text="l.num2"></td>
            <td width="25px;" v-text="l.num3"></td>
            <td width="25px;"  v-text="l.num4"></td>
            <td class="border-td" width="25px;"  v-text="l.num5"></td>
            <td class="line-2" v-bind:class="hmylfcFun(i,k)" v-for="(item,k) in 2" v-html="dx1Html(l.num1dx,k,l.miss)"></td>
            <td class="line-2" v-bind:class="hmylfcFun(i,k+2)" v-for="(item,k) in 2" v-html="dx2Html(l.num2dx,k,l.miss)"></td>
            <td class="line-2" v-bind:class="hmylfcFun(i,k+4)" v-for="(item,k) in 2" v-html="dx3Html(l.num3dx,k,l.miss)"></td>
            <td class="line-2" v-bind:class="hmylfcFun(i,k+6)" v-for="(item,k) in 2" v-html="dx4Html(l.num4dx,k,l.miss)"></td>
            <td class="line-2" v-bind:class="hmylfcFun(i,k+8)" v-for="(item,k) in 2" v-html="dx5Html(l.num5dx,k,l.miss)"></td>
            <td style="width: 50px;" class="border-td"  v-html="fontColorFun(l.dx)"></td>
            <td class="line-6" v-bind:class="hmylfcFun(i,k+11)" v-for="(item,k) in 6" v-html="dxbHtml(l.dx_p,k,l.miss)"></td>
        </tr>
        <tr  v-if="indexTime == 2">
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
            <td style="cursor: pointer;" @click="dx3Fun(1)"><p class="big" v-show="dx3count == 1">大</p></td>
            <td style="cursor: pointer;" @click="dx3Fun(2)"><p class="small" v-show="dx3count == 2">小</p></td>
            <td style="cursor: pointer;" @click="dx4Fun(1)"><p class="big" v-show="dx4count == 1">大</p></td>
            <td style="cursor: pointer;" @click="dx4Fun(2)"><p class="small" v-show="dx4count == 2">小</p></td>
            <td style="cursor: pointer;" @click="dx5Fun(1)"><p class="big" v-show="dx5count == 1">大</p></td>
            <td style="cursor: pointer;" @click="dx5Fun(2)"><p class="small" v-show="dx5count == 2">小</p></td>
            <td style="cursor: pointer;">-</td>
            <td style="cursor: pointer;" @click="dxbFun(1)"><p class="dancount" v-show="dancount == 1">5:0</p></td>
            <td style="cursor: pointer;" @click="dxbFun(2)"><p class="dancount" v-show="dancount == 2">4:1</p></td>
            <td style="cursor: pointer;" @click="dxbFun(3)"><p class="dancount" v-show="dancount == 3">3:2</p></td>
            <td style="cursor: pointer;" @click="dxbFun(4)"><p class="dancount" v-show="dancount == 4">2:3</p></td>
            <td style="cursor: pointer;" @click="dxbFun(5)"><p class="dancount" v-show="dancount == 5">1:4</p></td>
            <td style="cursor: pointer;" @click="dxbFun(6)"><p class="dancount" v-show="dancount == 6">0:5</p></td>
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
            <td style="cursor: pointer;" @click="dx3Fun1(1)"><p class="big" v-show="dx3count1 == 1">大</p></td>
            <td style="cursor: pointer;" @click="dx3Fun1(2)"><p class="small" v-show="dx3count1 == 2">小</p></td>
            <td style="cursor: pointer;" @click="dx4Fun1(1)"><p class="big" v-show="dx4count1 == 1">大</p></td>
            <td style="cursor: pointer;" @click="dx4Fun1(2)"><p class="small" v-show="dx4count1 == 2">小</p></td>
            <td style="cursor: pointer;" @click="dx5Fun1(1)"><p class="big" v-show="dx5count1 == 1">大</p></td>
            <td style="cursor: pointer;" @click="dx5Fun1(2)"><p class="small" v-show="dx5count1 == 2">小</p></td>
            <td style="cursor: pointer;">-</td>
            <td style="cursor: pointer;" @click="dxbFun1(1)"><p class="dancount" v-show="dancount1 == 1">5:0</p></td>
            <td style="cursor: pointer;" @click="dxbFun1(2)"><p class="dancount" v-show="dancount1 == 2">4:1</p></td>
            <td style="cursor: pointer;" @click="dxbFun1(3)"><p class="dancount" v-show="dancount1 == 3">3:2</p></td>
            <td style="cursor: pointer;" @click="dxbFun1(4)"><p class="dancount" v-show="dancount1 == 4">2:3</p></td>
            <td style="cursor: pointer;" @click="dxbFun1(5)"><p class="dancount" v-show="dancount1 == 5">1:4</p></td>
            <td style="cursor: pointer;" @click="dxbFun1(6)"><p class="dancount" v-show="dancount1 == 6">0:5</p></td>
        </tr>
        <tr class="tbody-yc" v-if="indexsort == 2">
            <td>
                {{dateTime}}<a style="color:deeppink;">{{parseInt(resetIssue)+2 < 100?'0'+parseInt(parseInt(resetIssue)+2):parseInt(parseInt(resetIssue)+2) >= 120?'00'+2:parseInt(parseInt(resetIssue)+2)}}</a>
            </td>
            <td colspan="5">-</td>
            <td style="cursor: pointer;" @click="dx1Fun(1)"><p class="big" v-show="dx1count == 1">大</p></td>
            <td style="cursor: pointer;" @click="dx1Fun2(2)"><p class="small" v-show="dx1count2 == 2">小</p></td>
            <td style="cursor: pointer;" @click="dx2Fun2(1)"><p class="big" v-show="dx2count2 == 1">大</p></td>
            <td style="cursor: pointer;" @click="dx2Fun2(2)"><p class="small" v-show="dx2count2 == 2">小</p></td>
            <td style="cursor: pointer;" @click="dx3Fun2(1)"><p class="big" v-show="dx3count2 == 1">大</p></td>
            <td style="cursor: pointer;" @click="dx3Fun2(2)"><p class="small" v-show="dx3count2 == 2">小</p></td>
            <td style="cursor: pointer;" @click="dx4Fun2(1)"><p class="big" v-show="dx4count2 == 1">大</p></td>
            <td style="cursor: pointer;" @click="dx4Fun2(2)"><p class="small" v-show="dx4count2 == 2">小</p></td>
            <td style="cursor: pointer;" @click="dx5Fun2(1)"><p class="big" v-show="dx5count2 == 1">大</p></td>
            <td style="cursor: pointer;" @click="dx5Fun2(2)"><p class="small" v-show="dx5count2 == 2">小</p></td>
            <td style="cursor: pointer;">-</td>
            <td style="cursor: pointer;" @click="dxbFun2(1)"><p class="dancount" v-show="dancount2 == 1">5:0</p></td>
            <td style="cursor: pointer;" @click="dxbFun2(2)"><p class="dancount" v-show="dancount2 == 2">4:1</p></td>
            <td style="cursor: pointer;" @click="dxbFun2(3)"><p class="dancount" v-show="dancount2 == 3">3:2</p></td>
            <td style="cursor: pointer;" @click="dxbFun2(4)"><p class="dancount" v-show="dancount2 == 4">2:3</p></td>
            <td style="cursor: pointer;" @click="dxbFun2(5)"><p class="dancount" v-show="dancount2 == 5">1:4</p></td>
            <td style="cursor: pointer;" @click="dxbFun2(6)"><p class="dancount" v-show="dancount2 == 6">0:5</p></td>
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
            <td width="30px;">大</td>
            <td width="30px;">小</td>
            <td width="30px;">大</td>
            <td width="30px;">小</td>
            <td width="30px;">大</td>
            <td width="30px;">小</td>
            <td rowspan="2" width="70px;">大小单选</td>
            <td width="35px;">5:0</td>
            <td width="35px;">4:1</td>
            <td width="35px;">3:2</td>
            <td width="35px;">2:3</td>
            <td width="35px;">1:4</td>
            <td width="35px;">0:5</td>
        </tr>
        <tr>
            <td colspan="2">万位</td>
            <td colspan="2">千位</td>
            <td colspan="2">百位</td>
            <td colspan="2">十位</td>
            <td colspan="2">个位</td>
            <td colspan="6">大小比</td>
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
        num3dx:['大','小'],
        num4dx:['大','小'],
        num5dx:['大','小'],
        dx:[0],
        dx_p:['5:0','4:1','3:2','2:3','1:4','0:5']

    };
    var obj = {
        arr:fields.num1dx,
        arrb:fields.dx_p
    }
</script>
<script type="text/javascript" src="<?php echo $HttpPath; ?>static/web/js/cqssc/cqssc-trend<?php echo $pos_type; ?>_<?php echo $pos_num; ?>.js?v=c167ceaa2357dd0f98caf9a7514f1ea5"></script>