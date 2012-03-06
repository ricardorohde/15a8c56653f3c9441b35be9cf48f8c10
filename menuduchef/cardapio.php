<?
include("include/header.php");


//$itens = Produto::find_all_by_restaurante_id($_GET['id'], array("order" => "nome asc"));
if ($enderecoSession) {
    $categorias = RestauranteTemTipoProduto::all(array('conditions' => array('restaurante_id = ?', $_GET['id'])));
    $restaurante = Restaurante::find($_GET['id']);
    $rxb = RestauranteAtendeBairro::find(array('conditions' => array('restaurante_id = ? and bairro_id=?', $_GET['id'], $enderecoSession->bairro_id)));
}

if($_POST){
    if($_POST['action']=='finaliza_carrinho'){
        echo "<script>alert('fifi')</script>";
        $de_buenas = 1;
        foreach($_POST as $key => $valor){
            if(substr($key,0,9)=="qtd_prod_"){
                if($valor<1){
                    $de_buenas = 0;
                }
            }
        }
        if($de_buenas){
            echo "<script>alert('debubu')</script>";
            if($_SESSION['pedido_id']){
                $idped = $_SESSION['pedido_id'];
                $prods=PedidoTemProduto::all(array("conditions"=>array("pedido_id = ?",$idped)));
                foreach($prods as $prod){
                    $prod->delete();
                }
            }else{
                echo "<script>alert('cricri')</script>";
                $data['consumidor_id'] = $consumidorSession->id;
                $data['restaurante_id'] = $restaurante->id;
                $data['forma_pagamento'] = "";
                $data['troco'] = 0;
                $data['cupom'] = "";
                $data['endereco'] = "";
                $data['situacao'] = "";
                $data['pagamento_efetuado'] = 0;
                $data['preco_entrega'] = $rxb->preco_entrega;
                
                $ped = new Pedido($data);
                $ped->save();
                var_dump($ped);
                $idped = $ped->id;
                
                echo "<br/><br/>".$idped;
            }
            foreach($_POST as $key => $valor){
                if(substr($key,0,8)=="id_prod_"){
                    $quebra = explode("_",$key);
                    $prod=Produto::find(array("conditions"=>array("restaurante_id = ? AND id = ?",$restaurante->id,$quebra[2])));
                    if($prod){
                        $data2['pedido_id'] = $idped;
                        $data2['produto_id'] = $prod->id;
                        $data2['qtd'] = $_POST['qtd_prod_'.$quebra[2]];
                        $data2['obs'] = $_POST['obs_prod_'.$quebra[2]];
                        $data2['tamanho'] = "";
                        $data2['produto_id2'] = 0;
                        $data2['produto_id3'] = 0;
                        $data2['produto_id4'] = 0;
                        $data2['preco_unitario'] = $_POST['qtd_prod_'.$quebra[2]];
                        
                        $pro = new PedidoTemProduto($data2);
                        $pro->save();
                    }
                }
            }     
        }
    }
}
?>
<script>
    
    function getElementByClass(theClass) {
        var allHTMLTags = new Array();
        var selectedElements = new Array();
        var allHTMLTags=document.getElementsByTagName("*");
        for (i=0; i<allHTMLTags.length; i++) {
            if (allHTMLTags[i].className==theClass) {
                selectedElements.push(allHTMLTags[i]);
            }
        }
        return selectedElements;
    }
    
    function number_format( number, decimals, dec_point, thousands_sep ) {
        // %        nota 1: Para 1000.55 retorna com precis�o 1 no FF/Opera � 1,000.5, mas no IE � 1,000.6
        // *     exemplo 1: number_format(1234.56);
        // *     retorno 1: '1,235'
        // *     exemplo 2: number_format(1234.56, 2, ',', ' ');
        // *     retorno 2: '1 234,56'
        // *     exemplo 3: number_format(1234.5678, 2, '.', '');
        // *     retorno 3: '1234.57'
        // *     exemplo 4: number_format(67, 2, ',', '.');
        // *     retorno 4: '67,00'
        // *     exemplo 5: number_format(1000);
        // *     retorno 5: '1,000'
        // *     exemplo 6: number_format(67.311, 2);
        // *     retorno 6: '67.31'

        var n = number, prec = decimals;
        n = !isFinite(+n) ? 0 : +n;
        prec = !isFinite(+prec) ? 0 : Math.abs(prec);
        var sep = (typeof thousands_sep == "undefined") ? ',' : thousands_sep;
        var dec = (typeof dec_point == "undefined") ? '.' : dec_point;

        var s = (prec > 0) ? n.toFixed(prec) : Math.round(n).toFixed(prec); //fix for IE parseFloat(0.55).toFixed(0) = 0;

        var abs = Math.abs(n).toFixed(prec);
        var _, i;

        if (abs >= 1000) {
            _ = abs.split(/\D/);
            i = _[0].length % 3 || 3;

            _[0] = s.slice(0,i + (n < 0)) +
                  _[0].slice(i).replace(/(\d{3})/g, sep+'$1');

            s = _.join(dec);
        } else {
            s = s.replace('.', dec);
        }

        return s;
    }
</script>
<script>

    $(document).ready(function() {
        contador = 0; //usado pra impedir que o vetor com a lista de pedidos do carrinho se repita
        
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
	    if(parseInt(qtd)>1){
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
            qtd = $("#qtd_"+idprod).attr("value");
            nome = $("#carda_nome_"+idprod).attr("value");
            obsprod = $("#carda_obs_"+idprod).attr("value");
            ja_tem_no_carrinho = 0;
            alvo = "";
            valor_total = 0; //esse � o valor de todos os itens somados, que da o total la do carrinho
            taxa_entrega = parseInt($("#taxa_de_entrega").attr("value"));
            
            vetor = getElementByClass("lista_carrinho");
            
            for(var i in vetor){
                qual = vetor[i].id;
                if(qual.substr(0,7)=="id_prod"){
                    qual = qual.split("_");
                    if((qual[0]=="id")&&(qual[1]=="prod")){
                        if(vetor[i].value==idprod){
                            obs = document.getElementById("obs_prod_"+qual[2]).value;

                            if(obs==obsprod){ //depois acrscente o criterio dos acompanhamentos
                                ja_tem_no_carrinho = 1;
                                alvo = qual[2];
                            }
                        }
                        
                        valor_total += parseInt(document.getElementById("preco_prod_"+qual[2]).value);
                    }
                }
            }

            preco = obter_preco(idprod);
            
            if(ja_tem_no_carrinho==0){
                numero = parseInt(document.getElementById("contador_itens").value);
                document.getElementById("contador_itens").value = numero + 1;
                item_no_carrinho = '<div id="produto_box_'+numero+'" style="margin:5px;">';
                item_no_carrinho += '<div onclick=\'destroi_box("'+numero+'")\'>X</div>';
                item_no_carrinho += '<div><span id="span_qtd_prod_'+numero+'">'+qtd+'x</span>';
                item_no_carrinho += '<input type="hidden" id="qtd_prod_'+numero+'" name="qtd_prod_'+numero+'" value="'+qtd+'">';
                item_no_carrinho += nome;                        
                item_no_carrinho += '<input type="hidden" id="id_prod_'+numero+'" name="id_prod_'+numero+'" class="lista_carrinho" value="'+idprod+'">';
                preco *= qtd;
                item_no_carrinho += '<div id="div_preco_prod_'+numero+'" style="float:right;">R$ '+number_format(preco, 2, ',', '.')+'</div>';
                item_no_carrinho += '<input type="hidden" id="preco_prod_'+numero+'"  class="preco_carrinho" value="'+preco+'" >';
                item_no_carrinho += '</div>';
                
                item_no_carrinho += '<div>';
                item_no_carrinho += '<span  style="font-size:10px;" id="span_obs_prod_'+numero+'">'+obsprod+'</span>';
                item_no_carrinho += '<input type="hidden" id="obs_prod_'+numero+'" name="obs_prod_'+numero+'" value="'+obsprod+'">';
                item_no_carrinho += '</div>';

                item_no_carrinho += '</div>';
                
                $('#campo_pedido_detalhado').append($(item_no_carrinho));
                
                valor_total += preco;
            }else{
                qtd_ = parseInt(qtd) + parseInt(document.getElementById("qtd_prod_"+alvo).value);
                valor_total += (qtd * preco);
                preco *= qtd_;
                document.getElementById("qtd_prod_"+alvo).value = qtd_;
                document.getElementById("span_qtd_prod_"+alvo).innerHTML = qtd_+"x";
                document.getElementById("div_preco_prod_"+alvo).innerHTML = "R$ "+number_format(preco, 2, ',', '.');
                document.getElementById("preco_prod_"+alvo).value = preco;
            }
            document.getElementById("subtotal_carrinho").innerHTML = "R$ "+number_format(valor_total, 2, ',', '.');
            document.getElementById("total_carrinho").innerHTML = "R$ "+number_format((valor_total + taxa_entrega), 2, ',', '.');
	});
    });
    function destroi_box(x){
        qual = document.getElementById("produto_box_"+x);
        carrinho = document.getElementById("campo_pedido_detalhado");
        carrinho.removeChild(qual);
        
        valor_total = 0;
        taxa_entrega = parseInt($("#taxa_de_entrega").attr("value"));
 
        vet = getElementByClass("preco_carrinho");
        
        for(var i in vet){
            preco = vet[i].value;
            valor_total += parseInt(preco);
        }
        
        document.getElementById("subtotal_carrinho").innerHTML = "R$ "+number_format(valor_total, 2, ',', '.');
        document.getElementById("total_carrinho").innerHTML = "R$ "+number_format((valor_total + taxa_entrega), 2, ',', '.'); 
    }
    function passa_etapa(){
        $("#form_carrinho").submit();
    }
    function obter_preco(x){
        preco = document.getElementById("carda_preco_"+x).value;
        return preco;
        //acrescente os produtos adicionais depois
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
		    
                        echo $rxb->tempo_entrega . "min";
			
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
                            <div id="box_produto_<?= $prod->id ?>" class="produto" <? if ($c % 2 == 1) {
				echo"style='background:#F0F0F0;'";
			    } ?>>
                                
                               
                                    <? /*  <div id="div_adicionais_<?= $prod->id ?>" style="background:#EEE; display: absolute; display: block;"><table><tr><td><? 
                                            
                                            if($prod->produto_tem_produtos_adicionais){
                                                $aco = "";
                                                $ext = "";
                                                $prodadi = "";
                                                $prodext = "";
                                                foreach($prod->produto_tem_produtos_adicionais as $ptpa){
                                                    if($ptpa->produto_adicional->quantas_unidades_ocupa>0){
                                                        $aco = "Acompanhamentos:<br/>";
                                                        $prodadi .= "<input type='checkbox' name='produto!adicional-".$ptpa->produto_adicional->id."-".$prod->id."' value='1' >&nbsp;".$ptpa->produto_adicional->nome."<br/>";
                                                    }
                                                    if($ptpa->produto_adicional->quantas_unidades_ocupa==0){
                                                        $ext = "Por&ccedil;&otilde;es extras:<br/>";
                                                        $prodext .= "<input type='checkbox' name='produto!adicional-".$ptpa->produto_adicional->id."-".$prod->id."' value='1' >&nbsp;".$ptpa->produto_adicional->nome."<br/>";
                                                    }
                                                }
                                                echo $aco;
                                                echo $prodadi;
                                                echo "</td><td>";
                                                echo $ext;
                                                echo $prodext;
                                            }                                      
                                                 ?></td></tr></table></div> */ ?>
                                
				<div class="titulo_produto">
		<?= $prod->nome ?>
				</div>

				<div class="sup_produto">	        
				    <div class="define_quantidade">
					<div style="float:right">
					    <img src="background/seta_down.gif" class="down" qual="<?= $prod->id ?>" width="10" height="10" style="cursor:pointer" />
					</div>
					<div style="float:right; margin:0 3px;">
					    <input type="hidden" value="1" name="qtd_<?= $prod->id ?>" id="qtd_<?= $prod->id ?>" /><div id="qtd2_<?= $prod->id ?>">1</div>
					</div> 
					<div style="float:right">
					    <img src="background/seta_up.gif" class="up" qual="<?= $prod->id ?>" width="10" height="10" style="cursor:pointer" />
					</div>
				    </div>

				    <div class="preco_produto" ><?= StringUtil::doubleToCurrency($prod->preco) ?>
				    </div>
                                    <input type="hidden" id="carda_preco_<?= $prod->id ?>" value="<?= $prod->preco ?>">
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
				    <div style="float:right; width:50px; margin-right:19px; height:21px; background:#B2B2B2; border:0;" class="radios" onclick="show('carda_obs_<?= $prod->id ?>')">
				    </div>
				</div> 
                                <div id="obs_box_<?= $prod->id ?>">
                                    <textarea id="carda_obs_<?= $prod->id ?>" style="width:300px; height:40px; display:none;"></textarea>
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
<form id="form_carrinho" action="" method="post">
    <input type="hidden" name="action" id="action" value="finaliza_carrinho">
<?php include "carrinho.php" ?>
</form>    
<? include("include/footer.php"); ?>