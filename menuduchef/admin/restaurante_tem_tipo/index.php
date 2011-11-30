<?
include('../../include/header_admin.php');

$itens = RestauranteTemTipo::all(array("order" => "restaurante_id asc"));
?>

<h2><a href="admin/area_administrativa">Menu Principal</a> &raquo; Gerenciar Restaurantes tem Tipos</h2>

<a href="admin/restaurante_tem_tipo/form" title="Criar">Criar</a>
<br /><br />

<table class="list">
    <tr>
	<th>Restaurante</th>
	<th>Tipo</th>
	<th width="10%"></th>
	<th width="10%"></th>
    </tr>
    <?
    if ($itens) {
	foreach ($itens as $item) {
	    ?>
	    <tr>
		<td><?= $item->restaurante->nome ?></td>
		<td><?= $item->tipo_restaurante->nome ?></td>
                              
		<td align="center"><a href="admin/restaurante_tem_tipo/form/<?= $item->id ?>">Modificar</a></td>
		<td align="center"><a href="admin/restaurante_tem_tipo/controller?deleteId=<?= $item->id ?>" onclick="return window.confirm('Confirmar exclusão?')">Excluir</a></td>
	    </tr>
	    <?
	}
    } else {
	?>
    <tr>
	<td colspan="12">Nenhum restaurante tem tipo cadastrado</td>
    </tr>
    <? } ?>
</table>

<? include("../../include/footer_admin.php"); ?>