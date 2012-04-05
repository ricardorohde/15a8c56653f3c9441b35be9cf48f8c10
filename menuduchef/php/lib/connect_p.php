<?php
///////////////////////////////////////////////////////////////////FUNCOES GERAIS
function connect(){
	$host = "mysql.gleycetour.com.br";
	$database = "restaurante_biro";
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
?>