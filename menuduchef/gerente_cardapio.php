<?
session_start();

include("include/header4.php");

if($_SESSION['restaurante_id']){
    $restaurante = $_SESSION['restaurante_id'];
    $usuario = unserialize($_SESSION['usuario']);
    $categorias = RestauranteTemTipoProduto::all(array("order"=>"ordem","conditions" => array("restaurante_id = ?",$restaurante)));
	$rest= Restaurante::find($restaurante);
}
?>
<script type="text/javascript" src="js/jquery-1.6.4.min.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.8.16.custom.min.js"></script>
<script type="text/javascript" src="js/mask.js"></script>
<script>

$(document).ready(function() {
        
    $("#botao_salvar_novo_item").click(function(){
        
        if($("#novoproduto_esta_em_promocao").attr("value")){
            preco = $("#novoproduto_preco_promocional").attr("value");  
        }else{
            preco = $("#novoproduto_preco").attr("value");
        }
        
        //if(preco==""){
        //    alert("O novo item deve conter um preço.");
        //}else{
            if(confirm("O preço do novo item é R$"+preco+", você confirma?")){
                $("#criar_novo_item").submit();
            }
        //}
    });
    $(".promocao").change( function(){
        
        qual = $(this).attr("name");
        qual = qual.split("_");
        qual = qual[4];
        estado = $(this).css("display");

        $("#div_preco_"+qual).toggle();
        $("#div_preco_promocional_"+qual).toggle();
        $("#div_label_preco_"+qual).toggle();
        $("#div_label_preco_promocional_"+qual).toggle();
        $("#div_texto_promocional_"+qual).toggle();
    });
    
    $(".desativar").click( function(){
        qual = $(this).attr("qual");
        nome = $(this).attr("nome");
        con = confirm("Tem certeza que deseja excluir "+nome+"?");
        if(con){    
            $("#produto-"+qual).hide();
            $("#ativo-"+qual).attr("value",0);
        }
    });
    
    $(".desativarc").click( function(){
        qual = $(this).attr("qual");
        nome = $(this).attr("nome");
        con = confirm("Tem certeza que deseja excluir a categoria "+nome+" e todos os seus itens?");
        if(con){    
            $("#categoria_"+qual).hide();
            $("#categoria_ativa_"+qual).attr("value",1);
            $(".ativo_"+qual).attr("value",0);
            nl = $("#categoria_qtd_"+qual).attr("value");
            
            if($("#categoria_ordem_ultimo_"+qual).attr("value")!=0){
                $(".ordem").each(function(){
                    if($("#categoria_ordem_ultimo_"+qual).attr("value")<$(this).attr("value")){
                        ordem = parseInt($(this).attr("value")) - nl;
                        $(this).attr("value", ordem);
                    }
                });
            }
            
            $("#categoria_ordem_"+qual).attr("value",-1);
        }
    });
    
    $(".subirc").click( function(){
        
        $self = $(this).parent().parent().parent();
        $tr = $self;
        $next = $tr.next();
        $prev = $tr.prev();
        qual1 = $self.attr("qual");
        qual2 = $prev.attr("qual");
        nl1 = $("#categoria_qtd_"+qual1).attr("value");
        nl2 = $("#categoria_qtd_"+qual2).attr("value");
        
        if ($prev.length > 0 && 'TR' === $prev[0].tagName) {
             $tr.clone(true).insertBefore($prev[0]);
             $tr.remove();
             
             vq1 = $("#categoria_ordem_"+qual1).attr("value");
             vq2 = $("#categoria_ordem_"+qual2).attr("value");
             $("#categoria_ordem_"+qual1).attr("value",vq2);
             $("#categoria_ordem_"+qual2).attr("value",vq1);
             
             /*$(".produto_ordem_"+qual1).each(function(index){
                 ordem = $(this).value("value") - parseInt(nl2);
                 $(this).value("value",ordem);
             });
             
             $(".produto_ordem_"+qual2).each(function(index){
                 ordem = $(this).value("value") + parseInt(nl1);
                 $(this).value("value",ordem);
             });*/
        }
        
    });
    
    $(".descerc").click( function(){
        
        $self = $(this).parent().parent().parent();
        $tr = $self;
        $next = $tr.next();
        $prev = $tr.prev();
        qual1 = $self.attr("qual");
        qual2 = $next.attr("qual");
        
        if ($next.length > 0 && 'TR' === $next[0].tagName) {
            //alert("HAYAYA");
             $tr.clone(true).insertAfter($next[0]);
             $tr.remove();
             
             vq1 = $("#categoria_ordem_"+qual1).attr("value");
             vq2 = $("#categoria_ordem_"+qual2).attr("value");
             $("#categoria_ordem_"+qual1).attr("value",vq2);
             $("#categoria_ordem_"+qual2).attr("value",vq1);
             
             /*$(".produto_ordem_"+qual1).each(function(index){
                 alert(index + $(this)[index].value);
                 //ordem = $(this).value("value") + parseInt(nl2);
                 //$(this).value("value",ordem);
             });
             
             $(".produto_ordem_"+qual2).each(function(index){
                 ordem = $(this).value("value") - parseInt(nl1);
                 $(this).value("value",ordem);
             }); */
             
             
        }
        
    });
    
    $(".descer").click( function(){
        
        $self = $(this).parent().parent().parent();
        $tr = $self;
        $next = $tr.next();
        $prev = $tr.prev();
        qual1 = $self.attr("qual");
        qual2 = $next.attr("qual");
        
        if ($next.length > 0 && 'TR' === $next[0].tagName) {
            //alert("HAYAYA");
             $tr.clone(true).insertAfter($next[0]);
             $tr.remove();
             vq1 = $("#produto_ordem-"+qual1).attr("value");
             vq2 = $("#produto_ordem-"+qual2).attr("value");
             $("#produto_ordem-"+qual1).attr("value",vq2);
             $("#produto_ordem-"+qual2).attr("value",vq1);
        }
        
    });
    
    $(".subir").click( function(){
        $self = $(this).parent().parent().parent();
        $tr = $self;
        $next = $tr.next();
		$prev = $tr.prev();
		qual1 = $self.attr("qual");
		qual2 = $prev.attr("qual");
        if ($prev.length > 0 && 'TR' === $prev[0].tagName) {
             $tr.clone(true).insertBefore($prev[0]);
			 $tr.remove();
			 vq1 = $("#produto_ordem-"+qual1).attr("value");
			 vq2 = $("#produto_ordem-"+qual2).attr("value");
			 $("#produto_ordem-"+qual1).attr("value",vq2);
			 $("#produto_ordem-"+qual2).attr("value",vq1);
        }
        
    });
    
});

function show(x){
    oque = document.getElementById(x);
    if(oque.style.display == "block"){
        oque.style.display = "none";
    }else{
        oque.style.display = "block";
    }
}

function ja_mexeu(){
    oque = document.getElementById("jamexeu");
    oque.value = 1;
}

function novo_item(){
    oque = document.getElementById("jamexeu");
    if(oque.value == 1){
        alert("Antes salve ou cancele as alterações!");
    }else{
        show("novo_item");
    }
}

function nova_categoria(){
    oque = document.getElementById("jamexeu");
    if(oque.value == 1){
        alert("Antes salve ou cancele as alterações!");
    }else{
        show("nova_categoria");
    }
}
</script>
<script src="js/jquery.js"></script>
<script>
$(document).ready( function (){
	$('.desloca').mouseover(function(){
		$(this).css('margin-left',10);
	});
	$('.desloca').mouseout(function(){
		$(this).css('margin-left',0);
	});
});
</script>

<div class="container">
  <div id="background_container">
    <?php include "menu_gerente.php" ?>
    <form action="php/controller/salva_cardapio" method="post">
      <div id="central" class="span-24">
        <div class="span-6">
          <div id="barra_esquerda">
            <div id="info_restaurante">
              <input type="hidden" id="jamexeu" value="0">
              <div id="dados_cliente" style="padding-top:62px;"> <img class="desloca" src="background/add_item.png" onclick="novo_item()" /> </div>
              <div id="dados_cliente"> <img class="desloca" src="background/add_cat.png" onclick="nova_categoria()" /> </div>
              <div id="dados_cliente" title="Acompanhamentos e porções extras"> <a href="edita_extra.php"> <img class="desloca" src="background/add_extras.png" /> </a> </div>
              <div id="dados_cliente"> <img width="110" height="30" src="background/cancel.png" style="cursor:pointer;" onclick="location.href=('gerente_cardapio');" /> </div>
              <div id="dados_cliente" style="margin-top:8px; margin-left:0;">
                <input style="margin-left:0; padding:0;" type="image" value="submit" width="110" height="30" src="background/salvar.png" />
              </div>
            </div>
          </div>
        </div>
        <div class="span-18 last">
          <div id="titulo_box_destaque"> Controle Gerência </div>
          <div class="titulo_box_concluir" style="margin-top:4px;">Edição de cardápio do
            <?= $rest->nome ?>
            por
            <div style="display:inline; font:Arial; color:#E51B21; font-size:13px;"> Sr(a).
              <?= $usuario->nome ?>
            </div>
          </div>
          <div id="box_concluir">
            <div style="margin-top:16px;" onclick="ja_mexeu()">
              <table>
                <? if($categorias){
                
                  $contador = 0;
                  $contador_categoria = 0;
                    foreach($categorias as $categoria){ ?>
                <tr qual="<?= $categoria->tipoproduto_id ?>" id="categoria_<?= $categoria->tipoproduto_id ?>">
                  <td><table style="width:674px; border:1px solid #bcbec0;">
                      <div style="width:60px; height:20px; float:right; position:relative; background:#bcbec0;">
                        <div class="botoes_cat subirc sdc"> ▲ </div>
                        <div class="botoes_cat descerc sdc"> ▼ </div>
                        <div class="botoes_cat desativarc" qual="<?= $categoria->tipoproduto_id ?>" > Х </div>
                      </div>
                      <input type="hidden" id="categoria_ativa_<?= $categoria->tipoproduto_id ?>" name="categoria!ativa-<?= $categoria->tipoproduto_id ?>" value="0">
                      <input type="hidden" id="categoria_ordem_<?= $categoria->tipoproduto_id ?>" name="categoria!ordem-<?= $categoria->tipoproduto_id ?>" value="<?= $contador_categoria ?>">
                      <tr>
                        <th class="titulo_cat"> <?= $categoria->tipo_produto->nome ?>
                        </th>
                      </tr>
                      <? //N temos ctz do Tbody a baixo (posicao) ?>
                      <tbody>
                        <? 
                        $itens = Produto::find_by_sql("SELECT P.* FROM produto P INNER JOIN produto_tem_tipo PTT ON P.id = PTT.produto_id INNER JOIN restaurante_tem_tipo_produto RTTP ON PTT.tipoproduto_id = RTTP.tipoproduto_id WHERE RTTP.restaurante_id = ".$restaurante." AND PTT.tipoproduto_id = ".$categoria->tipoproduto_id." AND P.restaurante_id = ".$restaurante." AND P.ativo = 1 ORDER BY P.ordem asc");
                        if($itens){
                            $num_linhas = sizeof($itens);
                            foreach($itens as $item){ ?>
                        <? //N temos ctz do Tbody a baixo (posicao) ?>
                        <tr id="produto-<?= $item->id ?>" qual="<?= $item->id ?>">
                          <input type="hidden" id="categoria_qtd_<?= $categoria->tipoproduto_id ?>" value="<?= $num_linhas ?>">
                          <input type="hidden" class="produto_ordem_<?= $categoria->tipoproduto_id ?> ordem" id="produto_ordem-<?= $item->id ?>" name="produto!ordem-<?= $item->id ?>" value="<?= $contador ?>">
                          <td><table style="background:#f1f1f2;">
                              <input type="hidden" name="produto!id-<?= $item->id ?>" value="<?= $item->id ?>">
                              <input type="hidden" id="ativo-<?= $item->id ?>" class="ativo_<?= $categoria->tipoproduto_id ?>" name="produto!ativo-<?= $item->id ?>" value="<?= $item->ativo ?>">
                              <div style="width:60px; height:20px; float:right; position:relative; background:#bcbec0;">
                                <div class="botoes_cat subir sd" qual="<?= $categoria->id ?>_<?= $item->id ?>_<?= $num_linhas ?>"> ▲ </div>
                                <div class="botoes_cat descer sd" qual="<?= $categoria->id ?>_<?= $item->id ?>_<?= $num_linhas ?>"> ▼ </div>
                                <div class="botoes_cat desativar" qual="<?= $item->id ?>"> Х </div>
                              </div>
                              <tr>
                                <td  class="titulo_item" colspan="6"><?= $item->nome ?></td>
                              </tr>
                              <tr>
                                <td> Codigo: </td>
                                <td><input class="inp_ger" type="text" name="produto!codigo-<?= $item->id ?>" value="<?= $item->codigo ?>" /></td>
                                <td> Nome: </td>
                                <td><input class="inp_ger" type="text" id="produto_nome-<?= $item->id ?>" name="produto!nome-<?= $item->id ?>" value="<?= $item->nome ?>" /></td>
                                <td> Tamanho: </td>
                                <td><input class="inp_ger" type="text" name="produto!tamanho-<?= $item->id ?>" value="<?= $item->tamanho ?>"/></td>
                              </tr>
                              <tr>
                                <td> Disponivel: </td>
                                <td><select class="sel_ger" name="produto!disponivel-<?= $item->id ?>">
                                    <option value="1" <? if($item->disponivel){ echo "selected"; } ?>> Sim </option>
                                    <option value="0" <? if(!$item->disponivel){ echo "selected"; } ?>> N&atilde;o </option>
                                  </select></td>
                                <td> Segundo Sabor: </td>
                                <td><select class="sel_ger" name="produto!aceita_segundo_sabor-<?= $item->id ?>">
                                    <option value="1" <? if($item->aceita_segundo_sabor){ echo "selected"; } ?>> Sim </option>
                                    <option value="0" <? if(!$item->aceita_segundo_sabor){ echo "selected"; } ?>> N&atilde;o </option>
                                  </select></td>
                                <td> Destaque: </td>
                                <td><select class="sel_ger" name="produto!destaque-<?= $item->id ?>">
                                    <option value="1" <? if($item->destaque){ echo "selected"; } ?>> Sim </option>
                                    <option value="0" <? if(!$item->destaque){ echo "selected"; } ?>> N&atilde;o </option>
                                  </select></td>
                              </tr>
                              <tr>
                                <td> Qnt. acompanhamentos: </td>
                                <td><input class="inp_ger" type="text" name="produto!qtd_produto_adicional-<?= $item->id ?>" value="<?= $item->qtd_produto_adicional ?>"/></td>
                                <td> Promocional: </td>
                                <td><select onchange="show('div_texto_promocional_<?= $item->id ?>'); show('div_label_preco_<?= $item->id ?>'); show('div_label_preco_promocional_<?= $item->id ?>'); show('descri_promo_<?= $item->id ?>') " class="sel_ger promocao" name="produto!esta_em_promocao-<?= $item->id ?>">
                                    <option value="1" <? if($item->esta_em_promocao){ echo "selected"; } ?>> Sim </option>
                                    <option value="0" <? if(!$item->esta_em_promocao){ echo "selected"; } ?>> N&atilde;o </option>
                                  </select></td>
                                <td><div id="div_label_preco_<?= $item->id ?>" style="display:<?= $item->esta_em_promocao ? "none" : "block" ?>;">Pre&ccedil;o(R$):</div>
                                  <div id="div_label_preco_promocional_<?= $item->id ?>" style="display:<?= $item->esta_em_promocao ? "block" : "none" ?>;">Pre&ccedil;o Promocional(R$):</div></td>
                                <td><div id="div_preco_promocional_<?= $item->id ?>" style="display:<?= $item->esta_em_promocao ? "block" : "none" ?>;">
                                    <input onkeyup="mask_moeda(this)"  class="inp_ger preco" type="text" name="produto!preco_promocional-<?= $item->id ?>" value="<?= $item->preco_promocional ?>">
                                  </div>
                                  <div id="div_preco_<?= $item->id ?>" style="display:<?= $item->esta_em_promocao ? "none" : "block" ?>;">
                                    <input type="text" onkeyup="mask_moeda(this)" class="inp_ger preco" name="produto!preco-<?= $item->id ?>" value="<?= $item->preco ?>">
                                  </div></td>
                              </tr>
                              <tr>
                                <td><div id="div_texto_promocional_<?= $item->id ?>" style="display:<?= $item->esta_em_promocao ? "block" : "none" ?>;">Texto da promo&ccedil;&atilde;o:</div></td>
                                <td><input id="descri_promo_<?= $item->id ?>" style="display:<?= $item->esta_em_promocao ? "block" : "none" ?>;" class="inp_ger" type="text" name="produto!texto_promocao-<?= $item->id ?>" value="<?= $item->texto_promocao ?>"></td>
                                <td> Descrição: </td>
                                <td colspan="3"><input class="inp_ger" style="width:287px;" type="text"  name="produto!descricao-<?= $item->id ?>" value="<?= $item->descricao ?>"/></td>
                              </tr>
                              <tr style="height:6px;"> </tr>
                              <tr onclick="show('div_adicionais_<?= $item->id ?>')">
                                <td colspan="3" style="text-align:right; background:#F8F8F8; cursor:pointer; color:#F90"> Acompanhamentos </td>
                                <td colspan="3" style="text-align:left; background:#F8F8F8; cursor:pointer; color:#F90"> | &nbsp;Porções Extras </td>
                              </tr>
                              <tr style=" background:#F8F8F8;">
                                <td colspan="6"><div id="div_adicionais_<?= $item->id ?>" style="display:none;">
                                    <table>
                                      <tr>
                                        <td><table style="background:#E8F3FF; width:316px">
                                            <tr>
                                              <?     
                                                        $acos = ProdutoAdicional::all(array("conditions"=>array("restaurante_id = ? AND ativo = ? AND quantas_unidades_ocupa > ?",$restaurante,1,0)));
                                                        $exts = ProdutoAdicional::all(array("conditions"=>array("restaurante_id = ? AND ativo = ? AND quantas_unidades_ocupa = ?",$restaurante,1,0)));
														$c=0;
														
                                                        if($acos){
                                                            foreach($acos as $aco){
																if($c==3){
																	echo "</tr><tr>";
																	$c=0;
																	}
                                                                $sel="";
                                                                if($item->temProdutoAdicional($aco->id)){
                                                                    $sel="checked";
                                                                }
                                                                echo "<td><input type='checkbox' name='produto!adicional-".$aco->id."-".$item->id."' value='1' ".$sel.">".$aco->nome."</td>";
																$c++;
                                                            }
                                                        }
                                                        echo "</tr></table></td><td><table style='background:#FFF2E6; width:316px'><tr>";
														$c=0;
                                                        if($exts){
                                                            foreach($exts as $ext){
																if($c==3){
																	echo "</tr><tr>";
																	$c=0;
																	}
                                                                $sel="";
                                                                if($item->temProdutoAdicional($ext->id)){
                                                                    $sel="checked";
                                                                }
                                                                echo "<td><input type='checkbox' name='produto!adicional-".$ext->id."-".$item->id."' value='1' ".$sel.">".$ext->nome."</td>";				
																$c++;
                                                            }
                                                        }
                                                             ?>
                                            </tr>
                                          </table></td>
                                      </tr>
                                    </table>
                                  </div></td>
                              </tr>
                            </table></td>
                        </tr>
                        <? $contador++; } ?>
                      <input type="hidden" id="categoria_ordem_ultimo_<?= $categoria->tipoproduto_id ?>" value="<?= ($contador -1) ?>">
                      <? }
                        else{ ?>
                      <input type="hidden" id="categoria_qtd_<?= $categoria->tipoproduto_id ?>" value="0">
                      <input type="hidden" id="categoria_ordem_ultimo_<?= $categoria->tipoproduto_id ?>" value="0">
                      <? }
                        ?>
                    </table></td>
                </tr>
                <? $contador_categoria++; }}?>
              </table>
            </div>
          </div>
        </div>
      </div>
    </form>
    <div id="novo_item" style="display:none; position:absolute; padding:10px; background: #CCF; z-index:50; left:40%; top:45%;">
      <form id="criar_novo_item" action="php/controller/salva_cardapio" method="post">
        Novo Item:
        <input type="hidden" name="novoproduto!ordem" value="<?= $contador ?>">
        <table border="0" cellspacing="0" style="width:650px; padding: 0px;">
          <input type="hidden" name="novoproduto!ativo" value="1">
          <tr>
            <td><table>
                <tr>
                  <td>Categoria:</td>
                  <td><select name="novoproduto!categoria" >
                      <? foreach($categorias as $categoria){ echo "<option value='".$categoria->tipo_produto->id."'>".$categoria->tipo_produto->nome."</option>"; } ?>
                    </select></td>
                </tr>
              </table></td>
          </tr>
          <tr>
            <td><table>
                <tr>
                  <td style="background:#F00;">Dispon&iacute;vel no momento: </td>
                  <td style="width:45px; background:#FF0;"><select name="novoproduto!disponivel">
                      <option value="1" selected> Sim </option>
                      <option value="0" > N&atilde;o </option>
                    </select></td>
                  <td style="background:#F00;">ASS: </td>
                  <td style="width:45px; background:#FF0;"><select name="novoproduto!aceita_segundo_sabor">
                      <option value="1" > Sim </option>
                      <option value="0" selected> N&atilde;o </option>
                    </select></td>
                  <td style="background:#F00;">DEST: </td>
                  <td style="width:45px; background:#FF0;"><select name="novoproduto!destaque">
                      <option value="1"> Sim </option>
                      <option value="0" selected> N&atilde;o </option>
                    </select></td>
                </tr>
              </table></td>
          </tr>
          <tr>
            <td><table>
                <tr>
                  <td>C&oacute;digo: </td>
                  <td><input style="width:27px;" type="text" name="novoproduto!codigo" value=""></td>
                  <td>Nome: </td>
                  <td><input type="text" name="novoproduto!nome" value=""></td>
                  <td>Tamanho: </td>
                  <td><input type="text" style="width:80px;" name="novoproduto!tamanho" value=""></td>
                </tr>
              </table></td>
          </tr>
          <tr>
            <td><table>
                <tr>
                  <td>Descri&ccedil;&atilde;o:</td>
                  <td><input style="width:300px;" type="text"  name="novoproduto!descricao" value=""></td>
                </tr>
              </table></td>
          </tr>
          <tr>
            <td><table>
                <tr>
                  <td>Qtd Acompanhamentos:</td>
                  <td><input class="inp_ger" type="text" name="novoproduto!qtd_produto_adicional" style="width:20px;" value="0"></td>
                  <td><input class="inp_ger" type="button" onclick="show('div_adicionais')" value="Acompanhamentos e Por&ccedil;&otilde;es Extras">
                    <div id="div_adicionais" style="background:#0A6; display: none;">
                      <table>
                        <tr>
                          <td><?     
                $acos = ProdutoAdicional::all(array("conditions"=>array("restaurante_id = ? AND ativo = ? AND quantas_unidades_ocupa > ?",$restaurante,1,0)));
                $exts = ProdutoAdicional::all(array("conditions"=>array("restaurante_id = ? AND ativo = ? AND quantas_unidades_ocupa = ?",$restaurante,1,0)));
                if($acos){
                    echo "Acompanhamentos:<br/>";
                    foreach($acos as $aco){
                        echo "<input type='checkbox' name='novoproduto!adicional-".$aco->id."' value='1'>".$aco->nome."<br/>";
                    }
                }
                echo "</td><td>";
                if($exts){
                    echo "Por&ccedil;&otilde;es extras:<br/>";
                    foreach($exts as $ext){
                        echo "<input type='checkbox' name='novoproduto!adicional-".$ext->id."' value='1' >".$ext->nome."<br/>";
                    }
                }
                     ?></td>
                        </tr>
                      </table>
                    </div></td>
                </tr>
              </table></td>
          </tr>
          <tr>
            <td><table>
                <tr>
                  <td style="width:68px;">Est&aacute; em promo&ccedil;&atilde;o:</td>
                  <td style="width:45px; background:#AAA;"><select onchange="show('div_texto_promocional')" class="promocao" id="novoproduto_esta_em_promocao" name="novoproduto!esta_em_promocao">
                      <option value="1" > Sim </option>
                      <option value="0" selected> N&atilde;o </option>
                    </select></td>
                  <td style="background:#09f; width:130px;"><div id="div_label_preco" style="display:block; position:relative; float:right;">Pre&ccedil;o:</div>
                    <div id="div_label_preco_promocional" style="display:none;">Pre&ccedil;o Promocional:</div></td>
                  <td style="width:10px; background: #006;">R$</td>
                  <td><div id="div_preco_promocional" style="display:none;">
                      <input onkeyup="mask_moeda(this)"  class="preco" style="width:50px;" type="text" id="novoproduto_preco_promocional" name="novoproduto!preco_promocional" value="">
                    </div>
                    <div id="div_preco" style="display:block;">
                      <input style="width:50px;" type="text" onkeyup="mask_moeda(this)" class="preco" id="novoproduto_preco" name="novoproduto!preco" value="">
                    </div></td>
                </tr>
              </table></td>
          </tr>
          <tr>
            <td><div id="div_texto_promocional" style="display:none">
                <table>
                  <tr>
                    <td style="width:68px;">Texto da promo&ccedil;&atilde;o:</td>
                    <td><input type="text" style="width:300px;" name="novoproduto!texto_promocao" value=""></td>
                  </tr>
                </table>
                
                  <tr>
                    <td><input type="button" id="botao_salvar_novo_item" value="Salvar">
                      <input type="button" onclick="show('novo_item')" value="Cancelar"></td>
                  </tr>
              </div></td>
          </tr>
        </table>
      </form>
    </div>
    <div id="nova_categoria" style="display:none; position:absolute; padding:10px; background: #CCF; z-index:50; left:40%; top:45%;">
      <form action="php/controller/salva_cardapio" method="post">
        Nova Categoria:
        <input type="hidden" name="novacategoria!ordem" value="<?= $contador_categoria ?>">
        <table border="0" cellspacing="0" style="width:650px; padding: 0px;">
          <tr>
            <td>Nome: </td>
            <td><input type="text" name="novacategoria!nome" value=""></td>
          </tr>
          <tr>
            <td><input type="submit" value="Salvar">
              <input type="button" onclick="show('nova_categoria')" value="Cancelar"></td>
          </tr>
        </table>
      </form>
    </div>
  </div>
</div>
<? include("include/footer.php"); ?>
