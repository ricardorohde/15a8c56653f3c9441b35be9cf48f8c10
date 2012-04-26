<?php
    include_once("../lib/config.php");
    include("../lib/connect_p.php");
    ob_start();
    
    $da = HttpUtil::getParameterArray2();

    $usuario_obj = unserialize($_SESSION['usuario_obj']);
    
    connect();    
    if($_POST['action3']=="novoendereco"){ //se o que vem sao dados sobre um novo endereco

        $end['consumidor_id'] = $usuario_obj->id;
        $end['complemento'] = $da['complemento'];
        $end['numero'] = $_POST['numero'];
        $end['referencia'] = $da['referencia'];
        
        $_POST['cep'] = explode("-",$_POST['cep']);
        $_POST['cep'] = implode("",$_POST['cep']);
        $dadosend=EnderecoCep::find_by_cep($_POST['cep']);
        $end['cep'] = $_POST['cep'];
        $end['bairro_id'] = $dadosend->bairro_id;
        $end['logradouro'] = $dadosend->logradouro;

        $enderecoConsumidor = new EnderecoConsumidor($end);
        $enderecoConsumidor->save();
    }else if($_POST['action2']=="deletaendereco"){       
        $endalvo=EnderecoConsumidor::find(array("conditions"=>array("consumidor_id = ? AND id = ?",$usuario_obj->id,$_POST['end_alvo'])));
        if($endalvo){
            $endalvo->delete();
        }
    }else if($_POST['action2']=="favendereco"){
        $ends==EnderecoConsumidor::all(array("conditions"=>array("consumidor_id = ?",$usuario_obj->id)));
        if($ends){
            $data['favorito'] = 0;
            foreach($ends as $end){
                $end->update_attributes($data);
            }
        }
        $endalvo=EnderecoConsumidor::find(array("conditions"=>array("consumidor_id = ? AND id = ?",$usuario_obj->id,$_POST['favorito'])));
        if($endalvo){
            $data['favorito'] = 1;
            $endalvo->update_attributes($data);
        }
    }else if($_POST['action']=="usuario"){ //se o que vem sao dados sobre o usuario

        $ag['nome'] = $da['nome'];
        $ag['cpf'] = $_POST['cpf'];
        $ag['sexo'] = $_POST['sexo'];
        $ag['dia'] = $_POST['diaNascimento'];
        $ag['mes'] = $_POST['mesNascimento'];
        $ag['ano'] = $_POST['anoNascimento'];
        
       
        
        
        $nome = filtrar_caracteres_malignos($da['nome']);
        
        $senha = 0;
        if($_POST['mudar_senha']){
            $senha = md5(filtrar_caracteres_malignos($_POST['senha']));
        }
        
        
        $sql="SELECT * FROM usuario WHERE id='".$usuario_obj->usuario_id."'";
        $sql=mysql_query($sql);
        $sql=mysql_fetch_array($sql);
        if($sql['id']){
        
            if($senha){
                $sql="UPDATE usuario SET nome = '$nome', senha = '$senha' WHERE id = '".$sql['id']."'";
            }else{
                $sql="UPDATE usuario SET nome = '$nome' WHERE id = '".$sql['id']."'";
            }
         
            mysql_query($sql);

            $cpf=filtrar_caracteres_malignos($_POST['cpf']);
            $data_nascimento=filtrar_caracteres_malignos($_POST['diaNascimento'])."/".filtrar_caracteres_malignos($_POST['mesNascimento'])."/".filtrar_caracteres_malignos($_POST['anoNascimento']);
            $sexo=filtrar_caracteres_malignos($_POST['sexo']);

            $sql="UPDATE consumidor SET cpf = '$cpf', data_nascimento = '$data_nascimento', sexo = '$sexo' WHERE id = '".$usuario_obj->id."'";
            //echo $sql;
            mysql_query($sql);

            
            foreach($_POST as $key=>$valor){
                $quebra = explode("_",$key);
                $valor = filtrar_caracteres_malignos($valor);
                if($quebra[0]=="telefone"){
                    if($quebra[1]=="ativo"){
                        if($valor==0){
                            $sql="DELETE FROM telefone_consumidor WHERE consumidor_id = '".$usuario_obj->id."' AND id = ".$quebra[2];
                            mysql_query($sql);
                        }else{
                            $num = filtrar_caracteres_malignos($_POST['telefone_'.$quebra[2]]);
                            $sql="UPDATE telefone_consumidor SET numero = '".$num."' WHERE consumidor_id = '".$usuario_obj->id."' AND id = ".$quebra[2];
                            mysql_query($sql);
                        }
                    }
                }else if($quebra[0]=="novotelefone"){
                    if($valor!=""){
                            $sql="INSERT INTO telefone_consumidor (consumidor_id,numero) VALUES ('".$usuario_obj->id."','$valor')";
                            mysql_query($sql);
                    }
                }
            }
            
            
            
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
            
            $usuario_obj=Consumidor::find($usuario_obj->id);
            $_SESSION['sessao_valida'] = 1;
            $_SESSION['usuario_obj'] = serialize($usuario_obj);
            $_SESSION['consumidor_id'] = $usuario_obj->id;
            
        }
    } 
    mysql_close();
    
    

    
    
  HttpUtil::redirect("../../usuario");
?>