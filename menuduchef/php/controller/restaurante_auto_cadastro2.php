<?

include_once("../lib/config.php");
include_once("../lib/connect_p.php");

$redirect = "../../gerente_principal";

$data = HttpUtil::getParameterArray2();
    
        connect();
        $end = filtrar_caracteres_malignos($data['rua']).", ".filtrar_caracteres_malignos($data['numero'])." - ".filtrar_caracteres_malignos($data['bairro']);

        $comp = filtrar_caracteres_malignos($data['complemento']);
        $tel = filtrar_caracteres_malignos($data['telefone']);
        $desc = filtrar_caracteres_malignos($data['descricao']);
        $cat = filtrar_caracteres_malignos($data['categoria']);
        
        $sql="UPDATE restaurante SET endereco = '$end', complemento = '$comp', telefone = '$tel', descricao = '$desc', categoria_personalizada = '$cat' WHERE id = ".$_SESSION['restaurante_id'];
        mysql_query($sql);
        
        $sql="DELETE FROM restaurante_tem_tipo WHERE restaurante_id = ".$_SESSION['restaurante_id'];
        mysql_query($sql);
        
        $sql="DELETE FROM restaurante_aceita_forma_pagamento WHERE restaurante_id = ".$_SESSION['restaurante_id'];
        mysql_query($sql);
        
        foreach($data as $key => $valor){
            $quebra = explode("_",$key);
            if($quebra[0]=="tiporestaurante"){
                $sql="INSERT INTO restaurante_tem_tipo (restaurante_id,tiporestaurante_id) VALUES (".$_SESSION['restaurante_id'].",".$quebra[1].")";
                mysql_query($sql);
            }
            else if($quebra[0]=="formapagamento"){
                $sql="INSERT INTO restaurante_aceita_forma_pagamento (restaurante_id,formapagamento_id) VALUES (".$_SESSION['restaurante_id'].",".$quebra[1].")";
                mysql_query($sql);
            }
        }
        
        mysql_close();

HttpUtil::redirect($redirect);
?>