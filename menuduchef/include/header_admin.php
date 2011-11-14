<?
$libDirectoryArray = array("php/lib", "../php/lib", "../../php/lib");

foreach ($libDirectoryArray as $directory) {
    if (is_dir($directory)) {
        $libDirectory = $directory;
    }
}

include_once("{$libDirectory}/config.php");

$usuario_logado = unserialize($_SESSION['usuario']);
$usuario_logado_obj = unserialize($_SESSION['usuario_obj']);

if(!$usuario_logado || $usuario_logado->tipo == Usuario::$CONSUMIDOR) {
    $_SESSION['request_fail'] = $_SERVER["REQUEST_URI"];
    HttpUtil::redirect('../404');
}

if (HttpUtil::isLocalhost()) {
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
	<script type="text/javascript" src="js/jquery-ui-1.8.16.custom.min.js"></script>
        <script type="text/javascript" src="js/util.js"></script>
        <script type='text/javascript' src="js/quickmenu.js"></script>
        <link rel="stylesheet" type="text/css" href="css/style.css" />
        <link rel="stylesheet" type="text/css" href="css/menu.css" />
	<link rel="stylesheet" type="text/css" href="css/custom-theme/jquery-ui-1.8.16.custom.css" />
    </head>
    <body>
        
        <div id="conteudo">
	    <? include('messages.php'); ?>
	    <? include('painel_area_administrativa.php') ;?>