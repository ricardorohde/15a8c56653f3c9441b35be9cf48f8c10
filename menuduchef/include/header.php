<?
$libDirectoryArray = array("php/lib", "../php/lib", "../../php/lib");

foreach ($libDirectoryArray as $directory) {
    if (is_dir($directory)) {
	$libDirectory = $directory;
    }
}

require_once("{$libDirectory}/constant.php");

if (($_SERVER['HTTP_HOST'] == 'servidor') || ($_SERVER['HTTP_HOST'] == 'localhost') || ($_SERVER['HTTP_HOST'] == '127.0.0.1')) {
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
	<link rel="stylesheet" type="text/css" href="css/style.css" />
    </head>
    <body>

    <? include("messages.php"); ?>