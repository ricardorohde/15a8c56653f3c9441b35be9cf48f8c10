<?php

require("../php/lib/config.php");

$obj = new Consumidor();

$data = $_POST ? $_POST : ($_GET ? $_GET : 0);
$msgError = "";

if($data) {
        $id = array_key_exists("id", $data) ? $data["id"] : 0;
        $action = array_key_exists("action", $data) ? $data["action"] : 0;
        $antiga_senha = array_key_exists("antiga_senha", $data) ? $data["antiga_senha"] : 0;
        $nova_senha = array_key_exists("senha", $data) ? $data["senha"] : 0;
        unset($data["action"]);
        unset($data["antiga_senha"]);
        unset($data["id_cidade"]);
    
        if($id) {
		$obj = Consumidor::find($id);
	}
        
        if($action) {
                switch($action) {
                        case "create":
                                if($nova_senha!=$antiga_senha){
                                    $data["senha"] = md5($nova_senha);
                                }
				$obj = new Consumidor($data);
				$obj->save();
				break;

			case "update":
                                if($nova_senha!=$antiga_senha){
                                    $data["senha"] = md5($nova_senha);
                                }
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


$cidades = Cidade::all(array("order" => "nome asc"));
if($obj->bairro->cidade->id){
    $idcid = $obj->bairro->cidade->id;
} 
else {
    $primeira_cidade = Cidade::all(array("order" => "nome asc","limit" => 1));
    foreach($primeira_cidade as $pc) {   
            $idcid = $pc->id;
    }
}

$bairros = Bairro::all(array('conditions' => array('id_cidade = ?', $idcid)));

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

		<h2>Gerenciar Consumidores</h2>
		<form action="" method="post">
			<input type="hidden" name="action" value="<?= $obj->id ? "update" : "create" ?>" />
			<input type="hidden" name="id" value="<?= $obj->id ?>" />
                        <input type="hidden" name="antiga_senha" value="<?= $obj->senha ?>" />
			Nome: 
			<input type="text" name="nome" value="<?= $obj->nome ?>" maxlength="100" /><br />
                        Cidade: 
			<select id="cidades" name="id_cidade" maxlength="100" >
                            <? if($cidades) {
				foreach($cidades as $index => $cid) {
                                        $sel = "";
                                        if($obj->bairro->cidade->id==$cid->id){
                                               $sel = "selected";                                     
                                        }
					echo "<option value='$cid->id' $sel>";
					echo "$cid->nome";
					echo "</option>";
				}
                            } ?>
                            
                        </select><br />
                        Bairro: 
			<select id="bairros" name="id_bairro" maxlength="100" >
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
                        Endere&ccedil;o: 
			<input type="text" name="endereco" value="<?= $obj->endereco ?>" maxlength="100" /><br />
                        Telefone: 
			<input type="text" name="telefone" value="<?= $obj->telefone ?>" maxlength="100" /><br />
                        Desativado: 
			<input type="text" name="desativado" value="<?= $obj->desativado ?>" maxlength="100" /><br />
                        Login: 
			<input type="text" name="login" value="<?= $obj->login ?>" maxlength="100" /><br />
                        Senha: 
			<input type="text" name="senha" value="<?= $obj->senha ?>" maxlength="100" /><br />
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
                                                <td><?= $item->bairro->cidade->nome ?></td>
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