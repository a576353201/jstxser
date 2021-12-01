
function Divdisplay(id1,id2){

	document.getElementById(id1).style.display='block';

	document.getElementById(id2).style.display='none';
}

var  highlightcolor='#c1ebff';

//此处clickcolor只能用win系统颜色代码才能成功,如果用#xxxxxx的代码就不行,还没搞清楚为什么:(

var  clickcolor='#51b2f6';

function  changeto(){

source=event.srcElement;

if  (source.tagName=="TR"||source.tagName=="TABLE")

return;

while(source.tagName!="TD")

source=source.parentElement;

source=source.parentElement;

cs  =  source.children;

//alert(cs.length);

if  (cs[1].style.backgroundColor!=highlightcolor&&source.id!="nc"&&cs[1].style.backgroundColor!=clickcolor)

for(i=0;i<cs.length;i++){

	cs[i].style.backgroundColor=highlightcolor;

}

}



function  changeback(){

if  (event.fromElement.contains(event.toElement)||source.contains(event.toElement)||source.id=="nc")

return

if  (event.toElement!=source&&cs[1].style.backgroundColor!=clickcolor)

//source.style.backgroundColor=originalcolor

for(i=0;i<cs.length;i++){

	cs[i].style.backgroundColor="";

}

}



function  clickto(){

source=event.srcElement;

if  (source.tagName=="TR"||source.tagName=="TABLE")

return;

while(source.tagName!="TD")

source=source.parentElement;

source=source.parentElement;

cs  =  source.children;

//alert(cs.length);

if  (cs[1].style.backgroundColor!=clickcolor&&source.id!="nc")

for(i=0;i<cs.length;i++){

	cs[i].style.backgroundColor=clickcolor;

}

else

for(i=0;i<cs.length;i++){

	cs[i].style.backgroundColor="";

}

}


var xmlHttp;
function Sxmlhttprequest(){
	if(window.ActiveXObject){
		xmlHttp = new ActiveXObject('Microsoft.XMLHTTP');
	}
	else if(window.XMLHttpRequest){
		xmlHttp = new XMLHttpRequest();
	}

}

function createXHR()
{
  var request;
  var browser = navigator.appName;
  //使用IE，则使用XMLHttp对象
  if(browser == "Microsoft Internet Explorer")
  {
    var arrVersions = ["Microsoft.XMLHttp", "MSXML2.XMLHttp.4.0", "MSXML2.XMLHttp.3.0", "MSXML2.XMLHttp","MSXML2.XMLHttp.5.0"];
    for (var i=0; i < arrVersions.length; i++)
    {
      try
      {
        //从中找到一个支持的版本并建立XMLHttp对象
        request = new ActiveXObject(arrVersions[i]);
        return request;
      }
      catch(exception)
      {
         //忽略，继续
      }
    }
  }
  else
  {
    //否则返回一个XMLHttpRequest对象
    request = new XMLHttpRequest();
    if(request.overrideMimeType)
    {
  　　  request.overrideMimeType('text/xml;charset=utf-8');
  　}
    return request;
  }
}

var Request = createXHR();//实例化

function ShowThirdMenuNav(x,type3)
{
   var URL = "../inc/ajax.php?type=getmenu&id=" +x+"&type3="+type3;

   Request.open("GET",URL,true);

   Request.onreadystatechange = ShowThirdMenuNavDiv;

   Request.send(null);
}

function ShowThirdMenuNavDiv()
{
   if(Request.readyState == 4 && Request.status == 200)
   {
      document.getElementById("thirdMenuNavDiv").style.display = 'none';
      document.getElementById('thirdMenuNavDiv').innerHTML = Request.responseText;
   }
}


function ShowNextMenuNav(x,type3){

   var URL = "../inc/ajax.php?type=getmenu2&id=" +x+"&type3="+type3;

   Request.open("GET",URL,true);

   Request.onreadystatechange = ShowNextMenuNavDiv;

   Request.send(null);
}
function ShowNextMenuNavDiv()
{
   if(Request.readyState == 4 && Request.status == 200)
   {
      document.getElementById("nextMenuNavDiv").style.display = 'block';
      document.getElementById('nextMenuNavDiv').innerHTML = Request.responseText;
   }
}

function copy(text) {
    console.log(text);
    Clipboard.copy(text);
}
window.Clipboard = (function(window, document, navigator) {
    var textArea,
        copy;

    // 判断是不是ios端
    function isOS() {
        return navigator.userAgent.match(/ipad|iphone/i);
    }
    //创建文本元素
    function createTextArea(text) {
        textArea = document.createElement('textArea');
        textArea.innerHTML = text;
        textArea.value = text;
        document.body.appendChild(textArea);
    }
    //选择内容
    function selectText() {
        var range,
            selection;

        if (isOS()) {
            range = document.createRange();
            range.selectNodeContents(textArea);
            selection = window.getSelection();
            selection.removeAllRanges();
            selection.addRange(range);
            textArea.setSelectionRange(0, 999999);
        } else {
            textArea.select();
        }
    }

    //复制到剪贴板
    function copyToClipboard() {
        try{
            if(document.execCommand("Copy")){

                layer.msg('复制成功',{ type: 1, anim: 2 ,time:1000});
            }else{

                layer.msg('复制失败！请手动复制！',{ type: 1, anim: 2 ,time:1000});
            }
        }catch(err){

            layer.msg('复制错误！请手动复制！',{ type: 1, anim: 2 ,time:1000});

        }
        document.body.removeChild(textArea);
    }

    copy = function(text) {
        createTextArea(text);
        selectText();
        copyToClipboard();
    };

    return {
        copy: copy
    };
})(window, document, navigator);