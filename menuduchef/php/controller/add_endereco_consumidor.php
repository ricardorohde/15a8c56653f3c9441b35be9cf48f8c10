<?
include_once("../lib/config.php");

$endereco = new EnderecoConsumidor($_REQUEST);

header("Content-type: application/json;");
echo $endereco->to_json(array('include' => array('bairro' => array('include' => 'cidade'))));
?>