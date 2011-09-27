<?php

include 'functions.php';
ob_start();

$p1 = detecta_perigo($_GET['res']);

if(($p1)||($_GET['res']=='')){

}
else{

$restaurante = $_GET['res'];

if(isset($_POST)){
	if($_POST['ir']=='Logar'){
		connect();
		
		$p1 = detecta_perigo($_POST['login']);
		$p2 = detecta_perigo($_POST['senha']);
		
		if(($p1==0)&&($p2==0)){
			$login = $_POST['login'];
			$senha = md5($_POST['senha']);
			$sql="SELECT * FROM consumidor WHERE login = '$login' AND senha = '$senha'";
			$sql=mysql_query($sql);
			if($sql=mysql_fetch_array($sql)){
				
			}
			else{
				echo "<script>alert('Login e/ou senha incorretos!');</script>";
			}
		}
		else{
			echo "<script>alert('Dados inválidos');</script>";
		}
		
		mysql_close();
	}
}

connect();

$menu = "<table>";
$count = 0;
$sql="SELECT * FROM produto WHERE id_restaurante = '$restaurante' ORDER BY nome";
$sql=mysql_query($sql);
while($c=mysql_fetch_array($sql)){
	
	$menu .= "<tr><th style='width:200px; text-align:left;'>".$c['nome']."</th><th> PRECO R$ ".(bcdiv($c['preco'],100,2))."</th> <th><input class='prod' type='button' value='+' qual='".$c['id']."' nome_produto='".$c['nome']."' preco_produto='".$c['preco']."'></th><th> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Qtd: <input type='text' style='width:20px;' id='qtd_".$c['id']."' class='quantidade_produto' readonly='true' value='1' ><input qual='".$c['id']."' class='mais_produto' type='button' value='+'><input qual='".$c['id']."' class='menos_produto' type='button' value='-'></th><th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input qual='".$c['id']."' class='obs_produto' type='button' value='OBS'></th></tr><tr><th colspan='4'><textarea alterado='0' class='obs_texto' style='width:700px; heigth:70px; display:none;' id='obs_".$c['id']."'  >Escreva aqui o que voc&ecirc; quiser alterar...</textarea></th></tr>";
	
	$count++;
}
$menu .= "</table>";

mysql_close();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<style>
a{ text-decoration:none; color:#FFFF00;}
a:hover{text-decoration:none; color:#FFFF00;} 
</style>
<link rel="stylesheet" type="text/css" href="css/estilo.css">
<script src="js/jquery.js" language="javascript" type="text/javascript"></script>
<script>
$(document).ready(function(){

  $(".cancela").click(function(){
  		alert("P1");
  		//qual = $(this).attr("qual");
		alert("P2");
		//$("#lista-pedidos").remove("#"+qual);
		alert("P3");
  });
  $(".obs_texto").blur(function(){

		conf = $(this).attr("value");

		if(conf==''){
			$(this).attr("value",'Escreva aqui o que você quiser alterar...');
			$(this).attr('alterado','0');
		}
  });
  $(".obs_texto").click(function(){
  		qual = $(this).attr("qual");
		
		conf = $(this).attr('alterado');
		if(conf=='0'){
			$(this).attr('value','');
			$(this).attr('alterado','1');
		}

  });
  $(".obs_produto").click(function(){
  		
  		qual = $(this).attr("qual");
		
		if(document.getElementById("obs_"+qual).style.display=="none"){
			document.getElementById("obs_"+qual).style.display = "block";
		}
		else{
			document.getElementById("obs_"+qual).style.display = "none";
		}

  });
  $(".mais_produto").click(function(){
  
  		qual = $(this).attr("qual");
		qtd = $("#qtd_"+qual).attr("value");
		
		qtd = parseInt(qtd) + 1;
		
		$("#qtd_"+qual).attr("value",qtd);
		
  });
  $(".menos_produto").click(function(){
  
  		qual = $(this).attr("qual");
		qtd = $("#qtd_"+qual).attr("value");
		if(qtd>1){
			qtd = parseInt(qtd) - 1;
		
			$("#qtd_"+qual).attr("value",qtd);
		}
  });
  $(".prod").click(function(){
  		qual = $(this).attr("qual");
		nome = $(this).attr("nome_produto");
		preco = $(this).attr("preco_produto");
		qtd = $("#qtd_"+qual).attr("value");
		obs = $("#obs_"+qual).attr("value");
		
		tem_obs = 1;
		
		if($("#obs_"+qual).attr("alterado")==0){
			obs = '';
			tem_obs = 0;
		}
		
		
		len = $("#lista-pedidos div[tem_obs=0]").length;
		sufixo = len;
		
		achou = 0;
		indice_achado = 0;
		
	

		for(i=0;i<len;i++){
		
			if(tem_obs==0){
				teste = $("#lista-pedidos div[tem_obs=0]")[i].id.split("_");
				
				if(teste[0]=='p'+qual){
				
						achou = 1;
						indice_achado = i;
				}
			}
		}
		
		
		if(achou){
		
			id_pedido = $("#lista-pedidos div[tem_obs=0]")[indice_achado].id;
			q = $("#"+id_pedido+" .qtd").html();
			q = parseInt(q) + parseInt(qtd);
			$("#"+id_pedido+" .qtd").html(q);	
		}
		else{
		
    		$("#lista-pedidos").append("<div id='p"+qual+"_"+sufixo+"' tem_obs='"+tem_obs+"' class='item' style='position:relative;' ><div style='position:relative; margin-left:15px;'> <b>"+nome+"</b> <input type='hidden' class='valor_unitario' value='"+preco+"'><input type='button' qual='p"+qual+"_"+sufixo+"' class='cancela' style='float:right; background:#CC0000; color:#FFFF00; font-weight:bold;' value='x'></div><div class='qtd' style='position:relative; float:left; margin-left:15px;'> "+qtd+" </div><div> x &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;R$&nbsp;"+(parseFloat(preco/100).toFixed(2))+"</div><div style='margin-left:15px;' class='obs'>"+obs+"</div></div><br/>");
		}
		
		document.getElementById("obs_"+qual).value = "Escreva aqui o que você quiser alterar...";
		document.getElementById("obs_"+qual).alterado = 0;
		document.getElementById("obs_"+qual).style.display = "none";
		
		
		len = $("#lista-pedidos .item").length;
		
		subtotal = 0;
		for(i=0;i<len;i++){
		
				id_pedido = $("#lista-pedidos .item")[i].id;
				q = $("#"+id_pedido+" .qtd").html();
				valor = $("#lista-pedidos .valor_unitario")[i].value;

				subtotal += (parseFloat(valor) * parseInt(q));
		}
		
		subtotal = parseFloat(subtotal/100).toFixed(2);
		$("#total").html(subtotal);
		$("#qtd_"+qual).attr("value",1);
		
		//subtotal = 0;
		//for(i=0;i<len;i++){
		//		valor = $("#lista-pedidos .valor_unitario")[i].value;
		//		qtd = $("#lista-pedidos .qtd")[i].html();
		//		alert(qtd);
		//		subtotal += (parseFloat(valor) * parseInt(qtd));
		//}


		
	//	if($("#lista-pedidos .joao").[0]){
	//		$("#lista-pedidos").remove(".joao");
	//	}

  });
});

</script>

</head>

<body>
<div id="pedido" style="position:fixed; right:0; background:#FF6600;">
	<div style="color:#FFFFFF;" value='1000'>SEU PEDIDO</div>
    <div id="lista-pedidos" style="color:#666666; background:#FFFFFF; height:200px; width:300px; overflow-y:auto;"></div>
    <div style="color:#FFF; background:#999999;"><div style="position:relative; float:left;">TOTAL:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div><div style="position:relative; float:left;">R$&nbsp;</div><div style="position:relative; float:left;" id="total">0.00</div></div>
    <br/><div style="color:#000;">cupom promocional</div>
    <div style="color:#000;">FINALIZAR</div>
</div>
<div id="background">
	
	<div id="centralize">
    
    	<div id="superior">
        	<?php //include 'barra_superior.php'; ?>
        </div>
     
        <div id="central">
        	
            <div id="escolha_cidade" style="background:#CC0000; color:#FFFF00; padding:20px;">
            	MENU<br/><br/>
            	<form action="" method="post">
                	<?php echo $menu; ?>
                </form>
            </div>
            <br />
            <?php /*
            <div id="login" style="background:#CC0000; color:#FFFF00; padding:20px;">
            	LOGIN:<br/><br/>
            	<form action="" method="post">
                	<input type="text" id="login" name="login" /><br/>
                    <input type="password" id="senha" name="senha" /><br/><br/>
                    <input type="submit" id="ir" name="ir" value="Logar" />
                </form>
            </div>
            <br />
            <a href="cadastro.php">Cadastre-se</a><br/>
           */ ?>
          
        </div>
            
        <div id="inferior" style="position:relative;">
        <?php
            //include 'barra_inferior.php';
        ?>
        </div>

	</div>
</div>
</body>
</html>
<?php } ?>