<?
include('../../include/header_admin.php');

$itens = PedidoTemProdutoAdicional::all(array("order" => "pedidotemproduto_id asc", "conditions" => array("pedidotemproduto_id = ?",$_GET['prodnoped'])));
$pedido_tem_produto = PedidoTemProduto::find_by_id($_GET['prodnoped']);
$limite_acompanhamento = $pedido_tem_produto->produto->qtd_produto_adicional;
?>

<h2><a href="admin/">Menu Principal</a> &raquo; <a href="admin/pedido">Gerenciar Pedidos</a> &raquo; <a href="admin/pedido_tem_produto/?ped=<?= $_GET['ped'] ?>">Gerenciar Produtos inclusos nos Pedidos</a> &raquo; Gerenciar Produtos Adicionais inclusos nos Pedidos</h2>

<?
$qtd_acompanhamentos_existente = 0;
    if ($itens) {
	foreach ($itens as $item) {
            if($item->produto_adicional->quantas_unidades_ocupa>0){
                $qtd_acompanhamentos_existente++;
            }
        }
    }
    
    if($qtd_acompanhamentos_existente<$limite_acompanhamento){
?>
<a href="admin/pedido_tem_produto_adicional/form?prodnoped=<?= $_GET['prodnoped'] ?>&ped=<?= $_GET['ped'] ?>" title="Criar">Criar</a>
<?  } ?>
<br /><br />

<table class="list">
    <tr>
	<th>Produto contido no Pedido</th>
	<th>Produto Adicional</th>
        <th>Tipo</th>
        <th>Pre&ccedil;o</th>
	<th>Modificar</th>
	<th>Excluir</th>
    </tr>
    <?
    if ($itens) {
        
	foreach ($itens as $item) {
	    ?>
	    <tr>
		<td><?= $item->pedidotemproduto_id." (".$item->pedido_tem_produto->produto->nome.")"; ?></td>
		<td><?= $item->produto_adicional->nome ?></td>
                <td><?= $item->produto_adicional->quantas_unidades_ocupa ? "Acompanhamento" : "Por&ccedil;&atilde;o Extra" ?></td>
                <td><?= StringUtil::doubleToCurrency($item->preco) ?></td>
		<td><a href="admin/pedido_tem_produto_adicional/form/?id=<?= $item->id ?>&prodnoped=<?= $item->pedidotemproduto_id ?>&ped=<?= $_GET['ped'] ?>">Modificar</a></td>
		<td><a href="admin/pedido_tem_produto_adicional/controller?deleteId=<?= $item->id ?>" onclick="return window.confirm('Confirmar exclus�o?')">Excluir</a></td>
	    </tr>
	    <?
	}
    } else {
	?>
    <tr>
	<td colspan="12">Nenhum produto adicional em pedido cadastrado</td>
    </tr>
    <? } ?>
</table>

<? include("../../include/footer.php"); ?>