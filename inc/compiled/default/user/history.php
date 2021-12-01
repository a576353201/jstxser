   <?php include_once template("header");?>

<div class="tl bm bml" >

<div  id='threadlist'>

</div>

<div id='getmore'  style='height:30px;line-height:30px;text-align:center;' onclick="getlist();">
加载中,请稍后...
</div>



<div  id='next' style='height:50px;line-height:50px;text-align:center;width:100%;'  onclick="getlist();">
点击加载后10项
</div>
</div>



<script type="text/javascript">
var xmlHttp;
function Sxmlhttprequest(){
	if(window.ActiveXObject){
		xmlHttp = new ActiveXObject('Microsoft.XMLHTTP');
	}
	else if(window.XMLHttpRequest){
		xmlHttp = new XMLHttpRequest();
	}

}
var countdown=60;
var page=1;
var timestemp = Date.parse(new Date());
var  end=1;
function getlist(){
	var timestemp1 = Date.parse(new Date());
	var str='';
	if(parseInt(timestemp1-timestemp)>3000 || page==1){
		timestemp=timestemp1;

		document.getElementById('getmore').style.display='block';
			Sxmlhttprequest();

			//alert(str);
			xmlHttp.open('GET','msg_list.php?type=history&page='+page,true);
			xmlHttp.onreadystatechange=function(){


				if(xmlHttp.readyState==1){
					
				
				//	document.getElementById('send_sms').value="发送中";
				}
				if(xmlHttp.readyState==4){
					document.getElementById('getmore').style.display='none';
				var msg=xmlHttp.responseText;

				//document.getElementById('threadlist').innerHTML+=msg;
				page++;
				if(msg.length<20) {
					document.getElementById('next').innerHTML='没有找到相关项目';	
					end=0;
					
				
				}
				else{
					
					
					
				}

				if(end=1)
					$('#threadlist').append(msg);
				}


			};
			xmlHttp.send(null);
			
			
		
		
	}
	


}
getlist();
//滚动条在Y轴上的滚动距离  
function getScrollTop(){
　var scrollTop = 0, bodyScrollTop = 0, documentScrollTop = 0;
　if(document.body){
　　　bodyScrollTop = document.body.scrollTop;
　}
　if(document.documentElement){
　　　documentScrollTop = document.documentElement.scrollTop;
　}
　scrollTop = (bodyScrollTop - documentScrollTop > 0) ? bodyScrollTop : documentScrollTop;
　return scrollTop;
} 
//文档的总高度 
function getScrollHeight(){
　var scrollHeight = 0, bodyScrollHeight = 0, documentScrollHeight = 0;
　if(document.body){
　　　bodyScrollHeight = document.body.scrollHeight;
　}
　if(document.documentElement){
　　　documentScrollHeight = document.documentElement.scrollHeight;
　}
　scrollHeight = (bodyScrollHeight - documentScrollHeight > 0) ? bodyScrollHeight : documentScrollHeight;
　return scrollHeight;
} 
//浏览器视口的高度 
function getWindowHeight(){
　var windowHeight = 0;
　if(document.compatMode == "CSS1Compat"){
　　　windowHeight = document.documentElement.clientHeight;
　}else{
　　　windowHeight = document.body.clientHeight;
　}
　return windowHeight;
} 

var scroll=0;
window.onscroll = function(){
	
	
　if(getScrollTop() + getWindowHeight() >= getScrollHeight()){
	//alert(page);
if(scroll==1)getlist();
scroll=1;

　}
};


</script>

<?php include_once template("footer");?>
 