function getQueryString(name) {
    var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)", "i");
    var r = window.location.search.substr(1).match(reg);
    if (r != null) return unescape(r[2]); return null;
}
var xx=getQueryString('qq');  //get参数
if(xx=='cj66'){
    var url="http://www.cj-app.com/";
    location.href=url;
}
else if(xx=='cj888'){
    var url="http://www.baidu.com/";
    location.href=url;
}

