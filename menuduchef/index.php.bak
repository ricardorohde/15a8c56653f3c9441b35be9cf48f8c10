<? include('include/header.php'); ?>
<? 
    include "menu.php";
    session_destroy();
?>
<script src="js/jquery-1.6.4.min.js">
</script>
<script>
	$(function(){
		
		$("#buscar").click(function(){
			
			$("#logcep").submit();
			
			});
		});
		
</script>
<div class="span-24" id="central_principal" >
    <div id="lateral_esquerda">
	<div style="width:132px; height:114px; padding:3px 13px; margin-top:84px; ">
	    <img src="background/faca_pedido.gif" width="132" height="114">
	</div>
     <form id="logcep" action="php/controller/cep" method="post" onsubmit="if(!this.cep.value.trim()) { alert('Digite um CEP v&aacute;lido'); return false; }">
	<div style="width:132px; height:28px; padding:0 6px; margin-top:2px; ">
	   
		<input type="text" class="w90" name="cep" style="height:18px; width:134px; color:#F90; font-size:14px; font-weight:bold;" />
	    
	</div>
	<div class="fonte_cep" style="width:132px; height:18px; padding:0 13px; ">
	    <div style="float:right;">N&atilde;o sei meu CEP</div>
	</div>
	<div class="fonte_lateral" style="width:132px; height:28px; padding:0 13px; position:relative;">
	    <span id="buscar" style="float:right; margin-top:-8px; cursor:pointer;">Buscar</span>
	</div>
    </form>
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