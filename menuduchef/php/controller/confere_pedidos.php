<?


        include("../../include/session_vars.php");
        
        $obj=Consumidor::find($consumidorSession->id);
        if($obj->pedidos){
            foreach($obj->pedidos as $pedido){
                    if($pedido->situacao=="novo_pedido"){
                        $cor = "#FFD700";
                    }else if($pedido->situacao=="cancelado"){
                        $cor = "#DD6666";
                    }else{
                        $cor = "#4682B4";
                    }
                    $dh = $pedido->quando->format('d/m/Y - H:i');
                        
                    $quebra = explode(" - ", $dh);
                    $data=$quebra[0];
                    $hora=$quebra[1];
                    echo "<div style='background:".$cor."; cursor:pointer; width:200px; height:30px; margin:3px;'>".$pedido->restaurante->nome." ".$data." ".$hora."</div>";
            }
        }
    ?>