<?
include("../../include/header.php");

$itens = Restaurante::all(array("order" => "nome asc"));
?>

<? include("../../include/painel_area_administrativa.php") ;?>

<h2><a href="admin/">Menu Principal</a> &raquo; Gerenciar Restaurantes</h2>

<a href="admin/restaurante/form" title="Criar">Criar</a>
<br /><br />

<table class="list">
    <tr>
	<th>Nome</th>
	<th>Cidade</th>
	<th>Administrador que cadastrou</th>
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
		<td><?= $item->administrador->nome ?></td>
		<td><a href="admin/restaurante/form/<?= $item->id ?>">Modificar</a></td>
		<td><a href="admin/restaurante/controller?deleteId=<?= $item->id ?>" onclick="return window.confirm('Confirmar exclusão?')">Excluir</a></td>
	    </tr>
	    <?
	}
    } else {
	?>
    <tr>
	<td colspan="3">Nenhum restaurante cadastrado</td>
    </tr>
    <? } ?>
</table>

<? include("../../include/footer.php"); ?>