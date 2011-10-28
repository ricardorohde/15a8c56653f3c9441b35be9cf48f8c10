<?
include_once("../lib/config.php");

$produto = Produto::find($REQUEST["id"]);

header("Content-type: application/json;");

if($produto->aceita_segundo_sabor) {
   echo $produto->to_json();
}
?>