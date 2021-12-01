<?php
include_once '../../inc/common.php';
$AdminServerRoot = substr(dirname(__FILE__), 0, -4).'/';
define('ADMIN_ABSOLUTE_PATH', $AdminServerRoot);
define('ADMIN_TEMPLATE_PATH', $AdminServerRoot.'template');
$AdminHostName = $_SERVER['HTTP_HOST'];
$AdminrootLen = strlen($_SERVER['DOCUMENT_ROOT']);
if(substr($_SERVER['DOCUMENT_ROOT'], $AdminrootLen-1, 1) == '/')$AdminrootLen = $AdminrootLen-1;
$AdminServerRelativPath = substr($AdminServerRoot, $AdminrootLen, strlen($AdminServerRoot)-$AdminrootLen);
$AdminHttpPath = str_replace('\\', '/', "//{$AdminHostName}{$AdminServerRelativPath}");
$AdminAbsolutePath = str_replace('\\', '/', ADMIN_ABSOLUTE_PATH);


if(!$userid) $userid='0';

