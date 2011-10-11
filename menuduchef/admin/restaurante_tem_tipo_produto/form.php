<?
include("../../include/header.php");

$obj = new RestauranteTemTipoProduto();
$restaurantes = Restaurante::all(array("order" => "nome asc"));
$tipos = TipoProduto::all(array("order" => "nome asc"));


if ($_GET["id"]) {
    $obj = RestauranteTemTipoProduto::find($_GET["id"]);
}
?>


<h2>Gerenciar Restaurantes tem Tipos de Produto</h2>

<a href="admin/restaurante_tem_tipo_produto/" title="Cancelar">Cancelar</a>
<br /><br />

<form action="admin/restaurante_tem_tipo_produto/controller" method="post">
    <input type="hidden" name="action" value="<?= $obj->id ? "update" : "create" ?>" />
    <input type="hidden" name="id" value="<?= $obj->id ?>" />
    Restaurante<br />
    <select name="id_restaurante">-- Selecione --</option>
	<?
	if ($restaurantes) {
	    foreach ($restaurantes as $restaurante) {
		?>
		<option value="<?= $restaurante->id ?>" <? if ($restaurante->id == $obj->id_restaurante) { ?>selected="true"<? } ?>><?= $restaurante->nome ?></option>
	    <? }
	} ?>
    </select>
    <br /><br />
    Tipo de Produto<br />
    <select name="id_tipo">-- Selecione --</option>
	<?
	if ($tipos) {
	    foreach ($tipos as $tipo) {
		?>
		<option value="<?= $tipo->id ?>" <? if ($tipo->id == $obj->id_tipo) { ?>selected="true"<? } ?>><?= $tipo->nome ?></option>
	    <? }
	} ?>
    </select>
    <br /><br />
        
    <input type="submit" value="<?= $obj->id ? "Modificar" : "Criar" ?>" />
</form>

<? include("../../include/footer.php"); ?>