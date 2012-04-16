<?
require("../lib/config.php");

if($atendenteSession) {
    $novos = Pedido::all(array("order" => "quando", "conditions" => array("situacao = ? AND restaurante_id = ?", Pedido::$NOVO, $atendenteSession->restaurante_id)));
    $preparo = Pedido::all(array("order" => "quando", "conditions" => array("situacao =? AND restaurante_id = ?", Pedido::$PREPARACAO, $atendenteSession->restaurante_id)));
    $finalizados = Pedido::all(array("order" => "quando", "conditions" => array("( situacao=? OR situacao=? ) AND restaurante_id = ?", Pedido::$CONCLUIDO, Pedido::$CANCELADO, $atendenteSession->restaurante_id)));
    
    $json = '{';
    $json .= '"novos": ' . StringUtil::arrayActiveRecordToJson($novos) . ',';
    $json .= '"preparo": ' . StringUtil::arrayActiveRecordToJson($preparo) . ',';
    $json .= '"finalizados": ' . StringUtil::arrayActiveRecordToJson($finalizados);
    $json .= '}';
    
    header("Content-type: application/json;");
    echo $json;
}
?>