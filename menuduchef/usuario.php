<?

include("include/header2.php");

//$itens = Produto::find_all_by_restaurante_id($_GET['id'], array("order" => "nome asc"));
$usuario_obj = unserialize($_SESSION['usuario_obj']);

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
"http://www.w3.org/TR/html4/strict.dtd"
>
<style>
		
    .bot_del{
	width:20px; 
	height:23px;
	padding-top:5px; 
	float:left; 
	position:relative;
	border:#bcbec0 solid 1px;
	color:#FFF; 
	cursor:pointer; 
	font-weight:normal;
	margin-top:6px;
	text-align:middle;
	margin-left:-1px;
	}
    .tabela_ends td{
        vertical-align:top;
    }
</style>   
<meta http-equiv="content-type" content="text/html" charset="UTF-8" />  

   <link rel="stylesheet" href="css_/blueprint/screen.css" type="text/css" media="screen, projection">
   <link rel="stylesheet" href="css_/blueprint/print.css" type="text/css" media="print">  
   <link rel="stylesheet" href="css_/estilo.css" type="text/css" media="screen"> 
   <!--[if lt IE 8]><link rel="stylesheet" href="css_/blueprint/ie.css" type="text/css" media="screen, projection"><![endif]-->
<script type="text/javascript" src="js/mask.js"></script>
<script src="js/jquery-1.6.4.min.js"></script>
<script>
$(document).ready( function (){
	$('.desloca').mouseover(function(){
		$(this).css('margin-left',10);
	});
	$('.desloca').mouseout(function(){
		$(this).css('margin-left',0);
	});
        $("#mudar_senha").click(function(){
            marcado = $(this).attr("checked");
            
            if(!marcado){
                $("#senha").css("background","#EEE");
                $("#senha").attr("value","");
                $("#senha").attr("readonly","true");
                $("#senhaconf").css("background","#EEE");
                $("#senhaconf").attr("value","");
                $("#senhaconf").attr("readonly","true");
            }else{
                $("#senha").css("background","#FFF");
                $("#senha").removeAttr("readonly");
                $("#senhaconf").css("background","#FFF");
                $("#senhaconf").removeAttr("readonly");
            }
        });
        count_tels = 0;
        qtd_tels_ja = <?= sizeof($usuario_obj->telefones) ?>;
        $("#add_tel").click(function(){
            if(qtd_tels_ja<4){
                count_tels++;
                qtd_tels_ja++;

                if($("#div_novotelefone_0").css("display")=="none"){
                    $("#div_novotelefone_0").show();
                }else if($("#div_novotelefone_1").css("display")=="none"){
                    $("#div_novotelefone_1").show();
                }else if($("#div_novotelefone_2").css("display")=="none"){
                    $("#div_novotelefone_2").show();
                }else if($("#div_novotelefone_3").css("display")=="none"){
                    $("#div_novotelefone_3").show();
                }
           }
        });
        $(".bot_del").click(function(){
            qtd_tels_ja--;
            qual = $(this).attr("qual");
            qual2 = qual.split("_");
            if(qual2[0]=="telefone"){
                $("#div_telefone_"+qual2[1]).hide();
                $("#telefone_ativo_"+qual2[1]).attr("value",0);
            }else{
                if($("#div_novotelefone_3").css("display")=="block"){
                    $("#div_novotelefone_3").hide();
                    $("#novotelefone_3").attr("value","");
                }else if($("#div_novotelefone_2").css("display")=="block"){
                    $("#div_novotelefone_2").hide();
                    $("#novotelefone_2").attr("value","");
                }else if($("#div_novotelefone_1").css("display")=="block"){
                    $("#div_novotelefone_1").hide();
                    $("#novotelefone_1").attr("value","");
                }else if($("#div_novotelefone_0").css("display")=="block"){
                    $("#div_novotelefone_0").hide();
                    $("#novotelefone_0").attr("value","");
                }
            }
        });
        $("#vericep").click(function(){
            
            cep = $("#cep").attr("value");
           
            $("#div_cidade").load("php/controller/traz_cidade?cep="+cep);
            $("#div_bairro").load("php/controller/traz_bairro?cep="+cep);
            $("#div_endereco").load("php/controller/traz_endereco?cep="+cep);
            $("#div_estado").load("php/controller/traz_estado?cep="+cep);
            
            $("#verifica_cep").load("php/controller/traz_verifica?cep="+cep);
        });
        
        $("#botao_novoend").click(function(){
            $("#form_dados_usuario_novoend").submit();
        });
        $(".exc").click(function(){
            $("#action2").attr("value","deletaendereco");
            qual = $(this).attr("qual");
            $("#end_alvo").attr("value",qual);
            $("#form_dados_usuario_delend").submit();
        });
        $(".favoritar").click(function(){
            $("#action2").attr("value","favendereco");
            $("#form_dados_usuario_delend").submit();
        });
        
        $("#botao_dadosusuario").click(function(){
            if($("#mudar_senha").attr("checked")=="checked"){
                s1 = $("#senha").attr("value");
                s2 = $("#senhaconf").attr("value");
                if(s1==s2){
                    $("#form_dados_usuario").submit();
                }else{
                    alert("A senha n\u00e3o est\u00e1 igual \u00e0 repeti\u00e7\u00e3o.");
                }
            }else{
                $("#form_dados_usuario").submit();
            }
            
        });
});
</script>

<div class="container">
	<div id="background_container">
    	<?php include "menu_voltar.php" ?>
        <div id="central" class="span-24">
			<div class="span-6">
            	<div id="barra_esquerda">
                	<div id="info_restaurante">
                    	<div id="dados_cliente" style="padding-top:62px;">
                        	<a href="usuario">
                            	<img class="desloca" src="background/meus_dados.png" />
                            </a>
                        </div>
                        <div id="dados_cliente">
                        	<a href="usuario_pedidos">
                            	<img class="desloca" src="background/meus_pedidos.png" />
                            </a>
                        </div>                   
                    </div>    
                </div>
            </div>
            <div class="span-18 last">
            	
                 <!-- <div class="prepend-top" id="status">
                        <div id="numero_rest" style="color:#FFF" ><span style="margin-left:8px;"> </span>
                        </div> 
                        <div id="status_pedido">
                        	<img src="background/passo4.png" width="541" height="43" alt="passo1">
                        </div> 
                    </div> -->
                    
                    <div id="titulo_box_destaque">
                    Meus Dados
                    </div>
                    <div class="titulo_box_concluir" style="margin-top:4px;">Edi&ccedil;&atilde;o de &aacute;rea do usu&aacute;rio, por
                    	<div style="display:inline; font:Arial; color:#E51B21; font-size:13px;"><?= $usuario_obj->nome ?>
                       		
                        </div>
					</div>
                    
                    
                    <div class="titulo_box_pedido">Meus Dados
					</div>
                    <div class="box_pedido" style="height:342px">
                        <form id="form_dados_usuario" action="php/controller/salva_dados_usuario" method="post">
                            <input type="hidden" name="action" value="usuario">
                        <div style="width:330px; float:left;">
                            
                                
                            <label>Nome</label><input type="text" id="nome" name="nome" value="<?= $usuario_obj->nome ?>" maxlength="100" class="campo">
                            <label>Nascimento</label>
                            <?
                                $quebra=explode("/",$usuario_obj->data_nascimento);
                                $dia = $quebra[0];
                                $mes = $quebra[1];
                                $ano = $quebra[2];
                            ?>
                            <input style="width:26px;" type="text" id="diaNascimento" name="diaNascimento" class="text campo" maxlength="2" value="<?= $dia ?>" placeholder="dd" /> 
        
                            <input style="width:28px;" type="text" id="mesNascimento" name="mesNascimento" class="text campo" maxlength="2" value="<?= $mes ?>" placeholder="mm" />
        
                            <input style="width:40px;" type="text" id="anoNascimento" name="anoNascimento" class="text campo" maxlength="4" value="<?= $ano ?>" placeholder="aaaa" />
                            
                            
                            <div id="lista_telefones" style="max-height:190px; background:#F2F2F2; overflow-y:auto;">
                            <label>Telefone(s)</label>
                            <? 
                            $telefones = TelefoneConsumidor::all(array("conditions"=>array("consumidor_id = ?",$usuario_obj->id)));
                            if($telefones){
                                $contel = 0;
                                foreach($telefones as $tel){
                                ?>        
                                <div id="div_telefone_<?= $tel->id ?>" >
                                    <input type="hidden" name="telefone_ativo_<?= $tel->id ?>" id="telefone_ativo_<?= $tel->id ?>" value="1">
                                    <input type="text" style="position:relative; float:left;" id="telefone_<?= $tel->id ?>" name="telefone_<?= $tel->id ?>" maxlength="12" class="campo" value="<?= $tel->numero ?>">
                                <?
                                    if($contel>0){ ?>
                                        <div class="bot_del desativar" style="background:#CCC;" qual="telefone_<?= $tel->id ?>">&nbsp; Х &nbsp; </div> 
                                    <? }
                                ?>
                                </div>
                            <? 
                                    $contel++;
                                }
                            } 
                            $contel = 0;
                            while($contel<4){ ?>
                                <div id="div_novotelefone_<?= $contel ?>" style="display:none"><input type="text" style="position:relative; float:left;" id="novotelefone_<?= $contel ?>" name="novotelefone_<?= $contel ?>" maxlength="12" class="campo" value=""><div class="bot_del desativar" style="background:#CCC;" qual="novotelefone_<?= $contel ?>">&nbsp; Х &nbsp; </div> </div>
                            
                                <?
                                $contel++;
                            }
                            ?>
                            </div>
                            <u style="cursor:pointer;" id="add_tel">Adicionar outro número de contato</u>    
                            
                        </div>
                        <div style="width:330px; margin-left:14px; float:left;">
                        	<label>CPF</label><input type="text" id="cpf" name="cpf" onkeyup="mask_cpf(this)" value="<?= $usuario_obj->cpf ?>" maxlength="14" class="campo"> 
                        	<label>Sexo</label>			
                                                        <select name="sexo" class="campo"> 
                                                        <option value="">Selecione</option>    
                                                            <option <? if($usuario_obj->sexo=="Masculino"){ echo "selected"; } ?> value="Masculino">Masculino</option>  
                                                            <option <? if($usuario_obj->sexo=="Feminino"){ echo "selected"; } ?> value="Feminino">Feminino</option> 
                                                        </select>
                                <label for="senha"><input type="checkbox" id="mudar_senha" name="mudar_senha" > Mudar senha </label><input type="password" readonly="true" style="background:#EEE;" id="senha" name="senha" maxlength="100" class="campo">
                            <label for="senha">Repita nova senha</label><input type="password" readonly="true" style="background:#EEE;" id="senhaconf" name="senhaconf" maxlength="100" class="campo">					
                            <img src="background/salvar.png" id="botao_dadosusuario" width="116" height="32" style="margin-top:8px; cursor:pointer;" />
                        </div>
                        </form>   
                    </div>
                        <form id="form_dados_usuario_delend" action="php/controller/salva_dados_usuario" method="post">
                            <input type="hidden" id="action2" name="action2" value="deletaendereco">
                            <input type="hidden" name="end_alvo" id="end_alvo" value="">
                    <div class="titulo_box_pedido">Endereço de entrega   	
					</div>
                    <div class="box_pedido" style="height:100%">
                    	<table class="tabela_ends">
                        	<tr>
                            	<th>
                                	CEP
                                </th>
                                <th>
                                	Endereço
                                </th>
                                <th>
                                	Complemento
                                </th>
                                <th>
                                	Refer&ecirc;ncia
                                </th>
                                <th>
                                	Favorito
                                </th>
                                <th>
                                </th>
                                <th>
                                </th>
                            </tr>
                            <? 
                            
                            $ends=EnderecoConsumidor::all(array("conditions"=>array("consumidor_id = ?",$usuario_obj->id)));
                            if($ends){
                                foreach($ends as $end){
                                ?>
                            <tr>
                            	<td>
                                	<?= $end->cep ?>
                                </td>
                                <td>
                                	<?= $end->logradouro ?>, <?= $end->numero ?> - <?= $end->bairro->nome ?>
                                </td>
                                <td>
                                	<?= $end->complemento ?>
                                </td>
                                <td>
                                	<?= $end->referencia ?>
                                </td>
                                <td style="text-align:center">
                                        <input type="radio" class="favoritar" name="favorito" <?= ($end->favorito==1) ? "checked" : "" ?> value="<?= $end->id ?>">
                                </td>
                                
                                <td class="exc" qual="<?= $end->id ?>">
                                	Excluir
                                </td>
                            </tr>
                            <? }} ?>
                        </table>
                    </div>
                        </form>
                 <form id="form_dados_usuario_novoend" action="php/controller/salva_dados_usuario" method="post">
                            <input type="hidden" name="action3" value="novoendereco">
                    <div class="titulo_box_pedido">Adicionar novo endereço   	
					</div>
                    <div class="box_pedido" style="height:290px">
                    	
                            <div id="verifica_cep"></div>
                   		<div style="width:330px; float:left;">
                            <div id="div_cep"><label>CEP*</label><input id="cep" type="text" name="cep" maxlength="100" class="campo"> <img id="vericep" src="background/maglass.png" style="position:absolute; margin-top:8px; margin-left:3px; cursor:pointer"></div>
                            <div id="div_endereco"><label>Endere&ccedil;o</label><input type="text" style="background:#EEE" readonly="true" name="endereco" maxlength="100" class="campo"></div>
                            <div id="div_numero"><label>Numero*</label><input type="text" name="numero" maxlength="100" class="campo"></div> 
                            <div id="div_bairro"><label>Bairro</label><input type="text" style="background:#EEE" readonly="true" name="bairro" maxlength="100" class="campo"></div>                    	
                    	</div>
                        <div style="width:330px; margin-left:14px; float:left;">
                            <div id="div_cidade"><label>Cidade</label><input type="text" style="background:#EEE" readonly="true" name="cidade" maxlength="100" class="campo"></div> 
                            <div id="div_estado"><label>Estado</label><input type="text" style="background:#EEE" readonly="true" name="estado" maxlength="100" class="campo"></div>
                            <div id="div_complemento"><label>Complemento</label><input type="text" name="complemento" maxlength="100" class="campo"></div> 
                            <div id="div_referencia"><label>Ponto de referência</label><input type="text" name="pr" maxlength="100" class="campo"></div>    
                        </div>
                        <img src="background/botao_add.png" id="botao_novoend" width="116" height="32" style="margin-top:8px; cursor:pointer;">
                    	
                    
                    </div>
                 </form>
                                                  
            </div>
            
		</div>
	</div>
</div>
<? include("include/footer.php"); ?>