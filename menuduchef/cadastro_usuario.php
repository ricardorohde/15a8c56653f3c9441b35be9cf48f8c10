<?
    include("include/header2.php");
    $aguardando = unserialize($_SESSION['aguardando']);
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
<script type="text/javascript" src="js/mask.js"></script>   
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
       
       
       
       $("#vericep").click(function(){
            
            cep = $("#cep").attr("value");
           
            $("#div_cidade").load("php/controller/traz_cidade?cep="+cep);
            $("#div_bairro").load("php/controller/traz_bairro?cep="+cep);
            $("#div_endereco").load("php/controller/traz_endereco?cep="+cep);
            $("#div_estado").load("php/controller/traz_estado?cep="+cep);
            
            $("#verifica_cep").load("php/controller/traz_verifica?cep="+cep);
        });
    });
</script>    

<div class="container">
	<div id="background_container">
    	<?php include "menu2.php" ?>
        <div id="central" class="span-24">
			<div class="span-6">
            	<div id="barra_esquerda">
                	
                    
                    
                </div>
            </div>
            <div class="span-18 last">
            	
                    
                    <div id="titulo_box_destaque" >
                    Cadastro de dados pessoais
                    </div>
                    
                    <form id="novousu" action="php/controller/cadastra_usuario" method="post">
                        <input type="hidden" name="action2" id="action2" value="novo_usuario">
                    <div class="titulo_box_pedido"> Dados pessoais
					</div>
                    <div class="box_pedido" style="height:357px">
                        
                        <div style="width:330px; float:left;">
                            
                                
                            <label>Nome*</label><input type="text" id="nome" name="nome" value="<?= $aguardando['nome'] ?>" maxlength="100" class="campo"> 
                            <label>CPF*</label><input type="text" id="cpf" onkeyup="mask_cpf(this)" name="cpf" value="<?= $aguardando['cpf'] ?>" maxlength="14" class="campo"> 
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
                    	
                            <div id="verifica_cep"></div>
                   		<div style="width:330px; float:left;">
                            <div id="div_cep"><label>CEP*</label><input id="cep" value="<?= $aguardando['cep'] ?>" type="text" name="cep" maxlength="100" class="campo"> <img id="vericep" src="background/maglass.png" style="position:absolute; margin-top:8px; margin-left:3px; cursor:pointer"></div>
                            <div id="div_endereco"><label>Endere&ccedil;o</label><input type="text" style="background:#EEE" value="<?= $aguardando['endereco'] ?>" readonly="true" name="endereco" maxlength="100" class="campo"></div>
                            <div id="div_numero"><label>Numero*</label><input type="text" id="numero" name="numero" maxlength="100" value="<?= $aguardando['numero'] ?>" class="campo"></div> 
                            <div id="div_bairro"><label>Bairro</label><input type="text" style="background:#EEE" readonly="true" value="<?= $aguardando['bairro'] ?>" name="bairro" maxlength="100" class="campo"></div>                    	
                    	</div>
                        <div style="width:330px; margin-left:14px; float:left;">
                            <div id="div_cidade"><label>Cidade</label><input type="text" style="background:#EEE" readonly="true" value="<?= $aguardando['cidade'] ?>" name="cidade" maxlength="100" class="campo"></div> 
                            <div id="div_estado"><label>Estado</label><input type="text" style="background:#EEE" readonly="true"  value="<?= $aguardando['estado'] ?>" name="estado" maxlength="100" class="campo"></div>
                            <div id="div_complemento"><label>Complemento</label><input type="text" name="complemento" value="<?= $aguardando['complemento'] ?>" maxlength="100" class="campo"></div> 
                            <div id="div_referencia"><label>Ponto de referência</label><input type="text" name="pr" maxlength="100"  value="<?= $aguardando['referencia'] ?>" class="campo"></div>    
                        </div>
                        <img src="background/cadastrar.png" id="b_novousu" width="116" height="32" style="margin-top:8px; cursor:pointer;">
                    	
                    
                    </div>
                 
                    </form>
                              
          </div>
		</div>
	</div>
</div>
   <?
        if($_GET['e']==1){
            ?>
                <script>alert("E-mail j\u00e1 cadastrado, escolha outro.");</script>
                <?
        }else if($_GET['e']==2){
            ?>
                <script>alert("O CEP fornecido \u00e9 inv\u00e1lido.");</script>
                <?
        }
    ?>
<? include("include/footer.php"); ?>