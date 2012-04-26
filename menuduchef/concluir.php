<?
    include("include/header.php");
    
    unset($_SESSION['pedido_id']);

    $usuario_obj = unserialize($_SESSION['usuario_obj']);
    $pedido = Pedido::find($_GET['ped']);
    $_SESSION['conf_pedido'] = $_GET['ped']; //esta variavel serve para o php/controller/confere_situacao_pedido saber de qual pedido se trata
    $restaurante = Restaurante::find($pedido->restaurante_id);
    $rxb = RestauranteAtendeBairro::find(array("conditions"=>array("restaurante_id = ? AND bairro_id = ?",$restaurante->id,$pedido->endereco_consumidor->bairro_id)));
    
    if($pedido->consumidor_id==$usuario_obj->id){
        
?>
<meta http-equiv="content-type" content="text/html" charset="UTF-8" />  

   <link rel="stylesheet" href="css_/blueprint/screen.css" type="text/css" media="screen, projection">
   <link rel="stylesheet" href="css_/blueprint/print.css" type="text/css" media="print">  
   <link rel="stylesheet" href="css_/estilo.css" type="text/css" media="screen"> 
   <!--[if lt IE 8]><link rel="stylesheet" href="css_/blueprint/ie.css" type="text/css" media="screen, projection"><![endif]-->
   <script src="js/jquery-1.6.4.min.js"></script>
   <script>
    var minut = 10;

    function append() {           
            minut--;
            if(minut<0){
                    $("#div_situacao_pedido").load("php/controller/confere_situacao_pedido");
            }
    }
    setInterval('append()', 1000);
</script>
<div class="container">
	<div id="background_container">
    	<?php if($_SESSION['usuario']){
        include "menu_user.php";
    }else{
        include "menu2.php"; 
    } ?>
        <div id="central" class="span-24">
			<div class="span-6">
            	<div id="barra_esquerda">
                	<div id="info_restaurante">
                    	<div id="categoria_rest"><?= $restaurante->getNomeCategoria() ?>
                        </div>
                        <div id="nome_rest"><?= $restaurante->nome ?>
                        </div>
                        <div id="avatar_rest">
                            <img src="images/restaurante/<?= $restaurante->imagem ?>">
                        </div>
                        
                        <div style="color:#E51B21; font:Arial; font-size:24px; display:inline;"><?= $restaurante->telefone ?>
                        </div>
                      <div id="tempo_entrega">Tempo de entrega:<img src="background/relogio.gif" width="20" height="19" style="position:relative; top:6px; left:4px;">&nbsp;&nbsp;&nbsp; <?= $rxb->tempo_entrega ?>min
                        </div>
                    </div>
                    
                    
                </div>
            </div>
            <div class="span-18 last">
            	
                    <div class="prepend-top" id="status">
                        <div id="numero_rest" style="color:#FFF" ><span style="margin-left:8px;"> </span>
                        </div> 
                        <div id="status_pedido">
                        	<img src="background/passo4.png" alt="passo1" width="541" height="43" border="0" usemap="#Map" >
<map name="Map" id="Map"><area shape="rect" coords="2,2,131,42" href="restaurantes" /></map>
                      </div>
              </div>
             <div id="div_situacao_pedido">      
                    <div id="titulo_box_destaque" >
                    Acompanhamento do pedido
                    </div>
                    <div class="titulo_box_concluir" style="margin-top:4px;">Obrigado por usar o Delivery du Chef
                    	<div style="display:inline; font:Arial; color:#E51B21; font-size:13px;">
                                <? 
                                    if($pedido->consumidor->sexo=="Feminino"){
                                        echo "Sra. ";
                                    }else{
                                        echo "Sr. ";
                                    }
                                    
                                    echo $pedido->consumidor->nome;
                                ?>
                                
                       		
                        </div>
					</div>
                    <div id="box_concluir">
                    	<div style="width:674px; height:68px;">
                            <div class="espaco_status radios_5">
                                <div class="box_status" style="padding:0 85px;">
                                    <img src="background/fine.png" width="40" height="38" style="margin-top:6px;">
                                </div>
                                <div class="descricao_status">
                                    Pedido enviado ao restaurante
                                </div>
                            </div>
                            <div class="espaco_status radios_5" style="margin:0 7px;">
                                <div class="box_status" style="padding:0 85px;">
                                    <? if(($pedido->situacao==Pedido::$PREPARACAO)||($pedido->situacao==Pedido::$CONCLUIDO)||($pedido->situacao==Pedido::$CANCELADO)){ ?>
                                        <img src="background/fine.png" width="40" height="38" style="margin-top:6px;">
                                    <? }else{ ?>
                                        <img src="background/Progresso.gif" width="40" height="38" style="margin-top:6px;">
                                    <? } ?>    
                                </div>
                                <div class="descricao_status">
                                    Pedido recebido pelo restaurante
                                </div>
                            </div>
                            <div class="espaco_status radios_5">
                                <div class="box_status" style="padding:0 85px;">
                                    <? if(($pedido->situacao==Pedido::$CONCLUIDO)||($pedido->situacao==Pedido::$CANCELADO)){ ?>
                                        <img src="background/fine.png" width="40" height="38" style="margin-top:6px;">
                                    <? }else{ ?>
                                        <img src="background/wait.png" width="40" height="38" style="margin-top:6px;">
                                    <? } ?>
                                </div>
                                <div class="descricao_status">
                                    Pedido entregue
                                </div>
                            </div>
                        </div>
                        <div style="margin-top:16px;">
                        <table style="width:674px; border:1px solid #bcbec0;">
                        	<tr><th style="padding-left:4px;">Pedido</th><th>Restaurante</th><th>Solicitado</th><th>Confirma&ccedil;&atilde;o</th><th>Valor</th><th>Situa&ccedil;&atilde;o</th></tr>
                            <tr><td style="padding-left:4px;"><?= $pedido->id ?></td>
                                <td><?= $restaurante->nome ?></td>
                                <td><? 
                                        $quando = explode(" ",$pedido->quando->format('H:i d/m/Y'));
                                        
                                        $dma = $quando[1];
                                        $hms = $quando[0];
                                        echo $dma." &agrave;s ".$hms;
                                        ?></td>
                                <td>
                                    <? 
                                        if($pedido->quando_confirmado){
                                            $quando = explode(" ",$pedido->quando_confirmado->format('H:i d/m/Y'));

                                            $dma = $quando[1];
                                            $hms = $quando[0];
                                            echo $dma." &agrave;s ".$hms;
                                        }else{
                                            echo "Em aguardo...";
                                        }
                                        ?>
                                </td>
                                <td style="color:#E51B21">
                                        <? 
                                            if($pedido->cupom->valor){
                                                $desconto = $pedido->cupom->valor;
                                            }else{
                                                $desconto = 0;
                                            }
                                            $total = $pedido->getTotal();
                                            $total -= $desconto;
                                            if($total<0){
                                                $total=0;
                                            } ?>
                                        <?= StringUtil::doubleToCurrency($total + $pedido->preco_entrega) ?></td>
                                <td style="color:#E51B21"><?= 
                                                $sit = "";
                                                switch($pedido->situacao){
                                                    case Pedido::$NOVO: $sit="Aguardando restaurante"; break;
                                                    case Pedido::$PREPARACAO: $sit="Pedido em peparo"; break;
                                                    case Pedido::$CONCLUIDO: $sit="Conclu&iacute;do"; break;   
                                                    case Pedido::$CANCELADO: $sit="Cancelado"; break;    
                                                }
                                                echo $sit; 
                                                ?></td></tr>
                        </table>
                        </div>       
                       
                        <div style="width:330px; float:left;"> 
                            <table>
                                <tr><td style="width:330px; height:43px; background:#e5ecf9; border:1px solid #c5ccf9; padding-left:4px;">Para qualquer informa&ccedil;&atilde;o adicional voc&ecirc; pode entrar em contato diretamente com o <b><?= $restaurante->nome ?></b> no telefone ao lado.</td></tr>
                                <tr style="height:10px;"></tr>
                                <tr><td style="width:330px; background:#e5ecf9; border:1px solid #c5ccf9; padding-left:4px;">Lembramos que todas solicita&ccedil;&otilde;es e contatos do Delivery du Chef ser&atilde;o enviadas para o e-mail <?= $pedido->consumidor->email ?>.<br/><br/><b>Se voc&ecirc; possui sistema anti-spam em sua caixa postal, favor desativ&aacute;-lo para os endere&ccedil;os @deliveryduchef.com.br.</td><tr>
                            </table>
                            <img src="background/takefriend.png" width="330" height="50">
                        	<div style="font:Arial; color:#E51B21; font-size:11px; margin-top:4px;">
                            	<u>O cupom de avalia&ccedil;&atilde;o de pedido chegar&aacute; na sua caixa de e-mail ou clique aqui e avalie agora.</u>
                            </div>
                        </div>
                    </div>
             </div>                          
            </div>
            
		</div>
	</div>
</div>
<? 
    }
include("include/footer.php"); 
?>