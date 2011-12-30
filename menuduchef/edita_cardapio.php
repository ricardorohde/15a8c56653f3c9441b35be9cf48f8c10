<?
session_start();

include("include/header2.php");

if($_SESSION['restaurante_id']){
    $restaurante = $_SESSION['restaurante_id'];
    $usuario = unserialize($_SESSION['usuario']);
    $categorias = RestauranteTemTipoProduto::all(array("conditions" => array("restaurante_id = ?",$restaurante)));
}
?>

<script type="text/javascript" src="js/jquery-1.6.4.min.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.8.16.custom.min.js"></script>
<script type="text/javascript" src="js/mask.js"></script>



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
    
   /* $(document.getElementsByTagName('tbody')[0].childNodes).find('a').bind('click',function(){

      switch(_hash) {
       case '.descer':
           alert("DESCE");
        if ($next.length > 0 && 'TR' === $next[0].tagName) {
         $tr.clone(true).insertAfter($next[0]);
         $tr.remove();
        }
       break;
       default:
           alert("SUBIR");
        if ($prev.length > 0 && 'TR' === $prev[0].tagName) {
         $tr.clone(true).insertBefore($prev[0]);
         $tr.remove();
        }
      }
     }); */
    
    $(".descer").click( function(){
        $self = $(this).parent().parent().parent().parent().parent().parent().parent().parent().parent().parent();
        $tr = $self;
        $next = $tr.next();
        $prev = $tr.prev();
        qual1 = $self.attr("qual");
        qual2 = $next.attr("qual");
        
        if ($next.length > 0 && 'TR' === $next[0].tagName) {
             $tr.clone(true).insertAfter($next[0]);
             $tr.remove();
             vq1 = $("#produto_ordem-"+qual1).attr("value");
             vq2 = $("#produto_ordem-"+qual2).attr("value");
             $("#produto_ordem-"+qual1).attr("value",vq2);
             $("#produto_ordem-"+qual2).attr("value",vq1);
        }
        
    });
    
    $(".subir").click( function(){
        
        $self = $(this).parent().parent().parent().parent().parent().parent().parent().parent().parent().parent();
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
</script>

<form action="php/controller/salva_cardapio" method="post">
<div>
    <input type="hidden" id="jamexeu" value="0">
    <div style="float:left; position: relative; padding-left: 20px; padding-right: 50px;">
        <table class="list">
            <tr><td><input type="button" value="Acrescentar Item" onclick="novo_item()"></td></tr>
            <tr><td><input type="submit" value="Salvar Altera&ccedil;&otilde;es"></td></tr>
            <tr><td><input type="button" onclick="location.href=('edita_cardapio');" value="Cancelar"></td></tr> 
            <tr><td><input type="button" onclick="location.href=('area_adm_restaurante');" value="Voltar"></td></tr>
        </table>
    </div>
     
    
    
    <div onclick="ja_mexeu()" id="drop" style="float:left; position: relative;">
        
            <? if($categorias){
                
                  $contador = 0;
                    foreach($categorias as $categoria){ ?>
                        <div class="itemDrag categoria" id="categoria_<?= $categoria->tipoproduto_id ?>" ><table border='1'><tr><th><?= $categoria->tipo_produto->nome ?><div style="position:relative; float:right;"><input type="button" class="subir sdc" value="^"><input type="button" class="descer sdc" value="v"><input type="button" class="desativarc" qual="<?= $categoria->id ?>" value="X"></div></th></tr>
                        <tbody>
                    <? 
                        $itens = Produto::find_by_sql("SELECT P.* FROM produto P INNER JOIN produto_tem_tipo PTT ON P.id = PTT.produto_id INNER JOIN restaurante_tem_tipo_produto RTTP ON PTT.tipoproduto_id = RTTP.tipoproduto_id WHERE RTTP.restaurante_id = ".$restaurante." AND PTT.tipoproduto_id = ".$categoria->tipoproduto_id." AND P.restaurante_id = ".$restaurante." AND P.ativo = 1 ORDER BY P.ordem asc");
                        if($itens){
                            $num_linhas = sizeof($itens);
                            foreach($itens as $item){ ?>
                                <tr id="produto-<?= $item->id ?>" qual="<?= $item->id ?>"><td>
                                        <input type="hidden" id="produto_ordem-<?= $item->id ?>" name="produto!ordem-<?= $item->id ?>" value="<?= $contador ?>">
                                           <table border="0" cellspacing="0" style="width:650px; padding: 0px;">
                                               <input type="hidden" name="produto!id-<?= $item->id ?>" value="<?= $item->id ?>">
                                               <input type="hidden" id="ativo-<?= $item->id ?>" name="produto!ativo-<?= $item->id ?>" value="<?= $item->ativo ?>">
                                               <tr><td><table><tr><td style="background:#F00;">Dispon&iacute;vel no momento: </td><td style="width:45px; background:#FF0;"><select name="produto!disponivel-<?= $item->id ?>"><option value="1" <? if($item->disponivel){ echo "selected"; } ?>> Sim </option><option value="0" <? if(!$item->disponivel){ echo "selected"; } ?>> N&atilde;o </option></select></td><td style="background:#F00;">ASS: </td><td style="width:45px; background:#FF0;"><select name="produto!aceita_segundo_sabor-<?= $item->id ?>"><option value="1" <? if($item->aceita_segundo_sabor){ echo "selected"; } ?>> Sim </option><option value="0" <? if(!$item->aceita_segundo_sabor){ echo "selected"; } ?>> N&atilde;o </option></select></td><td style="background:#F00;">DEST: </td><td style="width:45px; background:#FF0;"><select name="produto!destaque-<?= $item->id ?>"><option value="1" <? if($item->destaque){ echo "selected"; } ?>> Sim </option><option value="0" <? if(!$item->destaque){ echo "selected"; } ?>> N&atilde;o </option></select></td><td><input type="button" class="subir sd" qual="<?= $categoria->id ?>_<?= $item->id ?>_<?= $num_linhas ?>" value="^"><input type="button" class="descer sd" qual="<?= $categoria->id ?>_<?= $item->id ?>_<?= $num_linhas ?>" value="v"></td><td><input type="button" class="desativar" nome="<?= $item->nome ?>" qual="<?= $item->id ?>" value="X"></td></tr></table></td></tr>
                                               <tr><td><table><tr><td>C&oacute;digo: </td><td><input style="width:27px;" type="text" name="produto!codigo-<?= $item->id ?>" value="<?= $item->codigo ?>"></td><td>Nome: </td><td><input type="text" id="produto_nome-<?= $item->id ?>" name="produto!nome-<?= $item->id ?>" value="<?= $item->nome ?>"></td><td>Tamanho: </td><td><input type="text" style="width:80px;" name="produto!tamanho-<?= $item->id ?>" value="<?= $item->tamanho ?>"></td></tr></table></td></tr>
                                               <tr><td><table><tr><td>Descri&ccedil;&atilde;o:</td><td><input style="width:300px;" type="text"  name="produto!descricao-<?= $item->id ?>" value="<?= $item->descricao ?>"></td></tr></table></td></tr>
                                               <tr><td><table><tr><td>Qtd Acompanhamentos:</td><td><input type="text" name="produto!qtd_produto_adicional-<?= $item->id ?>" style="width:20px;" value="<?= $item->qtd_produto_adicional ?>"></td><td><input type="button" onclick="show('div_adicionais_<?= $item->id ?>')" value="Acompanhamentos e Por&ccedil;&otilde;es Extras">
                                                  <div id="div_adicionais_<?= $item->id ?>" style="background:#0A6; display: none;"><table><tr><td><?     
                                                        $acos = ProdutoAdicional::all(array("conditions"=>array("restaurante_id = ? AND ativo = ? AND quantas_unidades_ocupa > ?",$restaurante,1,0)));
                                                        $exts = ProdutoAdicional::all(array("conditions"=>array("restaurante_id = ? AND ativo = ? AND quantas_unidades_ocupa = ?",$restaurante,1,0)));
                                                        if($acos){
                                                            echo "Acompanhamentos:<br/>";
                                                            foreach($acos as $aco){
                                                                $sel="";
                                                                if($item->temProdutoAdicional($aco->id)){
                                                                    $sel="checked";
                                                                }
                                                                echo "<input type='checkbox' name='produto!adicional-".$aco->id."-".$item->id."' value='1' ".$sel.">".$aco->nome."<br/>";
                                                            }
                                                        }
                                                        echo "</td><td>";
                                                        if($exts){
                                                            echo "Por&ccedil;&otilde;es extras:<br/>";
                                                            foreach($exts as $ext){
                                                                $sel="";
                                                                if($item->temProdutoAdicional($ext->id)){
                                                                    $sel="checked";
                                                                }
                                                                echo "<input type='checkbox' name='produto!adicional-".$ext->id."-".$item->id."' value='1' ".$sel.">".$ext->nome."<br/>";
                                                            }
                                                        }
                                                             ?> </td></tr></table></div></td></tr></table></td></tr>
                                               <tr><td><table><tr><td style="width:68px;">Est&aacute; em promo&ccedil;&atilde;o:</td><td style="width:45px; background:#AAA;"><select onchange="show('div_texto_promocional_<?= $item->id ?>')" class="promocao" name="produto!esta_em_promocao-<?= $item->id ?>"><option value="1" <? if($item->esta_em_promocao){ echo "selected"; } ?>> Sim </option><option value="0" <? if(!$item->esta_em_promocao){ echo "selected"; } ?>> N&atilde;o </option></select></td><td style="background:#09f; width:130px;"><div id="div_label_preco_<?= $item->id ?>" style="display:<?= $item->esta_em_promocao ? "none" : "block" ?>; position:relative; float:right;">Pre&ccedil;o:</div><div id="div_label_preco_promocional_<?= $item->id ?>" style="display:<?= $item->esta_em_promocao ? "block" : "none" ?>; position:relative; float:right;">Pre&ccedil;o Promocional:</div></td><td style="width:10px; background: #006;">R$</td><td><div id="div_preco_promocional_<?= $item->id ?>" style="display:<?= $item->esta_em_promocao ? "block" : "none" ?>;"><input onkeyup="mask_moeda(this)"  class="preco" style="width:50px;" type="text" name="produto!preco_promocional-<?= $item->id ?>" value="<?= $item->preco_promocional ?>"></div><div id="div_preco_<?= $item->id ?>" style="display:<?= $item->esta_em_promocao ? "none" : "block" ?>;"><input style="width:50px;" type="text" onkeyup="mask_moeda(this)" class="preco" name="produto!preco-<?= $item->id ?>" value="<?= $item->preco ?>"></td></tr></table></div></td></tr>
                                               <tr><td><div id="div_texto_promocional_<?= $item->id ?>" style="display:<?= $item->esta_em_promocao ? "block" : "none" ?>;"><table><tr><td style="width:68px;">Texto da promo&ccedil;&atilde;o:</td><td><input type="text" style="width:300px;" name="produto!texto_promocao-<?= $item->id ?>" value="<?= $item->texto_promocao ?>"></td></tr></table>
                                     </table></td></tr>

                           <? $contador++; }
                        }?>
                        </tbody>                      
                        </table>
                         </div>
                    <?}
                
             } ?>
    </div>
</div>
</form>

<div id="novo_item" style="display:none; position:absolute; padding:10px; background: #CCF; z-index:50; left:40%; top:45%;">
 <form action="php/controller/salva_cardapio" method="post"> 
    Novo Item:
   <input type="hidden" name="novoproduto!ordem" value="<?= $contador ?>">
   <table border="0" cellspacing="0" style="width:650px; padding: 0px;">
       <input type="hidden" name="novoproduto!ativo" value="1">
       
       <tr><td><table><tr><td style="background:#F00;">Dispon&iacute;vel no momento: </td><td style="width:45px; background:#FF0;"><select name="novoproduto!disponivel"><option value="1" selected> Sim </option><option value="0" > N&atilde;o </option></select></td><td style="background:#F00;">ASS: </td><td style="width:45px; background:#FF0;"><select name="novoproduto!aceita_segundo_sabor"><option value="1" > Sim </option><option value="0" selected> N&atilde;o </option></select></td><td style="background:#F00;">DEST: </td><td style="width:45px; background:#FF0;"><select name="novoproduto!destaque"><option value="1"> Sim </option><option value="0" selected> N&atilde;o </option></select></td></tr></table></td></tr>
       <tr><td><table><tr><td>C&oacute;digo: </td><td><input style="width:27px;" type="text" name="novoproduto!codigo" value=""></td><td>Nome: </td><td><input type="text" name="novoproduto!nome" value=""></td><td>Tamanho: </td><td><input type="text" style="width:80px;" name="novoproduto!tamanho" value=""></td></tr></table></td></tr>
       <tr><td><table><tr><td>Descri&ccedil;&atilde;o:</td><td><input style="width:300px;" type="text"  name="novoproduto!descricao" value=""></td></tr></table></td></tr>
       <tr><td><table><tr><td>Qtd Acompanhamentos:</td><td><input type="text" name="novoproduto!qtd_produto_adicional" style="width:20px;" value="0"></td><td><input type="button" onclick="show('div_adicionais')" value="Acompanhamentos e Por&ccedil;&otilde;es Extras">
          <div id="div_adicionais" style="background:#0A6; display: none;"><table><tr><td><?     
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
                        echo "<input type='checkbox' name='produto!adicional-".$ext->id."' value='1' >".$ext->nome."<br/>";
                    }
                }
                     ?> </td></tr></table></div></td></tr></table></td></tr>
       <tr><td><table><tr><td style="width:68px;">Est&aacute; em promo&ccedil;&atilde;o:</td><td style="width:45px; background:#AAA;"><select onchange="show('div_texto_promocional')" class="promocao" name="novoproduto!esta_em_promocao"><option value="1" > Sim </option><option value="0" selected> N&atilde;o </option></select></td><td style="background:#09f; width:130px;"><div id="div_label_preco" style="display:block; position:relative; float:right;">Pre&ccedil;o:</div><div id="div_label_preco_promocional" style="display:none; position:relative; float:right;">Pre&ccedil;o Promocional:</div></td><td style="width:10px; background: #006;">R$</td><td><div id="div_preco_promocional" style="display:none;"><input onkeyup="mask_moeda(this)"  class="preco" style="width:50px;" type="text" name="novoproduto!preco_promocional" value=""></div><div id="div_preco" style="display:block;"><input style="width:50px;" type="text" onkeyup="mask_moeda(this)" class="preco" name="produto!preco" value=""></td></tr></table></div></td></tr>
       <tr><td><div id="div_texto_promocional" style="display:none"><table><tr><td style="width:68px;">Texto da promo&ccedil;&atilde;o:</td><td><input type="text" style="width:300px;" name="novoproduto!texto_promocao" value=""></td></tr></table>
       <tr><td><input type="submit" value="Salvar"><input type="button" onclick="show('novo_item')" value="Cancelar"></td></tr>            
</table>
</form>   
</div>

<? include("include/footer.php"); ?>