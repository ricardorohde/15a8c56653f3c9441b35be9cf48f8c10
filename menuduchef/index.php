<? include('include/header.php'); ?>
<? 
    include "menu.php";
    session_destroy();
?>
<script src="js/jquery-1.6.4.min.js">
</script>
<script>
	$(function(){
		
		$("#buscar").click(function(){
			
                            $("#logcep").submit();
			
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
                
                $('#atendimento_online').click(function(){
	
                        var width = 400;
                        var height = 540;
                        var left = (screen.width - width) / 2;
                        var top = ((screen.height - height) / 2) - 30;

                        var w = window.open('atendimento/cliente/index.php', 'at',  'height=' +height+ ', width=' +width+ ',status=no, toolbar=no, resizable=no, scrollbars=no, minimizable=no, left=' +left+ ', top=' +top);
                        //var w = window.open('http://settings.messenger.live.com/Conversation/IMMe.aspx?invitee=13fdebbf7edf5f5c@apps.messenger.live.com&mkt=en-US', 'at',  'height=' +height+ ', width=' +width+ ',status=no, toolbar=no, resizable=no, scrollbars=no, minimizable=no, left=' +left+ ', top=' +top);

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
<div class="span-24" id="central_principal" >
    <div id="lateral_esquerda">
	<div style="width:132px; height:114px; padding:3px 13px; margin-top:84px; ">
	    <img src="background/faca_pedido.gif" width="132" height="114">
	</div>
     <form id="logcep" action="php/controller/cep" method="post" onsubmit="if(!this.cep.value.trim()) { alert('Digite um CEP v&aacute;lido'); return false; }">
	<div style="width:132px; height:28px; padding:0 6px; margin-top:2px; ">
	   
		<input type="text" class="w90" name="cep" style="height:18px; width:134px; color:#F90; font-size:14px; font-weight:bold;" />
	    
	</div>
	<div class="fonte_cep" style="width:132px; height:18px; padding:0 13px; ">
	    <div style="float:right;">N&atilde;o sei meu CEP</div>
	</div>
	<div class="fonte_lateral" style="width:132px; height:28px; padding:0 13px; position:relative;">
	    <span id="buscar" style="float:right; margin-top:-8px; cursor:pointer;">Buscar</span>
	</div>
    </form>
	<img src="background/fazer_pedido.gif" height="446" width="144" style="padding:0 7px; margin-top:-12px; position:relative;"/>
    </div>
    <div id="lateral_direita" style="background:url(background/central.jpg);">
	<div id="direita_interna">
	    <div id="banner_dinamico">
	    </div>
	    <div id="botoes">
		<div class="botao_principal">
		</div>
		<div class="botao_principal" style="padding:0 21px;">
		</div>
		<div class="botao_principal">
		</div>
	    </div>
	    <img src="background/rodape_principal.gif" width="762" height="69"/>
	</div>   
    </div>
    

        
        
          <div id="esqueci_senha" class="pop-cat" style="display:none; position:absolute; padding:10px; z-index:50; left:35%; top:30%;">
            <form id="form_esqueci_senha" action="php/controller/gera_nova_senha" method="post">
                <input type="hidden" name="volta" value="index">
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
    
<script>
<? if($_GET){ 
    $erro = "";
    switch($_GET["e"]){
        case "1": $erro="Usuário e/ou senha incorretos."; break;
        case "2": $erro="E-mail e Senha são campos obrigatórios."; break;
        case "13": $erro="O e-mail fornecido não consta no sistema."; break;
        case "14": $erro="Em instantes chegará em seu e-mail uma nova senha."; break;
    }
    ?>
        alert('<?= $erro ?>');
    <?    
  } ?>
    
</script>    
<? include('include/footer.php'); ?>