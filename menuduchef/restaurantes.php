<?
include("include/header.php");
if($_POST){
	if($_GET['bai']){
		$sql = "SELECT  DISTINCT R.* FROM restaurante R INNER JOIN restaurante_atende_bairro RAB ON R.id = RAB.restaurante_id INNER JOIN restaurante_tem_tipo RTT ON R.id = RTT.restaurante_id WHERE R.ativo = 1 AND RAB.bairro_id = ".$_GET['bai']." AND R.nome LIKE '%".$_POST['caixa_filtro']."%' ";
	}else{
		$sql = "SELECT DISTINCT R.* FROM restaurante R INNER JOIN restaurante_tem_tipo RTT ON R.id = RTT.restaurante_id WHERE R.ativo = 1 AND R.nome LIKE '%".$_POST['caixa_filtro']."%' ";
	}
	$pri = 0;
	foreach($_POST as $key => $p){
		$quebra = explode("_",$key);
		if($quebra[0]=="checkrest"){
			if($pri==0){
				$sql .= " AND ( RTT.tiporestaurante_id = ".$quebra[1];
				$pri = 1;
			}
			else{
				$sql .= " OR RTT.tiporestaurante_id = ".$quebra[1];
			}
		}
	}
	if($pri==1){
		$sql .= " ) ";
	}
	$sql2 = $sql;
	$sql .= " ORDER BY R.nome LIMIT 6";
	$restaurantes = Restaurante::find_by_sql($sql);
	
	$rests = Restaurante::find_by_sql($sql2);
	$num_rest = sizeof($restaurantes);
	
}else{
	if($_GET['bai']){
		$restaurantes = Restaurante::find_by_sql("SELECT DISTINCT R.* FROM restaurante R INNER JOIN restaurante_atende_bairro RAB ON R.id = RAB.restaurante_id WHERE R.ativo = 1 AND RAB.bairro_id = ".$_GET['bai']." ORDER BY R.nome LIMIT 6");
		
		$rests = Restaurante::find_by_sql("SELECT DISTINCT R.* FROM restaurante R INNER JOIN restaurante_atende_bairro RAB ON R.id = RAB.restaurante_id WHERE R.ativo = 1 AND RAB.bairro_id = ".$_GET['bai']." ORDER BY R.nome");
		$num_rest = sizeof($rests);
	}else{
		$restaurantes = Restaurante::all(array("conditions" => array("ativo = ?",1), "limit" => "6", "order" => "nome"));
		$num_rest = sizeof($restaurantes);
	}
}

$categorias = TipoRestaurante::all(array("order" => "nome asc"));



?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
"http://www.w3.org/TR/html4/strict.dtd"
>
<html lang="pt">
<head>
<title>Delivery du Chef</title>
   <link rel="stylesheet" href="css_/blueprint/screen.css" type="text/css" media="screen, projection">
   <link rel="stylesheet" href="css_/blueprint/print.css" type="text/css" media="print">  
   <link rel="stylesheet" href="css_/estilo.css" type="text/css" media="screen"> 
   <!--[if lt IE 8]><link rel="stylesheet" href="css_/blueprint/ie.css" type="text/css" media="screen, projection"><![endif]-->

	<script>
    
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
    </script>
</head>
<body>
<div class="container">
	<div id="background_container">
    	<?php include "menu.php" ?>
        <div id="central" class="span-24">
			<div class="span-6">
            	<div id="barra_esquerda">
                	<form action="" method="post">
                    	
                        <div id="seleciona_endereco">
                            <img src="background/titulo_endereco.gif" width="114" height="30" alt="Endereço" style="margin-left:12px">
                            <div style="width:198px; height:25px; margin-left:7px;">
                            </div>
                        </div>
                        <div id="busca">
                            <img src="background/titulo_busca.gif" width="71" height="26" alt="Busca" style="margin-left:12px">
                            <div style="width:198px; height:25px; margin-left:7px;">
                            	<? if($_POST['caixa_filtro']){ ?>
                                <input id="caixa_filtro" name="caixa_filtro" type="text" style="float:left; margin: auto 0; width:140px; position:relative;" value='<?= $_POST['caixa_filtro'] ?>'> 
                                <? }else{ ?>
                                <input id="caixa_filtro" name="caixa_filtro" type="text" style="float:left; margin: auto 0; width:140px; position:relative;"> 
                                 <? } ?>
                                <input type="image" value="submit" id="filtrar" src="background/botao_ok.gif" style="float:right; margin: auto 0; border:0; width:36px; height:22px; position:relative; cursor:pointer;"> <!-- <img id="filtrar" src="background/botao_ok.gif" style="float:right; width:36px; margin-top: 1px; height:22px; position:relative; cursor:pointer;"> -->
                            </div>
                        </div>
                        <div id="filtro">
                            <img src="background/titulo_filtro.gif" width="74" height="26" alt="Filtro" style="margin-left:12px">
                            <div style="padding-top:5px;">
                            <? if($categorias){
                                    foreach($categorias as $categoria){ 
                                        if($_GET['bai']){
                                            //$itens = Restaurante::find_by_sql("SELECT R.* FROM restaurante R INNER JOIN restaurante_tem_tipo RTT ON R.id = RTT.restaurante_id WHERE RTT.tiporestaurante_id = ".$categoria->id." ");
                                            $itens = Restaurante::find_by_sql("SELECT R.* FROM restaurante R INNER JOIN restaurante_atende_bairro RAB ON R.id = RAB.restaurante_id INNER JOIN restaurante_tem_tipo RTT ON R.id = RTT.restaurante_id WHERE RAB.bairro_id = ".$_GET['bai']." AND RTT.tiporestaurante_id = ".$categoria->id." ");
                                        }else{
                                            $itens = Restaurante::find_by_sql("SELECT R.* FROM restaurante R INNER JOIN restaurante_tem_tipo RTT ON R.id = RTT.restaurante_id WHERE RTT.tiporestaurante_id = ".$categoria->id." ");
                                        }
                                        $num = sizeof($itens);
                                        if($num>0){
										
											$checked = "";
											if($_POST){
												if($_POST['checkrest_'.$categoria->id]=="on"){
													$checked = "checked";
												}else{
													$checked = "";
												}
											}
                                        ?>
                                        <div style="color:#CC0000; padding-top:5px; padding-left:12px;"><input type="checkbox" class="filtro_categoria" id="checkrest_<?= $categoria->id ?>" name="checkrest_<?= $categoria->id ?>" onclick="this.form.submit();" <?= $checked ?>> &nbsp;  <?= $categoria->nome ?> (<?= $num ?>)</div>
                                    <? 	}
                                    }
                             } ?>
                             </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="span-18 last">
            	<div style="height:1080px;">
            	<div class="prepend-top" id="status">
                	<div id="numero_rest" style="color:#FFF" ><span style="margin-left:8px;"> </span>
                 	</div> 
                    <div id="status_pedido">
               	    <img src="background/passo.gif" width="540" height="44" alt="passo1">
                    </div>
                </div>
            	<div class="radios prepend-top" id="caixa_sup">
                	<div id="rest_titulo">
                    	<img src="background/titulo_restaurantes.gif" width="168" height="26" alt="Restaurantes" style="margin-top:6px;">
                    </div>
                    <div id="contagem_pag">
                    </div>
            </div>
                <!--    -->
                <? if($restaurantes){
						foreach($restaurantes as $restaurante){ ?>
                <div class="radios prepend-top" id="box_restaurante">
                	<div id="box_interno">
                    	<div id="box_avatar">
                        </div>
                        <div id="box_textos">
                        	<div id="b1">Bebidas</div>
                            <div class="texto_box" id="b2"><?= $restaurante->nome ?></div>
                            <div class="texto_box" id="b3">Horario de funcionamento  |  Forma de pagamento</div>
                            <div class="texto_box" id="b4"></div>
                        </div>
                        <div id="box_botoes">
                        	<div style="width:110px; height:72px;">
                            </div>
                            <div id="botao_pedir">
                       	    	<img src="background/botao_pedir.gif" width="75" height="28" alt="Pedir" style="float:right; margin-bottom:0; cursor:pointer;">
                            </div>
                        </div>
                    </div>
                </div>
                <? 		}
				}else{ ?>
                	
                <? } ?>
                <!--    -->
                <div class="radios prepend-top" id="caixa_sup">
                    <div id="contagem_pag">
                    </div>
                </div>
                </div>
                <div id="rodape" class="prepend-top">
			    	<img src="background/rodape.jpg" width="760" height="69" style="margin-left:-61px;">
                </div>
            </div>
		</div>
	</div>
</div>
</body>
</html>