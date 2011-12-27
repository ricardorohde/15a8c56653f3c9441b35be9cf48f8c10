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
    if($pre[0]=="categoria"){
        
    }
    else if($pre[0]=="novacategoria"){
        
    }
    else if($pre[0]=="novo"){
        $pos = explode("-",$key);
        $a_criar[$pos[1]][$pos[0]] = $valor;
        if($ultimo_criar!=$pos[1]){
            $ultimo_criar=$pos[1];
            $fila_criar[$ccriar] = $pos[1];
            $ccriar++;
        }
    }else{
        $pos = explode("-",$key);
        $po = explode("!",$pos[0]);
        $a_modificar[$pos[1]][$po[1]] = $valor;
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
        $obj->save();
    }
}
for($j=0;$j<sizeof($a_modificar);$j++){
    $i = $fila_modificar[$j];
    unset($data);
    if($a_modificar[$i]['nome']!=""){

        $data['id'] = $a_modificar[$i]['id'];
        $data['nome'] = $a_modificar[$i]['nome'];
        $data['preco'] = $a_modificar[$i]['preco'];
        $data['disponivel'] = $a_modificar[$i]['disponivel'];
        $data['esta_em_promocao'] = $a_modificar[$i]['esta_em_promocao'];
        $data['preco_promocional'] = ($a_modificar[$i]['preco_promocional'] ? $a_modificar[$i]['preco_promocional'] : 0);
        $data['texto_promocao'] = ($a_modificar[$i]['texto_promocao'] ? $a_modificar[$i]['texto_promocao'] : "");
        $data['qtd_produto_adicional'] = ($a_modificar[$i]['qtd_produto_adicional'] ? $a_modificar[$i]['qtd_produto_adicional'] : 0);
        $data['descricao'] = $a_modificar[$i]['descricao'];
        $data['codigo'] = $a_modificar[$i]['codigo'];
        $data['tamanho'] = ($a_modificar[$i]['tamanho'] ? $a_modificar[$i]['tamanho'] : "");
        $data['imagem'] = ($a_modificar[$i]['tamanho'] ? $a_modificar[$i]['tamanho'] : "");
        $data['restaurante_id'] = $gerente->restaurante_id;
        $data['ativo'] = $a_modificar[$i]['ativo'];
        $data['destaque'] = ($a_modificar[$i]['destaque'] ? $a_modificar[$i]['destaque'] : "");
        $data['aceita_segundo_sabor'] = $a_modificar[$i]['aceita_segundo_sabor'];

        $obj = Produto::find($data['id']);

        $obj->update_attributes($data);
    }
}


//header("location: ../../edita_cardapio");
?>