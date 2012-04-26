<?
    include("include/header2.php");
    $endereco = unserialize($_SESSION['endereco']);
    $aguardando = unserialize($_SESSION['aguardando']);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
"http://www.w3.org/TR/html4/strict.dtd"
>
<script src="js/jquery-1.6.4.min.js"></script>
<meta http-equiv="content-type" content="text/html" charset="UTF-8" /> 
<script type="text/javascript" src="js/mask.js"></script>
<title>Delivery du Chef</title>
   <link rel="stylesheet" href="css_/blueprint/screen.css" type="text/css" media="screen, projection">
   <link rel="stylesheet" href="css_/blueprint/print.css" type="text/css" media="print">  
   <link rel="stylesheet" href="css_/estilo.css" type="text/css" media="screen"> 
   <!--[if lt IE 8]><link rel="stylesheet" href="css_/blueprint/ie.css" type="text/css" media="screen, projection"><![endif]-->
<style>
u{
	
	color:#FF9930;
	}
</style>
<script>
    
    function show(x){
        oque = document.getElementById(x);
        if(oque.style.display=='block'){
            oque.style.display = "none";
        }else{
            oque.style.display = "block";
        }
    }
    $(function() {
       $("#seleend").click(function(){
           $("#action").attr("value","sele");
           $("#escolhe_endereco").submit();
       });
       $("#novoend").click(function(){
           $("#action").attr("value","novo");
           $("#escolhe_endereco").submit();
       });
       $("#b_novousu").click(function(){
           $("#action2").attr("value","novo_usuario");
           
           ok=1;
           frase="Por favor, preencha:\n";
           if($("#nome").attr("value")==""){
               frase+="-Nome\n";
               ok=0;
           }
           if($("#cpf").attr("value")==""){
               frase+="-CPF\n";
               ok=0;
           }
           if($("#ema").attr("value")==""){
               frase+="-E-mail\n";
               ok=0;
           }
           if($("#sen").attr("value")==""){
               frase+="-Senha\n";
               ok=0;
           }
           if($("#celular").attr("value")==""){
               frase+="-Celular\n";
               ok=0;
           }
           if($("#numero").attr("value")==""){
               frase+="-Número\n";
               ok=0;
           }
           if(ok==1){
               if($("#ema").attr("value")!=$("#emac").attr("value")){
                   frase = "E-mail Confirmação diferente de E-mail.";
                   ok=0;
               }
               
               if($("#sen").attr("value")!=$("#senc").attr("value")){
                   frase = "Senha Confirmação diferente de Senha.";
                   ok=0;
               }
           }
           
           if(ok==1){
              $("#novousu").submit();
           }else{
               alert(frase);
           } 
       });
       $("#botao_esqueci_senha").click(function(){
            email = $("#email").attr("value");
            $("#email_nova_senha").attr("value",email);
            $("#esqueci_senha").show();
        });
        $("#botao_enviar_nova_senha").click(function(){
            email = $("#email_nova_senha").attr("value");
            if(email!=""){
                $("#form_esqueci_senha").submit();
            }else{
                alert("Por favor, informe seu e-mail de login.");
            }    
        });
    });
</script>    

<div class="container">
	<div id="background_container">
    	<?php include "menu2.php" ?>
        <div id="central" class="span-24">
			<div class="span-6">
            	<div id="barra_esquerda">
                	<div id="info_restaurante">
                    	<div id="categoria_rest">
                        </div>
                        <div id="nome_rest">
                        </div>
                        <div id="avatar_rest">
                        </div>
                        <div id="formas_pagamento">
                        </div>
                        <div id="tempo_entrega">
                        </div>
                    </div>
                    
                    
                </div>
            </div>
            <div class="span-18 last">
            	
                    <div class="prepend-top" id="status">
                        <div id="numero_rest" style="color:#FFF" ><span style="margin-left:8px;"> </span>
                        </div> 
                        <div id="status_pedido">
                        	<img src="background/passo2.png" width="541" height="43" alt="passo1">
                        </div>
                    </div>
                    
                    <div id="titulo_box_destaque" >
                    Cadastro de dados pessoais
                    </div>
                    <div class="titulo_box_pedido" style="margin-top:4px;">Sou cadastrado
					</div>
                    <div class="box_pedido">
                        <form action="../menuduchef/php/controller/login2" method="post">
                        <input type="hidden" name="onde_estava" value="cadastro">
                        <label for="email">Login:</label><input type="text" id="email" name="email" maxlength="50" class="campo">
                        <label for="senha">Senha:</label><input type="password" name="senha" maxlength="50" class="campo">
                        <div style="width:40px; height:28px; border:1px Solid #333; background:#F04047; font-size:16px; cursor:pointer; position:absolute; top:96px; left:240px; ">
                        	<input type="submit" name="Enviar" value="OK" id="botao_enviar">
                        </div>
                        <br/>
                        <u style="cursor:pointer" id="botao_esqueci_senha">Esqueci minha senha</u>
                        </form>
                        <? if($_SESSION['consumidor_id']){
                            
                            $usuario_obj = unserialize($_SESSION['usuario_obj']);
                            $endoriginal = unserialize($_SESSION['endereco']);
                            ?>
                        <form id="escolhe_endereco" action="php/controller/salva_pedido_aguardando" method="post">
                            <input id="action" name="action" type="hidden">    
                            <div class="pop_addend" id="popup_endereco" style="position:absolute; background:#EEE; z-index:30; top:-30px;">
                                <div style="width:354px;; height:66px; position:relative; float:left; margin:8px 0; background:#F4F4F4;">
                                    <div class="titulo_addend">Cadastro de endereço</div>
                                    <img src="background/logo_noback.png" height="68" width="71" style="position:absolute; top:-24px; left:-10px;"> 
                                </div>
                                    <div id="sele_end" style="display:block;">
                                <?
                                    $tem_ends = 0;
                                    if($usuario_obj->enderecos){ 
                                        
                                        ?>
                                        <table style="background:#F4F4F4; font-size:12px; width:354px; color:#999; float:left; position:relative;">
                                        <? foreach($usuario_obj->enderecos as $end){ 
                                            
                                            if($end->cep==$endoriginal->cep){
                                                $tem_ends++;
                                            ?>
                                                
                                                <tr><td style="text-align:right"><input type="radio" name="endereco_escolhido" value="<?= $end->id ?>"></td><td style="padding-left:22px; "><?= $end->logradouro ?>, <?= $end->numero ?> - <?= $end->bairro->nome ?></td></tr>
                                            <?
                                            }
                                        }
                                        ?>
                                        </table>    
                                        
                                       <?     
                                    }
                                    if($tem_ends==0){
                                        echo "N&atilde;o h&aacute; endere&ccedil;os cadastrados para o CEP fornecido.";
                                    }else{ ?>
                                        <div style="width:354px; height:30px; position:relative; float:left; margin:8px 0;"><input type="button" id="button_cne" onclick="show('cad_novo_end'); show('button_cne'); show('sele_end')" value="Cadastrar novo" style="width:120px; height:24px; font-family:Arial; font-weight:bold; font-size:13px; color:#FFF; background:#CCC; float:right; margin-right:32px" /><input id="seleend" type="button" value="Selecionar endere&ccedil;o" style="width:170px; height:24px; font-family:Arial; font-weight:bold; font-size:13px; color:#FFF; background:#CCC; float:right;" /></div>
                                        
                                 <?       
                                    }
                                ?>
                                        <br/><br/>
                                </div>        
                                
                                <div id="cad_novo_end" style="display:none;">
                                    
                                    <div id="form_endereco">
                                        <div>
                                            <div id="mensagens_endereco"></div>
                                            
                                            <input type="hidden" id="endereco_id" name="endereco_id" value="" />
                                            <input type="hidden" name="hash" value="" />
                                            <table style="background:#F4F4F4; font-size:12px; width:354px; color:#999; float:left; position:relative;">
                                                <tr>
                                                  <td style="text-align:right">Cidade:</td>
                                                  <td style="padding-left:22px; "><input class="inp_res" readonly="true" style="width:200px; background:#EEE;" value="<?= $endoriginal->bairro->cidade->nome ?>"/></td>
                                                </tr>
                                                <tr>
                                                  <td style="text-align:right">Bairro:</td>
                                                  <td style="padding-left:22px; "><input class="inp_res" readonly="true" style="width:200px; background:#EEE;" value="<?= $endoriginal->bairro->nome ?>"/></td>
                                                </tr>
                                                <tr>
                                                  <td style="text-align:right">Logradouro:</td>
                                                  <td style="padding-left:22px; "><input class="inp_res" readonly="true" style="width:200px; background:#EEE;" value="<?= $endoriginal->logradouro ?>"/></td>
                                                </tr>    
                                                <tr>
                                                  <td style="text-align:right">N&uacute;mero:</td>
                                                  <td style="padding-left:22px; "><input class="inp_res" id="numero_endereco" name="numero" style="width:200px;"/></td>
                                                </tr>
                                                <tr>
                                                  <td style="text-align:right">Complemento:</td>
                                                  <td style="padding-left:22px; "><input class="inp_res" name="complemento" style="width:200px;"/></td>
                                                </tr>
                                                <tr>
                                                  <td style="text-align:right">Refer&ecirc;ncia:</td>
                                                  <td style="padding-left:22px; "><input class="inp_res" name="referencia" style="width:200px;"/></td>
                                                </tr>
                                                <tr>
                                                  <td style="text-align:right">CEP:</td>
                                                  <td style="padding-left:22px; "><input class="inp_res" readonly="true" style="width:200px; background:#EEE;" value="<?= $endoriginal->cep ?>"/></td>
                                                </tr>
                                            </table>
                                            <div style="width:354px; height:30px; position:relative; float:left; margin:8px 0;"><input type="button"  onclick="show('cad_novo_end'); show('sele_end')" value="Voltar" style="width:100px; height:24px; font-family:Arial; font-weight:bold; font-size:13px; color:#FFF; background:#CCC; float:right; margin-right:32px" /><input type="button" id="novoend" value="Usar novo endere&ccedil;o " style="width:190px; height:24px; font-family:Arial; font-weight:bold; font-size:13px; color:#FFF; background:#CCC; float:right;" /></div>
                                        </div>

                                    </div>
                                
                                </div>
                                
                            </div>
                            </form>    
                        <? } ?>
                    </div>
                    <form id="novousu" action="php/controller/salva_pedido_aguardando" method="post">
                        <input type="hidden" name="action2" id="action2" value="novo_usuario">
                    <div class="titulo_box_pedido">Não sou cadastrado <b style="color:#E51B21;">.</b> Dados pessoais
					</div>
                    <div class="box_pedido" style="height:357px">
                        
                        <div style="width:330px; float:left;">
                            
                                
                            <label>Nome*</label><input type="text" id="nome" name="nome" value="<?= $aguardando['nome'] ?>" maxlength="100" class="campo"> 
                            <label>CPF*</label><input type="text" maxlength="14" onkeyup="mask_cpf(this)" id="cpf" name="cpf" value="<?= $aguardando['cpf'] ?>" maxlength="100" class="campo"> 
                            <label>Sexo</label>			
                                                        <select name="sexo" class="campo">
                                                            <option value="">Selecione</option>    
                                                            <option <? if($aguardando['sexo']=="Masculino"){ echo "selected"; } ?> value="Masculino">Masculino</option>  
                                                            <option <? if($aguardando['sexo']=="Feminino"){ echo "selected"; } ?> value="Feminino">Feminino</option> 
                                                        </select>
                            <label>Nascimento</label>
                            
                            <input style="width:26px;" type="text" id="diaNascimento" placeholder="dd" name="diaNascimento" value="<?= $aguardando['dia'] ?>" class="text campo" value="dd" maxlength="2"  /> 
        
                            <input style="width:28px;" type="text" id="mesNascimento"  placeholder="mm" name="mesNascimento" value="<?= $aguardando['mes'] ?>" class="text campo" value="mm" value="<?= $aguardando['mesn'] ?>" maxlength="2"  />
        
                            <input style="width:40px;" type="text" id="anoNascimento" placeholder="aaaa" name="anoNascimento" value="<?= $aguardando['ano'] ?>" class="text campo" value="aaaa" maxlength="4"  />
               
                            <label>Tel. Fixo</label><input type="text" name="telefone" value="<?= $aguardando['telefone'] ?>" maxlength="12" class="campo"><br/>
                            <? //<u>Adicionar outro número de contato</u>     ?>
                            
                        </div>
                        <div style="width:330px; margin-left:14px; float:left;">
                        	<label for="login">E-mail*</label><input type="text" id="ema" name="login" value="<?= $aguardando['login'] ?>" maxlength="100" class="campo">
                            <label for="login">E-mail Confirmação*</label><input type="text" id="emac" name="loginconf" value="<?= $aguardando['loginconf'] ?>" maxlength="100" class="campo">
                        	<label for="senha">Senha* </label><input type="password" id="sen" name="senha" maxlength="100" class="campo">
                            <label for="senha">Senha Confirmação*</label><input type="password" id="senc" name="senhaconf" maxlength="100" class="campo">
                            <label>Celular*</label><input type="text" id="celular" name="celular" value="<?= $aguardando['celular'] ?>" maxlength="12" class="campo"><br/>
                            
                            <label>Como conheceu o Delivery du Chef?</label>			
                                                        <select name="como_conheceu" class="campo">
                                                            <option value="">Selecione</option>    
                                                            <option <? if($aguardando['como_conheceu']=="Amigos"){ echo "selected"; } ?> value="Amigos">Amigos</option>  
                                                            <option <? if($aguardando['como_conheceu']=="E-mail marketing"){ echo "selected"; } ?> value="E-mail marketing">E-mail marketing</option>
                                                            <option <? if($aguardando['como_conheceu']=="Facebook"){ echo "selected"; } ?> value="Facebook">Facebook</option>
                                                            <option <? if($aguardando['como_conheceu']=="Twitter"){ echo "selected"; } ?> value="Twitter">Twitter</option>
                                                            <option <? if($aguardando['como_conheceu']=="Midia impressa"){ echo "selected"; } ?> value="Midia impressa">M&iacute;dia impressa</option>
                                                            <option <? if($aguardando['como_conheceu']=="Sites de busca"){ echo "selected"; } ?> value="Sites de busca">Sites de busca</option>
                                                            <option <? if($aguardando['como_conheceu']=="Anuncios em sites"){ echo "selected"; } ?> value="Anuncios em sites">A&uacute;ncios em sites</option>
                                                        </select>
                        </div>
                           
                    </div> 
                    <div class="titulo_box_pedido">Endereço de entrega   	
					</div>
                    <div class="box_pedido" style="height:290px">
                    	
                   		<div style="width:330px; float:left;">
                            <label>CEP</label><input type="text" style="background:#EEE" readonly="true" value="<?= $endereco->cep ?>" name="cep" maxlength="100" class="campo" > 
                            <label>Endereço</label><input type="text" style="background:#EEE" readonly="true" value="<?= $endereco->logradouro ?>" name="endereco" maxlength="100" class="campo">
                            <label>Número*</label><input type="text" id="numero" name="numero" value="<?= $aguardando['numero'] ?>" maxlength="100" class="campo"> 
                            <label>Bairro</label><input type="text" value="<?= $endereco->bairro->nome ?>" style="background:#EEE" readonly="true" name="bairro" maxlength="100" class="campo">                    	
                    	</div>
                        <div style="width:330px; margin-left:14px; float:left;">
                        	<label>Cidade</label><input type="text" style="background:#EEE" readonly="true" value="<?= $endereco->bairro->cidade->nome ?>" name="cidade" maxlength="100" class="campo"> 
                            <label>Estado</label><input type="text" style="background:#EEE" readonly="true" value="<?= $endereco->bairro->cidade->uf->nome ?>" name="estado" maxlength="100" class="campo">
                            <label>Complemento</label><input type="text" name="complemento" value="<?= $aguardando['complemento'] ?>" maxlength="100" class="campo"> 
                            <label>Ponto de referência</label><input type="text" name="pr" value="<?= $aguardando['referencia'] ?>" maxlength="100" class="campo">    
                        </div>
                        <img src="background/cadastrar.png" id="b_novousu" width="118" height="32" style="margin-top:8px; cursor:pointer;">
                    
                    
                    </div>
                    </form>
                              
          </div>
		</div>
	</div>
        <div id="esqueci_senha" class="pop-cat" style="display:none; position:absolute; padding:10px; z-index:50; left:35%; top:30%;">
            <form id="form_esqueci_senha" action="php/controller/gera_nova_senha" method="post">
                <input type="hidden" name="volta" value="cadastro">
                <div style="width:364px; height:80px; position:relative; float:left; margin:8px 0; background:#F4F4F4;">
                <div class="titulo_pop">Esqueci minha senha</div>
                <img src="background/logo_noback.png" height="68" width="71" style="position:absolute; top:-24px; left:-10px;"> <img src="background/close.png" height="28" width="28" onclick="show('esqueci_senha')" style="position:absolute; cursor:pointer; top:-16px; left:346px;"> 
                </div>
                  <div>  
                        
                        <table style="background:#F4F4F4; font-size:12px; width:364px; color:#999; float:left; position:relative;">
                          <tr>
                            
                            <td colspan="2" style="padding-left:22px; color:#F00;">Informe seu e-mail de login. Ao clicar em "confirmar", enviaremos a este e-mail uma nova senha.</td>
                          </tr>
                          <tr>
                            
                            <td colspan="2" style="padding-left:22px; "></td>
                          </tr>
                          <tr>
                            <td style="text-align:right">E-mail: </td>
                            <td style="padding-left:22px; "><input id="email_nova_senha" name="email_nova_senha" class="inp_res" style="width:220px;" value=""></td>
                          </tr>

                        </table>
                  </div>
                <div style="width:364px; height:30px; position:relative; float:left; margin:8px 0;"> <img id="botao_enviar_nova_senha" style="cursor:pointer" src="background/salvar.png" width="110" height="30"> </div>
              </form>
            </div>
</div>
   <?
    $frase = "";
        if($_GET['e']==1){
            $frase = "E-mail j\u00e1 cadastrado, escolha outro.";
        }else if($_GET['e']==2){
            $frase = "O login fornecido n\u00e3o pertence a um usu\u00e1rio comum.";
        }else if($_GET['e']==3){
            $frase = "Usu\u00e1rio n\u00e3o encontrado.";
        }else if($_GET['e']==4){
            $frase = "E-mail e senha s\u00e3o campos obrigat\u00f3rios.";
        }else if($_GET['e']==13){
            $frase = "O e-mail fornecido n\u00e3o consta no sistema.";
        }else if($_GET['e']==14){
            $frase = "Em instantes chegar\u00e1 em seu e-mail uma nova senha.";
        }
            
        if($frase!=""){    
            ?>
                <script>alert('<?= $frase ?>');</script>
                <?
        }    
    ?>
<? include("include/footer.php"); ?>