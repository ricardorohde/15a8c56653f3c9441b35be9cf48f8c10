<?
$class = "PedidoTemProduto";

$redirect = false;
include("include/crud.php");
HttpUtil::redirect("./?ped={$obj->pedido_id}");
?>