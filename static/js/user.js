    var u = navigator.userAgent;
    var isAndroid = u.indexOf('Android') > -1 || u.indexOf('Adr') > -1; //android终端
    var isiOS = !!u.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/); //ios终端



function is_float(value){
       var reg = new RegExp("^[0-9]*$");

    if(!reg.test(value)){
      return false;
    }
   else return true;
  }





  function   check_info(id){

  if(id=='height'){
var temp=document.getElementById('height');
if(temp.value!=''){


if(!isNaN(temp.value)){
if(parseFloat(temp.value)<140 || parseFloat(temp.value)>250){
window.wxc.xcConfirm('身高必须在140-250cm之间',window.wxc.xcConfirm.typeEnum.warning);
temp.focus();
return  false;
}



}
else{
window.wxc.xcConfirm('请输入正确的身高',window.wxc.xcConfirm.typeEnum.warning);
temp.focus();
		return  false;


}
	}


  }

if(id=='weight'){
var temp=document.getElementById('weight');
if(temp.value!=''){

if(!isNaN(temp.value)){

if(parseFloat(temp.value)<40 || parseFloat(temp.value)>150){
window.wxc.xcConfirm('体重必须在40-150KG之间',window.wxc.xcConfirm.typeEnum.warning);

return  false;
}



}
else{
window.wxc.xcConfirm('请输入正确的体重',window.wxc.xcConfirm.typeEnum.warning);

		return  false;


}
	}


}


if(id=='ballweight'){


var temp=document.getElementById('ballweight');
if(temp.value!=''){

if(!isNaN(temp.value)){
if(parseFloat(temp.value)<1 || parseFloat(temp.value)>16){
window.wxc.xcConfirm('球重必须在1-16磅之间',window.wxc.xcConfirm.typeEnum.warning);

return  false;
}

}
else{
window.wxc.xcConfirm('请输入正确的球重',window.wxc.xcConfirm.typeEnum.warning);

		return  false;


}
	}




}


if(id=='score1'){


var temp=document.getElementById('score1');
if(temp.value!=''){

if(!isNaN(temp.value)){
if(parseFloat(temp.value)<0 || parseFloat(temp.value)>300){
window.wxc.xcConfirm('单局最高分必须在0-300之间',window.wxc.xcConfirm.typeEnum.warning);

return  false;
}



}
else{
window.wxc.xcConfirm('请输入正确的单局最高分',window.wxc.xcConfirm.typeEnum.warning);

		return  false;


}
	}

}



if(id=='score3'){

	var temp=document.getElementById('score3');
if(temp.value!=''){

if(!isNaN(temp.value)){
if(parseFloat(temp.value)<0 || parseFloat(temp.value)>900){
window.wxc.xcConfirm('三局最高分必须在0-900之间',window.wxc.xcConfirm.typeEnum.warning);

return  false;
}



}
else{
window.wxc.xcConfirm('请输入正确的三局最高分',window.wxc.xcConfirm.typeEnum.warning);

		return  false;


}
	}



}


if(id=='score6'){

	var temp=document.getElementById('score6');
if(temp.value!=''){

if(!isNaN(temp.value)){
if(parseFloat(temp.value)<0 || parseFloat(temp.value)>1800){
window.wxc.xcConfirm('六局最高分必须在0-1800之间',window.wxc.xcConfirm.typeEnum.warning);

return  false;
}



}
else{
window.wxc.xcConfirm('请输入正确的六局最高分',window.wxc.xcConfirm.typeEnum.warning);

		return  false;


}
	}

}


  }

var sub=1;
function  check_ok(){
sub=0;
if(isiOS!=true)document.getElementById('click_next').click();
sub=1;
}

function click_sub(step,group){

   if(step==1){

   if(group!='4'){


if(document.getElementById('realname').value==''){


		window.wxc.xcConfirm('请输入真实姓名',window.wxc.xcConfirm.typeEnum.warning);
document.getElementById('realname').focus();
		return  false;

	}

var  sex=document.getElementsByName('sex');

var sta=idCardNo(document.getElementById('idcard').value);

if(sta==true){
setidcard(document.getElementById('idcard').value);
}else{
		window.wxc.xcConfirm('身份证号码不正确',window.wxc.xcConfirm.typeEnum.warning);

		return  false;

}

var sex_check=0;
for(var i=0;i<sex.length;i++){

if(sex[i].checked==true)sex_check=1;

}

if(sex_check==0){
	//window.wxc.xcConfirm('请选择性别',window.wxc.xcConfirm.typeEnum.warning);

	//	return  false;

}
}

else{

if(document.getElementById('realname').value==''){


		window.wxc.xcConfirm('请输入单位名称',window.wxc.xcConfirm.typeEnum.warning);
document.getElementById('realname').focus();
		return  false;

	}

}

}


if(step==2 && (group==1 || group==2)){




if(isiOS==true){
if(check_info('height')==false) return false;
if(check_info('weight')==false) return false;
if(check_info('ballweight')==false) return false;
}

if(sub==1){
if(document.getElementById('fromtime').value==''){


		window.wxc.xcConfirm('请填写开始打球时间',window.wxc.xcConfirm.typeEnum.warning);

		return  false;

	}




var  sex=document.getElementsByName('player[playkinds]');
var sex_check=0;
for(var i=0;i<sex.length;i++){

if(sex[i].checked==true)sex_check=1;

}

if(sex_check==0){
	window.wxc.xcConfirm('请选择技术打法',window.wxc.xcConfirm.typeEnum.warning)
		return  false;
}



var  sex=document.getElementsByName('player[hand]');
var sex_check=0;
for(var i=0;i<sex.length;i++){

if(sex[i].checked==true)sex_check=1;

}

if(sex_check==0){
	window.wxc.xcConfirm('请选择惯用手',window.wxc.xcConfirm.typeEnum.warning);

		return  false;

}


}


if(isiOS==true){
if(check_info('score1')==false) return false;
if(check_info('score3')==false) return false;
if(check_info('score6')==false) return false;
}

}





if(step==3){
var sta=checkMobile(document.getElementById('mobile').value);


if(document.getElementById('email').value!=''){
var sta=checkEmail(document.getElementById('email').value);

if(sta!=true){

		window.wxc.xcConfirm('邮箱格式不正确',window.wxc.xcConfirm.typeEnum.warning);

		return  false;
}

}
}





if(step==4){

var ss=confirm('确定要提交么? ')

if(ss==false) return false;
else return true;

}




}
function checkMobile(str) {
    var re =  /^(((13[0-9]{1})|(15[0-9]{1})|(17[0-9]{1})|(18[0-9]{1}))+\d{8})$/;
   if(re.test(str)){
      return true;
    }else{
        return false;
    }
}


function checkEmail(str){
    var re = /^(\w-*\.*)+@(\w-?)+(\.\w{2,})+$/
    if(re.test(str)){
      return true;
    }else{
        return false;
    }
}
function setidcard(value){

var sta=idCardNo(value);

if(sta==true){

document.getElementById('birth_html').innerHTML=document.getElementById('birth').value=IdCard(value,1);
var sex1=IdCard(value,2);
document.getElementById('sex').value=sex1;

if(sex1==1)document.getElementById('sex_html').innerHTML='男';
if(sex1==2)document.getElementById('sex_html').innerHTML='女';

}
else{
		window.wxc.xcConfirm('身份证号码不正确',window.wxc.xcConfirm.typeEnum.warning);

		return  false;

}


}




function idCardNo(value){
  //验证身份证号方法
  var area = { 11: "北京", 12: "天津", 13: "河北", 14: "山西", 15: "内蒙古", 21: "辽宁", 22: "吉林", 23: "黑龙江", 31: "上海", 32: "江苏", 33: "浙江", 34: "安徽", 35: "福建", 36: "江西", 37: "山东", 41: "河南", 42: "湖北", 43: "湖南", 44: "广东", 45: "广西", 46: "海南", 50: "重庆", 51: "四川", 52: "贵州", 53: "云南", 54: "西藏", 61: "陕西", 62: "甘肃", 63: "青海", 64: "宁夏", 65: "xinjiang", 71: "台湾", 81: "香港", 82: "澳门", 91: "国外" }
  var idcard, Y, JYM;
  var idcard=value;
  var S, M;
  var idcard_array = new Array();
  idcard_array = idcard.split("");
  if (area[parseInt(idcard.substr(0, 2))] == null) return false;
  switch (idcard.length) {
      case 15:
          if ((parseInt(idcard.substr(6, 2)) + 1900) % 4 == 0 || ((parseInt(idcard.substr(6, 2)) + 1900) % 100 == 0 && (parseInt(idcard.substr(6, 2)) + 1900) % 4 == 0)) {
              ereg = /^[1-9][0-9]{5}[0-9]{2}((01|03|05|07|08|10|12)(0[1-9]|[1-2][0-9]|3[0-1])|(04|06|09|11)(0[1-9]|[1-2][0-9]|30)|02(0[1-9]|[1-2][0-9]))[0-9]{3}$/; //测试出生日期的合法性
          }
          else {
              ereg = /^[1-9][0-9]{5}[0-9]{2}((01|03|05|07|08|10|12)(0[1-9]|[1-2][0-9]|3[0-1])|(04|06|09|11)(0[1-9]|[1-2][0-9]|30)|02(0[1-9]|1[0-9]|2[0-8]))[0-9]{3}$/; //测试出生日期的合法性
          }
          if (ereg.test(idcard))
              //return Errors[0];
            var res = true;
          else
              //return Errors[2];
            var res = false;
          return res;
          break;
      case 18:
          if (parseInt(idcard.substr(6, 4)) % 4 == 0 || (parseInt(idcard.substr(6, 4)) % 100 == 0 && parseInt(idcard.substr(6, 4)) % 4 == 0)) {
              ereg = /^[1-9][0-9]{5}19[0-9]{2}((01|03|05|07|08|10|12)(0[1-9]|[1-2][0-9]|3[0-1])|(04|06|09|11)(0[1-9]|[1-2][0-9]|30)|02(0[1-9]|[1-2][0-9]))[0-9]{3}[0-9Xx]$/; //闰年出生日期的合法性正则表达式
          }
          else {
              ereg = /^[1-9][0-9]{5}19[0-9]{2}((01|03|05|07|08|10|12)(0[1-9]|[1-2][0-9]|3[0-1])|(04|06|09|11)(0[1-9]|[1-2][0-9]|30)|02(0[1-9]|1[0-9]|2[0-8]))[0-9]{3}[0-9Xx]$/; //平年出生日期的合法性正则表达式
          }
          if (ereg.test(idcard)) {
              S = (parseInt(idcard_array[0]) + parseInt(idcard_array[10])) * 7 + (parseInt(idcard_array[1]) + parseInt(idcard_array[11])) * 9 + (parseInt(idcard_array[2]) + parseInt(idcard_array[12])) * 10 + (parseInt(idcard_array[3]) + parseInt(idcard_array[13])) * 5 + (parseInt(idcard_array[4]) + parseInt(idcard_array[14])) * 8 + (parseInt(idcard_array[5]) + parseInt(idcard_array[15])) * 4 + (parseInt(idcard_array[6]) + parseInt(idcard_array[16])) * 2 + parseInt(idcard_array[7]) * 1 + parseInt(idcard_array[8]) * 6 + parseInt(idcard_array[9]) * 3;
              Y = S % 11;
              M = "F";
              JYM = "10X98765432";
              M = JYM.substr(Y, 1);
              if (M == idcard_array[17])
                  //return Errors[0];
                var res = true;
              else
                  //return Errors[3];
                var res = false;
          }
          else
              //return Errors[2];
            res = false;
          return res;
          break;
      default:
          res = false;
          return res;
          break;
    };
}

function IdCard(UUserCard,num){
if(num==1){
//获取出生日期
birth=UUserCard.substring(6, 10) + "-" + UUserCard.substring(10, 12) + "-" + UUserCard.substring(12, 14);
return birth;
}
if(num==2){
//获取性别
if (parseInt(UUserCard.substr(16, 1)) % 2 == 1) {
//男
return 1;
}
else
{
//女
return 2;
}
}
if(num==3){
//获取年龄
var myDate = new Date();
var month = myDate.getMonth() + 1;
var day = myDate.getDate();
var age = myDate.getFullYear() - UUserCard.substring(6, 10) - 1;
if (UUserCard.substring(10, 12) < month || UUserCard.substring(10, 12) == month && UUserCard.substring(12, 14) <= day)
 {
 age++;
 }
return age;
}
}


function change_group(value){


     var str=player_group[value];
     var arr=str.split('|');
     var html="<select name='player[group2]'>";

     for(var i=0;i<arr.length;i++){

     html+="<option value='"+arr[i]+"'>"+arr[i]+"</option>";

     }

     html+="</select>";

document.getElementById('group2').innerHTML=html;
}




















