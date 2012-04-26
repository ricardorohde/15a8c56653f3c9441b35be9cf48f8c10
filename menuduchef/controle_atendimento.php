<?
session_start();

include("include/header4.php");


if($_SESSION['restaurante_id']){
    $restaurante = $_SESSION['restaurante_id'];
    $rest = Restaurante::find($restaurante);
}

$usuario = unserialize($_SESSION['usuario']);
$usuario_obj = unserialize($_SESSION['usuario_obj']);
$obj = Restaurante::find($usuobj->restaurante_id);
$tipos = TipoRestaurante::all();
$tipos_produto = TipoProduto::all();
$funcionarios = UsuarioRestaurante::all(array("conditions"=>array("restaurante_id = ?",$_SESSION['restaurante_id'])));
?>
<script type="text/javascript" src="js/jquery-1.6.4.min.js"></script>
<script type="text/javascript" src="js/mask.js"></script>
<script>

$(document).ready(function() {
    $("#botao_cancelar").click(function(){
        con = confirm("Tem certeza que deseja cancelar?");
        if(con){
            location.href=('controle_atendimento');
        }
    });
    $("#salvar").click(function(){
        ok = 1;
        
        $(".checksenha").each(function(){
            qual = $(this).attr("qual");
            marcado = $(this).attr("checked");
            if(marcado){
                sen = $("#senha-"+qual).attr("value");
                senrep = $("#repetirsenha-"+qual).attr("value");
                if(sen!=senrep){
                    ok = 0;
                    nome = $("#nome-"+qual).attr("value");
                    alert("A senha de "+nome+" não está igual à repetição.");
                }
            }
        });
        if(ok){
            $("#action").attr("value","alteracoes");
            $("#form_gerente").submit();
        }    
    });
    $("#botao_salvar_novo_funcionario").click(function(){
        ok = 1;
 
        sen = $("#novasenha").attr("value");
        senrep = $("#repetirsenha").attr("value");
        if(sen!=senrep){
            ok = 0;
            alert("A senha do novo funcionário não está igual à repetição.");
        }  
        
        if(ok){
            $("#action").attr("value","novofuncionario");
            $("#form_gerente").submit();
        }    
    });
    $(".desativar").click( function(){
        tipo = $(this).attr("tipo");
        if(tipo==2){
            alert("Para excluir um gerente, entre em contato com a administracao Delivery du Chef");
        }else{    
            qual = $(this).attr("qual");
            nome = $(this).attr("nome");
            con = confirm("Tem certeza que deseja excluir "+nome+"?");
            if(con){    
                $("#funcionario-"+qual).hide();
                $("#ativo-"+qual).attr("value",0);
            }
        }    
    });
});
function novo_funcionario(){
    //oque = document.getElementById("jamexeu");
    show("novo_funcionario");
}
function show(x){
    oque = document.getElementById(x);
    if(oque.style.display == "block"){
        oque.style.display = "none";
    }else{
        oque.style.display = "block";
    }
}
</script>
<script>
$(document).ready( function (){
	$('.desloca').mouseover(function(){
		$(this).css('margin-left',10);
	});
	$('.desloca').mouseout(function(){
		$(this).css('margin-left',0);
	});
        $(".checksenha").click(function(){
            qual = $(this).attr("qual");
            pode = $(this).attr("pode");
            marcado = $(this).attr("checked");
            
            if(pode==1){
                if(!marcado){
                    $("#senha-"+qual).css("background","#DDD");
                    $("#senha-"+qual).attr("value","");
                    $("#senha-"+qual).attr("readonly","true");
                    $("#repetirsenha-"+qual).css("background","#DDD");
                    $("#repetirsenha-"+qual).attr("value","");
                    $("#repetirsenha-"+qual).attr("readonly","true");
                }else{
                    $("#senha-"+qual).css("background","#FFF");
                    $("#senha-"+qual).removeAttr("readonly");
                    $("#repetirsenha-"+qual).css("background","#FFF");
                    $("#repetirsenha-"+qual).removeAttr("readonly");
                }
            }else{
                alert("Não é possível alterar senha de outros gerentes.");
                marcado = $(this).removeAttr("checked");
            }
            
        });
});
</script>

<div class="container">
  <form id="form_gerente" action="php/controller/restaurante_cadastro_funcionarios" method="post">
  <input type="hidden" name="action" id="action" value="">    
  <div id="background_container">
    <?php include "menu_gerente.php" ?>
    <div id="central" class="span-24">
      <div class="span-6">
        <div id="barra_esquerda">
          <div id="info_restaurante">
            <div id="dados_cliente"> <img class="desloca" src="background/add_fun.png" onclick="novo_funcionario()" /> </div>
            <img style="margin-top:12px; cursor:pointer;" width="110" height="30" src="background/cancel.png"  id="botao_cancelar"> <img width="110" height="30" id="salvar" style="cursor:pointer" src="background/salvar.png" > </div>
        </div>
      </div>
      <div class="span-18 last">
        <div id="titulo_box_destaque"> Controle GerÃªncia </div>
        <div class="titulo_box_concluir" style="margin-top:4px;">Rela&ccedil;&atilde;o de funcion&aacute;rios de
          <?= $rest->nome ?>, modificado por
          <div style="display:inline; font:Arial; color:#E51B21; font-size:13px;"><?= $usuario->nome ?>.</div>
        </div>
        <div id="box_concluir">
          <div id="novo_funcionario" class="pop-cat" style="display:none; position:absolute; padding:10px; z-index:50; left:5%; top:20%;">
              
                <div style="width:364px; height:80px; position:relative; float:left; margin:8px 0; background:#F4F4F4;">
                <div class="titulo_pop">Novo Funcion&aacute;rio</div>
                <img src="background/logo_noback.png" height="68" width="71" style="position:absolute; top:-24px; left:-10px;"> <img src="background/close.png" height="28" width="28" onclick="show('novo_funcionario')" style="position:absolute; cursor:pointer; top:-16px; left:346px;"> 
                </div>
                  <div>  
                        
                        <table style="background:#F4F4F4; font-size:12px; width:364px; color:#999; float:left; position:relative;">
                          <tr>
                            <td style="text-align:right">Nome: </td>
                            <td style="padding-left:22px; "><input name="novonome" class="inp_res" style="width:220px;" value=""></td>
                          </tr>
                          <tr>
                            <td style="text-align:right">E-mail: </td>
                            <td style="padding-left:22px; "><input name="novoemail" class="inp_res" style="width:220px;" value=""></td>
                          </tr>
                          <tr>
                            <td style="text-align:right">Tipo: </td>
                            <td style="padding-left:22px; "><select name="novotipo" class="sel_res" style="width:220px;">
                                    <option value="3">Atendente</option>
                                    <option value="2">Gerente</option>
                                </select>
                                </td>
                          </tr>
                          <tr>
                            <td style="text-align:right">Senha: </td>
                            <td style="padding-left:22px; "><input type="password" id="novasenha" name="novasenha" class="inp_res" style="width:220px;" value=""></td>
                          </tr>
                          <tr>
                            <td style="text-align:right">Repita a Senha: </td>
                            <td style="padding-left:22px; "><input type="password" id="repetirsenha" name="repetirsenha" class="inp_res" style="width:220px;" value=""></td>
                          </tr>

                        </table>
                  </div>
                <div style="width:364px; height:30px; position:relative; float:left; margin:8px 0;"> <img id="botao_salvar_novo_funcionario" style="cursor:pointer" src="background/salvar.png" width="110" height="30"> </div>
              
            </div>  
          <div style="margin-top:16px;">
            
            <input type="hidden" name="id" value="<?= $rest->id ?>">
             
            <table style="width:674px; border:1px solid #bcbec0; font-family:Arial;">
              <tr>
                
                <th style="padding-left:4px;">Funcionario</th>
                <th>E-mail</th>
                <th>Tipo</th>
                <th></th>
                <th>Senha</th>
                <th>Repetir Senha</th>
                <th >Excluir</th>
              </tr>
              <? if($funcionarios){
                    foreach($funcionarios as $fun){
                       
                        ?>
              <tr id="funcionario-<?= $fun->id ?>">
              	
                <td style="padding-left:4px; margin-left:12px;">
                  <input  class="inp_ger" type="text" id="nome-<?= $fun->id ?>" name="nome-<?= $fun->id ?>" value="<?= $fun->nome ?>">
                  <input type="hidden" id="ativo-<?= $fun->id ?>" name="ativo-<?= $fun->id ?>" value="1">
                  <input type="hidden" id="idfun-<?= $fun->id ?>" name="idfun-<?= $fun->id ?>" value="1">
                </td>
                <td>
                    <input  class="inp_ger" type="text" name="email-<?= $fun->id ?>" value="<?= $fun->email ?>">
                </td>
                <td>
                  <?
                    if($fun->tipo==2){
                        echo "Gerente";
                    }else if($fun->tipo==3){
                        echo "Atendente";
                    }
                  ?>
                </td>
                <td>
                    <? 
                        $pode = 0;
                        if($fun->tipo==3){
                            $pode = 1;
                        }else if($usuario_obj->id==$fun->id){
                            $pode = 1;
                        }
                    ?>
                  <input type="checkbox" class="checksenha" pode="<?= $pode ?>" qual="<?= $fun->id ?>" name="mudarsenha-<?= $fun->id ?>" >
                </td>
                <td>
                  <input class="inp_ger" type="password" readonly="true" style="width:65px; background:#DDD;" id="senha-<?= $fun->id ?>" name="senha-<?= $fun->id ?>" >
                </td>
                <td>
                  <input class="inp_ger" type="password" readonly="true" style="width:65px; background:#DDD;" id="repetirsenha-<?= $fun->id ?>" name="repetirsenha-<?= $fun->id ?>" >
                </td>
                <td>
                <div class="botoes_cat desativar" style="background:#CCC" nome="<?= $fun->nome ?>" tipo="<?= $fun->tipo ?>" qual="<?= $fun->id ?>"> Ð¥ </div>    
                </td>
              </tr>
              <? }
                } ?>

            </table>
               
          </div>
        </div>
      </div>
    </div>
  </div>
   </form>
</div>
<script>
<? 

if($_GET['ja']==1){ ?>
    alert("O e-mail fornecido j\u00e1 est\u00e1 cadastrado no sistema, escolha outro.");
<? }
?>
</script>
<?
include("include/footer.php"); ?>