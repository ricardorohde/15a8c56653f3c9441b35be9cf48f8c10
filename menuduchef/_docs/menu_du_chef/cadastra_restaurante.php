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

$prossegue = 0;
if(($p1==0)&&($p2==0)&&($p3==0)){
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
			if($_POST['ir']=='Cadastrar'){
				connect();
				
				$p1 = detecta_perigo($_POST['nome']);
				$p2 = detecta_perigo($_POST['cidade']);
				$p3 = detecta_perigo2($_POST['endereco']);
				
				if(($p1==0)&&($p2==0)&&($p3==0)){
					$nome = $_POST['nome'];
					$cidade = $_POST['cidade'];
					$endereco = $_POST['endereco'];
					$idusu = $_SESSION['idusu'];
					
					$sql="INSERT INTO restaurante (nome, id_cidade, endereco, senha, id_administrador_cadastrou) VALUES ('$nome','$cidade','$endereco','3691308f2a4c2f6983f2880d32e29c84','$idusu')";
					mysql_query($sql);
					
					$idres = mysql_insert_id();
					
					header("location:edita_restaurante_atende_bairro.php?res=".$idres);
				}
				else{
					echo "<script>alert('Dados inválidos');</script>";
				}
				
				mysql_close();
			}
		}
	}
	
	connect();
	
	$cidades = "";
	
	$sql="SELECT * FROM cidade ORDER BY nome";
	$sql=mysql_query($sql);
	while($c=mysql_fetch_array($sql)){
		$cidades .= "<option value='".$c['id']."'>".$c['nome']."</option>";
	}
	
	
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
<form action="" method="post">
<b>CADASTRAR RESTAURANTE</b><br/><br/>
<div>Nome: <input type="text" id="nome" name="nome"></div>
<div>Cidade: <select id="cidade" name="cidade"><?php echo $cidades; ?></select></div>
<div>Endere&ccedil;o: <input type="text" id="endereco" name="endereco"></div>

<div><br /><input type="submit" id="ir" name="ir" value="Cadastrar"></div>
</form>
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