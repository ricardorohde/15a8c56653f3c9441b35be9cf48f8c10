<?

include_once("../lib/config.php");

$data = HttpUtil::getParameterArray();

if (trim($data['email']) && trim($data['senha'])) {
    $usuario = Usuario::login($data['email'], $data['senha']);

    if ($usuario) {
	$usuario_obj = null;
	$redirect = null;
	
	switch ($usuario->tipo) {
	    case Usuario::$ADMINISTRADOR:
		$usuario_obj = Administrador::find_by_usuario_id($usuario->id);
		$redirect = '../../admin/area_administrativa';
		break;

	    case Usuario::$GERENTE:
	    case Usuario::$ATENDENTE:
		$usuario_obj = UsuarioRestaurante::find_by_usuario_id($usuario->id);
		$redirect = '../../admin/area_administrativa';
		break;

	    case Usuario::$CONSUMIDOR:
		$usuario_obj = Consumidor::find_by_usuario_id($usuario->id);
		$redirect = '../../';
		break;
	}
	
	$_SESSION['usuario'] = serialize($usuario);
	$_SESSION['usuario_obj'] = serialize($usuario_obj);
	HttpUtil::redirect($redirect);
    } else {
	HttpUtil::showErrorMessages(array('Usuário não encontrado'));
    }
} else {
    HttpUtil::showErrorMessages(array('E-mail e Senha são campos obrigatórios'));
}

HttpUtil::redirect('../../');
?>