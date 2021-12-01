<link rel="stylesheet" href="<?php echo $HttpTemplatePath; ?>static/css/plan.css?v=<?php echo $cachekey; ?>" type="text/css" media="screen" />
<script src="/static/js/plan_mobile.js?v=<?php echo $cachekey; ?>"></script>
<div class="plantools" style="display: none">
    <li class="active">
        <i class="icon-chart-line"></i>热门计划
    </li>
    <li onclick="plan_toplist();">
        <i class="icon-trophy"></i>排行榜
    </li>
    <li onclick="plan_task();" >
        <i class="icon-gift-1"></i>任务中心
    </li>

    <?php if($_SESSION['userid']>0){?>
    <li>
        <i class="icon-menu"></i>计划中心
        <div class="menulist">
            <?php if($user['isvip']==1){?>
            <span  onclick="plan_add();"><i class="icon-plus"></i>发布计划</span>
            <span onclick="my_plan_add();"><i class="icon-user"></i>我的发布</span>
            <?php } else { ?>
            <span class="button" onclick="plan_apply();">  <i class="icon-chart"></i>申请计划员</span>
            <?php }?>

            <span onclick="my_plan_reward(0);"><i class="icon-money"></i>打赏记录</span>
            <span onclick="my_plan_action(0);"><i class="icon-star"></i>我的关注</span>
        </div>

    </li>
    <?php }?>
</div>
<style>

    .layui-layer {
        border-radius: 8px;
    }
    #ClCache{
        display: none;
    }
</style>
