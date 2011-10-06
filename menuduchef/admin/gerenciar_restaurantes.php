<?php

include_once("../php/lib/config.php");

$obj = new Restaurante();

$data = $_POST ? $_POST : ($_GET ? $_GET : 0);
$msgError = "";

if($data) {
        $id = array_key_exists("id", $data) ? $data["id"] : 0;
        $action = array_key_exists("action", $data) ? $data["action"] : 0;
        unset($data["action"]);

    
        if($id) {
		$obj = Restaurante::find($id);
	}
        
        if($action) {
                switch($action) {
                        case "create":
				$obj = new Restaurante($data);
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

		$obj = new Restaurante();
        }
}

$itens = Restaurante::all(array("order" => "nome asc"));


$cidades = Cidade::all(array("order" => "nome asc"));
$adms = Administrador::all(array("order" => "nome asc"));

?>

<html>
	<head>
		<title>Menu du Chef</title>
		<script type="text/javascript" src="../js/jquery-1.6.4.min.js"></script>
                <script>
                $(document).ready(function(){
                    $('#cidades').change(function(){
                        $('#bairros').load('../php/controller/combobox_bairros.php?cidade='+$('#cidades').val() );
                    });
                });
                </script>
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

		<h2>Gerenciar Restaurantes</h2>
		<form action="" method="post">
			<input type="hidden" name="action" value="<?= $obj->id ? "update" : "create" ?>" />
			<input type="hidden" name="id" value="<?= $obj->id ?>" />
                        
			Nome: 
			<input type="text" name="nome" value="<?= $obj->nome ?>" maxlength="100" /><br />
                        Cidade: 
			<select id="cidades" name="id_cidade" maxlength="100" >
                            <? if($cidades) {
				foreach($cidades as $index => $cid) {
                                        $sel = "";
                                        if($obj->cidade->id==$cid->id){
                                               $sel = "selected";                                     
                                        }
					echo "<option value='$cid->id' $sel>";
					echo "$cid->nome";
					echo "</option>";
				}
                            } ?>
                            
                        </select><br />
                        
                        Endere&ccedil;o: 
			<input type="text" name="endereco" value="<?= $obj->endereco ?>" maxlength="100" /><br />
                        Desativado
			<input type="text" name="desativado" value="<?= $obj->desativado ?>" maxlength="100" /><br />
                        Administrador que cadastrou:
                        <select name="id_administrador_cadastrou" maxlength="100" >
                            <? if($adms) {
				foreach($adms as $index => $adm) {
                                        $sel = "";
                                        if($obj->id_administrador_cadastrou==$adm->id){
                                               $sel = "selected";                                     
                                        }
					echo "<option value='$adm->id' $sel>";
					echo "$adm->nome";
					echo "</option>";
				}
                            } ?>
                            
                        </select>
			                       
			<input type="submit" value="<?= $obj->id ? "Modificar" : "Criar" ?>" />
		</form>
		<hr />
		<h2>Restaurantes Cadastrados</h2>
		<table>
			<tr>
				<th>Restaurante</th>
                                <th>Cidade</th>
                                <th>Endereco</th>
                                <th>Desativado</th>
                                <th>Administrador que cadastrou</th>
                                
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
                                                <td><?= $item->endereco ?></td>
                                                <td><?= $item->desativado ?></td>
                                                <td><?= $item->administrador->nome ?></td>
                                                
						<td><a href="?id=<?= $item->id ?>">Modificar</a></td>
						<td><a href="?id=<?= $item->id ?>&action=delete" onclick="return window.confirm('Confirmar exclusão?')">Excluir</a></td>
					</tr>
					<?
				}
			} else {
				?>
				<tr>
					<td colspan="7">Nenhum cliente cadastrado</td>
				</tr>
			<? } ?>
		</table>
	</body>
</html>