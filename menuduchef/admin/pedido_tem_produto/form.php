<?
include("../../include/header.php");

$obj = HttpUtil::getActiveRecordObjectBySessionOrGetId("PedidoTemProduto");

$pedidos = Pedido::all(array("order" => "quando asc"));


?>
<script type="text/javascript">
    $(function() {
	autoCompleteProdutos(<?= $obj->id_pedido ?: 0 ?>, <?= $obj->id_produto ?: 0 ?>);
	    
	$('#pedidos').change(function() {
	    autoCompleteProdutos($(this).val());
	});
    });
</script>
<h2>Gerenciar Produtos inclusos nos Pedidos</h2>

<a href="admin/pedido_tem_produto/" title="Cancelar">Cancelar</a>
<br /><br />

<form action="admin/pedido_tem_produto/controller" method="post">
    <input type="hidden" name="id" value="<?= $obj->id ?>" />
    Pedido<br /><? if($obj->id_pedido){
            echo $obj->id_pedido." (".$obj->pedido->restaurante->nome.", ".$obj->pedido->consumidor->nome.")";
        }else{ ?>
    <select id="pedidos" name="id_pedido">-- Selecione --</option>
	<?        
            if ($pedidos) {
                foreach ($pedidos as $pedido) {
                    ?>
                    <option value="<?= $pedido->id ?>" <? if ($pedido->id == $obj->id_pedido) { ?>selected="true"<? } ?>><?= $pedido->id." (".$pedido->restaurante->nome.", ".$pedido->consumidor->nome.")" ?></option>
                <? }
            }
	?>
    </select>
    <? } ?>
    <br /><br />
    Produto<br />
    <select id="produtos" name="id_produto"></select>
    <br /><br />
    Quantidade<br />
    <input type="text" name="qtd" value="<?= $obj->qtd ?>" maxlength="100" /><br /><br />
    OBS:<br />
    <input type="text" name="obs" value="<?= $obj->obs ?>" maxlength="100" /><br /><br />
    Tamanho<br />
    <input type="text" name="tamanho" value="<?= $obj->tamanho ?>" maxlength="100" /><br /><br />
    Produto2<br />
    <select name="id_produto2"><option value="">-- Selecione --</option>
	<?
	if ($produtos) {
	    foreach ($produtos as $produto) {
		?>
		<option value="<?= $produto->id ?>" <? if ($produto->id == $obj->id_produto2) { ?>selected="true"<? } ?>><?= $produto->nome ?></option>
	    <? }
	} ?>
    </select>
    
    <input type="submit" value="<?= $obj->id ? "Modificar" : "Criar" ?>" />
</form>

<? include("../../include/footer.php"); ?>