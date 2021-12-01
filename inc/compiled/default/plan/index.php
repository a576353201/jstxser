

<?php include_once template("header");?>


<?php include_once template("plan/header");?>


<div class="planbox">

<div>
    <div id="gamelist">
        <?php if(is_array($gamelist)){foreach($gamelist AS $index=>$value) { ?>
        <div class="list <?php if($game['id']==$value['id']){?>active<?php }?>" onclick="click_gameplan(<?php echo $value['id']; ?>,'<?php echo $value['type']; ?>');" >

            <li>
                <img src="/<?php echo $value['logo']; ?>">

            </li>
            <li>
                <div class="title"><?php echo $value['title']; ?></div>
                <div class="time"><?php echo $value['content']; ?></div>
            </li>
        </div>
        <?php }}?>


    </div>



</div>

    <div>
        <?php include_once template("plan/top");?>
        <ul class="menulist" id="menulist" >
            <li id="wanfa"><p >选择玩法</p>

                <i class="icon-down-open-1"></i>

            <div class="nav">
                <span  onclick="wanfa_change('','选择玩法');" style="display: none;"><i class="icon-right-open-1"></i>不限玩法</span>
                <?php if(is_array($wanfa_arr[$game['type']])){foreach($wanfa_arr[$game['type']] AS $index=>$value) { ?>
              <span  onclick="wanfa_change('<?php echo $index; ?>','<?php echo $value; ?>');" id="wf_<?php echo $index; ?>"><i class="icon-right-open-1"></i><?php echo $value; ?></span>
                <?php }}?>
            </div>
            </li>
            <li id="order"><p>排序方式</p>    <i class="icon-down-open-1"></i>
                <div class="nav">
                    <span id="order_view" onclick="order_change('view','按热度排序');"><i class="icon-right-open-1"></i>按热度</span>
                    <span id="order_rate" class="active" onclick="order_change('rate','按中奖率排序');"><i class="icon-right-open-1"></i>按中奖率</span>
                    <span id="order_updatetime" onclick="order_change('updatetime','按更新时间');"><i class="icon-right-open-1"></i>按更新时间</span>
                    <span id="order_prize_num" onclick="order_change('prize_num','按当前连中');"><i class="icon-right-open-1"></i>按当前连中</span>
                </div>
            </li>
            <li id="fee" ><p>付费方式</p>
                <i class="icon-down-open-1"></i>
                <div class="nav">
                    <span class="active" id="fee_0"  onclick="fee_change('0','付费方式');"><i class="icon-right-open-1"></i>不限</span>
                    <span  id="fee_2" onclick="fee_change('2','免费');"><i class="icon-right-open-1"></i>免费</span>
                    <span id="fee_1" onclick="fee_change('1','付费');"><i class="icon-right-open-1"></i>付费</span>
                </div>
            </li>
            <li id="isonline"><p>在线状态</p>
                <i class="icon-down-open-1"></i>
                <div class="nav">
                    <span class="active" id="isonline_0" onclick="online_change('0','在线状态');"><i class="icon-right-open-1"></i>不限</span>
                    <span id="isonline_1"  onclick="online_change('1','计划员在线');"><i class="icon-right-open-1"></i>计划员在线</span>

                </div>
            </li>

<span class="search" style="display: none">
    <input type="text" value="" id="keyword" placeholder="输入编号直接查看" autocomplete="off">
<i class="icon-search" onclick="plan_search();"></i>
</span>

        </ul>


        <div class="content">
            <div id="plan_list" class="list">


                   <?php if(is_array($list)){foreach($list AS $index=>$item) { ?>
                <div class="item" id="plan_<?php echo $item['id']; ?>">
                    <div class="title" onclick="open_plan(<?php echo $item['id']; ?>)"><?php echo $item['title']; ?></div>
                    <div class="info" onclick="open_plan(<?php echo $item['id']; ?>)"><span class="wanfa"><?php echo $item['wanfa']; ?></span>  [ <?php echo $item['num']; ?><?php echo $item['numshow']; ?> ] ［<?php echo $item['donum']; ?>/<?php echo $item['expect_num']; ?>期］</div>
                    <div class="info" onclick="open_plan(<?php echo $item['id']; ?>)">当前连中：<?php echo $item['prize_num']; ?>，中奖率：<?php echo $item['rate']; ?>%</div>
                    <div class="info"><?php echo $item['content']; ?></div>
                    <div class="tools"> <i class=" icon-eye"></i><?php echo $item['view']; ?></div>
                </div>

                <?php }}?>
            </div>
            <div id="newifr" class="iframe">

            </div>
        </div>

    </div>
</div>
<div class="page_container el-pagination is-background">
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



    function wanfa_change(value,name) {
        wanfa=value;
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

    parent.document.querySelector('.tasknav').style.display='block';
    // parent.document.querySelector('.footer').style.display='none';
    window.onunload=function () {
        parent.document.querySelector('.tasknav').style.display='none';
        // parent.document.querySelector('.footer').style.display='block';
    }

</script>


<?php include_once template("footer");?>