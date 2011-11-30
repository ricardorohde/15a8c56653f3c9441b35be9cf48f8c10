<?
include('../../include/header_admin.php');

$itens = Cidade::all(array("order" => "nome asc"));
?>

<h2><a href="admin/area_administrativa">Menu Principal</a> &raquo; Gerenciar Cidades</h2>

<a href="admin/cidade/form" title="Criar">Criar</a>
<br /><br />

<table class="list">
    <tr>
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
		<td align="center"><a href="admin/cidade/form/<?= $item->id ?>">Modificar</a></td>
		<td align="center"><a href="admin/cidade/controller?deleteId=<?= $item->id ?>" onclick="return window.confirm('Confirmar exclusão?')">Excluir</a></td>
	    </tr>
	    <?
	}
    } else {
	?>
    <tr>
	<td colspan="3">Nenhuma cidade cadastrada</td>
    </tr>
    <? } ?>
</table>

<? include("../../include/footer_admin.php"); ?>