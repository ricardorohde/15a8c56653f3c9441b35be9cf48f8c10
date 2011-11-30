<?
include('../../include/header_admin.php');

$itens = TipoRestaurante::all(array("order" => "nome asc"));
?>

<h2><a href="admin/area_administrativa">Menu Principal</a> &raquo; Gerenciar Tipos de Restaurante</h2>

<a href="admin/tipo_restaurante/form" title="Criar">Criar</a>
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
		<td align="center"><a href="admin/tipo_restaurante/form/<?= $item->id ?>">Modificar</a></td>
		<td align="center"><a href="admin/tipo_restaurante/controller?deleteId=<?= $item->id ?>" onclick="return window.confirm('Confirmar exclusão?')">Excluir</a></td>
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

<? include("../../include/footer_admin.php"); ?>