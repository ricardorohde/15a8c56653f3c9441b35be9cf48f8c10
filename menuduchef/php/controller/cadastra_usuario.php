<?php
    include_once("../lib/config.php");
    include("../lib/connect_p.php");
    ob_start();
    
    $da = HttpUtil::getParameterArray2();

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
    $ag['como_conheceu'] = $_POST['como_conheceu'];
    
    $ag['cep'] = $_POST['cep'];
    $ag['cidade'] = $_POST['cidade'];
    $ag['estado'] = $_POST['estado'];
    $ag['bairro'] = $_POST['bairro'];
    $ag['endereco'] = $_POST['endereco'];
    
    $ag['numero'] = $_POST['numero'];
    $ag['complemento'] = $_POST['complemento'];
    $ag['referencia'] = $_POST['pr'];
    $_SESSION['aguardando'] = serialize($ag);
    
    connect(); 
        $nome = filtrar_caracteres_malignos($da['nome']);
        $tipo = 4;
        $email = filtrar_caracteres_malignos($_POST['login']);
        $senha = md5(filtrar_caracteres_malignos($_POST['senha']));
        
        $sql="SELECT * FROM usuario WHERE email='$email'";
        $sql=mysql_query($sql);
        $sql=mysql_fetch_array($sql);
        
        $sem_end = 0;
        $_POST['cep'] = explode("-",$_POST['cep']);
        $_POST['cep'] = implode("",$_POST['cep']);
        $dadosend=EnderecoCep::find_by_cep($_POST['cep']);
        if($dadosend){
            //nao acontece nada, tudo bem
        }else{
            $sem_end = 1;
        }

        if($sql['id']){  
            HttpUtil::redirect("../../cadastro_usuario?e=1");
        }else if($sem_end){
            HttpUtil::redirect("../../cadastro_usuario?e=2");
        }else{
        
            $sql="INSERT INTO usuario (tipo,nome,email,senha) VALUES ('$tipo','$nome','$email','$senha')";
            mysql_query($sql);

            $usuario_id = mysql_insert_id();
            $ativo=1;
            $cpf=filtrar_caracteres_malignos($_POST['cpf']);
            $data_nascimento=filtrar_caracteres_malignos($_POST['diaNascimento'])."/".filtrar_caracteres_malignos($_POST['mesNascimento'])."/".filtrar_caracteres_malignos($_POST['anoNascimento']);
            $sexo=filtrar_caracteres_malignos($_POST['sexo']);
            $como_conheceu=filtrar_caracteres_malignos($_POST['como_conheceu']);

            $sql="INSERT INTO consumidor (usuario_id,ativo,cpf,data_nascimento,sexo,como_conheceu) VALUES ('$usuario_id','$ativo','$cpf','$data_nascimento','$sexo','$como_conheceu')";
            mysql_query($sql);

            $idcon = mysql_insert_id();
            mysql_close();
            $usuario_obj=Consumidor::find($idcon);
            $_SESSION['usuario_obj'] = serialize($usuario_obj);

            $end['consumidor_id'] = $usuario_obj->id;
            $end['complemento'] = $da['complemento'];
            $end['numero'] = $_POST['numero'];
            $end['referencia'] = $da['pr'];
            $end['favorito'] = 1;
            
            
            $end['cep'] = $_POST['cep'];
            $end['bairro_id'] = $dadosend->bairro_id;
            $end['logradouro'] = $dadosend->logradouro;

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
            
            $usuario = Usuario::login($email, $senha);
            
            $_SESSION['sessao_valida'] = 1;
            $_SESSION['consumidor_id'] = $usuario_obj->id;
            $_SESSION['usuario'] = serialize($usuario);
            $_SESSION['usuario_obj'] = serialize($usuario_obj);
        }    
    mysql_close();
    $_SESSION['endereco'] = serialize($enderecoConsumidor);
    
    HttpUtil::redirect("../../restaurantes");
         
?>
