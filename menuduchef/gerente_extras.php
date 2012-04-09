<?
session_start();

include("include/header4.php");

if($_SESSION['restaurante_id']){
    $restaurante = $_SESSION['restaurante_id'];
    $acomps = ProdutoAdicional::all(array("conditions" => array("restaurante_id = ? AND quantas_unidades_ocupa > ? AND ativo = ?",$restaurante,0,1)));
    $porcoes = ProdutoAdicional::all(array("conditions" => array("restaurante_id = ? AND quantas_unidades_ocupa = ? AND ativo = ?",$restaurante,0,1)));
    $usuario = unserialize($_SESSION['usuario']);
    
    
}
?>
<script type="text/javascript" src="js/jquery-1.6.4.min.js"></script>
<script type="text/javascript" src="js/mask.js"></script>
<script>

$(document).ready(function() {
    
    num_adi = 0;
    
    $("#add_porcao").click( function(){
        $("#porcoes").append("<tr style='background:#F8F8F8;' id='novo_adicional-"+num_adi+"'><input type='hidden' name='novo_quantas_unidades_ocupa-"+num_adi+"' value='0'><td><input class='inp_ext' type='text' id='novo_nome-"+num_adi+"' name='novo_nome-"+num_adi+"' value=''></td><td><input class='inp_ext' type='text' name='novo_preco_adicional-"+num_adi+"' onkeyup='mask_moeda(this)' value='0,00'></td><td><input type='radio' name='novo_disponivel-"+num_adi+"' value='1' checked > Sim<br/><input type='radio' name='novo_disponivel-"+num_adi+"' value='0'> N&atilde;o</td><td><input class='inp_ext' /> </td><td><input type='hidden' id='novo_ativo-"+num_adi+"' name='novo_ativo-"+num_adi+"' value='1'><input type='image' src='background/fechar_pq.png' class='botao_remove_novo_adicional' qual='"+num_adi+"' value='x'></td></tr>");
        num_adi++;
        
        $(".botao_remove_novo_adicional").click( function(){
            qual = $(this).attr("qual");
            $("#novo_adicional-"+qual).remove();
        });
    });
    
    $("#add_acompanhamento").click( function(){
        $("#acompanhamentos").append("<tr style='background:#F8F8F8;' id='novo_adicional-"+num_adi+"'><td><input class='inp_ext' type='text' id='novo_nome-"+num_adi+"' name='novo_nome-"+num_adi+"' value=''></td><td><input class='inp_ext' type='text' name='novo_preco_adicional-"+num_adi+"' onkeyup='mask_moeda(this)' value='0,00'></td><td><input type='radio' name='novo_disponivel-"+num_adi+"' value='1' checked > Sim<br/><input type='radio' name='novo_disponivel-"+num_adi+"' value='0'> N&atilde;o</td><td><input class='inp_ext' type='text' name='novo_quantas_unidades_ocupa-"+num_adi+"' value='1'></td><td><input type='hidden' id='novo_ativo-"+num_adi+"' name='novo_ativo-"+num_adi+"' value='1'><input type='image' src='background/fechar_pq.png' class='botao_remove_novo_adicional' qual='"+num_adi+"'></td></tr>");
        num_adi++;
        
        $(".botao_remove_novo_adicional").click( function(){
            qual = $(this).attr("qual");
            $("#novo_adicional-"+qual).remove();
        });
    });

    
    
    //$("#porcoes").append("<tr id='novo_adicional-"+num_adi+"'><input type='hidden' name='novo_quantas_unidades_ocupa-"+num_adi+"' value='0'><th><input type='text' id='novo_nome-"+num_adi+"' name='novo_nome-"+num_adi+"' style='width:60px;' value=''></th><th><div style='position:relative; float: left;'>R$</div><div><input type='text' name='novo_preco_adicional-"+num_adi+"' style='width:50px; position:relative; float: left;' onkeyup='mask_moeda(this)' value='0,00'></div></th><th><div style='width:40px;'><input type='radio' name='novo_disponivel-"+num_adi+"' value='1' checked > Sim<br/><input type='radio' name='novo_disponivel-"+num_adi+"' value='0'> N&atilde;o</div></th><th><input type='hidden' id='novo_ativo-"+num_adi+"' name='novo_ativo-"+num_adi+"' value='1'><input type='button' class='desativar_novo' qual='"+num_adi+"' value='x"+num_adi+"'></th></tr>");
    $(".desativar").click( function(){
        qual = $(this).attr("qual");
        nome = $("#nome-"+qual).attr("value");
        con = confirm("Tem certeza que deseja excluir "+nome+"?");
        if(con){    
            $("#adicional-"+qual).hide();
            $("#ativo-"+qual).attr("value",0);
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
</script>

<form action="php/controller/salva_cardapio_extra" method="post">
  <div class="container">
    <div id="background_container">
      <?php include "menu_gerente.php" ?>
      <div id="central" class="span-24">
        <div class="span-6">
          <div id="barra_esquerda">
            <div id="info_restaurante">
              <div id="dados_cliente"> <img width="110" height="30" style="cursor:pointer" onclick="location.href=('gerente_extras');" src="background/cancel.png" /> </div>
              <div id="dados_cliente" style="margin-top:8px;">
                <input style="margin-left:0; padding:0;" type="image" value="submit" width="110" height="30" src="background/salvar.png" />
              </div>
            </div>
          </div>
        </div>
        <div class="span-18 last">
          <div id="titulo_box_destaque"> Controle Gerência </div>
          <div class="titulo_box_concluir" style="margin-top:4px;">Edição de acompanhamentos e porções extras,
            <?= $rest->nome ?>
            por
            <div style="display:inline; font:Arial; color:#E51B21; font-size:13px;"> Sr(a).
              <?= $usuario->nome ?>
            </div>
          </div>
          <div id="box_concluir">
            <div style="margin-top:16px;">
              <table style="width:674px; border:1px solid #bcbec0;">
                <tr>
                  <th colspan="3" class="titulo_cat"> Acompanhamentos e porções extras </th>
                </tr>
                <tr>
                  <td class="box_extra"><table id="acompanhamentos" >
                      <tr>
                        <td class="titulo_extra" colspan="5" > Acompanhamentos </td>
                      </tr>
                      <tr>
                        <td style="text-align:center;"> Nome </td>
                        <td style="text-align:center;"> Preço Adic. </td>
                        <td style="text-align:center;"> Disponível </td>
                        <td style="text-align:center;"> Unidades </td>
                        <td></td>
                      </tr>
                      <?
        $countad = 0;
        if($acomps){
            foreach($acomps as $item){ ?>
                      <tr style="background:#F8F8F8;" id="adicional-<?= $countad ?>">
                        <input type="hidden" name="id-<?= $countad ?>" value="<?= $item->id ?>">
                        <td style="text-align:center;"><input class="inp_ext" type="text" id="nome-<?= $countad ?>" name="nome-<?= $countad ?>" value='<?= $item->nome ?>'></td>
                        <td style="text-align:center;"><input class="inp_ext" type="text" name="preco_adicional-<?= $countad ?>" onkeyup="mask_moeda(this)" value='<?= $item->preco_adicional ?>'></td>
                        <td style="text-align:center;"><input type="radio" name="disponivel-<?= $countad ?>" value="1" <?= $item->disponivel ? "checked" : "" ?> >
                          Sim<br/>
                          <input type="radio" name="disponivel-<?= $countad ?>" value="0" <?= $item->disponivel ? "" : "checked" ?> >
                          N&atilde;o</td>
                        <td style="text-align:center;"><input class="inp_ext" type="text" name="quantas_unidades_ocupa-<?= $countad ?>" value='<?= $item->quantas_unidades_ocupa ?>'></td>
                        <td style="text-align:center;"><input type="hidden" id="ativo-<?= $countad ?>" name="ativo-<?= $countad ?>" value="1">
                          <input type="image" src="background/fechar_pq.png"  class="desativar" qual="<?= $countad ?>" >
                          </th></td>
                        <? $countad++; }
        }?>
                      <tr style="background:#F8F8F8; color:#F90">
                        <td colspan="5" style="text-align:center; cursor:pointer; color:#F90" id="add_acompanhamento" qual="acompanhamentos"> Criar novo + </td>
                      </tr>
                    </table></td>
                  <td style="width:14px; float:left;"></td>
                  <td class="box_extra"><table id="porcoes">
                      <tr>
                        <td class="titulo_extra" colspan="5"> Porções Extras </td>
                      </tr>
                      <tr>
                        <td style="text-align:center;"> Nome </td>
                        <td style="text-align:center;"> Preço Adic. </td>
                        <td style="text-align:center;"> Disponível </td>
                        <td style="text-align:center;"> Unidades </td>
                        <td></td>
                      </tr>
                      <?

        if($porcoes){
            foreach($porcoes as $item){ ?>
                      <tr style="background:#F8F8F8;" id="adicional-<?= $countad ?>">
                        <input type="hidden" name="quantas_unidades_ocupa-<?= $countad ?>" value="0">
                        <input type="hidden" name="id-<?= $countad ?>" value="<?= $item->id ?>">
                        <td><input class="inp_ext" type="text" id="nome-<?= $countad ?>" name="nome-<?= $countad ?>" value='<?= $item->nome ?>'></td>
                        <td><input class="inp_ext" type="text" name="preco_adicional-<?= $countad ?>" onkeyup="mask_moeda(this)" value='<?= $item->preco_adicional ?>'>
                          </td>
                        <td>
                            <input type="radio" name="disponivel-<?= $countad ?>" value="1" <?= $item->disponivel ? "checked" : "" ?> >
                            Sim<br/>
                            <input type="radio" name="disponivel-<?= $countad ?>" value="0" <?= $item->disponivel ? "" : "checked" ?> >
                            N&atilde;o</td>
                        <td>
                        	<input class="inp_ext" />
                        </td>    
                        <td><input type="hidden" id="ativo-<?= $countad ?>" name="ativo-<?= $countad ?>" value="1">
                          <input type="image" src="background/fechar_pq.png" class="desativar" qual="<?= $countad ?>"></td>
                      </tr>
                      <? $countad++; }
        }?>
                      <tr style="background:#F8F8F8; color:#F90">
                        <td colspan="5" style="text-align:center; cursor:pointer; color:#F90" id="add_porcao" qual="porcoes"> Criar novo + </td>
                      </tr>
                    </table></td>
                </tr>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</form>
<? include("include/footer.php"); ?>
