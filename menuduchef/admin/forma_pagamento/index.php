<?
include('../../include/header_admin.php');

$itens = FormaPagamento::all(array("order" => "nome asc"));
?>

<h2><a href="admin/area_administrativa">Menu Principal</a> &raquo; Gerenciar Formas de Pagamento</h2>

<a href="admin/forma_pagamento/form" title="Criar">Criar</a>
<br /><br />

<table class="list">
    <tr>
	<th>Nome</th>
	<th width="10%"></th>
	<th width="10%"></th>
    </tr>
    <?
    if ($itens) {
	foreach ($itens as $item) {
	    ?>
	    <tr>
		<td><?= $item->nome ?></td>
		<td align="center"><a href="admin/forma_pagamento/form/<?= $item->id ?>">Modificar</a></td>
		<td align="center"><a href="admin/forma_pagamento/controller?deleteId=<?= $item->id ?>" onclick="return window.confirm('Confirmar exclusão?')">Excluir</a></td>
	    </tr>
	    <?
	}
    } else {
	?>
    <tr>
	<td colspan="3">Nenhuma forma de pagamento cadastrada</td>
    </tr>
    <? } ?>
</table>

<? include("../../include/footer_admin.php"); ?>