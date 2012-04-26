<?php
ob_start();
session_start();
include("../../include/header2.php");
include_once("../lib/connect_p.php");

$ultimo_criar = -1;
$ultimo_modificar = -1;
$categoria_criar = 0;
$ccriar = 0;
$cmodificar = 0;
$gerente = unserialize($_SESSION['usuario_obj']);

$da = HttpUtil::getParameterArray2();
connect();

if($da['action']=='novofuncionario'){
    $tipo = filtrar_caracteres_malignos($da['novotipo']);
    if($tipo!=2){
        $tipo=3;
    }
    $nome = filtrar_caracteres_malignos($da['novonome']);
    $email = filtrar_caracteres_malignos($da['novoemail']);
    $senha = md5(filtrar_caracteres_malignos($da['novasenha']));
    
    $sql="SELECT * FROM usuario WHERE email = '$email'";
    $sql=mysql_query($sql);
    $sql=mysql_fetch_array($sql);
    if($sql['id']){
        HttpUtil::redirect("../../controle_atendimento?ja=1");
    }else{
        $sql="INSERT INTO usuario (tipo,nome,email,senha) VALUES ('$tipo','$nome','$email','$senha')";
        mysql_query($sql);
        
        $rest = $gerente->restaurante_id;
        $usu = mysql_insert_id();
        
        $sql="INSERT INTO usuario_restaurante (restaurante_id,usuario_id) VALUES ('$rest','$usu')";
        mysql_query($sql);
    }
}else if($da['action']=='alteracoes'){
    foreach($da as $key=>$valor){
        $quebra = explode("-",$key);
        if($quebra[0]=="idfun"){

            $id = $quebra[1];
            
            $conf=UsuarioRestaurante::find($id);
            if($conf){
                if($da['ativo-'.$id]==0){

                    if($conf->usuario->tipo==3){
                        $conf->usuario->delete();
                    }
                }else{
                    $pode = 0;
                    if($conf->usuario->tipo==3){
                        $pode = 1;
                    }else if($conf->id==$gerente->id){
                        $pode = 1;
                    }
                    if($pode){
                        $dados['nome'] = $da['nome-'.$id];
                        $dados['email'] = $da['email-'.$id];
                        if($da['mudarsenha-'.$id]==true){
                            $dados['senha'] = md5($da['senha-'.$id]);
                        }
                        $conf->usuario->update_attributes($dados);
                    }
                }
            }
        }
    }
}
mysql_close();


header("location: ../../controle_atendimento");
?>