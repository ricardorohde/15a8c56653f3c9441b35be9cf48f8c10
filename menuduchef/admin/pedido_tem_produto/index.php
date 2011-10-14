<?
include("../../include/header.php");

$itens = PedidoTemProduto::all(array("order" => "id_pedido asc"));
?>

<h2>Gerenciar Produtos inclusos nos Pedidos</h2>

<a href="admin/" title="Menu principal">Menu principal</a>
<br /><br />

<a href="admin/pedido_tem_produto/form" title="Criar">Criar</a>
<br /><br />

<table>
    <tr>
	<th>Pedido</th>
	<th>Produto</th>
        <th>Quantidade</th>
        <th>OBS</th>
        <th>Tamanho</th>
        <th>Produto2</th>
	<th>Modificar</th>
	<th>Excluir</th>
    </tr>
    <?
    if ($itens) {
	foreach ($itens as $item) {
	    ?>
	    <tr>
		<td><?= $item->id_pedido." (".$item->pedido->restaurante->nome.", ".$item->pedido->consumidor->nome.")" ?></td>
		<td><?= $item->produto->nome ?></td>
                <td><?= $item->qtd ?></td>
                <td><?= $item->obs ?></td>
                <td><?= $item->tamanho ?></td>
                <td><?= $item->produto2->nome ?></td>
                              
		<td><a href="admin/pedido_tem_produto/form/<?= $item->id ?>">Modificar</a></td>
		<td><a href="admin/pedido_tem_produto/controller?deleteId=<?= $item->id ?>" onclick="return window.confirm('Confirmar exclusão?')">Excluir</a></td>
	    </tr>
	    <?
	}
    } else {
	?>
    <tr>
	<td colspan="12">Nenhum produto em pedido cadastrado</td>
    </tr>
    <? } ?>
</table>

<? include("../../include/footer.php"); ?>