<?
include("../../include/header.php");

$obj = HttpUtil::getActiveRecordObjectBySessionOrGetId("RestauranteTemTipoProduto");

$restaurantes = Restaurante::all(array("order" => "nome asc"));
$tipos = TipoProduto::all(array("order" => "nome asc"));
?>


<h2>Gerenciar Restaurantes tem Tipos de Produto</h2>

<a href="admin/restaurante_tem_tipo_produto/" title="Cancelar">Cancelar</a>
<br /><br />

<form action="admin/restaurante_tem_tipo_produto/controller" method="post">
    <input type="hidden" name="id" value="<?= $obj->id ?>" />
    Restaurante<br />
    <select name="restaurante_id">-- Selecione --</option>
	<?
	if ($restaurantes) {
	    foreach ($restaurantes as $restaurante) {
		?>
		<option value="<?= $restaurante->id ?>" <? if ($restaurante->id == $obj->restaurante_id) { ?>selected="true"<? } ?>><?= $restaurante->nome ?></option>
	    <? }
	} ?>
    </select>
    <br /><br />
    Tipo de Produto<br />
    <select name="tipo_id">-- Selecione --</option>
	<?
	if ($tipos) {
	    foreach ($tipos as $tipo) {
		?>
		<option value="<?= $tipo->id ?>" <? if ($tipo->id == $obj->tipo_id) { ?>selected="true"<? } ?>><?= $tipo->nome ?></option>
	    <? }
	} ?>
    </select>
    <br /><br />
        
    <input type="submit" value="<?= $obj->id ? "Modificar" : "Criar" ?>" />
</form>

<? include("../../include/footer.php"); ?>