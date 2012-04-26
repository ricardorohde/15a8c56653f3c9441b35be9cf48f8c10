<?
    include("include/header.php");
    
    
    $pedido = Pedido::find($_SESSION['pedido_id']);
    $apaga_pagamento['troco'] = 0;
    $apaga_pagamento['forma_pagamento'] = "ainda_nao";
    $apaga_pagamento['nome_carta'] = NULL;
    $apaga_pagamento['num_cartao'] = NULL;
    $apaga_pagamento['validade_cartao'] = NULL;
    $apaga_pagamento['cod_seguranca_cartao'] = NULL;
    if($_SESSION['cupom_id']){
        $apaga_pagamento['cupom_id'] = $_SESSION['cupom_id'];
        $cupom=Cupom::find($_SESSION['cupom_id']);
        if($cupom){
            $atucup['pedido_id'] = $_SESSION['pedido_id'];
            $cupom->update_attributes($atucup);
        }
    }
    $pedido->update_attributes($apaga_pagamento);
    
    $restaurante = Restaurante::find($pedido->restaurante_id);
    $endcon=EnderecoConsumidor::find($pedido->endereco_id);
    $telefones = TelefoneConsumidor::all(array("conditions"=>array("consumidor_id = ?",$pedido->consumidor_id)));
    $rxb = RestauranteAtendeBairro::find(array("conditions"=>array("restaurante_id = ? AND bairro_id = ?",$pedido->restaurante_id,$endcon->bairro_id)));
    $cuidado_apertar_minha_conta = 1;
?>
<script>
    $(function() {
        $(".select_pag").click(function(){
            qual = $(this).attr("id");
            $(".aux_select_pag").each(function(){
                $(this).hide();
            });
            
            $("#aux_"+qual).show();
        });
        $("#confirma_pagamento").click(function(){
            ok = 0;
            $(".select_pag").each(function(){
                if($(this).attr("checked")){
                    ok = 1;
                }
            });
            if(ok){
                $("#confpag").submit();
            }else{
                alert("Selecione uma forma de pagamento.");
            }
            
        });
    });
</script>
<script type="text/javascript" src="js/mask.js"></script>
<style>
u{
    color:#FF9930;
}
</style>

<body>
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

                        <div style="color:#E51B21; font:Arial; font-size:24px; display:inline; margin-top:4px;">
                            <?= $restaurante->telefone ?>
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
                        	<img src="background/passo3.png" alt="passo1" width="541" height="43" border="0" usemap="#Map">
<map name="Map"><area shape="rect" coords="1,1,130,41" href="restaurantes.php"><area shape="rect" coords="137,2,269,41" href="cardapio?id=<?= $restaurante->id ?>"></map>
                        </div>
              </div>
                    
                    <div id="titulo_box_destaque" >
                    Confirma&ccedil;&atilde;o e pagamento
                    </div>
                    <div class="titulo_box_pedido" style="margin-top:4px;">Pedido
					</div>
                    <div class="box_pedido">
                    	<table>
                        	<tr style="font-size:12px;"><th class="tabela_pedido">Item</th><th>Valor</th><th>Quantidade</th><th>Valor Total</th></tr>
                            <? if($pedido->pedido_tem_produtos){
                                foreach($pedido->pedido_tem_produtos as $ptp){ ?>
                                    <tr><td><? 
                                            $val_prod = "";
                                            if($ptp->produto->aceita_segundo_sabor){
                                                if($ptp->produto_id2){
                                                    if($ptp->produto_id3){
                                                        if($ptp->produto_id4){
                                                           
                                                            echo "1/4".$ptp->produto->nome.",1/4".$ptp->produto2->nome.",1/4".$ptp->produto3->nome.",1/4".$ptp->produto4->nome;
                                                        }else{
                                                            
                                                            echo "1/3".$ptp->produto->nome.",1/3".$ptp->produto2->nome.",1/3".$ptp->produto3->nome;
                                                        }
                                                    }else{
                                                        
                                                        echo "1/2".$ptp->produto->nome.",1/2".$ptp->produto2->nome;
                                                    }
                                                }else{
                                                   
                                                   echo $ptp->produto->nome;
                                                }
                                            }else{
                                          
                                                echo $ptp->produto->nome;
                                            }
                                            
                                            if($ptp->produto->tamanho!=""){
                                                echo " ".$ptp->produto->tamanho;
                                            }
                                           
                                    
                                        ?><i><span style="font-size:8px;">
                                    <?
                                        $tem_acomp = 0;
                                        $tem_extr = 0;
                                        if($ptp->pedido_tem_produtos_adicionais){
                                            foreach($ptp->pedido_tem_produtos_adicionais as $ptpa){
                                                if($ptpa->produto_adicional->quantas_unidades_ocupa>0){
                                                    if($tem_acomp>0){
                                                        echo ", ";
                                                    }else{
                                                        echo "<br/>";
                                                    }
                                                    echo $ptpa->produto_adicional->nome;
                                                    $tem_acomp++;
                                                }
                                            }
                                        }
                                        if($ptp->pedido_tem_produtos_adicionais){
                                            foreach($ptp->pedido_tem_produtos_adicionais as $ptpa){
                                                if($ptpa->produto_adicional->quantas_unidades_ocupa==0){
                                                    if($tem_extr>0){
                                                        echo ", ";
                                                    }else{
                                                        echo "<br/>"; 
                                                    }
                                                    echo $ptpa->produto_adicional->nome;
                                                    $tem_extr++;
                                                }
                                            }
                                        }
                                        if($ptp->obs){
                                            echo "<br/>";
                                            echo $ptp->obs;
                                        }
                                    ?>
                                                </span></i>
                                        </td><td><? 
                                        if($ptp->getTotal()/$ptp->qtd==0){
                                            echo "R$ 0,00";
                                        }else{
                                            echo StringUtil::doubleToCurrency($ptp->getTotal()/$ptp->qtd);
                                        }
                                         
                                                ?></td><td>x<?= $ptp->qtd ?></td><td><?
                                                        if($ptp->getTotal()==0){
                                                            echo "R$ 0,00";
                                                        }else{
                                                            echo StringUtil::doubleToCurrency($ptp->getTotal());
                                                        }
                                                         
                                                                ?></td></tr>
                                    
                                    
                                    
                                <? }
                            } ?>
                            
                            <tr><td></td><td></td><td></td><td></td></tr>
                            <tr><td></td><td></td><th style="text-align:right; color:#E51B21;">Desconto:</th><th><?
                                    if($pedido->cupom->valor==0){
                                        echo "R$ 0,00";
                                        $desconto = 0;
                                    }else{
                                        echo StringUtil::doubleToCurrency($pedido->cupom->valor);
                                        $desconto = $pedido->cupom->valor;
                                    }    
                                    ?></th></tr>
                            <tr><td></td><td></td><th style="text-align:right; color:#E51B21;">Taxa de entrega:</th><th><?
                                    if($pedido->preco_entrega==0){
                                        echo "R$ 0,00";
                                    }else{
                                        echo StringUtil::doubleToCurrency($pedido->preco_entrega);
                                    }    
                                    ?></th></tr>
                            <?
                                $total = $pedido->getTotal();
                                $total -= $desconto;
                                if($total<0){
                                    $total=0;
                                }
                            ?>
                            <tr><td style="text-align:right; color:#E51B21; text-align:left; cursor:pointer;" onClick="location.href='cardapio?id=<?= $restaurante->id ?>'">&nbsp;&nbsp;Voltar para o carrinho<img src="background/carrinho_dark.png" width="20" height="15" style="float:left;"></td><td></td><th style="text-align:right; color:#E51B21;">Total:</th><th><?= StringUtil::doubleToCurrency($pedido->preco_entrega + $total) ?></th></tr>
                        </table>
                    </div>
                    <div class="titulo_box_pedido">Dados para entrega
					</div>
                    <div class="box_pedido">
                    	<table>
                            <tr><th>Nome:</th><td style="width:530px; u{color:#FF9930} "><u><?= $enderecoSession->consumidor->nome ?></u></td></tr>
                            <tr><th>Telefone(s):</th><td><u><?
                                if($telefones){    
                                    $ctel = 0;
                                    foreach($telefones as $tel){
                                        if($ctel>0){
                                            echo ", ";
                                        }
                                        echo $tel->numero;
                                        $ctel++;
                                    }
                                }
                            ?></u></td></tr>
                            <tr><th>CEP:</th><td><u><?= $enderecoSession->cep ?></u></td></tr>
                            <tr><th>Endereço:</th><td><u><?= $enderecoSession->logradouro ?></u></td></tr>
                            <tr><th>Número:</th><td><u><?= $enderecoSession->numero ?></u></td></tr>
                            <tr><th>Bairro:</th><td><u><?= $enderecoSession->bairro->nome ?></u></td></tr>
                            <tr><th>Cidade:</th><td><u><?= $enderecoSession->bairro->cidade->nome ?></u></td></tr>
                            <tr><th>Estado:</th><td><u><?= $enderecoSession->bairro->cidade->uf->sigla ?></u></td></tr>
                            <tr><th>Complemento:</th><td><u><?= $enderecoSession->complemento ?></u></td></tr>
                            <tr><th>Ponto de referência:</th><td><u><?= $enderecoSession->referencia ?></u></td></tr>
                        </table>
                    </div>
                    <div class="titulo_box_pedido">Pagamento
					</div>
                    <div class="box_pedido">
                        <form id="confpag" action="php/controller/salva_forma_pagamento" method="post">
                    <table style="margin-left:-4px; width:534px;">
                    	<?
                            if($restaurante->restaurante_pagamentos){
                                foreach($restaurante->restaurante_pagamentos as $rp){ ?>
                                    <tr><td style="height:32px;">
                                            <div title="<?= $rp->forma_pagamento->nome ?>"><input class="select_pag" id="fpag_<?= $rp->forma_pagamento->id ?>" type="radio" name="forma_pagamento" value="<?= $rp->forma_pagamento->id ?>">&nbsp; <img src="background/<?= $rp->forma_pagamento->url ?>">  </div>
                                            <div class="aux_select_pag" id="aux_fpag_<?= $rp->forma_pagamento->id ?>" style="display:none;">
                                                <? if($rp->forma_pagamento->nome=="Dinheiro"){ ?>
                                                    <input type="text" name="troco" onkeyup="mask_moeda(this)" placeholder="Troco para...">
                                                <? }else{ ?>
                                                    <table>
                                                    <tr><td><input type="text" name="nome_cartao" placeholder="Nome no cart&atilde;o"></td></tr>
                                                    <tr><td><input type="text" name="num_cartao" placeholder="N&uacute;mero cart&atilde;o" maxlength="19" onkeyup="mask_card(this)"></td></tr>
                                                    <tr><td><input type="text" name="validade_cartao" placeholder="Validade cart&atilde;o" maxlength="5" onkeyup="mask_valcard(this)"></td></tr>
                                                    <tr><td><input type="text" name="cod_seguranca_cartao" placeholder="C&oacute;digo seguran&ccedil; cart&atilde;o" maxlength="3"></td></tr>
                                                    </table>
                                                <? } ?>
                                            </div>
                                        </td></tr>
                              <?  }
                            }
                        ?>
                                    
                    </table>

                    <img src="background/botao_fin.png" id="confirma_pagamento" width="121" height="33" style="float:right; cursor:pointer; position:absolute; margin-top:-38px; margin-left:534px">
                        </form>
                    </div>
                    <div class="box_pedido" style="display:none;">
                        
                    </div>    
                              
          </div>
		</div>
	</div>
</div>
<? include("include/footer.php"); ?>