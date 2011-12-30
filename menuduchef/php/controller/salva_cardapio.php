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
    
    $pre = explode("!",$key);
    if($pre[0]=="categoria"){
        
    }
    else if($pre[0]=="novacategoria"){
        
    }
    else if($pre[0]=="novoproduto"){
        $pos = explode("-",$key);
        $po = explode("!",$pos[0]);
        
        $a_criar[$pos[1]][$po[1]] = $valor;
        $ccriar++;

    }else if($pre[0]=="produto"){
        $pos = explode("-",$key);
        $po = explode("!",$pos[0]);

        if($po[1]=='adicional'){
            $fila_adicionais[$pos[2]][$pos[1]] = 1;
        }else{
            $a_modificar[$pos[1]][$po[1]] = $valor;
            if($ultimo_modificar!=$pos[1]){
                $ultimo_modificar=$pos[1];
                $fila_modificar[$cmodificar] = $pos[1];
                $cmodificar++;
            }
        }
    }
}

if($ccriar){
    unset($data);
    $i=0;
    if($a_criar[$i]['novo_nome']!=""){

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
        $data['ordem'] = $a_modificar[$i]['ordem'];

        $obj = new Produto($data);
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
        $data['ordem'] = $a_modificar[$i]['ordem'];

        $obj = Produto::find($data['id']);

        $obj->update_attributes($data);
        
        $adis = ProdutoAdicional::all(array("conditions"=>array("restaurante_id = ?",$gerente->restaurante_id)));
        foreach($adis as $adi){
            $what = ProdutoTemProdutoAdicional::find(array("conditions"=>array("produto_id = ? AND produtoadicional_id = ?",$data['id'],$adi->id)));
            
            if(isset($fila_adicionais[$data['id']][$adi->id])){

                if($what){
                    //nao acontece nada, pois ja existe essa relação
                }else{
                    $data2['produto_id'] = $data['id'];
                    $data2['produtoadicional_id'] = $adi->id;
                    
                    $obj = new ProdutoTemProdutoAdicional($data2);
                    $obj->save();
                }
            }else{

                if($what){
                    $what->delete();
                }else{
                    //nao acontece nada, pois ja nao existia essa relação
                }
            }
        }
    }
}


header("location: ../../edita_cardapio");
?>