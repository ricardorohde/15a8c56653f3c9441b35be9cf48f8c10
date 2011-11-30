<?
include('../../include/header_admin.php');

$itens = ProdutoAdicional::all(array("order" => "nome asc"));
?>

<h2><a href="admin/area_administrativa">Menu Principal</a> &raquo; Gerenciar Produtos Adicionais</h2>

<a href="admin/produto_adicional/form" title="Criar">Criar</a>
<br /><br />

<table class="list w100">
    <tr>
	<th>Nome</th>
	<th>Restaurante</th>
        <th>Pre&ccedil;o Adicional</th>
        <th>Ativo</th>
        <th>Dispon&iacute;vel</th>
        <th>Quantas Unidades Ocupa</th>
	<th width="10%"></th>
	<th width="10%"></th>
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
               
              
		<td align="center"><a href="admin/produto_adicional/form/<?= $item->id ?>">Modificar</a></td>
		<td align="center"><a href="admin/produto_adicional/controller?deleteId=<?= $item->id ?>" onclick="return window.confirm('Confirmar exclusão?')">Excluir</a></td>
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

<? include("../../include/footer_admin.php"); ?>