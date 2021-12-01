<script type="text/javascript">
//选择器
function $a(id,tag){var re=(id&&typeof id!="string")?id:document.getElementById(id);if(!tag){return re;}else{return re.getElementsByTagName(tag);}}

//焦点滚动图 点击移动
function movec()
{
	var o=$a("bd1lfimg","");
	var oli=$a("bd1lfimg","dl");
    var oliw=width; //每次移动的宽度	 
	var ow=width-2;
	var dnow=0; //当前位置	
	var olf=oliw-(ow-oliw+10)/2;
		o["scrollLeft"]=olf+(dnow*oliw);
	var rqbd=$a("bd1lfsj","ul")[0];
	var extime;

	<!--for(var i=1;i<oli.length;i++){rqbd.innerHTML+="<li>"+i+"</li>";}-->
	var rq=$a("bd1lfsj","li");
	for(var i=0;i<rq.length;i++){reg(i);};
	oli[dnow].className=rq[dnow].className="show";
	var wwww=setInterval(uu,2000);

	function reg(i){rq[i].onclick=function(){oli[dnow].className=rq[dnow].className="";dnow=i;oli[dnow].className=rq[dnow].className="show";mv();}}
	function mv(){clearInterval(extime);clearInterval(wwww);extime=setInterval(bc,15);wwww=setInterval(uu,8000);}
	function bc()
	{
		var ns=((dnow*oliw+olf)-o["scrollLeft"]);
		var v=ns>0?Math.ceil(ns/10):Math.floor(ns/10);
		o["scrollLeft"]+=v;if(v==0){clearInterval(extime);oli[dnow].className=rq[dnow].className="show";v=null;}
	}
	function uu()
	{
		if(dnow<oli.length-2)
		{
			oli[dnow].className=rq[dnow].className="";
			dnow++;
			oli[dnow].className=rq[dnow].className="show";
		}
		else{oli[dnow].className=rq[dnow].className="";dnow=0;oli[dnow].className=rq[dnow].className="show";}
		mv();
	}
	o.onmouseover=function(){clearInterval(extime);clearInterval(wwww);}
	o.onmouseout=function(){extime=setInterval(bc,15);wwww=setInterval(uu,8000);}
}


var width=170;

var height=180;
//var height1=document.documentElement.clientHeight;
//document.getElementById('sub_box').width=width;

var css_string ='#sub_box{width:'+width+'px; position:relative; height:'+height+'px; overflow:hidden;margin:0 auto;}';
 css_string+='#sub_box img{border:none; width:'+width+'px; width:'+width+'px;}';
 css_string+='#bd1lfimg{position:relative; width:'+width+'px; height:'+height+'px; overflow:hidden;}';
 css_string+='#bd1lfimg div{width:10000px; margin-left:-4px;}';
 css_string+='#bd1lfimg dl{width:'+width+'px; height:'+height+'px; position:relative; overflow:hidden; float:left;}';
 css_string+='#bd1lfimg dt{width:100%; height:'+height+'px; position:absolute; left:0px; top:0px;}';
 css_string+='#bd1lfimg dt  img {width:'+width+'px; height:'+height+'px; }';
 css_string+='#bd1lfimg dd{width:'+width+'px; height:0px; background:#000000; filter:alpha(Opacity=70); Opacity:0.7; position:absolute; left:0px; bottom:0px; padding:0 20px;}';
 css_string+='#bd1lfimg dd h2{height:25px; padding:8px 0 4px 0; line-height:25px; overflow:hidden;}';
 css_string+='#bd1lfimg dd h2 a{font-size:14px; font-weight:bold; color:#ffffff;}';
 css_string+='#bd1lfimg dd a{color:#ffffff; text-decoration:none;}';
 css_string+='#bd1lfimg dd a:hover{text-decoration:none; color:#cccccc;}';
 css_string+='#bd1lfimg dd tt{color:#dddddd; line-height:1.2em;}';
 css_string+='#bd1lfimg dd tt a:hover{text-decoration:underline;}';
 css_string+='#sub_nav{width:100%; height:20px; bottom:0px; position:absolute; color:#999999; z-index:200;}';
 css_string+='.sub_no{height:20px;text-align:center;margin:0 auto;width:80px}';
 css_string+='.sub_no li{display:block; width:10px; height:10px;margin-left:10px; float:left; overflow:hidden;    -moz-border-radius:5px;-webkit-border-radius:5px;border-radius:5px;  vertical-align:middle; text-align:center; background-color:#fff; cursor:pointer;}';
 css_string+='.sub_no li.show{ background-color:#ff0000;}';
 document.write('<style type="text\/css">' + css_string + '<\/style>'); 



</script>
	<div id="sub_box" style="margin-top: 5px;">
			<div id="sub_nav">
				<div class="sub_no" id="bd1lfsj">
					<ul>
					   <?php if(is_array($flash)){foreach($flash AS $key=>$item) { ?>
						<li >·	</li>
						
					<?php }}?>
					
					</ul>
				</div>
			</div>
			<div id="bd1lfimg">
				<div>
					<dl class="show" ></dl>
					
					    	 <?php if(is_array($flash)){foreach($flash AS $key=>$item) { ?>
					    	
				<dl >
						<dt><a href="<?php echo $item['url']; ?>" title="" ><img src="<?php echo $HttpPath; ?><?php echo $item['src']; ?>" ></a></dt>
						<dd>
							<h2><a href="<?php echo $item['url']; ?>"><?php echo $item['title']; ?></a></h2>
						
						</dd>
					</dl>
	
		
    <?php }}?>
							
										
									</div>
			</div>
		</div>
		<script type="text/javascript">movec();</script>