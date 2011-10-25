<?
include("../../include/header.php");

$itens = UsuarioRestaurante::all(array("order" => "nome asc"));
?>

<? include("../../include/painel_area_administrativa.php") ;?>

<h2><a href="admin/">Menu Principal</a> &raquo; Gerenciar Gerentes e Atendentes de Restaurantes</h2>

<a href="admin/usuario_restaurante/form" title="Criar">Criar</a>
<br /><br />

<table class="list">
    <tr>
	<th>Nome</th>
	<th>Restaurante</th>
	<th>Login</th>
	<th>Perfil</th>
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
                <td><?= $item->getNomePerfil() ?></td>
		<td><a href="admin/usuario_restaurante/form/<?= $item->id ?>">Modificar</a></td>
		<td><a href="admin/usuario_restaurante/controller?deleteId=<?= $item->id ?>" onclick="return window.confirm('Confirmar exclusão?')">Excluir</a></td>
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