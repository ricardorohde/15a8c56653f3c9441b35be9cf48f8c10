<?
include("../../include/header.php");

$itens = TipoRestaurante::all(array("order" => "nome asc"));
?>

<? include("../../include/painel_area_administrativa.php") ;?>

<h2><a href="admin/">Menu Principal</a> &raquo; Gerenciar Tipos de Restaurante</h2>

<a href="admin/tipo_restaurante/form" title="Criar">Criar</a>
<br /><br />

<table class="list">
    <tr>
	<th>Nome</th>
	<th>Modificar</th>
	<th>Excluir</th>
    </tr>
    <?
    if ($itens) {
	foreach ($itens as $item) {
	    ?>
	    <tr>
		<td><?= $item->nome ?></td>
		<td><a href="admin/tipo_restaurante/form/<?= $item->id ?>">Modificar</a></td>
		<td><a href="admin/tipo_restaurante/controller?deleteId=<?= $item->id ?>" onclick="return window.confirm('Confirmar exclus�o?')">Excluir</a></td>
	    </tr>
	    <?
	}
    } else {
	?>
    <tr>
	<td colspan="3">Nenhum tipo de restaurante cadastrado</td>
    </tr>
    <? } ?>
</table>

<? include("../../include/footer.php"); ?>