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
            
	    case Usuario::$CONSUMIDOR:

		$usuario_obj = Consumidor::find_by_usuario_id($usuario->id);
		$redirect = '../../cadastro';
		$_SESSION['sessao_valida'] = 1;
		$_SESSION['consumidor_id'] = $usuario_obj->id;
                
                
                                
		break;
                
            default: HttpUtil::showErrorMessages(array('Login n&atilde;o pertence a um usu&aacute;rio comum'));
	}
	
	$_SESSION['usuario'] = serialize($usuario);
	$_SESSION['usuario_obj'] = serialize($usuario_obj);
	HttpUtil::redirect($redirect);
    } else {
	HttpUtil::showErrorMessages(array('Usu&aacute;rio n&atilde;o encontrado'));
    }
} else {
    HttpUtil::showErrorMessages(array('E-mail e Senha s&atilde;o campos obrigat&oacute;rios'));
}

HttpUtil::redirect("../../".$_POST['onde_estava']);
?>