<?
require("../php/lib/config.php");

$class = "Cidade";
$obj = new $class();
$data = HttpUtil::getParameterArray();

if($data) {
	$id = array_key_exists("id", $data) ? $data["id"] : 0;
	$action = array_key_exists("action", $data) ? $data["action"] : 0;
	unset($data["action"]);

	if($id) {
		$obj = $class::find($id);
	}

	if($action) {
		switch($action) {
			case "create":
				$obj = new $class($data);
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

		if($obj->is_invalid()) {
			$msgError = $obj->errors->full_messages();
		}

		$obj = new $class();
	}
}

$itens = $class::all(array("order" => "nome asc"));
?>

<html>
	<head>
		<title>Menu du Chef</title>
		<script type="text/javascript" src="js/jquery-1.6.4.min.js"></script>
		<link rel="stylesheet" type="text/css" href="../css/style.css" />
	</head>
	<body>

		<? include("../include/messages.php"); ?>

		<h2>Gerenciar Cidades</h2>
		<form action="<?= HttpUtil::getControllerFromCurrentPage() ?>" method="post">
			<input type="hidden" name="action" value="<?= $obj->id ? "update" : "create" ?>" />
			<input type="hidden" name="id" value="<?= $obj->id ?>" />
			Nome<br />
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