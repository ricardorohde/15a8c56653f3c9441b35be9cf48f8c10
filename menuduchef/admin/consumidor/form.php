<?
include_once("../../php/lib/config.php");

$obj = new Consumidor();

$cidades = Cidade::all(array("order" => "nome asc"));
if ($obj->bairro->cidade->id) {
    $idcid = $obj->bairro->cidade->id;
} else {
    $primeira_cidade = Cidade::all(array("order" => "nome asc", "limit" => 1));
    foreach ($primeira_cidade as $pc) {
	$idcid = $pc->id;
    }
}

$bairros = Bairro::all(array('conditions' => array('id_cidade = ?', $idcid)));

if ($_GET["id"]) {
    $obj = Consumidor::find($_GET["id"]);
}
?>

<? include("../../include/header.php"); ?>

<script>
    $(document).ready(function(){
	$('#cidades').change(function(){
	    $('#bairros').load('php/controller/combobox_bairros.php?cidade='+$('#cidades').val() );
	});
    });
</script>

<h2>Gerenciar Consumidores</h2>

<a href="admin/consumidor/" title="Cancelar">Cancelar</a>
<br /><br />

<form action="admin/consumidor/controller" method="post">
    <input type="hidden" name="action" value="<?= $obj->id ? "update" : "create" ?>" />
    <input type="hidden" name="id" value="<?= $obj->id ?>" />
    Nome<br />
    <input type="text" name="nome" value="<?= $obj->nome ?>" maxlength="100" /><br /><br />
    Endereço<br />
    <input type="text" name="endereco" value="<?= $obj->endereco ?>" maxlength="100" /><br /><br />
    Cidade<br />
    <select id="cidades" name="id_cidade" maxlength="100" >
	<?
	if ($cidades) {
	    foreach ($cidades as $index => $cid) {
		$sel = "";
		if ($obj->bairro->cidade->id == $cid->id) {
		    $sel = "selected";
		}
		echo "<option value='$cid->id' $sel>";
		echo "$cid->nome";
		echo "</option>";
	    }
	}
	?>
    </select>
    <br /><br />
    Bairro<br />
    <select id="bairros" name="id_bairro" maxlength="100" >
	<?
	if ($bairros) {
	    foreach ($bairros as $index => $bai) {
		$sel = "";
		if ($obj->id_bairro == $bai->id) {
		    $sel = "selected";
		}
		echo "<option value='$bai->id' $sel>";
		echo "$bai->nome";
		echo "</option>";
	    }
	}
	?>
    </select>
    <br /><br />
    Telefone<br />
    <input type="text" name="telefone" value="<?= $obj->telefone ?>" maxlength="100" /><br /><br />
    Ativo<br />
    <input type="radio" name="ativo" value="1" <? if (!$obj->id || $obj->ativo === 1) { ?>checked="true"<? } ?> />Sim
    <input type="radio" name="ativo" value="0" <? if ($obj->id && $obj->ativo === 0) { ?>checked="true"<? } ?> />Não
    <br /><br />
    Login<br />
    <input type="text" name="login" autocomplete="off" value="<?= $obj->login ?>" maxlength="100" /><br />
    Senha<br />
    <input type="password" name="senha" autocomplete="off" maxlength="100" /><br /><br />
    Repita a senha<br />
    <input type="password" name="senha_rep" autocomplete="off" maxlength="100" /><br /><br />
    <input type="submit" value="<?= $obj->id ? "Modificar" : "Criar" ?>" />
</form>

<? include("../../include/footer.php"); ?>