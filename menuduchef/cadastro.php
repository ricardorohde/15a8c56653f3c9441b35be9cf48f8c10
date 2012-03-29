<?
    include("include/header2.php");
 
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
"http://www.w3.org/TR/html4/strict.dtd"
>
<script src="js/jquery-1.6.4.min.js"></script>
<meta http-equiv="content-type" content="text/html" charset="UTF-8" />  
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
           $("#novousu").submit();
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
                        <label for="email">Login:</label><input type="text" name="email" maxlength="50" class="campo">
                        <label for="senha">Senha:</label><input type="password" name="senha" maxlength="50" class="campo">
                        <div style="width:40px; height:28px; border:1px Solid #333; background:#F04047; font-size:16px; cursor:pointer; position:absolute; top:96px; left:240px; ">
                        	<input type="submit" name="Enviar" value="OK" id="botao_enviar">
                        </div>
                        <br/>
                        <u>Esqueci minha senha</u>
                        </form>
                        <? if($_SESSION['consumidor_id']){
                            
                            $usuario_obj = unserialize($_SESSION['usuario_obj']);
                            $endoriginal = unserialize($_SESSION['endereco']);
                            ?>
                        <form id="escolhe_endereco" action="php/controller/salva_pedido_aguardando" method="post">
                            <input id="action" name="action" type="hidden">    
                            <div style="position:absolute; background:#EEE; z-index:30; top:-30px;">
                                <div id="sele_end" style="display:block;">
                                <?
                                    $tem_ends = 0;
                                    if($usuario_obj->enderecos){ 
                                        
                                        ?>
                                        <table>
                                        <? foreach($usuario_obj->enderecos as $end){ 
                                            
                                            if($end->cep==$endoriginal->cep){
                                                $tem_ends++;
                                            ?>
                                                <tr><td><input type="radio" name="endereco_escolhido" value="<?= $end->id ?>"><?= $end->logradouro ?>, <?= $end->numero ?> - <?= $end->bairro->nome ?></td></tr>
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
                                        <input type="button" id="seleend" value="Selecionar endere&ccedil;o">
                                 <?       
                                    }
                                ?>
                                        <br/><br/>
                                </div>        
                                
                                
                                <input type="button" style="display:block;" id="button_cne" onclick="show('cad_novo_end'); show('button_cne'); show('sele_end')" value="Cadastrar novo endere&ccedil;o">
                                <div id="cad_novo_end" style="display:none;">
                                    
                                    <div id="form_endereco">
                                        <div>
                                            <div id="mensagens_endereco"></div>

                                            <input type="hidden" id="endereco_id" name="endereco_id" value="" />
                                            <input type="hidden" name="hash" value="" />

                                            <label for="cidade_endereco" class="normal">Cidade:</label>
                                            <input type="text" readonly="true" style="background:#EEE;" value="<?= $endoriginal->bairro->cidade->nome ?>">

                                            <label for="bairro_endereco" class="normal">Bairro:</label>
                                            <input type="text" readonly="true" style="background:#EEE;" value="<?= $endoriginal->bairro->nome ?>">

                                            <label for="logradouro_endereco" class="normal">Logradouro:</label>
                                            <input type="text" readonly="true" style="background:#EEE;" value="<?= $endoriginal->logradouro ?>">

                                            <label for="numero_endereco" class="normal">N&uacute;mero:</label>
                                            <input class="formfield w15" type="text" id="numero_endereco" name="numero" />

                                            <label for="complemento_endereco" class="normal">Complemento:</label>
                                            <input class="formfield w25" type="text" id="complemento_endereco" name="complemento" />
                                            
                                            <label for="referencia_endereco" class="normal">Refer&ecirc;ncia:</label>
                                            <input class="formfield w25" type="text" id="referencia_endereco" name="referencia" />

                                            <label for="cep_endereco" class="normal">CEP:</label>
                                            <input class="formfield w25" type="text" id="cep_endereco" name="cep" readonly="true" style="background:#EEE;" value="<?= $endoriginal->cep ?>" />
                                        </div>
                                        <div>
                                            <input type="button" id="novoend" value="Usar novo endere&ccedil;o"> <input type="button" onclick="show('cad_novo_end'); show('button_cne'); show('sele_end')" value="Voltar">
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
                    <div class="box_pedido" style="height:342px">
                        
                        <div style="width:330px; float:left;">
                            
                                
                            <label>Nome*</label><input type="text" name="nome" maxlength="100" class="campo"> 
                            <label>CPF*</label><input type="text" name="cpf" maxlength="100" class="campo"> 
                            <label>Sexo</label>			
                                                        <select name="sexo" class="campo">
                                                            <option value="">Selecione</option>    
                                                            <option value="Masculino">Masculino</option>  
                                                            <option value="Feminino">Feminino</option> 
                                                        </select>
                            <label>Nascimento</label>
                            
                            <input style="width:26px;" type="text" id="diaNascimento" name="diaNascimento" class="text campo" value="dd" maxlength="2" onBlur="if (this.value == '') {this.value = 'dd';}" onFocus="if (this.value == 'dd') {this.value = '';}" /> 
        
                            <input style="width:28px;" type="text" id="mesNascimento" name="mesNascimento" class="text campo" value="mm" maxlength="2" onBlur="if (this.value == '') {this.value = 'mm';}" onFocus="if (this.value == 'mm') {this.value = '';}" />
        
                            <input style="width:40px;" type="text" id="anoNascimento" name="anoNascimento" class="text campo" value="aaaa" maxlength="4" onBlur="if (this.value == '') {this.value = 'aaaa';}" onFocus="if (this.value == 'aaaa') {this.value = '';}" />
               
                            <label>Telefone*</label><input type="text" name="telefone" maxlength="12" class="campo"><br/>
                            <u>Adicionar outro número de contato</u>    
                            
                        </div>
                        <div style="width:330px; margin-left:14px; float:left;">
                        	<label for="login">E-mail</label><input type="text" name="login" maxlength="100" class="campo">
                            <label for="login">E-mail Confirmação</label><input type="text" name="loginconf" maxlength="100" class="campo">
                        	<label for="senha">Senha </label><input type="password" name="senha" maxlength="100" class="campo">
                            <label for="senha">Senha Confirmação</label><input type="password" name="senhaconf" maxlength="100" class="campo">
                        </div>
                           
                    </div> 
                    <div class="titulo_box_pedido">Endereço de entrega   	
					</div>
                    <div class="box_pedido" style="height:290px">
                    	
                   		<div style="width:330px; float:left;">
                            <label>CEP*</label><input type="text" name="cep" maxlength="100" class="campo"> 
                            <label>Endereço*</label><input type="text" name="endereco" maxlength="100" class="campo">
                            <label>Numero*</label><input type="text" name="numero" maxlength="100" class="campo"> 
                            <label>Bairro*</label><input type="text" name="bairro" maxlength="100" class="campo">                    	
                    	</div>
                        <div style="width:330px; margin-left:14px; float:left;">
                        	<label>Cidade*</label><input type="text" name="cidade" maxlength="100" class="campo"> 
                            <label>Estado*</label><input type="text" name="estado" maxlength="100" class="campo">
                            <label>Complemento</label><input type="text" name="complemento" maxlength="100" class="campo"> 
                            <label>Ponto de referência</label><input type="text" name="pr" maxlength="100" class="campo">    
                        </div>
                        <img src="background/cadastrar.png" id="b_novousu" width="118" height="32" style="margin-top:8px; cursor:pointer;">
                    
                    
                    </div>
                    </form>
                              
          </div>
		</div>
	</div>
</div>
<? include("include/footer.php"); ?>