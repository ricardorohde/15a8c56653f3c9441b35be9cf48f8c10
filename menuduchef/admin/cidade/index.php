<?
include("../../include/header.php");

$itens = Cidade::all(array("order" => "nome asc"));
?>

<h2>Gerenciar Cidades</h2>

<a href="admin/" title="Menu principal">Menu principal</a>
<br /><br />

<a href="admin/cidade/form" title="Criar">Criar</a>
<br /><br />

<table>
    <tr>
	<th>Cidade</th>
	<th>Modificar</th>
	<th>Excluir</th>
    </tr>
    <?
    if ($itens) {
	foreach ($itens as $item) {
	    ?>
	    <tr>
		<td><?= $item->nome ?></td>
		<td><a href="admin/cidade/form/<?= $item->id ?>">Modificar</a></td>
		<td><a href="admin/cidade/controller?id=<?= $item->id ?>&action=delete" onclick="return window.confirm('Confirmar exclusão?')">Excluir</a></td>
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

<? include("../../include/footer.php"); ?>