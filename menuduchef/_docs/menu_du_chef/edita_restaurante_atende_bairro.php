<?php
if(!$_SESSION){

session_name('rest');
session_start();

}

if($_SESSION['validacao']==1){

include 'functions.php';
ob_start();

$p1 = detecta_perigo($_SESSION['idusu']);
$p2 = detecta_perigo($_SESSION['senha']);
$p3 = detecta_perigo($_SESSION['tipo']);
$p4 = detecta_perigo($_GET['res']);

$prossegue = 0;
if(($p1==0)&&($p2==0)&&($p3==0)&&($p4==0)){
	$idusu = $_SESSION['idusu'];
	$senha = $_SESSION['senha'];
	$tipo = $_SESSION['tipo'];
	
	switch($tipo){
		case "consumidor": $sql="SELECT * FROM consumidor WHERE id = '$idusu' AND senha = '$senha'"; break;
		case "restaurante": $sql="SELECT * FROM restaurante WHERE id = '$idusu' AND senha = '$senha'"; break;
		case "administrador": $sql="SELECT * FROM administrador WHERE id = '$idusu' AND senha = '$senha'"; break;
	}         
	
	connect();
	$sql=mysql_query($sql);
	if($sql=mysql_fetch_array($sql)){
		
		$prossegue = 1;
		$quem_sou = $sql['nome'];
	}
	else{
		echo "<script>alert('Login e/ou senha incorretos!');</script>";
	}
	mysql_close();
}

if($prossegue){

if(isset($_POST)){
	$p1 = detecta_perigo($_POST['ir']);
	if($p1==0){
		if($_POST['ir']=='Confirmar Bairros'){
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
}

connect();

$idres = $_GET['res'];
$nome = "SELECT nome FROM restaurante WHERE id = '$idres'";
$nome=mysql_query($nome);
$nome=mysql_fetch_array($nome);
$nome=$nome['nome'];

$bairros = "<table>";
$taxa = "<input type='radio' id='tipo_taxa' name='tipo_taxa' value='taxa_unica' selected>Taxa &Uacute;nica<br/><input type='radio' id='tipo_taxa' name='tipo_taxa' value='taxa_diferenciada'>Taxa Diferenciada";
$count = 0;
$sql="SELECT * FROM bairro ORDER BY nome";
$sql=mysql_query($sql);
while($c=mysql_fetch_array($sql)){
	$idbai = $c['id'];

	$bai="SELECT * FROM restaurante_atende_bairro WHERE id_bairro = '$idbai' AND id_restaurante = '$idres'";
	$bai=mysql_query($bai);
	if($bai=mysql_fetch_array($bai)){
		$atende = 'checked';
		$taxa = $bai['preco_entrega'];
	}
	else{
		$atende = '';
		$taxa = 0;
	}

	if($count==0){
		$bairros .= "<tr>";
	}
	
	$bairros .= "<td><input type='checkbox' id='bairro_".$c['id']."' name='bairro_".$c['id']."' ".$atende."></td><td style='width:100px; text-align:left;'>".$c['nome']."</td>";
	$taxa .= "<div id='div_taxa_".$c['id']."' name='div_taxa_".$c['id']."'><input type='text' id='taxa_".$c['id']."' name='taxa_".$c['id']."' value='".(bcdiv($taxa,100,2))."'> ".$c['nome']."</div>";
	
	$count++;
	
	if($count==4){
		$count = 0;
		$bairros .= "</tr>";
	}
}
$bairros .= "</table>";


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

});

</script>

</head>

<body>

<div id='taxa_entrega' style="display:none;"></div>

<div style="background-color:#CC0000; color:#FFFF00; margin:15px; padding:15px;">
<b>QUAIS BAIRROS ESTE RESTAURANTE ATENDE?</b><br/><br/>
<div>Nome: <?php echo $nome; ?></div>
<div><br/><br/>Atende os bairros:<br/><?php echo $bairros; ?></div>
<div><br /><input type="submit" id="ir" name="ir" value="Confirmar Bairros"></div>
</div>
</body>
</html>
<?php 

	}
	else{
		header("location:index.php");
	}

}
else{
	header("location:index.php");
}
?>