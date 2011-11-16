<?
include("include/header.php");

//$itens = Produto::all(array("order" => "nome asc", "conditions" => array("restaurante_id = ?",$_GET['res'])));
$categorias = RestauranteTemTipoProduto::all(array("conditions" => array("restaurante_id = ?",$_GET['res'])));
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
<div>
    <div style="float:left; position: relative; padding-left: 20px; padding-right: 50px;">
        <table class="list">
            <tr><td>Menu <input type="button" id="ver_completo" value="Ver Completo"></td></tr>
            <tr><td>Filtro<br/><input id="caixa_filtro" type="text"> <input id="filtrar" type="button" value="OK"></td></tr>
            <tr><td>Card&aacute;pio</td></tr>
            <? if($categorias){
                    foreach($categorias as $categoria){ 
                        $itens = Produto::find_by_sql("SELECT P.* FROM produto P INNER JOIN produto_tem_tipo PTT ON P.id = PTT.produto_id INNER JOIN restaurante_tem_tipo_produto RTTP ON PTT.tipoproduto_id = RTTP.tipoproduto_id WHERE RTTP.restaurante_id = ".$_GET['res']." AND PTT.tipoproduto_id = ".$categoria->tipoproduto_id." AND P.restaurante_id = ".$_GET['res']." ORDER BY P.nome asc");
                        $num = sizeof($itens);
                        ?>
                        <tr><td style="color:#CC0000;"><input type="checkbox" class="filtro_categoria" id="checkprod_<?= $categoria->tipoproduto_id ?>" onclick="check_show('categoria_<?= $categoria->tipoproduto_id ?>','checkprod_<?= $categoria->tipoproduto_id ?>')" checked> <?= $categoria->tipo_produto->nome ?> (<?= $num ?>)</td></tr>
                    <? 
                    }
             } ?>
        </table>
    </div>
    <div style="float:left; position: relative;">
        <table class="list">
            <? if($categorias){
                    foreach($categorias as $categoria){ ?>
                        <tr><td><div class="categoria" id="categoria_<?= $categoria->tipoproduto_id ?>" ><table>
                        <tr><th colspan="3" style="color:#CC0000;"><?= $categoria->tipo_produto->nome ?></th></tr>
                        <tr><td colspan="3">
                                <table style="width:550px;">
                    <? 
                        $itens = Produto::find_by_sql("SELECT P.* FROM produto P INNER JOIN produto_tem_tipo PTT ON P.id = PTT.produto_id INNER JOIN restaurante_tem_tipo_produto RTTP ON PTT.tipoproduto_id = RTTP.tipoproduto_id WHERE RTTP.restaurante_id = ".$_GET['res']." AND PTT.tipoproduto_id = ".$categoria->tipoproduto_id." AND P.restaurante_id = ".$_GET['res']." ORDER BY P.nome asc");
                        if($itens){
                            foreach($itens as $item){ ?>
                                <tr><td>
                                        <div id="produto_<?= $item->nome ?>" class="produto_de_categoria_<?= $categoria->tipo_produto->nome ?>" class="produto">     
                                           <table>     
                                               <tr>
                                                   <td><input type="hidden" id="idprod_<?= $item->id ?>" value="<?= $item->id ?>"><input type="hidden" id="nome_<?= $item->id ?>" value="<?= $item->nome ?>"><b><?= $item->nome ?></b><br/><?= $item->descricao ?></td>
                                                   <td><? if($item->esta_em_promocao){ ?><div style="text-decoration:line-through; font-size:10px;"><?= StringUtil::doubleToCurrency($item->preco) ?></div><div style="color:#CC0000;"><?= StringUtil::doubleToCurrency($item->preco_promocional) ?></div><? }else{ ?><div style="color:#CC0000;"><?= StringUtil::doubleToCurrency($item->preco) ?></div><? } ?></td>
                                                   <td><input type="button" value="Foto"><input onclick="show('obsprod_<?= $item->id ?>'); erase('obsbox_<?= $item->id ?>')" type="button" value="OBS"><input id="inclui_<?= $item->id ?>" onclick="poe_no_carrinho(<?= $item->id ?>)" type="button" value=" + "><br/>Qtd: <input type="button" onclick="mais('qtdprod_<?= $item->id ?>')" value=" + "><input id="qtdprod_<?= $item->id ?>" type="text" style="width:30px" readonly="true" value="1"><input onclick="menos('qtdprod_<?= $item->id ?>')" type="button" value=" - "></td>
                                               </tr>
                                               <tr><td colspan='3'><div id="obsprod_<?= $item->id ?>" style="display:none;"><textarea id="obsbox_<?= $item->id ?>" style="width:100%; height: 45px;"></textarea></div></td></tr>
                                           </table>
                                        </div>
                                </td></tr>
                           <? }
                        }?>
                                </table>
                       </td></tr>
                                </table></div></td></tr>
                    <?}
             } ?>
        
        </table>
    </div>

    <div style="float:right; position: static;">
        <table class="list">
            <tr><td>Seu Pedido</td></tr>
            <tr><td><div id="carrinho"></div></td></tr>
            <tr><td>Taxa Entrega:<br/>Desconto:<br/>Subtotal:<br/></td></tr>
            <tr><td>Promo&ccedil;&atilde;o<br/><input type="text" ><input type="button" value="OK"></td></tr>
            <tr><td><input type="button" value="FINALIZAR"></td></tr>
        </table>
    </div>
</div>
<? include("include/footer.php"); ?>