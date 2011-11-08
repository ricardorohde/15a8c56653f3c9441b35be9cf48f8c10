<?
include('../../include/header_admin.php');

$obj = HttpUtil::getActiveRecordObjectBySessionOrGetId("RestauranteTemTipoProduto");

$restaurantes = Restaurante::all(array("order" => "nome asc"));
$tipos = TipoProduto::all(array("order" => "nome asc"));
?>

<h2><a href="admin/">Menu Principal</a> &raquo; Gerenciar Restaurantes tem Tipos de Produto</h2>

<a href="admin/restaurante_tem_tipo_produto/" title="Cancelar">Cancelar</a>

<form action="admin/restaurante_tem_tipo_produto/controller" method="post">
    <input type="hidden" name="id" value="<?= $obj->id ?>" />
    
    <label class="normal">Restaurante:</label>
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

    <label class="normal">Tipo de Produto:</label>
    <select class="formfield w40" name="tipoproduto_id">
	<option value="">-- Selecione --</option>
	<?
	if ($tipos) {
	    foreach ($tipos as $tipo) {
		?>
		<option value="<?= $tipo->id ?>" <? if ($tipo->id == $obj->tipoproduto_id) { ?>selected="true"<? } ?>><?= $tipo->nome ?></option>
	    <? }
	} ?>
    </select>
    <br /><br />
        
    <input class="btn" type="submit" value="<?= $obj->id ? "Modificar" : "Criar" ?>" />
</form>

<? include("../../include/footer.php"); ?>