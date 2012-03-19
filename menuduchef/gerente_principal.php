<?
session_start();

include("include/header4.php");


if($_SESSION['restaurante_id']){
    $restaurante = $_SESSION['restaurante_id'];
    $cidade = $_SESSION['cidade_id'];
    $rest = Restaurante::find($restaurante);
}

$usuario = unserialize($_SESSION['usuario']);
$usuobj = unserialize($_SESSION['usuario_obj']);
$obj = Restaurante::find($usuobj->restaurante_id);
$tipos = TipoRestaurante::all();
$tipos_produto = TipoProduto::all();
$bairros = Bairro::all(array("conditions"=>array("cidade_id = ?",$cidade)));
?>
<script type="text/javascript" src="js/jquery-1.3.2.min.js"></script>
<script type="text/javascript" src="js/mask.js"></script>
<script>

$(document).ready(function() {
    
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
            <div id="categoria_rest">Pizzaria </div>
            <div id="nome_rest">Reis Magos </div>
            <div id="avatar_rest"> <img src="background/img_avt.jpg" border="0"> </div>
            <div id="formas_pagamento">Formas de pagamento </div>
            <div id="tempo_entrega"><span style="color:#E51B21;">Endereço:</span> Rua Des. Sinval Moreira Dias, Lorem Ipsum si dollor </div>
            <img style="margin-top:12px;" width="110" height="30" src="background/cancel.png" onclick="location.href=('area_adm_restaurante');"> <img width="110" height="30" src="background/salvar.png" > </div>
        </div>
      </div>
      <div class="span-18 last">
        <div id="titulo_box_destaque"> Controle Gerência </div>
        <div class="titulo_box_concluir" style="margin-top:4px;">Controle de bairros atendidos por
          <?= $rest->nome ?>
          , modificado por
          <div style="display:inline; font:Arial; color:#E51B21; font-size:13px;"><?= $usuario->nome ?>.</div>
        </div>
        <div id="box_concluir">
          <div style="margin-top:16px;">
            <table style="width:674px; border:1px solid #bcbec0; font-family:Arial;">
              <tr>
                <th style="padding-left:4px;">Incluir</th>
                <th>Bairro</th>
                <th>Taxa de Entrega</th>
                <th>Tempo de Entrega</th>
              </tr>
              <? if($bairros){
                    foreach($bairros as $bairro){
                        $atende = "";
                        $atendes=RestauranteAtendeBairro::all(array("conditions"=>array("restaurante_id = ? AND bairro_id = ?",$obj->id,$bairro->id)));
                        foreach($atendes as $atende){
                        }
                        ?>
              <tr>
              	<td style="padding-left:4px; margin-left:12px;">
                <input class="adjacent" type="checkbox" name="bairros[]" value="<?= $bairro->id ?>" id="bairro_id_<?= $bairro->id ?>" <? if($obj->atendeBairro($bairro->id)) { ?>checked="checked"<? } ?> /></td>
                <td>
                <label class="adjacent" for="bairro_id_<?= $bairro->id ?>">
                  <?= $bairro->nome ?>
                </label></td>
                <td>
                <input type="text" value="<? if($atende){ echo $atende->preco_entrega; } ?>" ></td>
                <td>
                <input type="text" value="<? if($atende){ echo $atende->tempo_entrega; } ?>" ></td>
              </tr>
              <? }
                } ?>
              <tr>
                <td style="padding-left:4px;">662657</td>
                <td>CHINA IN BOX</td>
                <td>28/10/11 as 17:53h</td>
                <td>28/10/11 às 17:55h</td>
              </tr>
              <tr>
                <td style="padding-left:4px;">662657</td>
                <td>CHINA IN BOX</td>
                <td>28/10/11 as 17:53h</td>
                <td>28/10/11 às 17:55h</td>
              </tr>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<? include("include/footer.php"); ?>
