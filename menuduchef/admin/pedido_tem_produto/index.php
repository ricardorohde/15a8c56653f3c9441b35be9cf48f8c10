<?
include('../../include/header_admin.php');

$itens = PedidoTemProduto::all(array("order" => "pedido_id asc", "conditions" => array("pedido_id = ?", $_GET['ped'])));

?>

<h2><a href="admin/area_administrativa">Menu Principal</a> &raquo; <a href="admin/pedido">Gerenciar Pedidos</a> &raquo; Gerenciar Produtos inclusos nos Pedidos</h2>

<a href="admin/pedido_tem_produto/form.php?ped=<?= $_GET['ped'] ?>" title="Criar">Criar</a>
<br /><br />

<table class="list">
    <tr>
	<th>Pedido</th>
	<th>Produto</th>
        <th>Sabores Adicionais</th>
        <th>Pre&ccedil;o Unit&aacute;rio</th>
        <th>Quantidade</th>
        <th>OBS</th>
        <th>Tamanho</th>
        <th width="10%"></th>
	<th width="10%"></th>
    </tr>
    <?
    if ($itens) {
	foreach ($itens as $item) {
	    ?>
	    <tr>
		<td><?= $item->pedido_id." (".$item->pedido->restaurante->nome.", ".$item->pedido->consumidor->nome.")" ?></td>
		<td><?= $item->produto->nome ?></td>
                <td><?= $item->produto2->nome ?>
                    <? if($item->produto_id3){ echo ", ".$item->produto3->nome; } ?>
                    <? if($item->produto_id4){ echo ", ".$item->produto4->nome; } ?></td>
                <td><?= StringUtil::doubleToCurrency($item->preco_unitario) ?>
                <? $preco = 0;
                        $adicionais = PedidoTemProdutoAdicional::all(array("conditions" => array("pedidotemproduto_id = ?", $item->id)));  
                        foreach($adicionais as $adicional){
                            $preco += $adicional->preco;
                        }
                        if($preco){
                            echo "+(".StringUtil::doubleToCurrency($preco).")";
                        }
                            ?></td>
                <td><?= $item->qtd ?></td>
                <td><?= $item->obs ?></td>
                <td><?= $item->tamanho ?></td>
                
                              
		<td align="center"><a href="admin/pedido_tem_produto/form/?id=<?= $item->id ?>&ped=<?= $_GET['ped'] ?>">Modificar</a></td>
		<td align="center"><a href="admin/pedido_tem_produto/controller?deleteId=<?= $item->id ?>" onclick="return window.confirm('Confirmar exclus�o?')">Excluir</a></td>
	    </tr>
	    <?
	}
    } else {
	?>
    <tr>
	<td colspan="12">Nenhum produto em pedido cadastrado</td>
    </tr>
    <? } ?>
</table>

<? include("../../include/footer_admin.php"); ?>