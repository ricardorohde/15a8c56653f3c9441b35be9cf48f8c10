<?
include("../../include/header.php");

$itens = ProdutoTemTipo::all(array("order" => "produto_id asc"));
?>

<h2>Gerenciar Produtos tem Tipos</h2>

<a href="admin/" title="Menu principal">Menu principal</a>
<br /><br />

<a href="admin/produto_tem_tipo/form" title="Criar">Criar</a>
<br /><br />

<table>
    <tr>
	<th>Produto</th>
	<th>Tipo</th>
	<th>Modificar</th>
	<th>Excluir</th>
    </tr>
    <?
    if ($itens) {
	foreach ($itens as $item) {
	    ?>
	    <tr>
		<td><?= $item->produto->nome ?></td>
		<td><?= $item->tipo_produto->nome ?></td>
                              
		<td><a href="admin/produto_tem_tipo/form/<?= $item->id ?>">Modificar</a></td>
		<td><a href="admin/produto_tem_tipo/controller?deleteId=<?= $item->id ?>" onclick="return window.confirm('Confirmar exclusão?')">Excluir</a></td>
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

<? include("../../include/footer.php"); ?>