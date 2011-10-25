<?
include("../../include/header.php");

$itens = Bairro::all(array("order" => "nome asc"));
?>

<? include("../../include/painel_area_administrativa.php") ;?>

<h2><a href="admin/">Menu Principal</a> &raquo; Gerenciar Bairros</h2>

<a href="admin/bairro/form" title="Criar">Criar</a>
<br /><br />

<table class="list">
    <tr>
	<th>Bairro</th>
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
		<td><?= $item->cidade->nome ?></td>
		<td><a href="admin/bairro/form/<?= $item->id ?>">Modificar</a></td>
		<td><a href="admin/bairro/controller?deleteId=<?= $item->id ?>" onclick="return window.confirm('Confirmar exclusão?')">Excluir</a></td>
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

<? include("../../include/footer.php"); ?>