<?
include_once("../../php/lib/config.php");

$itens = Administrador::all(array("order" => "nome asc"));
?>

<? include("../../include/header.php"); ?>

<h2>Gerenciar Administradores</h2>

<a href="admin/" title="Menu principal">Menu principal</a>
<br /><br />

<a href="admin/administrador/form" title="Criar">Criar</a>
<br /><br />

<table>
    <tr>
	<th>Nome</th>
	<th>Login</th>
	<th>Modificar</th>
	<th>Excluir</th>
    </tr>
    <?
    if ($itens) {
	foreach ($itens as $item) {
	    ?>
	    <tr>
		<td><?= $item->nome ?></td>
		<td><?= $item->login ?></td>
		<td><a href="admin/administrador/form/<?= $item->id ?>">Modificar</a></td>
		<td><a href="admin/administrador/controller?id=<?= $item->id ?>&action=delete" onclick="return window.confirm('Confirmar exclus�o?')">Excluir</a></td>
	    </tr>
	    <?
	}
    } else {
	?>
    <tr>
	<td colspan="3">Nenhum administrador cadastrado</td>
    </tr>
    <? } ?>
</table>

<? include("../../include/footer.php"); ?>