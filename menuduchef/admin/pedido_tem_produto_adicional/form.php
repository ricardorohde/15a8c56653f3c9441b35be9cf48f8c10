<?
include("../../include/header.php");

$obj = HttpUtil::getActiveRecordObjectBySessionOrGetId("PedidoTemProdutoAdicional");

$produto_tem_adicionais = ProdutoTemProdutoAdicional::all(array("order" => "id asc", "conditions" => array("produto_id = ?",$_GET['prod'])));
//$produtos_adicionais = ProdutoAdicional::all(array("order" => "nome asc", "conditions" => array("",)));
?>

<? include("../../include/painel_area_administrativa.php") ;?>

<h2><a href="admin/">Menu Principal</a> &raquo;  <a href="admin/pedido">Gerenciar Pedidos</a> &raquo; <a href="admin/pedido_tem_produto/?ped=<?= $_GET['ped'] ?>">Gerenciar Produtos inclusos nos Pedidos</a> &raquo; Gerenciar Produtos Adicionais inclusos nos Pedidos</h2>

<a href="admin/pedido_tem_produto_adicional/?prodnoped=<?= $_GET['prodnoped'] ?>&ped=<?= $_GET['ped'] ?>" title="Cancelar">Cancelar</a>
<br /><br />

<form action="admin/pedido_tem_produto_adicional/controller" method="post">
    <input type="hidden" name="id" value="<?= $obj->id ?>" />
    Pedido tem Produto<br /><? if($obj->pedido_tem_produto){ 
         echo $obj->pedido_tem_produto->id." ".$obj->pedido_tem_produto->produto->nome;  
      }else{ ?>
    <select name="pedidotemproduto_id">-- Selecione --</option>
	<?
	if ($pedido_tem_produtos) {
	    foreach ($pedido_tem_produtos as $pp) {
		?>
		<option value="<?= $pp->id ?>" <? if ($pp->id == $obj->pedidotemproduto_id) { ?>selected="true"<? } ?>><?= $pp->id." (".$pp->produto->nome.")" ?></option>
	    <? }
	} ?>
    </select><? } ?>
    <br /><br />
    Produto Adicional<br />
    <select name="produto_adicional_id">-- Selecione --</option>
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