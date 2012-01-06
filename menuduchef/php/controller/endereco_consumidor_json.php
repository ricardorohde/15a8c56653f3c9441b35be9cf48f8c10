<?

include_once("../lib/config.php");

header("Content-type: application/json;");

$parameters = HttpUtil::utf8DecodeArray($_REQUEST);
$errors = array();

if($parameters['deleteHash']) {
    HttpUtil::removeArrayFromSessionMatrix($parameters['hash_consumidor'], 'hash', $parameters['deleteHash']);
} else {
    if (!empty($parameters['cidade_id']) && !empty($parameters['bairro_id']) &&
            !empty($parameters['logradouro']) && !empty($parameters['cep'])) {
        
        $obj = new EnderecoConsumidor($parameters);
        $hashParameter = $parameters['hash'];
        $hashCalculado = $obj->hash();
        $indexByHash = HttpUtil::searchArrayInSessionMatrix($parameters['hash_consumidor'], 'hash', $hashParameter ? : $hashCalculado);

        if ($hashParameter || $indexByHash === null) {
            $parameters['hash'] = $hashCalculado;
            $parameters['id'] = $parameters['endereco_id'];
	    
	    if($parameters['favorito']) {
		HttpUtil::updateValuesOfArrayInSessionMatrix($parameters['hash_consumidor'], 'favorito', 0);
	    }
	    
            HttpUtil::saveArrayInSessionMatrix($parameters['hash_consumidor'], $parameters, $indexByHash);
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
}

if (!empty($errors)) {
    echo '{"errors": [';
    foreach ($errors as $key => $error) {
        echo '{"error": "' . htmlentities($error) . '"}' . (($key + 1) < sizeof($errors) ? ',' : '');
    }
    echo ']}';
} else {
    $json = StringUtil::matrixAttributesToJson($_SESSION[$parameters['hash_consumidor']], 'EnderecoConsumidor', array(
        'methods' => array('hash', '__toString'), 'include' => array(
            'bairro' => array(
                'include' => 'cidade'
            )
        )
    ));
    
    echo $json;
}
?>