<?
include_once("../lib/config.php");

$bairros = Bairro::find_all_by_id_cidade($_REQUEST["id"]);

header("Content-type: application/json;");

echo StringUtil::arrayActiveRecordToJson($bairros);
?>