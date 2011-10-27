<?
include("../../include/header.php");

$itens = PedidoTemProdutoAdicional::all(array("order" => "pedidotemproduto_id asc", "conditions" => array("pedidotemproduto_id = ?",$_GET['prodnoped'])));
?>

<? include("../../include/painel_area_administrativa.php") ;?>

<h2><a href="admin/">Menu Principal</a> &raquo; <a href="admin/pedido">Gerenciar Pedidos</a> &raquo; <a href="admin/pedido_tem_produto/?ped=<?= $_GET['ped'] ?>">Gerenciar Produtos inclusos nos Pedidos</a> &raquo; Gerenciar Produtos Adicionais inclusos nos Pedidos</h2>

<a href="admin/pedido_tem_produto_adicional/form?prodnoped=<?= $_GET['prodnoped'] ?>&ped=<?= $_GET['ped'] ?>" title="Criar">Criar</a>
<br /><br />

<table class="list">
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
                              
		<td><a href="admin/pedido_tem_produto_adicional/form/?id=<?= $item->id ?>&prodnoped=<?= $item->pedidotemproduto_id ?>&ped=<?= $_GET['ped'] ?>">Modificar</a></td>
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