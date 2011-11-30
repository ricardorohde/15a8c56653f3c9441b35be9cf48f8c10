<?
include('../../include/header_admin.php');

$itens = ProdutoTemTipo::all(array("order" => "produto_id asc"));
?>

<h2><a href="admin/area_administrativa">Menu Principal</a> &raquo; Gerenciar Produtos tem Tipos</h2>

<a href="admin/produto_tem_tipo/form" title="Criar">Criar</a>
<br /><br />

<table class="list">
    <tr>
	<th>Produto</th>
	<th>Tipo</th>
	<th width="10%"></th>
	<th width="10%"></th>
    </tr>
    <?
    if ($itens) {
	foreach ($itens as $item) {
	    ?>
	    <tr>
		<td><?= $item->produto->nome ?></td>
		<td><?= $item->tipo_produto->nome ?></td>
                              
		<td align="center"><a href="admin/produto_tem_tipo/form/<?= $item->id ?>">Modificar</a></td>
		<td align="center"><a href="admin/produto_tem_tipo/controller?deleteId=<?= $item->id ?>" onclick="return window.confirm('Confirmar exclusão?')">Excluir</a></td>
	    </tr>
	    <?
	}
    } else {
	?>
    <tr>
	<td colspan="12">Nenhum produto tem tipo cadastrado</td>
    </tr>
    <? } ?>
</table>

<? include("../../include/footer_admin.php"); ?>