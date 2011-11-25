<?
session_start();

include("include/header.php");

$_SESSION['restaurante_editado_id'] = 1;

if($_SESSION['restaurante_editado_id']){
    $restaurante = $_SESSION['restaurante_editado_id'];
    $categorias = RestauranteTemTipoProduto::all(array("conditions" => array("restaurante_id = ?",$restaurante)));
}
?>

<script type="text/javascript" src="js/jquery-1.3.2.min.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.7.2.custom.min.js"></script>
<script type="text/javascript" src="js/jquery.cookie.js"></script>

<style type="text/css">
        
        body{font:12px "Helvetica", sans-serif;}
        body div#content{width:980px;margin:0 auto;}
        div.recebeDrag{}
        div.itemDrag{border:1px solid #f2f2f2;margin:4px!important;}
        ul{list-style:none;}
        ul li{border-bottom:1px dotted silver;padding:4px; text-align: left;}
        h1{text-align:center;}
        h2{cursor:move!important;background-color:#F30;color:#fff;padding:3px;}
        h2 span{float:right;font-size:12px;font-weight:normal;padding:1px;}
        h2 span a{color:#fff;text-decoration:none;}
        div#drop{width:490px;float:left;min-width:490px;min-height:30px;}
        .dragHelper{border:4px dashed #F0F7F9;min-height:200px;margin:4px;}
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


});

</script>
<div>
    <div style="float:left; position: relative; padding-left: 20px; padding-right: 50px;">
        <table class="list">
            
            <tr><td><input type="button" value="Salvar Altera&ccedil;&otilde;es"></td></tr>
            <tr><td><input type="button" onclick="location.href=('edita_cardapio.php');" value="Cancelar"></td></tr>
            <tr><td><input type="button" value="Voltar"></td></tr>
        </table>
    </div>
     
    <div id="drop" class="recebeDrag" style="float:left; position: relative;">
        
            <? if($categorias){
                    foreach($categorias as $categoria){ ?>
                        <div class="itemDrag categoria" id="categoria_<?= $categoria->tipoproduto_id ?>" ><h2><span><a href="#" class="lnk-minimizar">[ - ]</a> <a href="#" class="lnk-remover">[ x ]</a></span><?= $categoria->tipo_produto->nome ?></h2>
                            <div style="height:30px;"></div>
                        <ul>
                         <div class="recebe_<?= $categoria->tipoproduto_id ?>">       
                    <? 
                        $itens = Produto::find_by_sql("SELECT P.* FROM produto P INNER JOIN produto_tem_tipo PTT ON P.id = PTT.produto_id INNER JOIN restaurante_tem_tipo_produto RTTP ON PTT.tipoproduto_id = RTTP.tipoproduto_id WHERE RTTP.restaurante_id = ".$restaurante." AND PTT.tipoproduto_id = ".$categoria->tipoproduto_id." AND P.restaurante_id = ".$restaurante." ORDER BY P.nome asc");
                        if($itens){
                            foreach($itens as $item){ ?>
                                <li>
                                        <div style="background:#DDDDFF" id="produto_<?= $item->nome ?>" class="produto_de_categoria_<?= $categoria->tipo_produto->nome ?> produto">     
                                           <table>     
                                               <tr><td>Nome:</td><td colspan="2"><input type="text" name="produto_nome_<?= $item->id ?>" value="<?= $item->nome ?>"></td><td><input type="button" value="Foto"></td></tr>
                                               <tr><td>Descri&ccedil;&atilde;o:</td><td colspan="3"><input style="width:400px;" type="text"  name="produto_descricao_<?= $item->id ?>" value="<?= $item->descricao ?>"></td></tr>
                                               <tr><td>Est&aacute; em promo&ccedil;&atilde;o:</td><td><input type="radio"  name="produto_esta_em_promocao_<?= $item->id ?>" value="1" <? if($item->esta_em_promocao){ echo "checked"; } ?>> Sim <br/><input type="radio"  name="produto_esta_em_promocao_<?= $item->id ?>" value="0" <? if(!$item->esta_em_promocao){ echo "checked"; } ?>> N&atilde;o </td><td>Pre&ccedil;o:</td><td><? if($item->esta_em_promocao){ ?><div style="text-decoration:line-through; font-size:10px;"><?= StringUtil::doubleToCurrency($item->preco) ?></div><div style="color:#CC0000;"><?= StringUtil::doubleToCurrency($item->preco_promocional) ?></div><? }else{ ?><div style="color:#CC0000;">R$<input type="text" name="produto_nome_<?= $item->id ?>" value="<?= $item->preco ?>"></div><? } ?></td></tr>
                                               
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