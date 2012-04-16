<?

session_start();

include("../../include/header2.php");

if($_SESSION['sessao_valida']){
    $atendente = unserialize($_SESSION['usuario_obj']);
}

if($_GET['sta']=='novoped'){
    $pedidos=Pedido::all(array("order"=>"quando", "conditions"=>array("situacao = ? AND restaurante_id = ? AND id <> ?",Pedido::$NOVO,$atendente->restaurante_id,$_GET['ped'])));
    $idtable = "novoped";
}
else if($_GET['sta']=='pedpre'){
    $pedidos=Pedido::all(array("order"=>"quando", "conditions"=>array("situacao = ? AND restaurante_id = ? AND id <> ?",Pedido::$PREPARACAO,$atendente->restaurante_id,$_GET['ped'])));
    $idtable = "pedpre";
}
else if($_GET['sta']=='pedconcan'){
    $pedidos=Pedido::all(array("order"=>"quando", "conditions"=>array("(situacao = ?  OR situacao = ?) AND restaurante_id = ? AND id <> ?",Pedido::$CONCLUIDO,Pedido::$CANCELADO,$atendente->restaurante_id,$_GET['ped'])));
    $idtable = "pedconcan";
}

echo '<table id="'.$idtable.'" class="table" border="1px solid black">';
if($pedidos){
    foreach($pedidos as $pedido){
        $dh = $pedido->quando->format('d/m/Y - H:i');
                        
        $quebra = explode(" - ", $dh);
        $data=$quebra[0];
        $hora=$quebra[1];
        
        if($pedido->situacao==Pedido::$NOVO){
            $classtr = "novo_ped";
        }else if($pedido->situacao==Pedido::$PREPARACAO){
            $classtr = "ped_pre";
        }else if($pedido->situacao==Pedido::$CONCLUIDO){
            $classtr = "ped_con";
        }else if($pedido->situacao==Pedido::$CANCELADO){
            $classtr = "ped_can";
        }      
         ?>

        <tr class="<?= $classtr ?> pedidos" idped="<?= $pedido->id ?>" tipo="<?= $idtable ?>" style="cursor:pointer;">
            <td><?= $pedido->id ?></td>
            <td><?= $pedido->consumidor->nome ?></td>
            <td><?= $data ?></td>
            <td><?= $hora ?></td>
        </tr>
        
        <?
    }
}
echo '</table>';

?>