
<!DOCTYPE html>
<HTML xmlns="http://www.w3.org/1999/xhtml" xmlns:esun>
<HEAD>    <meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1" />
    <meta name="renderer" content="webkit" title="360浏览器强制开启急速模式-webkit内核" />
    <meta charset="UTF-8" />
    <title><!--<?php echo $game['fullname']; ?>-->历史号码走势 </title>
    <link rel="shortcut icon" href="<!--<?php echo $con_system['ico']; ?>-->" type="image/x-icon" />
    <meta name="description" content="<!--<?php echo $config.description; ?>-->" />
    <meta name="keywords" content="<!--<?php echo $config.keywords; ?>-->" />

    <META http-equiv="Content-Type" content="text/html; charset=UTF-8" />

    <META http-equiv="Pragma" content="no-cache" />
    <link href="/trend/2018/sy2/css/defaultright.css" rel="stylesheet" type="text/css" />
    <link href="/trend/2018/sy2/css/line.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="/trend/2018/sy2/todo/images/common/base.css" />
    <link rel="stylesheet" href="/trend/2018/sy2/css/bonuscode_switchbar.min.css">
    <style>
        esun\:*{behavior:url(#default#VML)}
    </style>
    <script type="text/javascript" src="/trend/2018/sy2/js/jquery-1.9.1.js"></script>
    <script type="text/javascript" src="/trend/2018/sy2/js/line.min.js"></script>
    <style>
        .date_links a {color:red;font-weight:bold;}
        .wdh div.span{width:18px;height:18px;}

    </style>
    <style id="J-esun">
        esun\:*{behavior:url(#default#VML)}
    </style>
</HEAD>
<body id="lan">
<div id="right_01">
    <div class="right_01_01"><SPAN class="action-span1">
<a href="game_<!--<?php echo $game['id']; ?>-->.html?nav=<!--<?php echo $game['skey']; ?>-->" target='_top'><!--<?php echo $game['fullname']; ?>-->历史号码走势 </a></SPAN></div>

</div>
<script>
    $(function () {

        if ($(window).width() > 1000) {
            $("#titlemessage").css('width', '100%');
            $("#right_01").css('width', '100%');
        }

        $("#navbutton,#symbol").show();
        drawLine();

    });

    function drawLine() {
        $("canvas").remove();
        $('.IELine').remove();
        DrawLine.bind("chartsTable","has_line");

        DrawLine.color('#499495');
        DrawLine.add((parseInt(0)*10+5+1),2,10,0);
        DrawLine.color('#E4A8A8');
        DrawLine.add((parseInt(1)*10+5+1),2,10,0);
        DrawLine.color('#499495');
        DrawLine.add((parseInt(2)*10+5+1),2,10,0);
        DrawLine.color('#E4A8A8');
        DrawLine.add((parseInt(3)*10+5+1),2,10,0);
        DrawLine.color('#499495');
        DrawLine.add((parseInt(4)*10+5+1),2,10,0);

        DrawLine.draw(Chart.ini.default_has_line);
        resize();
    }

    function resize() {
        // 20170508 patch to detect mobile device and not to bind the resize event
        var isMobile = /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
        //if(window.console){console.log(isMobile)};
        if (!isMobile) {
            window.onresize = func;
            //document.onmousewheel = func;
            function func() {
                setTimeout(function () {window.location.href = window.location.href}, 100);
            }
        }
    }

    //remove mousewheel event...totally, fix ie8 ..just find it and patch it...
    //remove remark after discuss the issue
    // document.onmousewheel = function(e){stopWheel(e);} /* IE7, IE8 */
    // if(document.addEventListener){ /* Chrome, Safari, Firefox */
    // 	document.addEventListener('DOMMouseScroll', stopWheel, false);
    // }

    // function stopWheel(e){
    // 	var event = e || window.event;
    // 	if (event.ctrlKey) {
    // 		if(!e){e = window.event;} /* IE7, IE8, Chrome, Safari */
    // 		if(e.preventDefault) {e.preventDefault();} /* Chrome, Safari, Firefox */
    // 		e.returnValue = false; /* IE7, IE8 */
    // 	}
    // }


    function trends(checked) {
        if (!checked) {
            $("canvas").remove();
            $('.IELine').remove();
        } else {
            drawLine();
        }
    }

    function therm(checked) {
        if (!checked) {
            $("#chartsTable .ball0").removeClass("therm00");
            $("#chartsTable .ball1").removeClass("therm01");
            $("#chartsTable .ball2").removeClass('therm02');
            $(".ball0,.ball1,.ball2").addClass('ball01');
        }
        else {
            $(".ball0,.ball1,.ball2").removeClass('ball01');
            $("#chartsTable .ball0").addClass("therm00");
            $("#chartsTable .ball1").addClass("therm01");
            $("#chartsTable .ball2").addClass('therm02');
        }
    }

    function toggleMiss() {
        $('#missedTable').toggle();
    }
    //隐藏
    var t_handle = 0;
    function toggleNav(e) {
        $('.IELine').remove();
        if (t_handle == 0) {
            $("canvas").remove();
            $("#navbutton").html('展开功能区');
            $('#nav').fadeOut('fast', function () {
                drawLine();
            });
            t_handle = 1;
            $("#symbol").removeClass('open');
            $("#symbol").addClass('close');
        }
        else {

            $("canvas").remove();

            $('#nav').fadeIn('fast', function () {
                drawLine();
            });
            $("#navbutton").html('隐藏功能区');
            $("#symbol").removeClass('close');
            $("#symbol").addClass('open');
            t_handle = 0;

        }

    }
    function colored(checked) {
        if (!checked) {
            $("#chartsTable .lostcolor").css("background-color", '#FFF');
        }else {
            $("#chartsTable .lostcolor").css("background-color", '#e9e9e9');
        }
    }

    function lostnum(checked) {
        if (!checked) {
            $("#chartsTable .lostnum").hide();
        }
        else {
            $("#chartsTable .lostnum").show();
        }
    }

    function assist(checked) {
        if (!checked) {
            $(".bottomtd").css("border-bottom", '');
        } else {
            $(".bottomtd").css("border-bottom", "1px solid #fa742B");
        }
    }

    $(function(){
        assist(true)
    })
</script>
<style>
    esun\:*{behavior:url(#default#VML)}
</style>
<div class="switch-bar">
    <ul class="switch-bar-list switch-bar-type-list">

        <?php if(is_array($arr_game_code)){foreach($arr_game_code AS $key=>$item) { ?>

        <?php if(count($game_nav[$key])>0){?>

        <li >

            <a href="<!--<?php echo $root_url; ?>-->index_chart.html?playkey=<!--<?php echo $game_nav[$key][0]['ckey']; ?>-->&top=30" <?php if($game['skey']==$key){?>class="active" <?php }?>> <?php echo $item; ?></a>
        </li>


        <?php }?>


        <?php }}?>


    </ul>
    <ul class="switch-bar-list switch-bar-lottery-list">

        <?php if(is_array($game_nav[$game['skey']])){foreach($game_nav[$game['skey']] AS $key1=>$item1) { ?>
        <li >

            <a href="<!--<?php echo $root_url; ?>-->index_chart.html?playkey=<!--<?php echo $item1['ckey']; ?>-->&top=<!--<?php echo $top; ?>-->&method=<!--<?php echo $method; ?>-->" <?php if($game['ckey']==$item1['ckey']){?>class="active" <?php }?>   >
            <!--<?php echo $item1['fullname']; ?>-->
            </a>
        </li>

        <?php }}?>

    </ul>
</div><table width="100%" id="titlemessage" border="0" cellpadding="0" cellspacing="0">
    <tr>
        <td colspan="6" style="text-align:left">

            <?php if(is_array($method_list)){foreach($method_list AS $key1=>$item1) { ?>

            <b>
                <?php if($method==$key1){?>

                <span >
                   <?php echo $item1; ?>走势图
                </span>
                <?php } else { ?>
                <span class="redtext">
                    <a href="<!--<?php echo $root_url; ?>-->index_chart.html?playkey=<!--<?php echo $game['ckey']; ?>-->&top=<!--<?php echo $top; ?>-->&method=<!--<?php echo $key1; ?>-->"><?php echo $item1; ?>走势图</a>
                </span>

                <?php }?>
            </b>

            <?php }}?>


            <b><span onclick="toggleNav(event);" style="display:none;" id='navbutton'>隐藏功能区</span></b>
            <b><span id='symbol' class="open" style="display:none;" onclick="toggleNav(event);">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></b>
        </td>
    </tr>
    <tr>
        <td  colspan="6"  style="text-align:left;vertical-align:middel;width:100%;height:30%">
            <div id='nav' >
                <div style="width:auto;float:left">
<span title="选中时（用鼠标单击控件打上勾即为选中），在表格中每5个奖期的号码栏中将会出现辅助线" style="cursor:pointer">
<input type='checkbox' onclick='assist(this.checked)' checked="checked"/>辅助线</span>
                    <span title="选中时（用鼠标单击控件打上勾即为选中），在表格中每期开奖号码的表格中显示出该号码的遗漏值。" style="cursor:pointer">
<input type='checkbox' checked="checked" onclick='lostnum(this.checked)'/>遗漏</span>
                    <span title="选中时（用鼠标单击控件打上勾即为选中），在表格中将会把遗漏期使用有色的柱图来表示。" style="cursor:pointer">
<input type='checkbox' checked="checked" onclick='colored(this.checked)'/>遗漏条</span>
                    <span title="选中时（用鼠标单击控件打上勾即为选中），将会在表格中绘制开奖号码的走势。" style="cursor:pointer">
<input type='checkbox' checked="checked" onclick='trends(this.checked)'/>走势</span>
                    <span title="选中时（用鼠标单击控件打上勾即为选中），色温分为“冷热温”三种色调" style="cursor:pointer">
<input type='checkbox' onclick='therm(this.checked)' checked="checked" />号温</span>

                    <?php if(is_array($top_arr)){foreach($top_arr AS $key1=>$item1) { ?>

                    <?php if($top==$item1){?>
                    <span>
最近<?php echo $item1; ?>期&nbsp;</span>

                    <?php } else { ?>
                    <span >
                  <a href="<!--<?php echo $root_url; ?>-->index_chart.html?playkey=<!--<?php echo $game['ckey']; ?>-->&top=<?php echo $item1; ?>&method=<!--<?php echo $method; ?>-->">  最近<?php echo $item1; ?>期</a>
                </span>

                    <?php }?>

                    <?php }}?>

                    <!--
<span><a href="game_bonuscode.shtml?day=t&lotteryid=1&starttime=2018-03-10&endtime=2018-03-11">今日数据&nbsp;</a></span>
<span><a href="game_bonuscode.shtml?day=tt&lotteryid=1&starttime=2018-03-08&endtime=2018-03-10">近2天&nbsp;</a></span>
            <!span><a href="?controller=game&action=bonuscode&day=tw&lotteryid=1&starttime=2018-03-05&endtime=2018-03-10">近5天&nbsp;</a></span>
     -->  	<!--
            <span>

            <form id="J-date-form" method="POST" action="/game_bonuscode.shtml">

                <input type="hidden" name="controller" value="game">
                <input type="hidden" name="action" value="bonuscode">
                <input type="hidden" name="lotteryid" value="1">
                <input style="width:100px" type="text" value="" name="starttime" id="starttime">
                <img id="starttimeimg" src="/images/sy/icon_06.jpg" style="vertical-align:middle;">

                &nbsp;&nbsp;至&nbsp;&nbsp;
                <input style="width:100px" type="text" value="" name="endtime" id="endtime">
                <img id='endtimeimg' src="/images/sy/icon_06.jpg" style="vertical-align:middle;">
                <input type="button" value="" id="showissue">
            </form>

            </span>
           -->
                </div>

            </div>
        </td>
    </tr>
    <tr>
        <td class="date_links">


        </td>
        <td>

        </td>
    </tr>
</table>
<div style="position:relative; height: 950px;" id="container">

    <script>
        function transfer(checked){
            if(!checked)
            {
                $("#chartsTable #missone").hide();
                $("#chartsTable #showone").css('color','#000');
            }
            else
            {

                $("#chartsTable #missone").show();
                $("#chartsTable #showone").css('color','#F00');
            }
        }
    </script>

    <table id="chartsTable" width="100%" cellpadding="0" cellspacing="0" style="position:absolute; top:0; left:0; border-collapse: collapse;" class="chart-table">
        <tr id="title">
            <td rowspan="2">期号</td>
            <td rowspan="2" style="border-right:#d6d6d6 solid 1px;width:5%" colspan="5">开奖号码
                <?php if($method!='5X'){?>
                <br>
                <input type="checkbox" onclick='transfer(this.checked)' checked/>全部
                <?php }?>
            </td>
            <?php if(is_array($wei)){foreach($wei AS $key=>$item) { ?>
            <td colspan="10" style="border-right:#d6d6d6 solid 1px;"><?php echo $item; ?></td>

            <?php }}?>
            <?php if($method=='2X1' || $method=='2X2'){?>

            <td style="border-right:#d6d6d6 solid 1px;" rowspan="2">对子</td>

            <?php }?>
            <td colspan="10">号码分布</td>

            <?php if($method=='3X' || $method=='3X1' || $method=='3X2' || $method=='3X3'){?>
            <td rowspan="2" nowrap>大小形态</td>
            <td rowspan="2" nowrap>奇偶形态</td>
            <td rowspan="2" nowrap>质合形态</td>
            <td rowspan="2" nowrap>012形态</td>
            <td rowspan="2" nowrap>豹子</td>
            <td rowspan="2" nowrap>组三</td>
            <td rowspan="2" nowrap>组六</td>
            <td rowspan="2" nowrap>跨度</td>
            <td rowspan="2" nowrap>直选和值</td>
            <td rowspan="2" nowrap>和值尾数</td>
            <?php }?>


            <?php if($method=='2X1' || $method=='2X2'){?>

            <td style="border-right:#d6d6d6 solid 1px;" colspan="10">跨度走势</td>
            <td rowspan="2">和值</td>

            <?php }?>
        </tr>
        <tr id="head">

            <?php if(is_array($wei)){foreach($wei AS $key=>$item) { ?>
            <!--{for $i=0 to 9}-->
            <?php if($i<9){?>
            <td  class="wdh"><?php echo $i; ?></td>

            <?php } else { ?>
            <td  style="border-right:#d6d6d6 solid 1px;"><?php echo $i; ?></td>

            <?php }?>
            <!--{/for}-->
            <?php }}?>

            <td class="wdh">0</td>
            <td class="wdh">1</td>
            <td class="wdh">2</td>
            <td class="wdh">3</td>
            <td class="wdh">4</td>
            <td class="wdh">5</td>
            <td class="wdh">6</td>
            <td class="wdh">7</td>
            <td class="wdh">8</td>
            <td class="wdh">9</td>

            <?php if($method=='2X1' || $method=='2X2'){?>

            <td  class="wdh">0</td>
            <td  class="wdh">1</td>
            <td  class="wdh">2</td>
            <td  class="wdh">3</td>
            <td  class="wdh">4</td>
            <td  class="wdh">5</td>
            <td  class="wdh">6</td>
            <td  class="wdh">7</td>
            <td  class="wdh">8</td>
            <td  style="border-right:#d6d6d6 solid 1px;" class="wdh">9</td>


            <?php }?>

        </tr>

        <!--{$baozi=0}-->
        <?php if(is_array($list)){foreach($list AS $key=>$item) { ?>
        <tr>
            <td id="title" class="<?php echo $item['line']; ?>"   ><?php echo $item['period']; ?></td>


            <td class="wdh <?php echo $item['line']; ?>" align="center"  >
                <div <?php if($method=='3X1' || $method=='2X1'){?>id='showone' style="color:red"<?php } else { ?>id='missone'<?php }?>><?php echo $item['number'][0]; ?></div>                </td>
<td class="wdh <?php echo $item['line']; ?>" align="center"  >
    <div <?php if($method=='4X'|| $method=='3X1'|| $method=='3X3' || $method=='2X1' || ($method=='2X2' && $game['skey']=='dp')){?>id='showone' style="color:red"<?php } else { ?>id='missone'<?php }?>><?php echo $item['number'][1]; ?></div>
</td>
<td class="wdh <?php echo $item['line']; ?>" align="center"   >
    <div <?php if($method=='4X'|| $method=='3X1'|| $method=='3X2' || $method=='3X3' || ($method=='2X2' && $game['skey']=='dp')){?>id='showone' style="color:red"<?php } else { ?>id='missone'<?php }?>><?php echo $item['number'][2]; ?></div>
</td>
<td class="wdh <?php echo $item['line']; ?>" align="center"    >
    <div <?php if($method=='4X'|| $method=='3X3'|| $method=='3X2' || $method=='2X2'){?>id='showone' style="color:red"<?php } else { ?>id='missone'<?php }?>><?php echo $item['number'][3]; ?></div>
</td>
<td class="wdh <?php echo $item['line']; ?>" align="center" style=" border-right:#d6d6d6 solid 1px; " >
    <div <?php if($method=='4X'|| $method=='3X2' || $method=='2X2'){?>id='showone' style="color:red"<?php } else { ?>id='missone'<?php }?>'><?php echo $item['number'][4]; ?></div>                </td>

<?php if(is_array($wei)){foreach($wei AS $key1=>$item1) { ?>
<!--{for $i=0 to 9}-->
<?php if($i==$item['number'][$key1]){?>
<!--{$lx[$key1][$i]=0}-->
<!--{$cx[$key1][$i]=$cx[$key1][$i]+1}-->



<td class="charball <?php echo $item['line']; ?>"  align="center" style="<?php if($i==9){?>border-right:#d6d6d6 solid 1px;<?php }?> ">
    <div class="ball<!--<?php echo $i%3; ?>--> therm0<!--<?php echo $i%3; ?>-->"><?php echo $i; ?></div>
</td>
<?php } else { ?>
<!--{$lx[$key1][$i]=$lx[$key1][$i]+1}-->
<?php if($lx[$key1][$i]>$yl[$key1][$i]){?>
<!--{$yl[$key1][$i]=$lx[$key1][$i]}-->
<?php }?>
<td align="center" class=" wdh <!--<?php echo $item['lost'][$key1][$i]; ?>--> <?php echo $item['line']; ?>" style="<?php if($i==9){?>border-right:#d6d6d6 solid 1px;<?php }?> " ><div class='lostdiv'><div class='lostnum'><?php echo $lx[$key1][$i]; ?></div></div></td>
<?php }?>
<!--{/for}-->
<?php }}?>


<?php if($method=='2X1' || $method=='2X2'){?>
<td class="wdh <?php echo $item['line']; ?>" align="center" style="border-right:#d6d6d6 solid 1px;">
    <div class='lostdiv lostnum'>
        <?php if($item['number1'][0]==$item['number1'][1]){?>
        <!--{$cx['pair']=$cx['pair']+1}-->
        <!--{$lx['pair']=0}-->
        <div class="pair">对</div>
        <?php } else { ?>
        <!--{$lx['pair']=$lx['pair']+1}-->

        <?php if($lx['pair']>$yl['pair']){?>
        <!--{$yl['pair']=$lx['pair']}-->
        <?php }?>

        <!--<?php echo $lx['pair']; ?>-->
        <?php }?>

    </div>
</td>

<?php }?>




<!--{$ball_times=array()}-->



<!--{for $i=0 to 9}-->




<?php if(in_array($i,$item['number1'])){?>
<!--{$ball_times=0}-->
<?php if(is_array($item['number1'])){foreach($item['number1'] AS $key3=>$item3) { ?>
<?php if($i==$item3){?>
<!--{$ball_times=$ball_times+1}-->
<?php }?>
<?php }}?>

<?php if($ball_times>1){?>
<!--{$ball=5}-->
<?php } else { ?>
<!--{$ball=6}-->
<?php }?>

<!--{$lx['result'][$i]=0}-->
<!--{$cx['result'][$i]=$cx['result'][$i]+$ball_times}-->
<td class="wdh <?php echo $item['line']; ?>" align="center" style="<?php if($i==9){?>border-right:#d6d6d6 solid 1px;<?php }?>">
    <div class="ball0<!--<?php echo $ball; ?>-->"><?php echo $i; ?></div>
</td>

<?php } else { ?>
<!--{$lx['result'][$i]=$lx['result'][$i]+1}-->
<?php if($lx['result'][$i]>$yl['result'][$i]){?>
<!--{$yl['result'][$i]=$lx['result'][$i]}-->
<?php }?>
<td class="wdh <?php echo $item['line']; ?>" align="center" style="<?php if($i==9){?>border-right:#d6d6d6 solid 1px;<?php }?>" >
    <div class='lostdiv'><div class='lostnum'><?php echo $lx['result'][$i]; ?></div></div>
</td>

<?php }?>
<!--{/for}-->





<?php if($method=='2X1' || $method=='2X2'){?>

<!--{for $i=0 to 9}-->
<?php if($i==$item['kd']){?>
<!--{$lx['kd'][$i]=0}-->
<!--{$cx['kd'][$i]=$cx['kd'][$i]+1}-->
<td class="wdh <?php echo $item['line']; ?>" align="center" style="<?php if($i==9){?>border-right:#d6d6d6 solid 1px;<?php }?>">
    <div class="span"><?php echo $i; ?></div>
</td>

<?php } else { ?>

<!--{$lx['kd'][$i]=$lx['kd'][$i]+1}-->
<?php if($lx['kd'][$i]>$yl['kd'][$i]){?>
<!--{$yl['kd'][$i]=$lx['kd'][$i]}-->
<?php }?>
<td class="wdh <?php echo $item['line']; ?> <!--<?php echo $item['kuadu'][$i]; ?>-->" align="center" style="<?php if($i==9){?>border-right:#d6d6d6 solid 1px;<?php }?>" >
    <div class='lostdiv'><div class='lostnum'><?php echo $lx['kd'][$i]; ?></div></div>
</td>

<?php }?>
<!--{/for}-->
<td class="wdh <?php echo $item['line']; ?>" align="center">
    <div><?php echo $item['hz']; ?></div>
</td>


<?php }?>



<?php if($method=='3X' || $method=='3X1' || $method=='3X2' || $method=='3X3'){?>
<td align="center" style="background-color:#0dcaae;" class="<?php echo $item['line']; ?>">
    <div><?php if(is_array($item['number1'])){foreach($item['number1'] AS $key3=>$item3) { ?><?php if($item3>=5){?>大<?php } else { ?>小<?php }?><?php }}?></div>
</td>
<td align="center" style="background-color:#c2e783;" class="<?php echo $item['line']; ?>">
    <div><?php if(is_array($item['number1'])){foreach($item['number1'] AS $key3=>$item3) { ?><?php if($item3%2==1){?>单<?php } else { ?>双<?php }?><?php }}?></div>
</td>
<td align="center" style="background-color:#0dcaae;" class="<?php echo $item['line']; ?>">
    <div><?php if(is_array($item['number1'])){foreach($item['number1'] AS $key3=>$item3) { ?><?php if($item3==1 || $item3==2 || $item3==3 || $item3==5 || $item3==7){?>质<?php } else { ?>合<?php }?><?php }}?></div>
</td>
<td align="center" style="background-color:#c2e783;" class="<?php echo $item['line']; ?>">
    <div><?php if(is_array($item['number1'])){foreach($item['number1'] AS $key3=>$item3) { ?><!--<?php echo $item3%3; ?>--><?php }}?></div>
</td>
<td align="center" style="background-color:#c2e783;" class="<?php echo $item['line']; ?>">
    <div><span class="lostnum" style="color:#777">
                        <?php if($item['number1'][0]==$item['number1'][1] && $item['number1'][1]==$item['number1'][2]){?>
                        是
        <!--{$cx['baozi']=$cx['baozi']+1}-->
        <!--{$lx['baozi']=0}-->
        <?php } else { ?>
        <!--{$lx['baozi']=$lx['baozi']+1}-->
        <!--{$yl['baozi']=$yl['baozi']+1}-->
        <?php if($lx['baozi']>$yl['baozi']){?>
        <!--{$yl['baozi']=$lx['baozi']}-->
        <?php }?>

        <!--<?php echo $lx['baozi']; ?>-->
        <?php }?>


                    </span></div>
</td>
<td align="center" class="<?php echo $item['line']; ?>" >
    <div>
        <?php if($item['number1'][0]==$item['number1'][1] ||  $item['number1'][1]==$item['number1'][2]  || $item['number1'][0]==$item['number1'][2]){?>
        <!--{$cx['z3']=$cx['z3']+1}-->
        &#10003;
        <!--{$lx['z3']=0}-->
        <?php } else { ?>

        <!--{$lx['z3']=$lx['z3']+1}-->

        <?php if($lx['z3']>$yl['z3']){?>
        <!--{$yl['z3']=$lx['z3']}-->
        <?php }?>
        <?php }?>

    </div>
</td>
<td align="center" style="background-color:#0dcaae;" class="<?php echo $item['line']; ?>" >
    <div>         <?php if($item['number1'][0]==$item['number1'][1] ||  $item['number1'][1]==$item['number1'][2]  || $item['number1'][0]==$item['number1'][2]){?>

        <!--{$lx['z6']=$lx['z6']+1}-->

        <?php if($lx['z6']>$yl['z6']){?>
        <!--{$yl['z6']=$lx['z6']}-->
        <?php }?>
        <?php } else { ?>
        <!--{$cx['z6']=$cx['z6']+1}-->
        &#10003;
        <!--{$lx['z6']=0}-->
        <?php }?></div>
</td>
<td align="center" style="background-color:#0dcaae;>" class="<?php echo $item['line']; ?>" >
    <div><!--<?php echo $item['kd']; ?>--></div>
</td>
<td align="center" class="<?php echo $item['line']; ?>" >
    <div><!--<?php echo $item['hz']; ?>--></div>
</td>
<td align="center" class="<?php echo $item['line']; ?>" >
    <div><!--<?php echo $item['hz']%10; ?>--></div>
</td>
<?php }?>









</tr>

<?php }}?>






<tfoot>
<tr>
    <td nowrap>出现总次数</td>
    <td align="center" style='border-right:#d6d6d6 solid 1px;' colspan="5">&nbsp;</td>
    <?php if(is_array($wei)){foreach($wei AS $key1=>$item1) { ?>
    <!--{for $i=0 to 9}-->

    <td  align="center" style="<?php if($i==9){?>border-right:#d6d6d6 solid 1px;<?php }?> "> <!--<?php echo $cx[$key1][$i]; ?>--></td>
    <!--{/for}-->
    <?php }}?>


    <?php if($method=='2X1' || $method=='2X2'){?>
    <td align="center">
        <!--<?php echo $cx['pair']; ?>-->
    </td>

    <?php }?>

    <!--{for $i=0 to 9}-->
    <td align="center">
        <!--<?php echo $cx['result'][$i]; ?>-->                </td>
    <!--{/for}-->

    <?php if($method=='2X1' || $method=='2X2'){?>
    <!--{for $i=0 to 9}-->
    <td align="center">
        <!--<?php echo $cx['kd'][$i]; ?>-->                </td>
    <!--{/for}-->
    <td align="center">
    </td>
    <?php }?>

    <?php if($method=='3X' ||  $method=='3X1' || $method=='3X2' || $method=='3X3'){?>
    <td align="center">
    </td>
    <td align="center">
    </td>
    <td align="center">
    </td>
    <td align="center">
    </td>
    <td align="center">
        <!--<?php echo $cx['baozi']; ?>-->                </td>
    <td align="center">
        <!--<?php echo $cx['z3']; ?>-->                   </td>
    <td align="center">
        <!--<?php echo $cx['z6']; ?>-->            </td>
    <td align="center">
    </td>
    <td align="center">
    </td>
    <td align="center">
    </td>
    <?php }?>

</tr>
<tr>
    <td nowrap>平均遗漏值</td>
    <td align="center" style='border-right:#d6d6d6 solid 1px;' colspan="5">&nbsp;</td>
    <?php if(is_array($wei)){foreach($wei AS $key1=>$item1) { ?>
    <!--{for $i=0 to 9}-->

    <td  align="center" style="<?php if($i==9){?>border-right:#d6d6d6 solid 1px;<?php }?> ">
        <?php if($cx[$key1][$i]>0){?>

        <!--{intval(count($list)/$cx[$key1][$i])}-->

        <?php } else { ?>

        <!--{count($list)+1}-->
        <?php }?>

    </td>
    <!--{/for}-->
    <?php }}?>
    <?php if($method=='2X1' || $method=='2X2'){?>
    <td align="center">
        <?php if($cx['pair']>0){?>
        <!--{intval(count($list)/$cx['pair'])}-->
        <?php } else { ?>
        <!--{count($list)+1}-->
        <?php }?>
    </td>

    <?php }?>
    <!--{for $i=0 to 9}-->
    <td align="center">
        <?php if($cx['result'][$i]>0){?>

        <!--{intval(count($list)/$cx['result'][$i])}-->

        <?php } else { ?>

        <!--{count($list)+1}-->
        <?php }?>           </td>
    <!--{/for}-->
    <?php if($method=='2X1' || $method=='2X2'){?>
    <!--{for $i=0 to 9}-->
    <td align="center">
        <?php if($cx['kd'][$i]>0){?>

        <!--{intval(count($list)/$cx['kd'][$i])}-->

        <?php } else { ?>

        <!--{count($list)+1}-->
        <?php }?>                   </td>
    <!--{/for}-->
    <td align="center">
    </td>
    <?php }?>

    <?php if($method=='3X' ||  $method=='3X1' || $method=='3X2' || $method=='3X3'){?>
    <td align="center">
    </td>
    <td align="center">
    </td>
    <td align="center">
    </td>
    <td align="center">
    </td>
    <td align="center">
        <?php if($cx['baozi']>0){?>
        <!--{intval(count($list)/$cx['baozi'])}-->
        <?php } else { ?>
        <!--{count($list)+1}-->
        <?php }?>           </td>
    <td align="center">
        <?php if($cx['z3']>0){?>
        <!--{intval(count($list)/$cx['z3'])}-->
        <?php } else { ?>
        <!--{count($list)+1}-->
        <?php }?>             </td>
    <td align="center">
        <?php if($cx['z6']>0){?>
        <!--{intval(count($list)/$cx['z6'])}-->
        <?php } else { ?>
        <!--{count($list)+1}-->
        <?php }?>               </td>
    <td align="center">
    </td>
    <td align="center">
    </td>
    <td align="center">
    </td>
    <?php }?>


</tr>
<tr>
    <td nowrap>最大遗漏值</td>
    <td align="center" style='border-right:#d6d6d6 solid 1px;' colspan="5">&nbsp;</td>
    <?php if(is_array($wei)){foreach($wei AS $key1=>$item1) { ?>
    <!--{for $i=0 to 9}-->

    <td  align="center" style="<?php if($i==9){?>border-right:#d6d6d6 solid 1px;<?php }?> "> <!--<?php echo $yl[$key1][$i]; ?>--></td>
    <!--{/for}-->
    <?php }}?>
    <?php if($method=='2X1' || $method=='2X2'){?>
    <td align="center">

        <!--<?php echo $yl['pair']; ?>-->

    </td>

    <?php }?>
    <!--{for $i=0 to 9}-->
    <td align="center">
        <!--<?php echo $yl['result'][$i]; ?>-->                </td>
    <!--{/for}-->

    <?php if($method=='2X1' || $method=='2X2'){?>
    <!--{for $i=0 to 9}-->
    <td align="center">
        <!--<?php echo $yl['kd'][$i]; ?>-->                  </td>
    <!--{/for}-->
    <td align="center">
    </td>
    <?php }?>


    <?php if($method=='3X' ||  $method=='3X1' || $method=='3X2' || $method=='3X3'){?>
    <td align="center">
    </td>
    <td align="center">
    </td>
    <td align="center">
    </td>
    <td align="center">
    </td>
    <td align="center">
        <!--<?php echo $yl['baozi']; ?>-->                </td>
    <td align="center">
        <!--<?php echo $yl['z3']; ?>-->                   </td>
    <td align="center">
        <!--<?php echo $yl['z6']; ?>-->            </td>
    <td align="center">
    </td>
    <td align="center">
    </td>
    <td align="center">
    </td>
    <?php }?>
</tr>
<tr>
    <td nowrap>最大连出值</td>
    <td align="center" style='border-right:#d6d6d6 solid 1px;' colspan="5">&nbsp;</td>

    <?php if(is_array($wei)){foreach($wei AS $key1=>$item1) { ?>
    <!--{for $i=0 to 9}-->

    <td  align="center" style="<?php if($i==9){?>border-right:#d6d6d6 solid 1px;<?php }?> "> <!--<?php echo $lc[$key1][$i]; ?>--></td>
    <!--{/for}-->
    <?php }}?>

    <?php if($method=='2X1' || $method=='2X2'){?>
    <td align="center">

        <!--<?php echo $lc['pair']; ?>-->

    </td>

    <?php }?>
    <!--{for $i=0 to 9}-->
    <td align="center">
        <!--<?php echo $lc['result'][$i]; ?>-->                </td>
    <!--{/for}-->

    <?php if($method=='2X1' || $method=='2X2'){?>
    <!--{for $i=0 to 9}-->
    <td align="center">
        <!--<?php echo $lc['kd'][$i]; ?>-->                  </td>
    <!--{/for}-->
    <td align="center">
    </td>
    <?php }?>

    <?php if($method=='3X' || $method=='3X1' || $method=='3X2' || $method=='3X3'){?>
    <td align="center">
    </td>
    <td align="center">
    </td>
    <td align="center">
    </td>
    <td align="center">
    </td>
    <td align="center">
        <!--<?php echo $lc['baozi']; ?>-->                   </td>
    <td align="center">
        <!--<?php echo $yl['z6']; ?>-->                   </td>
    <td align="center">
        <!--<?php echo $yl['z3']; ?>-->            </td>
    <td align="center">
    </td>
    <td align="center">
    </td>
    <td align="center">
    </td>

    <?php }?>
</tr>
<tr id="head">
    <td rowspan="2" >期号</td>
    <td rowspan="2" colspan="5" style='border-right:#d6d6d6 solid 1px;'>开奖号码</td>
    <?php if(is_array($wei)){foreach($wei AS $key=>$item) { ?>
    <!--{for $i=0 to 9}-->
    <?php if($i<9){?>
    <td  class="wdh"><?php echo $i; ?></td>

    <?php } else { ?>
    <td  style="border-right:#d6d6d6 solid 1px;"><?php echo $i; ?></td>

    <?php }?>
    <!--{/for}-->
    <?php }}?>

    <?php if($method=='2X1' || $method=='2X2'){?>
    <td rowspan="2" style="border-right:#d6d6d6 solid 1px;">对子</td>
    <?php }?>
    <td>0</td>
    <td>1</td>
    <td>2</td>
    <td>3</td>
    <td>4</td>
    <td>5</td>
    <td>6</td>
    <td>7</td>
    <td>8</td>
    <td>9</td>

    <?php if($method=='2X1' || $method=='2X2'){?>
    <td >0</td>
    <td >1</td>
    <td >2</td>
    <td >3</td>
    <td >4</td>
    <td >5</td>
    <td >6</td>
    <td >7</td>
    <td >8</td>
    <td style="border-right:#d6d6d6 solid 1px;">9</td>
    <td rowspan="2">和值</td>
    <?php }?>

    <?php if($method=='3X' ||  $method=='3X1' || $method=='3X2' || $method=='3X3'){?>
    <td rowspan='2'></td>
    <td rowspan='2'></td>
    <td rowspan='2'></td>
    <td rowspan='2'></td>
    <td rowspan='2'>豹子</td>
    <td rowspan='2'>组三</td>
    <td rowspan='2'>组六</td>
    <td rowspan='2'></td>
    <td rowspan='2'></td>
    <td rowspan='2'></td>
    <?php }?>
</tr>
<tr id="title">
    <?php if(is_array($wei)){foreach($wei AS $key=>$item) { ?>
    <td colspan="10" style="border-right:#d6d6d6 solid 1px;"><?php echo $item; ?></td>

    <?php }}?>

    <td colspan="10">不定位</td>
    <?php if($method=='2X1' || $method=='2X2'){?>
    <td colspan="10" style="border-right:#d6d6d6 solid 1px;">跨度</td>

    <?php }?>
</tr>



<?php if($method=='2X1' || $method=='2X2'){?>
<tr>
    <td class="desc" colspan="48" style='text-align:left'><div>
        <p>参数说明：</p>
        <p>对子 - 开奖号码的万位与千位相同，例如：开奖号码88号码<br/>分布 - 开奖号码的万位与千位的0-9出号分布情况<br/>跨度 - 开奖号码的万位与千位的正差值，例如：开奖号码83，正差值为8-3=5<br/>和值 - 开奖号码的万位与千位的和值，例如：开奖号码83，二星和值为8+3=11</p>
    </div></td>
</tr>

<?php }?>
<?php if($method=='3X' ||  $method=='3X1' || $method=='3X2' || $method=='3X3'){?>
<tr>
    <td class="desc" colspan="56" style='text-align:left'><div>
        <p>参数说明：</p>
        <p>大小形态 - 开奖号码的千位、百位、十位的大小形态，0-4为小号，5-9为大号，例如：开奖号码783，大小形态为“大大小”
            <br/>
            奇偶形态 - 开奖号码的千位、百位、十位的奇偶形态，13579为奇号，02468为偶号，例如：开奖号码783，奇偶形态为“奇偶奇”
            <br/>
            质合形态 - 开奖号码的千位、百位、十位的质合形态，12357为质数号，04689为合数号，例如：开奖号码783，质合形态为“质合质”
            <br/>
            012形态 - 开奖号码的千位、百位、十位的除3余数形态，例如：开奖号码783，012形态为“120”
            <br/>
            0路包括的数字：0、3、6、9
            <br/>
            1路包括的数字：1、4、7
            <br/>
            2路包括的数字：2、5、8
            <br/>
            豹子 - 开奖号码的千位、百位、十位相同，例如：开奖号码333
            <br/>
            组三 - 开奖号码的千、百、十位其中两位号码相同，例如：开奖号码788
            <br/>
            组六 - 开奖号码的千、百、十位各不相同，例如：开奖号码748
            <br/>
            跨度 – 最大号和最小号的正差值</p>
    </div></td>
</tr>

<?php }?>

<?php if($method=='5X'){?>
<tr>
    <td class="desc" colspan="66" style='text-align:left'><div id='refdiv'>
        <p>参数说明：</p>
        <p>万 千 百 十 个 不定位对应的走势。</p>
    </div></td>
</tr>


<?php }?>

<?php if($method=='54'){?>
<tr>
    <td class="desc" colspan="60" style='text-align:left'><div id='refdiv'>
        <p>参数说明：</p>
        <p>千 百 十 个 不定位对应的走势。</p>
    </div></td>
</tr>


<?php }?>

</tfoot>
</table></div>
<!-- <div id="quickbuy"><a href="">购买重庆时时彩</a></div> //-->

<script>

    $(function() {
        // 修正手機瀏覽網站往下滑到底會重整 20170626 Mon 09:17:29
        var isWindowTop = false;
        var lastTouchY = 0;
        var touchStartHandler = function(e) {
            if (e.touches.length !== 1) return;
            lastTouchY = e.touches[0].clientY;
            isWindowTop = (window.pageYOffset === 0);
        };
        var touchMoveHandler = function(e) {
            var touchY = e.touches[0].clientY;
            var touchYmove = touchY - lastTouchY;
            lastTouchY = touchY;
            if (isWindowTop) {
                isWindowTop = false;
                // 阻擋移動事件
                if (touchYmove > 0) {
                    e.preventDefault();
                    return;
                }
            }
        };
        document.addEventListener('touchstart', touchStartHandler, false);
        document.addEventListener('touchmove', touchMoveHandler, false);
        drawLine();
    })
</script>