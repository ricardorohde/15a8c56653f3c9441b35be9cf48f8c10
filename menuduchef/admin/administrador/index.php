<?
include('../../include/header_admin.php');

$itens = Administrador::all();
?>

<h2><a href="admin/area_administrativa">Menu Principal</a> &raquo; Gerenciar Administradores</h2>

<a href="admin/administrador/form" title="Criar">Criar</a>
<br /><br />

<table class="list">
    <tr>
	<th>Nome</th>
	<th>E-mail</th>
	<th width="10%"></th>
	<th width="10%"></th>
    </tr>
    <?
    if ($itens) {
	foreach ($itens as $item) {
	    ?>
	    <tr>
		<td><?= $item->nome ?></td>
		<td><?= $item->email ?></td>
		<td align="center"><a href="admin/administrador/form/<?= $item->id ?>">Modificar</a></td>
		<td align="center"><a href="admin/administrador/controller?deleteId=<?= $item->id ?>" onclick="return window.confirm('Confirmar exclusão?')">Excluir</a></td>
	    </tr>
	    <?
	}
    } else {
	?>
    <tr>
	<td colspan="5">Nenhum administrador cadastrado</td>
    </tr>
    <? } ?>
</table>

<? include("../../include/footer_admin.php"); ?>