<?
include_once("../lib/config.php");

$produtos_adicionais = ProdutoAdicional::find_all_by_restaurante_id($_REQUEST["id"]);

header("Content-type: application/json;");

echo StringUtil::arrayActiveRecordToJson($produtos_adicionais, array('include' => 'produto_tem_produtos_adicionais'));
?>