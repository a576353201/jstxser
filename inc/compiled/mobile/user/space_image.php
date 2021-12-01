

<?php include_once template("header");?>
<style>
.head_wrapper{background-color:#000;border-bottom: 1px solid #000;}
</style>

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


 <div class='rebox'  id='showbg'  style='display:block;top:34px;z-index:1001;'>





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
            position: relative;
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



 function set_info11(id){


    if(document.getElementById(id).style.display=='none'){
    document.getElementById(id).style.display='block';

    }
    else{
    document.getElementById(id).style.display='none';
    }

    }

    <?php if($_GET['num']){?>show_img11(<?php echo $_GET['num']; ?>,0);<?php }?>
    </script>

</div>

<?php include_once template("footer");?>