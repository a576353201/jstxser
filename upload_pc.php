<?php
include_once 'inc/common.php'
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport">
	<title>移动端图片压缩上传</title>
    <style>
        *{margin: 0;padding: 0;}
        li{list-style-type: none;}
        a,input{outline: none;-webkit-tap-highlight-color:rgba(0,0,0,0);}
        #choose{display: none;}
        canvas{width: 100%;border: 1px solid #000000;}
        #upload{display: inline-block;background:url('static/images/btn_up.png') no-repeat;  background-size:100% 100%;height:35px;width:130px;margin-left:0px;   vertical-align: middle;}

   #face{display: inline-block;background:url('static/images/face1.jpg') no-repeat;height:30px;width:30px;}
        #face:hover{background:url('static/images/face2.jpg') no-repeat;}
        .touch{background-color: #ddd;}
        .img-list{float:left;}


        .img-list li{display: inline-block; width: 70px; height: 70px; position: relative; margin-left: 4px;  background-size: cover; background-color: #fff;overflow: hidden;text-align:center;}
        .img-list li img{border:0px;height:70px;}

 .img-list li .del img{height:20px;}
        .img-list li .up_pre{	width: 70px;height:70px;line-height:70px;text-align:center;font-size:12px;
    background: #000;position: absolute;left:0px;bottom:0px;overflow: hidden;z-index: 9999999999;color:#fff;filter:alpha(opacity=7);-moz-opacity:0.7; -khtml-opacity: 0.7; opacity: 0.7;
        }
        .progress{position: absolute;width: 100%;height: 20px;line-height: 20px;bottom: 0;left: 0;background-color:rgba(100,149,198,.5);}
        .progress span{display: block;width: 0;height: 100%;background-color:rgb(100,149,198);text-align: center;color: #FFF;font-size: 13px;}
        .size{position: absolute;width: 100%;height: 15px;line-height: 15px;bottom: -18px;text-align: center;font-size: 13px;color: #666;}
        .tips{display: block;text-align:center;font-size: 13px;margin: 10px;color: #999;}
        .pic-list{margin: 10px;line-height: 18px;font-size: 13px;}
        .pic-list a{display: block;margin: 10px 0;}
        .pic-list a img{ vertical-align: middle;max-width: 30px; max-height: 30px; margin: -4px 0 0 10px;}
 .btn{display:block;clear:both;padding-top:1px;padding-left:3px;}

        #face1{
        	display:none; margin-top: 0px; background: #FFFFFF; border: 1px solid #C5C5C5;padding: 4px;z-index:100000;
        }
        .del{display:none; position: absolute; top: 2px;right: 2px; border: 1px solid #ccc; border-radius: 12px;width: 22px;height: 22px; background: rgba(0,0,0,.38);}
        .del img{border: 1px solid #ccc;border-radius: 10px; width: 20px;height: 20px;}
    </style>
</head>
<body>
       <form id="form111" method="post" action=""  enctype="multipart/form-data"  style='display:none;'>

<input type="file" capture="camera" id="cameraInput" name="cameraInput"  onchange="file_up();"  />


</form>
<?php
if($_GET['img']){
	$img_list=explode("|", $_GET['img']);

}
?>
<div id='img-list' style='display:<?php 	if(count($img_list)>0) echo 'block';else echo 'none';?>;padding-top:5px;'  onclick="	document.getElementById('face1').style.display='none';">

<ul class="img-list">
<?php

	if(count($img_list)>0){
	foreach ($img_list as $key=>$value){

		?>
<li id="li_<?php echo $key+1;?>">
<img src="<?php echo $value;?>" id="img_<?php echo $key+1;?>" onclick="show_img('<?php echo $value;?>');" /><input type="hidden" id="src_<?php echo $key+1;?>" value="<?php echo $value;?>" >
<?php
if($_GET['read']!=1){
?>
<span class="del" id="del_<?php echo $key+1;?>"  style='display:block;'   onclick="del_image(<?php echo $key+1;?>);"><img src="static/images/del.jpg"></span>

<?php
}
?>

</li>

		<?php
	}



	}

?>

</ul>
<?php
if($_GET['read']!=1){
?>
<img src='static/images/fileadd.jpg' style='vertical-align:middle;height:70px;' onclick='document.getElementById("cameraInput").click();document.getElementById("face1").style.display="none";'>

<?php
}
?>

</div>

<div class='btn'>
<?php
if($_GET['read']!=1){
?>
<a id="upload"   onclick='document.getElementById("face1").style.display="none";'>&nbsp;</a>
<?php
}
?>


<div id='face1'>

</div>
</div>


<script src="static/js/jquery-1.11.1.min.js"></script>

<script><!--
var upload_num=10;
<?php
if($_GET['num']) echo "upload_num=".$_GET['num'].";";
?>



function show_face(){

if(document.getElementById("face1").style.display=='block'){
	document.getElementById("face1").style.display='none';
}
else{

	document.getElementById("face1").style.display='block';
}
set_height();
}

function show_img(src){

	window.parent.document.getElementById("showbg").style.display='block'
		window.parent.document.getElementById("show_img").src='../../'+src;

}



function inputface(i){


	var str="[face]"+i+"[/face]"

	window.parent.document.getElementById("message").value+=str;
	show_face();
}

function del_image(num1){

num--;
 var src=document.getElementById("src_"+num1).value;

if(num1==1)

window.parent.document.getElementById("<?php echo $_GET['fileid'];?>").value=window.parent.document.getElementById("<?php echo $_GET['fileid'];?>").value.replace(src+'|',"");

else
window.parent.document.getElementById("<?php echo $_GET['fileid'];?>").value=window.parent.document.getElementById("<?php echo $_GET['fileid'];?>").value.replace('|'+src,"");
window.parent.document.getElementById("<?php echo $_GET['fileid'];?>").value=window.parent.document.getElementById("<?php echo $_GET['fileid'];?>").value.replace(src,"");
var idObject = document.getElementById('li_'+num1);
if (idObject != null)
      idObject.parentNode.removeChild(idObject);

if(window.parent.document.getElementById("image_list").value==''){
    document.getElementById("img-list").style.display='none';


}

set_height();
}


    var filechooser = document.getElementById("cameraInput");
    //    用于压缩图片的canvas
    var canvas = document.createElement("canvas");
    var ctx = canvas.getContext('2d');
    //    瓦片canvas
    var tCanvas = document.createElement("canvas");
    var tctx = tCanvas.getContext("2d");
    var maxsize =10*1024 * 1024;
    $("#upload").on("click", function () {
        filechooser.click();
    })
    .on("touchstart", function () {
        $(this).addClass("touch")
    })
    .on("touchend", function () {
        $(this).removeClass("touch")
    });

    var num=<?php if(count($img_list)>0) echo count($img_list)+1;else echo '1';?>;


    filechooser.onchange = function () {

        if (!this.files.length) return;
    	//window.parent.document.getElementById("upimage").style.display='block';
        var files = Array.prototype.slice.call(this.files);
        if (num > upload_num) {
            alert("最多同时只可上传"+upload_num+"张图片");
            return;
        }
        files.forEach(function (file, i) {
            if (!/\/(?:jpeg|png|gif)/i.test(file.type)) {alert('您选择的图片格式不正确');return;}
            var reader = new FileReader();
            var li = document.createElement("li");
//          获取图片大小
            var size = file.size/1024 > 1024 ? (~~(10*file.size/1024/1024))/10 + "MB" :  ~~(file.size/1024) + "KB";
           // li.innerHTML = '<div class="progress"><span></span></div><div class="size">'+size+'</div>';
            document.getElementById("img-list").style.display='block';

            reader.onload = function () {

                var result = this.result;

              if (result.length <= maxsize) {
               $(".img-list").append($(li));
 var img = new Image();
                img.src = result;
    li.innerHTML = '<div class="up_pre" id="pre_'+num+'">上传中...</div><img src="'+result+'" id="img_'+num+'"   /><input type="hidden" id="src_'+num+'" value="" ><span class="del" id="del_'+num+'"   onclick="del_image('+num+');"><img src="static/images/del.jpg"></span>';

                var id='li_'+num;
                li.setAttribute("id",id);

                set_height();

if(result.length>2*1024*1024 ){
if(img.complete){

 result= compress(img);
  upload(result, file.type, $(li));

return ;
}

else{
 img.onload = function(){

	    result= compress(img);

	    upload(result, file.type, $(li));

return ;
	    }
}
}

else{

	  upload(result, file.type, $(li));

                    return;
}

              }
              else{
   	window.parent.alert("图片最大上传10MB！");

              	return false;



              }



            };
            reader.readAsDataURL(file);
        })
    };











    //    使用canvas对大图片进行压缩
    function compress(img) {
    var initSize = img.src.length;
    var width = img.width;
    var height = img.height;
    //如果图片大于四百万像素，计算压缩比并将大小压至400万以下
    var canvas = document.createElement("canvas");

    canvas.width = width;
    canvas.height = height;
  var drawer = canvas.getContext("2d");
          drawer.drawImage(img, 0, 0,width, height);
            var ndata  = canvas.toDataURL("image/jpeg", 0.6);

    tCanvas.width = tCanvas.height = canvas.width = canvas.height = 0;
    return ndata;
    }
    //    图片上传，将base64的图片转成二进制对象，塞进formdata上传
    function upload(basestr, type, $li) {
   // document.getElementById("upimage").style.display='block';

   	 var base64Data = basestr.substr(22);
 	//在前端截取22位之后的字符串作为图像数据
 	                            //开始异步上
 	   $.post("api/index.php?act=uploadImage&dir=<?php echo $_GET['dir'];?>", { "imgData": base64Data }, function (data, status) {

                 if(data.code==200){
                    if(window.parent.document.getElementById("<?php echo $_GET['fileid'];?>").value=='') window.parent.document.getElementById("<?php echo $_GET['fileid'];?>").value=data.url;
                    else window.parent.document.getElementById("<?php echo $_GET['fileid'];?>").value+='|'+data.url;
//                	 window.parent.document.getElementById("<?php echo $_GET['fileid'];?>").style.display='none';
       	            //alert(data.url);
                    document.getElementById("src_"+num).value=data.url;
                    document.getElementById("del_"+num).style.display='block';
                    document.getElementById("pre_"+num).style.display='none';

                    num++;
                 }
                 else{
                     parent.layer.msg("网络连接超时",{ type: 1, anim: 2 ,time:1000});

                     }
  	            	//window.parent.document.getElementById("upimage").style.display='none';
 	            	//window.parent.alert("恭喜您上传成功！");
 	            	//window.location.reload();

          }, "json");


    }
    // 获取blob对象的兼容性写法
    function getBlob(buffer, format){
        var Builder = window.WebKitBlobBuilder || window.MozBlobBuilder;
        if(Builder){
            var builder = new Builder;
            builder.append(buffer);
            return builder.getBlob(format);
        } else {
            return new window.Blob([ buffer ], {type: format});
        }
    }

       function  set_height(){



    	window.parent.document.getElementById("<?php echo $_GET['iframeid'];?>").style.height=document.body.clientHeight+'px';
        }

    set_height();  set_height();
--></script>
</body>
</html>