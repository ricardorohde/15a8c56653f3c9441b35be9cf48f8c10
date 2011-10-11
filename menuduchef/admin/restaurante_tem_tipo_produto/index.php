<?
include_once("../../php/lib/config.php");

$itens = RestauranteTemTipoProduto::all(array("order" => "id_restaurante asc"));
?>

<? include("../../include/header.php"); ?>

<h2>Gerenciar Restaurantes tem Tipos de Produto</h2>

<a href="admin/" title="Menu principal">Menu principal</a>
<br /><br />

<a href="admin/restaurante_tem_tipo_produto/form" title="Criar">Criar</a>
<br /><br />

<table>
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
		<td><a href="admin/restaurante_tem_tipo_produto/controller?id=<?= $item->id ?>&action=delete" onclick="return window.confirm('Confirmar exclusão?')">Excluir</a></td>
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

<? include("../../include/footer.php"); ?>