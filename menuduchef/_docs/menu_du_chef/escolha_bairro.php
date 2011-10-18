<?php

include 'functions.php';
ob_start();

$p1 = detecta_perigo($_GET['cid']);

if(($p1)||($_GET['cid']=='')){

}
else{

$cidade = $_GET['cid'];

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
	else if($_POST['ir']=='Selecionar este bairro'){
		connect();
		
		$p1 = detecta_perigo($_POST['bairro']);
		
		if($p1==0){
			$bairro = $_POST['bairro'];
			
			header("location: escolha_restaurante.php?bai=".$bairro);
		}
		else{
			echo "<script>alert('Dados inválidos');</script>";
		}
		
		mysql_close();
	}
}

connect();

$bairros = "";
$count = 0;
$sql="SELECT * FROM bairro WHERE cidade_id = '$cidade' ORDER BY nome";
$sql=mysql_query($sql);
while($c=mysql_fetch_array($sql)){
	$bairro[$count]['nome']=$c['nome'];
	$bairro[$count]['id']=$c['id'];
	
	$bairros .= "<option value='".$c['id']."'>".$c['nome']."</option>";
	
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
            	EM QUE BAIRRO VOCE ESTA?<br/><br/>
            	<form action="" method="post">
                	<select id="bairro" name="bairro"><?php echo $bairros; ?></select>
                    <input type="submit" id="ir" name="ir" value="Selecionar este bairro" />
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