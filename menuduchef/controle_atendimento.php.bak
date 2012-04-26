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
$funcionarios = UsuarioRestaurante::all(array("conditions"=>array("restaurante_id = ?",$_SESSION['restaurante_id'])));
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
            <div id="categoria_rest"><?= $rest->getNomeCategoria() ?> </div>
            <div id="nome_rest"><?= $rest->nome ?> </div>
            <div id="avatar_rest"> <img src="images/restaurante/<?= $rest->imagem ?>" border="0"> </div>
            <div id="formas_pagamento">Formas de pagamento </div>
            <div id="tempo_entrega"><span style="color:#E51B21;">EndereÃ§o:</span> <?= $rest->endereco ?> </div>
            <img style="margin-top:12px;" width="110" height="30" src="background/cancel.png" style="cursor:pointer;" onclick="location.href=('gerente_principal');"> <img width="110" height="30" id="salvar" style="cursor:pointer" src="background/salvar.png" > </div>
        </div>
      </div>
      <div class="span-18 last">
        <div id="titulo_box_destaque"> Controle GerÃªncia </div>
        <div class="titulo_box_concluir" style="margin-top:4px;">Relação de funcionários de
          <?= $rest->nome ?>, modificado por
          <div style="display:inline; font:Arial; color:#E51B21; font-size:13px;"><?= $usuario->nome ?>.</div>
        </div>
        <div id="box_concluir">
          <div style="margin-top:16px;">
            <form id="form_gerente" action="php/controller/restaurante_cadastro_funcionarios" method="post">
            <input type="hidden" name="id" value="<?= $rest->id ?>">
             
            <table style="width:674px; border:1px solid #bcbec0; font-family:Arial;">
              <tr>
                
                <th style="padding-left:4px;">Funcionario</th>
                <th>E-mail</th>
                <th>Tipo</th>
                <th >Excluir</th>
              </tr>
              <? if($funcionarios){
                    foreach($funcionarios as $fun){
                       
                        ?>
              <tr>
              	
                <td style="padding-left:4px; margin-left:12px;">
                  <?= $fun->nome ?>
                </td>
                <td>
                  <?= $fun->email ?>
                </td>
                <td>
                  <?
                    if($fun->tipo==2){
                        echo "Gerente";
                    }else if($fun->tipo==3){
                        echo "Atendente";
                    }
                  ?>
                <td >
                <div class="botoes_cat desativar" qual="<?= $fun->id ?>"> Ð¥ </div>    
                </td>
              </tr>
              <? }
                } ?>

            </table>
            </form>    
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<? include("include/footer.php"); ?>