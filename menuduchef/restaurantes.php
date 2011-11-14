<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
"http://www.w3.org/TR/html4/strict.dtd"
>
<html lang="pt">
<head>
<title>Delivery du Chef</title>
   <link rel="stylesheet" href="css/blueprint/screen.css" type="text/css" media="screen, projection">
   <link rel="stylesheet" href="css/blueprint/print.css" type="text/css" media="print">  
   <link rel="stylesheet" href="css/estilo.css" type="text/css" media="screen"> 
   <!--[if lt IE 8]><link rel="stylesheet" href="css/blueprint/ie.css" type="text/css" media="screen, projection"><![endif]-->

</head>
<body>
<div class="container">
	<div id="background_container">
    	<?php include "menu.php" ?>
        <div id="central" class="span-24">
			<div class="span-6">
            	<div id="barra_esquerda">
                	<div id="seleciona_endereco">
               	    	<img src="background/titulo_endereco.gif" width="114" height="30" alt="Endereço" style="margin-left:12px">
                        <div style="width:198px; height:25px; margin-left:7px;">
                        </div>
                    </div>
                    <div id="busca">
               	    	<img src="background/titulo_busca.gif" width="71" height="26" alt="Busca" style="margin-left:12px">
                        <div style="width:198px; height:25px;  margin-left:7px;">
                   	    	<img src="background/botao_ok.gif" width="36" height="22" style="float:right;">
                        </div>
                    </div>
                    <div id="filtro">
               	    	<img src="background/titulo_filtro.gif" width="74" height="26" alt="Filtro" style="margin-left:12px">
                    </div>
                </div>
            </div>
            <div class="span-18 last">
            	<div class="prepend-top" id="status">
                	<div id="numero_rest" style="color:#FFF" ><span style="margin-left:8px;"> </span>
                 	</div> 
                    <div id="status_pedido">
               	    <img src="background/passo.gif" width="540" height="44" alt="passo1">
                    </div>
                </div>
            	<div class="radios prepend-top" id="caixa_sup">
                	<div id="rest_titulo">
                    	<img src="background/titulo_restaurantes.gif" width="168" height="26" alt="Restaurantes" style="margin-top:6px;">
                    </div>
                    <div id="contagem_pag">
                    </div>
            </div>
                <?php include "box_restaurante.php" ?>
                <?php include "box_restaurante.php" ?>
                <?php include "box_restaurante.php" ?>
                <?php include "box_restaurante.php" ?>
                <?php include "box_restaurante.php" ?>
                <?php include "box_restaurante.php" ?>
                <div class="radios prepend-top" id="caixa_sup">
                    <div id="contagem_pag">
                    </div>
                </div>
                <div id="rodape" class="prepend-top">
			    	<img src="background/rodape.jpg" width="760" height="69" style="margin-left:-59px;">
                </div>
            </div>
		</div>
	</div>
</div>
</body>
</html>