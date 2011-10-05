<?
require("../../php/lib/config.php");

$itens = Cidade::all(array("order" => "nome asc"));
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
	
	<a href="form" title="Criar">Criar</a>
	<br /><br />
	
	<table>
	    <tr>
		<th>Cidade</th>
		<th>Modificar</th>
		<th>Excluir</th>
	    </tr>
	    <?
	    if ($itens) {
		foreach ($itens as $item) {
		    ?>
		    <tr>
			<td><?= $item->nome ?></td>
			<td><a href="form/<?= $item->id ?>">Modificar</a></td>
			<td><a href="controller?id=<?= $item->id ?>&action=delete" onclick="return window.confirm('Confirmar exclusão?')">Excluir</a></td>
		    </tr>
		    <?
		}
	    } else {
		?>
    	    <tr>
    		<td colspan="3">Nenhuma cidade cadastrada</td>
    	    </tr>
	    <? } ?>
	</table>
    </body>
</html>