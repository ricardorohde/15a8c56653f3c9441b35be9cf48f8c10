<?php

$atendente = unserialize($_SESSION['usuario_obj']);
if($_GET['status']=='novo_ped'){
    $pedidos=Pedido::all(array("order"=>"quando", "conditions"=>array("situacao = ? AND restaurante_id = ?","novo_pedido",$atendente->restaurante_id)));
    $idtable = "novoped";
    $classtr = "novo_ped";
}
else if($_GET['status']=='ped_pre'){
    $pedidos=Pedido::all(array("order"=>"quando", "conditions"=>array("situacao = ? AND restaurante_id = ?","pedido_em_preparo",$atendente->restaurante_id)));
    $idtable = "pedpre";
    $classtr = "ped_pre";
}

echo '<table id="'.$idtable.'" class="table" border="1px solid black">';
if($pedidos){
    foreach($pedidos as $pedido){
        $dh = $pedido->quando->format('d/m/Y - H:i');
                        
        $quebra = explode(" - ", $dh);
        $data=$quebra[0];
        $hora=$quebra[1];
         ?>

        <tr id="linha0011" class="<?= $classtr ?>" onclick="copia('<?= $pedido->id ?>','<?= $idtable ?>')" style="cursor:pointer;">
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