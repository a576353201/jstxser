<script type="text/javascript" src="<?php echo $HttpPath; ?>static/web/js/pk10/trend-public.js?v=c167ceaa2357dd0f98caf9a7514f1ea5"></script>
<script type="text/javascript" src="<?php echo $HttpPath; ?>static/web/js/pk10/pk10-trend-open.js?v=c167ceaa2357dd0f98caf9a7514f1ea5"></script>
    <div style="background-color: #ffffff;">
        <div class="common-zs-title">
            <span><?php echo $gameinfo['title']; ?>走势图</span>
            <span class="lg-tab-span">收起全部项目</span>
        </div>
        <div class="common-zs-tab common-zs-tab-div">
            <div>
                <span>位置走势:</span>
                <?php if(is_array($pos_arr)){foreach($pos_arr AS $key=>$value) { ?>
                <a href="?pos_type=1&pos_num=<?php echo $key; ?>" <?php if($pos_type==1 && $key==$pos_num){?>class="active"<?php }?> ><?php echo $value; ?></a>
                <?php if($key<10) echo '<b>|</b>';?>


                <?php }}?>

            </div>
            <div>
                <span>车号走势:</span>
                <?php if(is_array($pos_arr)){foreach($pos_arr AS $key=>$value) { ?>
                <a href="?pos_type=2&pos_num=<?php echo $key; ?>" <?php if($pos_type==2 && $key==$pos_num){?>class="active"<?php }?> ><?php echo $key; ?>号</a>
                <?php if($key<10) echo '<b>|</b>';?>

                <?php }}?>

            </div>
            <div>
                <span>和值走势:</span>
                <a href="?pos_type=3" <?php if($pos_type==3){?>class="active"<?php }?>>冠亚和</a>
            </div>
            <div>
                <span>龙虎走势:</span>

                <?php if(is_array($pos_arr)){foreach($pos_arr AS $key=>$value) { ?>
                <?php if($key<5) { ?>
                <a href="?pos_type=4&pos_num=<?php echo $key; ?>" <?php if($pos_type==4 && $key==$pos_num){?>class="active"<?php }?> ><?php echo $value; ?>龙虎</a>
               <?php } ?>
                <?php if($key<4) echo '<b>|</b>';?>

                <?php }}?>


            </div>
            <div>
                <span>组合走势:</span>
                <?php if(is_array($pos_arr)){foreach($pos_arr AS $key=>$value) { ?>
                <a href="?pos_type=5&pos_num=<?php echo $key; ?>" <?php if($pos_type==5 && $key==$pos_num){?>class="active"<?php }?> ><?php echo $value; ?></a>
                <?php if($key<10) echo '<b>|</b>';?>


                <?php }}?>
            </div>
        </div>
        <div class="common-zs-tab-title"><?php echo $gameinfo['title']; ?><?php if($pos_type==1){?><?php echo $pos_arr[$pos_num]; ?><?php }?><?php if($pos_type==2){?><?php echo $pos_num; ?>号<?php }?><?php if($pos_type==3){?>冠亚和<?php }?><?php if($pos_type==4){?><?php echo $pos_arr[$pos_num]; ?>龙虎<?php }?><?php if($pos_type==5){?>组合<?php echo $pos_arr[$pos_num]; ?><?php }?>走势图
            <span class="set-select hide-set">隐藏设置</span>
        </div>
        <div class="common-zs-all-kind">
            <div class="common-zs-all-kind-top">
                <div class="common-zs-all-kind-top-issue">
                    <span data-val="10">10期</span>
                    <span data-val="30" class="active" >30期</span>
                    <span data-val="100" >100期</span>
                    <span data-val="300">300期</span>
                    <span data-val="1000">1000期</span>
                    <input type="number" name="issue" placeholder="输入期数" onkeyup="this.value=this.value.replace(/[^\r\n0-9\,\|\ ]/g,'');">期<label class="select-issue-check" style="padding: 0 2px;">查询</label>
                </div>
                <div class="common-zs-all-kind-top-other">
                    <span data-val="0" class="active">连期</span>
                    <span data-val="2">后二同期</span>
                    <span data-val="3">后一同期</span>
                    <span data-val="4">同时分</span>
                    <span data-val="5">单期</span>
                    <span data-val="6">双期</span>
                </div>
                <div class="common-zs-all-kind-top-date">
                    <span data-val="0db">今天</span>
                    <span data-val="1db">昨天</span>
                    <span data-val="2db">前天</span>
                    <div class="lg-home-history-check">
                        <div class="layui-form">
                            <div class="layui-form-item" style="margin-bottom:0;">
                                <div class="layui-inline" style="margin-bottom:0;margin-right:0;">
                                    <div class="layui-input-inline">
                                        <input type="text" class="layui-input" id="date" placeholder="请选择日期" lay-key="1">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="common-zs-all-kind-top-date-check">查询</div>
                    </div>
                </div>
            </div>
            <div class="common-zs-all-kind-bottom">
                <div class="left-form">
                    <form class="layui-form">
                        <div class="layui-form-item left-form">
                            <label class="layui-form-label">显示:</label>
                            <div class="layui-input-block">
                                <input type="checkbox" name="demo-check" lay-skin="primary" lay-filter="yl" title="遗漏" value="遗漏" checked=""><div class="layui-unselect layui-form-checkbox layui-form-checked" lay-skin="primary"><span>遗漏</span><i class="layui-icon"></i></div>
                                <input type="checkbox" name="demo-check" lay-skin="primary" lay-filter="ylfc" title="遗漏分层"><div class="layui-unselect layui-form-checkbox" lay-skin="primary"><span>遗漏分层</span><i class="layui-icon"></i></div>
                                <input type="checkbox" name="demo-check" lay-skin="primary" lay-filter="fhx" title="分行线"><div class="layui-unselect layui-form-checkbox" lay-skin="primary"><span>分行线</span><i class="layui-icon"></i></div>
                                <input type="checkbox" name="demo-check" lay-skin="primary" lay-filter="flx" title="分列线" checked=""><div class="layui-unselect layui-form-checkbox" lay-skin="primary"><span>分列线</span><i class="layui-icon"></i></div>
                                <!--<input type="checkbox" name="demo-check" lay-skin="primary" lay-filter="lh" title="邻号"><div class="layui-unselect layui-form-checkbox" lay-skin="primary"><span>邻号</span><i class="layui-icon"></i></div>-->
                                <!--<input type="checkbox" name="demo-check" lay-skin="primary" lay-filter="th" title="跳号"><div class="layui-unselect layui-form-checkbox" lay-skin="primary"><span>跳号</span><i class="layui-icon"></i></div>-->
                                <input type="checkbox" name="demo-check" lay-skin="primary" lay-filter="ych" title="预测行"><div class="layui-unselect layui-form-checkbox" lay-skin="primary"><span>预测行</span><i class="layui-icon"></i></div>
                                <input type="checkbox" name="demo-check" lay-skin="primary" lay-filter="date" title="年月日">
                                <input type="checkbox" name="demo-check" lay-skin="primary" lay-filter="hour" title="时分">
                                <input type="checkbox" name="demo-check" lay-skin="primary" lay-filter="total" title="统计" checked=""><div class="layui-unselect layui-form-checkbox layui-form-checked" lay-skin="primary"><span>统计</span><i class="layui-icon"></i></div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="right-form">
                    <div class="right-form1">
                        <form class="layui-form">
                            <div class="layui-form-item">
                                <label class="layui-form-label">球形:</label>
                                <div class="layui-input-block">
                                    <input type="radio" name="kind" value="0" lay-filter="kind" title="圆" checked>
                                    <input type="radio" name="kind" value="1" lay-filter="kind" title="方">
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="right-form2">
                        <form class="layui-form">
                            <div class="layui-form-item">
                                <label class="layui-form-label">颜色:<i class="iconfont icon-paixuxia"></i></label>
                                <div class="layui-input-block">
                                    <input type="radio" name="kind" value="0" lay-filter="color" title="彩色" checked>
                                    <!--<input type="radio" name="kind" value="1" lay-filter="color" title="全红">-->
                                    <input type="radio" name="kind" value="2" lay-filter="color" title="全白">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>




        <?php include_once template("$tpl_name1");?>


    </div>