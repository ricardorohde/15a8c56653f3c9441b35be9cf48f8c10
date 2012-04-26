<?
include('../../include/header_admin.php');

$itens = LoteCupom::all(array("order" => "id asc"));
?>

<h2><a href="admin/area_administrativa">Menu Principal</a> &raquo; Gerenciar Lotes de Cupons</h2>

<a href="admin/lote_cupom/form" title="Criar">Criar</a>
<br /><br />

<table class="list">
    <tr>
        <th>Lote</th>
	<th>Validade</th>
	<th width="10%"></th>
	<th width="10%"></th>
    </tr>
    <?
    if ($itens) {
	foreach ($itens as $item) {
	    ?>
	    <tr>
		<td><?= $item->nome ?></td>
                <td><?= $item->validade->format("d/m/Y H:i:s") ?></td>
		<td align="center"><a href="admin/lote_cupom/form/<?= $item->id ?>">Modificar</a></td>
		<td align="center"><a href="admin/lote_cupom/controller?deleteId=<?= $item->id ?>" onclick="return window.confirm('Confirmar exclusão?')">Excluir</a></td>
	    </tr>
	    <?
	}
    } else {
	?>
    <tr>
	<td colspan="3">Nenhum lote cadastrado</td>
    </tr>
    <? } ?>
</table>

<? include("../../include/footer_admin.php"); ?>
