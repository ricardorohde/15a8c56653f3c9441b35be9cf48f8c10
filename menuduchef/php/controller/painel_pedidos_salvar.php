<?

include_once('../lib/config.php');

if($atendenteSession || $gerenteSession) {
    $pedido_id = $_REQUEST['id'];
    $op = $_REQUEST['op'];
    
    $pedido = Pedido::find($pedido_id);
    $situacaoNova = null;
    
    switch($op) {
	case 'avancar':
	    switch ($pedido->situacao) {
		case Pedido::$NOVO:
		    $situacaoNova = Pedido::$PREPARACAO;
		    break;

		case Pedido::$PREPARACAO:
		    $situacaoNova = Pedido::$CONCLUIDO;
		    break;
	    }
	    break;
	
	case 'retornar':
	    switch ($pedido->situacao) {
		case Pedido::$CONCLUIDO:
		case Pedido::$CANCELADO:
		    $situacaoNova = Pedido::$PREPARACAO;
		    break;

		case Pedido::$PREPARACAO:
		    $situacaoNova = Pedido::$NOVO;
		    break;
	    }
	    break;
	
	case 'cancelar':
	    $situacaoNova = Pedido::$CANCELADO;
	    break;
    }
    
    if($situacaoNova) {
	$pedido->update_attribute('situacao', $situacaoNova);
    }
}
?>