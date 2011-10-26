<?
$class = "PedidoTemProduto";

$redirect = false;
include("include/crud.php");
HttpUtil::redirect("./?ped={$_POST["ped"]}");
?>