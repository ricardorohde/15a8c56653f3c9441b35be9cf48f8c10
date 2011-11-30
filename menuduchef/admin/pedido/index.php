<?
include('../../include/header_admin.php');

$itens = Pedido::all(array("order" => "quando asc"));
?>

<h2><a href="admin/area_administrativa">Menu Principal</a> &raquo; Gerenciar Pedidos</h2>

<a href="admin/pedido/form" title="Criar">Criar</a>
<br /><br />

<table class="list w100">
    <tr>
	<th>Consumidor</th>
	<th>Restaurante</th>
        <th>Quando</th>
        <th>Pre&ccedil;o</th>
        <th>Endere&ccedil;o</th>
        <th>Situa&ccedil;&atilde;o</th>
	<th width="10%"></th>
	<th width="10%"></th>
    </tr>
    <?
    if ($itens) {
	foreach ($itens as $item) {
	    ?>
	    <tr>
		<td><?= $item->consumidor->nome ?></td>
		<td><?= $item->restaurante->nome ?></td>
		<td><?= $item->quando->format('H:i:s m/d/Y') ?></td>
                <td><?= $item->getTotal() ?></td>
                <td><?= $item->endereco ?></td>
                <td><?= $item->situacao ?></td>
                              
		<td align="center"><a href="admin/pedido/form/<?= $item->id ?>">Modificar</a></td>
		<td align="center"><a href="admin/pedido/controller?deleteId=<?= $item->id ?>" onclick="return window.confirm('Confirmar exclusão?')">Excluir</a></td>
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

<? include("../../include/footer_admin.php"); ?>