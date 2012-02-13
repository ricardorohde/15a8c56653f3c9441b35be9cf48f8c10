<?
$usuarioSession = unserialize($_SESSION['usuario']);

if ($usuarioSession) {
    $administradorSession = $usuarioSession->tipo == Usuario::$ADMINISTRADOR ? unserialize($_SESSION['usuario_obj']) : null;
    $gerenteSession = $usuarioSession->tipo == Usuario::$GERENTE ? unserialize($_SESSION['usuario_obj']) : null;
    $atendenteSession = $usuarioSession->tipo == Usuario::$ATENDENTE ? unserialize($_SESSION['usuario_obj']) : null;
    $consumidorSession = $usuarioSession->tipo == Usuario::$CONSUMIDOR ? unserialize($_SESSION['usuario_obj']) : null;
}

$enderecoCepSession = unserialize($_SESSION['endereco_cep']);

if($enderecoCepSession) {
    $enderecoSession = new EnderecoConsumidor();
    $enderecoSession->bairro_id = $enderecoCepSession->bairro_id;
    $enderecoSession->cep = $enderecoCepSession->cep;
    $enderecoSession->logradouro = $enderecoCepSession->logradouro;
} elseif ($consumidorSession) {
    if ($consumidorSession->enderecos) {
	$enderecoSession = $consumidorSession->enderecos[0];
    }
}
?>