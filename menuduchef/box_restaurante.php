<?
$restauranteAtendeBairro = $restaurante->getRestauranteAtendeBairro($enderecoSession->bairro_id);

$hora_atual = date("U");
?>

<script type="text/javascript">
    $(function() {
	$('.abre_box').hover(
	    function() {
		$(this).css('color', '#E51B21').next().show();
	    },
	    function() {
		$(this).css('color', '#6E7072').next().hide();
	    }
	);
    });
</script>

<div class="radios prepend-top" id="box_restaurante">
    <div id="box_interno">
	<div id="box_avatar">
	    <img style="width:130px; height:98px;" src="<?= $restaurante->getUrlImagem() ?>" alt="<?= $restaurante->nome ?>" />
	</div>
	<div id="box_textos">
	    <div id="b1"><?= $restaurante->getNomeCategoria() ?></div>
	    <div class="texto_box" id="b2"><?= $restaurante->nome ?></div>
	    
	    <div class="texto_box" id="b3">
		<? if($restaurante->getStrHorarios() || $restaurante->getStrFormasPagamento()) { ?>
		<? if($restaurante->getStrHorarios()) { ?>
                
                
		<span class="tool" style="display:inline">Horário de funcionamento
                        <? 
                        $quantas = 1;
                        foreach($restaurante->horarios as $hor){ 
                            if($hor->hora_inicio3){
                                $quantas = 3;
                            }else if(($hor->hora_inicio2)&&($quantas==1)){
                                $quantas = 2;
                            }
                        } 
                        $width = 150;
                        if($quantas==2){
                            $width = 220;
                        }else if($quantas==3){
                            $width = 300;
                        }
                        ?>

                    <span class="tip" ><table border="2px" class="sem" style="width:<?= $width ?>px;">
                         <? foreach($restaurante->horarios as $hor){ ?>   
                         <tr>
                            <td style="background:#999; width:3px;"></td>
                            <th class="dia"><?= $hor->dia_da_semana ?></th>
                            <td style="background:#F8F8F8;"><?= $hor->hora_inicio1 ?> &aacute;s <?= $hor->hora_fim1 ?></td>
                            <? if($hor->hora_inicio2&&$hor->hora_fim2){ ?>
                                <td style="background:#F8F8F8; "><?= $hor->hora_inicio2 ?> &aacute;s <?= $hor->hora_fim2 ?></td>
                            <? }else{ ?>
                                <td style="background:#F8F8F8; "></td>
                            <? } ?>    
                            <? if($hor->hora_inicio3&&$hor->hora_fim3){ ?>
                                <td style="background:#F8F8F8; "><?= $hor->hora_inicio3 ?> &aacute;s <?= $hor->hora_fim3 ?></td>
                            <? }else{ ?>
                                <td style="background:#F8F8F8; "></td>
                            <? } ?>
                        </tr>   
                        <? } ?>
                    </table></span>
                </span>    
                
		
		<?= $restaurante->getStrHorarios() && $restaurante->getStrFormasPagamento() ? '|' : '' ?>
		<? } ?>
		<? if($restaurante->getStrFormasPagamento()) { 
                        $width = sizeof($restaurante->restaurante_pagamentos) * 42;
                        if($width>220){
                            $width = 220;
                        }
                    ?>
		    <span class="tool">&nbsp;Formas de pagamento
                        <span class="tip" style="width:<?= $width ?>px" >
                            <? foreach($restaurante->restaurante_pagamentos as $pag){ ?>
                                <img src="background/<?= $pag->forma_pagamento->url ?>" style="margin-left:3px" title="<?= $pag->forma_pagamento->nome ?>">
                            <? } ?>
                        </span>
                    </span>
		<? } ?>
                
		<? } ?>
                    
                </span>    
		<? if($restauranteAtendeBairro && ($restauranteAtendeBairro->tempo_entrega || $restauranteAtendeBairro->preco_entrega)) { ?>
		
		<? } ?>
	    </div>
	    <div class="texto_box" id="b4">
		    <? if($restauranteAtendeBairro->tempo_entrega) { ?>
		    <img src="background/relogio.gif" width="15" height="14" title="Tempo de entrega" />
		    <?= $restauranteAtendeBairro->tempo_entrega ?> min
		    <? } ?>
		    <?= $restauranteAtendeBairro->tempo_entrega && $restauranteAtendeBairro->preco_entrega ? '&nbsp;|&nbsp;' : '' ?>
		    <? if($restauranteAtendeBairro->preco_entrega) { ?>
		    <img src="background/entrega.gif" width="20" height="14" title="Taxa de entrega" />
		    <?= $restauranteAtendeBairro->getPrecoFormatado() ?>
		    <? } ?>
		</div>
	</div>
	<div id="box_botoes">
	    <div style="width:110px; height:72px;">
                <? 

                if(($hora_atual - $restaurante->online)>180){
                    $aberto = 0;
                    echo "FECHADO";
                }else{
                    $aberto = 1;
                    echo "ABERTO";
                }
                    
                    ?>
	    </div>
	    <div id="botao_pedir">
                <? if($aberto){ ?>
		<a href="cardapio/<?= $restaurante->id ?>/" title="Pedir">
		    <img src="background/botao_pedir.gif" width="75" height="28" alt="Pedir" style="float:right; margin-bottom:0;" />
		</a>
                <? }else{ ?>
                <div style="cursor:pointer" onclick="if(confirm('O restaurante est\u00e1 fechado ou fora do ar, deseja mesmo prosseguir?')) location.href='cardapio/<?= $restaurante->id ?>/'" title="Pedir">
		    <img src="background/botao_pedir.gif" width="75" height="28" alt="Pedir" style="float:right; margin-bottom:0;" />
		</div>    
                <? } ?>
	    </div>
	</div>
    </div>
</div>