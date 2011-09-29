<?
require("../php/lib/config.php");

$obj = new Cidade();

$data = $_POST ? $_POST : ($_GET ? $_GET : 0);
$msgError = "";

if($data) {
	$id = array_key_exists("id", $data) ? $data["id"] : 0;
	$action = array_key_exists("action", $data) ? $data["action"] : 0;
	unset($data["action"]);

	if($id) {
		$obj = Cidade::find($id);
	}

	if($action) {
		if($action == "create" || $action == "update") {
			if($obj->is_invalid()) {
				$msgError = $obj->errors->full_messages();
			}
		}
		switch($action) {
			case "create":
				$obj = new Cidade($data);
				$obj->save();
				break;

			case "update":
				$obj->update_attributes($data);
				break;

			case "delete":
				$obj->delete();
				break;

			default:
				break;
		}

		$obj = new Cidade();
	}
}

$itens = Cidade::all(array("order" => "nome asc"));
?>

<html>
	<head>
		<title>Menu du Chef</title>
		<script type="text/javascript" src="js/jquery-1.6.4.min.js"></script>
		<style type="text/css">
			table { border-collapse: collapse; }
			table tr td, table tr th { border: #000 solid 1px; }
			.error { float: left; width: 50%; background-color: red; color: white; font-weight: bold; padding: 2px; }
		</style>
	</head>
	<body>

		<? if($msgError) {
			foreach($msgError as $msg) {
		?>
		<div class="error"><?= $msg ?></div>
		<? } ?>
		<br clear="all" />
		<? } ?>

		<h2>Gerenciar Cidades</h2>
		<form action="" method="post">
			Nome<br />
			<input type="hidden" name="action" value="<?= $obj->id ? "update" : "create" ?>" />
			<input type="hidden" name="id" value="<?= $obj->id ?>" />
			<input type="text" name="nome" value="<?= $obj->nome ?>" maxlength="100" /><br /><br />
			<input type="submit" value="<?= $obj->id ? "Modificar" : "Criar" ?>" />
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
			if($itens) {
				foreach($itens as $item) {
					?>
					<tr>
						<td><?= $item->nome ?></td>
						<td><a href="?id=<?= $item->id ?>">Modificar</a></td>
						<td><a href="?id=<?= $item->id ?>&action=delete" onclick="return window.confirm('Confirmar exclusão?')">Excluir</a></td>
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