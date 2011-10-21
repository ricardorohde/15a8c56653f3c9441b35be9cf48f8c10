<?
include_once("../lib/config.php");

//echo " !!".$_REQUEST["restaurante_id"]."!! ";
//echo " ZZ".$_REQUEST["id"]."ZZ ";

//$bairros = Bairro::find_by_sql('SELECT B.*, RAB.preco_entrega FROM bairro B LEFT JOIN restaurante_atende_bairro RAB ON B.id = RAB.bairro_id WHERE B.cidade_id = '.$_REQUEST["id"]);


$bairros = Bairro::find_all_by_cidade_id($_REQUEST["id"]);


header("Content-type: application/json;");

echo StringUtil::arrayActiveRecordToJson($bairros);
?>