<?
include("include/header.php");
include("include/session_vars.php");

$page = $_GET['page'] ? : 1;

$endereco = null;

if($_SESSION['endereco_cep']) {
    $enderecoCep = unserialize($_SESSION['endereco_cep']);
    $endereco = new EnderecoConsumidor();
    $endereco->bairro_id = $enderecoCep->bairro_id;
    $endereco->cep = $enderecoCep->cep;
    $endereco->logradouro = $enderecoCep->logradouro;
} elseif ($consumidorSession) {
    if ($consumidorSession->enderecos) {
	$endereco = $consumidorSession->enderecos[0];
    }
}

if ($endereco) {
    $paginacao = new Paginacao('Restaurante', array(
	    'joins' => 'inner join restaurante_atende_bairro rab on rab.restaurante_id = restaurante.id',
	    'conditions' => 'rab.bairro_id = ' . $endereco->bairro_id
	    ), 'restaurantes', $page, 5, 5);

    $restaurantes = $paginacao->list;
}
?>

<script type="text/javascript">
    $(document).ready(function() {
        $("#ver_completo").click( function(){
            $(".filtro_categoria").attr("checked","true");
            $(".categoria").show();
        });
        
        $("#filtrar").click( function(){
            oque = $("#caixa_filtro").attr("value");
            $(".produto").hide();
            $("#produto_").hide();
            
        });
        $('.pagina').click(function() {
	    $("#formulario").submit();
        });
        
        $('.refino').click(function() {
	    $("#volta_pagina1").attr("value",1);
	    $("#formulario").submit();
        });
        
        $('#endereco_cliente').change(function() {
	    $("#volta_pagina1").attr("value",1);
	    $("#formulario").submit();
        });
        
        $('.abre_formapagamento').mouseover(function() {
	    qual = $(this).attr("formapagamento");
	    $("#"+qual).show();
        });
        $('.abre_formapagamento').mouseout(function() {
	    qual = $(this).attr("formapagamento");
	    $("#"+qual).hide();
        });
        
        $('.abre_horario').mouseover(function() {
	    qual = $(this).attr("horario");
	    $("#"+qual).show();
        });
        $('.abre_horario').mouseout(function() {
	    qual = $(this).attr("horario");
	    $("#"+qual).hide();
        });
        
    });
    function show(x){
        oque = document.getElementById(x);
        if(oque.style.display=='block'){
            oque.style.display = "none";
        }else{
            oque.style.display = "block";
        }
    }
    function erase(x){
        oque = document.getElementById(x);
        oque.value = "";
    }
    function indica_pagina(x){
        if(x>0){
            oque = document.getElementById("pagina");
            oque.value = x;
        }
    }
</script>

<?php include "menu2.php" ?>

<div id="central" class="span-24">
    <div class="span-6">
	<div id="barra_esquerda">
	    <div id="seleciona_endereco">
		<img src="background/titulo_endereco.gif" width="114" height="30" alt="Endereço" style="margin-left:12px">
		<div style="width:198px; height:25px; margin-left:7px;">
		    <? if ($endereco) { ?>
			<?= $endereco->logradouro ?><br />
			CEP: <?= StringUtil::formataCep($endereco->cep) ?><br />
			<?= $endereco->bairro ?> - <?= $endereco->bairro->cidade ?>
		    <? } else { ?>
    		    <select id="endereco_cliente" name="endereco_cliente" style="width:195px; margin-left:3px;">
			    <?= $endereco ?>
    		    </select>
		    <? } ?>
		</div>
	    </div>
	    <br clear="all" /><br clear="all" />
	    <div id="busca">
		<img src="background/titulo_busca.gif" width="71" height="26" alt="Busca" style="margin-left:12px">
		<div style="width:198px; height:25px;  margin-left:10px;">
		    <input id="caixa_filtro" name="caixa_filtro" type="text" style="float:left; margin: auto 0; width:140px; position:relative;"> 
		    <input type="image" class="refino" value="submit" id="filtrar" src="background/botao_ok.gif" style="float:right; margin-top:-4px; border:0; width:40px; height:24px; position:relative; cursor:pointer;">                   	    	
		    </div>
		    </div>
		    <div id="filtro">
			<img src="background/titulo_filtro.gif" width="74" height="26" alt="Filtro" style="margin-left:12px">
			<div style="padding-top:5px;">
			    <div style="color:#CC0000; padding-top:5px; padding-left:12px;">
				<input type="checkbox" class="refino" class="filtro_categoria" id="checkrest_<?= $categoria->id ?>" name="checkrest_<?= $categoria->id ?>" <?= $checked ?> /> &nbsp; Sandubas (3)
			    </div>
			</div>
		    </div>
		    </div>
		    </div>
		    <div class="span-18 last">
			<div style="height: 1050px">
			    <div class="prepend-top" id="status">
				<div id="numero_rest"><span style="margin-left:8px;"> </span></div> 
				<div id="status_pedido">
				    <img src="background/passo.png" width="541" height="43" alt="passo1">
				</div>
			    </div>

			    <div id="caixa_sup">
				<h1 id="rest_titulo">Restaurantes</h1>
				<? if ($paginacao && $paginacao->getHtml()) { ?>
    				<div id="contagem_pag">
					<?= $paginacao->getHtml() ?>
    				</div>
				<? } ?>
			    </div>

			    <?
			    if ($restaurantes) {
				foreach ($restaurantes as $restaurante) {
				    ?>

				    <? include 'box_restaurante.php' ?>

				<? }
			    } else { ?>
    			    <br /><br />
    			    <p>Nenhum restaurante encontrado na sua localidade</p>
			    <? } ?>

			    <? if ($paginacao && $paginacao->getHtml()) { ?>
    			    <div class="radios prepend-top" id="caixa_sup">
    				<div id="contagem_pag">
					<?= $paginacao->getHtml() ?>
    				</div>
    			    </div>
			    <? } ?>
			</div>
			<div id="rodape" class="prepend-top">
			    <img src="background/rodape.jpg" width="760" height="69" style="margin-left:-61px;">
			</div>
		    </div>
		    </div>
		    <? include('include/footer.php'); ?>