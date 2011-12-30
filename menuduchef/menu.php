<script src="js/jquery.js">
</script>
<script>
	function apaga(x){
	conf = $("#"+x).attr('alterado');
	if(conf=='0'){
		document.getElementById(x).value = "";
		$("#"+x).attr('alterado','1');

	}
}
</script>
<style>
label{font-size:10px;}
input[type=text]{font:Arial; font-size:10px; color:#FF9930; margin:0 0; width:120px; height:16px; padding:0 0;}
input[type=password]{font:Arial; font-size:10px; color:#FF9930; margin:2px 0; width:120px; height:16px; padding:0 0;}
.campo_log{text-indent:-999px; width:28px; height:18px; background:url(background/ok_inicial.gif); border:1px Solid #EBEBEB; margin-left:-6px; top:-2px;}
</style>
<div class="div-24-last">
    <div id="menu" class="text">
	<!-- A div abaixo destinada para login! -->
        <div id="login">
	    <form action="../menuduchef/php/controller/login" method="post">
		<label style="font-size:14px;" for="email">E-mail:</label>
		<input  type="text" name="email" maxlength="50" style="float:right; padding:0; margin-right:8px;"/>
		<label style="font-size:14px;" for="senha">Senha:</label>
		<input  type="password" name="senha" maxlength="50" style="float:right; padding:0; margin-right:8px;"/>
		<input class="botao_ok" style="padding:0; margin-left:180px; margin-top:3px; position:absolute; z-index:3;" type="submit" value="OK"/>  
	    </form>
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
