<?
include_once("../../php/lib/config.php");

$itens = RestauranteAtendeBairro::all(array("order" => "id_restaurante asc"));
?>

<? include("../../include/header.php"); ?>

<h2>Gerenciar Restaurantes atende Bairros</h2>

<a href="admin/" title="Menu principal">Menu principal</a>
<br /><br />

<a href="admin/restaurante_atende_bairro/form" title="Criar">Criar</a>
<br /><br />

<table>
    <tr>
	<th>Restaurante</th>
	<th>Bairro</th>
	<th>Modificar</th>
	<th>Excluir</th>
    </tr>
    <?
    if ($itens) {
	foreach ($itens as $item) {
	    ?>
	    <tr>
		<td><?= $item->restaurante->nome ?></td>
		<td><?= $item->bairro->nome ?></td>
                              
		<td><a href="admin/restaurante_atende_bairro/form/<?= $item->id ?>">Modificar</a></td>
		<td><a href="admin/restaurante_atende_bairro/controller?id=<?= $item->id ?>&action=delete" onclick="return window.confirm('Confirmar exclusão?')">Excluir</a></td>
	    </tr>
	    <?
	}
    } else {
	?>
    <tr>
	<td colspan="12">Nenhum restaurante atende bairro cadastrado</td>
    </tr>
    <? } ?>
</table>

<? include("../../include/footer.php"); ?>