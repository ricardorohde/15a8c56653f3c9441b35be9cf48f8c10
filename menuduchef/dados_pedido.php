<?

session_start();

include("include/header2.php");

if($_SESSION['sessao_valida']){
    $atendente = unserialize($_SESSION['usuario_obj']);
}


$pedido=Pedido::find(array("conditions"=>array("id = ? AND restaurante_id = ?",$_GET['ped'],$atendente->restaurante_id)));
$dh = $pedido->quando->format('d/m/Y - H:i');
                        
$quebra = explode(" - ", $dh);
$data=$quebra[0];
$hora=$quebra[1];


echo "N: ".$pedido->id."<br/>";
echo "Cliente: ".$pedido->consumidor->nome."<br/>";
echo "Data: ".$data."<br/>";
echo "Hora: ".$hora."<br/>";
echo "End.: ".$pedido->endereco_consumidor->logradouro.", ".$pedido->endereco_consumidor->numero.", ".$pedido->endereco_consumidor->complemento." - ".$pedido->endereco_consumidor->bairro->nome."<br/>";
echo "Ref.: ".$pedido->endereco_consumidor->referencia."<br/>";
echo "CEP: ".$pedido->endereco_consumidor->cep."<br/>";
echo "Telefones: ";

$pri = 1;
$telefones = TelefoneConsumidor::all(array("conditions"=>array("consumidor_id = ?",$pedido->consumidor_id)));
if($telefones){
    foreach($telefones as $telefone){
        if($pri == 1){
            echo $telefone->numero;
            $pri = 0;
        }else{
            echo ", ".$telefone->numero;
        }
        
    }
}

?>
