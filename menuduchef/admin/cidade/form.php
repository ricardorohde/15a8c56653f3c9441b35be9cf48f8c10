<?
require("../../php/lib/config.php");

$obj = new Cidade();

if($_GET["id"]) {
    $obj = Cidade::find($_GET["id"]);
}
?>

<html>
    <head>
	<title>Menu du Chef</title>
	<script type="text/javascript" src="../../js/jquery-1.6.4.min.js"></script>
	<link rel="stylesheet" type="text/css" href="../../css/style.css" />
    </head>
    <body>

	<? include("../../include/messages.php"); ?>

	<h2>Gerenciar Cidades</h2>
	
	<a href="<?= $_GET["id"] ? "../" : "" ?>list" title="Cancelar">Cancelar</a>
	<br /><br />
	
	<form action="<?= $obj->id ? "../controller" : "controller" ?>" method="post">
	    <input type="hidden" name="action" value="<?= $obj->id ? "update" : "create" ?>" />
	    <input type="hidden" name="id" value="<?= $obj->id ?>" />
	    Nome<br />
	    <input type="text" name="nome" value="<?= $obj->nome ?>" maxlength="100" /><br /><br />
	    <input type="submit" value="<?= $obj->id ? "Modificar" : "Criar" ?>" />
	</form>
    </body>
</html>