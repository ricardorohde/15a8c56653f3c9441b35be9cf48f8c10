<?php
ob_start();
session_start();
include("../../include/header2.php");

$ultimo_criar = -1;
$ultimo_modificar = -1;
$ccriar = 0;
$cmodificar = 0;
$gerente = unserialize($_SESSION['usuario_obj']);

foreach($_POST as $key => $valor){
    
    $pre = explode("_",$key);
    if($pre[0]=="novo"){
        $pos = explode("-",$key);
        $a_criar[$pos[1]][$pos[0]] = $valor;
        if($ultimo_criar!=$pos[1]){
            $ultimo_criar=$pos[1];
            $fila_criar[$ccriar] = $pos[1];
            $ccriar++;
        }
    }else{
        $pos = explode("-",$key);
        $a_modificar[$pos[1]][$pos[0]] = $valor;
        if($ultimo_modificar!=$pos[1]){
            $ultimo_modificar=$pos[1];
            $fila_modificar[$cmodificar] = $pos[1];
            $cmodificar++;
        }
    }
}

for($j=0;$j<sizeof($a_criar);$j++){
    $i = $fila_criar[$j];
    unset($data);
    if($a_criar[$i]['novo_nome']!=""){
        $data['nome'] = $a_criar[$i]['novo_nome'];
        $data['preco_adicional'] = $a_criar[$i]['novo_preco_adicional'];
        $data['disponivel'] = $a_criar[$i]['novo_disponivel'];
        $data['quantas_unidades_ocupa'] = $a_criar[$i]['novo_quantas_unidades_ocupa'];
        $data['restaurante_id'] = $gerente->restaurante_id;
        $data['ativo'] = 1;

        $obj = new ProdutoAdicional($data);
	echo print_r($data, true)."<br/><br/>";
        //echo $obj->id." ~ ".$obj->nome." ".$a_criar[$i]['preco_adicional']."<br/>";
        $obj->save();
    }
}
for($j=0;$j<sizeof($a_modificar);$j++){
    $i = $fila_modificar[$j];
    unset($data);
    if($a_modificar[$i]['nome']!=""){

        $data['id'] = $a_modificar[$i]['id'];
        $data['nome'] = $a_modificar[$i]['nome'];
        $data['preco_adicional'] = $a_modificar[$i]['preco_adicional'];
        $data['disponivel'] = $a_modificar[$i]['disponivel'];
        $data['quantas_unidades_ocupa'] = $a_modificar[$i]['quantas_unidades_ocupa'];
        $data['restaurante_id'] = $gerente->restaurante_id;
        $data['ativo'] = $a_modificar[$i]['ativo'];
	echo $data[id] . "\n\n";
        $obj = ProdutoAdicional::find($data['id']);
        echo print_r($data, true)."<br/><br/>";
        $obj->update_attributes($data);
    }
}


//header("location: ../../edita_extra.php");
?>
