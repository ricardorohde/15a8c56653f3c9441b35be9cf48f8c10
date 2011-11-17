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
        
        $endereco = new EnderecoConsumidor($parameters);
        $hashParameter = $parameters['hash'];
        $hashCalculado = $endereco->hash();
        $indexEnderecoByHash = HttpUtil::searchArrayInSessionMatrix($parameters['hash_consumidor'], 'hash', $hashParameter ? : $hashCalculado);

        if ($hashParameter || $indexEnderecoByHash === null) {
            $parameters['hash'] = $hashCalculado;
            $parameters['id'] = $parameters['endereco_id'];
            HttpUtil::saveArrayInSessionMatrix($parameters['hash_consumidor'], $parameters, $indexEnderecoByHash);
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
}

if (!empty($errors)) {
    echo '{"errors": [';
    foreach ($errors as $key => $error) {
        echo '{"error": "' . htmlentities($error) . '"}' . (($key + 1) < sizeof($errors) ? ',' : '');
    }
    echo ']}';
} else {
    echo StringUtil::matrixAttributesToJson($_SESSION[$parameters['hash_consumidor']], 'EnderecoConsumidor', array(
        'methods' => 'hash', 'include' => array(
            'bairro' => array(
                'include' => 'cidade'
            )
        )
    ));
}
?>