<?
include('../../include/header_admin.php');

$obj = HttpUtil::getActiveRecordObjectBySessionOrGetId("ProdutoAdicional");

$restaurantes = Restaurante::all(array("order" => "nome asc"));
?>

<h2><a href="admin/">Menu Principal</a> &raquo; Gerenciar Produtos Adicionais</h2>

<a href="admin/produto_adicional/" title="Cancelar">Cancelar</a>

<form action="admin/produto_adicional/controller" method="post">
    <input type="hidden" name="id" value="<?= $obj->id ?>" />
    
    <label class="normal">Nome:</label>
    <input class="formfield w50" type="text" name="nome" value="<?= $obj->nome ?>" maxlength="100" />
    
    <label class="normal">Restaurante:</label>
    
    <? if($obj->id) { ?>
	<label class="adjacent"><?= $obj->restaurante->nome ?></label>
    <? } else { ?>
    <select class="formfield w40" name="restaurante_id">
	<option value="">-- Selecione --</option>
	<?
	if ($restaurantes) {
	    foreach ($restaurantes as $restaurante) {
		?>
		<option value="<?= $restaurante->id ?>" <? if ($restaurante->id == $obj->restaurante_id) { ?>selected="true"<? } ?>><?= $restaurante->nome ?></option>
	    <? }
	} ?>
    </select>
    <? } ?>
	
    <label class="normal">Pre&ccedil;o Adicional:</label>
    <input class="formfield w15" type="text" name="preco_adicional" value="<?= $obj->preco_adicional ?>" maxlength="100" /><br /><br />
    
    <label class="normal">Ativo:</label>
    <input class="adjacent" id="ativo_sim" type="radio" name="ativo" value="1" <? if (!$obj->id || $obj->ativo === 1) { ?>checked="true"<? } ?> />
    <label class="adjacent" for="ativo_sim">Sim</label>
    <input class="adjacent" id="ativo_nao" type="radio" name="ativo" value="0" <? if ($obj->id && $obj->ativo === 0) { ?>checked="true"<? } ?> />
    <label class="adjacent" for="ativo_nao">Não</label>
    
    <label class="normal">Dispon&iacute;vel:</label>
    <input class="adjacent" id="disponivel_sim" type="radio" name="disponivel" value="1" <? if (!$obj->id || $obj->disponivel === 1) { ?>checked="true"<? } ?> />
    <label class="adjacent" for="disponivel_sim">Sim</label>
    <input class="adjacent" id="disponivel_nao" type="radio" name="disponivel" value="0" <? if ($obj->id && $obj->disponivel === 0) { ?>checked="true"<? } ?> />
    <label class="adjacent" for="disponivel_nao">Não</label>
    
    <label class="normal">Quantas Unidades Ocupa:</label>
    <input class="formfield w15" type="text" name="quantas_unidades_ocupa" value="<?= $obj->quantas_unidades_ocupa ?>" maxlength="100" /><br /><br />
    
    <input class="btn" type="submit" value="<?= $obj->id ? "Modificar" : "Criar" ?>" />
</form>

<? include("../../include/footer.php"); ?>