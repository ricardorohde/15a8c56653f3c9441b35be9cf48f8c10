<? include('include/header.php'); ?>
<?php include "menu.php" ?>

<div class="span-24" id="central_principal" >
    <div id="lateral_esquerda">
	<div style="width:132px; height:114px; padding:3px 13px; margin-top:84px; ">
	    <img src="background/faca_pedido.gif" width="132" height="114">
	</div>
	<div style="width:132px; height:26px; padding:0 13px; margin-top:4px; ">
	    <form action="php/controller/cep" method="post" onsubmit="if(!this.cep.value.trim()) { alert('Digite um CEP v&aacute;lido'); return false; }">
		<input type="text" class="w90" name="cep" />
	    </form>
	</div>
	<div class="fonte_cep" style="width:132px; height:18px; padding:0 13px; ">
	    <div style="float:right;">N&atilde;o sei meu CEP</div>
	</div>
	<div class="fonte_lateral" style="width:132px; height:28px; padding:0 13px; position:relative;">
	    <span style="float:right; margin-top:-8px;">Buscar</span>
	</div>
	<img src="background/fazer_pedido.gif" height="446" width="144" style="padding:0 7px; margin-top:-12px; position:relative;"/>
    </div>
    <div id="lateral_direita" style="background:url(../menuduchef/background/central.jpg);">
	<div id="direita_interna">
	    <div id="banner_dinamico">
	    </div>
	    <div id="botoes">
		<div class="botao_principal">
		</div>
		<div class="botao_principal" style="padding:0 21px;">
		</div>
		<div class="botao_principal">
		</div>
	    </div>
	    <img src="background/rodape_principal.gif" width="762" height="69"/>

	</div>   
    </div> 
</div>
<? include('include/footer.php'); ?>