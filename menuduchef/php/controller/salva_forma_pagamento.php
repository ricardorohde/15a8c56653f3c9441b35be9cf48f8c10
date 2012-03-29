<?php
    include_once("../lib/config.php");
    ob_start();

    $usuario_obj = unserialize($_SESSION['usuario_obj']);    
    $pedido = Pedido::find($_SESSION['pedido_id']);
    $formapag = FormaPagamento::find($_POST['forma_pagamento']);
    
    if($formapag->nome=="Dinheiro"){
        $data['troco'] = $_POST['troco'];
        $data['forma_pagamento'] = $formapag->nome;
    }else{
        $data['nome_cartao'] = $_POST['nome_cartao'];
        $data['num_cartao'] = $_POST['num_cartao'];
        $data['validade_cartao'] = $_POST['validade_cartao'];
        $data['cod_seguranca_cartao'] = $_POST['cod_seguranca_cartao'];
        $data['forma_pagamento'] = $formapag->nome;
    }
    $data['situacao'] = "novo_pedido";
    $data['quando'] = date('Y-m-d H:i:s');
    $pedido->update_attributes($data);
    
   HttpUtil::redirect("../../concluir?ped=".$_SESSION['pedido_id']);
?>
