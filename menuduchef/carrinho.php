<?
    
    if(isset($_SESSION['pedido_id'])){
        $pedido = Pedido::find($_SESSION['pedido_id']);
    }
?>

<div id="carrinho" >
    <div id="movi">
	<div id="aba_carrinho">
	    <div id="topo_carrinho">
                <div id="total_carrinho"><?
                                if($pedido){
                                    echo StringUtil::doubleToCurrency($pedido->getTotal() + $rxb->preco_entrega);
                                }else{
                                    echo StringUtil::doubleToCurrency($rxb->preco_entrega);
                                }
                            ?></div>
		<img src="background/carrinho.png" width="31" height="23" style="position:absolute; z-index:6; top:6px; left:81px;">
	    </div> 
	</div>


	<div id="borda_carrinho" class="radios_10">
	</div>


	<div id="corpo_carrinho" class="radios_10">
	    <img src="background/logo_pq.png" width="56" height="54" style="position:absolute; z-index:4; left:150px; top:2px;" />
	    <div id="info_pedido">
		<div style="width:200px; height:18px; padding-top:5px; float:left;" >
		    Sub-total:<div id="subtotal_carrinho" style="color:#EE646B; display:inline"> <?
                                if($pedido){
                                    echo StringUtil::doubleToCurrency($pedido->getTotal());
                                }
                            ?></div>
		</div>
		<div style="width:200px; height:18px; float:left;" >
		    Frete:<div style="color:#EE646B; display:inline"> <? 
                        echo StringUtil::doubleToCurrency($rxb->preco_entrega);      
                    ?></div>
                    <input type="hidden" id="taxa_de_entrega" value="<?= $rxb->preco_entrega ?>">
		</div>
		<div style="width:200px; height:18px; float:left;" >
		    Desconto:<div style="color:#EE646B; display:inline"> R$0</div>
		</div>

	    </div>
	    <div id="voucher_promocional">
		<div class="radios_5" id="id_promo">
		</div>
		<div class="radios_5" id="ok_buton"><div style="margin-top:0; margin-left:10px;">OK</div>
		</div>
	    </div>
	    <div class="radios_5" id="campo_pedido_detalhado" style="overflow-x:auto;">
                <?
                    $count = 0;
                    if($pedido->pedido_tem_produtos){
                        foreach($pedido->pedido_tem_produtos as $prod){
                            ?>
                                <div id="produto_box_<?= $count ?>" style="margin:5px;">
                                    <div onclick="destroi_box('<?= $count ?>')">X</div>
                                    <div>
                                        <span id="span_qtd_prod_<?= $count ?>"><?= $prod->qtd ?>x</span>
                                        <input type="hidden" id="qtd_prod_<?= $count ?>" name="qtd_prod_<?= $count ?>" value="<?= $prod->qtd ?>">

                                        <?= $prod->produto->nome ?>
                                        <input type="hidden" id="id_prod_<?= $count ?>" name="id_prod_<?= $count ?>" class="lista_carrinho" value="<?= $prod->produto_id ?>">
                                        <div id="div_preco_prod_<?= $count ?>" style="float:right;"><?= StringUtil::doubleToCurrency($prod->getTotal()) ?></div>
                                        <input type="hidden" id="preco_prod_<?= $count ?>" class="preco_carrinho" value="<?= $prod->getTotal() ?>" >
                                    </div>
                                    <div>
                                    <? 
                                        if($prod->pedido_tem_produtos_adicionais){
                                            $counta = 0;
                                            foreach($prod->pedido_tem_produtos_adicionais as $adi){
                                                if($adi->produto_adicional->quantas_unidades_ocupa>0){
                                                  if($counta>0){
                                                      echo ", ";
                                                  }
                                                  ?>
                                                        <span style="font-size:10px;" id="span_adi_prod_<?= $count ?>_<?= $counta ?>">
                                                            <?= $adi->produto_adicional->nome ?>
                                                            <input type="hidden" class="adi_prod_nome_<?= $count ?>" id="adi_prod_nome_<?= $count ?>_<?= $counta ?>" value="<?= $adi->produto_adicional->nome ?>"> 
                                                            <input type="hidden" class="adi_prod_<?= $count ?>" id="adi_prod_<?= $count ?>_<?= $counta ?>" name="adi_prod_<?= $count ?>_<?= $counta ?>" value="<?= $adi->produtoadicional_id ?>">
                                                        </span>
                                                  <?
                                                  $counta++;
                                                }
                                            }
                                        }
                                    ?>
                                    </div>
                                    <div>
                                    <? 
                                        if($prod->pedido_tem_produtos_adicionais){
                                            $countb = 0;
                                            foreach($prod->pedido_tem_produtos_adicionais as $adi){
                                                if($adi->produto_adicional->quantas_unidades_ocupa==0){
                                                  if($countb>0){
                                                      echo ", ";
                                                  }
                                                  ?>
                                                        <span style="font-size:10px;" id="span_adi_prod_<?= $count ?>_<?= $counta ?>">
                                                            <?= "+".$adi->produto_adicional->nome ?>
                                                            <input type="hidden" class="adi_prod_nome_<?= $count ?>" id="adi_prod_nome_<?= $count ?>_<?= $counta ?>" value="<?= $adi->produto_adicional->nome ?>"> 
                                                            <input type="hidden" class="adi_prod_<?= $count ?>" id="adi_prod_<?= $count ?>_<?= $counta ?>" name="adi_prod_<?= $count ?>_<?= $counta ?>" value="<?= $adi->produtoadicional_id ?>">
                                                        </span>
                                                  <?
                                                  $counta++;
                                                  $countb++;
                                                }  
                                            }
                                        }
                                    ?>
                                    </div>
                                    <div>
                                        <span  style="font-size:10px;" id="span_obs_prod_<?= $count ?>"><?= $prod->obs ?></span>
                                        <input type="hidden" id="obs_prod_<?= $count ?>" name="obs_prod_<?= $count ?>" value="<?= $prod->obs ?>">
                                    </div>
                                    <div>

                                        
                                    </div>    
                                </div>
                            <?
                            $count++;
                        }
                    }
                    
                ?>
                <input type="hidden" id="contador_itens" value="<?= $count ?>" >
	    </div>
            <img src="background/finalizar_car.png" onclick="passa_etapa()" style="width:198px; height:26px; position:relative; float:left; margin-left:6px;">
        </div>
    </div>

</div>