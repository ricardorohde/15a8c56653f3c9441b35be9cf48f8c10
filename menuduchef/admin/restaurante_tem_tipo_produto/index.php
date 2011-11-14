<?
include('../../include/header_admin.php');

$itens = RestauranteTemTipoProduto::all(array("order" => "restaurante_id asc"));
?>

<h2><a href="admin/area_administrativa">Menu Principal</a> &raquo; Gerenciar Restaurantes tem Tipos de Produto</h2>

<a href="admin/restaurante_tem_tipo_produto/form" title="Criar">Criar</a>
<br /><br />

<table class="list">
    <tr>
	<th>Restaurante</th>
	<th>Tipo de Produto</th>
	<th>Modificar</th>
	<th>Excluir</th>
    </tr>
    <?
    if ($itens) {
	foreach ($itens as $item) {
	    ?>
	    <tr>
		<td><?= $item->restaurante->nome ?></td>
		<td><?= $item->tipo_produto->nome ?></td>
                              
		<td><a href="admin/restaurante_tem_tipo_produto/form/<?= $item->id ?>">Modificar</a></td>
		<td><a href="admin/restaurante_tem_tipo_produto/controller?deleteId=<?= $item->id ?>" onclick="return window.confirm('Confirmar exclusão?')">Excluir</a></td>
	    </tr>
	    <?
	}
    } else {
	?>
    <tr>
	<td colspan="12">Nenhum restaurante tem tipo produto cadastrado</td>
    </tr>
    <? } ?>
</table>

<? include("../../include/footer_admin.php"); ?>