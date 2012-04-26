<?

include("include/header2.php");

$page = $_GET['page'] ? $_GET['page'] : 1;
//$itens = Produto::find_all_by_restaurante_id($_GET['id'], array("order" => "nome asc"));
$usuario_obj = unserialize($_SESSION['usuario_obj']);
$paginacao = new Paginacao('Pedido', array(
	    //'joins' => 'inner join restaurante r on pedido.restaurante_id = r.id',
	    'conditions' => 'consumidor_id = "'.$usuario_obj->id.'" AND situacao <> "" ',
	    'order' => 'quando desc'
	    ), 'usuario_pedidos', $page, 6, 5, '?page=');

$pedidos = $paginacao->list;



//$pedidos = Pedido::all(array("order"=>"quando desc","conditions"=>array("consumidor_id = ?",$usuario_obj->id)));

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
"http://www.w3.org/TR/html4/strict.dtd"
>

<meta http-equiv="content-type" content="text/html" charset="UTF-8" />

<link rel="stylesheet" href="css_/blueprint/screen.css" type="text/css" media="screen, projection">
<link rel="stylesheet" href="css_/blueprint/print.css" type="text/css" media="print">
<link rel="stylesheet" href="css_/estilo.css" type="text/css" media="screen">
<!--[if lt IE 8]><link rel="stylesheet" href="css_/blueprint/ie.css" type="text/css" media="screen, projection"><![endif]-->
<style type="text/css">
	    /* TODO ver se adiciona essas regras em algum arquivo css depois; n�o adicionei agora para evitar conflitos */
	    #contagem_pag a { color: #E51B21; font-weight: bold; padding: 5px; }
	    #contagem_pag a:hover, #contagem_pag a.marked { background-color: #E51B21; color: #fff; }
	    .abre_box { cursor: pointer; text-decoration: underline; }
	    #painel {}
	</style>
<script src="js/jquery-1.6.4.min.js"></script>
<script>
$(document).ready( function (){
	$('.desloca').mouseover(function(){
		$(this).css('margin-left',10);
	});
	$('.desloca').mouseout(function(){
		$(this).css('margin-left',0);
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

<div class="container">
  <div id="background_container">
    <?php include "menu_voltar.php" ?>
    <div id="central" class="span-24">
      <div class="span-6">
        <div id="barra_esquerda">
          <div id="info_restaurante">
            <div id="dados_cliente" style="padding-top:62px;"> <a href="usuario"> <img class="desloca" src="background/meus_dados.png" /> </a> </div>
            <div id="dados_cliente"> <a href="usuario_pedidos"> <img class="desloca" src="background/meus_pedidos.png" /> </a> </div>
          </div>
        </div>
      </div>
      <div class="span-18 last">

        <div id="titulo_box_destaque"> Meus Pedidos </div>
        <div class="titulo_box_concluir" style="margin-top:4px;">Acompanhe abaixo o histórico de seus pedidos
          <div style="display:inline; font:Arial; color:#E51B21; font-size:13px;"><?= $usuario_obj->nome ?></div>
        </div>
        <div class="titulo_box_pedido">Hist&oacute;rico de Pedidos </div>
        <div id="box_pedido" style="height:100%;">
          <table style="width:674px; border-top:1px solid #bcbec0; ">
            <tr style="background:#F7F7F7">
              <th style="padding-left:4px;">Pedido</th>
              <th>Restaurante</th>
              <th>Data do Pedido</th>
              <th>Data de Confirmação</th>
              <th>Status</th>
              <td></td>
            </tr>
            <?
                if($pedidos){
                    foreach($pedidos as $pedido){
            ?>
                        <tr>
                          <td style="padding-left:4px;"><?= $pedido->id ?></td>
                          <td><?= $pedido->restaurante->nome ?></td>
                          <td><?= $pedido->quando->format("d/m/Y - h:i:s") ?></td>
                          <td><?= $pedido->quando_confirmado ? $pedido->quando_confirmado->format("d/m/Y - h:i:s") : "Em aguardo..." ?></td>
                          <td style="color:#E51B21"><?
                                switch($pedido->situacao){
                                    case Pedido::$NOVO: echo "Aguardando restaurante"; break;
                                    case Pedido::$PREPARACAO: echo "Pedido em peparo"; break;
                                    case Pedido::$CONCLUIDO: echo "Conclu&iacute;do"; break;   
                                    case Pedido::$CANCELADO: echo "Cancelado"; break;    
                                }
                          ?></td>
                          <td><input onclick="show('pedido_<?= $pedido->id ?>')" type="button" value="Detalhar"/></td>
                        </tr>
                        <tr>
                            <td colspan="6">
                                <div id="pedido_<?= $pedido->id ?>" style="display:none">
                                <table>
                                    <tr>
                                      <td>
                                      <table style="  width:130px; ">
                                        <tr>
                                          <td style="width:130px; height:98px; background:#FF9 "></td>
                                        </tr>
                                        <tr>
                                          <td style="color:#f90;">Forma de pagamento:</td>
                                        </tr>
                                      </table>
                                      </td>
                                      <td>
                                      <table style="width:520px;   border:1px solid #bcbec0;   ">
                                        <tr style="font-size:12px; background:#F7F7F7;">
                                          <th style="padding-left:10px;" >Item</th>
                                          <th>Valor</th>
                                          <th>Quantidade</th>
                                          <th>Valor Total</th>
                                        </tr>
                                        <? if($pedido->pedido_tem_produtos){ 
                                            foreach($pedido->pedido_tem_produtos as $prod){
                                            ?>
                                        <tr>
                                          <td style="padding-left:10px;"><?= $prod->produto->tamanho ? $prod->produto->nome." ".$prod->produto->tamanho : $prod->produto->nome ?></td>
                                          <td><?= StringUtil::doubleToCurrency($prod->preco_unitario) ?></td>
                                          <td><?= $prod->qtd ?>x</td>
                                          <td><?= StringUtil::doubleToCurrency($prod->preco_unitario * $prod->qtd) ?></td>
                                        </tr>
                                        <? }
                                        }?>
                                        
                                        <tr>
                                          <td></td>
                                        </tr>
                                        <tr>
                                          <th colspan="3" style="text-align:right; color:#E51B21;">Desc. promocional</th>
                                          <th>-<?= StringUtil::doubleToCurrency($pedido->cupom->valor) ?></th>
                                        </tr>
                                        <tr>
                                          <th colspan="3" style="text-align:right; color:#E51B21;">Taxa de entrega:</th>
                                          <th><?= StringUtil::doubleToCurrency($pedido->preco_entrega) ?></th>
                                        </tr>
                                        <tr>
                                          <th colspan="3" style="text-align:right; color:#E51B21;">Total:</th>
                                          <th><? 
                                                    $valor = $pedido->getTotal();
                                                    $valor -= $pedido->cupom->valor;
                                                    if($valor<0){
                                                        $valor = 0;
                                                    }
                                                    $valor += $pedido->preco_entrega;
                                                    echo StringUtil::doubleToCurrency($valor);
                                            ?></th>
                                        </tr>
                                      </table>
                                      </td>
                                      </tr>
                                </table>
                                </div>  
                            </td>    
                        </tr>    
            <?
                    }
                }
            ?>

          </table>
        </div>
        <div id="caixa_sup">

		<? if ($paginacao && $paginacao->getHtml()) { ?>
		<div id="contagem_pag">
			<?= $paginacao->getHtml() ?>
		</div>
		<? } ?>
	    </div>
      </div>
    </div>
  </div>
</div>
            
<? include("include/footer.php"); ?>