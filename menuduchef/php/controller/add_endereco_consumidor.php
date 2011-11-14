<?

include_once("../lib/config.php");

header("Content-type: application/json;");

$parameters = HttpUtil::utf8DecodeArray($_REQUEST);
$errors = array();

if (!empty($parameters['cidade_id']) && !empty($parameters['bairro_id']) && !empty($parameters['logradouro']) && !empty($parameters['cep'])) {
    $endereco = new EnderecoConsumidor($parameters);

    if (!HttpUtil::searchAttributeInSessionMatrix($parameters['hash'], 'hash_endereco', $endereco->hash())) {
	$parameters['hash_endereco'] = $endereco->hash();
	HttpUtil::addArrayInSessionHash($parameters, $parameters['hash']);	
	echo $endereco->to_json(array('methods' => 'hash', 'include' => array('bairro' => array('include' => 'cidade'))));
    } else {
	$errors[] = "Endereço já existe";
    }
} else {
    if (empty($parameters['cidade_id'])) {
	$errors[] = "Cidade obrigatória";
    }

    if (empty($parameters['bairro_id'])) {
	$errors[] = "Bairro obrigatório";
    }

    if (empty($parameters['logradouro'])) {
	$errors[] = "Logradouro obrigatório";
    }

    if (empty($parameters['cep'])) {
	$errors[] = "CEP obrigatório";
    }
}

if (!empty($errors)) {
    echo '{"errors": [';
    foreach ($errors as $key => $error) {
	echo '{"error": "' . htmlentities($error) . '"}' . (($key + 1) < sizeof($errors) ? ',' : '');
    }
    echo ']}';
}
?>