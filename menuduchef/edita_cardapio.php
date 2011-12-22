<?
session_start();

include("include/header2.php");

$_SESSION['restaurante_editado_id'] = 1;

if($_SESSION['restaurante_editado_id']){
    $restaurante = $_SESSION['restaurante_editado_id'];
    $categorias = RestauranteTemTipoProduto::all(array("conditions" => array("restaurante_id = ?",$restaurante)));
}
?>

<script type="text/javascript" src="js/jquery-1.6.4.min.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.8.16.custom.min.js"></script>
<script type="text/javascript" src="js/jquery.cookie.js"></script>
<script type="text/javascript" src="js/mask.js"></script>

<style type="text/css">
        input {font-size: 11px;}
        td {font-size: 11px;}
        
        body{font:12px "Helvetica", sans-serif;}
        body div#content{width:980px;margin:0 auto;}
        div.recebeDrag{}
        div.itemDrag{border:1px solid #f2f2f2;margin:4px!important;}
        ul{list-style:none;}
        ul li{border-bottom:1px dotted silver;padding:4px; text-align: left;}
        h1{text-align:center;}
        h2{cursor:move!important;background-color:#F30;color:#fff;padding:3px;}
        h5{cursor:move!important;background-color:#F00;color:#fff;padding:3px;}
        h2 span{float:right;font-size:12px;font-weight:normal;padding:1px;}
        h2 span a{color:#fff;text-decoration:none;}
        div#drop{width:490px;float:left;min-width:490px;min-height:30px;}
        .dragHelper{border:4px dashed #A0A7F9;min-height:200px;margin:4px;}
        .dragHelper2{border:4px dashed #A0A7F9;min-height:200px;margin:4px;}
        .itemDrag p small{display:block;margin-top:6px;}
        .itemDrag p a{font-weight:900;text-decoration:none;border-bottom:1px dotted blue;}
        div#voltar{text-align:center;border: 1px dotted silver;width:960px;margin:0 auto;padding:4px;} 
        
</style>

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
    
    $('.recebeDrag').sortable({connectWith: ['.recebeDrag']});

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

});

function show(x){
    oque = document.getElementById(x);
    if(oque.style.display == "block"){
        oque.style.display = "none";
    }else{
        oque.style.display = "block";
    }
}
</script>
<div>
    <div style="float:left; position: relative; padding-left: 20px; padding-right: 50px;">
        <table class="list">
            <tr><td><input type="button" value="Salvar Altera&ccedil;&otilde;es"></td></tr>
            <tr><td><input type="button" onclick="location.href=('edita_cardapio');" value="Cancelar"></td></tr> 
            <tr><td><input type="button" onclick="location.href=('area_adm_restaurante');" value="Voltar"></td></tr>
        </table>
    </div>
     
    <div id="drop" class="recebeDrag" style="float:left; position: relative;">
        
            <? if($categorias){
                    foreach($categorias as $categoria){ ?>
                        <div class="itemDrag categoria" id="categoria_<?= $categoria->tipoproduto_id ?>" ><h2><span><a href="#" class="lnk-adicionar">[ + ]</a></span><?= $categoria->tipo_produto->nome ?></h2>
                            <div style="height:30px;"></div>
                        <ul>
                         <div class="recebe_<?= $categoria->tipoproduto_id ?>">       
                    <? 
                        $itens = Produto::find_by_sql("SELECT P.* FROM produto P INNER JOIN produto_tem_tipo PTT ON P.id = PTT.produto_id INNER JOIN restaurante_tem_tipo_produto RTTP ON PTT.tipoproduto_id = RTTP.tipoproduto_id WHERE RTTP.restaurante_id = ".$restaurante." AND PTT.tipoproduto_id = ".$categoria->tipoproduto_id." AND P.restaurante_id = ".$restaurante." ORDER BY P.nome asc");
                        if($itens){
                            foreach($itens as $item){ ?>
                                <li>
                                        <div style="background:#DDDDFF; font-size: 11px;" id="produto_<?= $item->nome ?>" class="produto_de_categoria_<?= $categoria->tipo_produto->nome ?> produto">
                                           <h5><span><a href="#" class="lnk-adicionar">[ + ]</a></span></h5>
                                           <input type="hidden" name="produto_categoria_<?= $item->id ?>" value="<?= $categoria->tipoproduto_id ?>" >
                                           <table border="0" cellspacing="0" style="width:350px; padding: 0px;">
                                               <tr><td><table><tr><td style="background:#F00;">Dispon&iacute;vel no momento: </td><td style="width:45px; background:#FF0;"><select name="produto_disponivel_<?= $item->id ?>"><option value="1" <? if($item->disponivel){ echo "selected"; } ?>> Sim </option><option value="0" <? if(!$item->disponivel){ echo "selected"; } ?>> N&atilde;o </option></select></td><td style="background:#A57;"><input name="produto_foto_<?= $item->id ?>" type="button" value="Foto" onclick="show('div_produto_imagem_<?= $item->id ?>')" ><div id="div_produto_imagem_<?= $item->id ?>" style="position:absolute; background-color: #519; margin-top: 25px; display:none;"><?= $item->imagem ? "<img src='".$item->imagem."'> Mudar imagem:" : "Adicionar imagem:" ?><input type="file" name="produto_imagem_<?= $item->id ?>"></div></td><td><input type="button" value="X"></td></tr></table></td></tr>
                                               <tr><td><table><tr><td>C&oacute;digo: </td><td><input style="width:27px;" type="text" name="produto_nome_<?= $item->id ?>" value="<?= $item->codigo ?>"></td><td>Nome: </td><td><input type="text" name="produto_nome_<?= $item->id ?>" value="<?= $item->nome ?>"></td><td>Tamanho: </td><td><input type="text" style="width:80px;" name="produto_tamanho_<?= $item->id ?>" value="<?= $item->tamanho ?>"></td></tr></table></td></tr>
                                               <tr><td><table><tr><td>Descri&ccedil;&atilde;o:</td><td><input style="width:300px;" type="text"  name="produto_descricao_<?= $item->id ?>" value="<?= $item->descricao ?>"></td></tr></table></td></tr>
                                               <tr><td><table><tr><td>Qtd Acompanhamentos:</td><td><input type="text" name="produto_qtd_produto_adicional_<?= $item->id ?>" style="width:20px;" value="<?= $item->qtd_produto_adicional ?>"></td><td><input type="button" value="Acompanhamentos e Por&ccedil;&otilde;es Extras"></td></tr></table></td></tr>
                                               <tr><td><table><tr><td style="width:68px;">Est&aacute; em promo&ccedil;&atilde;o:</td><td style="width:45px; background:#AAA;"><select class="promocao" name="produto_esta_em_promocao_<?= $item->id ?>"><option value="1" <? if($item->esta_em_promocao){ echo "selected"; } ?>> Sim </option><option value="0" <? if(!$item->esta_em_promocao){ echo "selected"; } ?>> N&atilde;o </option></select></td><td style="background:#09f; width:130px;"><div id="div_label_preco_<?= $item->id ?>" style="display:<?= $item->esta_em_promocao ? "none" : "block" ?>; position:relative; float:right;">Pre&ccedil;o:</div><div id="div_label_preco_promocional_<?= $item->id ?>" style="display:<?= $item->esta_em_promocao ? "block" : "none" ?>; position:relative; float:right;">Pre&ccedil;o Promocional:</div></td><td style="width:10px; background: #006;">R$</td><td><div id="div_preco_promocional_<?= $item->id ?>" style="display:<?= $item->esta_em_promocao ? "block" : "none" ?>;"><input onkeyup="mask_moeda(this)"  class="preco" style="width:50px;" type="text" name="produto_preco_promocional_<?= $item->id ?>" value="<?= $item->preco_promocional ?>"></div><div id="div_preco_<?= $item->id ?>" style="display:<?= $item->esta_em_promocao ? "none" : "block" ?>;"><input style="width:50px;" type="text" onkeyup="mask_moeda(this)" class="preco" name="produto_preco_<?= $item->id ?>" value="<?= $item->preco ?>"></td></tr></table></div></td></tr>
                                               <tr><td><div id="div_texto_promocional_<?= $item->id ?>" style="display:<?= $item->esta_em_promocao ? "block" : "none" ?>;"><table><tr><td style="width:68px;">Texto da promo&ccedil;&atilde;o:</td><td><input type="text" style="width:300px;" name="produto_texto_promocao_<?= $item->id ?>" value="<?= $item->texto_promocao ?>"></td></tr></table></table></td></tr>
                                               <tr></tr>
                                               
                                           </table>
                                        </div>
                                </li>
                           <? }
                        }?>
                        </div>        
                       </ul>
                         </div>
                    <?}
             } ?>
    </div>
    <script type="text/javascript">
    $(function(){
            // configura drag and drop
            <? if($categorias){
                    foreach($categorias as $categoria){ ?>
                        $(".recebe_<?= $categoria->tipoproduto_id ?>").sortable({
                                connectWith: ['.recebeDrag2'],
                                placeholder: 'dragHelper2',
                                scroll: true,
                                revert: true,
                                stop: function( e, ui ) {
                                        salvaCookie();
                                }
                        });
            <?      }
            }   ?>            
            $(".recebeDrag").sortable({
                    connectWith: ['.recebeDrag'],
                    placeholder: 'dragHelper',
                    scroll: true,
                    revert: true,
                    stop: function( e, ui ) {
                            salvaCookie();
                    }
            });
            // minimizar boxes
            $('.lnk-minimizar').click(function(){
                    var ul = $(this).parent().parent().parent().find('ul');
                    if( $(ul).is(':visible') ) {
                            $(ul).slideUp();
                            $(this).html('[ + ]');
                    } else {
                            $(ul).slideDown();
                            $(this).html('[ - ]');
                    }
                    return false;
            });
            // remover box
            $('.lnk-remover').click(function(){
                    $(this).parent().parent().parent().fadeOut();
                    return false;
            });
            // configuração inicial do cookie
            if( $.cookie('df_draganddrop') ) {
                    var ordem = $.cookie('df_draganddrop').split('|');
                    // posiciona boxes nos containers certos
                    $('#drop div.itemDrag').each(function(){
                            if( ordem[0].search( $(this).attr('id') ) == -1 ) $('#drop-direita').append($(this));
                    });
                    // ordena containers
                    var esquerda = ordem[0].split(',');
                    for( i = 0; i<= esquerda.length; i++ ) $('#drop').append($('#'+esquerda[i]));
                    
            } else {
                    $.cookie('df_draganddrop', '', { expires: 7, path: '/' });
            }
    });	
    // salva cookie
    var salvaCookie = function() {
            var ordem = $('#drop').sortable('toArray');
            $.cookie('df_draganddrop', ordem);
    };
    </script>
</div>
<? include("include/footer.php"); ?>