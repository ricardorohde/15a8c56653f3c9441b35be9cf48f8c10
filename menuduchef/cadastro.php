<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
"http://www.w3.org/TR/html4/strict.dtd"
>
<html lang="pt">
<head>
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
</head>
<body>
<div class="container">
	<div id="background_container">
    	<?php include "menu2.php" ?>
        <div id="central" class="span-24">
			<div class="span-6">
            	<div id="barra_esquerda">
                	<div id="info_restaurante">
                    	<div id="categoria_rest">Pizzaria
                        </div>
                        <div id="nome_rest">Reis Magos
                        </div>
                        <div id="avatar_rest">
                        </div>
                        <div id="formas_pagamento">Formas de pagamento
                        </div>
                        <div id="tempo_entrega">Tempo de entrega:<img src="background/relogio.gif" width="20" height="19" style="position:relative; top:6px; left:4px;">&nbsp;&nbsp;&nbsp;300min
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
                    <div id="box_pedido">
                    <form>
                        <label for="login">Login:</label><input type="text" name="login" maxlength="100" class="campo">
                        <label for="senha">Senha:</label><input type="password" name="senha" maxlength="100" class="campo">
                        <div style="width:40px; height:28px; border:1px Solid #333; background:#F04047; font-size:16px; cursor:pointer; position:absolute; top:96px; left:240px; ">
                        	<input type="submit" name="Enviar" value="OK" id="botao_enviar">
                        </div>
                        <br/>
                        <u>Esqueci minha senha</u>
                      
                    </form>    
                    </div>
                    <div class="titulo_box_pedido">Não sou cadastrado <b style="color:#E51B21">.</b> Dados pessoais
					</div>
                    <div id="box_pedido" style="height:342px">
                        <form>
                        <div style="width:330px; float:left;">
                            
                                
                            <label>Nome*</label><input type="text" name="nome" maxlength="100" class="campo"> 
                            <label>CPF*</label><input type="text" name="cpf" maxlength="100" class="campo"> 
                            <label>Sexo</label>			
                                                        <select name="Sexo" class="campo"> 
                                                        <option value="1">Cabra homi 
                                                        <option value="2">Mulherzinha
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
                        </form>   
                    </div> 
                    <div class="titulo_box_pedido">Endereço de entrega   	
					</div>
                    <div id="box_pedido" style="height:290px">
                    	<form> 
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
                        <img src="background/cadastrar.png" width="118" height="32" style="margin-top:8px; cursor:pointer;">
                    	</form>
                    
                    </div>
                              
          </div>
		</div>
	</div>
</div>
</body>
</html>