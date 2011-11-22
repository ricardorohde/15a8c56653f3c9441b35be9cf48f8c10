<?
include_once("../lib/config.php");

$bairros = Bairro::find_all_by_cidade_id($_REQUEST["id"], array("order" => "nome asc"));

header("Content-type: application/json;");

echo StringUtil::arrayActiveRecordToJson($bairros);
?>