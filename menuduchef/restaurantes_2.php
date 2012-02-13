<?
include("include/header.php");

$bai = 0;

if($_SESSION['sessao_valida']){
    if($_SESSION['consumidor_id']){
        $endereco = "";
        $enderecos = EnderecoConsumidor::all(array("conditions"=>array("consumidor_id = ?",$_SESSION['consumidor_id'])));
        if($enderecos){
            foreach($enderecos as $ende){
                $sel = "";
                if($_POST){
                    if($ende->id==$_POST['endereco_cliente']){
                        $sel = "selected";
                        $_SESSION['bairro'] = $ende->bairro_id;
                        $_SESSION['endereco_cliente_id'] = $_POST['endereco_cliente'];
                    }
                }else{
                    if($_SESSION['endereco_cliente_id']){
                        if($ende->id==$_SESSION['endereco_cliente_id']){
                            $sel = "selected";
                            $_SESSION['bairro'] = $ende->bairro_id;
                            $_SESSION['endereco_cliente_id'] = $_SESSION['endereco_cliente_id'];
                        }
                    }
                    else if($ende->favorito){
                        $sel = "selected";
                        $_SESSION['bairro'] = $ende->bairro_id;
                        $_SESSION['endereco_cliente_id'] = $ende->id;
                    }
                }
                $endereco .= "<option value='".$ende->id."' ".$sel.">".$ende->logradouro.", ".$ende->numero." - ".$ende->bairro->nome."</option>";
            }
        }
    }else{
        $endereco = "<option value='0'>CEP ".$_SESSION['bairro']."</option>";
    }
}

$bai = $_SESSION['bairro'];
$pag = 1;
$lim1 = 0;
if($_POST){
    
	$_SESSION['bairro'] = $_POST['bairro'];
        if(($_POST['pagina'])&&($_POST['volta_pagina1']==0)){
            $pag = $_POST['pagina'];
            if($pag==1){
                $lim1 = 0;
            }else{
                $lim1 = (($pag - 1) * 6);
            }
        }
    
	if($bai){
		$sql = "SELECT DISTINCT R.*, RAB.preco_entrega, RAB.tempo_entrega FROM restaurante R INNER JOIN restaurante_atende_bairro RAB ON R.id = RAB.restaurante_id INNER JOIN restaurante_tem_tipo RTT ON R.id = RTT.restaurante_id WHERE R.ativo = 1 AND RAB.bairro_id = ".$bai." AND R.nome LIKE '%".$_POST['caixa_filtro']."%' ";
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
	$sql .= " ORDER BY R.nome LIMIT ".$lim1.",6";
	$restaurantes = Restaurante::find_by_sql($sql);
	
	$rests = Restaurante::find_by_sql($sql2);
	$num_rest = sizeof($rests);
	
}else{
	if($bai){
		$restaurantes = Restaurante::find_by_sql("SELECT DISTINCT R.*, RAB.preco_entrega, RAB.tempo_entrega FROM restaurante R INNER JOIN restaurante_atende_bairro RAB ON R.id = RAB.restaurante_id WHERE R.ativo = 1 AND RAB.bairro_id = ".$bai." ORDER BY R.nome LIMIT 6");
		
		$rests = Restaurante::find_by_sql("SELECT DISTINCT R.* FROM restaurante R INNER JOIN restaurante_atende_bairro RAB ON R.id = RAB.restaurante_id WHERE R.ativo = 1 AND RAB.bairro_id = ".$bai." ORDER BY R.nome");
		$num_rest = sizeof($rests);
	}
}

$categorias = TipoRestaurante::all(array("order" => "nome asc"));



?>

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
    
</head>
<body>
<form id="formulario" action="" method="post">
<input type="hidden" id="volta_pagina1" name="volta_pagina1" value="0" >
<div class="container">
	<div id="background_container">
    	<?php include "menu2.php" ?>
        <div id="central" class="span-24">
			<div class="span-6">
            	<div id="barra_esquerda">
                	<div id="seleciona_endereco">
               	    	<img src="background/titulo_endereco.gif" width="114" height="30" alt="Endereço" style="margin-left:12px">
                        <div style="width:198px; height:25px; margin-left:7px;">
                        	<select id="endereco_cliente" name="endereco_cliente" style="width:195px; margin-left:3px;">
                                    <?= $endereco ?>
                            </select>
                        </div>
                    </div>
                    <div id="busca">
               	    	<img src="background/titulo_busca.gif" width="71" height="26" alt="Busca" style="margin-left:12px">
                        <div style="width:198px; height:25px;  margin-left:10px;">
                        	<? if($_POST['caixa_filtro']){ ?>
                                <input id="caixa_filtro" name="caixa_filtro" type="text" style="float:left; margin: auto 0; width:140px; position:relative;" value='<?= $_POST['caixa_filtro'] ?>'> 
                                <? }else{ ?>
                                <input id="caixa_filtro" name="caixa_filtro" type="text" style="float:left; margin: auto 0; width:140px; position:relative;"> 
                                 <? } ?>
                                <input type="image" class="refino" value="submit" id="filtrar" src="background/botao_ok.gif" style="float:right; margin-top:-4px; border:0; width:40px; height:24px; position:relative; cursor:pointer;">                   	    	
                        </div>
                    </div>
                    <div id="filtro">
               	    	<img src="background/titulo_filtro.gif" width="74" height="26" alt="Filtro" style="margin-left:12px">
                        <div style="padding-top:5px;">
                            <? if($categorias){ 
                                    foreach($categorias as $categoria){ 
                                        if($_POST){
                                            if($bai){ 
                                                $itens = Restaurante::find_by_sql("SELECT R.* FROM restaurante R INNER JOIN restaurante_atende_bairro RAB ON R.id = RAB.restaurante_id INNER JOIN restaurante_tem_tipo RTT ON R.id = RTT.restaurante_id WHERE RAB.bairro_id = ".$bai." AND R.nome LIKE '%".$_POST['caixa_filtro']."%' AND RTT.tiporestaurante_id = ".$categoria->id." ");
                                            }
                                        }else{
                                            if($bai){ 
                                                $itens = Restaurante::find_by_sql("SELECT R.* FROM restaurante R INNER JOIN restaurante_atende_bairro RAB ON R.id = RAB.restaurante_id INNER JOIN restaurante_tem_tipo RTT ON R.id = RTT.restaurante_id WHERE RAB.bairro_id = ".$bai." AND RTT.tiporestaurante_id = ".$categoria->id." ");
                                            }
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
                                        <div style="color:#CC0000; padding-top:5px; padding-left:12px;"><input type="checkbox" class="refino" class="filtro_categoria" id="checkrest_<?= $categoria->id ?>" name="checkrest_<?= $categoria->id ?>" <?= $checked ?>> &nbsp;  <?= $categoria->nome ?> (<?= $num ?>)</div>
                                    <? 	}
                                    }
                             } ?>
                             </div>
                    </div>
                </div>
            </div>
            <div class="span-18 last">
            	<div style="height:1050px;">
            	<div class="prepend-top" id="status">
                	<div id="numero_rest"><span style="margin-left:8px;"> </span>
                 	</div> 
                    <div id="status_pedido">
               	    <img src="background/passo.png" width="541" height="43" alt="passo1">
                    </div>
                </div>
            	<div id="caixa_sup">
                	<h1 id="rest_titulo">
                    	Restaurantes 	
                    </h1>
                    <div id="contagem_pag">
                    	<input type="hidden" id="pagina" name="pagina" value="<?
                            if($_POST){
                                if($_POST['pagina']){
                                    echo $_POST['pagina'];
                                }else{
                                    echo 1;
                                }
                            }else{
                                echo 1;
                            }
                        ?>">
                        <? 
                            $contagem_pag = "";
                            $pags = ceil($num_rest/6);
                            $contagem_pag .= "P&aacute;gina ".$pag." de ".$pags."&nbsp&nbsp&nbsp&nbsp";
                            if($pags>1){
                                
                                $contagem_pag .= "<div style='position:relative; float:right;'>";
                                $contagem_pag .= "<div class='pagina' ";
                                if($pag>1){
                                    $contagem_pag .= "onclick='indica_pagina(".($pag - 1).");' ";
                                }
                                $contagem_pag .= "style='position:relative; float:left; margin: 0 2px; cursor:pointer'>«</div>";
                                for($j=0;$j<$pags;$j++){
                                    $contagem_pag .= "<div class='pagina' onclick='indica_pagina(".($j + 1).");' style='position:relative; float:left; margin: 0 5px; cursor:pointer'>".($j+1)."</div>";
                                }
                                $contagem_pag .= "<div class='pagina' ";
                                if($pag<$pags){
                                    $contagem_pag .= "onclick='indica_pagina(".($pag + 1).");' ";
                                }
                                $contagem_pag .= " style='position:relative; float:left; margin: 0 2px; cursor:pointer'>»</div>";
                                $contagem_pag .= "</div>";
                            }
                            echo $contagem_pag;
                        ?>
                    </div>
            	</div>
               
                	<!--    -->
                <? if($restaurantes){
						foreach($restaurantes as $restaurante){ ?>
         
                <div class="radios prepend-top" id="box_restaurante">
                	<div id="box_interno">
                    	<div id="box_avatar">
			    <img src="<?= $restaurante->getUrlImagem() ?>" alt="<?= $restaurante->nome ?>" />
                        </div>
                        <div id="box_textos">
                        	<div id="b1"><?= $restaurante->getNomeCategoria() ?></div>
                            <div class="texto_box" id="b2"><?= $restaurante->nome ?></div>
                            <div class="texto_box" horario="horarios_<?= $restaurante->id ?>" id="b3">
				<span class="abre_horario" horario="horarios_<?= $restaurante->id ?>">Horario de funcionamento</span>  
                                <?  $horarios = HorarioRestaurante::all(array("conditions" => array("restaurante_id = ?",$restaurante->id))); 
                                    if($horarios){ ?>
                                        <div id="horarios_<?= $restaurante->id ?>" style="display:none; z-index:3; background-color: #DDD; position: absolute;"><table>
                                       <? foreach($horarios as $horario){ ?>
                                                <tr><th><b><?= $horario->dia_da_semana ?></b></th><th><?= $horario->hora_inicio1 ?></th><th>&agrave;s</th><th><?= $horario->hora_fim1 ?></th> <? if($horario->hora_inicio2){ ?><th> | </th> <th><?= $horario->hora_inicio2 ?></th><th>&agrave;s</th><th><?= $horario->hora_fim2 ?></th> <? } if($horario->hora_inicio3){ ?> <th> | </th><th><?= $horario->hora_inicio3 ?></th><th>&agrave;s</th><th><?= $horario->hora_fim3 ?></th> <? } ?></tr>   
                                        <? } ?>
                                        </table></div>
                                    <? }
                                
                                ?>
                                
                                | <span class="abre_formapagamento" formapagamento="formapagamento_<?= $restaurante->id ?>"> Forma de pagamento</span>
                                <?  $fps = RestauranteAceitaFormaPagamento::all(array("conditions" => array("restaurante_id = ?",$restaurante->id))); 
                                    if($fps){ ?>
                                        <div id="formapagamento_<?= $restaurante->id ?>" style="display:none; z-index:3; background-color: #DDD; position: absolute;"><table><tr>
                                        <? $col = 1; ?>
                                        <? foreach($fps as $fp){ ?>
                                                <th><?= $fp->forma_pagamento->nome ?></th>   
                                        <? 
                                        $col++;
                                        if($col==2){
                                            $col = 1;
                                            echo "</tr><tr>";
                                        } ?>
                                        <? } ?>
                                        </tr></table></div>
                                    <? }
                                
                                ?>
                            </div>
                            <div class="texto_box" id="b4"><img src="background/relogio.gif" width="15" height="14" title="Tempo de entrega">
                            <?= $restaurante->tempo_entrega ?> min | <img src="background/entrega.gif" width="20" height="14" title="Taxa de entrega"> 
                            <?= StringUtil::doubleToCurrency($restaurante->preco_entrega) ?></div>
                        </div>
                        <div id="box_botoes">
                        	<div style="width:110px; height:72px;">
                            </div>
                            <div id="botao_pedir">
                       	    	<img src="background/botao_pedir.gif" onClick="location.href=('cardapio.php?res=<?= $restaurante->id ?>');" width="75" height="28" alt="Pedir" style="float:right; margin-bottom:0; cursor:pointer;">
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
                    	<?= $contagem_pag; ?>
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
</form>
</body>
</html>