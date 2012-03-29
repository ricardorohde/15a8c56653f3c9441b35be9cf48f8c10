<?
        include_once("../../php/lib/config.php");
        
        $pedido = Pedido::find($_SESSION['conf_pedido']);   
        $restaurante = Restaurante::find($pedido->restaurante_id);
        
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

                        <img src="background/update.png" width="16" height="16" title="Atualizar" style="margin-left:4px; cursor:pointer;">
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
                            <? if(($pedido->situacao=="pedido_preparacao")||($pedido->situacao=="pedido_concluido")||($pedido->situacao=="cancelado")){ ?>
                                <img src="background/fine.png" width="40" height="38" style="margin-top:6px;">
                            <? }else{ ?>
                                <img src="background/wait.png" width="40" height="38" style="margin-top:6px;">
                            <? } ?>    
                        </div>
                        <div class="descricao_status">
                            Pedido recebido pelo restaurante
                        </div>
                    </div>
                    <div class="espaco_status radios_5">
                        <div class="box_status" style="padding:0 85px;">
                            <? if(($pedido->situacao=="pedido_concluido")||($pedido->situacao=="cancelado")){ ?>
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
                        <td style="color:#E51B21"><?= StringUtil::doubleToCurrency($pedido->getTotal() + $pedido->preco_entrega) ?></td>
                        <td style="color:#E51B21"><?= 
                                        $sit = "";
                                        switch($pedido->situacao){
                                            case "novo_pedido": $sit="Aguardando restaurante"; break;
                                            case "pedido_preparacao": $sit="Pedido em peparo"; break;
                                            case "pedido_concluido": $sit="Conclu&iacute;do"; break;   
                                            case "cancelado": $sit="Cancelado"; break;    
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
