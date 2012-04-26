<?php
    include_once("../lib/config.php");
    ob_start();
    
    function random_string($l){
        $c = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        for($i=0;$i<$l;$i++) $s .= $c{rand(0,strlen($c)-1)};
        return str_shuffle($s);
    }

    
        $email=Usuario::find_by_email($_POST['email_nova_senha']);
        if($email){
            
            $senha = random_string(8);
            $data['senha'] = md5($senha);
            
            $email->update_attributes($data);
            
            $corpo .= "Ol&aacute;, voc&ecirc; solicitou uma mudan&ccedil;a de senha no Delivery du Chef, ent&atilde;o uma nova senha foi gerada pelo sistema.<br/> Sua nova senha &eacute;: ".$senha." <br/>"; 
            $corpo .= "<br/>Ap&oacute;s logar, voc&ecirc; poder&aacute; trocar essa senha por uma nova &agrave; sua escolha.  <br/>";
            $corpo .= "<br/><br/>Atenciosamente,<br/>";
            $corpo .= "<br/>Equipe Delivery du Chef";
            
            $headers = "Content-type: text/html; charset=utf-8\r\n";
            $headers .= "From: Delivery du Chef <noreply@deliveryduchef.com.br> \r\n";
            $headers .= "Return-Path: Delivery du Chef <noreply@deliveryduchef.com.br> \n";

            mail($email->email,"Nova Senha - Delivery du Chef",$corpo,$headers);
            HttpUtil::redirect("../../".$_POST['volta']."?e=14");
        }else{    
            HttpUtil::redirect("../../".$_POST['volta']."?e=13"); 
        }

    
  
?>