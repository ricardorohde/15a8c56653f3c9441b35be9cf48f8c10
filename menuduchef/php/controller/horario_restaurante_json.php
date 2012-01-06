<?

include_once("../lib/config.php");

header("Content-type: application/json;");

$parameters = HttpUtil::utf8DecodeArray($_REQUEST);
$errors = array();

if($parameters['deleteHash']) {
    HttpUtil::removeArrayFromSessionMatrix($parameters['hash_restaurante'], 'hash', $parameters['deleteHash']);
} else {
    if (!empty($parameters['dia_da_semana']) && !empty($parameters['hora_inicio1']) && !empty($parameters['hora_fim1'])) {
        if(empty($parameters['hora_inicio2'])) {
            unset($parameters['hora_inicio2']);
        }
        
        if(empty($parameters['hora_fim2'])) {
            unset($parameters['hora_fim2']);
        }
        
        if(empty($parameters['hora_inicio3'])) {
            unset($parameters['hora_inicio3']);
        }
        
        if(empty($parameters['hora_fim3'])) {
            unset($parameters['hora_fim3']);
        }
        
        $obj = new HorarioRestaurante($parameters);
        $hashParameter = $parameters['hash'];
        $hashCalculado = $obj->hash();
        $indexByHash = HttpUtil::searchArrayInSessionMatrix($parameters['hash_restaurante'], 'hash', $hashParameter ? : $hashCalculado);

        if ($hashParameter || $indexByHash === null) {
            $parameters['hash'] = $hashCalculado;
            $parameters['id'] = $parameters['horario_id'];
            HttpUtil::saveArrayInSessionMatrix($parameters['hash_restaurante'], $parameters, $indexByHash);
        } else {
            $errors[] = "Horário já cadastrado anteriormente";
        }
    } else {
        if (empty($parameters['dia_da_semana'])) {
            $errors[] = "Dias da semana obrigatórios";
        }
        if (empty($parameters['hora_inicio1']) || empty($parameters['hora_fim1'])) {
            $errors[] = "Pelo menos o 1º horário deve ser preenchido";
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
    $json = StringUtil::matrixAttributesToJson($_SESSION[$parameters['hash_restaurante']], 'HorarioRestaurante', array(
        'methods' => array('hash', '__toString')
    ));
    
    echo $json;
}
?>