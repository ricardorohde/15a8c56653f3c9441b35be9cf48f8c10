<?

include_once("../lib/config.php");

header("Content-type: application/json;");

$parameters = HttpUtil::utf8DecodeArray($_REQUEST);
$errors = array();

//print_r($parameters);

if($parameters['deleteHash']) {
    HttpUtil::removeArrayFromSessionMatrix($parameters['hash_consumidor'], 'hash', $parameters['deleteHash']);
    /*if($parameters['favorito']) {
	if($_SESSION[$parameters['hash_consumidor']]) {
	    foreach($_SESSION[$parameters['hash_consumidor']] as $key => $array) {
		$_SESSION[$parameters['hash_consumidor']][$key]['favorito'] = 1;
		break;
	    }
	}
    }*/
} else {
    if (!empty($parameters['cidade_id']) && !empty($parameters['bairro_id']) &&
            !empty($parameters['logradouro']) && !empty($parameters['cep'])) {
        
        $endereco = new EnderecoConsumidor($parameters);
        $hashParameter = $parameters['hash'];
        $hashCalculado = $endereco->hash();
        $indexEnderecoByHash = HttpUtil::searchArrayInSessionMatrix($parameters['hash_consumidor'], 'hash', $hashParameter ? : $hashCalculado);

        if ($hashParameter || $indexEnderecoByHash === null) {
            $parameters['hash'] = $hashCalculado;
            $parameters['id'] = $parameters['endereco_id'];
	    
	    if($parameters['favorito']) {
		HttpUtil::updateValuesOfArrayInSessionMatrix($parameters['hash_consumidor'], 'favorito', 0);
	    }
	    
            HttpUtil::saveArrayInSessionMatrix($parameters['hash_consumidor'], $parameters, $indexEnderecoByHash);
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
        'methods' => 'hash', 'include' => array(
            'bairro' => array(
                'include' => 'cidade'
            )
        )
    ));
//    print_r(json_decode($json, true));
//    print_r(HttpUtil::updateValuesOfArrayInMatrix(json_decode($json, true), 'hash_consumidor', $parameters['hash_consumidor']));
//    echo json_encode(HttpUtil::updateValuesOfArrayInMatrix(json_decode($json, true), 'hash_consumidor', $parameters['hash_consumidor']));
    echo $json;
}
?>