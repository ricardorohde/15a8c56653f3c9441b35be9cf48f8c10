<?
include("../../include/header.php");

$itens = Produto::all(array("order" => "nome asc"));
?>

<h2>Gerenciar Produtos</h2>

<a href="admin/" title="Menu principal">Menu principal</a>
<br /><br />

<a href="admin/produto/form" title="Criar">Criar</a>
<br /><br />

<table>
    <tr>
	<th>Nome</th>
	<th>Restaurante</th>
        <th>Pre&ccedil;o</th>
        <th>Ativo</th>
        <th>Dispon&iacute;vel</th>
        <th>Est&aacute; em Promo&ccedil;&atilde;o</th>
        <th>Pre&ccedil;o Promocional</th>
        <th>Descri&ccedil;&atilde;o</th>
        <th>Quantidade de Produto Adicional</th>
        <th>C&oacute;digo</th>
        <th>Texto Promo&ccedil;&atilde;o</th>
	<th>Modificar</th>
	<th>Excluir</th>
    </tr>
    <?
    if ($itens) {
	foreach ($itens as $item) {
	    ?>
	    <tr>
		<td><?= $item->nome ?></td>
		<td><?= $item->restaurante->nome ?></td>
		<td><?= $item->preco ?></td>
                <td><?= $item->ativo ?></td>
                <td><?= $item->disponivel ?></td>
                <td><?= $item->esta_em_promocao ?></td>
                <td><?= $item->preco_promocional ?></td>
                <td><?= $item->descricao ?></td>
                <td><?= $item->qtd_produto_adicional ?></td>
                <td><?= $item->codigo ?></td>
                <td><?= $item->texto_promocao ?></td>
              
		<td><a href="admin/produto/form/<?= $item->id ?>">Modificar</a></td>
		<td><a href="admin/produto/controller?id=<?= $item->id ?>&action=delete" onclick="return window.confirm('Confirmar exclusão?')">Excluir</a></td>
	    </tr>
	    <?
	}
    } else {
	?>
    <tr>
	<td colspan="19">Nenhum produto cadastrado</td>
    </tr>
    <? } ?>
</table>

<? include("../../include/footer.php"); ?>