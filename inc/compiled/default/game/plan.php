<?php include_once template("header");?>
<?php include_once template("game/header");?>
<style>
    .iframe-div {padding:10px 10px;background-color: #ffffff;line-height: 25px;}
    .iframe {width:100%;height:600px;background-color: #ffffff;}

</style>
<link rel="stylesheet" href="<?php echo $HttpTemplatePath; ?>51cp/static/web/css/plan.css?v=c167ceaa2357dd0f98caf9a7514f1ea5" type="text/css"/>
<div class="container cst-mainbody" style="background-color: #ffffff;">
    <div class="location-box"  style="width: 1170px;background-color: #e9e9e9;margin:0 0 10px -15px;">
        <ul>
            <li></li>
            <li>
                <span>当前位置:</span>
                <a href="<?php echo $HttpPath; ?>"><?php echo $system['web_title']; ?></a> > <a href="home_<?php echo $gameinfo['showkey']; ?>.html"><?php echo $gameinfo['title']; ?></a> > <a href="#">免费推荐</a>
            </li>
        </ul>
    </div>
    <div class="main_d lotteryPublic_main">

        <div class="lotteryPublic_dataInfoBlock free_main">

            <div class="lotteryPublic_contentBlock">
                <div class="lotteryPublic_descriptionBlock">
                    <span class="csj410_title">说明：</span>
                    <div class="csj410_text">
                <span class="text">
                    根据特定算法为你推荐号码及单双大小两面，当推荐数据与开奖结果相同，则为推荐成功，呈标红加粗显示。
                </span>
                    </div>

                </div>
                <div class="lotteryPublic_tableBlock">
                    <div class="freeList">
                        <div class="list_left">
                            <table cellpadding="0" cellspacing="0" border="0" width="100%" data-type="historyTable">
                                <thead>
                                <tr>
                                    <th style="width: 34%">
                                        <span>期号</span>
                                        <span>时间</span>
                                    </th>
                                    <th>历史开奖结果</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php if(is_array($lottery_list)){foreach($lottery_list AS $index=>$value) { ?>
                                <tr>

                                    <td>
                                        <span><?php echo $value['period']; ?>&nbsp;&nbsp;<?php echo date('H:i',$value['lottime'])?></span>
                                    </td>
                                    <td class="efeito">
                                        <div class="fc_<?php if($gametype=='kl8'){?>bjkl8<?php } else { ?>pk10<?php }?>" data-type="historyNumbers">

                                          <?php
 $num=explode(',',$value['number']);
 foreach($num as $k=>$v){
                        ?>
                                            <span class="<?php if($gametype=='kl8'){?>font_6F8A97<?php } else { ?>pk10num_<?php echo $v; ?><?php }?>"><?php echo $v; ?></span>
                          <?php
                                            }
?>


                                        </div>
                                    </td>
                                </tr>

                                <?php }}?>

                                </tbody>
                            </table>

                        </div>
                        <div class="list_right" data-type="betgameList">
                            <?php if(is_array($plan)){foreach($plan AS $index=>$value) { ?>
                            <?php if($value['number']){?>
                            <?php  $number=explode(',',$value['number']);?>
                            <table cellpadding="0" cellspacing="0" border="0" width="100%" class="">
                                <tbody>
                              <?php if($gametype=='k3' || $gametype=='pcdd' || $gametype=='kl8'){?>

                              <tr>
                                  <th colspan="5">
                    <span class="nunTitle2">
                       <?php echo $value['period']; ?> 期
                            往期推荐  <?php if($value['number']){?>开奖号码    <?php echo $value['number']; ?>
                        <?php if($gametype=='pcdd'){?>=<?php  echo array_sum($number);?><?php }?>

                        <?php }?>

                    </span>
                                  </th>
                              </tr>

                              <?php } else { ?>
                               <tr>
                                    <th width="20%">名&nbsp;次</th>
                                    <th width="20%">开奖结果</th>
                                    <th colspan="4">
                    <span class="nunTitle">
                         <?php echo $value['period']; ?>期
往期推荐
                    </span>
                                    </th>
                                </tr>
                              <?php }?>

                                <?php $num=0;?>
                                <?php if(is_array($value['code'])){foreach($value['code'] AS $k1=>$v1) { ?>
                              <?php
                              if ($k1=='冠亚和'){
                              $number[$num]=$number[0]+$number[1];
                              $da=5;
                              }  if ($k1=='龙虎'){
                             if($number[0]>$number[4]) $number[$num]='龙';else if($number[0]<$number[4]) $number[$num]='虎';else  $number[$num]='和';

                              }

                              else if($gametype=='kl8' || $gametype=='k3' || $gametype=='pcdd'){
                              $number[$num]=array_sum($number);
                              }
                              else{
                              $da=$da_num;
                              }
                               if( $number[$num]>$da_num) $dx='大';else $dx='小';


                              if( $number[$num]%2==1) $ds='单';else $ds='双';
                            if(count($value['code'])==1){
                             $dx='总和'.$dx;$ds='总和'.$ds;
                              }

?>
                                <tr class="rank1">
                                    <td>

                                        <?php echo $k1; ?>
                                    </td>
                                    <?php if($gametype=='ssc' || $gametype=='11x5' || $gametype=='pk10' || $gametype=='kl10'){?>
                                    <td>
                                        <span class="ball"><?php echo $number[$num]; ?></span>
                                    </td>
                                    <?php }?>
                                    <td colspan="<?php if($k1=='龙虎'){?>4<?php } else { ?>2<?php }?>">

                                        <?php if(is_array($v1['code'])){ ?>

                                        <?php if(is_array($v1['code'])){foreach($v1['code'] AS $k2=>$v2) { ?>
                                        <?php if($k2>0){?>，<?php }?>
                                        <i <?php if($number[$num]==$v2 || ($gametype=='kl8' && in_array($v2,$number))){?>class="font_red" <?php }?> ><?php echo $v2; ?></i>
                                        <?php }}?>

                                        <?php } else{ ?>

                                        <i <?php if($number[$num]==$v1['code']){?>class="font_red" <?php }?> ><?php echo $v1['code']; ?></i>

                                        <?php }?>

                                    </td>
                                    <?php if($k1=='龙虎'){?><?php } else { ?>
                                    <td width="10%" <?php if($ds==$v1['ds']){?>class="font_red" <?php }?> ><?php echo $v1['ds']; ?></td>
                                    <td width="10%" <?php if($dx==$v1['dx']){?>class="font_red" <?php }?> ><?php echo $v1['dx']; ?> </td>
                                    <?php }?>


                                </tr>
                                <?php $num++;?>
                                <?php }}?>


                                </tbody></table>

                            <?php } else { ?>
                            <table cellpadding="0" cellspacing="0" border="0" width="100%" class="polymerization_table">
                                <tbody><tr>
                                    <th width="20%">名&nbsp;次</th>
                                    <th colspan="5">
                    <span class="nunTitle">
                        <?php echo $value['period']; ?>期
                            <i>（等待开奖）</i>
<?php if($key==0){?>本期推荐<?php }?>
                    </span>
                                    </th>
                                </tr>
                              <?php if(is_array($value['code'])){foreach($value['code'] AS $k1=>$v1) { ?>

                                <tr class="rank1">
                                    <td>

                                       <?php echo $k1; ?>
                                    </td>
                                    <td colspan="<?php if($k1=='龙虎' ){?>4<?php } else { ?>2<?php }?>" class="">
                                        <?php if(is_array($v1['code'])){ ?>

                                        <?php if(is_array($v1['code'])){foreach($v1['code'] AS $k2=>$v2) { ?>
                                        <?php if($k2>0){?>，<?php }?>
                                        <i class=""><?php echo $v2; ?></i>
                                        <?php }}?>
                                        <?php } else{ ?>


                                        <?php echo $v1['code']; ?>
                                        <?php }?>
                                      </td>
                                    <?php if($k1=='龙虎'){?><?php } else { ?>
                                    <td width="10%" class=""><?php echo $v1['ds']; ?></td>
                                    <td width="10%" class=""><?php echo $v1['dx']; ?> </td>
                                    <?php }?>



                                </tr>
                                <?php }}?>


                                </tbody></table>
                            <?php }?>

<?php }}?>





                        </div>

                    </div>
                </div>
            </div>
        </div>







    </div>
</div>

<?php include_once template("footer");?>

</body>
</html>