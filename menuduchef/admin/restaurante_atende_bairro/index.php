<?
include("../../include/header.php");

$itens = RestauranteAtendeBairro::all(array("order" => "restaurante_id asc"));
?>

<? include("../../include/painel_area_administrativa.php") ;?>

<h2><a href="admin/">Menu Principal</a> &raquo; Gerenciar Restaurantes atendem Bairros</h2>

<a href="admin/restaurante_atende_bairro/form" title="Criar">Criar</a>
<br /><br />

<table class="list">
    <tr>
	<th>Restaurante</th>
	<th>Bairro</th>
        <th>Taxa de Entrega</th>
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
                <td><?= $item->preco_entrega ?></td>       
		<td><a href="admin/restaurante_atende_bairro/form/<?= $item->id ?>">Modificar</a></td>
		<td><a href="admin/restaurante_atende_bairro/controller?deleteId=<?= $item->id ?>" onclick="return window.confirm('Confirmar exclusão?')">Excluir</a></td>
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