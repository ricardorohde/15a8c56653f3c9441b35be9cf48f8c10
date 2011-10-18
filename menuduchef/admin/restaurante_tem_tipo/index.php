<?
include_once("../../php/lib/config.php");

$itens = RestauranteTemTipo::all(array("order" => "restaurante_id asc"));
?>

<? include("../../include/header.php"); ?>

<h2>Gerenciar Restaurantes tem Tipos</h2>

<a href="admin/" title="Menu principal">Menu principal</a>
<br /><br />

<a href="admin/restaurante_tem_tipo/form" title="Criar">Criar</a>
<br /><br />

<table>
    <tr>
	<th>Restaurante</th>
	<th>Tipo</th>
	<th>Modificar</th>
	<th>Excluir</th>
    </tr>
    <?
    if ($itens) {
	foreach ($itens as $item) {
	    ?>
	    <tr>
		<td><?= $item->restaurante->nome ?></td>
		<td><?= $item->tipo_restaurante->nome ?></td>
                              
		<td><a href="admin/restaurante_tem_tipo/form/<?= $item->id ?>">Modificar</a></td>
		<td><a href="admin/restaurante_tem_tipo/controller?deleteId=<?= $item->id ?>" onclick="return window.confirm('Confirmar exclusão?')">Excluir</a></td>
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

<? include("../../include/footer.php"); ?>