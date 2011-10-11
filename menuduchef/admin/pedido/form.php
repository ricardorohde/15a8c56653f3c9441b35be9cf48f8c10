<?
include("../../include/header.php");

$obj = new Pedido();
$restaurantes = Restaurante::all(array("order" => "nome asc"));
$consumidores = Consumidor::all(array("order" => "nome asc"));


if ($_GET["id"]) {
    $obj = Pedido::find($_GET["id"]);
}
?>

<h2>Gerenciar Pedidos</h2>

<a href="admin/pedido/" title="Cancelar">Cancelar</a>
<br /><br />

<form action="admin/pedido/controller" method="post">
    <input type="hidden" name="action" value="<?= $obj->id ? "update" : "create" ?>" />
    <input type="hidden" name="id" value="<?= $obj->id ?>" />
    Consumidor<br />
    <select name="id_consumidor">-- Selecione --</option>
	<?
	if ($consumidores) {
	    foreach ($consumidores as $consumidor) {
		?>
		<option value="<?= $consumidor->id ?>" <? if ($consumidor->id == $obj->id_consumidor) { ?>selected="true"<? } ?>><?= $consumidor->nome ?></option>
	    <? }
	} ?>
    </select>
    <br /><br />
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
    Pagamento Efetuado<br />
    <input type="radio" name="pagamento_efetuado" value="1" <? if (!$obj->id || $obj->pagamento_efetuado === 1) { ?>checked="true"<? } ?> />Sim
    <input type="radio" name="pagamento_efetuado" value="0" <? if ($obj->id && $obj->pagamento_efetuado === 0) { ?>checked="true"<? } ?> />Não
    <br /><br />
    Forma de Pagamento<br />
    <input type="text" name="forma_pagamento" value="<?= $obj->forma_pagamento ?>" maxlength="100" /><br /><br />
    Pre&ccedil;o<br />
    <input type="text" name="preco" value="<?= $obj->preco ?>" maxlength="100" /><br /><br />
    Troco<br />
    <input type="text" name="troco" value="<?= $obj->troco ?>" maxlength="100" /><br /><br />
    Cupom<br />
    <input type="text" name="cupom" value="<?= $obj->cupom ?>" maxlength="100" /><br /><br />
    Endere&ccedil;o<br />
    <input type="text" name="endereco" value="<?= $obj->endereco ?>" maxlength="100" /><br /><br />
    Situa&ccedil;&atilde;o<br />
    <input type="text" name="situacao" value="<?= $obj->situacao ?>" maxlength="100" /><br /><br />
    
    <input type="submit" value="<?= $obj->id ? "Modificar" : "Criar" ?>" />
</form>

<? include("../../include/footer.php"); ?>