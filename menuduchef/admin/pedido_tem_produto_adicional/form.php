<?
include('../../include/header_admin.php');

$obj = HttpUtil::getActiveRecordObjectBySessionOrGetId("PedidoTemProdutoAdicional");

$pedido_tem_produto = PedidoTemProduto::find_by_id($_GET['prodnoped']);
$produto_tem_adicionais = ProdutoTemProdutoAdicional::all(array("order" => "id asc", "conditions" => array("produto_id = ?",$pedido_tem_produto->produto_id)));
//$produtos_adicionais = ProdutoAdicional::all(array("order" => "nome asc", "conditions" => array("",)));
?>

<h2><a href="admin/">Menu Principal</a> &raquo;  <a href="admin/pedido">Gerenciar Pedidos</a> &raquo; <a href="admin/pedido_tem_produto/?ped=<?= $_GET['ped'] ?>">Gerenciar Produtos inclusos nos Pedidos</a> &raquo; Gerenciar Produtos Adicionais inclusos nos Pedidos</h2>

<a href="admin/pedido_tem_produto_adicional/?prodnoped=<?= $_GET['prodnoped'] ?>&ped=<?= $_GET['ped'] ?>" title="Cancelar">Cancelar</a>
<br /><br />

<form action="admin/pedido_tem_produto_adicional/controller" method="post">
    <input type="hidden" name="id" value="<?= $obj->id ?>" />
    <input type="hidden" name="ped" value="<?= $_GET['ped'] ?>" />
    <input type="hidden" name="prodnoped" value="<?= $_GET['prodnoped'] ?>" />
    <input type="hidden" name="pedidotemproduto_id" value="<?= $_GET['prodnoped'] ?>" />
    Pedido tem Produto<br /><? if($pedido_tem_produto){ 
         echo $pedido_tem_produto->id." ".$pedido_tem_produto->produto->nome;  
      } ?>

    <br /><br />
    Produto Adicional<br />
    <select name="produtoadicional_id">-- Selecione --</option>
	<?
	if ($produto_tem_adicionais) {
	    foreach ($produto_tem_adicionais as $pta) {
		?>
		<option value="<?= $pta->produto_adicional->id ?>" <? if ($pta->produto_adicional->id == $obj->produtoadicional_id) { ?>selected="true"<? } ?>><?= $pta->produto_adicional->nome ?></option>
	    <? }
	} ?>
    </select>
    <br /><br />
    
    <input type="submit" value="<?= $obj->id ? "Modificar" : "Criar" ?>" />
</form>

<? include("../../include/footer.php"); ?>