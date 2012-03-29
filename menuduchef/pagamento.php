<?
    include("include/header.php");
    
    
    $pedido = Pedido::find($_SESSION['pedido_id']);
    $restaurante = Restaurante::find($pedido->restaurante_id);
    $telefones = TelefoneConsumidor::all(array("conditions"=>array("consumidor_id = ?",$pedido->consumidor_id)));
    
    
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
    });
</script>
<style>
u{
    color:#FF9930;
}
</style>

<body>
<div class="container">
	<div id="background_container">
    	<?php include "menu2.php" ?>
        <div id="central" class="span-24">
			<div class="span-6">
            	<div id="barra_esquerda">
                	<div id="info_restaurante">
                    	<div id="categoria_rest">Pizzaria
                        </div>
                        <div id="nome_rest">Reis Magos
                        </div>
                        <div id="avatar_rest">
                        </div>
                        <div id="formas_pagamento">Formas de pagamento
                        </div>
                        <div id="tempo_entrega">Tempo de entrega:<img src="background/relogio.gif" width="20" height="19" style="position:relative; top:6px; left:4px;">&nbsp;&nbsp;&nbsp;300min
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
                    Forma de pagamento
                    </div>
                    <div class="titulo_box_pedido" style="margin-top:4px;">Pedido
					</div>
                    <div class="box_pedido">
                    	<table>
                        	<tr style="font-size:12px;"><th class="tabela_pedido">Item</th><th>Valor</th><th>Quantidade</th><th>Valor Total</th></tr>
                            <? if($pedido->pedido_tem_produtos){
                                foreach($pedido->pedido_tem_produtos as $ptp){ ?>
                                    <tr><td><?= $ptp->produto->nome ?><i><span style="font-size:8px;">
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
                                        </td><td><?= StringUtil::doubleToCurrency($ptp->getTotal()/$ptp->qtd) ?></td><td>x<?= $ptp->qtd ?></td><td><?= StringUtil::doubleToCurrency($ptp->getTotal()) ?></td></tr>
                                    
                                    
                                    
                                <? }
                            } ?>
                            
                            <tr><td></td><td></td><td></td><td></td></tr>
                            <tr><td></td><td></td><th style="text-align:right; color:#E51B21;">Taxa de entrega:</th><th><?= StringUtil::doubleToCurrency($pedido->preco_entrega) ?></th></tr>
                            <tr><td style="text-align:right; color:#E51B21; text-align:left; cursor:pointer;" onClick="location.href='cardapio?id=<?= $restaurante->id ?>'">&nbsp;&nbsp;Voltar para o carrinho<img src="background/carrinho_dark.png" width="20" height="15" style="float:left;"></td><td></td><th style="text-align:right; color:#E51B21;">Total:</th><th><?= StringUtil::doubleToCurrency($pedido->preco_entrega + $pedido->getTotal()) ?></th></tr>
                        </table>
                    </div>
                    <div class="titulo_box_pedido">Dados para entrega
					</div>
                    <div class="box_pedido">
                    	<table>
                            <tr><th>Nome:</th><td style="width:530px; u{color:#FF9930} "><u><?= $enderecoSession->consumidor->nome ?></u></td></tr>
                            <tr><th>Telefone:</th><td><u><?
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
                    <table style="margin-left:-4px; width:534px;">
                    	<?
                            if($restaurante->restaurante_pagamentos){
                                foreach($restaurante->restaurante_pagamentos as $rp){ ?>
                                    <tr><td>
                                            <div><input class="select_pag" id="fpag_<?= $rp->forma_pagamento->id ?>" type="radio" name="forma_pagamento" value="<?= $rp->forma_pagamento->id ?>"> <img src="<?= $rp->forma_pagamento->url ?>"> <?= $rp->forma_pagamento->nome ?> </div>
                                            <div class="aux_select_pag" id="aux_fpag_<?= $rp->forma_pagamento->id ?>" style="display:none;">
                                                <? if($rp->forma_pagamento->nome=="Dinheiro"){ ?>
                                                    <input type="text" name="troco" placeholder="Troco para...">
                                                <? }else{ ?>
                                                    <input type="text" name="troco" placeholder="Trocouheiaushvesa">
                                                <? } ?>
                                            </div>
                                        </td></tr>
                              <?  }
                            }
                        ?>
                    </table>

                    <img src="background/botao_fin.png" width="121" height="33" style="float:right; cursor:pointer; position:absolute; margin-top:-38px; margin-left:534px">
                    </div>
                    <div class="box_pedido" style="display:none;">
                        
                    </div>    
                              
          </div>
		</div>
	</div>
</div>
<? include("include/footer.php"); ?>