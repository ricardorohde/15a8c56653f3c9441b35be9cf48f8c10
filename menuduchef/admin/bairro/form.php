<?
include('../../include/header_admin.php');

$obj = HttpUtil::getActiveRecordObjectBySessionOrGetId("Bairro");

$cidades = Cidade::all(array("order" => "nome asc"));
?>

<h2><a href="admin/">Menu Principal</a> &raquo; Gerenciar Bairros</h2>

<a href="admin/bairro/" title="Cancelar">Cancelar</a>

<form action="admin/bairro/controller" method="post">
    <input type="hidden" name="id" value="<?= $obj->id ?>" />
    
    <label class="normal">Nome:</label>
    <input class="formfield w50" type="text" name="nome" value="<?= $obj->nome ?>" maxlength="100" />

    <label class="normal">Cidade:</label>
    <? if ($obj->id) { ?>
    <label class="adjacent"><?= $obj->cidade->nome ?></label>
    <? } else { ?>
        <select class="formfield w40" name="cidade_id">
	    <option value="">-- Selecione --</option>
	    <?
	    if ($cidades) {
		foreach ($cidades as $cidade) {
		    ?>
	    	<option value="<?= $cidade->id ?>" <? if ($cidade->id == $obj->cidade_id) { ?>selected="true"<? } ?>><?= $cidade->nome ?></option>
		<? }
	    } ?>
        </select>
    <? } ?>
    
    <input class="btn" type="submit" value="<?= $obj->id ? "Modificar" : "Criar" ?>" />
</form>

<? include("../../include/footer_admin.php"); ?>