<?
$restauranteAtendeBairro = $restaurante->getRestauranteAtendeBairro($enderecoSession->bairro_id);
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
	    <img src="<?= $restaurante->getUrlImagem() ?>" alt="<?= $restaurante->nome ?>" />
	</div>
	<div id="box_textos">
	    <div id="b1"><?= $restaurante->getNomeCategoria() ?></div>
	    <div class="texto_box" id="b2"><?= $restaurante->nome ?></div>
	    
	    <div class="texto_box" id="b3">
		<? if($restaurante->getStrHorarios() || $restaurante->getStrFormasPagamento()) { ?>
		<? if($restaurante->getStrHorarios()) { ?>
		<span class="abre_box">Horário de funcionamento</span>
		<div style="display:none; z-index:3; background-color: #DDD; position: absolute;">
		    <?= $restaurante->getStrHorarios('<br />') ?>
		</div>
		<? } ?>
		
		<?= $restaurante->getStrHorarios() && $restaurante->getStrFormasPagamento() ? '|' : '' ?>
		
		<? if($restaurante->getStrFormasPagamento()) { ?>
		    <span class="abre_box">Formas de pagamento</span>
		    <div style="display:none; z-index:3; background-color: #DDD; position: absolute;<? if($restaurante->getStrHorarios()) { ?> margin-left: 151px;<? } ?>">
			<?= $restaurante->getStrFormasPagamento('<br />') ?>
		    </div>
		<? } ?>
		<? } ?>
		<? if($restauranteAtendeBairro && ($restauranteAtendeBairro->tempo_entrega || $restauranteAtendeBairro->preco_entrega)) { ?>
		<div class="texto_box" id="b4">
		    <? if($restauranteAtendeBairro->tempo_entrega) { ?>
		    <img src="background/relogio.gif" width="15" height="14" title="Tempo de entrega" />
		    <?= $restauranteAtendeBairro->tempo_entrega ?> min
		    <? } ?>
		    <?= $restauranteAtendeBairro->tempo_entrega && $restauranteAtendeBairro->preco_entrega ? '|' : '' ?>
		    <? if($restauranteAtendeBairro->preco_entrega) { ?>
		    <img src="background/entrega.gif" width="20" height="14" title="Taxa de entrega" />
		    <?= $restauranteAtendeBairro->getPrecoFormatado() ?>
		    <? } ?>
		</div>
		<? } ?>
	    </div>
	    
	</div>
	<div id="box_botoes">
	    <div style="width:110px; height:72px;">
	    </div>
	    <div id="botao_pedir">
		<a href="cardapio/<?= $restaurante->id ?>/" title="Pedir">
		    <img src="background/botao_pedir.gif" width="75" height="28" alt="Pedir" style="float:right; margin-bottom:0;" />
		</a>
	    </div>
	</div>
    </div>
</div>