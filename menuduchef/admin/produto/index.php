<?
include('../../include/header_admin.php');

$itens = Produto::all(array("order" => "nome asc"));
?>

<h2><a href="admin/area_administrativa">Menu Principal</a> &raquo; Gerenciar Produtos</h2>

<a href="admin/produto/form" title="Criar">Criar</a>
<br /><br />

<table class="list w100">
    <tr>
	<th>Nome</th>
	<th>Restaurante</th>
        <th>Tamanho</th>
        <th>Multi-sabor</th>
        <th>Pre&ccedil;o</th>
        <th>Ativo</th>
        <th>Dispon&iacute;vel</th>
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
                <td><?= $item->tamanho ?></td>
                <td><?= $item->aceita_segundo_sabor ? "Sim" : "N�o" ?></td>
		<td><?= $item->getPrecoFormatado() ?></td>
                
                <td><?= $item->ativo ? "Sim" : "N�o" ?></td>
                <td><?= $item->disponivel ? "Sim" : "N�o" ?></td>
		<td align="center"><a href="admin/produto/form/<?= $item->id ?>">Modificar</a></td>
		<td align="center"><a href="admin/produto/controller?deleteId=<?= $item->id ?>" onclick="return window.confirm('Confirmar exclus�o?')">Excluir</a></td>
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

<? include("../../include/footer_admin.php"); ?>