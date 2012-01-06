<?

include_once("../lib/config.php");

header("Content-type: application/json;");

$parameters = HttpUtil::utf8DecodeArray($_REQUEST);
$errors = array();

if($parameters['deleteHash']) {
    HttpUtil::removeArrayFromSessionMatrix($parameters['hash_consumidor'], 'hash', $parameters['deleteHash']);
} else {
    if (!empty($parameters['numero'])) {
        $obj = new TelefoneConsumidor($parameters);
        $hashParameter = $parameters['hash'];
        $hashCalculado = $obj->hash();
        $indexByHash = HttpUtil::searchArrayInSessionMatrix($parameters['hash_consumidor'], 'hash', $hashParameter ? : $hashCalculado);

        if ($hashParameter || $indexByHash === null) {
            $parameters['hash'] = $hashCalculado;
            $parameters['id'] = $parameters['telefone_id'];
            HttpUtil::saveArrayInSessionMatrix($parameters['hash_consumidor'], $parameters, $indexByHash);
        } else {
            $errors[] = "Telefone já existe";
        }
    } else {
        if (empty($parameters['numero'])) {
            $errors[] = "Número obrigatório";
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
    $json = StringUtil::matrixAttributesToJson($_SESSION[$parameters['hash_consumidor']], 'TelefoneConsumidor', array(
        'methods' => array('hash', '__toString')
    ));
    
    echo $json;
}
?>