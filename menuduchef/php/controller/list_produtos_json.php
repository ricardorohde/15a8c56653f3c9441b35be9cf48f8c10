<?
include_once("../lib/config.php");

$produtos = Produto::find_all_by_id_restaurante($pedido->id_restaurante);

header("Content-type: application/json;");

echo StringUtil::arrayActiveRecordToJson($produtos);
?>