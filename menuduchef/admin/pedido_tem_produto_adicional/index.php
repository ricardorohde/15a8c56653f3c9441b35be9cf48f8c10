<?
include('../../include/header_admin.php');

$itens = PedidoTemProdutoAdicional::all(array("order" => "pedidotemproduto_id asc", "conditions" => array("pedidotemproduto_id = ?",$_GET['prodnoped'])));
$pedido_tem_produto = PedidoTemProduto::find_by_id($_GET['prodnoped']);
$limite_acompanhamento = $pedido_tem_produto->produto->qtd_produto_adicional;
?>

<h2><a href="admin/area_administrativa">Menu Principal</a> &raquo; <a href="admin/pedido">Gerenciar Pedidos</a> &raquo; <a href="admin/pedido_tem_produto/?ped=<?= $_GET['ped'] ?>">Gerenciar Produtos inclusos nos Pedidos</a> &raquo; Gerenciar Produtos Adicionais inclusos nos Pedidos</h2>

<a href="admin/pedido_tem_produto_adicional/form?prodnoped=<?= $_GET['prodnoped'] ?>&ped=<?= $_GET['ped'] ?>" title="Criar">Criar</a>
<?
$qtd_acompanhamentos_existente = 0;
    if ($itens) {
	foreach ($itens as $item) {
            
            $qtd_acompanhamentos_existente += $item->produto_adicional->quantas_unidades_ocupa;
            
        }
    }
    
    if(($qtd_acompanhamentos_existente>=$limite_acompanhamento)&&($limite_acompanhamento>0)){
?>
(O limite de <?= $limite_acompanhamento ?> acompanhamentos foi alcan&ccedil;ado.)
<?  } ?>
<br /><br />

<table class="list">
    <tr>
	<th>Produto contido no Pedido</th>
	<th>Produto Adicional</th>
        <th>Tipo</th>
        <th>Pre&ccedil;o</th>
	<th width="10%"></th>
	<th width="10%"></th>
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
		<td align="center"><a href="admin/pedido_tem_produto_adicional/form/?id=<?= $item->id ?>&prodnoped=<?= $item->pedidotemproduto_id ?>&ped=<?= $_GET['ped'] ?>">Modificar</a></td>
		<td align="center"><a href="admin/pedido_tem_produto_adicional/controller?deleteId=<?= $item->id ?>" onclick="return window.confirm('Confirmar exclusão?')">Excluir</a></td>
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

<? include("../../include/footer_admin.php"); ?>