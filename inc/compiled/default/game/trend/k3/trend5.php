<div class="common-zs-table" style="position: relative;">
    <table>
        <thead>
        <tr>
            <td rowspan="2" width="100px;" class="sort-img" @click="sortImg()">
                <span>期数</span>
                <span  v-bind:class="index?'sort-img-down':'sort-img-up'"></span>
            </td>
            <td rowspan="2" colspan="3" width="90px;">开奖号</td>
            <td colspan="3">百位012路</td>
            <td colspan="3">十位012路</td>
            <td colspan="3">个位012路</td>
            <td rowspan="2" style="width:80px;">012路单选</td>
            <td colspan="4">0路个数</td>
            <td colspan="4">1路个数</td>
            <td colspan="4">2路个数</td>
        </tr>
        <tr>
            <td width="50px;" v-for="k in 3"  v-text="k-1"></td>
            <td width="50px;" v-for="k in 3"  v-text="k-1"></td>
            <td width="50px;" v-for="k in 3"  v-text="k-1"></td>
            <td width="50px;" v-for="k in 4"  v-text="k-1"></td>
            <td width="50px;" v-for="k in 4"  v-text="k-1"></td>
            <td width="50px;" v-for="k in 4"  v-text="k-1"></td>
        </tr>
        </thead>
        <tbody class="common-tbody-total tbody-list">
        <tr class="tbody-yc" v-if="indexsort == 1">
            <td>
                {{dateTime}}<a style="color:deeppink;">{{parseInt(resetIssue)+2 < 100?'0'+parseInt(parseInt(resetIssue)+2):parseInt(parseInt(resetIssue)+2) >= 82?'00'+2:parseInt(parseInt(resetIssue)+2)}}</a>
            </td>
            <td colspan="3">-</td>
            <td style="cursor: pointer;" @click="ycb012Fun2(1)"><p v-show=" xt1count2 == 1" class="big">0</p></td>
            <td style="cursor: pointer;" @click="ycb012Fun2(2)"><p v-show=" xt1count2 == 2" class="shuang">1</p></td>
            <td style="cursor: pointer;" @click="ycb012Fun2(3)"><p v-show=" xt1count2 == 3" class="dan">2</p></td>
            <td style="cursor: pointer;" @click="ycs012Fun2(1)"><p v-show=" xt2count2 == 1" class="big">0</p></td>
            <td style="cursor: pointer;" @click="ycs012Fun2(2)"><p v-show=" xt2count2 == 2" class="shuang">1</p></td>
            <td style="cursor: pointer;" @click="ycs012Fun2(3)"><p v-show=" xt2count2 == 3" class="dan">2</p></td>
            <td style="cursor: pointer;" @click="ycg012Fun2(1)"><p v-show=" xt3count2 == 1" class="big">0</p></td>
            <td style="cursor: pointer;" @click="ycg012Fun2(2)"><p v-show=" xt3count2 == 2" class="shuang">1</p></td>
            <td style="cursor: pointer;" @click="ycg012Fun2(3)"><p v-show=" xt3count2 == 3" class="dan">2</p></td>
            <td style="cursor: pointer;">-</td>
            <td style="cursor: pointer;" @click="yc0countFun2(1)"><p v-show=" xt4count2 == 1" class="big">0</p></td>
            <td style="cursor: pointer;" @click="yc0countFun2(2)"><p v-show=" xt4count2 == 2" class="shuang">1</p></td>
            <td style="cursor: pointer;" @click="yc0countFun2(3)"><p v-show=" xt4count2 == 3" class="dan">2</p></td>
            <td style="cursor: pointer;" @click="yc0countFun2(4)"><p v-show=" xt4count2 == 4" class="small">3</p></td>
            <td style="cursor: pointer;" @click="yc1countFun2(1)"><p v-show=" xt5count2 == 1" class="big">0</p></td>
            <td style="cursor: pointer;" @click="yc1countFun2(2)"><p v-show=" xt5count2 == 2" class="shuang">1</p></td>
            <td style="cursor: pointer;" @click="yc1countFun2(3)"><p v-show=" xt5count2 == 3" class="dan">2</p></td>
            <td style="cursor: pointer;" @click="yc1countFun2(4)"><p v-show=" xt5count2 == 4" class="small">3</p></td>
            <td style="cursor: pointer;" @click="yc2countFun2(1)"><p v-show=" xt6count2 == 1" class="big">0</p></td>
            <td style="cursor: pointer;" @click="yc2countFun2(2)"><p v-show=" xt6count2 == 2" class="shuang">1</p></td>
            <td style="cursor: pointer;" @click="yc2countFun2(3)"><p v-show=" xt6count2 == 3" class="dan">2</p></td>
            <td style="cursor: pointer;" @click="yc2countFun2(4)"><p v-show=" xt6count2 == 4" class="small">3</p></td>
        </tr>
        <tr class="tbody-yc" v-if="indexsort == 1">
            <td>
                {{dateTime}}<a style="color:deeppink;">{{parseInt(resetIssue)+1 < 100?'0'+parseInt(parseInt(resetIssue)+1):parseInt(parseInt(resetIssue)+1) >= 82?'00'+1:parseInt(parseInt(resetIssue)+1)}}</a>
            </td>
            <td colspan="3">-</td>
            <td style="cursor: pointer;" @click="ycb012Fun1(1)"><p v-show=" xt1count1 == 1" class="big">0</p></td>
            <td style="cursor: pointer;" @click="ycb012Fun1(2)"><p v-show=" xt1count1 == 2" class="shuang">1</p></td>
            <td style="cursor: pointer;" @click="ycb012Fun1(3)"><p v-show=" xt1count1 == 3" class="dan">2</p></td>
            <td style="cursor: pointer;" @click="ycs012Fun1(1)"><p v-show=" xt2count1 == 1" class="big">0</p></td>
            <td style="cursor: pointer;" @click="ycs012Fun1(2)"><p v-show=" xt2count1 == 2" class="shuang">1</p></td>
            <td style="cursor: pointer;" @click="ycs012Fun1(3)"><p v-show=" xt2count1 == 3" class="dan">2</p></td>
            <td style="cursor: pointer;" @click="ycg012Fun1(1)"><p v-show=" xt3count1 == 1" class="big">0</p></td>
            <td style="cursor: pointer;" @click="ycg012Fun1(2)"><p v-show=" xt3count1 == 2" class="shuang">1</p></td>
            <td style="cursor: pointer;" @click="ycg012Fun1(3)"><p v-show=" xt3count1 == 3" class="dan">2</p></td>
            <td style="cursor: pointer;">-</td>
            <td style="cursor: pointer;" @click="yc0countFun1(1)"><p v-show=" xt4count1 == 1" class="big">0</p></td>
            <td style="cursor: pointer;" @click="yc0countFun1(2)"><p v-show=" xt4count1 == 2" class="shuang">1</p></td>
            <td style="cursor: pointer;" @click="yc0countFun1(3)"><p v-show=" xt4count1 == 3" class="dan">2</p></td>
            <td style="cursor: pointer;" @click="yc0countFun1(4)"><p v-show=" xt4count1 == 4" class="small">3</p></td>
            <td style="cursor: pointer;" @click="yc1countFun1(1)"><p v-show=" xt5count1 == 1" class="big">0</p></td>
            <td style="cursor: pointer;" @click="yc1countFun1(2)"><p v-show=" xt5count1 == 2" class="shuang">1</p></td>
            <td style="cursor: pointer;" @click="yc1countFun1(3)"><p v-show=" xt5count1 == 3" class="dan">2</p></td>
            <td style="cursor: pointer;" @click="yc1countFun1(4)"><p v-show=" xt5count1 == 4" class="small">3</p></td>
            <td style="cursor: pointer;" @click="yc2countFun1(1)"><p v-show=" xt6count1 == 1" class="big">0</p></td>
            <td style="cursor: pointer;" @click="yc2countFun1(2)"><p v-show=" xt6count1 == 2" class="shuang">1</p></td>
            <td style="cursor: pointer;" @click="yc2countFun1(3)"><p v-show=" xt6count1 == 3" class="dan">2</p></td>
            <td style="cursor: pointer;" @click="yc2countFun1(4)"><p v-show=" xt6count1 == 4" class="small">3</p></td>
        </tr>
        <tr  v-if="indexTime == 1">
            <td>
                {{dateTime}}<a style="color:#ff0000;">{{resetIssue}}</a>
            </td>
            <td colspan="3">
                <div class="td-opentime">
                    剩余<a class="lg-minuteb"></a><b>:</b><a class="lg-secondb"></a>
                </div>
            </td>
            <td style="cursor: pointer;" @click="ycb012Fun(1)"><p v-show=" xt1count == 1" class="big">0</p></td>
            <td style="cursor: pointer;" @click="ycb012Fun(2)"><p v-show=" xt1count == 2" class="shuang">1</p></td>
            <td style="cursor: pointer;" @click="ycb012Fun(3)"><p v-show=" xt1count == 3" class="dan">2</p></td>
            <td style="cursor: pointer;" @click="ycs012Fun(1)"><p v-show=" xt2count == 1" class="big">0</p></td>
            <td style="cursor: pointer;" @click="ycs012Fun(2)"><p v-show=" xt2count == 2" class="shuang">1</p></td>
            <td style="cursor: pointer;" @click="ycs012Fun(3)"><p v-show=" xt2count == 3" class="dan">2</p></td>
            <td style="cursor: pointer;" @click="ycg012Fun(1)"><p v-show=" xt3count == 1" class="big">0</p></td>
            <td style="cursor: pointer;" @click="ycg012Fun(2)"><p v-show=" xt3count == 2" class="shuang">1</p></td>
            <td style="cursor: pointer;" @click="ycg012Fun(3)"><p v-show=" xt3count == 3" class="dan">2</p></td>
            <td style="cursor: pointer;">-</td>
            <td style="cursor: pointer;" @click="yc0countFun(1)"><p v-show=" xt4count == 1" class="big">0</p></td>
            <td style="cursor: pointer;" @click="yc0countFun(2)"><p v-show=" xt4count == 2" class="shuang">1</p></td>
            <td style="cursor: pointer;" @click="yc0countFun(3)"><p v-show=" xt4count == 3" class="dan">2</p></td>
            <td style="cursor: pointer;" @click="yc0countFun(4)"><p v-show=" xt4count == 4" class="small">3</p></td>
            <td style="cursor: pointer;" @click="yc1countFun(1)"><p v-show=" xt5count == 1" class="big">0</p></td>
            <td style="cursor: pointer;" @click="yc1countFun(2)"><p v-show=" xt5count == 2" class="shuang">1</p></td>
            <td style="cursor: pointer;" @click="yc1countFun(3)"><p v-show=" xt5count == 3" class="dan">2</p></td>
            <td style="cursor: pointer;" @click="yc1countFun(4)"><p v-show=" xt5count == 4" class="small">3</p></td>
            <td style="cursor: pointer;" @click="yc2countFun(1)"><p v-show=" xt6count == 1" class="big">0</p></td>
            <td style="cursor: pointer;" @click="yc2countFun(2)"><p v-show=" xt6count == 2" class="shuang">1</p></td>
            <td style="cursor: pointer;" @click="yc2countFun(3)"><p v-show=" xt6count == 3" class="dan">2</p></td>
            <td style="cursor: pointer;" @click="yc2countFun(4)"><p v-show=" xt6count == 4" class="small">3</p></td>
        </tr>
        <tr v-for="(l,k) in data">
            <td class="border-td" v-html="expectFun(l.expect)"></td>
            <td width="35px;" v-bind:class="classFun(l.num1,l.num2,l.num3)" v-text="l.num1"></td>
            <td width="35px;" v-bind:class="classFun(l.num1,l.num2,l.num3)" v-text="l.num2"></td>
            <td class="border-td" width="35px;" v-bind:class="classFun(l.num1,l.num2,l.num3)" v-text="l.num3"></td>
            <td v-bind:class="hmylfcFun(k,i)" class="line-3" v-for="(item,i) in 3" v-html="bluHtml(l.road012[0],k,i,l.miss)"></td>
            <td v-bind:class="hmylfcFun(k,i+3)" class="line-3" v-for="(item,i) in 3" v-html="sluHtml(l.road012[1],k,i,l.miss)"></td>
            <td v-bind:class="hmylfcFun(k,i+6)" class="line-3" v-for="(item,i) in 3" v-html="gluHtml(l.road012[2],k,i,l.miss)"></td>
            <td v-text="l.road012"></td>
            <td v-bind:class="hmylfcFun(k,i+10)" class="line-4" v-for="(item,i) in 4" v-html="lu0Html(l.road0,k,i,l.miss)"></td>
            <td v-bind:class="hmylfcFun(k,i+14)" class="line-4" v-for="(item,i) in 4" v-html="lu1Html(l.road1,k,i,l.miss)"></td>
            <td v-bind:class="hmylfcFun(k,i+18)" class="line-4" v-for="(item,i) in 4" v-html="lu2Html(l.road2,k,i,l.miss)"></td>
        </tr>
        <tr  v-if="indexTime == 2">
            <td>
                {{dateTime}}<a style="color:#ff0000;">{{resetIssue}}</a>
            </td>
            <td colspan="3">
                <div class="td-opentime">
                    剩余<a class="lg-minuteb"></a><b>:</b><a class="lg-secondb"></a>
                </div>
            </td>
            <td style="cursor: pointer;" @click="ycb012Fun(1)"><p v-show=" xt1count == 1" class="big">0</p></td>
            <td style="cursor: pointer;" @click="ycb012Fun(2)"><p v-show=" xt1count == 2" class="shuang">1</p></td>
            <td style="cursor: pointer;" @click="ycb012Fun(3)"><p v-show=" xt1count == 3" class="dan">2</p></td>
            <td style="cursor: pointer;" @click="ycs012Fun(1)"><p v-show=" xt2count == 1" class="big">0</p></td>
            <td style="cursor: pointer;" @click="ycs012Fun(2)"><p v-show=" xt2count == 2" class="shuang">1</p></td>
            <td style="cursor: pointer;" @click="ycs012Fun(3)"><p v-show=" xt2count == 3" class="dan">2</p></td>
            <td style="cursor: pointer;" @click="ycg012Fun(1)"><p v-show=" xt3count == 1" class="big">0</p></td>
            <td style="cursor: pointer;" @click="ycg012Fun(2)"><p v-show=" xt3count == 2" class="shuang">1</p></td>
            <td style="cursor: pointer;" @click="ycg012Fun(3)"><p v-show=" xt3count == 3" class="dan">2</p></td>
            <td style="cursor: pointer;">-</td>
            <td style="cursor: pointer;" @click="yc0countFun(1)"><p v-show=" xt4count == 1" class="big">0</p></td>
            <td style="cursor: pointer;" @click="yc0countFun(2)"><p v-show=" xt4count == 2" class="shuang">1</p></td>
            <td style="cursor: pointer;" @click="yc0countFun(3)"><p v-show=" xt4count == 3" class="dan">2</p></td>
            <td style="cursor: pointer;" @click="yc0countFun(4)"><p v-show=" xt4count == 4" class="small">3</p></td>
            <td style="cursor: pointer;" @click="yc1countFun(1)"><p v-show=" xt5count == 1" class="big">0</p></td>
            <td style="cursor: pointer;" @click="yc1countFun(2)"><p v-show=" xt5count == 2" class="shuang">1</p></td>
            <td style="cursor: pointer;" @click="yc1countFun(3)"><p v-show=" xt5count == 3" class="dan">2</p></td>
            <td style="cursor: pointer;" @click="yc1countFun(4)"><p v-show=" xt5count == 4" class="small">3</p></td>
            <td style="cursor: pointer;" @click="yc2countFun(1)"><p v-show=" xt6count == 1" class="big">0</p></td>
            <td style="cursor: pointer;" @click="yc2countFun(2)"><p v-show=" xt6count == 2" class="shuang">1</p></td>
            <td style="cursor: pointer;" @click="yc2countFun(3)"><p v-show=" xt6count == 3" class="dan">2</p></td>
            <td style="cursor: pointer;" @click="yc2countFun(4)"><p v-show=" xt6count == 4" class="small">3</p></td>
        </tr>
        <tr class="tbody-yc" v-if="indexsort == 2">
            <td>
                {{dateTime}}<a style="color:deeppink;">{{parseInt(resetIssue)+1 < 100?'0'+parseInt(parseInt(resetIssue)+1):parseInt(parseInt(resetIssue)+1) >= 82?'00'+1:parseInt(parseInt(resetIssue)+1)}}</a>
            </td>
            <td colspan="3">-</td>
            <td style="cursor: pointer;" @click="ycb012Fun1(1)"><p v-show=" xt1count1 == 1" class="big">0</p></td>
            <td style="cursor: pointer;" @click="ycb012Fun1(2)"><p v-show=" xt1count1 == 2" class="shuang">1</p></td>
            <td style="cursor: pointer;" @click="ycb012Fun1(3)"><p v-show=" xt1count1 == 3" class="dan">2</p></td>
            <td style="cursor: pointer;" @click="ycs012Fun1(1)"><p v-show=" xt2count1 == 1" class="big">0</p></td>
            <td style="cursor: pointer;" @click="ycs012Fun1(2)"><p v-show=" xt2count1 == 2" class="shuang">1</p></td>
            <td style="cursor: pointer;" @click="ycs012Fun1(3)"><p v-show=" xt2count1 == 3" class="dan">2</p></td>
            <td style="cursor: pointer;" @click="ycg012Fun1(1)"><p v-show=" xt3count1 == 1" class="big">0</p></td>
            <td style="cursor: pointer;" @click="ycg012Fun1(2)"><p v-show=" xt3count1 == 2" class="shuang">1</p></td>
            <td style="cursor: pointer;" @click="ycg012Fun1(3)"><p v-show=" xt3count1 == 3" class="dan">2</p></td>
            <td style="cursor: pointer;">-</td>
            <td style="cursor: pointer;" @click="yc0countFun1(1)"><p v-show=" xt4count1 == 1" class="big">0</p></td>
            <td style="cursor: pointer;" @click="yc0countFun1(2)"><p v-show=" xt4count1 == 2" class="shuang">1</p></td>
            <td style="cursor: pointer;" @click="yc0countFun1(3)"><p v-show=" xt4count1 == 3" class="dan">2</p></td>
            <td style="cursor: pointer;" @click="yc0countFun1(4)"><p v-show=" xt4count1 == 4" class="small">3</p></td>
            <td style="cursor: pointer;" @click="yc1countFun1(1)"><p v-show=" xt5count1 == 1" class="big">0</p></td>
            <td style="cursor: pointer;" @click="yc1countFun1(2)"><p v-show=" xt5count1 == 2" class="shuang">1</p></td>
            <td style="cursor: pointer;" @click="yc1countFun1(3)"><p v-show=" xt5count1 == 3" class="dan">2</p></td>
            <td style="cursor: pointer;" @click="yc1countFun1(4)"><p v-show=" xt5count1 == 4" class="small">3</p></td>
            <td style="cursor: pointer;" @click="yc2countFun1(1)"><p v-show=" xt6count1 == 1" class="big">0</p></td>
            <td style="cursor: pointer;" @click="yc2countFun1(2)"><p v-show=" xt6count1 == 2" class="shuang">1</p></td>
            <td style="cursor: pointer;" @click="yc2countFun1(3)"><p v-show=" xt6count1 == 3" class="dan">2</p></td>
            <td style="cursor: pointer;" @click="yc2countFun1(4)"><p v-show=" xt6count1 == 4" class="small">3</p></td>
        </tr>
        <tr class="tbody-yc" v-if="indexsort == 2">
            <td>
                {{dateTime}}<a style="color:deeppink;">{{parseInt(resetIssue)+2 < 100?'0'+parseInt(parseInt(resetIssue)+2):parseInt(parseInt(resetIssue)+2) >= 82?'00'+2:parseInt(parseInt(resetIssue)+2)}}</a>
            </td>
            <td colspan="3">-</td>
            <td style="cursor: pointer;" @click="ycb012Fun2(1)"><p v-show=" xt1count2 == 1" class="big">0</p></td>
            <td style="cursor: pointer;" @click="ycb012Fun2(2)"><p v-show=" xt1count2 == 2" class="shuang">1</p></td>
            <td style="cursor: pointer;" @click="ycb012Fun2(3)"><p v-show=" xt1count2 == 3" class="dan">2</p></td>
            <td style="cursor: pointer;" @click="ycs012Fun2(1)"><p v-show=" xt2count2 == 1" class="big">0</p></td>
            <td style="cursor: pointer;" @click="ycs012Fun2(2)"><p v-show=" xt2count2 == 2" class="shuang">1</p></td>
            <td style="cursor: pointer;" @click="ycs012Fun2(3)"><p v-show=" xt2count2 == 3" class="dan">2</p></td>
            <td style="cursor: pointer;" @click="ycg012Fun2(1)"><p v-show=" xt3count2 == 1" class="big">0</p></td>
            <td style="cursor: pointer;" @click="ycg012Fun2(2)"><p v-show=" xt3count2 == 2" class="shuang">1</p></td>
            <td style="cursor: pointer;" @click="ycg012Fun2(3)"><p v-show=" xt3count2 == 3" class="dan">2</p></td>
            <td style="cursor: pointer;">-</td>
            <td style="cursor: pointer;" @click="yc0countFun2(1)"><p v-show=" xt4count2 == 1" class="big">0</p></td>
            <td style="cursor: pointer;" @click="yc0countFun2(2)"><p v-show=" xt4count2 == 2" class="shuang">1</p></td>
            <td style="cursor: pointer;" @click="yc0countFun2(3)"><p v-show=" xt4count2 == 3" class="dan">2</p></td>
            <td style="cursor: pointer;" @click="yc0countFun2(4)"><p v-show=" xt4count2 == 4" class="small">3</p></td>
            <td style="cursor: pointer;" @click="yc1countFun2(1)"><p v-show=" xt5count2 == 1" class="big">0</p></td>
            <td style="cursor: pointer;" @click="yc1countFun2(2)"><p v-show=" xt5count2 == 2" class="shuang">1</p></td>
            <td style="cursor: pointer;" @click="yc1countFun2(3)"><p v-show=" xt5count2 == 3" class="dan">2</p></td>
            <td style="cursor: pointer;" @click="yc1countFun2(4)"><p v-show=" xt5count2 == 4" class="small">3</p></td>
            <td style="cursor: pointer;" @click="yc2countFun2(1)"><p v-show=" xt6count2 == 1" class="big">0</p></td>
            <td style="cursor: pointer;" @click="yc2countFun2(2)"><p v-show=" xt6count2 == 2" class="shuang">1</p></td>
            <td style="cursor: pointer;" @click="yc2countFun2(3)"><p v-show=" xt6count2 == 3" class="dan">2</p></td>
            <td style="cursor: pointer;" @click="yc2countFun2(4)"><p v-show=" xt6count2 == 4" class="small">3</p></td>
        </tr>
        </tbody>
        <thead>
        <tr>
            <td rowspan="2" width="100px;" class="sort-img" @click="sortImg()">
                <span>期数</span>
                <span  v-bind:class="index?'sort-img-down':'sort-img-up'"></span>
            </td>
            <td rowspan="2" colspan="3" width="90px;">开奖号</td>
            <td width="50px;" v-for="k in 3"  v-text="k-1"></td>
            <td width="50px;" v-for="k in 3"  v-text="k-1"></td>
            <td width="50px;" v-for="k in 3"  v-text="k-1"></td>
            <td rowspan="2">012路单选</td>
            <td width="50px;" v-for="k in 4"  v-text="k-1"></td>
            <td width="50px;" v-for="k in 4"  v-text="k-1"></td>
            <td width="50px;" v-for="k in 4"  v-text="k-1"></td>
        </tr>
        <tr>
            <td colspan="3">百位012路</td>
            <td colspan="3">十位012路</td>
            <td colspan="3">个位012路</td>
            <td colspan="4">0路个数</td>
            <td colspan="4">1路个数</td>
            <td colspan="4">2路个数</td>
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