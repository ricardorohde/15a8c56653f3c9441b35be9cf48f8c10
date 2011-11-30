<?
include('../../include/header_admin.php');

$itens = UsuarioRestaurante::all();
?>

<h2><a href="admin/area_administrativa">Menu Principal</a> &raquo; Gerenciar Gerentes e Atendentes de Restaurantes</h2>

<a href="admin/usuario_restaurante/form" title="Criar">Criar</a>
<br /><br />

<table class="list">
    <tr>
	<th>Nome</th>
	<th>Restaurante</th>
	<th>E-mail</th>
	<th>Perfil</th>
        <th width="10%"></th>
	<th width="10%"></th>
    </tr>
    <?
    if ($itens) {
	foreach ($itens as $item) {
	    ?>
	    <tr>
		<td><?= $item->nome ?></td>
		<td><?= $item->restaurante->nome ?></td>
		<td><?= $item->email ?></td>
                <td><?= $item->usuario->getNomePerfil() ?></td>
		<td align="center"><a href="admin/usuario_restaurante/form/<?= $item->id ?>">Modificar</a></td>
		<td align="center"><a href="admin/usuario_restaurante/controller?deleteId=<?= $item->id ?>" onclick="return window.confirm('Confirmar exclusão?')">Excluir</a></td>
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

<? include("../../include/footer_admin.php"); ?>