<?
include('../../include/header_admin.php');

$itens = TipoProduto::all(array("order" => "nome asc"));
?>

<h2><a href="admin/area_administrativa">Menu Principal</a> &raquo; Gerenciar Tipos de Produto</h2>

<a href="admin/tipo_produto/form" title="Criar">Criar</a>
<br /><br />

<table class="list">
    <tr>
	<th>Nome</th>
	<th>Qtd. de Produtos</th>
	<th width="10%"></th>
	<th width="10%"></th>
    </tr>
    <?
    if ($itens) {
	foreach ($itens as $item) {
	    $qtdProdutos = ProdutoTemTipo::count(array("conditions" => array("tipoproduto_id = ?", $item->id)));
	    ?>
	    <tr>
		<td><?= $item->nome ?></td>
		<td><?= $qtdProdutos ?></td>
		<td align="center"><a href="admin/tipo_produto/form/<?= $item->id ?>">Modificar</a></td>
		<td align="center"><a href="admin/tipo_produto/controller?deleteId=<?= $item->id ?>" onclick="return window.confirm('Confirmar exclus�o?')">Excluir</a></td>
	    </tr>
	    <?
	}
    } else {
	?>
    <tr>
	<td colspan="3">Nenhum tipo de produto cadastrado</td>
    </tr>
    <? } ?>
</table>

<? include("../../include/footer_admin.php"); ?>