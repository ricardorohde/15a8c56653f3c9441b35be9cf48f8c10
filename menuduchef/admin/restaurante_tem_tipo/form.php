<?
include('../../include/header_admin.php');

$obj = HttpUtil::getActiveRecordObjectBySessionOrGetId("RestauranteTemTipo");

$restaurantes = Restaurante::all(array("order" => "nome asc"));
$tipos = TipoRestaurante::all(array("order" => "nome asc"));
?>

<h2><a href="admin/area_administrativa">Menu Principal</a> &raquo; Gerenciar Restaurantes tem Tipos</h2>

<a href="admin/restaurante_tem_tipo/" title="Cancelar">Cancelar</a>

<form action="admin/restaurante_tem_tipo/controller" method="post">
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

    <label class="normal">Tipo:</label>
    <select class="formfield w40" name="tiporestaurante_id">
	<option value="">-- Selecione --</option>
	<?
	if ($tipos) {
	    foreach ($tipos as $tipo) {
		?>
		<option value="<?= $tipo->id ?>" <? if ($tipo->id == $obj->tiporestaurante_id) { ?>selected="selected"<? } ?>><?= $tipo->nome ?></option>
	    <? }
	} ?>
    </select>
        
    <input class="btn" type="submit" value="<?= $obj->id ? "Modificar" : "Criar" ?>" />
</form>

<? include("../../include/footer_admin.php"); ?>