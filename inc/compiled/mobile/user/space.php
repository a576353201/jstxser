

<?php include_once template("header");?>
<style>
.info .line{line-height: 45px;}
</style>

 <div class="user_center  space">

<table style='width:100%;'>
<tr>


<td style='width:120px;text-align:center;'>
<div style='display:none;'>
<img src="<?php echo avatar($user['id']); ?>" style='width:500px;height:500px;'>
</div>
<img src="<?php echo avatar($user['id']); ?>" style='width:100px;height:100px;border:1px solid #ddd;border-radius:5px;padding:3px;'>

</td>

<td  valign='top'  style='line-height:35px;'>
<?php echo show_username($user['id']); ?>&nbsp;
<?php echo show_usergroup($user['id']); ?>
<br>
<span class='title'>类型：</span><?php echo $user_group[$user['group']]; ?><br>
<span class='title'>访问人气:</span> <?php echo $user['view']; ?><br>



</td>
</tr>
</table>





<div class='process1'>

<?php

foreach($group_arr as $key=>$value){


	?>




<div id='tit_<?php echo $key;?>'  class='step <?php if($key==0) echo 'cur';?>'  style='width:<?php echo 100/count($group_arr);?>%;'  onclick="set_tabs(<?php echo $key;?>,<?php echo count($group_arr);?>);"; >

<div class='info'><?php echo $value;?></div>
</div>




<?php
}

?>



 </div>



<div class='info' id='info_0' style='display:block;'>

<?php if ($user['group']==4){ ?>

<div class='line'>
<span  class='title'>单位名称：</span>
<?php echo $user['realname'];?>

</div>

<div class='line'>
<span  class='title'>组织机构代码编号：</span>
<?php echo $company['ids'];?>

</div>

<div class='line'>

<span  class='title'>机构类型：</span>
<?php echo $company_type[$company['type']]; ?>


</div>

      <?php }else{?>

<?php if($user['realname']){?>
<div class='line'>
<span  class='title'>真实姓名：</span>
<?php echo $user['realname']; ?>

</div>
<?php }?>

<?php if($user['sex']){?>
<div class='line'>
<span  class='title'>性别：</span>
<?php echo $sex_arr[$user['sex']]; ?>
</div>
<?php }?>
<?php if($user['birth']){?>
<div class='line'>
<span  class='title'>出生年月日：</span>

<?php echo $user['birth']; ?>
</div>
<?php }?>

<?php if($user['age']){?>
<div class='line'>
<span  class='title'>年龄：</span>

<?php echo $user['age']; ?>
</div>
<?php }?>

<?php if($address[birthcountry]  && !strpos($address[birthcountry],'选择')){?>

<div class='line'>
<span  class='title'>家乡：</span>
<?php echo $address['birthprovince']; ?> &nbsp; <?php echo $address['birthcity']; ?> &nbsp; <?php echo $address['birthcountry']; ?>
</div>
<?php }?>





<?php if($address[residecountry] && !strpos($address[residecountry],'选择')){?>

<div class='line'>
<span  class='title'>居住地：</span>
<?php echo $address['resideprovince']; ?> &nbsp; <?php echo $address['residecity']; ?> &nbsp; <?php echo $address['residecountry']; ?>
</div>
<?php }?>

<?php if($contact['email']){?>
<div class='line'>
<span  class='title'>常用邮箱：</span>
<?php echo $contact['email'];?>

</div>

<?php }?>

  <?php }?>

</div>


<div class='info' id='info_1' style='display:none;'>
<?php if ($user['group']==1 || $user['group']==2){ ?>

<?php if($user['nickname']){?>
<div class='line'>
<span  class='title'>昵称：</span>
<?php echo $user['nickname'];?>

</div>
<?php }?>

<?php if($player['group']){?>
<div class='line'>
<span  class='title'>级别：</span>
<?php echo $player_group[$player['group']];

if($player['group2']) echo '-'.$player['group2'];
?>

</div>
<?php }?>

<?php if($player['qiuguan']){?>
<div class='line'>
<span  class='title'>常驻球馆：</span>
<?php echo $player['qiuguan'];?>

</div>
<?php }?>

<?php if($player['height']){?>
<div class='line'>
<span  class='title'>身高：</span>
<?php echo $player['height'];?>cm
</div>
<?php }?>

<?php if($player['weight']){?>
<div class='line'>
<span  class='title'>体重：</span>
<?php echo $player['weight'];?>kg
</div>
<?php }?>

<?php if($player['ballweight']){?>
<div class='line'>
<span  class='title'>球重：</span>
<?php echo $player['ballweight'];?>磅
</div>
<?php }?>

<?php if($player['fromtime']){?>
<div class='line'>
<span  class='title'>开始打球时间：</span>
<?php echo $player['fromtime'];?>年

</div>
<?php }?>

<?php if($player['playkinds']){?>
<div class='line'>
<span  class='title'>技术打法：</span>


<?php if ($player['playkinds']=='F') echo "飞碟";?>
 <?php if ($player['playkinds']=='H') echo "弧线";?>
 <?php if ($player['playkinds']=='Z') echo "直线";?>


</div>
<?php }?>

<?php if($player['hand']){?>
<div class='line'>
<span  class='title'>惯用手：</span>
<?php echo $player['hand']; ?>


</div>
<?php }?>

<?php if($player['score1']){?>
<div class='line'>
<span  class='title'>单局最高分：</span>
<?php echo $player['score1'];?>
</div>
<?php }?>

<?php if($player['score3']){?>
<div class='line'>
<span  class='title'>三局最高分：</span>
<?php echo $player['score3'];?>
</div>
<?php }?>

<?php if($player['score6']){?>
<div class='line'>
<span  class='title'>六局最高分：</span>
<?php echo $player['score6'];?>
</div>
<?php }?>

    <?php }?>

<?php if ($user['group']==1 ){ ?>

<?php if($player['danwei']){?>
<div class='line'>
<span  class='title'>注册单位：</span>
<?php echo $player['danwei'];?>

</div>
<?php }?>

<?php if($player['zhanji']){?>
<div class='line'>
<span  class='title'>主要运动战绩：</span>
<?php echo $player['zhanji'];?>
</div>
<?php }?>

    <?php }?>




<?php if ($user['group']==2 ){ ?>

<?php if($player['fromyear']){?>
<div class='line'>
<span  class='title'>注册为职业球员时间：</span>
<?php echo $player['fromyear']; ?>年

</div>
<?php }?>

<?php if($player['xiehui']){?>
<div class='line'>
<span  class='title'>所属协会或俱乐部：</span>
<?php echo $player['xiehui'];?>
</div>
<?php }?>

<?php if($player['zanzhu']){?>
<div class='line'>
<span  class='title'>赞助商：</span>
<?php echo $player['zanzhu'];?>
</div>
<?php }?>

<?php if($player['zyscore']){?>
<div class='line'>
<span  class='title'>职业积分：</span>
<?php echo $player['zyscore'];?>
</div>
<?php }?>

<?php if($player['zhanji']){?>
<div class='line'>
<span  class='title'>职业战绩：</span>
<?php echo $player['zhanji'];?>

</div>
<?php }?>
    <?php }?>




<?php if ($user['group']==3){ ?>

<?php if($player['danwei']){?>
<div class='line'>
<span  class='title'>注册单位：</span>
<?php echo $player['danwei'];?>
</div>
<?php }?>

<?php if($player['dengji']){?>
<div class='line'>
<span  class='title'>裁判员等级：</span>
<?php echo $player['dengji'];?>

</div>
<?php }?>

<?php if($player['jingli']){?>
<div class='line'>
<span  class='title'>主要执裁经历：</span>
<?php echo $player['jingli'];?>
</div>
<?php }?>


    <?php }?>






</div>





<div class='info' id='info_2' style='display:none;'>
<div class='img_list'>
<?php if(count($file2)>0){?>
<?php if(is_array($file2)){foreach($file2 AS $index=>$value) { ?>
<img src='<?php echo $HttpPath; ?><?php echo $value; ?>' onclick="location.href='space_image.php?uid=<?php echo $_GET['uid']; ?>&num=<?php echo $index; ?>';"  name='img_show'>


<?php }}?>
<?php } else { ?>

该用户还没有上传照片
<?php }?>

</div>
</div>
</div>

<script>
function set_tabs(num,sum){



	for(var i=0;i<sum;i++){


		if(i==num){

			document.getElementById('tit_'+i).className='step cur';

			document.getElementById('info_'+i).style.display='block';
		}
		else{
			document.getElementById('tit_'+i).className='step';

			document.getElementById('info_'+i).style.display='none';


		}





	}






}

var img_sum=<?php echo count($file2);?>;
var img_num=0;
var xx=0;

function show_img11(num,move){


img_num=num;


var x=-parseInt(document.body.clientWidth)*(num+1);


if(move==1){

var temp=(x-xx)/100;
var t=0;
var tt=setInterval(

function(){
t++;
if(t>=100) clearInterval(tt);
xx=xx+temp;
document.getElementById("sw").style.transform='translate3d('+x+'px, 0px, 0px)';

var elStyle=document.getElementById("sw").style;
elStyle.webkitTransform = elStyle.MsTransform = elStyle.msTransform = elStyle.MozTransform = elStyle.OTransform = elStyle.transform;


},
5);


}
else{
xx=x;
document.getElementById("sw").style.transform='translate3d('+x+'px, 0px, 0px)';

var elStyle=document.getElementById("sw").style;
elStyle.webkitTransform = elStyle.MsTransform = elStyle.msTransform = elStyle.MozTransform = elStyle.OTransform = elStyle.transform;


}



	document.getElementById("showbg").style.display='block'
	//	document.getElementById("show_img").src=src;

}


function show_next(pre){

move=1;
if(pre==1){

if(img_num==img_sum-1) {img_num=0;move=0;}
else img_num++;
}
else{
if(img_num==0) {img_num=img_sum-1;move=0;}
else img_num--;
}

	//document.getElementById("show_img").src=img_show[img_num].src;
//alert(img_show[img_num].src);


show_img11(img_num,move);

}
</script>


 <div class='rebox'  id='showbg'  style='display:block;'>





 <link rel="stylesheet" href="<?php echo $HttpPath; ?>static/dist/css/swiper.min.css">
<style>
    .swiper-container {
        width: 100%;
        height: 100%;
        margin-left: auto;
        margin-right: auto;
    }
    .swiper-slide {
        text-align: center;
        font-size: 18px;


        display: -webkit-box;
        display: -ms-flexbox;
        display: -webkit-flex;
        display: flex;
        -webkit-box-pack: center;
        -ms-flex-pack: center;
        -webkit-justify-content: center;
        justify-content: center;
        -webkit-box-align: center;
        -ms-flex-align: center;
        -webkit-align-items: center;
        align-items: center;
    }
    .swiper-pagination{display:none;}
    </style>
     <div class="swiper-container">
        <div class="swiper-wrapper"  id='sw'>


        <?php if(is_array($file2)){foreach($file2 AS $index=>$value) { ?>
         <div class="swiper-slide"><img src="<?php echo $HttpPath; ?><?php echo $value; ?>"  onclick="set_info11('myinfo_<?php echo $index; ?>');">


         <div class='show_info' id='myinfo_<?php echo $index; ?>' name='show_info11'><span style='color:#bbb'>(<span style='color:#ff0000;font-weight:600;'><?php echo $index+1;?></span>/<?php echo count($file2); ?>)</span><?php echo $info[$index]; ?></div>

         </div>

           <?php }}?>

        </div>
        <!-- Add Pagination -->
        <div class="swiper-pagination"></div>
        <!-- Add Arrows -->
        <div class="swiper-button-next" id='banner_next' style='display:none;' ></div>
        <div class="swiper-button-prev"  style='display:none;'></div>
    </div>

    <!-- Swiper JS -->
    <script src="<?php echo $HttpPath; ?>static/dist/js/swiper.js"></script>

    <!-- Initialize Swiper -->
    <script>

     var swiper = new Swiper('.swiper-container', {
        pagination: '.swiper-pagination',
        slidesPerView: 1,
        loop:true,
        paginationClickable: true,
        spaceBetween:0,
        keyboardControl: true,
        nextButton: '.swiper-button-next',
        prevButton: '.swiper-button-prev',
    });

   // setInterval(function(){alert(swiper.slidesPerView)},5000);



   document.getElementById('showbg').style.display='none';
 function set_info11(id){


    if(document.getElementById(id).style.display=='none'){
    document.getElementById(id).style.display='block';

    }
    else{
    document.getElementById(id).style.display='none';
    }

    }
    </script>



<div class='close' onclick="document.getElementById('showbg').style.display='none';"></div>
</div>

<?php include_once template("footer");?>