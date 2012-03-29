<?php
    include_once("../lib/config.php");
    ob_start();

    $usuario_obj = unserialize($_SESSION['usuario_obj']);
    $endereco = unserialize($_SESSION['endereco']);
    if($_POST['action']=="novo"){ //se o endereco já existia na lista do usuario
        $end['consumidor_id'] = $usuario_obj->id;
        $end['complemento'] = $_POST['complemento'];
        $end['numero'] = $_POST['numero'];
        $end['referencia'] = $_POST['referencia'];
        
        $end['cep'] = $endereco->cep;
        $end['bairro_id'] = $endereco->bairro_id;
        $end['logradouro'] = $endereco->logradouro;

        $enderecoConsumidor = new EnderecoConsumidor($end);
        $enderecoConsumidor->save();
    }else if($_POST['action']=="sele"){ //se o endereco está sendo criado agora
        $enderecoConsumidor = EnderecoConsumidor::find($_POST['endereco_escolhido']);
    }else if($_POST['action2']=="novo_usuario"){ //se até o usuario está sendo criado só agora
        /*$usu['tipo'] = 4;
        $usu['nome'] = $_POST['nome'];
        $usu['email'] = $_POST['login'];
        $usu['senha'] = md5($_POST['senha']);
        
        $u = new Usuario($usu);
        $u->save();*/

        $con['nome'] = $_POST['nome'];
        $con['email'] = $_POST['login'];
        $con['senha'] = $_POST['senha'];
        
        //$con['usuario_id'] = $u->id;
        $con['ativo'] = 1;
        $con['cpf'] = $_POST['cpf'];
        $con['data_nascimento'] = $_POST['diaNascimento']."/".$_POST['mesNascimento']."/".$_POST['anoNascimento'];
        $con['sexo'] = $_POST['sexo'];

        $c = new Consumidor($con);
        $c->save($con);
        
        $usuario_obj = $c;
        
        $end['consumidor_id'] = $usuario_obj->id;
        $end['complemento'] = $_POST['complemento'];
        $end['numero'] = $_POST['numero'];
        $end['referencia'] = $_POST['pr'];
        
        $end['cep'] = $endereco->cep;
        $end['bairro_id'] = $endereco->bairro_id;
        $end['logradouro'] = $endereco->logradouro;

        $enderecoConsumidor = new EnderecoConsumidor($end);
        $enderecoConsumidor->save();
    }
    
    $_SESSION['endereco'] = serialize($enderecoConsumidor);
    
    
    $pedido = unserialize($_SESSION["pedido_aguardando"]);
    $pedido['consumidor_id'] = $usuario_obj->id;
    $pedido['endereco_id'] = $enderecoConsumidor->id;

    $ped = new Pedido($pedido);
    $ped->save();

    $_SESSION['pedido_id'] = $ped->id;

    if($_SESSION['produto_aguardando'][0]){
        for($i=0;$i<sizeof($_SESSION['produto_aguardando']);$i++){
            $produto = unserialize($_SESSION['produto_aguardando'][$i]);
            $produto["pedido_id"] = $ped->id;
            $prod = new PedidoTemProduto($produto);
            $prod->save();
            
            if($_SESSION['produto_adicional_aguardando'][$i][0]){
                for($j=0;$j<sizeof($_SESSION['produto_adicional_aguardando'][$i]);$j++){
                    $produtoa = unserialize($_SESSION['produto_adicional_aguardando'][$i][$j]);
                    $produtoa['pedidotemproduto_id'] = $prod->id;

                    $proda = new PedidoTemProdutoAdicional($produtoa);
                    $proda->save();
                }
            }
        }
    }

    
    
   HttpUtil::redirect("../../pagamento");
?>
