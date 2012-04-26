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

/////// parte bem especifica, pra que restuarantes atendam cidades vizinhas
$parnamirim=Cidade::find(array("conditions"=>array("nome = ? AND uf_id = ?","Parnamirim",21)));
if($rest->cidade->nome=="Natal"){
    $cidalt=Cidade::find(array("conditions"=>array("nome = ? AND uf_id = ?","Parnamirim",21)));
    $cidade_alternativa = $cidalt->id;
    
}else if($parnamirim->nome=="Parnamirim"){
    $cidalt=Cidade::find(array("conditions"=>array("nome = ? AND uf_id = ?","Natal",21)));
    $cidade_alternativa = $cidalt->id;
}
///////

$bairros = Bairro::all(array("order"=>"nome","conditions"=>array("cidade_id = ? OR cidade_id = ?",$cidade,$cidade_alternativa)));
?>
<script type="text/javascript" src="js/jquery-1.6.4.min.js"></script>
<script type="text/javascript" src="js/mask.js"></script>
<script>

$(document).ready(function() {
    $("#salvar").click(function(){
        $("#form_gerente").submit();
    });
    $("#salvar_inf_principal").click(function(){
        $("#form_inf_principal").submit();
    });
    
    $("#botao_cancelar").click(function(){
        con = confirm("Tem certeza que deseja cancelar?");
        if(con){
            location.href=('gerente_principal');
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

<div class="container">
  <div id="background_container">
    <?php include "menu_gerente.php" ?>
    <div id="central" class="span-24">
      <div class="span-6">
        <div id="barra_esquerda"  >
          <div id="info_restaurante">
             <div style="cursor:pointer" onclick="show('pop_dados_rest')"> 
            <div id="categoria_rest"><?= $rest->getNomeCategoria() ?> </div>
            <div id="nome_rest"><?= $rest->nome ?> </div>
            <div id="avatar_rest"> <img src="images/restaurante/<?= $rest->imagem ?>" border="0"> </div>
            <div id="formas_pagamento">Formas de pagamento </div>
            <div id="tempo_entrega"><span style="color:#E51B21;">Endereço:</span> <?= $rest->endereco ?> </div>
             </div>
            <img style="margin-top:12px;cursor:pointer;" width="110" height="30" src="background/cancel.png" id="botao_cancelar"> <img width="110" height="30" id="salvar" style="cursor:pointer" src="background/salvar.png" > </div>
        </div>
      </div>
      <div class="span-18 last">
        <div id="titulo_box_destaque"> Controle Gerência </div>
        <div class="titulo_box_concluir" style="margin-top:4px;">Controle de bairros atendidos por
          <?= $rest->nome ?>, modificado por
          <div style="display:inline; font:Arial; color:#E51B21; font-size:13px;"><?= $usuario->nome ?>.</div>
        </div>
        <div id="box_concluir">
          <div id="pop_dados_rest" class="pop-up" style="position:absolute; display:none;">
              <form id="form_inf_principal" action="php/controller/restaurante_auto_cadastro2" method="post">    
                <div style="width:564px; height:80px; position:relative; float:left; margin:8px 0; background:#F4F4F4;">
                <div class="titulo_pop">Informações principais</div>
                <img src="background/logo_noback.png" height="97" width="101" style="position:absolute; top:-24px; left:-10px;"> <img src="background/close.png" height="28" width="28" style="position:absolute; top:-16px; left:548px; cursor:pointer;" onclick="show('pop_dados_rest')"> 
                </div>
                <?
                    $quebra = explode(", ",$rest->endereco);
                    $rua = $quebra[0];
                    $quebra = explode(" - ",$quebra[1]);
                    $numero = $quebra[0];
                    $bairro = $quebra[1];
                ?>
                    <table style="background:#F4F4F4; font-size:12px; width:564px; color:#999; float:left; position:relative;">
                                <tr>
                      <td> Rua: </td>
                      <td><input name="rua" class="inp_res" value="<?= $rua ?>" /></td>
                      <td> Bairro: </td>
                      <td><input name="bairro" class="inp_res" value="<?= $bairro ?>" /></td>

                        </tr>
                    <tr>
                      <td> Número: </td>
                      <td><input name="numero" class="inp_res" value="<?= $numero ?>" /></td>
                      <td> Complemento: </td>
                      <td><input name="complemento" class="inp_res" value="<?= $rest->complemento ?>" /></td>

                    </tr>
                    <tr>
                      <td>
                        Categoria principal:
                      </td>
                      <td>
                        <input  name="categoria" class="inp_res" value="<?= $rest->getNomeCategoria() ?>"/>
                      </td>
                       <td>
                        Telefone:
                      </td>
                      <td>
                        <input  name="telefone" class="inp_res" value="<?= $rest->telefone ?>"/>
                      </td>
                    </tr>
                    <tr>
                        <td>
                            Descrição:
                        </td>
                        <td colspan="3">
                            <input name="descricao" class="inp_res" style="width:400px" value="<?= $rest->descricao ?>"/>
                        </td>
                    </tr>
                    <tr style="height:16px;">
                    </tr>

                    <tr> 
                        <td>
                                Categorias alternativas:
                        </td>
                        <td colspan="3">
                            <div style="height:50px; overflow-y:auto; background:#FFF;">
                                <table><tr>
                                <?
                                    $cats=TipoRestaurante::all();
                                    if($cats){
                                        $countcat = 0;
                                        foreach($cats as $cat){ 
                                            $sel = '';
                                            $conf=RestauranteTemTipo::find(array("conditions"=>array("restaurante_id = ? AND tiporestaurante_id = ?",$_SESSION['restaurante_id'],$cat->id)));
                                            if($conf){
                                                $sel = "checked";
                                            }
                                            ?>
                                            <td><input type='checkbox' <?= $sel ?> name='tiporestaurante_<?= $cat->id ?>'>&nbsp;<?= $cat->nome ?></td>
                                        <? 
                                            $countcat++;
                                            if(($countcat%3)==0){
                                                echo "</tr><tr>";    
                                            }
                                        }
                                    }
                                ?>
                                </tr></table>            
                            </div>
                        </td> 
                    </tr>
                    <tr>
                        <td>
                                Formas de pagamento:
                        </td>
                        <td colspan="3">
                            <div style="height:50px; overflow-y:auto; background:#FFF;">
                                <table><tr>
                                <?
                                    $fps=FormaPagamento::all();
                                    if($fps){
                                        $countfp = 0;
                                        foreach($fps as $fp){ 
                                            $sel = '';
                                            $conf=RestauranteAceitaFormaPagamento::find(array("conditions"=>array("restaurante_id = ? AND formapagamento_id = ?",$_SESSION['restaurante_id'],$fp->id)));
                                            if($conf){
                                                $sel = "checked";
                                            }
                                            ?>
                                            <td><input type='checkbox' <?= $sel ?> name='formapagamento_<?= $fp->id ?>'>&nbsp;<?= $fp->nome ?></td>
                                        <? 
                                            $countfp++;
                                            if(($countfp%3)==0){
                                                echo "</tr><tr>";    
                                            }
                                        }
                                    }
                                ?>
                                </tr></table>            
                            </div>
                        </td> 
                    </tr>

                        </table>
                        <div style="width:564px; height:30px; position:relative; float:left; margin:8px 0;"> <img id="salvar_inf_principal" style="cursor:pointer" src="background/salvar.png" width="110" height="30"> </div>
          </form>
          </div> 
        </div>  
            
          <div style="margin-top:16px;">
            <form id="form_gerente" action="php/controller/restaurante_auto_cadastro" method="post">
            <input type="hidden" name="id" value="<?= $rest->id ?>">
             
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
                        $atende=RestauranteAtendeBairro::find(array("conditions"=>array("restaurante_id = ? AND bairro_id = ?",$obj->id,$bairro->id)));
                        
                        ?>
              <tr>
              	<td style="padding-left:4px; margin-left:12px;">
                <input class="adjacent" type="checkbox" name="bairro_<?= $bairro->id ?>" value="<?= $bairro->id ?>" id="bairro_id_<?= $bairro->id ?>" <? if($obj->atendeBairro($bairro->id)) { ?>checked="checked"<? } ?> /></td>
                <td>
                <label class="adjacent" for="bairro_id_<?= $bairro->id ?>">
                  <?= $bairro->nome ?>
                  <?
                 
                    if($bairro->cidade_id!=$rest->cidade_id){
                        echo " (".$bairro->cidade->nome.")";
                    }
                  ?>
                </label></td>
                <td>
                <input type="text" name="preco_entrega_<?= $bairro->id ?>" onkeyup="mask_moeda(this)" value="<? if($atende){ echo number_format($atende->preco_entrega, 2, ',', '.'); } ?>" ></td>
                <td>
                <input type="text" name="tempo_entrega_<?= $bairro->id ?>" value="<? if($atende){ echo $atende->tempo_entrega; } ?>" ></td>
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