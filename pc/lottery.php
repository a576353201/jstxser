<?php
include_once '../inc/common.php';
$game_list=$db->fetch_all("select * from ".tname('game')." where status='1' order by sortnum asc");
$id=$_REQUEST['id']?$_REQUEST['id']:$game_list[0]['id'];
$lotteryId=$id;
$current=$_GET['current']?$_GET['current']:1;
$pageSize=$_GET['pageSize']?$_GET['pageSize']:15;
$game=get_table(tname('game'),$lotteryId);
$gamekey=$game['showkey'];
$data=array();
$data['current']=$current;
$from=($current-1)*$pageSize;
$fromtime=strtotime(date('Y-m-d H:i:s',time()-3*86400));

$str="lottime>='{$fromtime}'";
$limit="limit {$from},{$pageSize}";

$sortnum=0;
$lotteydata=array();
foreach ($game_list as $key1=>$game){
    if($game['id']==$id){

        $sortnum=$key1;
        $gamekey1=$game['showkey'];
        $allnum=$db->exec("select count(*) as num from  ".lottery_table($gamekey1)." where {$str}");

        $data['pages']=ceil($allnum['num']/$pageSize);
        $records=array();
        $list=$db->fetch_all("select * from ".lottery_table($gamekey1)." where {$str} order by period desc {$limit}");
        if(count($list)>0){
            foreach ($list as $key=>$value){
                $arr=array();
                $arr['gametype']=$game['type'];
                $arr['issueNo']=$value['period'];
                $arr['openCode']=$value['number'];
                $arr['predictedTime']=date('Y-m-d H:i:s',$value['lottime']);

                $arr['SX']=SXZC($value['number']);
                if($key==0){
                    $period= get_now_period($gamekey1);
                    $arr['lastsecond']=$period['lastsecond'];
                    $arr['period']=$period['period'];
                }

                $arr['key']=$key;
                $records[]=$arr;
            }


        }
        $data['records']=$records;
        $data['searchCount']=true;
        $data['size']=(int) $pageSize;
        $data['total']=(int) $allnum['num'];
        $lotteydata[$game['id']]=$data;

    }
}


?>
<!DOCTYPE html>
<html lang=en>

<head>
    <meta charset=utf-8>
    <meta http-equiv=X-UA-Compatible content="IE=edge">
    <meta name=viewport content="width=device-width,initial-scale=1,user-scalable=no">
    <link rel=icon href='favicon.ico'>

    <title><?php echo $system['title'];?></title>
    <meta name="description" content="<?php echo $system['description'];?>" />
    <meta name="keywords" content="<?php echo $system['keywords'];?>" />
    <link href=style/lottery.css?v=<?php echo time(); ?> rel=stylesheet>
<link href="/assets/css/chunk-vendors.fc418570.css" rel="stylesheet">
    <link href="../static/fontello.css" rel=stylesheet>
    <link href=../assets/css/main.css?v=<?php echo $cachekey;?> rel=stylesheet>
    <script src="/static/js/jquery-1.11.1.min.js"></script>
</head>

<body>


<div class="wrapper_container">

    <div class="lottery">
        <div class="inner lottery-con">
            <div class="cont">
                <ul id="menu_nav" class="nav">
                    <?php


                    foreach ($game_list as $key=>$value){
                        ?>

                        <li class="<?php if($value['id']==$id) echo 'active';?>" onclick="click_game(<?php echo $value['id']?>,<?php echo $key;?>);"><?php echo $value['title'];?></li>
                    <?php
                    }
                    ?>
</ul>
            </div>
            <div title="查看走势图" class="trend" onclick="open_trend();">查看走势图</div>
            <div title="查看在线计划" class="trendleft" onclick="open_plan();">查看在线计划</div>
            <div title="左移" class="click_left" onclick="click_left()">
                <i class="icon-left-open"></i>
            </div>
            <div title="右移" class="click_right" onclick="click_right()">
                <i class="icon-right-open"></i>
            </div>
            <div class="lottery-data">
                <div class="clearfix swiper-container" id="lotterydata" style="transform: translateX(-<?php echo  $sortnum*950;?>px);">
                    <?php
                    foreach ($game_list as $game){
                        ?>
                        <div class="slide" style="width: 950px; height: 560px;">
                            <div class="el-table el-table--fit el-table--border el-table--enable-row-hover el-table--enable-row-transition" style="width: 100%;">
                                <div class="hidden-columns">
                                    <div></div>
                                    <div></div>
                                    <div></div>
                                </div>
                                <div class="el-table__header-wrapper">
                                    <table cellspacing="0" cellpadding="0" border="0" class="el-table__header" style="width: 949px;">
                                        <colgroup>
                                            <col name="el-table_1_column_1" width="270">
                                            <col name="el-table_1_column_2" width="270">
                                            <col name="el-table_1_column_3" width="409">
                                            <col name="gutter" width="0"></colgroup>
                                        <thead class="has-gutter">
                                        <tr class="">
                                            <th colspan="1" rowspan="1" class="el-table_1_column_1  is-center table-column  is-leaf">
                                                <div class="cell">时间</div></th>
                                            <th colspan="1" rowspan="1" class="el-table_1_column_2  is-center table-column  is-leaf">
                                                <div class="cell">期号</div></th>
                                            <th colspan="1" rowspan="1" class="el-table_1_column_3  is-center table-column  is-leaf">
                                                <div class="cell">开奖号码</div></th>
                                            <th class="gutter" style="width: 0px; display: none;"></th>
                                        </tr>
                                        </thead>
                                    </table>
                                </div>

                                    <div class="el-table__body-wrapper is-scrolling-none">
                                        <table cellspacing="0" cellpadding="0" border="0" class="el-table__body" style="width: 949px;">
                                            <colgroup>
                                                <col name="el-table_1_column_1" width="270">
                                                <col name="el-table_1_column_2" width="270">
                                                <col name="el-table_1_column_3" width="409"></colgroup>
                                            <tbody id="loattery_<?php echo $game['id'] ?>">

                                            <?php
                                            if($game['id']==$lotteryId) {
                                                foreach ($lotteydata[$game['id']]['records'] as $value) {
                                                    ?>
                                                    <tr class="el-table__row">
                                                        <td class="el-table_1_column_1 is-center table-column">
                                                            <div
                                                                class="cell"><?php echo $value['predictedTime']; ?></div>
                                                        </td>
                                                        <td class="el-table_1_column_2 is-center table-column">
                                                            <div class="cell"><?php echo $value['issueNo']; ?></div>
                                                        </td>
                                                        <td class="el-table_1_column_3 is-center table-column">
                                                            <div class="cell">
                                                                <?php
                                                                foreach (explode(',', $value['openCode']) as $number) {
                                                                    ?>
                                                                    <?php if ($game['type'] == 'pk10') {
                                                                        ?>
                                                                        <p class="<?php echo $game['type'] . " num_" . $number; ?> "><?php echo $number; ?></p>
                                                                        <?php
                                                                    } else if ($game['type'] == 'k3') {

                                                                        ?>
                                                                        <div
                                                                            class="<?php echo $game['type'] . " num_" . $number; ?> "></div>

                                                                        <?php
                                                                    } else {
                                                                        ?>
                                                                        <span class="<?php echo $game['type'] ?>"><?php echo $number; ?></span>
                                                                        <?php
                                                                    } ?>

                                                                    <?php
                                                                }
                                                                ?>

                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                }

                                            }
                                            ?>


                                            <!----></tbody>
                                        </table>
                                    </div>

                            </div>
                        </div>


                        <?php
                    }
                    ?>



                </div>
            </div>
            <div class="page_container el-pagination is-background">
                <button type="button"  class="btn-prev" onclick="page_next(-1)">
                    <span>上一页</span></button>
                <ul class="el-pager">
                  </ul>
                <button type="button" class="btn-next" onclick="page_next(1)">
                    <span>下一页</span></button>
            </div>

            <p class="tit">提示：每个彩种，开奖历史都显示最近3天内的数据</p></div>
    </div>
</div>


<script>
    var page=1;
    var gameid=<?php echo $lotteryId;?>;
    var pagesum=0;
    var gamelist=JSON.parse(JSON.stringify(<?php echo json_encode($game_list); ?>));

    function click_left() {
        if(  document.querySelector('.cont').scrollLeft>0)
            movestep(-1)
    }
    function  click_right() {
      movestep(1)
    }

    function movestep(num) {
        var from=0;
        var to=76;

        var timer= setInterval(function () {
            from++;
            document.querySelector('.cont').scrollLeft+=3*num;
            if(from>=to) clearInterval(timer);
        },1)

    }
    function click_game(id,num) {
        var li =document.querySelector('#menu_nav').querySelectorAll('li');
        for(var i=0;i<li.length;i++){
            if(i==num){
                li[i].className='active';
            }else{
                li[i].className='';
            }
        }
        document.querySelector('#lotterydata').style.transform="translateX(-"+num*950+"px)"
       gameid=id;
        getdata(id);
    }
    function  getdata(id) {


        $.get("../api/index.php?act=lotterylist",{lotteryId:id,current:page,pageSize:15}, function(result){
            var res=JSON.parse(result);
            if(res.code==200){

              var data=res.data;

              var html="";
              for(var i=0;i<data.records.length;i++){
                  html+=gethtmldata(data.records[i]);
              }
              $('#loattery_'+id).html(html);
                setpage(data.pages);

            }else{

            }

        });
    }
    function  gethtmldata(item) {
    var html='<tr class="el-table__row"> <td  class="el-table_1_column_1 is-center table-column">';


          html+='<div class="cell">'+item.predictedTime+'</div></td>';
          html+='<td class="el-table_1_column_2 is-center table-column">';
        html+='<div class="cell">'+item.issueNo+'</div></td>';
         html+='<td class="el-table_1_column_3 is-center table-column">';
         html+='<div class="cell">';

            var opencode=item.openCode.split(',');
            for(var i=0;i<opencode.length;i++){
                if(item.gametype=='pk10'){
                    html+='<p class="'+item.gametype+' num_'+opencode[i]+'">'+opencode[i]+'</p>';
                }else if(item.gametype=='k3'){
                    html+='<div class="'+item.gametype+' num_'+opencode[i]+'"></div>';
                }else {
                    html+='<span class="'+item.gametype+' num_'+opencode[i]+'">'+opencode[i]+'</span>';
                }
            }
        html+="  </div></td></tr>";

        return html;
    }
    function  setpage(sum) {
        pagesum=sum;
        var html="";
          if(page>4){
              var from=page-2;
              var to=page+2;
          }
          else {var from=1;
          var to=6;
          }
         if(to>sum)  to=sum;
          if(from>2){
             html+='<li class="number" onclick="getpage(1);">1</li><li class="el-icon more btn-quicknext el-icon-more"></li>';
          }
           for(var i=from;i<=to;i++){
              if(i==page) var active='active';
              else var active="";
              html+="<li  onclick=\"getpage("+i+");\" class=\"number "+active+" \">"+i+"</li>";
           }
           if(to<sum-1)   html+='<li  onclick="getpage('+sum+');" class="el-icon more btn-quicknext el-icon-more"></li><li class="number">'+sum+'</li>';
          $('.el-pager').html(html)

    }
    function getpage(num) {
        page=num;
        getdata(gameid);
    }
    function page_next(num) {
         page=page+num;
         if(page<1) page=1;
         if(page>pagesum) page=pagesum;
         getdata(gameid);
    }

    function lottery_update(data) {
        for(var i=0;i<gamelist.length;i++){
            if(gamelist[i].id==gameid){
                var gamekey=gamelist[i].showkey;
                break;
            }
        }

        for(var i=0;i<data.length;i++){
            var item=data[i];
            if(item.gamekey.toLowerCase() == gamekey.toLowerCase()){

//                var res =dataformat(item);
//               var tr= document.querySelector('#loattery_'+gameid).querySelectorAll('tr');
//             var cell=  tr[0].querySelectorAll('.cell');
//               if(cell[1].innerHTML!=res.issueNo){
//
//               }

                getdata(gameid);
                break;
            }

        }
    }
    function dataformat(item){
        var data={};
        data.gametype=gametype;
        data.issueNo=item.expect;
        data.openCode=item.number;
        if(item.lasttime>parseInt((new Date()).getTime() / 1000))
            data.lastsecond=item.lastsecond - parseInt((new Date()).getTime() / 1000)
        else
            data.lastsecond=item.lasttime;
        data.predictedTime=timestampToTime(item.time);
        data.SX=24;
        return data;
    }
    function timestampToTime(timestamp) {
        var date = new Date(timestamp * 1000);//时间戳为10位需*1000，时间戳为13位的话不需乘1000
        var Y = date.getFullYear() ;
        var M = (date.getMonth()+1 < 10 ? '0'+(date.getMonth()+1) : date.getMonth()+1);
        var D = date.getDate();
        var h = date.getHours();
        var m = date.getMinutes();
        var s = date.getSeconds();
        if(D<10) D='0'+D;
        if(h<10) h='0'+h;
        if(m<10) m='0'+m;
        if(s<10) s='0'+s;
        return Y+'-'+M+'-'+D+' '+h+':'+m+':'+s;
    }

    function open_trend() {
        parent.layer.open({
            type: 2,
            title: false,
            shadeClose: true,
            closeBtn:true,
            shade: 0.6,
            area: ['1180px', '800px'],
            content: "/trend/index.php?id="+gameid //iframe的url
        });
    }

    function open_plan() {
       if(gameid<27 ) var id=gameid;
       else var id=22;
        parent.window.open("/pc.php?id="+id+'#/plan');
    }
    movestep(<?php echo $sortnum; ?>);
  getdata(gameid);

</script>




</body>

</html>