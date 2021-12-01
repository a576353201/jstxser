<?php
function downfile($fileurl) {
	ob_start();
	  $filename=$fileurl;
	  $date=date("Ymd-H:i:m");
	 header( "Content-type:  application/octet-stream ");
	  header( "Accept-Ranges:  bytes ");
	    header( "Content-Disposition:  attachment;  filename= {$date}.sql");
	     $size=readfile($filename);
	 header( "Accept-Length: " .$size);
	 }



	 downfile($_GET['file']);
?>
