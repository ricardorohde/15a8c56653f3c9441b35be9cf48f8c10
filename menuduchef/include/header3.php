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
	<style type="text/css">
	    /* TODO ver se adiciona essas regras em algum arquivo css depois; não adicionei agora para evitar conflitos */
	    #btn-atualizar { float: left; margin-bottom: 10px; }
	    #loading-painel { float: left; display:block; margin-left: 10px; }
	    #loading-painel img { float:left; margin-right: 3px; }
	    #colunas-pedidos { float: left; width: 100%; border-bottom: #000 solid 1px; }
	    .pedidos { float:left; width: 33.3%; border-right: #000 solid 1px; }
	    .pedidos#finalizados { border-right: none; }
	    .pedidos h3 { float: left; width: 98%; padding: 1%; border-right: #fff solid 1px;  color: #fff; background-color: #000; text-align: center; font-weight: bold; }
	    .pedidos ul { float:left; width: 100%; height: 250px; overflow: auto; margin: 0; list-style-type: none; }
	    .pedidos ul li { float: left; width: 98%; margin: 0; padding: 1%; cursor: pointer; border-bottom: #000 solid 2px; }
	    .pedidos#novos ul li { background-color: yellow; color: #000; }
	    .pedidos#preparacao ul li { background-color: green; color: #fff; }
	    .pedidos#finalizados ul li { background-color: red; color: #fff; }
	    #controles-pedido { float: left; width: 98%; padding: 1%; background-color: #ccc; }
	    #controles-pedido input { padding: 3px; width: 20%; border: #000 solid 1px; color: #fff; font-size: 14px; cursor: pointer; }
	    #controles-pedido input#btn-avancar { background-color: green;  margin-left: 25%; margin-right: 10%; }
	    #controles-pedido input#btn-cancelar { background-color: red; }
	    #detalhes-pedido { float: left; width: 100%; }
	    #detalhes-cliente, #detalhes-produtos { float: left; height: 300px; padding-top: 5px; }
	    #detalhes-cliente { width: 32.3%; border-right: #000 solid 1px; padding-right: 1%; }
	    #detalhes-produtos { width: 65.7%; padding-left: 1%; }
	    #detalhes-produtos table { border-collapse: collapse; width: 100%; }
	    #detalhes-produtos table td, #detalhes-produtos table th { border: #000 solid 1px; text-align: center; padding: 5px; font-size: 14px; }
	</style>
    </head>
    <body>
        
        <div id="conteudo">
	    <? include('messages.php'); ?>