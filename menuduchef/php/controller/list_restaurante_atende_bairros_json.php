<?
include_once("../lib/config.php");

$rab = RestauranteAtendeBairro::find_all_by_restaurante_id($_REQUEST["id"]);

header("Content-type: application/json;");

echo StringUtil::arrayActiveRecordToJson($rab);
?>