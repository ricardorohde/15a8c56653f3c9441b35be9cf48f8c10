<?
        include_once("../../php/lib/config.php");
        
        $pedido = Pedido::find($_SESSION['conf_pedido']);   
        $restaurante = Restaurante::find($pedido->restaurante_id);
        
        $hora_atual = date("U");
        if(($hora_atual - $restaurante->online)>30){
            if($pedido->situacao=="novo_pedido"){
                $pedatu['situacao'] = "cancelado";
                $pedatu['texto_cancelamento'] = "systemautomsg#!#O pedido foi cancelado, pois o restaurante est&aacute; fora do ar.";
                $pedido->update_attributes($pedatu);
                
                echo "<script>alert('O pedido foi cancelado, pois o restaurante est\u00e1 fora do ar.')</script>";
            }
        }
        
        ?>
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
                            <? if(($pedido->situacao==Pedido::$PREPARACAO)||($pedido->situacao==Pedido::$CONCLUIDO)||($pedido->situacao==Pedido::$CANCELADO&&$pedido->quando_confirmado)){ ?>
                                <img src="background/fine.png" width="40" height="38" style="margin-top:6px;">
                            <? }else if($pedido->situacao==Pedido::$CANCELADO){ ?>
                                <img src="background/bad.png" width="40" height="38" style="margin-top:6px;">   
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
                            <? if($pedido->situacao==Pedido::$CONCLUIDO){ ?>
                                <img src="background/fine.png" width="40" height="38" style="margin-top:6px;">
                            <? }else if($pedido->situacao==Pedido::$CANCELADO){ ?>
                                <img src="background/bad.png" width="40" height="38" style="margin-top:6px;">
                            <?}else{ ?>
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
                                    if($pedido->situacao==Pedido::$CANCELADO){
                                        echo "Sem resposta do restaurante.";
                                    }else{
                                        echo "Em aguardo...";
                                    }
                                }
                                ?>
                        </td>
                        <td style="color:#E51B21"><?= StringUtil::doubleToCurrency($pedido->getTotal() + $pedido->preco_entrega) ?></td>
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
                        <tr><td style="width:330px; background:#e5ecf9; border:1px solid #c5ccf9; padding-left:4px;">Lembramos que todas solicita&ccedil;&otilde;es e contatos do Delivery du Chef ser&atilde;o enviadas para o e-mail <?= $pedido->consumidor->email ?>.<br/><br/><b>Se voc&ecirc; possui sistema anti-spam em sua caixa postal, favor desativa-lo para os endere&ccedil;os @deliveryduchef.com.br.</td><tr>
                    </table>
                    <img src="background/takefriend.png" width="330" height="50">
                        <div style="font:Arial; color:#E51B21; font-size:11px; margin-top:4px;">
                        <u>O cupom de avalia&ccedil;&atilde;o de pedido chegar&aacute; na sua caixa de e-mail ou clique aqui e avalie agora.</u>
                    </div>
                </div>
            </div>
