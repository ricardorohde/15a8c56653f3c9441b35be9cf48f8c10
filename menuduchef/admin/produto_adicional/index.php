<?
include_once("../../php/lib/config.php");

$itens = ProdutoAdicional::all(array("order" => "nome asc"));
?>

<? include("../../include/header.php"); ?>

<h2>Gerenciar Produtos Adicionais</h2>

<a href="admin/" title="Menu principal">Menu principal</a>
<br /><br />

<a href="admin/produto_adicional/form" title="Criar">Criar</a>
<br /><br />

<table>
    <tr>
	<th>Nome</th>
	<th>Restaurante</th>
        <th>Pre&ccedil;o Adicional</th>
        <th>Ativo</th>
        <th>Dispon&iacute;vel</th>
        <th>Quantas Unidades Ocupa</th>
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
		<td><?= $item->preco_adicional ?></td>
                <td><?= $item->ativo ?></td>
                <td><?= $item->disponivel ?></td>
                <td><?= $item->quantas_unidades_ocupa ?></td>
               
              
		<td><a href="admin/produto_adicional/form/<?= $item->id ?>">Modificar</a></td>
		<td><a href="admin/produto_adicional/controller?id=<?= $item->id ?>&action=delete" onclick="return window.confirm('Confirmar exclusão?')">Excluir</a></td>
	    </tr>
	    <?
	}
    } else {
	?>
    <tr>
	<td colspan="8">Nenhum produto adicional cadastrado</td>
    </tr>
    <? } ?>
</table>

<? include("../../include/footer.php"); ?>