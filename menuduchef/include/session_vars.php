<?

$usuarioSession = unserialize($_SESSION['usuario']);

if ($usuarioSession) {
    $administradorSession = $usuarioSession->tipo == Usuario::$ADMINISTRADOR ? unserialize($_SESSION['usuario_obj']) : null;
    $gerenteSession = $usuarioSession->tipo == Usuario::$GERENTE ? unserialize($_SESSION['usuario_obj']) : null;
    $atendenteSession = $usuarioSession->tipo == Usuario::$ATENDENTE ? unserialize($_SESSION['usuario_obj']) : null;
    $consumidorSession = $usuarioSession->tipo == Usuario::$CONSUMIDOR ? unserialize($_SESSION['usuario_obj']) : null;
}

$enderecoSession = unserialize($_SESSION['endereco']);
?>
