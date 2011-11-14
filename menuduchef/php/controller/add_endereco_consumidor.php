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
	$errors[] = "Endere�o j� existe";
    }
} else {
    if (empty($parameters['cidade_id'])) {
	$errors[] = "Cidade obrigat�ria";
    }

    if (empty($parameters['bairro_id'])) {
	$errors[] = "Bairro obrigat�rio";
    }

    if (empty($parameters['logradouro'])) {
	$errors[] = "Logradouro obrigat�rio";
    }

    if (empty($parameters['cep'])) {
	$errors[] = "CEP obrigat�rio";
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