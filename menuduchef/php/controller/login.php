<?
session_cache_expire(15);
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
                $usuario_obj = UsuarioRestaurante::find_by_usuario_id($usuario->id);
		$redirect = '../../gerente_principal';
                $_SESSION['sessao_valida'] = 1;
		$_SESSION['usuario_id'] = $usuario_obj->id;
		$_SESSION['restaurante_id'] = $usuario_obj->restaurante_id;
                $_SESSION['cidade_id'] = $usuario_obj->restaurante->cidade_id;
		break;
	    case Usuario::$ATENDENTE:
		$usuario_obj = UsuarioRestaurante::find_by_usuario_id($usuario->id);
		$redirect = '../../painel_pedidos';
                $_SESSION['sessao_valida'] = 1;
		break;

	    case Usuario::$CONSUMIDOR:
		$usuario_obj = Consumidor::find_by_usuario_id($usuario->id);
		$redirect = '../../restaurantes';
		$_SESSION['sessao_valida'] = 1;
		$_SESSION['consumidor_id'] = $usuario_obj->id;
		if ($usuario_obj->enderecos) {
		    $enderecoConsumidor = $usuario_obj->enderecos[0];
		    $_SESSION['endereco'] = serialize($enderecoConsumidor);
		}

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