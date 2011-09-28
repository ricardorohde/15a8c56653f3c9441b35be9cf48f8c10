<?
require("../php/lib/config.php");

$cidades = Cidade::all();

?>

<html>
	<head>
		<title>Menu du Chef</title>
		<script type="text/javascript" src="js/jquery-1.6.4.min.js"></script>
		<style type="text/css">
			table { border-collapse: collapse; }
			table tr td, table tr th { border: #000 solid 1px; }
		</style>
	</head>
	<body>
		<h2>Cadastrar</h2>
		<form action="?action=cadastrar" method="post">

		</form>
		<hr />
		<h2>Cidades Cadastradas</h2>
		<table>
			<tr>
				<th>Cidade</th>
				<th>Modificar</th>
				<th>Excluir</th>
			</tr>
			<?
			if($cidades) {
				foreach($cidades as $cidade) {
			?>
			<tr>
				<td><?= $cidade->nome ?></td>
				<td><a href="?id=<?= $cidade->id ?>">Modificar</a></td>
				<td><a href="?id=<?= $cidade->id ?>&action=excluir">Excluir</a></td>
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