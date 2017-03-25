<?php
ini_set('display_errors',1);
error_reporting(E_ALL);

Header('Content-Type: text/html; charset=utf-8');

list($msec, $sec) = explode(chr(32), microtime());
$time = $sec + $msec;

$pereadres = "";
$base_url = "http://delfbrick.ru/";

$request = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];

//www.
$poz_www = strrpos($request, "www.");
if ($poz_www !== false) 
{
	$request = str_replace("www.", "", $request);
	$pereadres = "Location: ".$request;
}

//admin.php
$poz_admin = strrpos($request, "admin.php");
if ($poz_admin !== false) $pereadres = "Location: ".$base_url."admin/";

if (strlen($pereadres) > 0)
{
	header("HTTP/1.1 301 Moved Permanently");
	header($pereadres);
	exit();
}

// change the following paths if necessary
$yii=dirname(__FILE__).'/framework/yii.php';
$config=dirname(__FILE__).'/protected/config/main.php';

// remove the following lines when in production mode
//defined('YII_DEBUG') or define('YII_DEBUG',true);
// specify how many levels of call stack should be shown in each log message
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);

require_once($yii);
Yii::createWebApplication($config)->run();

list($msec, $sec) = explode(chr(32), microtime());
//echo '<div style="display:none">Генерация скрипта '.round(($sec + $msec) - $time, 4).' секунд</div>';