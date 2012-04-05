<?php
    include_once("../lib/config.php");
    include("../lib/connect_p.php");
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
        //$usu['tipo'] = 4;
        //$usu['nome'] = $_POST['nome'];
        //$usu['email'] = $_POST['login'];
        //$usu['senha'] = md5($_POST['senha']);
        
        //$u = new Usuario($usu);
        //$u->save();
/*
        $con['nome'] = $_POST['nome'];
        $con['email'] = $_POST['login'];
        $con['senha'] = $_POST['senha'];
      
        $con['usuario_id'] = $u->id;
        $con['ativo'] = 1;
        $con['cpf'] = $_POST['cpf'];
        $con['data_nascimento'] = $_POST['diaNascimento']."/".$_POST['mesNascimento']."/".$_POST['anoNascimento'];
        $con['sexo'] = $_POST['sexo'];

        $c = new Consumidor($con);
        $c->save($con);
        
        $usuario_obj = $c;*/
        
        unset($_SESSION['aguardando']);
        $ag['nome'] = $_POST['nome'];
        $ag['login'] = $_POST['login'];
        $ag['loginconf'] = $_POST['loginconf'];
        $ag['cpf'] = $_POST['cpf'];
        $ag['sexo'] = $_POST['sexo'];
        $ag['dia'] = $_POST['diaNascimento'];
        $ag['mes'] = $_POST['mesNascimento'];
        $ag['ano'] = $_POST['anoNascimento'];
        $ag['telefone'] = $_POST['telefone'];
        $ag['celular'] = $_POST['celular'];
        $ag['numero'] = $_POST['numero'];
        $ag['complemento'] = $_POST['complemento'];
        $ag['referencia'] = $_POST['pr'];
        $_SESSION['aguardando'] = serialize($ag);
        
        
        connect(); 
        $nome = $_POST['nome'];
        $tipo = 4;
        $email = $_POST['login'];
        $senha = md5($_POST['senha']);
        
        $sql="SELECT * FROM usuario WHERE email='$email'";
        $sql=mysql_query($sql);
        $sql=mysql_fetch_array($sql);
        if($sql['id']){     
            HttpUtil::redirect("../../cadastro?ja=1");
        }else{
        
            $sql="INSERT INTO usuario (tipo,nome,email,senha) VALUES ('$tipo','$nome','$email','$senha')";
            mysql_query($sql);

            $usuario_id = mysql_insert_id();
            $ativo=1;
            $cpf=$_POST['cpf'];
            $data_nascimento=$_POST['diaNascimento']."/".$_POST['mesNascimento']."/".$_POST['anoNascimento'];
            $sexo=$_POST['sexo'];

            $sql="INSERT INTO consumidor (usuario_id,ativo,cpf,data_nascimento,sexo) VALUES ('$usuario_id','$ativo','$cpf','$data_nascimento','$sexo')";
            mysql_query($sql);


            $idcon = mysql_insert_id();
            mysql_close();
            $usuario_obj=Consumidor::find($idcon);

            $end['consumidor_id'] = $usuario_obj->id;
            $end['complemento'] = $_POST['complemento'];
            $end['numero'] = $_POST['numero'];
            $end['referencia'] = $_POST['pr'];

            $end['cep'] = $endereco->cep;
            $end['bairro_id'] = $endereco->bairro_id;
            $end['logradouro'] = $endereco->logradouro;

            $enderecoConsumidor = new EnderecoConsumidor($end);
            $enderecoConsumidor->save();

            $tel['consumidor_id'] = $usuario_obj->id;
            $tel['numero'] = $_POST['telefone'];

            if($_POST['telefone']){
                $telefone = new TelefoneConsumidor($tel);
                $telefone->save();
            }
            
            $tel['numero'] = $_POST['celular'];
            
            if($_POST['celular']){
                $telefone = new TelefoneConsumidor($tel);
                $telefone->save();
            }
        }
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
