<?
include("../../include/header.php");

$itens = PedidoTemProdutoAdicional::all(array("order" => "pedidotemproduto_id asc"));
?>

<h2>Gerenciar Produtos Adicionais inclusos nos Pedidos</h2>

<a href="admin/" title="Menu principal">Menu principal</a>
<br /><br />

<a href="admin/pedido_tem_produto_adicional/form" title="Criar">Criar</a>
<br /><br />

<table>
    <tr>
	<th>Produto contido no Pedido</th>
	<th>Produto Adicional</th>
	<th>Modificar</th>
	<th>Excluir</th>
    </tr>
    <?
    if ($itens) {
	foreach ($itens as $item) {
	    ?>
	    <tr>
		<td><?= $item->pedidotemproduto_id." (".$item->pedido_tem_produto->produto->nome.")"; ?></td>
		<td><?= $item->produto_adicional->nome ?></td>
                              
		<td><a href="admin/pedido_tem_produto_adicional/form/<?= $item->id ?>">Modificar</a></td>
		<td><a href="admin/pedido_tem_produto_adicional/controller?deleteId=<?= $item->id ?>" onclick="return window.confirm('Confirmar exclusão?')">Excluir</a></td>
	    </tr>
	    <?
	}
    } else {
	?>
    <tr>
	<td colspan="12">Nenhum produto adicional em pedido cadastrado</td>
    </tr>
    <? } ?>
</table>

<? include("../../include/footer.php"); ?>