<?

include_once('../lib/config.php');

header('Content-type: application/json;');

if($atendenteSession || $gerenteSession) {
    $situacao = $_REQUEST['situacao'];
    $restaurante_id = $atendenteSession->restaurante_id ?: $gerenteSession->restaurante_id;
    $restaurante = Restaurante::find($restaurante_id);
    
    $pedidos = Pedido::all(array("order" => "quando", "conditions" => array("situacao = ? AND restaurante_id = ?", situacao, $restaurante_id)));
    
    echo StringUtil::arrayActiveRecordToJson($pedidos, array('methods' => array('quandoFormatado', 'getTotal'), 'include' => array('consumidor', 'endereco_consumidor')));
}
?>