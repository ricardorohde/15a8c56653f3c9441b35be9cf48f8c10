<?
include("../../include/header.php");

$itens = UsuarioRestaurante::all(array("order" => "nome asc"));
?>

<h2>Gerenciar Usu&aacute;rios de Restaurantes</h2>

<a href="admin/" title="Menu principal">Menu principal</a>
<br /><br />

<a href="admin/usuario_restaurante/form" title="Criar">Criar</a>
<br /><br />

<table>
    <tr>
	<th>Nome</th>
	<th>Restaurante</th>
	<th>Login</th>
	<th>Senha</th>
	<th>Superior</th>
        <th>Modificar</th>
	<th>Excluir</th>
    </tr>
    <?
    if ($itens) {
	foreach ($itens as $item) {
	    ?>
	    <tr>
		<td><?= $item->nome ?></td>
		<td><?= $item->restaurante->nome ?></td>
		<td><?= $item->login ?></td>
                <td><?= $item->senha ?></td>
                <td><?= $item->superior ?></td>
		<td><a href="admin/usuario_restaurante/form/<?= $item->id ?>">Modificar</a></td>
		<td><a href="admin/usuario_restaurante/controller?id=<?= $item->id ?>&action=delete" onclick="return window.confirm('Confirmar exclusão?')">Excluir</a></td>
	    </tr>
	    <?
	}
    } else {
	?>
    <tr>
	<td colspan="7">Nenhum usu&aacute;rio de restaurante cadastrado</td>
    </tr>
    <? } ?>
</table>

<? include("../../include/footer.php"); ?>