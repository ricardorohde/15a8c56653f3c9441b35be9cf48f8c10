<?
include('../../include/header_admin.php');

$obj = HttpUtil::getActiveRecordObjectBySessionOrGetId("RestauranteAtendeBairro");

$restaurantes = Restaurante::all(array("order" => "nome asc"));
$bairros = Bairro::all(array("order" => "nome asc"));
?>

<h2><a href="admin/area_administrativa">Menu Principal</a> &raquo; Gerenciar Restaurantes atendem Bairros</h2>

<a href="admin/restaurante_atende_bairro/" title="Cancelar">Cancelar</a>

<form action="admin/restaurante_atende_bairro/controller" method="post">
    <input type="hidden" name="id" value="<?= $obj->id ?>" />
    
    <label class="normal">Restaurante:</label>
    <select class="formfield w40" name="restaurante_id">
	<option value="">-- Selecione --</option>
	<?
	if ($restaurantes) {
	    foreach ($restaurantes as $restaurante) {
		?>
		<option value="<?= $restaurante->id ?>" <? if ($restaurante->id == $obj->restaurante_id) { ?>selected="selected"<? } ?>><?= $restaurante->nome ?></option>
	    <? }
	} ?>
    </select>
    
    <label class="normal">Bairro:</label>
    <select class="formfield w40" name="bairro_id">
	<option value="">-- Selecione --</option>
	<?
	if ($bairros) {
	    foreach ($bairros as $bairro) {
		?>
		<option value="<?= $bairro->id ?>" <? if ($bairro->id == $obj->bairro_id) { ?>selected="selected"<? } ?>><?= $bairro->nome ?></option>
	    <? }
	} ?>
    </select>

    <label class="normal">Taxa de Entrega:</label>
    <input class="formfield w15" type="text" name="preco_entrega" value="<?= $obj->preco_entrega ?>" maxlength="100" />
        
    <input class="btn" type="submit" value="<?= $obj->id ? "Modificar" : "Criar" ?>" />
</form>

<? include("../../include/footer_admin.php"); ?>