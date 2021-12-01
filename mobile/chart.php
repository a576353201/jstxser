
<style>

</style>

<div class="query-area">

    <div class="query-result" style="width: 100%">
        <table id="chartsTable" width="100%" border="0" cellpadding="0" cellspacing="1" class="query-table">
            <thead id="LotteryHeadLines">
            </thead>
            <tbody id="LotteryLines">
            </tbody>
        </table>
    </div>
</div>
</body>
<script type="text/javascript" src="../static/js/jquery-1.9.1.js"></script>
<script src="static/chart/line.js"></script>
<script type="text/javascript">

    function danhaoList() {

        var wei_num=parseInt(wanfa_key2);
        removeline();
        var nols = $("div[class^='ball1']");
        $.each(nols, function (i, n) {
            n.style.display = 'none';
        });


        $("#LotteryHeadLines").html("");
        $("#LotteryLines").html("");


        d=lotteryDate;
        var LotteryHeadLines = "";
        var LotteryLines = "";
        var min = 0;
        var max = 9;
        var count = 10;
        var ballNum = 5;
        var strheader = "<tr>";
        strheader += "<td rowspan=\"2\" style=\"width:100px;\">期号</td>";
        //  strheader += "<td rowspan=\"2\" style=\"width:100px;\">开奖号码</td>";
        if (gametype=='ssc' || gametype=='dp') {
            min = 0;
            max = 9;
            count = 10;
            ballNum = 1;

            var strheader = "<tr>";
            strheader += "<td style=\"width:60px;\">期号</td>";
            //    strheader += "<td rowspan=\"2\" style=\"width:100px;\">开奖号码</td>";
            // strheader += "<td colspan=\"" + count + "\">"+wei[wei_num]+"</td>";

            //  strheader += "</tr>";
            //  strheader += "<tr>";
            for (var j = 0; j < ballNum; j++) {
                for (var k = min; k <= max; k++) {
                    strheader += "<td>" + k + "</td>";
                }
            }
            strheader += "</tr>";
            LotteryHeadLines = strheader;
            $("#LotteryHeadLines").html(LotteryHeadLines);
        }
        if (gametype=='11x5') {
            min = 1;
            max = 11;
            count = 11;
            ballNum = 1;
            var strheader = "<tr>";
            strheader += "<td style=\"width:60px;\">期号</td>";

            for (var k = min; k <= max; k++) {
                if(k<10) var tt='0';
                else var tt='';
                strheader += "<td>" +tt+ k + "</td>";
            }

            strheader += "</tr>";

            LotteryHeadLines = strheader;
            $("#LotteryHeadLines").html(LotteryHeadLines);
        }
        if (gametype=='k3') {
            min = 1;
            max = 6;
            count = 10;
            ballNum = 3;
            var strheader = "<tr>";
            strheader += "<td  style=\"width:100px;\">期号</td>";



            for (var k = min; k <= max; k++) {

                strheader += "<td>" + k + "</td>";
            }
            strheader += "</tr>";
            LotteryHeadLines = strheader;
            $("#LotteryHeadLines").html(LotteryHeadLines);
        }
        if (gametype=='pk10') {
            min = 1;
            max = 10;
            count = 10;
            ballNum = 1;
            var strheader = "<tr>";
            strheader += "<td style=\"width:60px;\">期号</td>";

            for (var k = min; k <= max; k++) {
                if(k<10) var tt='0';
                else var tt='';
                strheader += "<td>" +tt+ k + "</td>";
            }

            strheader += "</tr>";

            LotteryHeadLines = strheader;
            $("#LotteryHeadLines").html(LotteryHeadLines);
        }

        var countArray = new Array();
        var MaxNum = new Array();
        var MaxNumArray = new Array();
        var MaxLostNum = new Array();
        var strArray = new Array();
        var numArray = new Array();
        for (var i = wei_num; i < wei_num+1; i++) {
            countArray[i] = new Array();
            MaxNum[i] = new Array();
            MaxNumArray[i] = new Array();
            MaxLostNum[i] = new Array();
            strArray[i] = new Array();
            numArray[i] = new Array();
            for (var j = min; j <= max; j++) {
                countArray[i][j] = 0;
                MaxNum[i][j] = 0;
                MaxNumArray[i][j] = 0;
                MaxLostNum[i][j] = 0;
                strArray[i][j] = 0;
                numArray[i][j] = 0;
            }
        }
        if (d.table.length>0)
            $("#name").html(d.table[0].name);

        for (var i = 0; i < d.table.length; i++) {
            var dt = d.table[i];
            var num0;
            var str = dt.title;
            str = qistr(str);
            var str2 = dt.number;
            var strArray2 = str2.split(',');

            var str3 = "<tr>";
            str3 += "<td class=\"issue\">";
            str3 += str;
            str3 += "</td>";
            // str3 += "<td align=\"center\" class=\"tdwth\">";
            //   str3 += str2;
            //   str3 += "</td>";

            for (var j = wei_num; j < wei_num+1; j++) {
                num0 = min;
                while (num0 <= max) {
                    if (num0 == parseInt(strArray2[j])) {
                        countArray[j][num0]++;
                        numArray[j][num0] = -1;
                        MaxNumArray[j][num0]++;
                        if (MaxNum[j][num0] < MaxNumArray[j][num0])
                            MaxNum[j][num0] = MaxNumArray[j][num0];
                    }
                    else {
                        MaxNumArray[j][num0] = 0;
                        numArray[j][num0]++;
                        if (MaxLostNum[j][num0] < numArray[j][num0])
                            MaxLostNum[j][num0] = numArray[j][num0];
                    }
                    if (num0 == parseInt(strArray2[j])) {
                        str3 += "<td class=\"charball td0\"><div class=\"ball01\">" + strArray2[j] +
                            "</div></td>";
                        numArray[j][num0]++;
                    }
                    else {
                        str3 += "<td class=\"wdh td0\"><div class=\"ball14\">" + numArray[j][num0] +
                            "</div></td>";

                    }
                    num0++;
                }
            }
            str3 += "</tr>";
            LotteryLines += str3;

        }

        var str4 = "<tr class='color2'>";
        str4 += "<td >";
        str4 += "最大连出";
        str4 += "</td>";

        for (var j = wei_num; j < wei_num+1; j++) {
            var num0 = min;
            while (num0 <= max) {
                str4 += "<td >" + MaxNum[j][num0] + "</td>";
                num0++;
            }
        }
        str4 += "</tr>";


        var str5 = "<tr class='color3'>";
        str5 += "<td >";
        str5 += "最大遗漏";
        str5 += "</td>";

        for (var j = wei_num; j < wei_num+1; j++) {
            var num0 = min;
            while (num0 <= max) {
                str5 += "<td >" + MaxLostNum[j][num0] + "</td>";
                num0++;
            }
        }
        str5 += "</tr>";

        var str6 = "<tr class='color1'>";
        str6 += "<td >";
        str6 += "出现次数";
        str6 += "</td>";

        for (var j = wei_num; j < wei_num+1; j++) {
            var num0 = min;
            while (num0 <= max) {
                str6 += "<td >" + countArray[j][num0] + "</td>";
                num0++;
            }
        }
        str6 += "</tr>";


        var str7 = "<tr class='color4'>";
        str7 += "<td >";
        str7 += "平均遗漏";
        str7 += "</td>";

        for (var j = wei_num; j < wei_num+1; j++) {
            var num0 = min;
            while (num0 <= max) {
                if(countArray[j][num0]>0)
                    var tt= (d.table.length-countArray[j][num0])/countArray[j][num0];
                else
                    var tt= d.table.length;
                tt=parseInt(tt);
                str7 += "<td >" +tt + "</td>";
                num0++;
            }
        }
        str7 += "</tr>";

        LotteryLines += str6 + str4 + str5+str7+strheader;

        $("#LotteryLines").html(LotteryLines);


        if ($("#chartsTable").width() > $('body').width()) {
            $('body').width(($("#chartsTable").width() + 30) + "px");
            $('.history_code').css("width", $("#chartsTable").width() + "px");
        }




        Chart.init();
        DrawLine.bind("chartsTable", "has_line");
        DrawLine.color('#5250ae');
        DrawLine.add((parseInt(0) * count + 1 ), 1, count, 0);

        //  console.log(Chart.ini.default_has_line);
        DrawLine.draw(Chart.ini.default_has_line);



        window.scroll(0, 999999);
        var show = false;
        var nols = $("div[class^='ball1']");
        $("#no_miss").click(function () {
            show = !show;
            $.each(nols, function (i, n) {
                if (show == true) {
                    n.style.display = 'none';
                } else {
                    n.style.display = 'block';
                }
            });
        });
    }

    function resize() {
        window.onresize = func;
        function func() {
            window.location.href = window.location.href;
        }
    }

    function  removeline() {
        var removeObj = document.querySelector('body').querySelectorAll('canvas');
        for(var t=0;t<removeObj.length;t++){

            removeObj[t].parentNode.removeChild(removeObj[t])

        }
    }

    function GetQueryString(name) {
        var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)", "i");
        var r = window.location.search.substr(1).match(reg);
        if (r != null)
            return unescape(r[2]);
        return null;
    }


    function Lot_New(arr,begin,to){
        var arr11=Array();
        for(var i=begin;i<to+1;i++){

            arr11[arr11.length]=arr[i];
        }
        return arr11;

    }

    function in_arr_num(arr,str) {
        var num=0;
        for(var i=0;i<arr.length;i++){

            if(arr[i]==str) num++;
        }
        return num;
    }



    function duohaoList() {

        var wei_num = wanfa_key2.split('-');

        var wei_from = parseInt(wei_num[0]);
        var wei_to = parseInt(wei_num[1]);

        removeline();
        var nols = $("div[class^='ball1']");
        $.each(nols, function (i, n) {
            n.style.display = 'none';
        });


        $("#LotteryHeadLines").html("");
        $("#LotteryLines").html("");


        d = lotteryDate;
        var LotteryHeadLines = "";
        var LotteryLines = "";
        var min = 0;
        var max = 9;
        var count = 10;
        var ballNum = 5;
        var strheader = "<tr>";
        strheader += "<td rowspan=\"2\" style=\"width:100px;\">期号</td>";


        min = 0;
        max = 9;
        count = 10;
        ballNum = 1;

        if(gametype=='11x5'){
            min=1;max=11;
        }
        if(gametype=='k3'){
            min=1;max=6;
        }
        if(gametype=='pk10'){
            min=1;max=10;
        }



        var strheader = "<tr>";
        strheader += "<td style=\"width:60px;\">期号</td>";

        for (var k = min; k <= max; k++) {

            if(k<10 && gametype=='11x5') var tt='0';
            else var tt='';

            strheader += "<td>" +tt+ k + "</td>";
        }

        strheader += "</tr>";
        LotteryHeadLines = strheader;
        $("#LotteryHeadLines").html(LotteryHeadLines);


        var countArray = new Array();
        var MaxNum = new Array();
        var MaxNumArray = new Array();
        var MaxLostNum = new Array();
        var strArray = new Array();
        var numArray = new Array();


        for (var j = min; j <= max; j++) {
            countArray[j] = 0;
            MaxNum[j] = 0;
            MaxNumArray[j] = 0;
            MaxLostNum[j] = 0;
            strArray[j] = 0;
            numArray[j] = 0;
        }

        if (d.table.length > 0)
            $("#name").html(d.table[0].name);

        for (var i = 0; i < d.table.length; i++) {
            var dt = d.table[i];
            var num0;
            var str = dt.title;
            str = qistr(str);
            var str2 = dt.number;
            var strArray2 = str2.split(',');
            strArray2 = Lot_New(strArray2,wei_from,wei_to);


            var str3 = "<tr>";
            str3 += "<td class=\"issue\">";
            str3 += str;
            str3 += "</td>";
            // str3 += "<td align=\"center\" class=\"tdwth\">";
            //   str3 += str2;
            //   str3 += "</td>";

            num0 = min;
            while (num0 <= max) {


                var temp = in_arr_num(strArray2, num0);
                if (temp>0) {
                    countArray[num0]= countArray[num0]+temp;
                    numArray[num0] = -1;
                    MaxNumArray[num0]++;
                    if (MaxNum[num0] < MaxNumArray[num0])
                        MaxNum[num0] = MaxNumArray[num0];
                }
                else {
                    MaxNumArray[num0] = 0;
                    numArray[num0]++;
                    if (MaxLostNum[num0] < numArray[num0])
                        MaxLostNum[num0] = numArray[num0];
                }

                if (temp > 0) {
                    if(temp>1) var times_str='<span class="times">'+temp+'</span>';
                    else var times_str='';
                    if(num0<10 && gametype=='11x5') var tt='0';
                    else var tt='';
                    str3 += "<td class=\"charball td0\"><div class=\"ball01\">"+tt+ num0 + times_str+"</div></td>";
                    numArray[num0]++;
                }
                else {
                    str3 += "<td class=\"wdh td0\"><div class=\"ball14\">" + numArray[num0] + "</div></td>";

                }
                num0++;
            }
            str3 += "</tr>";
            LotteryLines += str3;
        }


        var str4 = "<tr class='color2'>";
        str4 += "<td >";
        str4 += "最大连出";
        str4 += "</td>";


        var num0 = min;
        while (num0 <= max) {
            str4 += "<td >" + MaxNum[num0] + "</td>";
            num0++;
        }

        str4 += "</tr>";


        var str5 = "<tr class='color3'>";
        str5 += "<td >";
        str5 += "最大遗漏";
        str5 += "</td>";


        var num0 = min;
        while (num0 <= max) {
            str5 += "<td >" + MaxLostNum[num0] + "</td>";
            num0++;
        }

        str5 += "</tr>";

        var str6 = "<tr class='color1'>";
        str6 += "<td >";
        str6 += "出现次数";
        str6 += "</td>";


        var num0 = min;
        while (num0 <= max) {
            str6 += "<td >" + countArray[num0] + "</td>";
            num0++;
        }

        str6 += "</tr>";


        var str7 = "<tr class='color4'>";
        str7 += "<td >";
        str7 += "平均遗漏";
        str7 += "</td>";

        var num0 = min;
        while (num0 <= max) {
            if(countArray[num0]>0)
                var tt= (d.table.length-countArray[num0])/countArray[num0];
            else
                var tt= d.table.length;
            tt=parseInt(tt);
            str7 += "<td >" +tt + "</td>";
            num0++;
        }

        str7 += "</tr>";

        LotteryLines += str6 + str4 + str5+str7+strheader;

        $("#LotteryLines").html(LotteryLines);




        window.scroll(0, 999999);

    }

    function qistr(str) {

        if (str.length > 8) str = str.substr(6, str.length - 6);
        else if (str.length > 3) str = str.substr(3, str.length - 3);
        return str;
    }

    function dxList(type) {


        removeline();
        var wei_num = wanfa_key2.split('-');

        var wei_from = parseInt(wei_num[0]);
        var wei_to = parseInt(wei_num[1]);

        $("#LotteryHeadLines").html("");
        $("#LotteryLines").html("");


        d = lotteryDate;
        var LotteryHeadLines = "";
        var LotteryLines = "";
        var min = 0;
        var max = 9;
        var count = 10;
        var ballNum = 5;



        min = 0;
        max = 5;
        count = 10;
        ballNum = 1;

        var strheader = "<tr>";
        strheader += "<td style=\"width:60px;\">期号</td>";

        for (var j = 0; j < wanfa_title2.length; j++) {
            strheader+="<td class='noborder'>"+wanfa_title2.substr(j,1)+"</td>";
        }


        for (var j = 0; j < wanfa_title2.length; j++) {

            strheader += "<td colspan='2'>" + wanfa_title2.substr(j,1) + "位</td>";

        }
        strheader += "</tr>";
        LotteryHeadLines = strheader;
        $("#LotteryHeadLines").html(LotteryHeadLines);


        var countArray = new Array();
        var MaxNum = new Array();
        var MaxNumArray = new Array();
        var MaxLostNum = new Array();
        var strArray = new Array();
        var numArray = new Array();


        for (var j = min; j <= max; j++) {
            countArray[j] = 0;
            MaxNum[j] = 0;
            MaxNumArray[j] = 0;
            MaxLostNum[j] = 0;
            strArray[j] = 0;
            numArray[j] = 0;
        }

        if (d.table.length > 0) $("#name").html(d.table[0].name);

        for (var i = 0; i < d.table.length; i++) {
            var dt = d.table[i];
            var num0;
            var str = dt.title;
            str = qistr(str);
            var str2 = dt.number;
            var strArray2 = str2.split(',');
            strArray2 = Lot_New(strArray2,wei_from,wei_to);


            var str3 = "<tr>";
            str3 += "<td class=\"issue\">";
            str3 += str;
            str3 += "</td>";

            num0 = min;
            for(var tt=0;tt<strArray2.length;tt++){
                str3+="<td class='noborder'>"+strArray2[tt]+"</td>";
            }




            for(var j=0;j<3;j++){

                for(var k=0;k<2;k++){
                    code=parseInt(strArray2[j]);
                    num0=2*j+k;
                    if(k==0){

                        if((type=='ds' && code%2==1) || (type=='dx' && (((gametype=='ssc' || gametype=='dp') && code>=5) || (gametype=='11x5'
                                && code>=7)|| (gametype=='k3' && code>=4) || (gametype=='pk10' && code>=6))) ){

                            var sta=1;
                            if(type=='ds') var showname='单';
                            else var showname='大';
                        }else sta=0;







                    }else{
                        if((type=='ds' && code%2==0) || (type=='dx' &&  (((gametype=='ssc' || gametype=='dp')  && code<5) || (gametype=='11x5'
                                && code<7) || (gametype=='k3' && code<4)|| (gametype=='pk10' && code<6))) ){

                            var sta=1;
                            if(type=='ds') var showname='双';
                            else var showname='小';
                        }else sta=0;

                    }

                    if (sta==1) {
                        countArray[num0]++;
                        numArray[num0] = -1;
                        MaxNumArray[num0]++;
                        if (MaxNum[num0] < MaxNumArray[num0])
                            MaxNum[num0] = MaxNumArray[num0];

                        str3 += "<td class='numbg"+k+"'>"+showname+"</td>";
                    }
                    else {
                        MaxNumArray[num0] = 0;
                        numArray[num0]++;
                        if (MaxLostNum[num0] < numArray[num0])
                            MaxLostNum[num0] = numArray[num0];

                        str3 += "<td class=\"wdh td0\">"+numArray[num0]+"</td>";

                    }

                }

            }


            str3 += "</tr>";
            LotteryLines += str3;
        }


        var str4 = "<tr class='color2'>";
        str4 += "<td >";
        str4 += "最大连出";
        str4 += "</td><td colspan='3'></td>";


        var num0 = min;
        while (num0 <= max) {
            str4 += "<td >" + MaxNum[num0] + "</td>";
            num0++;
        }

        str4 += "</tr>";


        var str5 = "<tr class='color3'>";
        str5 += "<td >";
        str5 += "最大遗漏";
        str5 += "</td><td colspan='3'></td>";


        var num0 = min;
        while (num0 <= max) {
            str5 += "<td >" + MaxLostNum[num0] + "</td>";
            num0++;
        }

        str5 += "</tr>";

        var str6 = "<tr class='color1'>";
        str6 += "<td >";
        str6 += "出现次数";
        str6 += "</td><td colspan='3'></td>";


        var num0 = min;
        while (num0 <= max) {
            str6 += "<td >" + countArray[num0] + "</td>";
            num0++;
        }

        str6 += "</tr>";


        var str7 = "<tr class='color4'>";
        str7 += "<td >";
        str7 += "平均遗漏";
        str7 += "</td><td colspan='3'></td>";

        var num0 = min;
        while (num0 <= max) {
            if(countArray[num0]>0)
                var tt= (d.table.length-countArray[num0])/countArray[num0];
            else
                var tt= d.table.length;
            tt=parseInt(tt);
            str7 += "<td >" +tt + "</td>";
            num0++;
        }

        str7 += "</tr>";

        LotteryLines += str6 + str4 + str5+str7+strheader;

        $("#LotteryLines").html(LotteryLines);




        window.scroll(0, 999999);

    }
    function arr_sum( arr ) {
        var sum=0;
        for(var i=0;i<arr.length;i++){
            sum+=parseInt(arr[i]);
        }
        return sum;
    }

    function arr_kd( arr ) {
        var sum=0;
        for(var i=0;i<arr.length-1;i++){
            for(var j=i+1;j<arr.length;j++){
                var cha=arr[i]-arr[j];
                if(cha<0) cha=-cha;
                if(cha>sum) sum=cha;
            }
        }
        return sum;
    }



    function hz5xList() {


        removeline();

        $("#LotteryHeadLines").html("");
        $("#LotteryLines").html("");


        d = lotteryDate;
        var LotteryHeadLines = "";
        var LotteryLines = "";
        var min = 0;
        var max = 9;


        min = 0;
        max = 3;


        var strheader = "<tr>";
        strheader += "<td style=\"width:60px;\">期号</td>";
        strheader+="<td class='noborder'>万</td>";
        strheader+="<td class='noborder'>千</td>";
        strheader+="<td class='noborder'>百</td>";
        strheader+="<td class='noborder'>十</td>";
        strheader+="<td class='noborder'>个</td>";
        strheader+="<td>";
        strheader +=  "和值";
        strheader+="</td>";
        strheader+="<td colspan='4'>";
        strheader +=  "和值形态";
        strheader+="</td>";


        strheader += "</tr>";
        LotteryHeadLines = strheader;
        $("#LotteryHeadLines").html(LotteryHeadLines);


        var countArray = new Array();
        var MaxNum = new Array();
        var MaxNumArray = new Array();
        var MaxLostNum = new Array();
        var strArray = new Array();
        var numArray = new Array();


        for (var j = min; j <= max; j++) {
            countArray[j] = 0;
            MaxNum[j] = 0;
            MaxNumArray[j] = 0;
            MaxLostNum[j] = 0;
            strArray[j] = 0;
            numArray[j] = 0;
        }

        if (d.table.length > 0) $("#name").html(d.table[0].name);

        for (var i = 0; i < d.table.length; i++) {
            var dt = d.table[i];
            var num0;
            var str = dt.title;
            str = qistr(str);
            var str2 = dt.number;
            var strArray2 = str2.split(',');



            var str3 = "<tr>";
            str3 += "<td class=\"issue\">";
            str3 += str;
            str3 += "</td>";

            num0 = min;
            for(var tt=0;tt<strArray2.length;tt++){
                str3+="<td class='noborder'>"+strArray2[tt]+"</td>";
            }


            var sum=arr_sum(strArray2);
            str3+="<td class='numbg4'>"+sum+"</td>";

            var showarr=new Array('大','小','单','双');
            for(var j=0;j<4;j++){


                code=parseInt(strArray2[j]);
                num0=j;

                if((j==0 && code>5) || (j==1 && code<5) || (j==2 && code%2==1) || (j==3 && code%2==0) ){

                    var sta=1;
                    var showname=showarr[j];
                }else sta=0;



                if (sta==1) {
                    countArray[num0]++;
                    numArray[num0] = -1;
                    MaxNumArray[num0]++;
                    if (MaxNum[num0] < MaxNumArray[num0])
                        MaxNum[num0] = MaxNumArray[num0];

                    str3 += "<td class='numbg"+j+"'>"+showname+"</td>";
                }
                else {
                    MaxNumArray[num0] = 0;
                    numArray[num0]++;
                    if (MaxLostNum[num0] < numArray[num0])
                        MaxLostNum[num0] = numArray[num0];

                    str3 += "<td class=\"wdh td0\">"+numArray[num0]+"</td>";

                }



            }


            str3 += "</tr>";
            LotteryLines += str3;
        }


        var str4 = "<tr class='color2'>";
        str4 += "<td >";
        str4 += "最大连出";
        str4 += "</td><td colspan='6'></td>";


        var num0 = min;
        while (num0 <= max) {
            str4 += "<td >" + MaxNum[num0] + "</td>";
            num0++;
        }

        str4 += "</tr>";


        var str5 = "<tr class='color3'>";
        str5 += "<td >";
        str5 += "最大遗漏";
        str5 += "</td><td colspan='6'></td>";


        var num0 = min;
        while (num0 <= max) {
            str5 += "<td >" + MaxLostNum[num0] + "</td>";
            num0++;
        }

        str5 += "</tr>";

        var str6 = "<tr class='color1'>";
        str6 += "<td >";
        str6 += "出现次数";
        str6 += "</td><td colspan='6'></td>";


        var num0 = min;
        while (num0 <= max) {
            str6 += "<td >" + countArray[num0] + "</td>";
            num0++;
        }

        str6 += "</tr>";


        var str7 = "<tr class='color4'>";
        str7 += "<td >";
        str7 += "平均遗漏";
        str7 += "</td><td colspan='6'></td>";

        var num0 = min;
        while (num0 <= max) {
            if(countArray[num0]>0)
                var tt= (d.table.length-countArray[num0])/countArray[num0];
            else
                var tt= d.table.length;
            tt=parseInt(tt);
            str7 += "<td >" +tt + "</td>";
            num0++;
        }

        str7 += "</tr>";

        LotteryLines += str6 + str4 + str5+str7+strheader;

        $("#LotteryLines").html(LotteryLines);




        window.scroll(0, 999999);

    }

    function hzList(type) {


        removeline();

        $("#LotteryHeadLines").html("");
        $("#LotteryLines").html("");


        d = lotteryDate;
        var LotteryHeadLines = "";
        var LotteryLines = "";
        var min = 0;
        var max = 9;


        min = 0;
        max = 3;


        var strheader = "<tr>";
        strheader += "<td style=\"width:60px;\">期号</td>";
        strheader+="<td class='noborder'>万</td>";
        strheader+="<td class='noborder'>千</td>";
        strheader+="<td class='noborder'>百</td>";
        strheader+="<td class='noborder'>十</td>";
        strheader+="<td class='noborder'>个</td>";
        if(type=='hz') var typename='和值';
        else var typename='跨度';

        strheader+="<td class='f12'>前二<br>"+typename+"</td>";
        strheader+="<td class='f12'>前三<br>"+typename+"</td>";
        strheader+="<td class='f12'>中三<br>"+typename+"</td>";
        strheader+="<td class='f12'>后三<br>"+typename+"</td>";
        strheader+="<td class='f12'>后二<br>"+typename+"</td>";
        strheader += "</tr>";
        LotteryHeadLines = strheader;
        $("#LotteryHeadLines").html(LotteryHeadLines);



        if (d.table.length > 0) $("#name").html(d.table[0].name);

        for (var i = 0; i < d.table.length; i++) {
            var dt = d.table[i];
            var num0;
            var str = dt.title;
            str = qistr(str);
            var str2 = dt.number;
            var strArray2 = str2.split(',');



            var str3 = "<tr>";
            str3 += "<td class=\"issue\">";
            str3 += str;
            str3 += "</td>";

            num0 = min;
            for(var tt=0;tt<strArray2.length;tt++){
                str3+="<td class='noborder'>"+strArray2[tt]+"</td>";
            }


            var showarr=new Array('0-1','0-2','1-3','2-4','3-4');
            for(var j=0;j<5;j++){
                var weinum=showarr[j].split('-');

                var codearr=Lot_New(strArray2,parseInt(weinum[0]),parseInt(weinum[1]));
                if(type=='hz')
                    var sum=arr_sum(codearr);
                else var sum=arr_kd(codearr);
                str3 += "<td class='numbg"+j+"'>"+sum+"</td>";



            }


            str3 += "</tr>";
            LotteryLines += str3;
        }

        LotteryLines+=strheader;

        $("#LotteryLines").html(LotteryLines);




        window.scroll(0, 999999);

    }


    function lhhList(type) {


        removeline();
        var wei_num = wanfa_key2.split('-');

        var wei_from =wei_num[0];
        var wei_to = wei_num[1];

        $("#LotteryHeadLines").html("");
        $("#LotteryLines").html("");


        d = lotteryDate;
        var LotteryHeadLines = "";
        var LotteryLines = "";
        var min = 0;
        var max = 9;
        var count = 10;
        var ballNum = 5;



        min = 0;
        max = 5;
        count = 10;
        ballNum = 1;

        var strheader = "<tr>";
        strheader += "<td style=\"width:60px;\">期号</td>";

        for (var j = 0; j <2; j++) {
            strheader+="<td class='noborder'>"+wanfa_title2.substr(j,1)+"</td>";
        }

        strheader+="<td >龙</td><td >和</td><td >虎</td>";
        for (var j = 3; j <5; j++) {
            strheader+="<td class='noborder'>"+wanfa_title2.substr(j,1)+"</td>";
        }
        strheader+="<td >龙</td><td >和</td><td >虎</td>";

        strheader += "</tr>";
        LotteryHeadLines = strheader;
        $("#LotteryHeadLines").html(LotteryHeadLines);


        var countArray = new Array();
        var MaxNum = new Array();
        var MaxNumArray = new Array();
        var MaxLostNum = new Array();
        var strArray = new Array();
        var numArray = new Array();


        for (var j = min; j <= max; j++) {
            countArray[j] = 0;
            MaxNum[j] = 0;
            MaxNumArray[j] = 0;
            MaxLostNum[j] = 0;
            strArray[j] = 0;
            numArray[j] = 0;
        }

        if (d.table.length > 0) $("#name").html(d.table[0].name);

        for (var i = 0; i < d.table.length; i++) {
            var dt = d.table[i];
            var num0;
            var str = dt.title;
            str = qistr(str);
            var str2 = dt.number;
            var strArray2 = str2.split(',');



            var str3 = "<tr>";
            str3 += "<td class=\"issue\">";
            str3 += str;
            str3 += "</td>";

            num0 = min;
            var showarr=new Array('龙','和','虎');
            var arr1= new Array(strArray2[parseInt(wei_from.substr(0,1))],strArray2[parseInt(wei_from.substr(1,1))]);

            for(var tt=0;tt<arr1.length;tt++){
                str3+="<td class='noborder'>"+arr1[tt]+"</td>";
            }
            var code1=parseInt(arr1[0]);
            var code2=parseInt(arr1[1]);
            for(var j=0;j<3;j++){

                num0=j;


                if((j%3==0 && code1>code2) || (j%3==1 && code1==code2) || (j%3==2 && code1<code2) ){

                    var sta=1;
                    var showname=showarr[j%3];
                }else sta=0;


                if (sta==1) {
                    countArray[num0]++;
                    numArray[num0] = -1;
                    MaxNumArray[num0]++;
                    if (MaxNum[num0] < MaxNumArray[num0])
                        MaxNum[num0] = MaxNumArray[num0];

                    str3 += "<td class='numbg"+j%3+"'>"+showname+"</td>";
                }
                else {
                    MaxNumArray[num0] = 0;
                    numArray[num0]++;
                    if (MaxLostNum[num0] < numArray[num0])
                        MaxLostNum[num0] = numArray[num0];

                    str3 += "<td class=\"wdh td0\">"+numArray[num0]+"</td>";

                }



            }



            var arr1= new Array(strArray2[parseInt(wei_to.substr(0,1))],strArray2[parseInt(wei_to.substr(1,1))]);


            for(var tt=0;tt<arr1.length;tt++){
                str3+="<td class='noborder'>"+arr1[tt]+"</td>";
            }

            var code1=parseInt(arr1[0]);
            var code2=parseInt(arr1[1]);
            for(var j=3;j<6;j++){

                num0=j;


                if((j%3==0 && code1>code2) || (j%3==1 && code1==code2) || (j%3==2 && code1<code2) ){

                    var sta=1;
                    var showname=showarr[j%3];
                }else sta=0;


                if (sta==1) {
                    countArray[num0]++;
                    numArray[num0] = -1;
                    MaxNumArray[num0]++;
                    if (MaxNum[num0] < MaxNumArray[num0])
                        MaxNum[num0] = MaxNumArray[num0];

                    str3 += "<td class='numbg"+j%3+"'>"+showname+"</td>";
                }
                else {
                    MaxNumArray[num0] = 0;
                    numArray[num0]++;
                    if (MaxLostNum[num0] < numArray[num0])
                        MaxLostNum[num0] = numArray[num0];

                    str3 += "<td class=\"wdh td0\">"+numArray[num0]+"</td>";

                }




            }





            str3 += "</tr>";
            LotteryLines += str3;
        }


        var str4 = "<tr class='color2'>";
        str4 += "<td >";
        str4 += "最大连出";
        str4 += "</td><td colspan='2'></td>";


        var num0 = min;
        while (num0 <= max) {
            str4 += "<td >" + MaxNum[num0] + "</td>";
            if(num0==2) str4 += "<td colspan='2'></td>";
            num0++;
        }

        str4 += "</tr>";


        var str5 = "<tr class='color3'>";
        str5 += "<td >";
        str5 += "最大遗漏";
        str5 += "</td><td colspan='2'></td>";


        var num0 = min;
        while (num0 <= max) {
            str5 += "<td >" + MaxLostNum[num0] + "</td>";
            if(num0==2) str5 += "<td colspan='2'></td>";
            num0++;
        }

        str5 += "</tr>";

        var str6 = "<tr class='color1'>";
        str6 += "<td >";
        str6 += "出现次数";
        str6 += "</td><td colspan='2'></td>";


        var num0 = min;
        while (num0 <= max) {
            str6 += "<td >" + countArray[num0] + "</td>";
            if(num0==2) str6 += "<td colspan='2'></td>";
            num0++;
        }

        str6 += "</tr>";


        var str7 = "<tr class='color4'>";
        str7 += "<td >";
        str7 += "平均遗漏";
        str7 += "</td><td colspan='2'></td>";

        var num0 = min;
        while (num0 <= max) {
            if(countArray[num0]>0)
                var tt= (d.table.length-countArray[num0])/countArray[num0];
            else
                var tt= d.table.length;
            tt=parseInt(tt);
            str7 += "<td >" +tt + "</td>";
            if(num0==2) str7 += "<td colspan='2'></td>";
            num0++;
        }

        str7 += "</tr>";

        LotteryLines += str6 + str4 + str5+str7+strheader;

        $("#LotteryLines").html(LotteryLines);




        window.scroll(0, 999999);

    }

    function hmdsList() {


        removeline();

        $("#LotteryHeadLines").html("");
        $("#LotteryLines").html("");


        d = lotteryDate;
        var LotteryHeadLines = "";
        var LotteryLines = "";
        var min = 0;
        var max = 9;


        min = 0;
        max = 5;


        var strheader = "<tr>";
        strheader += "<td style=\"width:60px;\">期号</td>";
        strheader+="<td class='noborder'>一</td>";
        strheader+="<td class='noborder'>二</td>";
        strheader+="<td class='noborder'>三</td>";
        strheader+="<td class='noborder'>四</td>";
        strheader+="<td class='noborder'>五</td>";
        strheader+="<td >5:0</td>";
        strheader+="<td >4:1</td>";
        strheader+="<td >3:2</td>";
        strheader+="<td >2:3</td>";
        strheader+="<td >1:4</td>";
        strheader+="<td >0:5</td>";

        strheader += "</tr>";
        LotteryHeadLines = strheader;
        $("#LotteryHeadLines").html(LotteryHeadLines);


        var countArray = new Array();
        var MaxNum = new Array();
        var MaxNumArray = new Array();
        var MaxLostNum = new Array();
        var strArray = new Array();
        var numArray = new Array();


        for (var j = min; j <= max; j++) {
            countArray[j] = 0;
            MaxNum[j] = 0;
            MaxNumArray[j] = 0;
            MaxLostNum[j] = 0;
            strArray[j] = 0;
            numArray[j] = 0;
        }

        if (d.table.length > 0) $("#name").html(d.table[0].name);

        for (var i = 0; i < d.table.length; i++) {
            var dt = d.table[i];
            var num0;
            var str = dt.title;
            str = qistr(str);
            var str2 = dt.number;
            var strArray2 = str2.split(',');



            var str3 = "<tr>";
            str3 += "<td class=\"issue\">";
            str3 += str;
            str3 += "</td>";

            num0 = min;
            for(var tt=0;tt<strArray2.length;tt++){
                str3+="<td class='noborder'>"+strArray2[tt]+"</td>";
            }



            var showarr=new Array('5:0','4:1','3:2','2:3','1:4','0:5');
            for(var j=0;j<6;j++){
                var dan=0;
                var shuang=0;
                for(var tt=0;tt<strArray2.length;tt++){

                    if(strArray2[tt]%2==1) dan++;
                    else shuang++;
                }
                code=showarr[j].split(':');
                if(dan==parseInt(code[0])){

                    var sta=1;
                    var showname=showarr[j];
                }else sta=0;



                if (sta==1) {
                    countArray[num0]++;
                    numArray[num0] = -1;
                    MaxNumArray[num0]++;
                    if (MaxNum[num0] < MaxNumArray[num0])
                        MaxNum[num0] = MaxNumArray[num0];

                    str3 += "<td class='numbg"+j+"'>"+showname+"</td>";
                }
                else {
                    MaxNumArray[num0] = 0;
                    numArray[num0]++;
                    if (MaxLostNum[num0] < numArray[num0])
                        MaxLostNum[num0] = numArray[num0];

                    str3 += "<td class=\"wdh td0\">"+numArray[num0]+"</td>";

                }



            }


            str3 += "</tr>";
            LotteryLines += str3;
        }


        var str4 = "<tr class='color2'>";
        str4 += "<td >";
        str4 += "最大连出";
        str4 += "</td><td colspan='5'></td>";


        var num0 = min;
        while (num0 <= max) {
            str4 += "<td >" + MaxNum[num0] + "</td>";
            num0++;
        }

        str4 += "</tr>";


        var str5 = "<tr class='color3'>";
        str5 += "<td >";
        str5 += "最大遗漏";
        str5 += "</td><td colspan='5'></td>";


        var num0 = min;
        while (num0 <= max) {
            str5 += "<td >" + MaxLostNum[num0] + "</td>";
            num0++;
        }

        str5 += "</tr>";

        var str6 = "<tr class='color1'>";
        str6 += "<td >";
        str6 += "出现次数";
        str6 += "</td><td colspan='5'></td>";


        var num0 = min;
        while (num0 <= max) {
            str6 += "<td >" + countArray[num0] + "</td>";
            num0++;
        }

        str6 += "</tr>";


        var str7 = "<tr class='color4'>";
        str7 += "<td >";
        str7 += "平均遗漏";
        str7 += "</td><td colspan='5'></td>";

        var num0 = min;
        while (num0 <= max) {
            if(countArray[num0]>0)
                var tt= (d.table.length-countArray[num0])/countArray[num0];
            else
                var tt= d.table.length;
            tt=parseInt(tt);
            str7 += "<td >" +tt + "</td>";
            num0++;
        }

        str7 += "</tr>";

        LotteryLines += str6 + str4 + str5+str7+strheader;

        $("#LotteryLines").html(LotteryLines);




        window.scroll(0, 999999);

    }


    function hzxtList() {


        removeline();

        $("#LotteryHeadLines").html("");
        $("#LotteryLines").html("");


        d = lotteryDate;
        var LotteryHeadLines = "";
        var LotteryLines = "";
        var min = 0;
        var max = 9;


        min = 0;
        max = 2;


        var strheader = "<tr>";
        strheader += "<td style=\"width:60px;\">期号</td>";
        strheader+="<td class='noborder'>一</td>";
        strheader+="<td class='noborder'>二</td>";
        strheader+="<td class='noborder'>三</td>";
        if(gametype=='dp'){
            strheader+="<td class='f12'>三码<br>和值</td>";
            strheader+="<td class='f12'>前二<br>和值</td>";
            strheader+="<td class='f12'>后二<br>和值</td>";
        }

        else
            strheader+="<td >和值</td>";
        strheader+="<td >三同号</td>";
        strheader+="<td >三不同号</td>";
        strheader+="<td >二同号</td>";


        strheader += "</tr>";
        LotteryHeadLines = strheader;
        $("#LotteryHeadLines").html(LotteryHeadLines);


        var countArray = new Array();
        var MaxNum = new Array();
        var MaxNumArray = new Array();
        var MaxLostNum = new Array();
        var strArray = new Array();
        var numArray = new Array();


        for (var j = min; j <= max; j++) {
            countArray[j] = 0;
            MaxNum[j] = 0;
            MaxNumArray[j] = 0;
            MaxLostNum[j] = 0;
            strArray[j] = 0;
            numArray[j] = 0;
        }

        if (d.table.length > 0) $("#name").html(d.table[0].name);

        for (var i = 0; i < d.table.length; i++) {
            var dt = d.table[i];
            var num0;
            var str = dt.title;
            str = qistr(str);
            var str2 = dt.number;
            var strArray2 = str2.split(',');



            var str3 = "<tr>";
            str3 += "<td class=\"issue\">";
            str3 += str;
            str3 += "</td>";

            num0 = min;
            for(var tt=0;tt<strArray2.length;tt++){
                str3+="<td class='noborder'>"+strArray2[tt]+"</td>";
            }
            var sum=arr_sum(strArray2);
            str3 += "<td class='numbg4'>"+sum+"</td>";
            if(gametype=='dp'){
                sum=parseInt(strArray2[0])+parseInt(strArray2[1]);
                str3 += "<td class='numbg5'>"+sum+"</td>";
                sum=parseInt(strArray2[2])+parseInt(strArray2[1]);
                str3 += "<td class='numbg3'>"+sum+"</td>";
            }


            var showarr=new Array('三同号','三不同号','二同号');
            if(gametype=='dp')showarr=new Array('豹子','组六','组三');
            for(var j=0;j<3;j++){



                if(strArray2[0]==strArray2[1] && strArray2[1]==strArray2[2] ){

                    if(j==0) var sta=1;
                    else sta=0;

                }else if(strArray2[0]!=strArray2[1] && strArray2[1]!=strArray2[2] && strArray2[0]!=strArray2[2]) {

                    if(j==1) var sta=1;
                    else sta=0;
                }
                else{
                    if(j==2) var sta=1;
                    else sta=0;
                }


                var showname=showarr[j];
                num0=j;
                if (sta==1) {
                    countArray[num0]++;
                    numArray[num0] = -1;
                    MaxNumArray[num0]++;
                    if (MaxNum[num0] < MaxNumArray[num0])
                        MaxNum[num0] = MaxNumArray[num0];

                    str3 += "<td class='numbg"+j+"'>"+showname+"</td>";
                }
                else {
                    MaxNumArray[num0] = 0;
                    numArray[num0]++;
                    if (MaxLostNum[num0] < numArray[num0])
                        MaxLostNum[num0] = numArray[num0];

                    str3 += "<td class=\"wdh td0\">"+numArray[num0]+"</td>";

                }



            }


            str3 += "</tr>";
            LotteryLines += str3;
        }


        var str4 = "<tr class='color2'>";
        str4 += "<td >";
        str4 += "最大连出";
        str4 += "</td><td colspan='4'></td>";
        if(gametype=='dp'){
            str4 += "<td colspan='2'></td>";
        }


        var num0 = min;
        while (num0 <= max) {
            str4 += "<td >" + MaxNum[num0] + "</td>";
            num0++;
        }

        str4 += "</tr>";


        var str5 = "<tr class='color3'>";
        str5 += "<td >";
        str5 += "最大遗漏";
        str5 += "</td><td colspan='4'></td>";
        if(gametype=='dp'){
            str5 += "<td colspan='2'></td>";
        }

        var num0 = min;
        while (num0 <= max) {
            str5 += "<td >" + MaxLostNum[num0] + "</td>";
            num0++;
        }

        str5 += "</tr>";

        var str6 = "<tr class='color1'>";
        str6 += "<td >";
        str6 += "出现次数";
        str6 += "</td><td colspan='4'></td>";
        if(gametype=='dp'){
            str6 += "<td colspan='2'></td>";
        }

        var num0 = min;
        while (num0 <= max) {
            str6 += "<td >" + countArray[num0] + "</td>";
            num0++;
        }

        str6 += "</tr>";


        var str7 = "<tr class='color4'>";
        str7 += "<td >";
        str7 += "平均遗漏";
        str7 += "</td><td colspan='4'></td>";
        if(gametype=='dp'){
            str7 += "<td colspan='2'></td>";
        }
        var num0 = min;
        while (num0 <= max) {
            if(countArray[num0]>0)
                var tt= (d.table.length-countArray[num0])/countArray[num0];
            else
                var tt= d.table.length;
            tt=parseInt(tt);
            str7 += "<td >" +tt + "</td>";
            num0++;
        }

        str7 += "</tr>";

        LotteryLines += str6 + str4 + str5+str7+strheader;

        $("#LotteryLines").html(LotteryLines);




        window.scroll(0, 999999);

    }

    function hz1List() {


        removeline();

        $("#LotteryHeadLines").html("");
        $("#LotteryLines").html("");


        d = lotteryDate;
        var LotteryHeadLines = "";
        var LotteryLines = "";
        var min = 0;
        var max = 9;


        min = 0;
        max = 7;


        var strheader = "<tr>";
        strheader += "<td style=\"width:60px;\">期号</td>";

        strheader+="<td>";
        strheader +=  "和值";
        strheader+="</td>";
        var showarr=new Array('单','双','大','小','大单','大双','小单','小双');

        for(var i=0;i<showarr.length;i++)
            strheader+="<td>"+showarr[i]+"</td>";


        strheader += "</tr>";
        LotteryHeadLines = strheader;
        $("#LotteryHeadLines").html(LotteryHeadLines);


        var countArray = new Array();
        var MaxNum = new Array();
        var MaxNumArray = new Array();
        var MaxLostNum = new Array();
        var strArray = new Array();
        var numArray = new Array();


        for (var j = min; j <= max; j++) {
            countArray[j] = 0;
            MaxNum[j] = 0;
            MaxNumArray[j] = 0;
            MaxLostNum[j] = 0;
            strArray[j] = 0;
            numArray[j] = 0;
        }

        if (d.table.length > 0) $("#name").html(d.table[0].name);

        for (var i = 0; i < d.table.length; i++) {
            var dt = d.table[i];
            var num0;
            var str = dt.title;
            str = qistr(str);
            var str2 = dt.number;
            var strArray2 = str2.split(',');



            var str3 = "<tr>";
            str3 += "<td class=\"issue\">";
            str3 += str;
            str3 += "</td>";

            num0 = min;

            var sum=parseInt(arr_sum(strArray2));
            str3+="<td class='numbg4'>"+sum+"</td>";


            for(var j=0;j<8;j++){


                code=parseInt(strArray2[j]);
                num0=j;
                var sta=0;
                if(sum%2==1 && j==0){sta=1;}
                if(sum%2==0 && j==1){sta=1;}
                if(sum>810 && j==2){sta=1;}
                if(sum<=810 && j==3){sta=1;}
                if(sum>810 && sum%2==1 && j==4){sta=1;}
                if(sum>810 && sum%2==0 && j==5){sta=1;}
                if(sum<=810 && sum%2==1 && j==6){sta=1;}
                if(sum<=810 && sum%2==0 && j==7){sta=1;}
                showname=showarr[j];
                if (sta==1) {
                    countArray[num0]++;
                    numArray[num0] = -1;
                    MaxNumArray[num0]++;
                    if (MaxNum[num0] < MaxNumArray[num0])
                        MaxNum[num0] = MaxNumArray[num0];

                    str3 += "<td class='numbg"+j%4+"'>"+showname+"</td>";
                }
                else {
                    MaxNumArray[num0] = 0;
                    numArray[num0]++;
                    if (MaxLostNum[num0] < numArray[num0])
                        MaxLostNum[num0] = numArray[num0];

                    str3 += "<td class=\"wdh td0\">"+numArray[num0]+"</td>";

                }



            }


            str3 += "</tr>";
            LotteryLines += str3;
        }


        var str4 = "<tr class='color2'>";
        str4 += "<td >";
        str4 += "最大连出";
        str4 += "</td><td colspan='1'></td>";


        var num0 = min;
        while (num0 <= max) {
            str4 += "<td >" + MaxNum[num0] + "</td>";
            num0++;
        }

        str4 += "</tr>";


        var str5 = "<tr class='color3'>";
        str5 += "<td >";
        str5 += "最大遗漏";
        str5 += "</td><td colspan='1'></td>";


        var num0 = min;
        while (num0 <= max) {
            str5 += "<td >" + MaxLostNum[num0] + "</td>";
            num0++;
        }

        str5 += "</tr>";

        var str6 = "<tr class='color1'>";
        str6 += "<td >";
        str6 += "出现次数";
        str6 += "</td><td colspan='1'></td>";


        var num0 = min;
        while (num0 <= max) {
            str6 += "<td >" + countArray[num0] + "</td>";
            num0++;
        }

        str6 += "</tr>";


        var str7 = "<tr class='color4'>";
        str7 += "<td >";
        str7 += "平均遗漏";
        str7 += "</td><td colspan='1'></td>";

        var num0 = min;
        while (num0 <= max) {
            if(countArray[num0]>0)
                var tt= (d.table.length-countArray[num0])/countArray[num0];
            else
                var tt= d.table.length;
            tt=parseInt(tt);
            str7 += "<td >" +tt + "</td>";
            num0++;
        }

        str7 += "</tr>";

        LotteryLines += str6 + str4 + str5+str7+strheader;

        $("#LotteryLines").html(LotteryLines);




        window.scroll(0, 999999);

    }

    function hz2List() {


        removeline();

        $("#LotteryHeadLines").html("");
        $("#LotteryLines").html("");


        d = lotteryDate;
        var LotteryHeadLines = "";
        var LotteryLines = "";
        var min = 0;
        var max = 9;


        min = 0;
        max = 4;


        var strheader = "<tr>";
        strheader += "<td style=\"width:60px;\">期号</td>";

        strheader+="<td>";
        strheader +=  "和值";
        strheader+="</td>";
        var showarr=new Array('金','木','水','火','土');


        strheader+="<td class='f12'>金<br>210-695</td>";
        strheader+="<td class='f12'>木<br>696-763</td>";
        strheader+="<td class='f12'>水<br>764-855</td>";
        strheader+="<td class='f12'>火<br>856-923</td>";
        strheader+="<td class='f12'>土<br>924-1410</td>";

        strheader += "</tr>";
        LotteryHeadLines = strheader;
        $("#LotteryHeadLines").html(LotteryHeadLines);


        var countArray = new Array();
        var MaxNum = new Array();
        var MaxNumArray = new Array();
        var MaxLostNum = new Array();
        var strArray = new Array();
        var numArray = new Array();


        for (var j = min; j <= max; j++) {
            countArray[j] = 0;
            MaxNum[j] = 0;
            MaxNumArray[j] = 0;
            MaxLostNum[j] = 0;
            strArray[j] = 0;
            numArray[j] = 0;
        }

        if (d.table.length > 0) $("#name").html(d.table[0].name);

        for (var i = 0; i < d.table.length; i++) {
            var dt = d.table[i];
            var num0;
            var str = dt.title;
            str = qistr(str);
            var str2 = dt.number;
            var strArray2 = str2.split(',');



            var str3 = "<tr>";
            str3 += "<td class=\"issue\">";
            str3 += str;
            str3 += "</td>";

            num0 = min;

            var sum=parseInt(arr_sum(strArray2));
            str3+="<td class='numbg4'>"+sum+"</td>";


            for(var j=0;j<5;j++){


                code=parseInt(strArray2[j]);
                num0=j;
                var sta=0;
                if(sum>=210  && sum<=695 && j==0){sta=1;}
                if(sum>=696  && sum<=763 && j==1){sta=1;}
                if(sum>=764  && sum<=855 && j==2){sta=1;}
                if(sum>=856  && sum<=923 && j==3){sta=1;}
                if(sum>=924  && sum<=1410 && j==4){sta=1;}
                showname=showarr[j];
                if (sta==1) {
                    countArray[num0]++;
                    numArray[num0] = -1;
                    MaxNumArray[num0]++;
                    if (MaxNum[num0] < MaxNumArray[num0])
                        MaxNum[num0] = MaxNumArray[num0];

                    str3 += "<td class='numbg"+j%4+"'>"+showname+"</td>";
                }
                else {
                    MaxNumArray[num0] = 0;
                    numArray[num0]++;
                    if (MaxLostNum[num0] < numArray[num0])
                        MaxLostNum[num0] = numArray[num0];

                    str3 += "<td class=\"wdh td0\">"+numArray[num0]+"</td>";

                }



            }


            str3 += "</tr>";
            LotteryLines += str3;
        }


        var str4 = "<tr class='color2'>";
        str4 += "<td >";
        str4 += "最大连出";
        str4 += "</td><td colspan='1'></td>";


        var num0 = min;
        while (num0 <= max) {
            str4 += "<td >" + MaxNum[num0] + "</td>";
            num0++;
        }

        str4 += "</tr>";


        var str5 = "<tr class='color3'>";
        str5 += "<td >";
        str5 += "最大遗漏";
        str5 += "</td><td colspan='1'></td>";


        var num0 = min;
        while (num0 <= max) {
            str5 += "<td >" + MaxLostNum[num0] + "</td>";
            num0++;
        }

        str5 += "</tr>";

        var str6 = "<tr class='color1'>";
        str6 += "<td >";
        str6 += "出现次数";
        str6 += "</td><td colspan='1'></td>";


        var num0 = min;
        while (num0 <= max) {
            str6 += "<td >" + countArray[num0] + "</td>";
            num0++;
        }

        str6 += "</tr>";


        var str7 = "<tr class='color4'>";
        str7 += "<td >";
        str7 += "平均遗漏";
        str7 += "</td><td colspan='1'></td>";

        var num0 = min;
        while (num0 <= max) {
            if(countArray[num0]>0)
                var tt= (d.table.length-countArray[num0])/countArray[num0];
            else
                var tt= d.table.length;
            tt=parseInt(tt);
            str7 += "<td >" +tt + "</td>";
            num0++;
        }

        str7 += "</tr>";

        LotteryLines += str6 + str4 + str5+str7+strheader;

        $("#LotteryLines").html(LotteryLines);




        window.scroll(0, 999999);

    }
    function josxList(type) {


        removeline();
        var wei_num = wanfa_key2.split('-');

        var wei_from =wei_num[0];
        var wei_to = wei_num[1];

        $("#LotteryHeadLines").html("");
        $("#LotteryLines").html("");


        d = lotteryDate;
        var LotteryHeadLines = "";
        var LotteryLines = "";
        var min = 0;
        var max = 9;
        var count = 10;
        var ballNum = 5;



        min = 0;
        max = 5;
        count = 10;
        ballNum = 1;

        var strheader = "<tr>";
        strheader += "<td style=\"width:60px;\">期号</td>";


        strheader+="<td style=\"width:60px;\">奇偶个数</td>";


        strheader+="<td >奇</td><td >和</td><td >偶</td>";
        strheader+="<td style=\"width:60px;\">上下个数</td>";
        strheader+="<td >上</td><td >中</td><td >下</td>";

        strheader += "</tr>";
        LotteryHeadLines = strheader;
        $("#LotteryHeadLines").html(LotteryHeadLines);


        var countArray = new Array();
        var MaxNum = new Array();
        var MaxNumArray = new Array();
        var MaxLostNum = new Array();
        var strArray = new Array();
        var numArray = new Array();


        for (var j = min; j <= max; j++) {
            countArray[j] = 0;
            MaxNum[j] = 0;
            MaxNumArray[j] = 0;
            MaxLostNum[j] = 0;
            strArray[j] = 0;
            numArray[j] = 0;
        }

        if (d.table.length > 0) $("#name").html(d.table[0].name);

        for (var i = 0; i < d.table.length; i++) {
            var dt = d.table[i];
            var num0;
            var str = dt.title;
            str = qistr(str);
            var str2 = dt.number;
            var strArray2 = str2.split(',');



            var str3 = "<tr>";
            str3 += "<td class=\"issue\">";
            str3 += str;
            str3 += "</td>";

            num0 = min;
            var showarr=new Array('奇','和','偶');
            var ji=0;
            var ou=0;
            var shang=0;
            var xia=0;
            for(var j=0;j<strArray2.length;j++){
                if(strArray2[j]%2==1) ji++;else ou++;
                if(strArray2[j]<=40)shang++;
                else xia++;

            }


            str3+="<td class='noborder'>"+ji+":"+ou+"</td>";

            for(var j=0;j<3;j++){

                num0=j;


                if((j%3==0 && ji>ou) || (j%3==1 && ji==ou) || (j%3==2 && ji<ou) ){

                    var sta=1;
                    var showname=showarr[j%3];
                }else sta=0;


                if (sta==1) {
                    countArray[num0]++;
                    numArray[num0] = -1;
                    MaxNumArray[num0]++;
                    if (MaxNum[num0] < MaxNumArray[num0])
                        MaxNum[num0] = MaxNumArray[num0];

                    str3 += "<td class='numbg"+j%3+"'>"+showname+"</td>";
                }
                else {
                    MaxNumArray[num0] = 0;
                    numArray[num0]++;
                    if (MaxLostNum[num0] < numArray[num0])
                        MaxLostNum[num0] = numArray[num0];

                    str3 += "<td class=\"wdh td0\">"+numArray[num0]+"</td>";

                }



            }



            str3+="<td class='noborder'>"+shang+":"+xia+"</td>";

            for(var j=3;j<6;j++){

                num0=j;


                if((j%3==0 && shang>xia) || (j%3==1 && shang==xia) || (j%3==2 && shang<xia) ){

                    var sta=1;
                    var showname=showarr[j%3];
                }else sta=0;


                if (sta==1) {
                    countArray[num0]++;
                    numArray[num0] = -1;
                    MaxNumArray[num0]++;
                    if (MaxNum[num0] < MaxNumArray[num0])
                        MaxNum[num0] = MaxNumArray[num0];

                    str3 += "<td class='numbg"+j%3+"'>"+showname+"</td>";
                }
                else {
                    MaxNumArray[num0] = 0;
                    numArray[num0]++;
                    if (MaxLostNum[num0] < numArray[num0])
                        MaxLostNum[num0] = numArray[num0];

                    str3 += "<td class=\"wdh td0\">"+numArray[num0]+"</td>";

                }




            }





            str3 += "</tr>";
            LotteryLines += str3;
        }


        var str4 = "<tr class='color2'>";
        str4 += "<td >";
        str4 += "最大连出";
        str4 += "</td><td colspan='1'></td>";


        var num0 = min;
        while (num0 <= max) {
            str4 += "<td >" + MaxNum[num0] + "</td>";
            if(num0==2) str4 += "<td colspan='1'></td>";
            num0++;
        }

        str4 += "</tr>";


        var str5 = "<tr class='color3'>";
        str5 += "<td >";
        str5 += "最大遗漏";
        str5 += "</td><td colspan='1'></td>";


        var num0 = min;
        while (num0 <= max) {
            str5 += "<td >" + MaxLostNum[num0] + "</td>";
            if(num0==2) str5 += "<td colspan='1'></td>";
            num0++;
        }

        str5 += "</tr>";

        var str6 = "<tr class='color1'>";
        str6 += "<td >";
        str6 += "出现次数";
        str6 += "</td><td colspan='1'></td>";


        var num0 = min;
        while (num0 <= max) {
            str6 += "<td >" + countArray[num0] + "</td>";
            if(num0==2) str6 += "<td colspan='1'></td>";
            num0++;
        }

        str6 += "</tr>";


        var str7 = "<tr class='color4'>";
        str7 += "<td >";
        str7 += "平均遗漏";
        str7 += "</td><td colspan='1'></td>";

        var num0 = min;
        while (num0 <= max) {
            if(countArray[num0]>0)
                var tt= (d.table.length-countArray[num0])/countArray[num0];
            else
                var tt= d.table.length;
            tt=parseInt(tt);
            str7 += "<td >" +tt + "</td>";
            if(num0==2) str7 += "<td colspan='1'></td>";
            num0++;
        }

        str7 += "</tr>";

        LotteryLines += str6 + str4 + str5+str7+strheader;

        $("#LotteryLines").html(LotteryLines);




     window.scroll(0, 999999);

    }
</script>

