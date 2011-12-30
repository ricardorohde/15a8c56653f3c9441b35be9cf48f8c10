<div class="radios prepend-top" id="box_restaurante">
    <div id="box_interno">
	<div id="box_avatar">
	    <img src="<?= $restaurante->getUrlImagem() ?>" alt="<?= $restaurante->nome ?>" />
	</div>
	<div id="box_textos">
	    <div id="b1"><?= $restaurante->getNomeCategoria() ?></div>
	    <div class="texto_box" id="b2"><?= $restaurante->nome ?></div>
	    <div class="texto_box" id="b3">Horário de funcionamento  |  Forma de pagamento</div>
	    <div class="texto_box" id="b4"></div>
	</div>
	<div id="box_botoes">
	    <div style="width:110px; height:72px;">
	    </div>
	    <div id="botao_pedir">
		<img src="background/botao_pedir.gif" width="75" height="28" alt="Pedir" style="float:right; margin-bottom:0;">
	    </div>
	</div>
    </div>
</div>