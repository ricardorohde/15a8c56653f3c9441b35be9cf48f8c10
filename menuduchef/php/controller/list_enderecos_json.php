<?
include_once("../lib/config.php");

$idConsumidor = $_REQUEST['idConsumidor'];
$idRestaurante = $_REQUEST['idRestaurante'];

$enderecos = EnderecoConsumidor::all(array(
    'joins' => 'inner join restaurante_atende_bairro rab on rab.bairro_id = endereco_consumidor.bairro_id',
    'conditions' => array('endereco_consumidor.consumidor_id = ? and rab.restaurante_id = ?', $idConsumidor, $idRestaurante)
));

header("Content-type: application/json;");

echo StringUtil::arrayActiveRecordToJson($enderecos);
?>