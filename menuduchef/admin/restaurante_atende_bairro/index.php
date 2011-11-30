<?
include('../../include/header_admin.php');

$itens = RestauranteAtendeBairro::all(array("order" => "restaurante_id asc"));
?>

<h2><a href="admin/area_administrativa">Menu Principal</a> &raquo; Gerenciar Restaurantes atendem Bairros</h2>

<a href="admin/restaurante_atende_bairro/form" title="Criar">Criar</a>
<br /><br />

<table class="list">
    <tr>
	<th>Restaurante</th>
	<th>Bairro</th>
        <th>Taxa de Entrega</th>
	<th width="10%"></th>
	<th width="10%"></th>
    </tr>
    <?
    if ($itens) {
	foreach ($itens as $item) {
	    ?>
	    <tr>
		<td><?= $item->restaurante->nome ?></td>
		<td><?= $item->bairro->nome ?></td>
                <td><?= $item->preco_entrega ?></td>       
		<td align="center"><a href="admin/restaurante_atende_bairro/form/<?= $item->id ?>">Modificar</a></td>
		<td align="center"><a href="admin/restaurante_atende_bairro/controller?deleteId=<?= $item->id ?>" onclick="return window.confirm('Confirmar exclusão?')">Excluir</a></td>
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

<? include("../../include/footer_admin.php"); ?>