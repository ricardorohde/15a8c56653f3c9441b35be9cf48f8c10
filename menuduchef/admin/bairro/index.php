<?
include('../../include/header_admin.php');

$itens = Bairro::all();
?>

<h2><a href="admin/area_administrativa">Menu Principal</a> &raquo; Gerenciar Bairros</h2>

<a href="admin/bairro/form" title="Criar">Criar</a>
<br /><br />

<table class="list">
    <tr>
	<th>Bairro</th>
	<th>Cidade</th>
	<th width="10%"></th>
	<th width="10%"></th>
    </tr>
    <?
    if ($itens) {
	foreach ($itens as $item) {
	    ?>
	    <tr>
		<td><?= $item->nome ?></td>
		<td><?= $item->cidade->nome ?></td>
		<td align="center"><a href="admin/bairro/form/<?= $item->id ?>">Modificar</a></td>
		<td align="center"><a href="admin/bairro/controller?deleteId=<?= $item->id ?>" onclick="return window.confirm('Confirmar exclusão?')">Excluir</a></td>
	    </tr>
	    <?
	}
    } else {
	?>
    <tr>
	<td colspan="3">Nenhum bairro cadastrado</td>
    </tr>
    <? } ?>
</table>

<? include("../../include/footer_admin.php"); ?>