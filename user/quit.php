<?php
session_start();
session_unset();
session_destroy();
setcookie("userid", '',time()-3600*24,'/');
session_start();


echo "<script>window.location='/pc/login.php';</script>";
?>
