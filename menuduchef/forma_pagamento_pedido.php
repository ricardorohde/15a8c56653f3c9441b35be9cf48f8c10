<?

session_start();

include("include/header2.php");

if($_SESSION['sessao_valida']){
    $atendente = unserialize($_SESSION['usuario_obj']);
}


$pedido=Pedido::find(array("conditions"=>array("id = ? AND restaurante_id = ?",$_GET['ped'],$atendente->restaurante_id)));

$preco_total = 0;
$taxa_entrega = $pedido->preco_entrega;
$desconto = 0;

echo "N&uacute;mero do Pedido: ".$pedido->id."<br/>";
echo "Forma de Pagamento: ".$pedido->forma_pagamento."<br/>";
if($pedido->nome_cartao){
    echo "Nome no cart&atilde;o: ".$pedido->nome_cartao."<br/>";
    echo "N&uacute;mero do cart&atilde;o: ".$pedido->num_cartao."<br/>";
    echo "C&oacute;digo de seguran&ccedil;a: ".$pedido->cod_seguranca_cartao."<br/>";
    echo "Validade do cart&atilde;o: ".$pedido->validade_cartao."<br/>";
}
if($pedido->pedido_tem_produtos){
    foreach($pedido->pedido_tem_produtos as $ptp){        
        $preco_total += ($ptp->qtd * $ptp->preco_unitario);
    }
}
$preco_total = (($preco_total + $taxa_entrega) - $desconto);
echo "Valor Total: R$ ".$preco_total."<br/>";
echo "Troco para: R$ ".$pedido->troco."<br/>";

?>