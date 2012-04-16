<?

include_once('../lib/config.php');

header('Content-type: application/json');

if($atendenteSession || $gerenteSession) {
    $restaurante_id = $atendenteSession->restaurante_id ?: $gerenteSession->restaurante_id;
    
    $pedidos = Pedido::all(array("order" => "quando asc", "conditions" => array("restaurante_id = ?", $restaurante_id)));
    
    echo StringUtil::arrayActiveRecordToJson($pedidos, array(
	'methods' => array('quandoFormatado', 'getTotal', 'getTotalFormatado'),
	'include' => array(
	    'endereco_consumidor' => array('methods' => '__toString'),
	    'pedido_tem_produtos' => array('methods' => array('getTotal', 'getTotalFormatado'), 'include' => 'produto'),
	    'consumidor' => array('methods' => 'getTelefonesFormatado', 'include' => 'usuario')
	)
    ));
}
?>