<?
require("../lib/config.php");

if($atendenteSession) {
    $novos = Pedido::all(array("order" => "quando", "conditions" => array("situacao = ? AND restaurante_id = ?", "novo_pedido", $atendenteSession->restaurante_id)));
    $preparo = Pedido::all(array("order" => "quando", "conditions" => array("situacao =? AND restaurante_id = ?", "pedido_preparacao", $atendenteSession->restaurante_id)));
    $finalizados = Pedido::all(array("order" => "quando", "conditions" => array("( situacao=? OR situacao=? ) AND restaurante_id = ?", "pedido_concluido", "cancelado", $atendenteSession->restaurante_id)));
    
    $json = '{';
    $json .= '"novos": ' . StringUtil::arrayActiveRecordToJson($novos) . ',';
    $json .= '"preparo": ' . StringUtil::arrayActiveRecordToJson($preparo) . ',';
    $json .= '"finalizados": ' . StringUtil::arrayActiveRecordToJson($finalizados);
    $json .= '}';
    
    header("Content-type: application/json;");
    echo $json;
}
?>