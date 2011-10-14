<?
include("../../include/header.php");

$obj = HttpUtil::getActiveRecordObjectBySessionOrGetId("PedidoTemProdutoAdicional");

$pedido_tem_produtos = PedidoTemProduto::all(array("order" => "id asc"));
$produtos_adicionais = ProdutoAdicional::all(array("order" => "nome asc"));
?>

<h2>Gerenciar Produtos Adicionais inclusos nos Pedidos</h2>

<a href="admin/pedido_tem_produto_adicional/" title="Cancelar">Cancelar</a>
<br /><br />

<form action="admin/pedido_tem_produto_adicional/controller" method="post">
    <input type="hidden" name="action" value="<?= $obj->id ? "update" : "create" ?>" />
    <input type="hidden" name="id" value="<?= $obj->id ?>" />
    Pedido tem Produto<br />
    <select name="id_pedido_tem_produto">-- Selecione --</option>
	<?
	if ($pedido_tem_produtos) {
	    foreach ($pedido_tem_produtos as $pp) {
		?>
		<option value="<?= $pp->id ?>" <? if ($pp->id == $obj->id_pedido_tem_produto) { ?>selected="true"<? } ?>><?= $pp->id." (".$pp->produto->nome.")" ?></option>
	    <? }
	} ?>
    </select>
    <br /><br />
    Produto Adicional<br />
    <select name="id_produto_adicional">-- Selecione --</option>
	<?
	if ($produtos_adicionais) {
	    foreach ($produtos_adicionais as $produto_adicional) {
		?>
		<option value="<?= $produto_adicional->id ?>" <? if ($produto_adicional->id == $obj->id_produto_adicional) { ?>selected="true"<? } ?>><?= $produto_adicional->nome ?></option>
	    <? }
	} ?>
    </select>
    <br /><br />
    
    <input type="submit" value="<?= $obj->id ? "Modificar" : "Criar" ?>" />
</form>

<? include("../../include/footer.php"); ?>