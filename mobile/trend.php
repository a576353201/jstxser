<?php
include_once '../inc/common.php';
if($_GET['top']) $top=$_GET['top'];
else $top=30;
if($_GET['type']=='list' and $_GET['playkey']  and $top){
    $return =array();
      $str='';
      $game=get_table(tname('game'),$_GET['playkey']);

      $showkey=$game['showkey'];

    if(strpos($top,'day')!==false){
        $limit='';
        $num=substr($top,3,1);
        $fromtime=strtotime(date('Y-m-d',time()-$num*24*3600).' 00:00:00');
        $totime=$fromtime+24*3600-1;
        $str.=" and lottime>='{$fromtime}' and lottime<='{$totime}' ";

    }
    else{
        $limit="limit 0,{$top}";
    }

    $sql="select * from ".lottery_table($showkey)." where 1=1 {$str} order by period desc,id desc {$limit}";

    $list=$db->fetch_all($sql);
    if(count($list)>0){
        $return['result']=1;
        $return['returnval']='操作成功';
        $return['recordcount']=count($list);
        $return['table']=array();
        foreach ($list as $key=>$value){

            $temp=array();
            $temp['id']=$value['id'];
            $temp['type']=$value['code'];
            $temp['title']=$value['period'];
            $temp['number']=$value['number'];
            $num=explode(',',$value['number']);
            $sum=0;

            foreach ($num as $value1){

                $sum+=$value1;
            }
            $temp['total']=$sum;
            $temp['ds']=0;
            $temp['dx']=0;
            $temp['opentime']=$value['lottime'];
            $temp['flag']=0;
            $temp['flags']=0;
            $temp['isfill']=1;
            $return['table'][]=$temp;

        }
        $list=array();
        for($i=count($return['table'])-1;$i>=0;$i--){
            $list[]=$return['table'][$i];
        }
        $return['table']=$list;
        echo json_encode($return);
    }


    exit();
}

$game=$db->exec("select * from ".tname('game')." where id='{$_GET['id']}'");
$top_arr=array('30'=>'30期','50'=>'50期','day0'=>'今日数据','day1'=>'昨日数据','day2'=>'前日数据');

$tabs_nav2=array();




    $tabs_nav1=array('danhao'=>'单号走势','duohao'=>'多号走势','lhh'=>'龙虎和','dx'=>'大小走势','ds'=>'单双走势','5xhz'=>'五星和值','hz'=>'和值','kd'=>'跨度');

    $tabs_nav2['danhao']=array('万位','千位','百位','十位','个位');
    $tabs_nav2['duohao']=array('0-4'=>'五星','1-4'=>'后四','0-2'=>'前四','2-4'=>'后三','1-3'=>'中三','0-2'=>'前三','3-4'=>'后二','0-1'=>'前二');
    $tabs_nav2['dx']=array('0-2'=>'万百千','2-4'=>'百十个');
    $tabs_nav2['ds']=array('0-2'=>'万百千','2-4'=>'百十个');
    $tabs_nav2['5xhz']=array('大小单双');
    $tabs_nav2['hz']=array('各类');
    $tabs_nav2['kd']=array('各类');
    $tabs_nav2['lhh']=array('01-02'=>'万千 万百','03-04'=>'万十 万个','12-13'=>'千百 千十','14-23'=>'千个 百十','24-34'=>'百个 十个');


if($_GET['key1']) $wanfa_key1=$_GET['key1'];
else $wanfa_key1=key($tabs_nav1);
if($_GET['key2']) $wanfa_key2=$_GET['key2'];
else $wanfa_key2=key($tabs_nav2[$wanfa_key1]);

$wanfa_name1=$tabs_nav1[$wanfa_key1];
$wanfa_name2=$tabs_nav2[$wanfa_key1][$wanfa_key2];
?>
<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/html" xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="UTF-8">
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta name="format-detection" content="telephone=no, email=no, date=no, address=no">

<link href='static/chart/main.css?v=<?php echo time();?>' rel="stylesheet" type="text/css" />
    <script src="static/main.js"></script>
    <link rel="stylesheet" type="text/css" href="/static/fontello.css" />
</head>
<body>
<style>
    .gamenav{
        position: fixed;
        top:70px;
        left: 0px;
        width: 115px;
    ;
        z-index:5;
        background-color: rgba(0,0,0,0.7);
        line-height: 35px;
        padding: 5px 5px;
        transform: translate(0,-100vh);

        transition: .5s;
    }
    .gamenav.active{
        transform: translate(0,0);
    }
    .gamenav li{
        height: 35px;
        line-height: 35px;
        color: #fff;
        cursor: pointer;
        width: 100%;
        border-bottom:1px dashed #fff;
        font-size: 14px;
        text-align: center;
    }
    .gamenav li i{margin-right: 5px;}
    .gamenav li:hover{
        color: #2319dc;
    }


</style>
<div class="query-form" style="height: 70px;top:0px;">
    <div style="display: block;text-align: center">

        <?php
        foreach ($top_arr as $key1=>$item1){

                ?>

                  <a <?php if($top==$key1) echo 'class="current"';?>   onclick="change_num('<?php echo $key1;?>');" ><?php echo $item1;?></a>

                <?php


        }
        ?>
    </div>
    <div style="height: 30px;line-height: 30px" >

        <span onclick="show_gamenav1();" style="float: left;padding-left: 10px;color: #2319dc;"><?php echo  $game['title'];?> <i id="gameicon" class="icon-down-open"></i></span>

<div id="wanfa_title" style="display: inline-block;color: #2319dc" onclick="showtabs();" >
            <?php
            echo $wanfa_name1.'_'.$wanfa_name2;
            ?>
        </div>
        <input type="checkbox" name="checkbox2" value="checkbox" id="has_line" style="display:none ">
        <input type="checkbox" name="checkbox" value="checkbox" id="no_miss" checked="checked" style="display:none ">


        <div style="display: inline-block;float: right;width: 50px;text-align: center;color: #2319dc" onclick="showtabs();" >

            <img src="static/img/setting.png" style="height: 16px;vertical-align: middle;"> 切换
        </div>


    </div>

</div>

<div class="gamenav" >
    <?php
    $gamelist=$db->fetch_all("select * from ".tname('game')." where status='1'  and `type` in ('ssc','ffc') order by sortnum asc,id asc");
    foreach ($gamelist as $value){
        ?>
        <li onclick="location.href='?id=<?php echo $value['id'];?>';"><?php echo $value['title']?></li>

    <?php
    }
    ?>

</div>
<div class="showtabs" >

    <?php
    foreach ($tabs_nav1 as $key=>$item) {
        ?>


        <div class="lines">
            <?php
            echo $item;
            ?>
        </div>
        <div class="line-btn">
            <?php
            foreach ($tabs_nav2[$key] as $key1=>$item1) {
                ?>
   <span id="item_<?php echo $key;?>_<?php echo $key1;?>"
                      class="item <?php  if($wanfa_key1 == $key && $wanfa_key2 == $key1) echo "current"?>"
                      onclick="show_wanfa('<?php echo $key;?>','<?php echo $key1;?>','<?php echo $item;?>','<?php echo $item1;?>',this);">
                    <?php
                    echo $item1;
                    ?>
    </span>

                <?php
            }
            ?>


        </div>


        <?php
    }
    ?>

</div>

<div style="clear: both;height:70px;">

</div>

<div style="clear: both;display: inline-block;width: 100%"  >

    <?php
    include_once 'chart.php'
    ?>

</div>








<script>

    var wanfa_key1='<?php echo $wanfa_key1;?>';
    var wanfa_key2='<?php echo $wanfa_key2;?>';
    var lotteryId='<?php echo $_GET['id'];?>';
    var topnum='<?php echo $top;?>';
    var gametype='ssc';
    var wanfa_title1='';
    var wanfa_title2='';
    window.scroll(0, 999999);
    function  go_next(id) {
        location.href='?id='+id;
    }
    function  showtabs() {

        if(document.querySelector('.showtabs').className=='showtabs'){
            document.querySelector('.showtabs').className='showtabs active';
        }
        else{
            document.querySelector('.showtabs').className='showtabs';
        }
    }

    function show_wanfa(key1,key2,name1,name2,div) {

        var item= document.querySelector('.showtabs').querySelectorAll('.item');
        for(var i=0;i<item.length;i++){

            item[i].className='item';
        }
        div.className='item current';
        wanfa_key1=key1;
        wanfa_key2=key2;
        wanfa_title1=name1;
        wanfa_title2=name2;
        if(key1=='danhao') danhaoList();
        if(key1=='duohao') duohaoList();
        if(key1=='dx' || key1=='ds') dxList(key1);
        if(key1=='5xhz') hz5xList();
        if(key1=='hz' || key1=='kd') hzList(key1);
        if(key1=='lhh') lhhList();
        if(key1=='hmds') hmdsList();
        if(key1=='hzxt') hzxtList();
        if(key1=='hz1') hz1List();
        if(key1=='hz2') hz2List();
        if(key1=='josx') josxList();
        document.getElementById('wanfa_title').innerHTML=name1+'_'+name2;
        document.querySelector('.showtabs').className='showtabs';
    }
    var lotteryDate='';
    var lastissue='';
   function getlotterydata() {
       url = "?type=list&playkey=" + lotteryId + "&top=" + topnum;
       $.ajax(url, {
               data: "",
               dataType: 'json',
               crossDomain: true,
               success: function (d) {

                   var data=d.table;

                   if(lastissue!=data[data.length-1]['title']){
                       lastissue=data[data.length-1]['title'];
                       lotteryDate = d;
                       document.getElementById('item_'+wanfa_key1+'_'+wanfa_key2).click();
                   }

                   // daxiaoList();
               }
           }
       )
   }


    $(document).ready(function () {
        getlotterydata();
        // daxiaoList();
      setInterval(function () {
          getlotterydata();
      },5000)



    });
    function change_num(num) {
        var url='?id=<?php echo $_GET['id'];?>&top='+num+'&key1='+wanfa_key1+'&key2='+wanfa_key2+'&from=<?php echo $_GET['from']?>';

        location.href=url;

    }

    parent.gameid=<?php echo $_GET['id'];?>;
</script>
</body>
</html>