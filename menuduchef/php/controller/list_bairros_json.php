<?
include_once("../lib/config.php");

$bairros = Bairro::find_all_by_id_cidade($_REQUEST["id"]);

header("Content-type: application/json; charset=iso-8859-1");
mb_internal_encoding("iso-8859-1");
mb_http_output( "iso-8859-1" ); 
ob_start("mb_output_handler");

echo StringUtil::arrayActiveRecordToJson($bairros);
?>