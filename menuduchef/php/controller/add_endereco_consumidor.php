<?
include_once("../lib/config.php");

$parameters = HttpUtil::utf8DecodeArray($_REQUEST);
HttpUtil::addArrayInSessionHash($parameters, $parameters['hash']);
$endereco = new EnderecoConsumidor($parameters);

header("Content-type: application/json;");
echo $endereco->to_json(array('include' => array('bairro' => array('include' => 'cidade'))));
?>