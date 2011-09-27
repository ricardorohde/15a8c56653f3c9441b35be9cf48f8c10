<?php

if(!$_SESSION){

session_name('rest');
session_start();

}

ini_set('display_errors', 1); // mostra os erros

include 'functions.php';
ob_start();



if(isset($_POST)){

	if(detecta_perigo($_POST['ir'])==0){
	
		if($_POST['ir']=='Logar'){
		
			connect();
			
			$p1 = detecta_perigo($_POST['login']);
			$p2 = detecta_perigo($_POST['senha']);
			$p3 = detecta_perigo($_POST['tipo']);			
			
			if(($p1==0)&&($p2==0)&&($p3==0)){
				$login = $_POST['login'];
				$senha = md5($_POST['senha']);
				$tipo = $_POST['tipo'];
				
				$sql = "";
				$pagina = "";
				switch($tipo){
					case "consumidor": $sql="SELECT * FROM consumidor WHERE login = '$login' AND senha = '$senha'"; $pagina="location: painel_consumidor.php"; break;
					case "restaurante": $sql="SELECT * FROM restaurante WHERE login = '$login' AND senha = '$senha'"; $pagina="location: painel_restaurante.php"; break;
					case "administrador": $sql="SELECT * FROM administrador WHERE login = '$login' AND senha = '$senha'"; $pagina="location: painel_administrador.php"; break;
				}
				
				if($sql!=""){
					$sql=mysql_query($sql);
					if($sql=mysql_fetch_array($sql)){
					
						$_SESSION['idusu'] = $sql['id'];
						$_SESSION['senha'] = $senha;
						$_SESSION['tipo'] = $tipo;
						$_SESSION['validacao'] = 1;
						mysql_close();
						header($pagina);
						
					}
					else{
						echo "<script>alert('Login e/ou senha incorretos!');</script>";
					}
				}
			}
			else{
				echo "<script>alert('Dados inválidos');</script>";
			}
			
			mysql_close();
			
		}
		else if($_POST['ir']=='Selecionar esta cidade'){
			connect();
			
			$p1 = detecta_perigo($_POST['cidade']);
			
			if($p1==0){
				$cidade = $_POST['cidade'];
				
				header("location: escolha_bairro.php?cid=".$cidade);
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
$count = 0;
$sql="SELECT * FROM cidade ORDER BY nome";
$sql=mysql_query($sql);
while($c=mysql_fetch_array($sql)){
	$cidade[$count]['nome']=$c['nome'];
	$cidade[$count]['id']=$c['id'];
	
	$cidades .= "<option value='".$c['id']."'>".$c['nome']."</option>";
	
	$count++; 
}

mysql_close();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<link rel="stylesheet" type="text/css" href="css/estilo.css">
<script src="js/jquery.js" language="javascript" type="text/javascript"></script>
</head>

<body>

<div id="background">
	
	<div id="centralize">
    
    	<div id="superior">
        	<?php //include 'barra_superior.php'; ?>
        </div>
     
        <div id="central">
        	
           <div id="escolha_cidade" style="background:#CC0000; color:#FFFF00; padding:20px;">
            	ESCOLHA A CIDADE:<br/><br/>
            	<form action="" method="post">
                	<select id="cidade" name="cidade"><?php echo $cidades; ?></select>
                    <input type="submit" name="ir" value="Selecionar esta cidade" />
                </form>
            </div>
            <br />
            
            <div id="login" style="background:#CC0000; color:#FFFF00; padding:20px;">
            	LOGIN:<br/><br/>
            	<form action="" method="post">
                	<input type="text" id="login" name="login" /><br/>
                    <input type="password" id="senha" name="senha" /><br/>
                    <input type="radio" id="tipo" name="tipo" value="consumidor" />Consumidor&nbsp;&nbsp;&nbsp;<input type="radio" id="tipo" name="tipo" value="restaurante" />Restaurante&nbsp;&nbsp;&nbsp;<input type="radio" id="tipo" name="tipo" value="administrador" />Administrador&nbsp;&nbsp;&nbsp;<br/><br/>
                    <input type="submit" name="ir" value="Logar" />
                </form> 
            </div>
            <br />
            <!--<a href="cadastro.php">Cadastre-se</a><br/>-->
            
          
        </div>
            

	</div>
</div>

</body>
</html>