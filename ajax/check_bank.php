<?php
include_once '../inc/common.php';
include_once '../inc/blank.inc.php';
header('Content-type:text/html;charset=utf-8');  
function bankInfo($card,$bankList)
{
    $card_8 = substr($card, 0, 8);
    if (isset($bankList[$card_8])) {
        return $bankList[$card_8];
    
    }
    $card_6 = substr($card, 0, 6);
    if (isset($bankList[$card_6])) {
        return $bankList[$card_6];
    
    }
    $card_5 = substr($card, 0, 5);
    if (isset($bankList[$card_5])) {
        return $bankList[$card_5];
        ;
    }
    $card_4 = substr($card, 0, 4);
    if (isset($bankList[$card_4])) {
        return $bankList[$card_4];
     
    }
   return  false;
}

function is_blank($str){
	
preg_match('/([\d]{4})([\d]{4})([\d]{4})([\d]{4})([\d]{3})?/', $str,$match);  
$num=0;
for($i=1;$i<6;$i++){
	if($i<5){
		if($match[$i]>=0 and $match[$i]<=9999  and strlen($match[$i])==4) $num++;
		
		
	}
	else {
	if($match[$i]>=0 and $match[$i]<=999  and strlen($match[$i])==3) $num++;	
		
	}
	
}

if($num==5  or $num==4) return true;
else return false;	
	
}
$str =$_GET['number'];

if(is_blank($str)){
$row=bankInfo($str,$bankList);
if($row){
	if($db->exec("select * from ".tname('bank')." where number='{$str}'")){
		
	echo "error|您输入的银行卡号已经被其他人使用";	
		
	}
else 	
	echo "ok|".$row;
} 
else echo "error|您输入的银行卡号不正确";

}
else{
	
	echo "error|您输入的银行卡格式不正确".is_blank($str);
	
}

?>