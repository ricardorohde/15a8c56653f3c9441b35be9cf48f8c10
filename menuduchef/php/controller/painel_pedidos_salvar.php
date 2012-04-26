<?

include_once('../lib/config.php');

if ($atendenteSession || $gerenteSession) {
    $pedido_id = $_REQUEST['id'];
    $op = $_REQUEST['op'];
    
    if ($pedido_id && in_array($op, array('avancar', 'retornar', 'cancelar'))) {
	$pedido = Pedido::find($pedido_id);
	
	switch ($op) {
	    case 'avancar':
		switch ($pedido->situacao) {
		    case Pedido::$NOVO:
			$pedido->situacao = Pedido::$PREPARACAO;
			$pedido->quando_confirmado = date('Y-m-d H:i:s');
			break;

		    case Pedido::$PREPARACAO:
			$pedido->situacao = Pedido::$CONCLUIDO;
			$pedido->quando_concluiu = date('Y-m-d H:i:s');
			break;
		}
		break;

	    case 'retornar':
		switch ($pedido->situacao) {
		    case Pedido::$CONCLUIDO:
		    case Pedido::$CANCELADO:
			$pedido->situacao = Pedido::$PREPARACAO;
			break;

		    case Pedido::$PREPARACAO:
			$pedido->situacao = Pedido::$NOVO;
			break;
		}
		break;

	    case 'cancelar':
		$pedido->situacao = Pedido::$CANCELADO;
		break;
	}

	$pedido->save();
    }
}
?>