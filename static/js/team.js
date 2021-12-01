
var num1=0;
function add_lingdui(num){

var str='';

if(num>lingdui_num){

for(var i=lingdui_num;i<num;i++){

 str+="<div id='lingdui_"+i+"'>姓名:<input type='text' class='input1' name='lingdui["+i+"][name]' value=''  minlength='2' maxlength='10' autofocus='' required='' autocomplete='off' >&nbsp;&nbsp;&nbsp;"
+" 性别:<input type='radio' name='lingdui["+i+"][sex]' value='1' required='' >男&nbsp;&nbsp;<input type='radio' name='lingdui["+i+"][sex]' value='2' required=''>女</div>";


}




$('#lingdui').append(str);
}

else{


for(var i=num;i<lingdui_num;i++){

document.getElementById("lingdui").removeChild(document.getElementById("lingdui_"+i));
}





}
lingdui_num=num;
if(num==0)$('#lingdui_div').hide();
else $('#lingdui_div').show();

}



function add_fulingdui(num){
var str='';

if(num>fulingdui_num){
for(var i=fulingdui_num;i<num;i++){

 str+="<div id='fulingdui_"+i+"'>姓名:<input type='text' class='input1' name='fulingdui["+i+"][name]' value='' minlength='2' maxlength='10' autofocus='' required='' autocomplete='off'>&nbsp;&nbsp;&nbsp;"
+"性别:<input type='radio' name='fulingdui["+i+"][sex]' value='1'  required=''>男&nbsp;&nbsp;<input type='radio' name='fulingdui["+i+"][sex]' value='2' required=''>女</div>";


}

$('#fulingdui').append(str);
}
else{


for(var i=num;i<fulingdui_num;i++){

document.getElementById("fulingdui").removeChild(document.getElementById("fulingdui_"+i));
}





}

fulingdui_num=num;
if(num==0)$('#fulingdui_div').hide();
else $('#fulingdui_div').show();

}


function add_jiaolian(num){




var str='';

if(jiaolian_num<num){
for(var i=jiaolian_num;i<num;i++){

 str+="<tr id='jiaolian_"+i+"'><td><input type='text' class='input1' name='jiaolian["+i+"][name]' value='' minlength='2' maxlength='10' autofocus='' required='' autocomplete='off'></td>"
+" <td><input type='radio' name='jiaolian["+i+"][sex]' value='1' required='' >男&nbsp;&nbsp;<input type='radio' name='jiaolian["+i+"][sex]' value='2' required=''>女</td>"
+"<td><input type='radio' name='jiaolian["+i+"][waiji]' value='1' required=''>是&nbsp;&nbsp;<input type='radio' name='jiaolian["+i+"][waiji]' value='2' required=''>否</td>"+
" <td style='position: relative;'><input type='text' style='width:180px;' id='jiaolian_danwei1_"+i+"' placeholder='上年度锦标赛代表单位' name='jiaolian["+i+"][danwei]' value='' minlength='2' maxlength='10' autofocus=''  autocomplete='off'  onclick=\"set_danwei(this.value,"+i+",'jiaolian',0);\" oninput=\"set_danwei(this.value,"+i+",'jiaolian',1);\"><div class='jiaolian_danwei'  id='jiaolian_danwei_"+i+"'></div></td></tr>";


}


$('#jiaolian').append(str);

}
else{


for(var i=num;i<jiaolian_num+1;i++){


  $("#jiaolian_"+i).remove();;

}


}

jiaolian_num=num;
if(num==0)$('#jiaolian_div').hide();
else $('#jiaolian_div').show();

}




function add_jiaolian1(num){
var str='';
if(jiaolian_num<num){
for(var i=jiaolian_num;i<num;i++){


 str+="<tr id='jiaolian_"+i+"'><td><input type='text' class='input1' style='width:50px !important;' name='jiaolian["+i+"][name]' value='' minlength='2' maxlength='10' autofocus='' required='' autocomplete='off'></td>"
+" <td style='line-height:25px;'><input type='radio' name='jiaolian["+i+"][sex]' value='1' required='' >男<br><input type='radio' name='jiaolian["+i+"][sex]' value='2' required=''>女</td>"
+"<td  style='line-height:25px;'><input type='radio' name='jiaolian["+i+"][waiji]' value='1' required=''>是<br><input type='radio' name='jiaolian["+i+"][waiji]' value='2' required=''>否</td>"+
" <td><input type='text' style='width:70px;' placeholder='上年度锦标赛代表单位' name='jiaolian["+i+"][danwei]' value='' minlength='2' maxlength='10' autofocus='' required='' autocomplete='off'></td></tr>";


}


$('#jiaolian').append(str);

}
else{


for(var i=num;i<jiaolian_num+1;i++){


  $("#jiaolian_"+i).remove();;

}


}

jiaolian_num=num;

if(num==0)$('#jiaolian_div').hide();
else $('#jiaolian_div').show();

}



function jian_div(div,num){
if(num==1) {num1--;$('#add_lingdui').show();}
if(num==2) {num2--;$('#add_fulingdui').show();}
$('#'+div).remove();

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
function search_player(){
document.getElementById('search_info').innerHTML="查询中...";

Sxmlhttprequest();




var  url='../ajax/search_player.php?playerid='+document.getElementById('playerid').value+'&realname='+document.getElementById('realname').value+'&playersex='+document.getElementById('playersex').value;


	xmlHttp.open('GET',url,true);
	xmlHttp.onreadystatechange=function(){


		if(xmlHttp.readyState==4){
		var msg=xmlHttp.responseText;

document.getElementById('search_info').innerHTML=msg;

player_num();
		}


	};
	xmlHttp.send(null);


}


function click_all(div){

var playerid=document.getElementsByName('playerid[]');

for(var i=0;i<playerid.length;i++){

if(div.checked==true)playerid[i].checked=true;

else playerid[i].checked=false;
}
player_num();
}

var sex1=0;
var sex2=0;
function player_num(){
sex1=0;sex2=0;
var num1=0; var num2=0;
var playerid=document.getElementsByName('playerid[]');

for(var i=0;i<playerid.length;i++){
if(playerid[i].checked==true){
var tt='sex_'+playerid[i].value;

if(document.getElementById(tt).value==1) num1++;
else num2++;

if(num1>parseInt(team_num4)){
num1--;
playerid[i].checked=false;
//window.wxc.xcConfirm('男运动员最多不能超过'+team_num4+'人',window.wxc.xcConfirm.typeEnum.warning);
}

if(num2>parseInt(team_num5)){
num2--;
playerid[i].checked=false;
//window.wxc.xcConfirm('女运动员最多不能超过'+team_num5+'人',window.wxc.xcConfirm.typeEnum.warning);
}
}
}
 sex1=num1;
sex2=num2;

var sum=num1+num2;
var str="您再次选择中了"+sum+"名运动员,其中男运动员："+num1+"名，女运动员："+num2+"名";
if(sum>0)  str+='&nbsp;<input type="button" class="btn00" style="width:80px;" value="添加" onclick="add_player()" >';




document.getElementById('search_num').innerHTML=str;
//document.getElementById('player_sum').value=sum;
//document.getElementById('player_sum1').value=num1;
//document.getElementById('player_sum2').value=num2;
}

function  add_player(){
    if(is_admin==1) var path='../';
else var  path='';

sex1=0;sex2=0;
var num1=0; var num2=0;
var playerid=document.getElementsByName('playerid[]');

for(var i=0;i<playerid.length;i++){
if(playerid[i].checked==true){
var tt='sex_'+playerid[i].value;

if(document.getElementById(tt).value==1) num1++;
else num2++;

if(num1>parseInt(team_num4)){
num1--;
playerid[i].checked=false;
//window.wxc.xcConfirm('男运动员最多不能超过'+team_num4+'人',window.wxc.xcConfirm.typeEnum.warning);
}

if(num2>parseInt(team_num5)){
num2--;
playerid[i].checked=false;
//window.wxc.xcConfirm('女运动员最多不能超过'+team_num5+'人',window.wxc.xcConfirm.typeEnum.warning);
}
}
}
 sex1=num1;
sex2=num2;


var num1=0; var num2=0;
var playerid=document.getElementsByName('playerid[]');
    var playerids=document.getElementsByName('playerids[]');
  //  alert(playerid.length);
for(var i=0;i<playerid.length;i++){

 if(playerid[i].checked==true){
   var temp=0;
        for(var j=0;j<playerids.length;j++){

            if(playerid[i].value==playerids[j].value){

                temp=1;
            }

        }

if(temp==1){

if(document.getElementById('sex_'+playerid[i].value).value==1){

sex1--;
}

else sex2--;

}
}

}
 var playerid=document.getElementsByName('player_sex[]');

for(var i=0;i<playerid.length;i++){
if(playerid[i].value==1) num1++;
else num2++

}



var tt=num1+sex1;
if(tt>parseInt(team_num4)){

window.wxc.xcConfirm('男运动员最多不能超过'+team_num4+'人',window.wxc.xcConfirm.typeEnum.warning);
return false;
}
var tt=num2+sex2;
//alert(tt);
if(tt>parseInt(team_num5)){


window.wxc.xcConfirm('女运动员最多不能超过'+team_num5+'人',window.wxc.xcConfirm.typeEnum.warning);
return false;
}


    var playerid=document.getElementsByName('playerid[]');
        var playerids=document.getElementsByName('playerids[]');




for(var i=0;i<playerid.length;i++){
    if(playerid[i].checked==true){

        var temp=0;
        for(var j=0;j<playerids.length;j++){

            if(playerid[i].value==playerids[j].value){

                temp=1;
            }

        }

        if(temp==0){

            var str=" <li  id='playerid_"+playerid[i].value+"'>";

            str+="<a href='"+path+"../user/space.php?uid="+playerid[i].value+"' target='_blank'>"+document.getElementById('name_'+playerid[i].value).value+"</a>";

         str+=" <img src='"+path+"../static/images/del.png'  onclick='delete_player("+playerid[i].value+");'  title='删除'/>";

          str+=" <input type='hidden'  name='playerids[]' value='"+playerid[i].value+"'>";
          str+="<input type='hidden'  id='sex_"+playerid[i].value+"' name='player_sex[]' value='"+document.getElementById('sex_'+playerid[i].value).value+"'>";
          var waiyuan='';
            if(document.getElementById('waiyuan_1_'+playerid[i].value).checked) waiyuan=1;
            if(document.getElementById('waiyuan_2_'+playerid[i].value).checked) waiyuan=2;
str+="<input type='hidden'  name='player["+playerid[i].value+"][waiyuan]' value='"+waiyuan+"'>";
str+="<input type='hidden'  name='player["+playerid[i].value+"][danwei]' value='"+document.getElementById('player_danwei1_'+playerid[i].value).value+"'>";
//          <input type='hidden'  name="player[{$index}][danwei]" value="{$value['danwei']}">

         str+=" </li>";


           document.getElementById('player_ul').innerHTML+=str;


        }

    }

}
  if(playerids.length>0)
   document.getElementById('player_nums').innerHTML='当前已有<span id="player_num">'+playerids.length+'</span>名报名运动员';


    document.getElementById('player_sum').value=playerids.length;

}


function delete_player(id){



     document.getElementById('player_ul').removeChild(document.getElementById('playerid_'+id));
      document.getElementById('player_sum').value=document.getElementById('player_sum').value-1;
        document.getElementById('player_num').innerHTML=document.getElementById('player_sum').value;                          }

function click_sub(step){
if(step==1){
if(document.getElementById('name').value==''){


		window.wxc.xcConfirm('请输入队伍名称',window.wxc.xcConfirm.typeEnum.warning);
document.getElementById('name').focus();
		return  false;

	}

if(document.getElementById('player_sum').value<1){


		window.wxc.xcConfirm('报名运动员人数不能为0',window.wxc.xcConfirm.typeEnum.warning);

		return  false;

	}

if(document.getElementById('player_sum1').value>team_num4){


		window.wxc.xcConfirm('男运动员最多不能超过'+team_num4+'人',window.wxc.xcConfirm.typeEnum.warning);

		return  false;

	}
if(document.getElementById('player_sum2').value>team_num5){


		window.wxc.xcConfirm('女运动员最多不能超过'+team_num5+'人',window.wxc.xcConfirm.typeEnum.warning);

		return  false;

	}

}

if(step==3){
   var room= document.querySelectorAll('.room');
   if(room.length>0){
   var temp=0;
   for(var i=0;i<room.length;i++){

   if(room[i].value>0) temp++;

   }
   if(temp==0){

   	window.wxc.xcConfirm('您还没有选择要预定的房间',window.wxc.xcConfirm.typeEnum.warning);

		return  false;
   }

   }


}

if(step==4 ){



//if(document.getElementById('file_add2').value==''){
//
//
//		window.wxc.xcConfirm('外援的协议或有关证明',window.wxc.xcConfirm.typeEnum.warning);
//
//		return  false;
//
//	}
//
//	if(document.getElementById('file_add3').value==''){
//
//
//		window.wxc.xcConfirm('团队合影',window.wxc.xcConfirm.typeEnum.warning);
//
//		return  false;
//
//	}

}

}

var num_arr=Array('一','二','三','四','五','六','七','八','九','十','十一','十二','十三','十四','十五','十六','十七','十八','十九','二十');
function arrive_add(){

var str="<div class='info00' id='arrive_"+arrive_num+"'><div class='title00'>抵达时间"+num_arr[arrive_num];

if(arrive_num==0)
str+="<span class='icon_add1' onclick='arrive_add();'></span>";

str+="<span class='icon_add2' onclick='arrive_remove(\"arrive_"+arrive_num+"\");'></span>";
str+="</div><div>"
+"<span class='title'>抵达时间：</span><input type='text' class='Wdate input1'  name='arrive["+arrive_num+"][time]' value=''  style='width:200px !important;' minlength='18' maxlength='20' autofocus='' required='' autocomplete='off'  onclick=\"WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss',alwaysUseStartDate:false})\">（格式：yyyy-mm-dd  HH:ii:ss）<br>"
+"<span class='title'>航班号(车次)：</span><input type='text' style='width:200px !important;'   name='arrive["+arrive_num+"][hangban]' value='' required=''><br>"
+"<span class='title'>备注：</span><input type='text' style='width:200px !important;'   name='arrive["+arrive_num+"][mark]' value=''><br>"
+"<span class='title'>人数：</span><input type='number'  class='input1'  name='arrive["+arrive_num+"][num]' value='' min='1' max='1000'  autofocus='' required='' autocomplete='off' >人<br>"
+"<span class='title'>联系人：</span><input type='text'  style='width:200px !important;'  name='arrive["+arrive_num+"][contact]' value='' minlength='2' maxlength='20' autofocus='' required='' autocomplete='off' >"
+"<br><span class='title'>联系电话：</span><input type='text' style='width:200px !important;'   name='arrive["+arrive_num+"][tel]' value=''>"
+"</div></div>";

$('#arrive_div').append(str);
arrive_num++;
}


function arrive_remove(div){
$('#'+div).remove();
arrive_num--;
}


function level_add(){

var str="<div class='info00' id='level_"+level_num+"'><div class='title00'>离会时间"+num_arr[level_num];


str+="<span class='icon_add1' onclick='level_add();'></span>";

str+="<span class='icon_add2' onclick='level_remove(\"level_"+level_num+"\");'></span>";
str+="</div><div>"
+"<span class='title'>离会时间：</span><input type='text' class='Wdate input1'  name='level["+level_num+"][time]' value=''  style='width:200px !important;' minlength='18' maxlength='20' autofocus='' required='' autocomplete='off'  onclick=\"WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss',alwaysUseStartDate:false})\">（格式：yyyy-mm-dd  HH:ii:ss）<br>"
+"<span class='title'>航班号(车次)：</span><input type='text' style='width:200px !important;'   name='level["+level_num+"][hangban]' value='' required=''><br>"
    +"<span class='title'>备注：</span><input type='text' style='width:200px !important;'   name='level["+level_num+"][mark]' value=''><br>"
+"<span class='title'>人数：</span><input type='number'  class='input1'  name='level["+level_num+"][num]' value='' min='1' max='1000'  autofocus='' required='' autocomplete='off' >人<br>"
+"<span class='title'>联系人：</span><input type='text'  style='width:200px !important;'  name='level["+level_num+"][contact]' value='' minlength='2' maxlength='20' autofocus='' required='' autocomplete='off' >"
+"<br><span class='title'>联系电话：</span><input type='text' style='width:200px !important;'   name='level["+level_num+"][tel]' value=''>"
+"</div></div>";

$('#level_div').append(str);
level_num++;
}


function level_remove(div){
$('#'+div).remove();
level_num--;
}


function room_add(){

var str="<div class='info00' id='room_"+room_num+"'><div class='title00'>入住信息"+num_arr[room_num];



str+="<span class='icon_add2' onclick='room_remove(\"room_"+room_num+"\");'></span>";
str+="</div><div>"
+"<span class='title' >户型：</span><span ><select  name='room["+room_num+"][name]'>"+hotal_html+"</select></span><br>"
+"<span class='title' >数量：</span><input type='number' class='input' id='height'  name='room["+room_num+"][num]'  value=''  min='1' max='1000' step='1'> <br>"

+"<span class='title'>入住时间：</span><input type='text' class='Wdate input1' id='room_"+room_num+"_begintime' name='room["+room_num+"][begintime]' value=''  style='width:200px !important;' minlength='18' maxlength='20' autofocus='' required='' autocomplete='off'  onclick=\"WdatePicker({dateFmt:'yyyy-MM-dd',alwaysUseStartDate:false})\">（格式：yyyy-mm-dd）<br>"
+"<span class='title'>退房时间：</span><input type='text' class='Wdate input1' id='room_"+room_num+"_endtime' name='room["+room_num+"][endtime]' value=''  style='width:200px !important;' minlength='18' maxlength='20' autofocus='' required='' autocomplete='off'  onclick=\"WdatePicker({dateFmt:'yyyy-MM-dd',alwaysUseStartDate:false})\">（格式：yyyy-mm-dd）<br>"

+"</div><div style='clear:both'><span class='title'>备注：</span><input type='text'id='room_"+room_num+"_mark' name='room["+room_num+"][mark]' value=''  style='width:200px !important;' ></div></div>";

$('#room_div').append(str);
room_num++;
}


function room_remove(div){
$('#'+div).remove();
room_num--;
}

function set_room_date(value){

document.getElementById('text_html').innerHTML=value;

}



function select_room(room_id,num,begintime,endtime){
if(document.getElementById(begintime).value==''){


		window.wxc.xcConfirm('您还没有选择入住时间',window.wxc.xcConfirm.typeEnum.warning);

		return  false;

	}

if(document.getElementById(endtime).value==''){


		window.wxc.xcConfirm('您还没有选择离开时间',window.wxc.xcConfirm.typeEnum.warning);

		return  false;

	}
if(document.getElementById(begintime).value>=document.getElementById(endtime).value){
	window.wxc.xcConfirm('入住时间不能早于离开时间',window.wxc.xcConfirm.typeEnum.warning);

		return  false;
}
if(is_admin==1) var path='../';
else var  path='';


Sxmlhttprequest();

	xmlHttp.open('GET',path+'../ajax/search_room.php?room_id='+room_id+'&begintime='+document.getElementById(begintime).value+'&endtime='+document.getElementById(endtime).value+'&num='+num,true);
	xmlHttp.onreadystatechange=function(){


		if(xmlHttp.readyState==4){
		var msg=xmlHttp.responseText;

document.getElementById('roominfo_'+num).innerHTML=msg;

		}


	};
	xmlHttp.send(null);


}

var  danwei_type='';

var  danwei_id='';


function   set_danwei(value,id,type,search){

   var tt= document.querySelectorAll('.'+type+'_danwei');
    for(var i=0;i<tt.length;i++){

    tt[i].style.display='none';
    }
    danwei_id=id;
    danwei_type=type;


       document.getElementById(type+'_danwei_'+id).style.display='none';

      var str="<ul id="+type+"'_danwei2_"+id+"'>";

        for(var i=0;i<danwei_list.length;i++){
            if(search==0 || (search==1 && danwei_list[i].indexOf(value)>-1)){

            if(danwei_list[i]==value) var cl='class="cur"';
        else var cl='';

         str+='<li  onclick="set_danwei_select(\''+danwei_list[i]+'\');" '+cl+' >'+danwei_list[i]+'</li>';

            }


        }


        str+="</ul>";


     document.getElementById(type+'_danwei_'+id).innerHTML=str;





}


function set_danwei_select(value){

      document.getElementById(danwei_type+'_danwei1_'+danwei_id).value=value;
       document.getElementById(danwei_type+'_danwei_'+danwei_id).style.display='none';

}



function  search_room(tid){

document.getElementById('room_info').innerHTML="查询中...";
Sxmlhttprequest();

if(is_admin==1) var path='../';
else var  path='';
if(document.getElementById('begintime').value==''){

	alert('请选择入住日期');
	return false;

}


	xmlHttp.open('GET',path+'../ajax/search_hotal.php?begintime='+document.getElementById('begintime').value+'&hotal_name='+document.getElementById('hotal_name').value+'&tid='+tid,true);
	xmlHttp.onreadystatechange=function(){


		if(xmlHttp.readyState==4){
		var msg=xmlHttp.responseText;

document.getElementById('room_info').innerHTML=msg;

		}


	};
	xmlHttp.send(null);

}



function show_room(div,id){

if(div.checked==true){

document.getElementById('roomhtml_'+id).style.display='block';
}
else{
document.getElementById('roomhtml_'+id).style.display='none';
}
room_num11();
}


function room_num11(){

	var hotal=document.getElementsByName('hotal[]');
	var hotal_num=0;
	var room_num=0;

	for(var i=0;i<hotal.length;i++){
		if(hotal[i].checked==true){
			hotal_num++;
			var room0=document.querySelectorAll('.room_'+hotal[i].value);

			for(var j=0;j<room0.length;j++){
				if(room0[j].value>0)
				room_num=parseInt(room_num)+parseInt(room0[j].value);
			}

		}

	}


	var html="您选中了"+hotal_num+"个酒店，共"+room_num+"个房间。";
	if(room_num>0) html+="<input type='button' class='btn00' value='确认添加' onclick='add_room11();'>";

	document.getElementById('room_tip').innerHTML=html;
}


function  add_room11(){

	var hotal=document.getElementsByName('hotal[]');
	var hotal_num=0;
	var room_num=0;

	for(var i=0;i<hotal.length;i++){
		if(hotal[i].checked==true){
			hotal_num++;
			var room0=document.querySelectorAll('.room_'+hotal[i].value);
			var room_str='';
			for(var j=0;j<room0.length;j++){


				if(room0[j].value>0){

					if(room_str!='') room_str+='|';
				room_str+=room0[j].name+"^"+room0[j].value;
				room_num=parseInt(room_num)+parseInt(room0[j].value);
				}

			}
			var mark=document.getElementById('mark_'+hotal[i].value).value;
        var url="../ajax/room_add.php?tid="+team_id+'&hid='+hotal[i].value+"&room="+room_str+"&mark="+mark+"&begintime="+document.getElementById('begintime').value;
			Sxmlhttprequest();
	xmlHttp.open('GET',url,true);
	xmlHttp.onreadystatechange=function(){


		if(xmlHttp.readyState==4){
		var msg=xmlHttp.responseText;
get_room_list();
		}


	};
	xmlHttp.send(null);

		}

	}

}



function get_room_list(){


	        var url="../ajax/room_list.php?tid="+team_id;
			Sxmlhttprequest();
	xmlHttp.open('GET',url,true);
	xmlHttp.onreadystatechange=function(){


		if(xmlHttp.readyState==4){
		var msg=xmlHttp.responseText;

       document.getElementById('room_list').innerHTML=msg;

		}


	};
	xmlHttp.send(null);


}

function delete_hotal11(id){


	   var url="../ajax/room_list.php?type=delete&id="+id;

			Sxmlhttprequest();
	xmlHttp.open('GET',url,true);
	xmlHttp.onreadystatechange=function(){


		if(xmlHttp.readyState==4){
		var msg=xmlHttp.responseText;

      get_room_list();

		}


	};
	xmlHttp.send(null);



}






