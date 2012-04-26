<?php
    include_once("../lib/config.php");
    ob_start();

    function mascara($x){
        $quebra = explode(".",$x);
        $x = implode("",$quebra);
        $quebra = explode(",",$x);
        $centavos = $quebra[1];
        $real = $quebra[0];
        $quebra = explode(".",$real);
        $real = implode("",$quebra);
        $x = $real.".".$centavos;

        return $x;
    }
    
    $usuario_obj = unserialize($_SESSION['usuario_obj']);    
    $pedido = Pedido::find($_SESSION['pedido_id']);
    $formapag = FormaPagamento::find($_POST['forma_pagamento']);
    
    if($formapag->nome=="Dinheiro"){
        $data['troco'] = mascara($_POST['troco']);
        $data['forma_pagamento'] = $formapag->nome;
    }else{
        $data['nome_cartao'] = $_POST['nome_cartao'];
        $data['num_cartao'] = $_POST['num_cartao'];
        $data['validade_cartao'] = $_POST['validade_cartao'];
        $data['cod_seguranca_cartao'] = $_POST['cod_seguranca_cartao'];
        $data['forma_pagamento'] = $formapag->nome;
    }
    $data['situacao'] = Pedido::$NOVO;
    $data['quando'] = date('Y-m-d H:i:s');
    $pedido->update_attributes($data);
    
   HttpUtil::redirect("../../concluir?ped=".$_SESSION['pedido_id']);
?>
