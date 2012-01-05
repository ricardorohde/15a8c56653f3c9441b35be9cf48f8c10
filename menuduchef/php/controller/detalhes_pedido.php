<?

session_start();

include("../../include/header2.php");

if($_SESSION['sessao_valida']){
    $atendente = unserialize($_SESSION['usuario_obj']);
}

$pedido=Pedido::find(array("conditions"=>array("id = ? AND restaurante_id = ?",$_GET['ped'],$atendente->restaurante_id)));

$preco_total = 0;
$taxa_entrega = $pedido->preco_entrega;
$desconto = 0;

echo "Pedido N: ".$pedido->id."<br/>";
echo "<table border='1'>";

if($pedido->pedido_tem_produtos){
    echo "<tr><th>Qtd</th><th>Item</th><th>OBS</th><th>Valor</th></tr>";
    foreach($pedido->pedido_tem_produtos as $ptp){
        echo "<tr>";
        echo "<td>".$ptp->qtd."</td>";
        echo "<td>".$ptp->produto->nome."</td>";
        echo "<td>".$ptp->obs."</td>";
        echo "<td>R$ ".($ptp->qtd * $ptp->preco_unitario)."</td>";
        echo "</tr>";
        
        $preco_total += ($ptp->qtd * $ptp->preco_unitario);
    }
}else{
    echo "<tr><th>N&atilde;o h&aacute; nenhum item neste pedido.</th></tr>";
}
echo "</table>";

echo "<table border='1'>";
echo "<tr><th>Subtotal:</th><th>R$ ".$preco_total."</th></tr>";
echo "<tr><th>Desconto</th><th>R$ ".$desconto."</th></tr>";
echo "<tr><th>Taxa de Entrega:</th><th>R$ ".$taxa_entrega."</th></tr>";
echo "<tr><th>Valor Total:</th><th>R$ ".(($preco_total + $taxa_entrega) - $desconto)."</th></tr>";
echo "</table>";

?>