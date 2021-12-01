<?php
include_once '../inc/common.php';




   if(strtoupper($_GET['code'])==$_SESSION['code']){
echo 'ok';

   }
   else{

   	echo 'error';
   }


?>
