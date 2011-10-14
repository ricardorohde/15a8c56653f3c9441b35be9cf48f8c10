<?
include("../../include/header.php");

$itens = Pedido::all(array("order" => "quando asc"));
?>

<h2>Gerenciar Pedidos</h2>

<a href="admin/" title="Menu principal">Menu principal</a>
<br /><br />

<a href="admin/pedido/form" title="Criar">Criar</a>
<br /><br />

<table>
    <tr>
	<th>Consumidor</th>
	<th>Restaurante</th>
        <th>Quando</th>
        <th>Pagamento Efetuado</th>
        <th>Forma de Pagamento</th>
        <th>Pre&ccedil;o</th>
        <th>Troco</th>
        <th>Cupom</th>
        <th>Endere&ccedil;o</th>
        <th>Situa&ccedil;&atilde;o</th>
	<th>Modificar</th>
	<th>Excluir</th>
    </tr>
    <?
    if ($itens) {
	foreach ($itens as $item) {
	    ?>
	    <tr>
		<td><?= $item->consumidor->nome ?></td>
		<td><?= $item->restaurante->nome ?></td>
		<td><?= $item->quando ?></td>
                <td><?= $item->pagamento_efetuado ?></td>
                <td><?= $item->forma_pagamento ?></td>
                <td><?= $item->preco ?></td>
                <td><?= $item->troco ?></td>
                <td><?= $item->cupom ?></td>
                <td><?= $item->endereco ?></td>
                <td><?= $item->situacao ?></td>
                              
		<td><a href="admin/pedido/form/<?= $item->id ?>">Modificar</a></td>
		<td><a href="admin/pedido/controller?deleteId=<?= $item->id ?>" onclick="return window.confirm('Confirmar exclusão?')">Excluir</a></td>
	    </tr>
	    <?
	}
    } else {
	?>
    <tr>
	<td colspan="12">Nenhum pedido cadastrado</td>
    </tr>
    <? } ?>
</table>

<? include("../../include/footer.php"); ?>
