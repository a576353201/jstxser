

<?php include_once template("header");?>

<div class="header" style="padding: 5px 0px;">
    <span class="back" onclick="history.back();" style="top:5px;"><i class="icon-left-open-3"></i></span>
    <div class="navright" onclick="show_addnav1();" style="top:5px;">
        <i class="icon-plus-1" style="font-size: 28px"></i>
    </div>
    <div id="head_nav" class="nav" style="width: 60%;left: 20%;top:5px;">
        <div class="item active" onclick="plan_shownav();">计划</div>
        <div class="item" style="border-left: 1px solid #2319dc;width: 33%" onclick="plan_toplist();" >排行榜</div>
        <div class="item" style="border-left: 1px solid #2319dc;" onclick="plan_task();"  >任务</div>
    </div>

</div>
<div class="addnav"  id="addnav_1" style="top:47px;">
    <?php if($user['isvip']==1){?>
    <li  onclick="plan_add();"><i class="icon-plus"></i>发布计划</li>
    <li onclick="location.href='/plan/my_add.php';"><i class="icon-user"></i>我的发布</li>
    <?php } else { ?>
    <li class="button" onclick="plan_apply();">  <i class="icon-chart"></i>申请计划员</li>
    <?php }?>

    <li onclick="my_plan_reward(0);"><i class="icon-money"></i>打赏记录</li>
    <li onclick="my_plan_action(0);"><i class="icon-star"></i>我的关注</li>
</div>
<?php include_once template("plan/header");?>


<div class="planbox">

        <?php include_once template("plan/top");?>
        <ul class="menulist" id="menulist" >
            <li id="wanfa" onclick="click_nav(this);"><p >选择玩法</p>

                <i class="icon-down-open-1"></i>

            <div class="nav">
                <span  onclick="wanfa_change('','选择玩法');" style="display: none;">不限玩法</span>
                <?php if(is_array($wanfa_arr[$game['type']])){foreach($wanfa_arr[$game['type']] AS $index=>$value) { ?>
              <span  onclick="wanfa_change('<?php echo $index; ?>','<?php echo $value; ?>');" id="wf_<?php echo $index; ?>"><?php echo $value; ?></span>
                <?php }}?>
            </div>
            </li>
            <li id="order" onclick="click_nav(this);"><p>排序方式</p>    <i class="icon-down-open-1"></i>
                <div class="nav">
                    <span id="order_view" onclick="order_change('view','热度');">按热度</span>
                    <span id="order_rate" class="active" onclick="order_change('rate','中奖率');">按中奖率</span>
                    <span id="order_updatetime" onclick="order_change('updatetime','更新时间');">按更新时间</span>
                    <span id="order_prize_num" onclick="order_change('prize_num','当前连中');">按当前连中</span>
                </div>
            </li>
            <li id="fee" onclick="click_nav(this);"><p>付费方式</p>
                <i class="icon-down-open-1"></i>
                <div class="nav">
                    <span class="active" id="fee_0"  onclick="fee_change('0','付费方式');">不限</span>
                    <span  id="fee_2" onclick="fee_change('2','免费');">免费</span>
                    <span id="fee_1" onclick="fee_change('1','付费');">付费</span>
                </div>
            </li>
            <li id="isonline" onclick="click_nav(this);"><p>在线状态</p>
                <i class="icon-down-open-1"></i>
                <div class="nav">
                    <span class="active" id="isonline_0" onclick="online_change('0','在线状态');">不限</span>
                    <span id="isonline_1"  onclick="online_change('1','计划员在线');">计划员在线</span>

                </div>
            </li>

<span class="search" style="display: none">
    <input type="text" value="" id="keyword" placeholder="输入编号直接查看" autocomplete="off">
<i class="icon-search" onclick="plan_search();"></i>
</span>

        </ul>

    <div class="notes">


        <div class="msglist11" id="msglist">
            <div class="list1">

                <?php echo rewardlist(); ?>
            </div>
            <div class="list2">


            </div>

        </div>

    </div>
        <div class="contentbox">
            <div id="plan_list" class="list" style="clear: both;">


            </div>
            <div id="newifr" class="iframe">

            </div>
            <div class="nodata" id="loadmore" style="display: none;color: #666;clear: both;">
                加载更多...
            </div>
        </div>

    </div>


<iframe src="/plan/task.php?from=layer" id="ifr"></iframe>

<iframe src="/plan/toplist.php?from=layer" id="ifr1"></iframe>
<div class="page_container el-pagination is-background" style="display: none;">
    <button type="button" class="btn-prev" onclick="page_num(-1);"><span>上一页</span></button>
    <ul class="el-pager">

    </ul>
    <button type="button" class="btn-next" onclick="page_num(1);"><span>下一页</span></button>
</div>
<script>
    var gamekey='<?php echo $game['showkey']; ?>';
    var maxpage=1;
    var wanfa='';
    var order='rate';
    var fee='0';
    var isonline='0';
    var showtype='list';
    var page=1;
    var plandata="";

    get_plan_list();
    setInterval(function () {
        set_updown1('msglist');
    },5000)
   var hh= document.documentElement.clientHeight;
    hh=hh-90;
    document.querySelector('#ifr').style.height=hh+'px';
    document.querySelector('#ifr1').style.height=hh+'px';
    document.querySelector('.contentbox').onscroll = function() {
        //var height = document.getElementById("divData").offsetHeight;//250
        //var height=$("#divData").height();//250
        var scrollHeight =   document.querySelector('.contentbox').scrollHeight;//251
        var scrollTop =  document.querySelector('.contentbox').scrollTop;//0-18
        var clientHeight =   document.querySelector('.contentbox').clientHeight;//233

        if (scrollHeight - clientHeight - scrollTop<=100) {
               page++;
            get_plan_list();
            $('#loadmore').show();
        }else{
            $('#loadmore').hide();
        }
    };

    function  click_nav(div) {
        if(div.className!='active'){
            div.className='active';
        }else
        {
            div.className='';
        }
    }
    function wanfa_change(value,name) {
        wanfa=value;
        page=1;
        get_plan_list();
       $('#wanfa p').html(name);
      var span= document.querySelector('#wanfa').querySelector('.nav').querySelectorAll('span');
      for(var i=0;i<span.length;i++){
          if(span[i].id=='wf_'+value) span[i].className='active';
          else span[i].className='';
      }
      if(value=='')span[0].style.display='none';
        else span[0].style.display='';


    }

    function order_change(value,name) {
        order =value;
        page=1;
        get_plan_list();
        $('#order p').html(name);
        var span= document.querySelector('#order').querySelector('.nav').querySelectorAll('span');
        for(var i=0;i<span.length;i++){
            if(span[i].id=='order_'+value) span[i].className='active';
            else span[i].className='';
        }

    }
    function fee_change(value,name) {
        fee =value;
        page=1;
        get_plan_list();
        $('#fee p').html(name);
        var span= document.querySelector('#fee').querySelector('.nav').querySelectorAll('span');
        for(var i=0;i<span.length;i++){
            if(span[i].id=='fee_'+value) span[i].className='active';
            else span[i].className='';
        }

    }
    function online_change(value,name) {
        isonline =value;
        page=1;
        get_plan_list();
        $('#isonline p').html(name);
        var span= document.querySelector('#isonline').querySelector('.nav').querySelectorAll('span');
        for(var i=0;i<span.length;i++){
            if(span[i].id=='isonline_'+value) span[i].className='active';
            else span[i].className='';
        }

    }

    window.onload=function () {
        get_plan_list();
    }


   var menuid=1;
</script>


<?php include_once template("footer");?>