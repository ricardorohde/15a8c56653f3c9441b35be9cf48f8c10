<?
include('../../include/header_admin.php');

$itens = ProdutoTemProdutoAdicional::all(array("order" => "produto_id asc"));
?>

<h2><a href="admin/area_administrativa">Menu Principal</a> &raquo; Gerenciar Produtos Adicionais pertencentes aos Produtos</h2>

<a href="admin/produto_tem_produto_adicional/form" title="Criar">Criar</a>
<br /><br />

<table class="list">
    <tr>
	<th>Produto</th>
	<th>Produto Adicional</th>
	<th width="10%"></th>
	<th width="10%"></th>
    </tr>
    <?
    if ($itens) {
	foreach ($itens as $item) {
	    ?>
	    <tr>
		<td><?= $item->produto->nome ?></td>
		<td><?= $item->produto_adicional->nome ?></td>
                              
		<td align="center"><a href="admin/produto_tem_produto_adicional/form/<?= $item->id ?>">Modificar</a></td>
		<td align="center"><a href="admin/produto_tem_produto_adicional/controller?deleteId=<?= $item->id ?>" onclick="return window.confirm('Confirmar exclusão?')">Excluir</a></td>
	    </tr>
	    <?
	}
    } else {
	?>
    <tr>
	<td colspan="12">Nenhum produto adicional pertencente a um produto cadastrado</td>
    </tr>
    <? } ?>
</table>

<? include("../../include/footer_admin.php"); ?>