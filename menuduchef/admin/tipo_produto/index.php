<?
include("../../include/header.php");

$itens = TipoProduto::all(array("order" => "nome asc"));
?>

<h2>Gerenciar Tipos de Produto</h2>

<a href="admin/" title="Menu principal">Menu principal</a>
<br /><br />

<a href="admin/tipo_produto/form" title="Criar">Criar</a>
<br /><br />

<table>
    <tr>
	<th>Nome</th>
	<th>Modificar</th>
	<th>Excluir</th>
    </tr>
    <?
    if ($itens) {
	foreach ($itens as $item) {
	    ?>
	    <tr>
		<td><?= $item->nome ?></td>
		<td><a href="admin/tipo_produto/form/<?= $item->id ?>">Modificar</a></td>
		<td><a href="admin/tipo_produto/controller?id=<?= $item->id ?>&action=delete" onclick="return window.confirm('Confirmar exclus�o?')">Excluir</a></td>
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

<? include("../../include/footer.php"); ?>