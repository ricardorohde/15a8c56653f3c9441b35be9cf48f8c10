<?
$libDirectoryArray = array("php/lib", "../php/lib", "../../php/lib");

foreach ($libDirectoryArray as $directory) {
    if (is_dir($directory)) {
	$libDirectory = $directory;
    }
}

include_once("{$libDirectory}/config.php");

if (HttpUtil::isLocalhost()) {
    $baseHref = "http://{$_SERVER['HTTP_HOST']}/menuduchef/";
} else {
    $baseHref = URL_PRODUCTION;
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
    "http://www.w3.org/TR/html4/strict.dtd"
    >
<html lang="pt">
    <head>
        <title><?= SITE_TITLE ?></title>
        <base href="<?= $baseHref ?>" />
        <script type="text/javascript" src="js/jquery-1.6.4.min.js"></script>
	<script type="text/javascript" src="js/jquery-ui-1.8.16.custom.min.js"></script>
        <script type="text/javascript" src="js/util.js"></script>
        <script type='text/javascript' src="js/quickmenu.js"></script>
        <script type="text/javascript">
            var imgLoading = new Image();
            imgLoading.src = '<?= PATH_IMAGE_LOADING ?>';
        </script>
        <link rel="stylesheet" type="text/css" href="css/style.css" />
        <link rel="stylesheet" type="text/css" href="css/menu.css" />
	<link rel="stylesheet" type="text/css" href="css/custom-theme/jquery-ui-1.8.16.custom.css" />
	<link rel="stylesheet" href="css/blueprint/screen.css" type="text/css" media="screen, projection">
	<link rel="stylesheet" href="css/blueprint/print.css" type="text/css" media="print">  
	<link rel="stylesheet" href="css/estilo.css" type="text/css" media="screen"> 
	<!--[if lt IE 8]><link rel="stylesheet" href="css/blueprint/ie.css" type="text/css" media="screen, projection"><![endif]-->
    </head>
    <body>
	<div class="container">
	    <div id="background_container">
		    <? include('messages.php'); ?>