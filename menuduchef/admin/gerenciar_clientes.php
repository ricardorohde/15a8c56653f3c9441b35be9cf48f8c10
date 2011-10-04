<?php

require("../php/lib/config.php");

$obj = new Consumidor();

$data = $_POST ? $_POST : ($_GET ? $_GET : 0);
$msgError = "";

if($data) {
        $id = array_key_exists("id", $data) ? $data["id"] : 0;
        $action = array_key_exists("action", $data) ? $data["action"] : 0;
        unset($data["action"]);
    
        if($id) {
		$obj = Consumidor::find($id);
	}
        
        if($action) {
                switch($action) {
                        case "create":
				$obj = new Consumidor($data);
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

		$obj = new Consumidor();
        }
}

$itens = Consumidor::all(array("order" => "nome asc"));

$bairros = Bairro::all(array("order" => "nome asc"));
$cidades = Cidades::all(array("order" => "nome asc"));

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

		<h2>Gerenciar Consumidores</h2>
		<form action="" method="post">
			<input type="hidden" name="action" value="<?= $obj->id ? "update" : "create" ?>" />
			<input type="hidden" name="id" value="<?= $obj->id ?>" />
			Nome: 
			<input type="text" name="nome" value="<?= $obj->nome ?>" maxlength="100" /><br />
                        Cidade: 
			<select name="id_cidade" maxlength="100" >
                            <? if($cidades) {
				foreach($cidades as $index => $cid) {
                                        $sel = "";
                                        if($obj->id_cidade==$cid->id){
                                               $sel = "selected";                                     
                                        }
					echo "<option value='$cid->id' $sel>";
					echo "$cid->nome";
					echo "</option>";
				}
                            } ?>
                            
                        </select><br />
                        Bairro: 
			<select name="id_bairro" maxlength="100" >
                            <? if($bairros) {
				foreach($bairros as $index => $bai) {
                                        $sel = "";
                                        if($obj->id_bairro==$bai->id){
                                               $sel = "selected";                                     
                                        }
					echo "<option value='$bai->id' $sel>";
					echo "$bai->nome";
					echo "</option>";
				}
                            } ?>
                            
                        </select><br />
                        <br />
			<input type="submit" value="<?= $obj->id ? "Modificar" : "Criar" ?>" />
		</form>
		<hr />
		<h2>Consumidores Cadastrados</h2>
		<table>
			<tr>
				<th>Consumidor</th>
                                <th>Cidade</th>
                                <th>Bairro</th>
                                <th>Endereco</th>
                                <th>Telefone</th>
                                <th>Desativado</th>
                                <th>login</th>
                                <th>senha</th>
				<th>Modificar</th>
				<th>Excluir</th>
			</tr>
			<?
			if($itens) {
				foreach($itens as $item) {
					?>
					<tr>
						<td><?= $item->nome ?></td>
                                                <td><?= $item->cidade->nome ?></td>
                                                <td><?= $item->bairro->nome ?></td>
                                                <td><?= $item->endereco ?></td>
                                                <td><?= $item->telefone ?></td>
                                                <td><?= $item->desativado ?></td>
                                                <td><?= $item->login ?></td>
                                                <td><?= $item->senha ?></td>
						<td><a href="?id=<?= $item->id ?>">Modificar</a></td>
						<td><a href="?id=<?= $item->id ?>&action=delete" onclick="return window.confirm('Confirmar exclusão?')">Excluir</a></td>
					</tr>
					<?
				}
			} else {
				?>
				<tr>
					<td colspan="10">Nenhum cliente cadastrado</td>
				</tr>
			<? } ?>
		</table>
	</body>
</html>