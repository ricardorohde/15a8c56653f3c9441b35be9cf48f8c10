<?
$page = HttpUtil::getCurrentPage();

$exibeMenu = in_array($page, array('404', 'painel_pedidos'));

?>
<script type="text/javascript">
    function apaga(x){
	conf = $("#"+x).attr('alterado');
	if(conf=='0'){
	    document.getElementById(x).value = "";
	    $("#"+x).attr('alterado','1');

	}
    }
    $(function() {
        $('#atendimento_online').click(function(){
	
                        var width = 400;
                        var height = 540;
                        var left = (screen.width - width) / 2;
                        var top = ((screen.height - height) / 2) - 30;

                        var w = window.open('atendimento/cliente/index.php', 'at',  'height=' +height+ ', width=' +width+ ',status=no, toolbar=no, resizable=no, scrollbars=no, minimizable=no, left=' +left+ ', top=' +top);
                        //var w = window.open('http://settings.messenger.live.com/Conversation/IMMe.aspx?invitee=13fdebbf7edf5f5c@apps.messenger.live.com&mkt=en-US', 'at',  'height=' +height+ ', width=' +width+ ',status=no, toolbar=no, resizable=no, scrollbars=no, minimizable=no, left=' +left+ ', top=' +top);

        });
    });     
</script>
<style>
label{font-size:10px;}
.nome_log{font-family:Arial; font-size:10px; color:#FF9930; margin-top:12px; float:left; width:120px; height:20px; padding:0 0;}
.pass_log{font-family:Arial; font-size:10px; color:#FF9930; margin: 1px 0px; float:left; width:120px; height:20px; padding:0 0;}
a{ margin:0; padding:0;} 
</style>
<div class="div-24-last">
    <div id="menu" class="text">
	<!-- A div abaixo destinada para login! -->
        <div id="login">
            <div class="tool" style="float:left; color: #0C3; padding-top:15px;"><a href="" style="color:#F90">logar-se</a>
            <div class="log">
              <form action="php/controller/login" method="post">
                <div style="width:155px; height:68px; float:left; position:relative;">
                	<input  placeholder="E-mail" type="text" name="email" maxlength="40"/>
                	<input  placeholder="Senha" type="password" name="senha" maxlength="40"/>
                </div>
                <div style="width:36px; height:34px; float:left; position:relative;">
                <input src="background/botao_ok.jpg" type="image" width="36" height="24" style="margin-top:10px; padding:0;" />
                </div>
                <div style="width:119px; height:28px; float:left; position:relative; font-family:Arial, Helvetica, sans-serif; font-weight:normal; ">
                	<div id="botao_esqueci_senha" style="width:96px; cursor:pointer; color:#F94; font-size:9px; height:14px; float:left;  position:relative; margin:0; padding-left:23px;">
                    	   Esqueci minha senha
                    </div>
                    <div style="width:61px;  height:14px;  float:left; position:relative; color:#F94; margin-top:7px; padding-left:58px; font-size:9px;">
                    	  <a href="cadastro_usuario" style=" color:#F94; font-size:9px;">Cadastrar-se </a>
                    </div>
                </div>
                 
                
                 
              </form>
            </div>
        </div>    
      </div>
                 
        <!-- Termina aqui! -->
        <div id="itens_menu">
	    <div style="padding-top:15px;">
		<div style="width:102px; padding-left:25px; float:left;"><a href="#">quem somos</a></div><div style="width:99px; float:left"><a href="#">como pedir</a></div><div style="width:187px; float:left"><a href="#">tenho um restaurante</a></div><div style="width:97px; float:left"> <a href="#">fale conosco</a></div>
	    </div>
        </div>
        <img src="background/logo.png" width="210px" height="157px" style="float:left; position:absolute; z-index:5; left:-32px; top:-2px;" />
    </div>
</div>
<div id="atendimento_online" style="cursor:pointer; left:0px; font-size:10px; border:0; color:#FFE500; width:37px; height:146px; top:250px; position:fixed;">
    <img src="background/atendimento online.png">
</div>