<?
include("include/header.php");


#$itens = Produto::find_all_by_restaurante_id($_GET['id'], array("order" => "nome asc"));
if ($enderecoSession) {
    $categorias = RestauranteTemTipoProduto::all(array('conditions' => array('restaurante_id = ?', $_GET['id'])));
    $restaurante = Restaurante::find($_GET['id']);
    $resxbai = RestauranteAtendeBairro::all(array('conditions' => array('restaurante_id = ? and bairro_id=?', $_GET['id'], $enderecoSession->bairro_id)));
}
?>

<script>

    $(document).ready(function() {
	$("#ver_completo").click( function(){
	    $(".filtro_categoria").attr("checked","true");
	    $(".categoria").show();
	});
    
	$(".up").click( function(){
	    qual=$(this).attr("qual");
	    qtd=$("#qtd_"+qual).attr("value");
	    qtd= parseInt(qtd) + 1;
	    $("#qtd_"+qual).attr("value",qtd);
	    $("#qtd2_"+qual).html(qtd);	
	});
	
	$(".down").click( function(){
	    qual=$(this).attr("qual");
	    qtd=$("#qtd_"+qual).attr("value");
	    if(parseInt(qtd)>0){
		qtd= parseInt(qtd) - 1;
		$("#qtd_"+qual).attr("value",qtd);
		$("#qtd2_"+qual).html(qtd);
	    }
	});
	
	$("#filtrar").click( function(){
	    oque = $("#caixa_filtro").attr("value");
	    $(".produto").hide();
	    $("#produto_").hide();
        
	});
	$('.abreformapagamento').mouseover(function() {
	    $("#formapagamento").show();
        });
        $('.abreformapagamento').mouseout(function() {
	    $("#formapagamento").hide();
        });
        $(".poe_carrinho").click( function(){
	    idprod = $(this).attr("produto");
            
	});
    });
    function poe_no_carrinho(x){
	conteudo = document.getElementById('carrinho');
	produto = document.getElementById('nome_'+x).value;
	idprod = document.getElementById('idprod_'+x).value;
	qtdprod = document.getElementById('qtdprod_'+x).value;
	obsprod = document.getElementById('obsbox_'+x).value;
    
	conteudo.innerHTML += "<div>";
	conteudo.innerHTML += "<input type='hidden' id='idprod_carrinho_"+idprod+"' value='"+idprod+"'>";
	conteudo.innerHTML += "<input type='hidden' id='qtdprod_carrinho_"+idprod+"' value='"+qtdprod+"'>";
	conteudo.innerHTML += "<input type='hidden' id='obsprod_carrinho_"+idprod+"' value='"+obsprod+"'>";
	conteudo.innerHTML += qtdprod+"x "+produto+"<br/>";
	conteudo.innerHTML += obsprod;
	conteudo.innerHTML += "</div>";
    }
    function show(x){
	oque = document.getElementById(x);
	if(oque.style.display=='block'){
	    oque.style.display = "none";
	}else{
	    oque.style.display = "block";
	}
    }
    function check_show(x,y){
    
	oque = document.getElementById(y);
	oque2 = document.getElementById(x);

	if(oque.checked){
	    oque2.style.display = "block";
	}else{
	    oque2.style.display = "none";
	}
    }
    function erase(x){
	oque = document.getElementById(x);
	oque.value = "";
    }
    function mais(x){
	oque = document.getElementById(x);
	oque.value = parseInt(oque.value) + 1;
    }
    function menos(x){
	oque = document.getElementById(x);
	if(oque.value>1){
	    oque.value = parseInt(oque.value) - 1;
	}
    }

</script>

<script src="js/jquery.js" type="text/javascript"></script>
<script src="js/s3Slider.js" type="text/javascript"></script>
<script>

    

    $(document).ready(function(){  
	left_car=0;
	retorno_car=0;
	if(screen.width==1024){
	    $("#carrinho").css("left","88.5%");
	    left_car="88.5%";
	    retorno_car="67.5%"; 
	}
	else if(screen.width==1280){
	    $("#carrinho").css("left","91%");
	    left_car="91%";
	    retorno_car="74.1%"; 
	}
	else if(screen.width==1366){
	    $("#carrinho").css("left","91.5%");
	    left_car="91.5%";
	    retorno_car="75.8%"; 
	}
	else if(screen.width==320){
	    $("#carrinho").css("left","88.5%");
	    left_car="88.5%";
	    retorno_car="67.5%"; 
	}
	else{
	    $("#carrinho").css("left","91.5%");
	    left_car="91.5%";
	    retorno_car="75.8%"; 
	}
	//Horizontal Sliding 
	  
	$('#movi').hover(function(){  
	    $("#carrinho").stop().animate({left:retorno_car},{queue:false,duration:300});  
	}, function() {  
	    $("#carrinho").stop().animate({left:left_car},{queue:false,duration:300});  
	});  
  
    });  

</script>    

<?php include "menu2.php" ?>
<div id="central" class="span-24">
    <div class="span-6">
	<div id="barra_esquerda">
	    <div id="info_restaurante">
		<div id="categoria_rest"><?= $restaurante->getNomeCategoria() ?>
		</div>
		<div id="nome_rest"><?= $restaurante->nome ?>
		</div>
		<div id="avatar_rest">
		</div>
		<div id="formas_pagamento"><div class="abreformapagamento" >Formas de pagamento</div>
		    <? $fps = RestauranteAceitaFormaPagamento::all(array("conditions" => array("restaurante_id=?", $restaurante->id)));
		    if ($fps) { ?>
    		    <div id="formapagamento" style="display:none; z-index:3; background:#DDD; position:absolute;"><table>
				<? foreach ($fps as $fp) { ?>
				    <tr><th><?= $fp->forma_pagamento->nome ?></th></tr>							
				<? } ?>
    			</table></div>
		    <? } ?>


		</div>
		<div id="tempo_entrega">Tempo de entrega:<img src="background/relogio.gif" width="20" height="19" style="position:relative; top:6px; left:4px;">&nbsp;&nbsp;&nbsp;<?
		    if ($resxbai) {
			foreach ($resxbai as $rxb) {
			    echo $rxb->tempo_entrega . "min";
			}
		    }
		    ?> 
		</div>
	    </div>
	    <div id="filtro" class="prepend-top">
		<img src="background/titulo_filtro.gif" width="74" height="26" alt="Filtro" style="margin-left:25px">
	    </div>	


	</div>
    </div>
    <div class="span-18 last">

	<div class="prepend-top" id="status">
	    <div id="numero_rest" style="color:#FFF" ><span style="margin-left:8px;"> </span>
	    </div> 
	    <div id="status_pedido">
		<img src="background/passo2.png" width="541" height="43" alt="passo1">
	    </div>
	</div>
	<div id="titulo_box_destaque" >
	    Dicas du Chef
	</div>






	<div id="box_destaque" class="radios" >
	    <?
	    $destaques = Produto::find_by_sql("SELECT * FROM produto WHERE destaque=1 AND ativo=1 AND restaurante_id =".$restaurante->id." ORDER BY rand() LIMIT 3");
	    if ($destaques) {
		$c = 1;
		foreach ($destaques as $dest) {
		    ?>
		    <div class="destaque" <? if ($c == 2) {
			echo "style='margin:0 16px;'";
		    } ?> >
			<div class="avatar_destaque">
			</div>
			<div class="titulo_destaque">
			    <?= $dest->nome ?> 
			</div>
			<div class="descricao_destaque">
	<?= $dest->descricao ?>
			</div>
			<div class="preco_destaque">

		    <?= StringUtil::doubleToCurrency($dest->preco) ?>
			    <img src="background/botao_add.gif" width="36" height="30" style="float:left; cursor:pointer;" /> 
			</div>
		    </div>
		<?
		$c++;
	    }
	}
	?>                     
	</div>                

<?
$categorias = TipoProduto::find_by_sql("SELECT TP.* FROM tipo_produto TP INNER JOIN restaurante_tem_tipo_produto RTTP ON TP.id = RTTP.tipoproduto_id WHERE RTTP.restaurante_id = " . $_GET['id']);
if ($categorias) {
    foreach ($categorias as $cat) {
	?>      
		<div class="titulo_box_categoria"><?= $cat->nome ?>
		</div>

		<div id="box_categoria" class="radios" >
		    <?
		    $produtos = Produto::find_by_sql("SELECT P.* FROM produto P INNER JOIN produto_tem_tipo PTT ON P.id = PTT.produto_id WHERE PTT.tipoproduto_id = " . $cat->id . " AND P.restaurante_id = " . $_GET['id']);
		    if ($produtos) {
			$c = 1;
			foreach ($produtos as $prod) {
			    ?>   
			    <div class="produto" <? if ($c % 2 == 1) {
				echo"style='background:#F0F0F0;'";
			    } ?>>
				<div class="titulo_produto">
		<?= $prod->nome ?>
				</div>

				<div class="sup_produto">	        
				    <div class="define_quantidade">
					<div style="float:right">
					    <img src="background/seta_down.gif" class="down" qual="<?= $prod->id ?>" width="10" height="10" style="cursor:pointer" />
					</div>
					<div style="float:right; margin:0 3px;">
					    <input type="hidden" value="0" name="qtd_<?= $prod->id ?>" id="qtd_<?= $prod->id ?>" /><div id="qtd2_<?= $prod->id ?>">0</div>
					</div> 
					<div style="float:right">
					    <img src="background/seta_up.gif" class="up" qual="<?= $prod->id ?>" width="10" height="10" style="cursor:pointer" />
					</div>
				    </div>

				    <div class="preco_produto" ><?= StringUtil::doubleToCurrency($prod->preco) ?>
				    </div> 
				</div>

				<div class="texto_produto">
		<?= $prod->descricao ?>
				</div>

				<div style="width:230px; height:21px; float:right;  padding-top:10px;">

				    <div style="float:right; position:relative;">
                                        <input type="hidden" id="carda_id_<?= $prod->id ?>" value="<?= $prod->id ?>">
                                        <input type="hidden" id="carda_nome_<?= $prod->id ?>" value="<?= $prod->nome ?>">
                                        
					<img class="poe_carrinho" produto="<?= $prod->id ?>" src="background/botao_add.gif" width="25" height="21" style="margin:0 8px; cursor:pointer;"/>
				    </div>
				    <div style="float:right; width:50px; margin-right:19px; height:21px; background:#B2B2B2; border:0;" class="radios">
				    </div>
				</div>      
			    </div>
			<?
			$c++;
		    }
		}
		?>
		</div>
    <? }
} ?> 





    </div>
</div>
<?php include "carrinho.php" ?>
<? include("include/footer.php"); ?>