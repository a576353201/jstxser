
<?php include_once template("header");?>
<?php include_once template("game/header");?>

<link rel="stylesheet" href="<?php echo $HttpTemplatePath; ?>51cp/static/web/css/pk10/hot.css?v=c167ceaa2357dd0f98caf9a7514f1ea5" type="text/css"/>

<script type="text/javascript" src="<?php echo $HttpPath; ?>static/web/js/echart/echarts.common.min.js?v=11233"></script>
<script type="text/javascript" src="<?php echo $HttpPath; ?>static/web/js/jqueryUi/jquerui-min-js.js?v=c167ceaa2357dd0f98caf9a7514f1ea5"></script>



<div class="container cst-mainbody" style="padding:0;">

        <!--号码冷热-->
        <div class="lg-hot-main">
            <div class="lg-hot-type">
                <?php
                foreach($nav_list as $key=>$value){
                ?>
                <a href="<?php echo $value['url']; ?>" <?php if($key==$action) echo 'class="active"';?> ><?php echo $value['title']; ?></a>

                <?php } ?>

            </div>

            <!--选择类型-->
            <div class="lg-hot-kind" style="background-color: #f0f0f0;">
                <div class="lg-hot-select">
                    <div class="lg-hot-select-span" style="display: none">
                        <span data-val="0" class="active">全部</span>
                        <?php
                        foreach($pos_arr as $key=>$value){
                      ?>
                        <span data-val="<?php echo $key+1;?>"><?php echo $value;?></span>
                        <?php } ?>

                    </div>
                    <div class="lg-hot-issue" style="float: left;padding-top: 10px;">
                        <a>期数:</a>
                        <select onchange="param.period = this.value; ajaxLoad();" style="background-color: #fff;">
                            <option value="0db">今日</option>
                            <option value="1db">昨日</option>
                            <option value="2db">前日</option>
                            <option value="10">10期</option>
                            <option value="30">30期</option>
                            <option value="100" selected >100期</option>
                            <option value="300">300期</option>
                            <option value="1000">1000期</option>

                        </select>

                    </div>
                    <div style="float:right ">
                        <form class="layui-form">
                            <div class="layui-form-item" style="margin-bottom: 0px">

                                <div class="layui-input-block" style="margin-left: 0px" >
                                    <input type="radio" name="sort" lay-filter="sort"   value="0" title="按号码" style="margin-top: 0px;">
                                    <input type="radio" name="sort" lay-filter="sort"   value="1" title="按次数"  style="margin-top: 0px;" checked>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="lg-hot-status" style="display: none">

                    <div>
                        <form class="layui-form">
                            <div class="layui-form-item">
                                <label class="layui-form-label">图形:</label>
                                <div class="layui-input-block">
                                    <input type="radio" name="type" lay-filter="sta"   value="0" title="柱状图" checked>
                                    <input type="radio" name="type" lay-filter="sta"   value="1" title="饼状图">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!--选择类型-->


            <div class="lg-hot-xt">
                <!--列表数据-->
                <div class="lg-hot-list">
                    <ul>
                        <li v-show="arr[i-1]" v-for="(l,i) in list" v-bind:data-val="i-1">
                            <p v-text="posFun(i)"></p>
                            <span v-for="k in l"><a v-bind:class="classFun(k.times)">{{k.num}}<b>{{k.times}}</b></a></span>
                        </li>
                    </ul>
                </div>
                <!--列表数据-->


                <!-- 柱状图 -->
                <div class="lg-hot-zhu">
                    <div class="lg-hot-zhu-title">柱状图</div>
                    <div class="lg-hot-zhu-list">
                        <ul>
                            <li v-show="arr[i-1]" v-for="(l,i) in list">
                                <div class="title" v-text="posFun(i)"></div>
                                <table>
                                    <thead>
                                    <tr>
                                        <td>次数</td>
                                        <td v-for="(v,k) in l">
                                            <div v-text="v.times"></div>
                                            <div v-bind:class="'common-height'+i"></div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>号码</td>
                                        <td v-for="(a,b) in l"><span v-text="a.num"></span></td>
                                    </tr>
                                    </thead>
                                </table>
                            </li>
                        </ul>
                    </div>
                </div>
                <!-- 柱状图 -->


                <!-- 饼状图 -->
                <div class="lg-hot-bin" style="display: none;">
                    <div class="lg-hot-bin-title">饼状图</div>
                    <div class="lg-hot-bin-list">
                        <ul>

                            <?php
                            $num=0;
                        foreach($pos_arr as $key=>$value){
                            $num++;
                            ?>


                            <li v-show="arr[<?php echo $key;?>]" >
                                <div class="title"><?php echo $value;?></div>
                                <div id="echart<?php echo $num;?>" style="width:400px;height:400px;margin: -100px auto 0 auto;"></div>
                                <div>
                                    <table>
                                        <tr>
                                            <td>号码</td>
                                            <td v-for="(v,k) in list['<?php echo $key+1;?>']"><span v-text="v.num"></span></td>
                                        </tr>
                                        <tr>
                                            <td>次数</td>
                                            <td v-for="(a,b) in list['<?php echo $key+1;?>']" v-text="a.times"></td>
                                        </tr>
                                    </table>
                                </div>
                            </li>


                            <?php } ?>


                        </ul>
                    </div>
                </div>
                <!-- 饼状图 -->

            </div>
        </div>
        <!--号码冷热-->

    </div>

<script>
    var param = {pos:0,target:<?php echo $nav_list[$action]['target']; ?>,period:100,sort:'times'};
   var wei_sum=<?php echo $wei_sum;?>

</script>
<script type="text/javascript" src="<?php echo $HttpPath; ?>static/web/js/cqssc/hot.js?v=c167ceaa2357dd0f98caf9a7514f1ea5"></script>
<script type="text/javascript" src="<?php echo $HttpPath; ?>static/web/js/pk10/hot-echart.js?v=c167ceaa2357dd0f98caf9a7514f1ea5"></script>


    <?php include_once template("footer");?>
</body>
</html>


