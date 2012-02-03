<?php 
        function connect(){
	$host = "mysql.gleycetour.com.br";
	$database = "biro_restaurante";
	$login = "biroadmin";
	$pswd = "oribdesign";
	$r = FALSE;
	if ($con = mysql_connect($host,$login,$pswd))
	{
		if ($sel = mysql_select_db($database,$con))
		{
			$r = $con;
		}
	}
	return $r;
}

function upload($arquivo,$caminho,$name){
	$arquivo_tratado = '';
	if(!(empty($arquivo))){
		$arquivo1 = $arquivo;
	
		$arquivo_tratado = $name;
		$destino = "../".$caminho."/".$arquivo_tratado;
		
		if(move_uploaded_file($arquivo1['tmp_name'],$destino)){

		}else{

		}
		
		
		
	}
	return $arquivo_tratado;
}
?>