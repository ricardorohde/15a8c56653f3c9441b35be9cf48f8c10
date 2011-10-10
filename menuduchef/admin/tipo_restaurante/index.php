<?
include_once("../../php/lib/config.php");

$itens = TipoRestaurante::all(array("order" => "nome asc"));
?>

<? include("../../include/header.php"); ?>

<h2>Gerenciar Tipos de Restaurante</h2>

<a href="admin/" title="Menu principal">Menu principal</a>
<br /><br />

<a href="admin/tipo_restaurante/form" title="Criar">Criar</a>
<br /><br />

<table>
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
		<td><a href="admin/tipo_restaurante/controller?id=<?= $item->id ?>&action=delete" onclick="return window.confirm('Confirmar exclusão?')">Excluir</a></td>
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