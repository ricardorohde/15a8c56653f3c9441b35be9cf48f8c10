<?
$libDirectoryArray = array("php/lib", "../php/lib", "../../php/lib");

foreach ($libDirectoryArray as $directory) {
    if (is_dir($directory)) {
	$libDirectory = $directory;
    }
}

include_once("{$libDirectory}/config.php");

if(HttpUtil::isLocalhost()) {
    $baseHref = "http://{$_SERVER['HTTP_HOST']}/menuduchef/";
} else {
    $baseHref = URL_PRODUCTION;
}
?>
<html>
    <head>
	<title><?= SITE_TITLE ?></title>
	<base href="<?= $baseHref ?>" />
	<script type="text/javascript" src="js/jquery-1.6.4.min.js"></script>
	<script type="text/javascript" src="js/ajax_util.js"></script>
	<link rel="stylesheet" type="text/css" href="css/style.css" />
    </head>
    <body>

    <? include("messages.php"); ?>