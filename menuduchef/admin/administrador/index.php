<?
include("../../include/header.php");

$itens = Administrador::all(array("order" => "nome asc"));
?>

<? include("../../include/painel_area_administrativa.php") ;?>

<h2><a href="admin/">Menu Principal</a> &raquo; Gerenciar Administradores</h2>

<a href="admin/administrador/form" title="Criar">Criar</a>
<br /><br />

<table class="list">
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
		<td><a href="admin/administrador/controller?deleteId=<?= $item->id ?>" onclick="return window.confirm('Confirmar exclusão?')">Excluir</a></td>
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