<?
include_once("../lib/config.php");

header("Content-type: application/json;");

$parameters = HttpUtil::utf8DecodeArray($_REQUEST);

if(!empty($parameters['bairro_id']) && !empty($parameters['logradouro'])) {
    HttpUtil::addArrayInSessionHash($parameters, $parameters['hash']);
    $endereco = new EnderecoConsumidor($parameters);
    echo $endereco->to_json(array('include' => array('bairro' => array('include' => 'cidade'))));
} else {
    $errors = array();
    
    if(empty($parameters['bairro_id'])) {
	$errors[] = "Bairro obrigatório";
    }
    
    if(empty($parameters['logradouro'])) {
	$errors[] = "Logradouro obrigatório";
    }
    
    echo '{"errors": [';
    foreach($errors as $key => $error) {
	echo '{"error": "' . htmlentities($error) . '"}' . (($key + 1) < sizeof($errors) ? ',' : '');
    }
    echo ']}';
}
?>