<?

include_once("../lib/config.php");

$data = HttpUtil::getParameterArray();

if (trim($data['email']) && trim($data['senha'])) {
    $usuario = Usuario::login($data['email'], $data['senha']);

    if ($usuario) {
	$_SESSION['usuario'] = serialize($usuario);
	
	switch ($usuario->tipo) {
	    case Usuario::$ADMINISTRADOR:
	    case Usuario::$GERENTE:
	    case Usuario::$ATENDENTE:
		HttpUtil::redirect('../../admin/');
		break;

	    case Usuario::$CONSUMIDOR:
		HttpUtil::redirect('../../');
		break;
	}
    } else {
	HttpUtil::showErrorMessages(array('Usu�rio n�o encontrado'));
	HttpUtil::redirect('../../');
    }
} else {
    HttpUtil::showErrorMessages(array('E-mail e Senha s�o campos obrigat�rios'));
    HttpUtil::redirect('../../');
}
?>