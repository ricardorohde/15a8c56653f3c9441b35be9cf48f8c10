<?php
ob_start();
session_start();
include("../../include/header2.php");

$ultimo_criar = -1;
$ultimo_modificar = -1;
$categoria_criar = 0;
$ccriar = 0;
$cmodificar = 0;
$gerente = unserialize($_SESSION['usuario_obj']);


foreach($_POST as $key => $valor){
    
    $pre = explode("!",$key);
    if($pre[0]=="categoria"){
 
        $pos = explode("-",$pre[1]);
        $idtip = $pos[1];
        if($pos[0]=="ativa"){
            if($valor==1){
                $obj = RestauranteTemTipoProduto::find(array("conditions"=>array("restaurante_id = ? AND tipoproduto_id = ?",$gerente->restaurante_id,$idtip)));
                $obj->delete();
            }
        }else if(($pos[0]=="ordem")&&($valor!=-1)){
            $data3['ordem'] = $valor;
            $obj = RestauranteTemTipoProduto::find(array("conditions"=>array("restaurante_id = ? AND tipoproduto_id = ?",$gerente->restaurante_id,$idtip)));
            $obj->update_attributes($data3);
        }
        
    }
    else if($pre[0]=="novacategoria"){
        
        $pos = explode("-",$key);
        $po = explode("!",$pos[0]);

        $categoria_a_criar[$po[1]] = $valor;
        
        $categoria_criar++;
    }
    else if($pre[0]=="novoproduto"){

        $pos = explode("-",$key);
        $po = explode("!",$pos[0]);
        
        if($po[1]=='adicional'){
            $fila_criar_adicionais[$pos[1]] = 1;
        }
        
        $a_criar[$po[1]] = $valor;
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

if($categoria_criar){
    unset($data);
    if($categoria_a_criar['nome']!=""){
        $verifica = TipoProduto::find(array("conditions"=>array("nome = ?",$categoria_a_criar['nome'])));
        if($verifica){
            $idtip = $verifica->id;
            $verifica = RestauranteTemTipoProduto::find(array("conditions"=>array("tipoproduto_id = ? AND restaurante_id = ?",$idtip,$gerente->restaurante_id)));
            if($verifica){
                //nada acontece
            }else{
                $data['tipoproduto_id'] = $idtip;
                $data['restaurante_id'] = $gerente->restaurante_id;
                $data['ordem'] = $categoria_a_criar['ordem'];
                
                $obj = new RestauranteTemTipoProduto($data);
                $obj->save();
            }
        }else{
            $data['nome'] = $categoria_a_criar['nome'];
            $obj = new TipoProduto($data);
            $obj->save();
           
            
            $data2['tipoproduto_id'] = $obj->id;
            $data2['restaurante_id'] = $gerente->restaurante_id;
            $data2['ordem'] = $categoria_a_criar['ordem'];
            
            $obj = new RestauranteTemTipoProduto($data2);
            $obj->save();
        }
    }
}
else if($ccriar){
    
    unset($data);
    if($a_criar['nome']!=""){

        $data['nome'] = $a_criar['nome'];
        $data['preco'] = $a_criar['preco'];
        $data['disponivel'] = $a_criar['disponivel'];
        $data['esta_em_promocao'] = $a_criar['esta_em_promocao'];
        $data['preco_promocional'] = ($a_criar['preco_promocional'] ? $a_criar['preco_promocional'] : 0);
        $data['texto_promocao'] = ($a_criar['texto_promocao'] ? $a_criar['texto_promocao'] : "");
        $data['qtd_produto_adicional'] = ($a_criar['qtd_produto_adicional'] ? $a_criar['qtd_produto_adicional'] : 0);
        $data['descricao'] = $a_criar['descricao'];
        $data['codigo'] = $a_criar['codigo'];
        $data['tamanho'] = ($a_criar['tamanho'] ? $a_criar['tamanho'] : "");
        $data['imagem'] = ($a_criar['tamanho'] ? $a_criar['tamanho'] : "");
        $data['restaurante_id'] = $gerente->restaurante_id;
        $data['ativo'] = $a_criar['ativo'];
        $data['destaque'] = ($a_criar['destaque'] ? $a_criar['destaque'] : "");
        $data['aceita_segundo_sabor'] = $a_criar['aceita_segundo_sabor'];
        $data['ordem'] = $a_criar['ordem'];

        $obj = new Produto($data);
        $obj->save();

        $idpro = $obj->id;
        $idtip = $a_criar['categoria'];
        
        $data2['produto_id'] = $idpro;
        $data2['tipoproduto_id'] = $idtip;
        
        $obj = new ProdutoTemTipo($data2);
        $obj->save();
        
        $id = $idpro;
        
        $adis = ProdutoAdicional::all(array("conditions"=>array("restaurante_id = ?",$gerente->restaurante_id)));
        foreach($adis as $adi){

            if(isset($fila_criar_adicionais[$adi->id])){

                $data4['produto_id'] = $id;
                $data4['produtoadicional_id'] = $adi->id;

                $obj = new ProdutoTemProdutoAdicional($data4);
                $obj->save();
                
            }
        }

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


header("location: ../../gerente_cardapio");
?>