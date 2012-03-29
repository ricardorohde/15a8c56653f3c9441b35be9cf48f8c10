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
.nome_log{font-family:Arial; font-size:10px; color:#FF9930; margin-top:12px; float:left; width:120px; height:20px; padding:0 0;}
.pass_log{font-family:Arial; font-size:10px; color:#FF9930; margin: 1px 0px; float:left; width:120px; height:20px; padding:0 0;}
.campo_log{text-indent:-999px; width:29px; height:18px; background:url(background/ok_inicial.gif); border:1px Solid #EBEBEB;}
</style>
<div class="div-24-last">
    <div id="menu" class="text">
	<!-- A div abaixo destinada para login! -->
        <div class="tool" style="float:left; color: #0C3; padding-top:15px;"><a href="" style="color:#F90">logar-se</a>
        <div class="log">
          <form action="php/controller/login" method="post">
            <input  placeholder="Nome" type="text" name="email" maxlength="40"/>
            <input  placeholder="Senha" type="password" name="senha" maxlength="40"/>
            <div style="position:relative; float:left;">
              <input class="campo_log" type="submit" value="OK"/>
            </div>
             <a href="#"><div style="font-size:9px; font-family:Arial, Helvetica, sans-serif; font-weight:normal; color:#F94;">&nbsp;Esqueci minha senha</div></a>
          </form>
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
