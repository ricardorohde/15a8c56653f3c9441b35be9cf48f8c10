<?
        include_once("../../php/lib/config.php");
        
        $usuarioSession = unserialize($_SESSION['usuario']);
        if ($usuarioSession) {
            $administradorSession = $usuarioSession->tipo == Usuario::$ADMINISTRADOR ? unserialize($_SESSION['usuario_obj']) : null;
            $gerenteSession = $usuarioSession->tipo == Usuario::$GERENTE ? unserialize($_SESSION['usuario_obj']) : null;
            $atendenteSession = $usuarioSession->tipo == Usuario::$ATENDENTE ? unserialize($_SESSION['usuario_obj']) : null;
            $consumidorSession = $usuarioSession->tipo == Usuario::$CONSUMIDOR ? unserialize($_SESSION['usuario_obj']) : null;
        }
        
        $obj=Consumidor::find($consumidorSession->id);
        if($obj->pedidos){
            foreach($obj->pedidos as $pedido){
                    if($pedido->situacao==Pedido::$NOVO){
                        $cor = "#FFD700";
                    }else if($pedido->situacao==Pedido::$CANCELADO){
                        $cor = "#DD6666";
                    }else if($pedido->situacao==Pedido::$PREPARACAO){
                        $cor = "#3CB371";
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