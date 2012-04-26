<?
session_start();

include("include/header4.php");


if($_SESSION['restaurante_id']){
    $restaurante = $_SESSION['restaurante_id'];
    $rest = Restaurante::find($restaurante);
}

$usuario = unserialize($_SESSION['usuario']);
$usuobj = unserialize($_SESSION['usuario_obj']);
$obj = Restaurante::find($usuobj->restaurante_id);
$tipos = TipoRestaurante::all();
$tipos_produto = TipoProduto::all();

?>
<script type="text/javascript" src="js/jquery-1.6.4.min.js"></script>
<script type="text/javascript" src="js/mask.js"></script>
<script>

$(document).ready(function() {
    $("#salvar").click(function(){
        $("#form_gerente").submit();
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
    <?php include "menu_gerente.php" ?>
    <div id="central" class="span-24">
      <div class="span-6">
        <div id="barra_esquerda">
          <div id="info_restaurante">
            
            <img style="margin-top:12px;cursor:pointer;" width="110" height="30" src="background/cancel.png" onclick="location.href=('gerente_principal');"> <img width="110" height="30" id="salvar" style="cursor:pointer" src="background/salvar.png" > </div>
        </div>
      </div>
      <div class="span-18 last">
        <div id="titulo_box_destaque"> Controle Gerência </div>
        <div class="titulo_box_concluir" style="margin-top:4px;">Relat&oacute;rio de pedidos
          <?= $rest->nome ?>, modificado por
          <div style="display:inline; font:Arial; color:#E51B21; font-size:13px;"><?= $usuario->nome ?>.</div>
        </div>
        <div id="box_concluir">
          <div style="margin-top:16px;">
            
              <?
                      $mes = date("m");
                      $mes += 0;
                      $mespas = $mes - 1;
                      if($mespas==0){
                          $mespas=12;
                      }
                      $mesret = $mes - 2;
                      if($mesret<1){
                          $mesret+=12;
                      }
                      
                      $qtd = 0;
                      $qtd_mes = 0;
                      $qtd_mespas = 0;
                      $qtd_mesret = 0;
                      
                      $can = 0;
                      $can_mes = 0;
                      $can_mespas = 0;
                      $can_mesret = 0;
                      
                      $val = 0;
                      $val_mes = 0;
                      $val_mespas = 0;
                      $val_mesret = 0;
                      
                      if($rest->pedidos){
                          foreach($rest->pedidos as $ped){
                              if($ped->situacao=="pedido_concluido"){
                                  $qtd++;
                                  $pedval = $ped->getTotal();
                                  $val += $pedval;
                                  $mesp = $ped->quando->format('m');
                                  if($mesp==$mes){
                                      $qtd_mes++;
                                      $val_mes += $pedval;
                                  }else if($mesp==$mespas){
                                      $qtd_mespas++;
                                      $val_mespas += $pedval;
                                  }else if($mesp==$mesret){
                                      $qtd_mesret++;
                                      $val_mesret += $pedval;
                                  }
                              }else if($ped->situacao=="cancelado"){
                                  $can++;
                                  $mesp = $ped->quando->format('m');
                                  if($mesp==$mes){
                                      $can_mes++;
                                  }else if($mesp==$mespas){
                                      $can_mespas++;
                                  }else if($mesp==$mesret){
                                      $can_mesret++;
                                  }
                              }
                          }
                      }
              ?>
              Qtd total de pedidos: <?= $qtd ?><br/>
              Qtd total de pedidos neste m&ecirc;s (<?= $mes ?>): <?= $qtd_mes ?><br/>
              Qtd total de pedidos no m&ecirc;s passado (<?= $mespas ?>): <?= $qtd_mespas ?><br/>
              Qtd total de pedidos no m&ecirc;s retrasado (<?= $mesret ?>): <?= $qtd_mesret ?><br/><br/>
              
              Qtd total de pedidos cancelados: <?= $can ?><br/>
              Qtd total de pedidos cancelados neste m&ecirc;s (<?= $mes ?>): <?= $can_mes ?><br/>
              Qtd total de pedidos cancelados no m&ecirc;s passado (<?= $mespas ?>): <?= $can_mespas ?><br/>
              Qtd total de pedidos cancelados no m&ecirc;s retrasado (<?= $mesret ?>): <?= $can_mesret ?><br/><br/>
              
              Valor bruto dos pedidos: <?= StringUtil::doubleToCurrency($val) ?><br/>
              Valor bruto dos pedidos neste m&ecirc;s (<?= $mes ?>): <?= StringUtil::doubleToCurrency($val_mes) ?><br/>
              Valor bruto dos pedidos no m&ecirc;s passado (<?= $mespas ?>): <?= StringUtil::doubleToCurrency($val_mespas) ?><br/>
              Valor bruto dos pedidos no m&ecirc;s retrasado (<?= $mesret ?>): <?= StringUtil::doubleToCurrency($val_mesret) ?><br/><br/>
              
              
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<? include("include/footer.php"); ?>