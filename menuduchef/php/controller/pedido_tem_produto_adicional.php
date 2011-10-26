<?
$class = "PedidoTemProdutoAdicional";

$redirect = false;
include("include/crud.php");
HttpUtil::redirect("./?prodnoped={$_POST["prodnoped"]}&ped={$_POST["ped"]}");
?>