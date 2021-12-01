<?php
include_once '../inc/common.php';
$system=get_system();
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
    <link href=style/home.css rel=stylesheet>

    <link rel="stylesheet" href="style/dist/css/swiper.min.css">
    <link rel="stylesheet" href="style/vip.css">
    <link href="../static/fontello.css" rel=stylesheet>
    <script src="/static/layui/layui.all.js"></script>
    <script src="/static/js/jquery-1.11.1.min.js"></script>
</head>

<body>

<div class="swiper-container">
    <div class="swiper-wrapper">

            <div class="swiper-slide" >
                <img src="style/images/vip2.png" "width="100%"></div>



    </div>
</div>



<div class="content_warp">
    <div class="warp">


        <div class="vipMainBox">
            <div class="" style="height: 80px;"></div>
            <div class="vipContent" deep="2">
                <div class="duibBox">
                    <p>VIP会员权益对比</p>
                    <table class="duibtable">
                        <thead>
                        <tr>
                            <th class="viphuibg02">权益描述</th>
                            <th class="viphuibg">普通用户</th>
                            <th class="vipbluebg">计划员</th>
                            <th class="orgbg">个人VIP</th>
                            <th class="vipzisbg">团队VIP</th>

                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>查看开奖</td>
                            <td><img src="style/images/right.png"></td>
                            <td><img src="style/images/right.png"></td>
                            <td><img src="style/images/right.png"></td>
                            <td><img src="style/images/right.png"></td>

                        </tr>
                        <tr>
                            <td>使用缩水工具</td>
                            <td><img src="style/images/right.png"></td>
                            <td><img src="style/images/right.png"></td>
                            <td><img src="style/images/right.png"></td>
                            <td><img src="style/images/right.png"></td>

                        </tr>
                        <tr>
                            <td>查看计划</td>
                            <td><img src="style/images/right.png"></td>
                            <td><img src="style/images/right.png"></td>
                            <td><img src="style/images/right.png"></td>
                            <td><img src="style/images/right.png"></td>

                        </tr>
                        <tr>
                            <td>创建群组</td>
                            <td><img src="style/images/right.png"></td>
                            <td><img src="style/images/right.png"></td>
                            <td><img src="style/images/right.png"></td>
                            <td><img src="style/images/right.png"></td>

                        </tr>
                        <tr>
                            <td>发展下级</td>
                            <td><img src="style/images/wrong.png"></td>
                            <td><img src="style/images/right.png"></td>
                            <td><img src="style/images/right.png"></td>
                            <td><img src="style/images/right.png"></td>

                        </tr>
                        <tr>
                            <td>参加任务</td>
                            <td><img src="style/images/wrong.png"></td>
                            <td><img src="style/images/right.png"></td>
                            <td><img src="style/images/right.png"></td>
                            <td><img src="style/images/right.png"></td>

                        </tr>
                        <tr>
                            <td>下级分红</td>
                            <td><img src="style/images/wrong.png"></td>
                            <td><img src="style/images/right.png"></td>
                            <td><img src="style/images/right.png"></td>
                            <td><img src="style/images/right.png"></td>

                        </tr>
                        <tr>
                            <td>专属图标</td>
                            <td><img src="style/images/wrong.png"></td>
                            <td><img src="style/images/right.png"></td>
                            <td><img src="style/images/right.png"></td>
                            <td><img src="style/images/right.png"></td>

                        </tr>
                        <tr>
                            <td>发布计划</td>
                            <td><img src="style/images/wrong.png"></td>
                            <td><img src="style/images/right.png"></td>
                            <td><img src="style/images/right.png"></td>
                            <td><img src="style/images/right.png"></td>

                        </tr>
                        

                        <tr>
                            <td>修改计划签名</td>
                            <td><img src="style/images/wrong.png"></td>
                            <td><img src="style/images/wrong.png"></td>
                            <td><img src="style/images/right.png"></td>
                            <td><img src="style/images/right.png"></td>

                        </tr>
                        <tr>
                            <td>发布收费计划</td>
                            <td><img src="style/images/wrong.png"></td>
                            <td><img src="style/images/wrong.png"></td>
                            <td><img src="style/images/right.png"></td>
                            <td><img src="style/images/right.png"></td>

                        </tr>
                        <tr>
                            <td>接受打赏</td>
                            <td><img src="style/images/wrong.png"></td>
                            <td><img src="style/images/wrong.png"></td>
                            <td><img src="style/images/right.png"></td>
                            <td><img src="style/images/right.png"></td>

                        </tr>
                        <tr>
                            <td>群聊机器人</td>
                            <td><img src="style/images/wrong.png"></td>
                            <td><img src="style/images/wrong.png"></td>
                            <td><img src="style/images/right.png"></td>
                            <td><img src="style/images/right.png"></td>

                        </tr>
                        <tr>
                            <td>关键词自定义屏蔽</td>
                            <td><img src="style/images/wrong.png"></td>
                            <td><img src="style/images/wrong.png"></td>
                            <td><img src="style/images/right.png"></td>
                            <td><img src="style/images/right.png"></td>

                        </tr>
                        <tr>
                            <td>ID靓号</td>
                            <td><img src="style/images/wrong.png"></td>
                            <td><img src="style/images/wrong.png"></td>
                            <td><img src="style/images/wrong.png"></td>
                            <td><img src="style/images/right.png"></td>

                        </tr>
                        <tr>
                            <td>赠送下级VIP</td>
                            <td><img src="style/images/wrong.png"></td>
                            <td><img src="style/images/wrong.png"></td>
                            <td><img src="style/images/wrong.png"></td>
                            <td><img src="style/images/right.png"></td>

                        </tr>
                        <tr>
                            <td>VIP使用人数</td>
                            <td>0</td>
                            <td>0</td>
                            <td class="vipred">1</td>
                            <td class="vipzis"><?php echo $system['vip1_max']?></td>

                        </tr>

                        <tr>
                            <td>群组最大人数</td>
                            <td><?php echo $system['people_sum0']?></td>
                            <td><?php echo $system['people_sum1']?></td>
                            <td class="vipred"><?php echo $system['people_sum2']?></td>
                            <td class="vipzis"><?php echo $system['people_sum3']?></td>

                        </tr>
                        <tr>
                            <td>创建群组数量</td>
                            <td><?php echo $system['group_sum0']?></td>
                            <td><?php echo $system['group_sum1']?></td>
                            <td class="vipred"><?php echo $system['group_sum2']?></td>
                            <td class="vipzis"><?php echo $system['group_sum3']?></td>

                        </tr>
                        <tr>
                            <td>加入群组数量</td>
                            <td><?php echo $system['group_join0']?></td>
                            <td><?php echo $system['group_join1']?></td>
                            <td class="vipred"><?php echo $system['group_join2']?></td>
                            <td class="vipzis"><?php echo $system['group_join3']?></td>

                        </tr>
                        <tr>
                            <td>好友最多人数</td>
                            <td><?php echo $system['friend_num0']?></td>
                            <td><?php echo $system['friend_num1']?></td>
                            <td class="vipred"><?php echo $system['friend_num2']?></td>
                            <td class="vipzis"><?php echo $system['friend_num3']?></td>

                        </tr>



                        <tr>
                            <td>价格</td>
                            <td class="vipblue"><strong>免费</strong></td>
                            <td class="vipblue"><strong>免费</strong></td>
                            <td class="vipred"><strong>￥<?php echo $system['vip_month']?>元/月</strong></td>
                            <td class="vipzis"><strong>￥<?php echo $system['vip1_month']?>元/月</strong></td>

                        </tr>


                        <tr>
                            <td colspan="3"></td>

                            <td class="vipred">
                               <input type="button" class="btn1" value="立即加入" onclick="joinvip(0);">
                            </td>
                            <td class="vipzis">

                                <input type="button" class="btn2" value="立即加入" onclick="joinvip(1);">
                            </td>

                        </tr>



                        </tbody>
                    </table>
                    <div style="height: 30px;line-height: 30px;text-align: center;font-size: 14px;color: #666;margin-bottom: 10px">注：VIP的最终解释权归本站所有</div>

                </div>



            </div>
        </div>


    </div>

</div>

<script>
    function joinvip(type) {
        if(parent.userid>0){
            var index= parent.layer.open({
                type: 2,
                title: false,
                shadeClose: true,
                shade: 0.6,
                area: ['350px','260px'],
                content: "/user/joinvip.php?type="+type//iframe的url
            });
        }else{
            parent.showlogin();
        }

    }
</script>




</body>

</html>