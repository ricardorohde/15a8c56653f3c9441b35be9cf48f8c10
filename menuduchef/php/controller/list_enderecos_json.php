<?
include_once("../lib/config.php");

$enderecos = EnderecoConsumidor::find_all_by_consumidor_id($_REQUEST["id"], array("order" => "logradouro asc"));

header("Content-type: application/json;");

echo StringUtil::arrayActiveRecordToJson($enderecos);
?>