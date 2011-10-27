<?
$class = "PedidoTemProdutoAdicional";

$redirect = false;
include("include/crud.php");
HttpUtil::redirect("./?prodnoped={$obj->pedidotemproduto_id}&ped={$obj->pedido_tem_produto->pedido_id}");
?>