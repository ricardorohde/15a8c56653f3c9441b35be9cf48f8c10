<?
include_once("../lib/config.php");

$pedido = Pedido::find($REQUEST["id"]);
$produtos = Produto::find_all_by_restaurante_id($pedido->restaurante_id);

header("Content-type: application/json;");

echo StringUtil::arrayActiveRecordToJson($produtos);
?>