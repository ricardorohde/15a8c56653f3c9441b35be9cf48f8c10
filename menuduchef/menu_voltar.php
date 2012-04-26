<script>
    $(function() {    
        $("#menu_voltar").click(function(){
                 location.href="restaurantes";
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
</script>
<div class="div-24-last">
    <div id="menu" class="text">
	<!-- A div abaixo destinada para login! -->
        <div id="login"><div id="menu_voltar" style="padding-top:15px; color:#F90; cursor:pointer;">Voltar</div> 
        </div>
        <!-- Termina aqui! -->
        <div id="itens_menu">
	    <div style="padding-top:15px;">
		<div style="width:102px; padding-left:25px; float:left;"><a href="#">quem somos</a></div><div style="width:99px; float:left"><a href="#">como pedir</a></div><div style="width:187px; float:left"><a href="#">tenho um restaurante</a></div><div style="width:97px; float:left"> <a href="#">fale conosco</a></div>
	    </div>
        </div>
        <a href="index"><img src="background/logo.png" width="210px" height="157px" style="cursor:pointer; float:left; position:absolute; z-index:5; top:-2px;" /></a>
    </div>
</div>
<div id="atendimento_online" style="cursor:pointer; left:0px; font-size:10px; border:0; color:#FFE500; width:37px; height:146px; top:250px; position:fixed;">
    <img src="background/atendimento online.png">
</div>